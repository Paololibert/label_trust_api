<?php

declare(strict_types = 1);

namespace Core\Utils\Controllers\RESTful;

use App\Http\Controllers\Controller;
use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;
use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use Core\Utils\Controllers\RESTful\Contracts\RESTfulResourceControllerContract;
use Core\Utils\Requests\ResourceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * **`RESTfulResourceController`**
 *
 * This controller provides a RESTful interface for managing resources.
 * It extends the base Controller class and encapsulates common CRUD operations.
 * The controller delegates the actual implementation of the operations to a service contract.
 *
 * @property \Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract restJsonReadWriteService The RESTful service contract responsible for handling CRUD operations.
 *
 * @method void __construct(Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract $restJsonReadWriteService)              The constructor of the controller class creates a new instance of the controller and initializes the `$restJsonReadWriteService` property. It expects an implementation of the `RestJsonReadWriteServiceContract`, which is a contract defining the methods for performing CRUD operations on resources. This service will be used throughout the controller methods to interact with the underlying data storage.
 * @method \Illuminate\Http\JsonResponse index()                                Display a listing of the resource.
 * @method \Illuminate\Http\JsonResponse store(Request $request)                Store a newly created resource in storage.
 * @method \Illuminate\Http\JsonResponse show(string $id)                       Display the specified resource.
 * @method \Illuminate\Http\JsonResponse update(Request $request, string $id)   Update the specified resource in storage.
 * @method \Illuminate\Http\JsonResponse softDelete(string $id)                 Soft delete the specified resource.
 * @method \Illuminate\Http\JsonResponse permanentDelete(string $id)            Permanently delete the specified resource.
 * @method \Illuminate\Http\JsonResponse loadTrash()                            Load the trash and display the soft deleted resources.
 * @method \Illuminate\Http\JsonResponse restoreFromTrash(string $id)           Restore the specified soft deleted resource from the trash.
 * @method \Illuminate\Http\JsonResponse restoreAllFromTrash()                  Restore all soft deleted resources from the trash.
 * @method \Illuminate\Http\JsonResponse emptyTrash()                           Empty the trash.
 * @method \Illuminate\Http\JsonResponse deletePermanentlyFromTrash(string $id) Permanently delete the specified soft deleted resource from the trash.
 * @method \Illuminate\Http\JsonResponse deletePermanentlyAll()                 Permanently delete all resources.
 * @method \Illuminate\Http\JsonResponse search(Request $request)               Filter resources based on the provided request parameters.
 *
 * @package **`\Core\Utils\Controllers\RESTful`**
 */
class RESTfulResourceController extends Controller implements RESTfulResourceControllerContract
{
    /**
     * @var array
     */
    protected $requestClasses = [];

    /**
     * The RESTful service contract responsible for handling CRUD operations.
     *
     * @var RestJsonReadWriteServiceContract|null
     */
    protected $restJsonReadWriteService;

    /**
     * The RESTful service contract responsible for handling CRUD operations.
     *
     * @var RestJsonQueryServiceContract|null
     */
    protected $restJsonQueryService;

    /**
     * Create a new RESTfulController instance.
     *
     * @param RestJsonReadWriteServiceContract $restJsonReadWriteService The RESTful service contract for managing resources.
     * @return void
     */
    /**
     * Create a new RESTfulController instance.
     *
     * @param RestJsonReadWriteServiceContract|null $restJsonReadWriteService The RESTful service contract for managing resources.
     * @param RestJsonQueryServiceContract|null     $restJsonQueryService     The RESTful query service contract for querying resources.
     * @return void
     */
    public function __construct(RestJsonReadWriteServiceContract $restJsonReadWriteService = null, RestJsonQueryServiceContract $restJsonQueryService = null)
    {
        if ($restJsonReadWriteService === null && $restJsonQueryService === null) {
            throw new \InvalidArgumentException('At least one of $restJsonReadWriteService or $restJsonQueryService should be precise.');
        }
        
        $this->restJsonReadWriteService = $restJsonReadWriteService;
        $this->restJsonQueryService = $restJsonQueryService;
        
    }

    /**
     * Set the request class for a specific method.
     *
     * @param string $method
     * @param string $requestClass
     */
    protected function setRequestClass(string $method, string $requestClass): void
    {
        $this->requestClasses[$method] = $requestClass;
    }

