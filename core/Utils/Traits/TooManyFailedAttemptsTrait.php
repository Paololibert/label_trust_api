<?php

declare(strict_types=1);

namespace Core\Utils\Traits;

use Exception;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

trait TooManyFailedAttemptsTrait
{
    /** * Get the maximum number of attempts to allow. * * @return int */ 
    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 3;
    }

    /** * Get the number of minutes to throttle for. * * @return int */ 
    public function decayMinutes()
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        if(request()->user()){
            return request()->user()->credential->identifier . '-' . request()->ip();
        }
        return Str::lower(request('identifier')) . '-' . request()->ip();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     */
    public function checkTooManyFailedAttempts($maxAttempts = 3)
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), $maxAttempts) /* || RateLimiter::attempts($this->throttleKey()) <= $maxAttempts */) {
            return;
        }

        throw new Exception('Trop de tentative de connexion. Veuillez réessayer dans 1 minute.');
    }
}
