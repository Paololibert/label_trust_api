<?php

declare(strict_types=1);

namespace Domains\Postes\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Postes\Services\RESTful\Contracts\PosteRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`PosteRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Poste" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Poste" resource.
 * It implements the `PosteRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Postes\Services\RESTful`***
 */
class PosteRESTfulReadWriteService extends RestJsonReadWriteService implements PosteRESTfulReadWriteServiceContract
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
     * Attach salaries to a Poste.
     *
     * This method associates specific salaries with a given Poste. The specified salaries will be attached
     * to the Poste identified by `$posteId`. The response is returned as a JSON format,
     * indicating the status of the salaries attachment operation.
     *
     * @param   string                                          $posteId         The unique identifier of the Poste to associate salaries with.
     * @param   \Core\Utils\DataTransfertObjects\DTOInterface   $salariesIds     The array of access identifiers representing the salaries to be attached.
     * 
     * @return  \Illuminate\Http\JsonResponse                                    The JSON response indicating the status of the salaries attachment operation.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException                          Throws an exception if there is an issue with the service operation.
     */
    public function attachSalariesToAPoste(string $posteId, \Core\Utils\DataTransfertObjects\DTOInterface $salariesIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            // Call the create method on the repository to add salaries to the poste
            $result = $this->queryService->getRepository()->attachSalaries($posteId, $salariesIds->toArray()['salaries']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to add salaries to poste. Salaries not added.", 1);
            }

            // Commit the transaction since salaries were added successfully
            DB::commit();

            // Return a success response
            return JsonResponseTrait::success(
                message: 'Salaries attached to poste successfully',
                data: $result,
                status_code: Response::HTTP_CREATED
            );

        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to attach salaries to poste: ' . $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Detach salaries from a Poste.
     *
     * This method disassociates specific salaries from a given Poste. The specified salaries will be detached
     * from the Poste identified by `$posteId`. The response is returned as a JSON format,
     * indicating the status of the salaries detachment operation.
     *
     * @param   string                                          $posteId         The unique identifier of the Poste to disassociate salaries from.
     * @param   \Core\Utils\DataTransfertObjects\DTOInterface   $salariesIds                    The array of access identifiers representing the salaries to be detached.
     * 
     * @return  \Illuminate\Http\JsonResponse                                               The JSON response indicating the status of the salaries detachment operation.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException                                     Throws an exception if there is an issue with the service operation.
     */
    public function detachSalariesFromAPoste(string $posteId, \Core\Utils\DataTransfertObjects\DTOInterface $salariesIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            
            // Call the detachSalaries method on the repository to detach salaries from the poste
            $result = $this->queryService->getRepository()->detachSalaries($posteId, $salariesIds->toArray()['salaries']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to detach salaries to poste. The salaries were not detach.", 1);
            }

            // Commit the transaction since salaries were detached successfully
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Salaries detached to poste successfully',
                data: $result,
                status_code: Response::HTTP_OK
            );

        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: 'Failed to detache salaries from poste: ' . $exception->getMessage(), previous: $exception);
        }

    }
}