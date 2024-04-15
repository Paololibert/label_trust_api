<?php

declare(strict_types=1);

namespace Domains\Finances\ProjetsProduction\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\ProjetsProduction\Services\RESTful\Contracts\ProjetProductionRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`ProjetProductionRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "ProjetProduction" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "ProjetProduction" resource.
 * It implements the `ProjetProductionRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\ProjetsProduction\Services\RESTful`***
 */
class ProjetProductionRESTfulReadWriteService extends RestJsonReadWriteService implements ProjetProductionRESTfulReadWriteServiceContract
{    
    /**
     * Constructor for the ProjetProductionRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }
}