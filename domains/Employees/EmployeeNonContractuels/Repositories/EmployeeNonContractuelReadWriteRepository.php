<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Repositories;

use App\Models\EmployeeNonContractuel;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use App\Models\CategoryOfEmployee;
use Core\Utils\Exceptions\Contract\CoreException;
use Exception;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\Repositories\CategoryOfEmployeeTauxReadWriteRepository;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;
use Throwable;

/**
 * ***`EmployeeNonContractuelReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EmployeeNonContractuel $instance data.
 *
 * @package ***`Domains\Employees\EmployeeNonContractuels\Repositories`***
 */
class EmployeeNonContractuelReadWriteRepository extends EloquentReadWriteRepository
{
    private $categoryOfEmployeeTauxReadWriteRepository;

    /**
     * Create a new EmployeeNonContractuelReadWriteRepository instance.
     *
     * @param  \App\Models\EmployeeNonContractuel $model
     * 
     * 
     * @return void
     */
    public function __construct(EmployeeNonContractuel $model, CategoryOfEmployeeTauxReadWriteRepository $categoryOfEmployeeTauxReadWriteRepository)
    {
        parent::__construct($model);
        $this->categoryOfEmployeeTauxReadWriteRepository = $categoryOfEmployeeTauxReadWriteRepository;
    }


    /**
     * Change the category of a non-contractual employee.
     *
     * @param string            $employeeId The ID of the non-contractual employee.
     * @param string            $newCategoryId The ID of the new category.
     * @param array             $data Additional data such as 'date_debut', 'category_of_employee_taux_id'.
     *
     * @return bool             True if the category is successfully changed, false otherwise.
     * @throws Exception        If the employee or the category is not found.
     */
    public function changeCategoryOfNonContractualEmployee(string $employeeId, string $newCategoryId, array $data): bool
    {
        try {

            // Find the non-contractual employee by ID
            $employee = $this->model->find($employeeId);

            // Get the ID of the current category
            $currentCategoryId = $employee->categories()->wherePivot('date_fin', null)->wherePivot('category_of_employee_id', $data['category_of_employee_id'])->first();


            if (!$currentCategoryId) throw new Exception("Impossible  hear to get the current categorie of the employee.");

            // Check if the new category exists
            $emp_Cont_rep = CategoryOfEmployee::find($newCategoryId);
            if (!$emp_Cont_rep) throw new Exception("Impossible to get the categorie of the employee.");


            //CategoryOfEmployee::findOrFail($newCategoryId);


            // Update the end date of the current category
            if ($currentCategoryId) {
                DB::table('employee_non_contractuel_categories')
                    ->where('employee_non_contractuel_id', $employeeId)
                    ->where('category_of_employee_id', $currentCategoryId->id)
                    ->update(['date_fin' => now()]);
            }

            $categoryEmployeeTauxId = $data['category_of_employee_taux_id'] ?? null;

            $attributes = [
                'date_debut' => $data['date_debut'],

                'category_of_employee_taux_id' => $categoryEmployeeTauxId
            ];

            // Attach the new category to the employee with the provided data

            $employee->categories()->attach($newCategoryId, $attributes);

            return true;
        } catch (QueryException $exception) {

            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {

            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }

    /**
     * Generate Invoice
     *
     * @param   string      $employeeId     The unique identifier of the employee.
     * @param   array       $data           The array data.
     */
    public function generateInvoice(string $employeeId, array $data)
    {
        try {

            $this->model = $this->find($employeeId);

            $invoice = $this->model->invoices()->create($data);

            foreach ($data["items"] as $key => $item) {

                $taux = $this->model->actual_category->taux->where("unite_travaille_id", $item["unite_travaille_id"])->first();

                $item["unit_price"] = $taux->montant->montant;
                $item["total"] = ($item["unit_price"] * $item["quantity"]) / $taux->hint;

                $invoice->items()->create($item);
            }

            $invoice->refresh();
            $invoice->update(["total" => $invoice->items->sum("total")]);


            return $invoice->refresh();
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        } catch (Throwable $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Update Invoice
     *
     * @param   string      $employeeId     The unique identifier of the employee.
     * @param   string      $invoiceId      The unique identifier of the invoice.
     * @param   array       $data           The array data.
     */
    public function updateInvoice(string $employeeId, string $invoiceId, array $data)
    {
        try {

            $this->model = $this->find($employeeId);

            $invoice = $this->model->invoices()->where("id", $invoiceId)->first();

            $items = $invoice->items;

            foreach ($data["items"] as $key => $item) {

                $taux = $this->model->actual_category->taux->where("unite_travaille_id", $item["unite_travaille_id"])->first();

                $item["unit_price"] = $taux->montant->montant;
                $item["total"] = ($item["unit_price"] * $item["quantity"]) / $taux->hint;

                if (isset($item["id"])) {

                    $invoice_item = $invoice->items->where("id", $item["id"])->first();

                    if ($invoice_item) {
                        $invoice_item->update($item);

                        $items = $items->reject(function ($invoice_item) use ($item) {
                            return $invoice_item->id === $item["id"];
                        });
                    }
                } else {
                    $invoice->items()->create($item);
                }
            }

            $items->each->delete();
            $invoice->refresh();
            $invoice->update(array_merge($data, ["total" => $invoice->items->sum("total")]));

            return $invoice->refresh();
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
     * @param   string      $employeeId     The unique identifier of the employee.
     * @param   string      $invoiceId      The unique identifier of the invoice.
     *
     * @return  bool                        Whether the invoice were created successfully.
     */
    public function validateInvoice(string $employeeId, string $invoiceId): bool
    {
        try {

            $this->model = $this->find($employeeId);

            $invoice = $this->model->invoices()->where("id", $invoiceId)->first();

            return $invoice->update(["invoice_status" => true]);
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        } catch (Throwable $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), previous: $exception);
        }
    }
}
