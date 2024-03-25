<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\LignesEcritureComptable\Repositories;

use App\Models\Finances\LigneEcritureComptable;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`LigneEcritureComptableReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EcritureComptable $instance data.
 *
 * @package ***`Domains\Finances\EcrituresComptable\LignesEcritureComptable\Repositories`***
 */
class LigneEcritureComptableReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new LigneEcritureComptableReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\LigneEcritureComptable $model
     * @return void
     */
    public function __construct(LigneEcritureComptable $model)
    {
        parent::__construct($model);
    }
    
}