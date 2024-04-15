<?php

declare(strict_types=1);

namespace Domains\Magasins\Commandes\Commande\Repositories;

use App\Models\Magasins\Commande;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\TypeOrderEnum;
use Domains\Magasins\Commandes\CommandeArticle\Repositories\CommandeArticleReadWriteRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;

/**
 * ***`CommandeReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Commande $instance data.
 *
 * @package ***`Domains\Magasins\Magasin\Repositories`***
 */
class CommandeReadWriteRepository extends EloquentReadWriteRepository
{
    
    /**
     * @var CommandeArticleReadWriteRepository
     */
    private $commandeArticleRWRepository;

    /**
     * Create a new CommandeReadWriteRepository instance.
     *
     * @param  \App\Models\Magasins\Commande $model
     * @return void
     */
    public function __construct(Commande $model, CommandeArticleReadWriteRepository $commandeArticleRWRepository)
    {
        parent::__construct($model);
        $this->commandeArticleRWRepository = $commandeArticleRWRepository;
    }
    
    
    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return Commande               The created record.
     *
     * 
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): Commande
    {
        try {
            
            $theparent =  $this->model = parent::create($data);

            $commande_articles = $this->commandeArticleRWRepository->create(array_merge($data['data'],['commande_id'=>$theparent->id]));
            
            if (!$commande_articles) throw new Exception("Error occur while creating the details of the order",1);

            return $this->model->refresh();
            
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }
}