    /**
     * Get the request class for a specific method.
     *
     * @param string $method
     * @return string|null
     */
    protected function getRequestClass(string $method): ?string
    {
        return $this->requestClasses[$method] ?? null;
    }

    /**
     * Get the request class for a specific method.
     *
     * @param string $method
     * @return array
     */
    protected function getRequestClasses(): array
    {
        return $this->requestClasses;
    }

    /**
     * Get the RESTful service contract responsible for handling CRUD operations.
     *
     * @return \Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract|null The RESTful service contract, or null if not set.
     */
    public function getService(): ?\Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract
    {
        return $this->restJsonReadWriteService;
    }

    /**
     * Set the RESTful service contract for managing resources.
     *
     * @param \Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract $service The RESTful service contract to set.
     */
    public function setService(\Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract $service): void
    {
        $this->restJsonReadWriteService = $service;
    }

    /**
     * Resolve the request instance for the given method.
     *
     * @param string $method
     * @param array $parameters
     * @return \Core\Utils\Requests\ResourceRequest
     */
    protected function createRequest(string $method, array $parameters): ?ResourceRequest
    {
        $requestClass = $this->getRequestClass($method);

        return $requestClass ? app($requestClass) : null;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request              The request object containing the filter parameters.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the listing of resources.
     */
    public function index(Request $request): JsonResponse
    {
        $per_page = intval($request->query('per_page', 15));
        $page = intval($request->query('page', 1));
        $fields = explode(',', $request->query('fields', '*'));
        $order = $request->query('order', 'desc');
        return $this->restJsonQueryService->paginate(perPage: $per_page, columns: $fields, order: $order, page: $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request The request object containing the data for creating the resource.
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating the status of the operation.
     */
    public function store(Request $request): JsonResponse
    { 
        $createRequest = $this->createRequest('store', [$request]);

        if ($createRequest) {

            $createRequest->validate($createRequest->rules());
        
            return $this->restJsonReadWriteService->create($createRequest->getDto());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request              The request object containing the filter parameters.
     * @param  string $id                    The identifier of the resource to be displayed.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response containing the specified resource.
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $fields = explode(',', $request->query('fields', '*'));
        return $this->restJsonQueryService->findById($id, $fields);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                   $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating the status of the operation.
     */
    public function update(Request $request, string $id): JsonResponse
    {   
        //dd($request);
        $createRequest = $this->createRequest('update', [$request]);

        if ($createRequest) {

            $createRequest->validate($createRequest->rules());
            
            return $this->restJsonReadWriteService->update($id, $createRequest->getDto());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id                    The identifier of the resource to be removed.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->softDelete($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $id                    The identifier of the resource to be removed.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function softDelete(string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->softDelete($id);
    }

    /**
     * Permanently delete the specified soft deleted resource.
     *
     * @param  string $id                    The identifier of the soft deleted resource to be permanently deleted.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function permanentDelete(string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->permanentlyDelete($id);
    }

    /**
     * Load the trash and display the soft deleted resources.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the soft deleted resources.
     */
    public function loadTrash(): JsonResponse
    {
        return $this->restJsonQueryService->trash();
    }

    /**
     * Restore the specified soft deleted resource.
     *
     * @param  string $id                    The identifier of the soft deleted resource to be restored.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function restoreFromTrash(string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->restore($id);
    }

    /**
     * Restore all soft deleted resources from the trash.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function restoreAllFromTrash(): JsonResponse
    {
        return $this->restJsonReadWriteService->restoreAll();
    }

    /**
     * Empty the trash.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function emptyTrash(): JsonResponse
    {
        return $this->restJsonReadWriteService->emptyTrash();
    }

    /**
     * Delete permanently soft deleted resources from the trash.
     *
     * @param  string $id                    The identifier of the soft deleted resource to be permanently deleted.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function deletePermanentlyFromTrash(string $id): JsonResponse
    {
        return $this->restJsonReadWriteService->permanentlyDelete($id);
    }

    /**
     * Permanently Delete all resources.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the status of the operation.
     */
    public function deletePermanentlyAll(): JsonResponse
    {
        return $this->restJsonReadWriteService->permanentlyDeleteAll();
    }

    /**
     * Filter all resources.
     *
     * @param  Request $request              The request object containing the filter parameters.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the filtered resources.
     */
    public function search(Request $request): JsonResponse
    {
        $fields = explode(',', $request->query('fields', '*'));
        return $this->restJsonQueryService->search($request->all(), $fields);
    }
}