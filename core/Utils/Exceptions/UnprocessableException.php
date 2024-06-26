<?php

declare(strict_types=1);

namespace Core\Utils\Exceptions;

use Core\Utils\Enums\Common\ErrorCodeEnum;
use Illuminate\Http\Response;

/**
 * Class ***`UnprocessableException`***
 * 
 * This exception represents a "Not Found" error (HTTP status code 404).
 * It is used to indicate that the requested resource is not found.
 * 
 * @package ***`\Core\Utils\Exceptions`***
 */
class UnprocessableException extends \Core\Utils\Exceptions\Contract\CoreException
{
    /**
     * UnprocessableException constructor.
     * 
     * @param string     $message      The specific reason for the "Not Found" error.
     *                                 If not provided, a default message "The requested resource was not found." will be used.
     * 
     * @param int        $error_code   The error code associated with the exception (optional).
     *                                 If not provided, it defaults to the value of the 'code' parameter.
     * 
     * @param int        $status_code  The HTTP status code associated with the exception (optional).
     *                                 It represents the status code for API responses or HTTP error handling.
     *                                 If not provided, it defaults to HTTP status code 404 (Not Found).
     * @param array|null $error        Additional error information or data related to the exception (optional).
     * @param int        $code         The Exception code. (optional)
     *                                 If not provided, it defaults to 0.
     * @param \Throwable $previous     The previous throwable used for the exception chaining. (optional)
     */
    public function __construct(
        string $message = 'Validation error.',
        int $error_code = ErrorCodeEnum::VALIDATION_ERROR,
        int $status_code =  Response::HTTP_UNPROCESSABLE_ENTITY,
        $error = [],
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $error_code, $status_code, $error, $code, $previous);
    }
}
