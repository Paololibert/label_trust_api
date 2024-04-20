<?php

namespace App\Exceptions;

use Core\Utils\Exceptions\ApplicationException;
use Core\Utils\Exceptions\AuthException;
use Core\Utils\Exceptions\AuthorizationException as CoreAuthorizationException;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\HttpMethodNotAllowedException;
use Core\Utils\Exceptions\NotFoundException;
use Core\Utils\Exceptions\TooManyAttemptsException;
use Core\Utils\Exceptions\UnprocessableException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        dd($exception);
        if ($exception instanceof MethodNotAllowedHttpException) {
            throw new HttpMethodNotAllowedException();
        }
        else if ($exception instanceof AuthenticationException) {
            throw new AuthException(previous: $exception);
        }
        else if ($exception instanceof AuthorizationException) {
            throw new CoreAuthorizationException(previous: $exception);
        }
        else if($exception instanceof NotFoundHttpException){
            throw new NotFoundException(message: "Route not be found", previous: $exception);            
        }
        else if($exception instanceof ValidationException){
            throw new UnprocessableException(message: $exception->getMessage(), status_code: $exception->status, error: $exception->errors(), previous: $exception); 
        }
        else if($exception instanceof ThrottleRequestsException){
            throw new TooManyAttemptsException(previous: $exception);            
        }
        else if($exception instanceof \Symfony\Component\ErrorHandler\Error\FatalError){
            throw new ApplicationException(message: 'An unexpected error occurred.'. $exception->getMessage(), previous: $exception);   
        }
        else if(!$exception instanceof CoreException){
            throw new ApplicationException(message: $exception->getMessage(), previous: $exception);   
        }
    
        return parent::render($request, $exception);
    }
}
