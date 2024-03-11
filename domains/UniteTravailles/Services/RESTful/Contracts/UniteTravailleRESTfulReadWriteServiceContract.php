<?php

declare(strict_types=1);

namespace Domains\UniteTravailles\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use Core\Utils\DataTransfertObjects\DTOInterface;

/**
 * Interface ***`UniteTravailleRESTfulReadWriteServiceContract`***
 *
 * The `UniteTravailleRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the UniteTravailles module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on UniteTravaille resources via RESTful API endpoints.
 *
 * @package ***`\Domains\UniteTravailles\Services\RESTful\Contracts`***
 */
interface UniteTravailleRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
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
    public function addTaux(string $uniteTravailleId, DTOInterface $uniteTauxArray): \Illuminate\Http\JsonResponse;

    /**
     * Edit taux for unite travailles.
     *
     * @param string          $uniteTravailleId          The identifier of the unite travaille for which taux will be edited.
     * @param DTOInterface    $uniteTauxArray            The data transfer object containing edited taux information.
     *
     * @return \Illuminate\Http\JsonResponse             The JSON response indicating the status of the taux edit operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException   If there is an issue with the service operation.
     */
    public function editTaux(string $uniteTravailleId, DTOInterface $uniteTauxArray): \Illuminate\Http\JsonResponse;

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
    public function removeTaux(string $uniteTravailleId, DTOInterface $uniteTauxIds): \Illuminate\Http\JsonResponse;
}