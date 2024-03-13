<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Accountable;
use Core\Data\Eloquent\ORMs\Balanceable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ***`SubAccount`***
 *
 * This model represents the `plan_comptable_compte_sous_comptes` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $sub_account_id;
 *
 * @package ***`\App\Models\Finances`***
 */
class SubAccount extends ModelContract
{
    use AsPivot, Balanceable, Accountable;
    

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
        'account_number', 'principal_account_id', 'sub_account_id', 'sous_compte_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'account_number'            => 'string',
        'sub_account_id'            => 'string',
        'sous_compte_id'            => 'string',
        'principal_account_id'      => 'string'
    ];

    /**
     * Get the plan_comptable of the salary of the work unit.
     *
     * @return BelongsTo
     */
    public function principal_account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'principal_account_id');
    }

    /**
     * Get the plan_comptable of the salary of the work unit.
     *
     * @return BelongsTo
     */
    public function parent_sub_account(): BelongsTo
    {
        return $this->belongsTo(SubAccount::class, 'sub_account_id');
    }

    /**
     * Get the subdivision
     *
     * @return BelongsTo
     */
    public function sous_compte(): BelongsTo
    {
        return $this->belongsTo(Compte::class, 'sous_compte_id');
    }

    /**
     * Get the subdivisions
     *
     * @return HasMany
     */
    public function sub_divisions(): HasMany
    {
        return $this->hasMany(Compte::class, 'sub_account_id');
    }
}