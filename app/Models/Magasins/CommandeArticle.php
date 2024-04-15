<?php

namespace App\Models\Magasins;

use App\Models\Articles\Article;
use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\StatutsOrderEnum;
use Core\Utils\Enums\TypeOrderEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\Rules\Enum;
use Ramsey\Uuid\Type\Decimal;

/**
 * Class CommandeArticle
 *+
 * This model represents the `commande_articles` 
 *
 * @property Decimal                    $quantity       the quantity the ordered article
 * @property Decimal                    $discount       the  discount of the ordered article.
 * @property Article                    $article_id     Relationship: that articles ordered
 *
 * @property-read Commande              $commande_id    Relationship: the order which contains the ordered articles.
 *
 * @package App\Models
 */
class CommandeArticle extends ModelContract
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commande_articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'discount',
        'article_id',
        'commande_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'quantity','discount','article_id','commande_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity'              => 'decimal',
        'discount'              => 'decimal',
        'article_id'            => 'string',
        'commande_id'           => 'string',
    ];

    /**
     * Get the article the order.
     *
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * Get the order which contains the ordered articles
     *
     * @return BelongsTo
     */
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }

}