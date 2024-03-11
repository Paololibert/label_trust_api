<?php

declare(strict_types=1);

namespace Domains\UniteTravailles\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\UniteTravailles\Services\RESTful\Contracts\UniteTravailleRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`UniteTravailleRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "UniteTravaille" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "UniteTravaille" resource.
 * It implements the `UniteTravailleRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\UniteTravailles\Services\RESTful`***
 */
class UniteTravailleRESTfulReadWriteService extends RestJsonReadWriteService implements UniteTravailleRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the UniteTravailleRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

    /**
     * Add taux to unite travailles.
     *
     * @param string          $uniteTravailleId                     The identifier of the unite travaille to which taux will be added.
     * @param DTOInterface    $uniteTauxArray                       The data transfer object containing taux information.
     *
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the taux addition operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException              If there is an issue with the service operation.
     */
    public function addTaux(string $uniteTravailleId, DTOInterface $uniteTauxArray): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            // Call the create method on the repository to add taux to the unite travaille
            $result = $this->queryService->getRepository()->createTaux($uniteTravailleId, $uniteTauxArray->toArray()['taux']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to add taux to unite travaille. Taux not added.", 1);
            }

            // Commit the transaction since taux were added successfully
            DB::commit();

            // Return a success response
            return JsonResponseTrait::success(
                message: 'Taux added to unite travaille successfully',
                data: $result,
                status_code: Response::HTTP_CREATED
            );

        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to add taux to unite travaille: ' . $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Edit taux for unite travailles.
     *
     * @param string          $uniteTravailleId         The identifier of the unite travaille for which taux will be edited.
     * @param DTOInterface    $uniteTauxArray           The data transfer object containing edited taux information.
     *
     * @return \Illuminate\Http\JsonResponse            The JSON response indicating the status of the taux edit operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException  If there is an issue with the service operation.
     */
    public function editTaux(string $uniteTravailleId, DTOInterface $uniteTauxArray): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Call the editTaux method on the repository to edit taux for the unite travaille
            $result = $this->queryService->getRepository()->editTaux($uniteTravailleId, $uniteTauxArray->toArray()['taux']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to edit taux for unite travaille. Taux not edited.", 1);
            }

            // Commit the transaction since taux were edited successfully
            DB::commit();

            // Return a success response
            return JsonResponseTrait::success(
                message: 'Taux for unite travaille edited successfully',
                data: $result,
                status_code: Response::HTTP_OK
            );

        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to edit taux for unite travaille: ' . $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Remove taux from unite travailles.
     *
     * @param  string                           $uniteTravailleId   The identifier of the unite travaille from which taux will be removed.
     * @param  DTOInterface                     $uniteTauxIds       The data transfer object containing taux identifiers to be removed.
     *
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the taux removal operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException              If there is an issue with the service operation.
     */
    public function removeTaux(string $uniteTravailleId, DTOInterface $uniteTauxIds): \Illuminate\Http\JsonResponse
    {

        // Begin the transaction
        DB::beginTransaction();

        try {
            
            // Call the removeTaux method on the repository to remove taux from the unite travaille
            $result = $this->queryService->getRepository()->removeTaux($uniteTravailleId, $uniteTauxIds->toArray()['taux']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to remove taux from unite travaille. Taux not removed.", 1);
            }

            // Commit the transaction since taux were removed successfully
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Taux removed from unite travaille successfully',
                data: $result,
                status_code: Response::HTTP_OK
            );

        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: 'Failed to remove taux from unite travaille: ' . $exception->getMessage(), previous: $exception);
        }
    }

}