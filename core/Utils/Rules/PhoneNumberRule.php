<?php

declare(strict_types = 1);

namespace Core\Utils\Rules;

use Core\Data\Eloquent\ValueObjects\PhoneNumber;
use Core\Utils\Exceptions\InvalidArgumentException;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Enums\Common\ErrorCodeEnum;

/**
 * Class `PhoneNumberRule`
 *
 * The PhoneNumberRule rule checks if a given value exists for the authenticated user and is a valid UUID.
 *
 * @package \Core\Utils\Rules
 */
class PhoneNumberRule implements Rule
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @var string
     */
    protected ?string $ignore_value;

    /**
     * @var string
     */
    protected string $attribute;

    /**
     * @var string
     */
    protected string $column;

    /**
     * @var CoreException|null
     */
    protected ?CoreException $exception;

    public function __construct(string $table = 'users', string $column = 'phone_number', ?string $ignore_value = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->exception = null;
        $this->ignore_value = $ignore_value;
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute The attribute being validated.
     * @param  mixed   $value     The value being validated.
     * @return bool               True if the validation passes, false otherwise.
     */
    public function passes($attribute, $value)
    {
        try {
            $phone_number = null;
            if(is_string($value))
            {
                $phone_number = PhoneNumber::fromString($value);
            }
            elseif(is_array($value))
            {
                $phone_number = new PhoneNumber($value);
            }
            elseif (! $value instanceof PhoneNumber) {
                throw new InvalidArgumentException('Phone number should be in json format');
            }
            
            if ($this->ignore_value != null) {
                if (DB::table('users') ->where($this->column, $phone_number->toJson())->where('id','!=',$this->ignore_value)->exists()) {
                    $this->exception = new CoreException(message: "The phone number you entered already exists in our records.", error_code: ErrorCodeEnum::VALIDATION_ERROR, status_code: Response::HTTP_UNPROCESSABLE_ENTITY);
                    return false;
                }
            }
            if (DB::table('users') ->where($this->column, $phone_number->toJson())->exists()) {
                $this->exception = new CoreException(message: "The phone number you entered already exists in our records.", error_code: ErrorCodeEnum::VALIDATION_ERROR, status_code: Response::HTTP_UNPROCESSABLE_ENTITY);
                return false;
            }
            return true;
        } catch (CoreException $prev) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string The validation error message.
     */
    public function message()
    {
        return $this->exception?->getMessage() ?? 'The :attribute must be a valid phone number.';
    }
}
