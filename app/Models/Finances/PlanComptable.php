<?php

declare(strict_types=1);

namespace App\Models\Finances;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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
        'code', 'name', 'description',
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
        'description'  => 'string'
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
     * 
     *
     * @return HasMany
     */
    public function exercices_comptable(): HasMany
    {
        return $this->hasMany(ExerciceComptable::class, 'plan_comptable_id');
    }

    private function generateCode(string $name){

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
}