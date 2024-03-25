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
        'libelle', 'montant', 'type_ecriture_compte', 'ligneable_id', 'ligneable_type', 'accountable_id', 'accountable_type'
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
    protected $visible = [
        'libelle', 'montant', 'type_ecriture_compte'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'libelle'                   => 'string',
        'montant'                   => 'decimal:2',
        'ligneable_id'              => 'string',
        'ligneable_type'            => 'string',
        'accountable_id'            => 'string',
        'accountable_type'          => 'string',
        'type_ecriture_compte'      => TypeEcritureCompteEnum::class
    ];
    
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