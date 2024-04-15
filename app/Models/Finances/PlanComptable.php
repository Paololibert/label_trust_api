<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;
use Core\Utils\Exceptions\ApplicationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class ***`PlanComptable`***
 *
 * This model represents the `plans_comptable` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models\Finances`***
 */
class PlanComptable extends ModelContract
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
    protected $table = 'plans_comptable';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code', 'name', 'description', 'est_valider'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'code', 'name', 'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'code'         => 'string',
        'name'         => 'string',
        'description'  => 'string',
        'est_valider'  => 'boolean'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'accounts'
    ];

    /**
     * Interact with the PlanComptable's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }

    /**
     * Define a many-to-many relationship with the Compte model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comptes(): BelongsToMany
    {
        return $this->belongsToMany(Compte::class, 'plan_comptable_comptes', 'plan_comptable_id', 'compte_id')
            ->as('account')
            ->withPivot('account_number', 'classe_id', 'status', 'deleted_at', 'can_be_delete')
            ->withTimestamps() // Enable automatic timestamps for the pivot table
            ->wherePivot('status', true) // Filter records where the status is true
            ->using(Account::class); // Specify the intermediate model for the pivot relationship
    }

    /**
     * @return HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'plan_comptable_id');
    }

    /**
     * @return HasMany
     */
    public function sortAccounts(): HasMany
    {
        return $this->hasMany(Account::class, 'plan_comptable_id')
            ->join('classes_de_compte', 'plan_comptable_comptes.classe_id', '=', 'classes_de_compte.id')
            ->orderBy('classes_de_compte.class_number');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Builder|null $query
     * 
     * @return HasManyThrough|\Illuminate\Database\Eloquent\Collection
     */
    public function sub_accounts($query = null, bool $withSubDivision = false, array $columns = ["*"]): HasManyThrough|\Illuminate\Database\Eloquent\Collection
    {
        if ($query) {
            if ($query->getModel() instanceof Account) {
                return $this->sub_accounts_and_sub_divisions(query: $query, withSubDivision: $withSubDivision, columns: $columns);
            }
        }
        return $this->hasManyThrough(SubAccount::class, Account::class, 'plan_comptable_id', 'subaccountable_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Builder|null $query
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function sub_divisions($query = null, array $columns = ["*"])
    {
        $sub_divisions = new \Illuminate\Database\Eloquent\Collection(); // Create an empty Eloquent collection

        $query = $query ?? $this->sub_accounts();

        if ($query instanceof \Illuminate\Database\Eloquent\Collection) {
            $this->recursiveSubAccounts(query: $query, sub_accounts_and_sub_divisions: $sub_divisions, columns: $columns);
        } else if ($query instanceof \Illuminate\Database\Eloquent\Relations\Relation || $query instanceof \Illuminate\Database\Eloquent\Builder) {

            if ($query->getModel() instanceof SubAccount) {
                if ($query->whereHas("sub_divisions")) {
                    return $this->recursiveSubAccounts(query: $query->whereHas("sub_divisions"), sub_accounts_and_sub_divisions: $sub_divisions, columns: $columns);
                }
            }
        }

        return $sub_divisions;
    }


    /**
     * @param \Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Builder|null $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function sub_accounts_and_sub_divisions($query = null, $withSubDivision = true, array $columns = ["*"]): \Illuminate\Database\Eloquent\Collection
    {
        $sub_accounts_and_sub_divisions = new \Illuminate\Database\Eloquent\Collection(); // Create an empty Eloquent collection

        $query = $query ?? $this->accounts();

        if ($query instanceof \Illuminate\Database\Eloquent\Relations\Relation || $query instanceof \Illuminate\Database\Eloquent\Builder) {
            $query = $query->get();
        }

        if ($query instanceof \Illuminate\Database\Eloquent\Collection || $query instanceof \Illuminate\Database\Eloquent\Collection) {

            $query->each(function ($account) use (&$sub_accounts_and_sub_divisions, $withSubDivision, $columns) {

                if ($account->sous_comptes) {

                    // Concatenate each sub division to the $sub_divisions collection
                    $sub_accounts_and_sub_divisions = $sub_accounts_and_sub_divisions->concat($account->sous_comptes()->select($columns)->get());

                    if ($withSubDivision) {
                        if ($account->sous_comptes()->whereHas("sub_divisions")->count()) {
                            $sub_accounts_and_sub_divisions = $this->recursiveSubAccounts(query: $account->sous_comptes()->whereHas("sub_divisions"), sub_accounts_and_sub_divisions: $sub_accounts_and_sub_divisions, columns: $columns);
                        }
                    }
                }
            });
        }

        return $sub_accounts_and_sub_divisions;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Builder|null $query
     */
    protected function recursiveSubAccounts($query, $sub_accounts_and_sub_divisions, array $columns = ["*"])
    {
        if ($query instanceof \Illuminate\Database\Eloquent\Collection) {
            $query = $query;
        } else if ($query instanceof \Illuminate\Database\Eloquent\Relations\Relation || $query instanceof \Illuminate\Database\Eloquent\Builder) {
            $query = $query->get();
        }

        if ($query instanceof \Illuminate\Database\Eloquent\Collection) {
            $query->each(function ($sub_account) use (&$sub_accounts_and_sub_divisions, $columns) {

                if ($sub_account->sub_divisions) {

                    // Concatenate each sub division to the $sub_divisions collection
                    $sub_accounts_and_sub_divisions = $sub_accounts_and_sub_divisions->concat($sub_account->sub_divisions()->select($columns)->get());

                    if ($sub_account->sub_divisions()->whereHas("sub_divisions")->count()) {
                        $sub_accounts_and_sub_divisions = $this->recursiveSubAccounts(query: $sub_account->sub_divisions()->whereHas("sub_divisions"), sub_accounts_and_sub_divisions: $sub_accounts_and_sub_divisions, columns: $columns);
                    }
                }
            });
        }

        return $sub_accounts_and_sub_divisions;
    }



    /**
     * @param string $accountNumber
     * @param \Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|null $query
     * 
     * @return mixed
     */
    public function findAccountOrSubAccount(string $accountNumber, $query = null, $columns = ["*"])
    {
        if (strlen($accountNumber) < 2) throw new ApplicationException("Veuillez soumettre un numero de compte invalid", 1);

        if (strlen($accountNumber) === 2) {
            $query = $query ?? $this->accounts();

            return $query->whereNull('deleted_at')
                ->select($columns)
                ->where('account_number', '=', $accountNumber)->first();
        } else {
            $query = $query ?? $this->sub_accounts_and_sub_divisions(columns: $columns);
            return $query->whereNull('deleted_at')
                ->where('account_number', '=', $accountNumber)->first();
        }

        return null;
    }

    /**
     * 
     *
     * @return HasMany
     */
    public function exercices_comptable(): HasMany
    {
        return $this->hasMany(ExerciceComptable::class, 'plan_comptable_id');
    }

    private function generateCode(string $name)
    {

        // Retrieve the first letter of the plan's name
        $firstLetter = strtoupper(substr($name, 0, 1));

        // Generate a unique code using the first letter and a random string
        $uniqueCode = 'PL_' . $firstLetter . '_' . Str::random(6);

        // Check if the generated code already exists in the database
        if ($this->where('code', $uniqueCode)->exists()) {
            $this->generateCode($name);
        }

        return $uniqueCode;
    }

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (PlanComptable $model) {
            $model->code = $model->generateCode($model->name);
        });
    }

    public function scopeFindAccount(Builder $query, string $accountNumber)
    {
        if (strlen($accountNumber) === 1) {
            $this->accounts()->where('account_number', $accountNumber);
        } else {
            $this->sub_accounts()->where('account_number', $accountNumber);
        }
    }


    /**
     */
    public function scopeAccountsBalance(Builder $query, string $exercice_comptable_id)
    {
        return $query->whereHas("accounts", function ($query) use ($exercice_comptable_id) {
            $query->transactions($exercice_comptable_id);
        });
    }

}
