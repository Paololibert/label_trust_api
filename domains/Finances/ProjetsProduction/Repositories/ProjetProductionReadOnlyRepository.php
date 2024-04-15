<?php

declare(strict_types=1);

namespace Domains\Finances\ProjetsProduction\Repositories;

use App\Http\Resources\Finances\JournauxResource;
use App\Models\Finances\ProjetProduction;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;

/**
 * ***`ProjetProductionReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the ProjetProduction $instance data.
 *
 * @package ***`\Domains\Finances\ProjetsProduction\Repositories`***
 */
class ProjetProductionReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new ProjetProductionReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\ProjetProduction $model
     * @return void
     */
    public function __construct(ProjetProduction $model)
    {
        parent::__construct($model);
    }

    public function journaux(string $exerciceComptableId, array $periodeArrayData)
    {
        try {
            $projet_production = $this->find($exerciceComptableId)->load(["journaux", "journaux.ecritures_comptable"]);

            return new JournauxResource(resource: $projet_production);
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while quering balance of accounts of an exercice comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
