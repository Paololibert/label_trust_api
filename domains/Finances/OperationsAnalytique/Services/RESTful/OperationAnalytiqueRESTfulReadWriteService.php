<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsAnalytique\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\OperationsAnalytique\Services\RESTful\Contracts\OperationAnalytiqueRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`OperationAnalytiqueRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "OperationAnalytique" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "OperationAnalytique" resource.
 * It implements the `OperationAnalytiqueRESTfulReadWriteService` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\OperationsAnalytique\Services\RESTful`***
 */
class OperationAnalytiqueRESTfulReadWriteService extends RestJsonReadWriteService implements OperationAnalytiqueRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the OperationsAnalytiqueRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

    public function validateOperationAnalytique(string $operationAnalytiqueId, \Core\Utils\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse{

        // Begin the transaction
        DB::beginTransaction();

        try {
            // Logic to validate the specified Plan Analytique
            $operation = $this->readWriteService->getRepository()->validateOperationAnalytique(operationAnalytiqueId: $operationAnalytiqueId, data: $data->toArray());

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Operation valider et convertir en ecriture compture.',
                data: $operation,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Begin the transaction
            DB::rollback();
    
            // Throw a ServiceException if there is an issue with validating a plan comptable
            throw new ServiceException(message: "Failed to import: " . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}