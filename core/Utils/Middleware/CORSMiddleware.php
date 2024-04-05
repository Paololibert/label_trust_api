<?php

declare(strict_types=1);

namespace Core\Utils\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Core\Utils\Exceptions\AuthorizationException;

/**
 * Class `CORSMiddleware`
 *
 * This middleware class handles Cross-Origin Resource Sharing (`CORS`) for incoming requests.
 * CORS allows restricted resources on a web page to be requested from another domain outside the domain from which the resource originated.
 * It allows or restricts `cross-origin` requests based on the configuration.
 *
 * @package ***`\Core\Utils\Middleware`***
 */
class CORSMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\JsonResponse)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {

        // Perform header value validation
        $allowedOrigins = ['http://localhost', 'http://localhost:8000', 'http://localhost:8080', 'http://127.0.0.1', 'http://127.0.0.1:8000', 'http://127.0.0.1:8080', 'https://pms.labelstrust.com/'];

        // Check if the request origin is in the list of allowed origins
        $origin = $request->header('Origin');

        if (in_array($origin, $allowedOrigins)) {
            // Add headers to allow cross-origin requests from the allowed origin
            $headers = [
                'Access-Control-Allow-Origin' => $origin,
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
                'Access-Control-Allow-Credentials' => 'true',
            ];

            // Check if the request is an OPTIONS request (preflight request)
            if ($request->isMethod('OPTIONS')) {
                return response()->json('OK', 200, $headers);
            }

            // Add CORS headers to the response
            $response = $next($request);
            foreach ($headers as $key => $value) {
                $response->header($key, $value);
            }

            return $response;
        }

        throw new AuthorizationException(message: "Request origin not allowed.");
    }
}
