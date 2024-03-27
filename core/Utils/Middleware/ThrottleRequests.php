<?php

declare(strict_types=1);

namespace Core\Utils\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequests
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, $maxAttempts = 10, $decaySeconds = 60)
    {
        // Apply rate limiting per user based on IP address
        $ipKey = $request->ip();
        $routeKey = $request->path();

        if ($this->limiter->tooManyAttempts($ipKey, $maxAttempts)) {
            return response()->json(['message' => 'Too many requests. Please try again later.'], Response::HTTP_TOO_MANY_REQUESTS);
        }

        $this->limiter->hit($ipKey, $decaySeconds);

        // Apply route-specific rate limiting
        if ($this->limiter->tooManyAttempts($routeKey, 3)) {
            return response()->json(['message' => 'Too many requests for this route. Please try again later.'], Response::HTTP_TOO_MANY_REQUESTS);
        }

        $this->limiter->hit($routeKey, 60);

        // Set a timeout duration for HTTP requests
        $request->timeout = 800; // 0.8 seconds in milliseconds

        return $next($request);
    }
}
