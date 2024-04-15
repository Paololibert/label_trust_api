<?php

declare(strict_types=1);

namespace App\Models\Finances;

use App\Models\Articles\Article;
use App\Models\Productions\LigneDeProduction;
use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`ProjetProduction`***
 *
 * This model represents the `projets_production` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class ProjetProduction extends ModelContract
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
    protected $table = 'projets_production';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "intitule", "description", "date_debut", "date_fin", "ligne_de_production_id", "article_id"
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        "intitule", "description", "date_debut", "date_fin"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "intitule"                  => "string",
        "description"               => "string",
        "ligne_de_production_id"    => "string",
        "article_id"                => "string",
        'date_debut'                => 'datetime:Y-m-d H:i:s',
        'date_fin'                  => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $appends = [
        "ligne_de_production", "produit_fini"
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        "date_debut", "date_fin"
    ];
    
    /**
     * Interact with the ProjetProduction's intitule.
     */
    protected function intitule(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }

    /**
     * Date debut du projet
     * 
     * @return Attribute
     */
    protected function date_debut(): Attribute
    {
        return Attribute::make(
            set: function (string|null $value) {
                $this->date_debut =  $value ?? \Carbon\Carbon::createFromFormat("Y-m-d", $value)->format('Y-m-d H:i:s');
            }
        );
    }

    /**
     * Get ligne de production name
     *
     * @return string
     */
    public function getLigneDeProductionAttribute(): string
    {
        return $this->ligneDeProduction->name;
    }

    /**
     * Get produit fini related to  the projet
     *
     * @return string.
     */
    public function getProduitFiniAttribute(): string
    {
        return $this->article->name;
    }

    /**
     * Ecritures analytique
     *
     * @return HasMany
     */
    public function ecritures_analytique(): HasMany
    {
        return $this->hasMany(EcritureAnalytique::class, 'projet_production_id');
    }

    /**
     * Produit Fini concerne par le projet
     *
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * La ligne de production concerne par le projet
     *
     * @return BelongsTo
     */
    public function ligneDeProduction(): BelongsTo
    {
        return $this->belongsTo(LigneDeProduction::class, 'ligne_de_production_id');
    }
}