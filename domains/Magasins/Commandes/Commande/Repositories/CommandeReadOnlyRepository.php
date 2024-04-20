<?php

declare(strict_types=1);

namespace Domains\Magasins\Commandes\Commande\Repositories;

use App\Models\Magasins\Commande;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;
use Illuminate\Database\Eloquent\Collection;
use Throwable;
use Core\Utils\Exceptions\RepositoryException;
use Illuminate\Support\Facades\DB;

/**
 * ***`CommandeReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Magasin $instance data.
 *
 * @package ***`\Domains\Magasins\Commandes\Commande\Repositories`***
 */
class CommandeReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new CommandeReadOnlyRepository instance.
     *
     * @param  \App\Models\Magasins\Commande $model
     * @return void
     */
    public function __construct(Commande $model)
    {
        parent::__construct($model);
    }
    

}