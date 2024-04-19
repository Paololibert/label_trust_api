<?php

declare(strict_types=1);

namespace Domains\Magasins\Commandes\CommandeArticle\Repositories;

use App\Models\Magasins\CommandeArticle;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Throwable;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;

/**
 * ***`CommandeArticleReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the CommandeArticle $instance data.
 *
 * @package ***`Domains\Magasins\Magasin\Repositories`***
 */
class CommandeArticleReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new CommandeArticleReadWriteRepository instance.
     *
     * @param  \App\Models\Magasins\CommandeArticle $model
     * @return void
     */
    public function __construct(CommandeArticle $model)
    {
        parent::__construct($model);
    }

    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return CommandeArticle               The created record.
     *
     * 
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): CommandeArticle
    {
        try {

            // Créez une variable pour stocker les articles créés
            $createdCommandeArticles = [];

            // Parcourez chaque article dans les données
            foreach ($data['articles'] as $article) {
                // Assurez-vous que chaque article a l'ID de la commande associée
                $article['commande_id'] = $data['commande_id'];
                // Créez l'article et ajoutez-le à la liste des articles créés
                $createdCommandeArticles[] = parent::create($article);
            }

            return $createdCommandeArticles[0];

        } catch (QueryException $exception) {
            dd($exception);
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            dd($exception);
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }

}
