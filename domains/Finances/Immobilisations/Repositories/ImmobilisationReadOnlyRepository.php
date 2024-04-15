<?php

declare(strict_types=1);

namespace Domains\Finances\Immobilisations\Repositories;

use App\Models\Finances\Immobilisation;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`ImmobilisationReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Immobilisation $instance data.
 *
 * @package ***`\Domains\Finances\Immobilisations\Repositories`***
 */
class ImmobilisationReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new ImmobilisationReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\Immobilisation $model
     * @return void
     */
    public function __construct(Immobilisation $model)
    {
        parent::__construct($model);
    }
}