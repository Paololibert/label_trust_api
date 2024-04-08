<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\TypeEcritureCompteEnum;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class ***`LigneEcritureComptable`***
 *
 * This model represents the `lignes_ecriture_comptable` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class LigneEcritureComptable extends ModelContract
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
    protected $table = 'lignes_ecriture_comptable';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'montant', 'type_ecriture_compte', 'ligneable_id', 'ligneable_type', 'accountable_id', 'accountable_type'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type_ecriture_compte'   => TypeEcritureCompteEnum::DEFAULT
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'intitule'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'montant', 'type_ecriture_compte'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'montant'                   => 'decimal:2',
        'ligneable_id'              => 'string',
        'ligneable_type'            => 'string',
        'accountable_id'            => 'string',
        'accountable_type'          => 'string',
        'type_ecriture_compte'      => TypeEcritureCompteEnum::class
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::observe(\App\Observers\LigneEcritureComptableObserver::class);
    }

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    /* protected static function boot(): void
    {
        parent::boot();

        static::creating(function (LigneEcritureComptable $model) {
            parent::creating($model);
            dd($model->ligneable->plan_comptable);
            if(!$model->ligneable->plan_comptable->findAccountOrSubAccount($model->accountable->account_number)){
                throw new ModelNotFoundException('Veuillez preciser un numero de compte du plan comptable');
            }
        });
    } */

    /**
     * Get account related
     *
     * @return string|null The user's full name.
     */
    public function getIntituleAttribute(): ?string
    {
        return $this->accountable?->intitule;
    }
    
    /**
     * Get the associate parent details.
     *
     * @return MorphTo
     */
    public function ligneable(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Get the account details.
     *
     * @return MorphTo
     */
    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }
}