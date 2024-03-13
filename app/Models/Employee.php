<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Core\Utils\Enums\StatutEmployeeEnum;
use Core\Utils\Enums\TypeEmployeeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class ***`Employee`***
 *
 * This model represents the `employees` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 *
 * @package ***`\App\Models`***
 */
class Employee extends ModelContract
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matricule','type_employee','statut_employee'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type_employee'          => TypeEmployeeEnum::DEFAULT,
        'statut_employee'           => StatutEmployeeEnum::DEFAULT,
    ];


    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'matricule',
        'type_employee'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'matricule'             => 'string',
        'type_employee'         => TypeEmployeeEnum::class,
        'statut_employee'       => StatutEmployeeEnum::class,
    ];
    

    /**
     * Get the profil details.
     *
     * @return MorphTo
     */
    public function contractual(): MorphTo
    {
        return $this->morphTo();
    }
    
    
    /**
     * Get the user's full name attribute.
     *
     * @return string The user's full name.
     */
    public function getUserNameAttribute(): string
    {
        return $this->user->name ;
    }
    
    /**
     * Get the Unit mesure of the unitTravaille.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Interact with the Employee's name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }

}