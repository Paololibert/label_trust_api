<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\SubAccounts\Repositories;

use App\Models\Finances\SubAccount;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\Comptes\Repositories\CompteReadWriteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 * ***`SubAccountReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the SubAccount $instance data.
 *
 * @package ***`Domains\Finances\PlansComptable\SubAccounts\Repositories`***
 */
class SubAccountReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var CompteReadWriteRepository
     */
    protected $compteReadWriteRepository;
    
    /**
     * Create a new SubAccountReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\SubAccount $model
     * @return void
     */
    public function __construct(SubAccount $model, CompteReadWriteRepository $compteReadWriteRepository)
    {
        parent::__construct($model);
        $this->compteReadWriteRepository = $compteReadWriteRepository;
    }

    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return SubAccount          The created record.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): SubAccount
    {
        try {

            $this->model = parent::create($data);

            if(isset($data['sub_divisions'])){
                $this->attachSubDivisions($this->model->id, $data['sub_divisions']);
            }

            return $this->model->refresh();
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
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
                    if (!parent::relationExists($this->model->sub_divisions(), [$subDivisionItem['sous_compte_id']])) {
                        $this->create(array_merge($subDivisionItem, ["subaccountable_id" => $this->model->id, "subaccountable_type" => $this->model::class]));
                    }
                }else {
                    $compte = $this->compteReadWriteRepository->create(array_merge($subDivisionItem, $subDivisionItem["compte_data"]));

                    $this->create(array_merge($subDivisionItem, ["sous_compte_id" => $compte->id, "subaccountable_id" => $this->model->id, "subaccountable_type" => $this->model::class]));
                }
            }
    
            return false; // Taux is already attached
            
        } catch (ModelNotFoundException $exception) {
            throw new QueryException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while attaching taux to category of employee.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while attaching taux to category of employee.", previous: $exception);
        }        
    }
    
}