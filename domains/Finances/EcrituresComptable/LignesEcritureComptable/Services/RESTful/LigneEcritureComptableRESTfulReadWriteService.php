<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\LignesEcritureComptable\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\EcrituresComptable\LignesEcritureComptable\Services\RESTful\Contracts\LigneEcritureComptableRESTfulReadWriteServiceContract;

/**
 * The ***`LigneEcritureComptableRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "LigneEcritureComptable" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "LigneEcritureComptable" resource.
 * It implements the `LigneEcritureComptableRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\LignesEcritureComptable\Services\RESTful`***
 */
class LigneEcritureComptableRESTfulReadWriteService extends RestJsonReadWriteService implements LigneEcritureComptableRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the LigneEcritureComptableRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}