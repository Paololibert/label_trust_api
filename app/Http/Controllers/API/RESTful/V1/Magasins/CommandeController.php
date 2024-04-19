<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Magasins;

use App\Http\Requests\Magasins\Commande\v1\CreateCommandeRequest;
use App\Http\Requests\Magasins\Commande\v1\UpdateCommandeRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Magasins\Commandes\Commande\Services\RESTful\Contracts\CommandeRESTfulQueryServiceContract;
use Domains\Magasins\Commandes\Commande\Services\RESTful\Contracts\CommandeRESTfulReadWriteServiceContract;

/**
 * **`CommandeController`**
 *
 * Controller for managing unite_mesure resources. This controller extends the RESTfulController
 * and provides CRUD operations for unite_mesure resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class CommandeController extends RESTfulResourceController
{
    /**
     * Create a new CommandeController instance.
     *
     * @param \Domains\Magasins\Commande\Services\RESTful\Contracts\CommandeRESTfulQueryServiceContract $article_iqpRESTfulQueryService
     *        The Commande RESTful Query Service instance.
     */
    public function __construct(CommandeRESTfulReadWriteServiceContract $article_iqpRESTfulReadWriteService, CommandeRESTfulQueryServiceContract $article_iqpRESTfulQueryService)
    {
        parent::__construct($article_iqpRESTfulReadWriteService, $article_iqpRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateCommandeRequest::class);
        $this->setRequestClass('update', UpdateCommandeRequest::class);
    }
}
