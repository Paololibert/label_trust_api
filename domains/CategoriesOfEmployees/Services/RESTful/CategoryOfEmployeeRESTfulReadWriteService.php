<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\CategoriesOfEmployees\Services\RESTful\Contracts\CategoryOfEmployeeRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`CategoryOfEmployeeRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "CategoryOfEmployee" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "CategoryOfEmployee" resource.
 * It implements the `CategoryOfEmployeeRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\CategoryOfEmployees\Services\RESTful`***
 */
class CategoryOfEmployeeRESTfulReadWriteService extends RestJsonReadWriteService implements CategoryOfEmployeeRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the PosteRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

    /**
     * Attach taux to a CategoryOfEmployee.
     *
     * This method associates specific taux with a given CategoryOfEmployee. The specified taux will be attached
     * to the CategoryOfEmployee identified by `$categoryEmployeeId`. The response is returned as a JSON format,
     * indicating the status of the taux attachment operation.
     *
     * @param   string                                          $categoryEmployeeId         The unique identifier of the CategoryOfEmployee to associate taux with.
     * @param   \Core\Utils\DataTransfertObjects\DTOInterface   $tauxIds                    The array of access identifiers representing the taux to be attached.
     * 
     * @return  \Illuminate\Http\JsonResponse                                               The JSON response indicating the status of the taux attachment operation.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException                                     Throws an exception if there is an issue with the service operation.
     */
    public function attachTauxToACategoryOfEmployee(string $categoryEmployeeId, \Core\Utils\DataTransfertObjects\DTOInterface $tauxIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            // Call the create method on the repository to add taux to the unite travaille
            $result = $this->queryService->getRepository()->attachTaux($categoryEmployeeId, $tauxIds->toArray()['taux']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to add taux to unite travaille. Taux not added.", 1);
            }

            // Commit the transaction since taux were added successfully
            DB::commit();

            // Return a success response
            return JsonResponseTrait::success(
                message: 'Taux attached to category of employee successfully',
                data: $result,
                status_code: Response::HTTP_CREATED
            );

        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to attach taux to category of employee: ' . $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Detach taux from a CategoryOfEmployee.
     *
     * This method disassociates specific taux from a given CategoryOfEmployee. The specified taux will be detached
     * from the CategoryOfEmployee identified by `$categoryEmployeeId`. The response is returned as a JSON format,
     * indicating the status of the taux detachment operation.
     *
     * @param   string                                          $categoryEmployeeId         The unique identifier of the CategoryOfEmployee to disassociate taux from.
     * @param   \Core\Utils\DataTransfertObjects\DTOInterface   $tauxIds                    The array of access identifiers representing the taux to be detached.
     * 
     * @return  \Illuminate\Http\JsonResponse                                               The JSON response indicating the status of the taux detachment operation.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException                                     Throws an exception if there is an issue with the service operation.
     */
    public function detachTauxFromACategoryOfEmployee(string $categoryEmployeeId, \Core\Utils\DataTransfertObjects\DTOInterface $tauxIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            
            // Call the detachTaux method on the repository to detach taux from the category of employee
            $result = $this->queryService->getRepository()->detachTaux($categoryEmployeeId, $tauxIds->toArray()['taux']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to detach taux to category of employee. The taux were not detach.", 1);
            }

            // Commit the transaction since taux were detached successfully
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Taux detached to category of employee successfully',
                data: $result,
                status_code: Response::HTTP_OK
            );

        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: 'Failed to detache taux from category of employee: ' . $exception->getMessage(), previous: $exception);
        }

    }
}