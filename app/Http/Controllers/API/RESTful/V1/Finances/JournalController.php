<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\Journaux\CreateJournalRequest;
use App\Http\Requests\Finances\v1\Journaux\UpdateJournalRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\Journaux\Services\RESTful\Contracts\JournalRESTfulQueryServiceContract;
use Domains\Finances\Journaux\Services\RESTful\Contracts\JournalRESTfulReadWriteServiceContract;

/**
 * **`JournalController`**
 *
 * Controller for managing classe resources. This controller extends the RESTfulController
 * and provides CRUD operations for classe resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class JournalController extends RESTfulResourceController
{
    /**
     * Create a new JournalController instance.
     *
     * @param \Domains\Journaux\Services\RESTful\Contracts\JournalRESTfulQueryServiceContract $compteDeJournalRESTfulQueryService
     *        The Journal RESTful Query Service instance.
     */
    public function __construct(JournalRESTfulReadWriteServiceContract $compteDeJournalRESTfulReadWriteService, JournalRESTfulQueryServiceContract $compteDeJournalRESTfulQueryService)
    {
        parent::__construct($compteDeJournalRESTfulReadWriteService, $compteDeJournalRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateJournalRequest::class);
        $this->setRequestClass('update', UpdateJournalRequest::class);
    }
}
