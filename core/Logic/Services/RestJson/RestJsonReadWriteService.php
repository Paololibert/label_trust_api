<?php

declare(strict_types=1);

namespace Core\Logic\Services\RestJson;

use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Core\Utils\Exceptions\Contract\CoreException;

/**
 * Class `RestJsonReadWriteService`
 *
 * The `RestJsonReadWriteService` class is an abstract class that provides a concrete implementation of the `RestJsonReadWriteServiceContract`.
 * It extends the RestJsonQueryService class and adds methods for `creating`, `updating`, and `deleting` records in a `RESTful JSON` format.
 * This class is responsible for `creating` records, `updating` records, `soft deleting` records, `permanently deleting` records, `restoring` soft deleted records,
 * `emptying the trash`, and `performing bulk` operations on records.
 *
 * @package \Core\Logic\Services\RestJson
 */
abstract class RestJsonReadWriteService extends RestJsonQueryService implements RestJsonReadWriteServiceContract
{

    /**
     * The read-write service instance.
     *
     * @var \Core\Logic\Services\Contracts\ReadWriteServiceContract|null
     */
    protected ?ReadWriteServiceContract $readWriteService;


    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
        $this->readWriteService = $readWriteService;
    }

    /**
     * Set the read-write service associated with the service.
     *
     * @param \Core\Logic\Services\Contracts\ReadWriteServiceContract $service The read-write service instance.
     * @return void
     */
    public function setReadWriteService(ReadWriteServiceContract $service): void
    {
        $this->readWriteService = $service;
    }

    /**
     * Get the read-write service associated with the service.
     *
     * @return \Core\Logic\Services\Contracts\ReadWriteServiceContract The read-write service instance.
     */
    public function getReadWriteService(): ReadWriteServiceContract
    {
        return $this->readWriteService;
    }

    /**
     * Create a new record.
     *
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface $data The data for creating the record.
     * @return \Illuminate\Http\JsonResponse                 The JSON response indicating whether the create was successful or not.
     *
     * @throws \Core\Utils\Exceptions\ServiceException             If there is an error while creating the record.
     */
    public function create(DTOInterface $data): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            $data = $this->readWriteService->create($data);
            
            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Record created successfully',
                data: $data,
                status_code: Response::HTTP_CREATED
            );
        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Update an existing record.
     *
     * @param  Model|string                   $id            The ID of the record to update.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface $data The data for updating the record.
     * @return \Illuminate\Http\JsonResponse                 The JSON response indicating whether the update was successful or not.
     *
     * @throws \Core\Utils\Exceptions\ServiceException             If there is an error while updating the record.
     */
    public function update($id, DTOInterface $data): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            $data = $this->readWriteService->update($id, $data);

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Record updated successfully',
                data: $data,
                status_code: Response::HTTP_CREATED
            );
        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Soft delete one or more records.
     *
     * @param  string|array $ids                                    The ID or IDs of the record(s) to soft delete.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating whether the soft delete was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If any of the records with the given IDs are not found.
     * @throws \Core\Utils\Exceptions\ServiceException                    If there is an error while performing the soft delete.
     */
    public function softDelete($ids): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $data = $this->readWriteService->softDelete($ids);

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Records soft deleted successfully',
                data: $data,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Permanently delete one or more soft deleted records.
     *
     * @param  string|array $ids                                   The ID or IDs of the record(s) to permanently delete.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating whether the permanent deletion was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If any of the soft deleted records with the given IDs are not found.
     * @throws \Core\Utils\Exceptions\ServiceException                   If there is an error while performing the permanent deletion.
     */
    public function permanentlyDelete($ids): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $data = $this->readWriteService->permanentlyDelete($ids);

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'All records restored successfully',
                data: $data,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Restore one or more soft deleted records.
     *
     * @param  string|array $ids                                   The ID or IDs of the soft deleted record(s) to restore.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating whether the restoration of all soft deleted records was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If any of the soft deleted records with the given IDs are not found.
     * @throws \Core\Utils\Exceptions\ServiceException                   If there is an error while restoring the soft deleted records.
     */
    public function restore($ids): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $data = $this->readWriteService->restore($ids);

            // Commit the transaction
            DB::commit();
            
            return JsonResponseTrait::success(
                message: 'Records restored successfully',
                data: $data,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Restore all soft deleted records.
     *
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating whether the restoration of all soft deleted records was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while restoring all soft deleted records.
     */
    public function restoreAll(): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $data = $this->readWriteService->restoreAll();

            // Commit the transaction
            DB::commit();
            
            return JsonResponseTrait::success(
                message: 'All records restored successfully',
                data: $data,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Empty the trash by permanently deleting all soft deleted records.
     *
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating whether the emptying of trash was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while emptying the trash.
     */
    public function emptyTrash(): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $data = $this->readWriteService->emptyTrash();

            // Commit the transaction
            DB::commit();
            
            return JsonResponseTrait::success(
                message: 'Trash emptied successfully',
                data: $data,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Permanently delete all records.
     *
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating whether the permanent deletion of all records was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function permanentlyDeleteAll(): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $data = $this->readWriteService->permanentlyDeleteAll();

            // Commit the transaction
            DB::commit();
            
            return JsonResponseTrait::success(
                message: 'All records permanently deleted successfully',
                data: $data,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
