<?php

namespace App\Models\Magasins;

use App\Models\Articles\Article;
use App\Models\Supplier;
use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\StatutsOrderEnum;
use Core\Utils\Enums\TypeOrderEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rules\Enum;

use App\Models\Magasins\CommandeArticle;

/**
 * Class Commande
 *
 * This model represents the `commandes` 
 *
 * @property date                       $date     the date the order was placed
 * @property Enum                       $statut   order statut.
 * @property Enum                       $type_order  type of the order.
 *
 * @property-read Client                $client_id                Relationship: that allows the customer to place the order.
 * @property-read Supplier              $supplier_id              Relationship: which allows us to have the supplier with whom the order was placed employees.
 *
 * @package App\Models
 */
class Commande extends ModelContract
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commandes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'statut',
        'type_order',
        'client_id',
        'supplier_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'date', 'statut', 'type_order'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'statut'          => StatutsOrderEnum::DEFAULT,
        'type_order'      => TypeOrderEnum::DEFAULT,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date'             => 'date',
        'statut'           => StatutsOrderEnum::class,
        'type_order'       => TypeOrderEnum::class,
        'client_id'        => 'string',
        'supplier_id'      => 'string',
    ];


    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'articles','getCommandeArticles'
    ];

    /**
     * Get the category of the rate of the work unit.
     *
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get the rate of the work unit for a category of employees
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Get the articles associated with this commande.
     *
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'commande_articles', 'commande_id', 'article_id');
    }

    /**
     * Get the articles associated with this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCommandeArticles()
    {
        // Use the 'commandeArticles' relationship to get the CommandeArticles associated with this order
        return $this->hasMany(CommandeArticle::class, 'commande_id');
    }

}
