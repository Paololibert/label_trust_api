<?php

namespace App\Http\Controllers\API\RESTful\V1\Auths;

use App\Http\Controllers\Controller;
use App\Models\Credential;
use App\Models\Oauths\OauthClient;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Core\Utils\Traits\TooManyFailedAttemptsTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    use TooManyFailedAttemptsTrait;

    /**
     * Handle user login and issue access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->checkTooManyFailedAttempts();

        $request->validate([
            'identifier' => 'required|exists:credentials,identifier',
            'password' => 'required',
        ]);

        $credential = $this->getCredential($request);

        if (!$this->isCredentialValid($credential, $request)) {
            return $this->handleInvalidCredential();
        }

        return $this->authenticateAndIssueToken($request, $credential);
    }

    /**
     * Get the credential based on the provided identifier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Credential|null
     */
    private function getCredential(Request $request): ?Credential
    {
        return Credential::where('identifier', $request->input('identifier'))->first();
    }

    /**
     * Check if the provided credential and password are valid.
     *
     * @param  \App\Models\Credential|null  $credential
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function isCredentialValid(?Credential $credential, Request $request): bool
    {
        return $credential && Hash::check($request->input('password'), $credential->password);
    }

    /**
     * Handle the case where the credential or password is invalid.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleInvalidCredential(): \Illuminate\Http\JsonResponse
    {
        RateLimiter::hit($this->throttleKey(), $seconds = 60);

        return JsonResponseTrait::error(
            message: "Identifiant ou mot de passe incorrect",
            status_code: Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * Authenticate the user and issue the access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Credential  $credential
     * @return \Illuminate\Http\JsonResponse
     */
    private function authenticateAndIssueToken(Request $request, Credential $credential): \Illuminate\Http\JsonResponse
    {
        if (!Auth::attempt(['identifier' => $request->input('identifier'), 'password' => $request->input('password')])) {
            RateLimiter::hit($this->throttleKey(), $seconds = 60);

            return JsonResponseTrait::error(
                message: "Échec d'authentification. Veuillez réessayer plus tard",
                status_code: Response::HTTP_UNAUTHORIZED
            );
        }

        $oauthClient = OauthClient::where('user_id', $credential->id)->first();

        $authenticate = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => $oauthClient ? $oauthClient->id : config('passport.grant_access_client.id'),
            'client_secret' => $oauthClient ? $oauthClient->secret : config('passport.grant_access_client.secret'),
            'username' => $request->input('identifier'),
            'password' => $request->input('password'),
            'scope' => '*',
        ]);

        $response = app()->handle($authenticate)->getContent();

        return JsonResponseTrait::success(
            data: json_decode($response),
            status_code: Response::HTTP_OK
        );
    }

    
}