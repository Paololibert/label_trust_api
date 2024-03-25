<?php

declare(strict_types=1);

namespace Domains\Finances\Comptes\Repositories;

use App\Models\Finances\Compte;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`CompteReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Compte $instance data.
 *
 * @package ***`Domains\Finances\Comptes\Repositories`***
 */
class CompteReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new CompteReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\Compte $model
     * @return void
     */
    public function __construct(Compte $model)
    {
        parent::__construct($model);
    }
    
}