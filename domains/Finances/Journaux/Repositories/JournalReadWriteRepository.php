<?php

declare(strict_types=1);

namespace Domains\Finances\Journaux\Repositories;

use App\Models\Finances\Journal;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;

/**
 * ***`JournalReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Journal $instance data.
 *
 * @package ***`Domains\Finances\Journaux\Repositories`***
 */
class JournalReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new JournalReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\Journal $model
     * @return void
     */
    public function __construct(Journal $model)
    {
        parent::__construct($model);
    }
    
}