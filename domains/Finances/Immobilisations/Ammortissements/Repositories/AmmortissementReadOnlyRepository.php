<?php

declare(strict_types=1);

namespace Domains\Finances\Immobilisations\Ammortissements\Repositories;

use App\Models\Finances\Ammortissement;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`AmmortissementReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the EcritureComptable $instance data.
 *
 * @package ***`\Domains\Finances\Immobilisations\Ammortissements\Repositories`***
 */
class AmmortissementReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new AmmortissementReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\Ammortissement $model
     * @return void
     */
    public function __construct(Ammortissement $model)
    {
        parent::__construct($model);
    }
}