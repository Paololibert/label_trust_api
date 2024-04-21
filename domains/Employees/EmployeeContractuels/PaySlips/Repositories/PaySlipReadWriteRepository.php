<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\PaySlips\Repositories;

use App\Models\EmployeeContractuel;
use App\Models\Finances\PaySlip;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Employees\EmployeeContractuels\Repositories\EmployeeContractuelReadWriteRepository;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * ***`PaySlipReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EmployeeContractuel $instance data.
 *
 * @package ***`Domains\Employees\EmployeeContractuels\Repositories`***
 */
class PaySlipReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new PaySlipReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\PaySlip $model
     * @return void
     */

    public function __construct(PaySlip $model)
    {
        parent::__construct($model);
    }


    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return Model               The created record.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): Model
    {
        try {

            $employeeContractuel = app(EmployeeContractuelReadWriteRepository::class)->find($data["employee_contractuel_id"]);

            $this->model = $employeeContractuel->pay_slips()->create($data);

            $this->model->items()->create(["libelle" => "Salaire de base", "amount" => $employeeContractuel->contract->salary->montant]);

            if (isset($data["items"])) {
                foreach ($data["items"] as $key => $item) {
                    $this->model->items()->create($item);
                }
            }

            $this->model->refresh();

            $total = $this->model->items->sum("amount");

            $this->model->update(["total_hors_taxe" => $total, "ttc" => $total - (($total * $this->model->tva) / 100)]);

            return $this->model->refresh();
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        } catch (Throwable $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), previous: $exception);
        }
    }

    public function update($id, array $data)
    {
        try {

            $this->model = $this->find($id)->where("employee_contractuel_id", $data["employee_contractuel_id"])->firstOrFail();

            $items = $this->model->items;

            if (isset($data["items"])) {
                foreach ($data["items"] as $key => $item) {

                    if (isset($item["id"])) {

                        $pay_slip_item = $this->model->items()->where("id", $item["id"])->first();

                        dump($pay_slip_item);

                        if ($pay_slip_item) {
                            $pay_slip_item->update($item);

                            $items = $items->reject(function ($pay_slip_item) use ($item) {
                                return $pay_slip_item->id === $item["id"];
                            });
                        }
                    } else {
                        $this->model->items()->create($item);
                    }
                }

                $items->each->delete();
                
            }

            $this->model->refresh();

            $total = $this->model->items->sum("amount");

            $this->model->update(array_merge($data, ["total_hors_taxe" => $total, "ttc" => $total - (($total * $data["tva"]) / 100)]));

            return $this->model->refresh();
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        } catch (Throwable $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Validate Invoice
     *
     * @param   string      $employeeComptableId     The unique identifier of the employee.
     * @param   string      $paySlipId               The unique identifier of the pay slip.
     *
     * @return  bool                        Whether the pay slip is validate were created successfully.
     */
    public function validatePaySlip(string $employeeComptableId, string $paySlipId): bool
    {
        try {

            $this->model = $this->find($paySlipId)->where("employee_contractuel_id", $employeeComptableId)->firstOrFail();

            return $this->model->update(["pay_slip_status" => true]);
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        } catch (Throwable $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), previous: $exception);
        }
    }
}
