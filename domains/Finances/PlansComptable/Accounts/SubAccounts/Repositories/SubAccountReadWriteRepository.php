<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\SubAccounts\Repositories;

use App\Models\Finances\SubAccount;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\Comptes\Repositories\CompteReadWriteRepository;
use Domains\Finances\ExercicesComptable\Repositories\ExerciceComptableReadWriteRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * ***`SubAccountReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the SubAccount $instance data.
 *
 * @package ***`Domains\Finances\PlansComptable\Accounts\SubAccounts\Repositories`***
 */
class SubAccountReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var CompteReadWriteRepository
     */
    protected $compteReadWriteRepository;

    /**
     * @var ExerciceComptableReadWriteRepository
     */
    protected $exerciceComptableReadWriteRepository;
    
    /**
     * Create a new SubAccountReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\SubAccount $model
     * @return void
     */
    public function __construct(SubAccount $model, CompteReadWriteRepository $compteReadWriteRepository/* , ExerciceComptableReadWriteRepository $exerciceComptableReadWriteRepository */)
    {
        parent::__construct($model);
        $this->compteReadWriteRepository = $compteReadWriteRepository;
        //$this->exerciceComptableReadWriteRepository = $exerciceComptableReadWriteRepository;
    }

    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return SubAccount          The created record.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): Model
    {
        try {

            $this->model = parent::create($data);

            if(isset($data['sub_divisions'])){
                $this->attachSubDivisions($this->model->id, $data['sub_divisions']);
            }

            return $this->model->refresh();
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while creating sub-accounts or sub-divisions accounts." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Attach subaccounts.
     *
     * This method associates specific taux with a given category of employee.
     *
     * @param   string      $accountId              The unique identifier of the Account.
     * @param   array       $subDivisionDataArray    The array of access identifiers representing the taux to be attached.
     *
     * @return  bool                                Whether the taux were attached successfully.
     */
    public function attachSubDivisions(string $subAccountId, array $subDivisionDataArray): bool
    {
        try {

            $this->model = $this->find($subAccountId);

            foreach ($subDivisionDataArray as $subDivisionItem) {
                if(isset($subDivisionItem['sous_compte_id'])){
                    if (!parent::relationExists($this->model->sub_divisions(), [$subDivisionItem['sous_compte_id']], isPivot: false)) {
                        $this->create(array_merge($subDivisionItem, ["subaccountable_id" => $this->model->id, "subaccountable_type" => $this->model::class]));
                    }
                }else {
                    $compte = $this->compteReadWriteRepository->create(array_merge($subDivisionItem, $subDivisionItem["compte_data"]));

                    $this->create(array_merge($subDivisionItem, ["sous_compte_id" => $compte->id, "subaccountable_id" => $this->model->id, "subaccountable_type" => $this->model::class]));
                }
            }
    
            return true;
            
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while attaching sub-divisions accounts to a plan comptable account a sub-account." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }    
    }

    /**
     * Report de solde a un compte
     *
     * @param   string                                      $accountId              The unique identifier of the account.
     * @param   array                                       $balanceArrayData       The balance data.
     *
     * @return  bool                                                                Whether the account balance are report.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                               If there is an error while reporting account balance.
     * @throws  \Core\Utils\Exceptions\RepositoryException                          If there is an issue with the repository operation.
     */
    public function reportDeSolde(string $subAccountId, array $balanceArrayData): bool
    {
        try {
            // Find the account by ID
            $this->model = $this->model->find($subAccountId);

            //change the account balance
            $this->model->balances()->create($balanceArrayData);

            return true;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while reporting an account balance." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
    
}