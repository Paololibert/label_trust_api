<?php

declare(strict_types = 1);

namespace App\Http\Requests\Finances\v1\Journaux;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Finances\Journaux\DataTransfertObjects\UpdateJournalDTO;

/**
 * Class **`UpdateJournalRequest`**
 *
 * Represents a form request for creating a departement. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Journaux\v1`**
 */
class UpdateJournalRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateJournalDTO::fromRequest(request()), 'journal');
    }

    /**
     * Determine if the user is authorized to make this request.
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
