<?php

declare(strict_types=1);

namespace Domains\Partners\Clients\Repositories;

use App\Models\Client;

use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Enums\StatutContratEnum;
use Domains\Contrats\Repositories\ContractReadWriteRepository;
use Exception;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Throwable;

/**
 * ***`ClientReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Client $instance data.
 *
 * @package ***`Domains\Partners\Clients\Repositories`***
 */
class ClientReadWriteRepository extends EloquentReadWriteRepository
{


    protected ContractReadWriteRepository $contractReadWriteRepository;
    /**
     * Create a new ClientReadWriteRepository instance.
     *
     * @param  \App\Models\Client $model
     * @return void
    */

    public function __construct(Client $model)
    {
        parent::__construct($model);
    }

}