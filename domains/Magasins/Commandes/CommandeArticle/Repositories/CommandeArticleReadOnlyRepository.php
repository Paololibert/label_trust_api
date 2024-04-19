<?php

declare(strict_types=1);

namespace Domains\Magasins\Commandes\CommandeArticle\Repositories;

use App\Models\Magasins\CommandeArticle;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;


/**
 * ***`CommandeArticleReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the Magasin $instance data.
 *
 * @package ***`\Domains\Magasins\Commandes\CommandeArticle\Repositories`***
 */
class CommandeArticleReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new CommandeArticleReadOnlyRepository instance.
     *
     * @param  \App\Models\Magasins\CommandeArticle $model
     * @return void
     */
    public function __construct(CommandeArticle $model)
    {
        parent::__construct($model);
    }
}