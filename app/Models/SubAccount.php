<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Accountable;
use Core\Data\Eloquent\ORMs\Balanceable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`SubAccount`***
 *
 * This model represents the `plan_comptable_comptes` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $sous_compte_id;
 *
 * @package ***`\App\Models`***
 */
class SubAccount extends ModelContract
{
    use AsPivot, Balanceable, Accountable;
    
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
    protected $table = 'plan_comptable_compte_sous_comptes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_number', 'sub_division_id', 'sous_compte_id', 'plan_comptable_compte_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'account_number'            => 'string',
        'sub_division_id'           => 'string',
        'sous_compte_id'            => 'string',
        'plan_comptable_compte_id'  => 'string'
    ];

    /**
     * Get the plan_comptable of the salary of the work unit.
     *
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'plan_comptable_compte_id');
    }

    /**
     * Get the sous compte
     *
     * @return BelongsTo
     */
    public function sous_compte(): BelongsTo
    {
        return $this->belongsTo(Compte::class, 'sous_compte_id');
    }

    /**
     * Get the subdivision
     *
     * @return BelongsTo
     */
    public function sub_division(): BelongsTo
    {
        return $this->belongsTo(Compte::class, 'sub_division_id');
    }

    /**
     * Get the subdivisions
     *
     * @return HasMany
     */
    public function sub_divisions(): HasMany
    {
        return $this->hasMany(Compte::class, 'sub_division_id');
    }
}