<?php

declare(strict_types=1);

namespace Domains\Postes\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`PosteRESTfulReadWriteServiceContract`***
 *
 * The `PosteRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the Postes module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on Poste resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Postes\Services\RESTful\Contracts`***
 */
interface PosteRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    /**
     * Attach salaries to a poste.
     *
     * This method associates specific salaries with a given poste. The specified salaries will be attached
     * to the poste identified by `$posteId`. The response is returned as a JSON format,
     * indicating the status of the salaries attachment operation.
     *
     * @param   string                                          $posteId         The unique identifier of the poste to associate salaries with.
     * @param   \Core\Utils\DataTransfertObjects\DTOInterface   $salariesIds     The array of access identifiers representing the salaries to be attached.
     * 
     * @return  \Illuminate\Http\JsonResponse                                    The JSON response indicating the status of the salaries attachment operation.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException                          Throws an exception if there is an issue with the service operation.
     */
    public function attachSalariesToAPoste(string $posteId, \Core\Utils\DataTransfertObjects\DTOInterface $salariesIds): \Illuminate\Http\JsonResponse;

    /**
     * Detach salaries from a poste.
     *
     * This method disassociates specific salaries from a given poste. The specified salaries will be detached
     * from the poste identified by `$posteId`. The response is returned as a JSON format,
     * indicating the status of the salaries detachment operation.
     *
     * @param   string                                          $posteId         The unique identifier of the poste to disassociate salaries from.
     * @param   \Core\Utils\DataTransfertObjects\DTOInterface   $salariesIds     The array of access identifiers representing the salaries to be detached.
     * 
     * @return  \Illuminate\Http\JsonResponse                                    The JSON response indicating the status of the salaries detachment operation.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException                          Throws an exception if there is an issue with the service operation.
     */
    public function detachSalariesFromAPoste(string $posteId, \Core\Utils\DataTransfertObjects\DTOInterface $salariesIds): \Illuminate\Http\JsonResponse;

}