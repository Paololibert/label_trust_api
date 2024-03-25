<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Accountable;
use Core\Data\Eloquent\ORMs\Balanceable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
        'account_number', 'subaccountable_id', 'subaccountable_type', /* 'sub_account_id',  */'sous_compte_id'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'account_number'
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
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'account_number'            => 'string',
        //'sub_account_id'            => 'string',
        'sous_compte_id'            => 'string',
        'subaccountable_id'         => 'string',
        'subaccountable_type'       => 'string'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'sub_divisions'
    ];

    /**
     * Get the user's full name attribute.
     *
     * @return string The user's full name.
     */
    public function getIntituleAttribute(): string
    {
        return $this->sous_compte->name ;
    }
    
    /**
     * Get sub accountable.
     *
     * @return MorphTo
     */
    public function subaccountable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get sub divisions.
     *
     * @return MorphMany
     */
    public function sub_divisions(): MorphMany
    {
        return $this->morphMany(SubAccount::class, 'subaccountable');
    }

    /**
     * Get the plan_comptable of the salary of the work unit.
     *
     * @return BelongsTo|null
     */
    public function parent_sub_account(): ?BelongsTo
    {
        return $this->belongsTo(SubAccount::class, 'subaccountable_id');
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
     * Get the subdivisions
     *
     * @return HasMany
     */
    /* public function sub_divisions(): HasMany
    {
        return $this->hasMany(Compte::class, 'sub_account_id');
    } */

    /**
     * Get subdivisions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    /* public function subdivisions(): BelongsToMany
    {
        return $this->belongsToMany(Compte::class, 'plan_comptable_compte_sous_comptes', 'sub_account_id', 'sous_compte_id')
                    ->as('subdivision')
                    ->withPivot('account_number', 'status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->using(SubAccount::class); // Specify the intermediate model for the pivot relationship
    } */
}