<?php

declare(strict_types=1);

namespace Domains\Partners\Repositories;

use App\Models\Partner;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`PartnerReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Partner $instance data.
 *
 * @package ***`\Domains\Partners\Repositories`***
 */
class PartnerReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new PartnerReadOnlyRepository instance.
     *
     * @param  \App\Models\Partner $model
     * @return void
     */
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }
}