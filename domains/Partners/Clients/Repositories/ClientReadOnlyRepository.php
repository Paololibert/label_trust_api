<?php

declare(strict_types=1);

namespace Domains\Partners\Clients\Repositories;

use App\Models\Client;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;

/**
 * ***`ClientReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Client $instance data.
 *
 * @package ***`\Domains\Partners\Clients\Repositories`***
 */
class ClientReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new ClientReadOnlyRepository instance.
     *
     * @param  \App\Models\Client $model
     * @return void
     */
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }
}