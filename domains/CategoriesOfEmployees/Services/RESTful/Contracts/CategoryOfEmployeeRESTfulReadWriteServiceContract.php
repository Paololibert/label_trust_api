<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`CategoryOfEmployeeRESTfulReadWriteServiceContract`***
 *
 * The `CategoryOfEmployeeRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the CategoriesOfEmployees module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on CategoryOfEmployeee resources via RESTful API endpoints.
 *
 * @package ***`\Domains\CategoriesOfEmployees\Services\RESTful\Contracts`***
 */
interface CategoryOfEmployeeRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
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
    public function attachTauxToACategoryOfEmployee(string $categoryEmployeeId, \Core\Utils\DataTransfertObjects\DTOInterface $tauxIds): \Illuminate\Http\JsonResponse;

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
    public function detachTauxFromACategoryOfEmployee(string $categoryEmployeeId, \Core\Utils\DataTransfertObjects\DTOInterface $tauxIds): \Illuminate\Http\JsonResponse;

}