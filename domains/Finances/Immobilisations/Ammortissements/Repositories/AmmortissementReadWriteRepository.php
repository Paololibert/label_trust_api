<?php

declare(strict_types=1);

namespace Domains\Finances\Immobilisations\Ammortissements\Repositories;

use App\Models\Finances\Ammortissement;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`AmmortissementReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EcritureComptable $instance data.
 *
 * @package ***`Domains\Finances\Immobilisations\Ammortissement\Repositories`***
 */
class AmmortissementReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new AmmortissementReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\Ammortissement $model
     * @return void
     */
    public function __construct(Ammortissement $model)
    {
        parent::__construct($model);
    }
}