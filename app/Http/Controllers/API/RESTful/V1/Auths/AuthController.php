<?php

namespace App\Http\Controllers\API\RESTful\V1\Auths;

use App\Http\Controllers\Controller;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user login and issue access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request): \Illuminate\Http\JsonResponse
    {
        try {

            return JsonResponseTrait::success(
                data: $request->user()->user,
                status_code: Response::HTTP_OK
            );

        } catch (\Throwable $th) {

            return JsonResponseTrait::error(
                message: $th->getMessage(),
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );

            return $this->errorResponse(message: $th->getMessage());
        }
    }

    /**
     * Handle user logout and revoke the access token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        Auth::user()->token()->revoke();

        return JsonResponseTrait::success(
            data: null,
            message: 'User logged out successfully.',
            status_code: Response::HTTP_OK
        );
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                "data" => null,
                'message' => 'Logged out successfully',
            ], 200);
        }
    }
}
