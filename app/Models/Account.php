<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\Accountable;
use Core\Data\Eloquent\ORMs\Balanceable;
use Core\Utils\Traits\CPivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * Class ***`Account`***
 *
 * This model represents the `plan_comptable_comptes` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $compte_id;
 *
 * @package ***`\App\Models`***
 */
class Account extends ModelContract
{
    use AsPivot, CPivot, Balanceable, Accountable;
    
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
    protected $table = 'plan_comptable_comptes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_number', 'classe_id', 'compte_id', 'plan_comptable_id',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'account_number',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'intitule', 'classe_name'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'account_number'    => 'string', 
        'classe_id'         => 'string',
        'compte_id'         => 'string',
        'plan_comptable_id' => 'string'
    ];

    /**
     * Get the user's full name attribute.
     *
     * @return string The user's full name.
     */
    public function getClasseNameAttribute(): string
    {
        return $this->classe->name ;
    }

    /**
     * Get the user's full name attribute.
     *
     * @return string The user's full name.
     */
    public function getIntituleAttribute(): string
    {
        return $this->compte->name ;
    }

    /**
     * Get the plan_comptable of the salary of the work unit.
     *
     * @return BelongsTo
     */
    public function plan_comptable(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class, 'plan_comptable_id');
    }

    /**
     * Get the compte of the work unit for a poste
     *
     * @return BelongsTo
     */
    public function compte(): BelongsTo
    {
        return $this->belongsTo(Compte::class, 'compte_id');
    }

    /**
     * Get the classe of the account
     *
     * @return BelongsTo
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(ClasseDeCompte::class, 'classe_id');
    }

    /**
     * Get sous comptes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sous_comptes(): BelongsToMany
    {
        return $this->belongsToMany(Compte::class, 'plan_comptable_compte_sous_comptes', 'plan_comptable_id', 'sous_compte_id')
                    ->as('sub_account')
                    ->withPivot('status', 'deleted_at', 'can_be_delete')
                    ->withTimestamps() // Enable automatic timestamps for the pivot table
                    ->wherePivot('status', true) // Filter records where the status is true
                    ->using(SubAccount::class); // Specify the intermediate model for the pivot relationship
    }
}