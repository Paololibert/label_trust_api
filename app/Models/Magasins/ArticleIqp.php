<?php

declare(strict_types=1);

namespace App\Models\Magasins;

use App\Models\Articles\Article;
use App\Models\UniteMesure;
use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`ArticleIqp`***
 *
 * This model represents the `article_iqps` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class ArticleIqp extends ModelContract
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_iqps';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'norme',
        'unite_mesure_id',
        'article_id',
        'iqp_id'
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'name',
        'norme',
        'unite_mesure_id',
        'article_id',
        'iqp_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name'                  =>'string',
        'norme'                 =>'string',
        'unite_mesure_id'       =>'string',      
        'article_id'            =>'string',
        'iqp_id'                =>'string',
    ];

    /**
     * Get the article for the article_iqp.
    */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * Get the unit of measure for the article_iqp.
    */
    public function unite_mesure(): BelongsTo
    {
        return $this->belongsTo(UniteMesure::class, 'unite_mesure_id');
    }

    /**
     * Get the IQP for the article_iqp.
    */
    public function iqp(): BelongsTo
    {
        return $this->belongsTo(IQP::class, 'iqp_id');
    }
}
