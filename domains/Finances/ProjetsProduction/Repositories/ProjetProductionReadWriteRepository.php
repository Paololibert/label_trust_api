<?php

declare(strict_types=1);

namespace Domains\Finances\ProjetsProduction\Repositories;

use App\Models\Finances\ProjetProduction;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\StatusExerciceEnum;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\QueryException as CoreQueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadWriteRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * ***`ProjetProductionReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the ProjetProduction $instance data.
 *
 * @package ***`Domains\Finances\ProjetsProduction\Repositories`***
 */
class ProjetProductionReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var AccountReadWriteRepository
     */
    protected $accountRepositoryReadWrite;

    /**
     * Create a new ProjetProductionReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\ProjetProduction $model
     * @return void
     */
    public function __construct(ProjetProduction $model)
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
            return parent::create($data);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while creating the exercice comptable.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the exercice comptable.", previous: $exception);
        }
    }
}
