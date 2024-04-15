<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresAnalytique\Repositories;

use App\Models\Finances\EcritureAnalytique;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`EcritureAnalytiqueReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the EcritureAnalytique $instance data.
 *
 * @package ***`\Domains\Finances\EcrituresAnalytique\Repositories`***
 */
class EcritureAnalytiqueReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new EcritureAnalytiqueReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\EcritureAnalytique $model
     * @return void
     */
    public function __construct(EcritureAnalytique $model)
    {
        parent::__construct($model);
    }
}