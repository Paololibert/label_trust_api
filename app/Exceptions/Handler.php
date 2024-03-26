<?php

namespace App\Exceptions;

use Core\Utils\Exceptions\ApplicationException;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\HttpMethodNotAllowedException;
use Core\Utils\Exceptions\ServiceException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
        if ($exception instanceof MethodNotAllowedHttpException) {
            throw new HttpMethodNotAllowedException();
        }
    
        return parent::render($request, $exception);
    }
}
