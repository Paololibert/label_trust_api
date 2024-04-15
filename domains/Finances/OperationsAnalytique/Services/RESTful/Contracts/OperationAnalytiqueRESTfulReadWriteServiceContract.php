<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsAnalytique\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`OperationAnalytiqueRESTfulReadWriteServiceContract`***
 *
 * The `OperationAnalytiqueRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the OperationsAnalytique module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on OperationAnalytique resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Finances\OperationsAnalytique\Services\RESTful\Contracts`***
 */
interface OperationAnalytiqueRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    public function validateOperationAnalytique(string $operationAnalytiqueId, \Core\Utils\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse;
}
