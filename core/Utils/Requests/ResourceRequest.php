<?php

namespace Core\Utils\Requests;

use Core\Utils\Requests\Contracts\ResourceRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class **`ResourceRequest`**
 *
 * This abstract class serves as the foundation for custom request classes in Laravel.
 * It extends the FormRequest class and implements the ResourceRequestInterface.
 * Concrete classes extending ResourceRequest must provide their implementation
 * for isAuthorize and process methods.
 *
 * @package **`Core\Utils\Requests`**
 */
abstract class ResourceRequest extends FormRequest implements ResourceRequestInterface
{
    /**
     * The data transfer object (DTO) associated with this class.
     *
     * @var \Core\Utils\DataTransfertObjects\DTOInterface
     */
    protected $dto;

    /**
     * ResourceRequest constructor.
     *
     * @param \Core\Utils\DataTransfertObjects\DTOInterface $dto The Data Transfer Object (DTO) instance to associate with this request.
     */
    public function __construct(\Core\Utils\DataTransfertObjects\DTOInterface $dto)
    {
        $this->dto = $dto;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * Concrete classes must implement this method to provide their specific authorization logic.
     *
     * @return bool Whether the user is authorized.
     */
    abstract protected function isAuthorize(): bool;

    /**
     * Authorize the user to perform the resource creation operation.
     *
     * This method is called during the authorization phase of the request lifecycle.
     * It sets the Data Transfer Object (DTO) associated with this request
     * and then checks if the user is authorized based on the implemented authorization logic
     * in the concrete class.
     *
     * @return bool Whether the user is authorized.
     */
    abstract public function authorize(): bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * Uses the DTO's rules() method to define the validation rules.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->dto->rules();
    }

    /**
     * Get the validation error messages.
     *
     * Uses the DTO's messages() method to define the validation error messages.
     *
     * @return array<string, string|array>
     */
    public function messages()
    {
        return $this->dto->messages();
    }

    /**
     * Get the data transfer object (DTO) associated with this class.
     *
     * @return \Core\Utils\DataTransfertObjects\DTOInterface|null The data transfer object (DTO) instance, or null if not set.
     */
    public function getDto(): ?\Core\Utils\DataTransfertObjects\DTOInterface
    {
        return $this->dto;
    }

    /**
     * Set the Data Transfer Object (DTO) associated with this request.
     *
     * @param \Core\Utils\DataTransfertObjects\DTOInterface $dto The Data Transfer Object (DTO) instance to set.
     */
    public function setDto(\Core\Utils\DataTransfertObjects\DTOInterface $dto): void
    {
        $this->dto = $dto;
    }

    /**
     * Validate the request data and return the validated data.
     *
     * @return array The validated data.
     */
    public function validate(): array
    {
        return $this->validated();
    }

    /**
     * Process the request data and return the data transfer object (DTO) for the resource operation.
     *
     * @return \Core\Utils\DataTransfertObjects\DTOInterface The data transfer object (DTO) for the resource operation.
     */
    public function process(): \Core\Utils\DataTransfertObjects\DTOInterface
    {
        return $this->dto->fromRequest(Request());
    }

    /**
     * Get additional validation rules for the resource operation.
     *
     * @return array Additional validation rules.
     */
    public function additionalRules(): array
    {
        return [];
    }

    /**
     * Get additional validation messages for the resource operation.
     *
     * @return array Additional validation messages.
     */
    public function additionalMessages(): array
    {
        return [];
    }
}
