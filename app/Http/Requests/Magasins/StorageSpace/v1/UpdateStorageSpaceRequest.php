<?php

declare(strict_types = 1);

namespace App\Http\Requests\Magasins\StorageSpace\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Magasins\StorageSpace\DataTransfertObjects\UpdateStorageSpaceDTO;

/**
 * Class **`UpdateStorageSpaceRequest`**
 *
 * Represents a form request for creating a StorageSpace. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Magasins\StorageSpace\v1`**
 */
class UpdateStorageSpaceRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateStorageSpaceDTO::fromRequest(request()), 'storage_space');
    }

    /**
     * Determine if the Magasin is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }
    
    public function authorize(): bool
    {
        return parent::authorize();
    }

}
