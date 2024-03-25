<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\LignesEcritureComptable\Repositories;

use App\Models\Finances\LigneEcritureComptable;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`LigneEcritureComptableReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the EcritureComptable $instance data.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\LignesEcritureComptable\Repositories`***
 */
class LigneEcritureComptableReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new LigneEcritureComptableReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\LigneEcritureComptable $model
     * @return void
     */
    public function __construct(LigneEcritureComptable $model)
    {
        parent::__construct($model);
    }
}