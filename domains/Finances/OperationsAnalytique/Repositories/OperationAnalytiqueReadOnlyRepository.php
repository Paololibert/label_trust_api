<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsAnalytique\Repositories;

use App\Models\Finances\OperationAnalytique;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`OperationAnalytiqueReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the OperationAnalytique $instance data.
 *
 * @package ***`\Domains\Finances\OperationsAnalytique\Repositories`***
 */
class OperationAnalytiqueReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new OperationAnalytiqueReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\OperationAnalytique $model
     * @return void
     */
    public function __construct(OperationAnalytique $model)
    {
        parent::__construct($model);
    }
}