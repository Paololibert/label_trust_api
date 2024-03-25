<?php

declare(strict_types=1);

namespace Domains\Montants\Repositories;

use App\Models\Montant;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`MontantReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Montant $instance data.
 *
 * @package ***`\Domains\Montants\Repositories`***
 */
class MontantReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new MontantReadOnlyRepository instance.
     *
     * @param  \App\Models\Montant $model
     * @return void
     */
    public function __construct(Montant $model)
    {
        parent::__construct($model);
    }
}