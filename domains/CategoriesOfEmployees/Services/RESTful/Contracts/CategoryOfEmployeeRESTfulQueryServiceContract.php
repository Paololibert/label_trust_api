<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`CategoryOfEmployeeRESTfulQueryServiceContract`***
 *
 * The `CategoryOfEmployeeRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to CategoryOfEmployee resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to CategoryOfEmployee resources.
 *
 * @package ***`\Domains\CategoriesOfEmployees\Services\RESTful\Contracts`***
 */
interface CategoryOfEmployeeRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{
    /**
     * Retrieve taux associated with a specific CategoryOfEmployee.
     *
     * This method queries the system to fetch the taux linked to a particular CategoryOfEmployee. The response
     * is returned as a JSON format, providing details about the taux granted to the specified CategoryOfEmployee.
     *
     * @param   string                                  $categoryEmployeeId The unique identifier of the CategoryOfEmployee to query taux for.
     * 
     * @return  \Illuminate\Http\JsonResponse                               The JSON response containing information about the taux associated with the CategoryOfEmployee.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException                     Throws an exception if there is an issue with the service operation.
     */
    public function fetchCategoryOfEmployeeTaux(string $categoryEmployeeId): \Illuminate\Http\JsonResponse;
}