<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Contract\ModelContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * Class ***`Credential`***
 *
 * This model represents the `credentials` table in the database, storing user credentials such as identifiers and passwords.
 * It extends the base `ModelContract` class, providing access to the underlying database table associated with the model.
 *
 * @property string $identifier - The identifier associated with the credential.
 * @property string $password   - The hashed password stored in the credential.
 *
 * @package ***`App\Models`***
 */
class Credential extends ModelContract implements AuthenticatableContract
{
    use Authenticatable, Notifiable, HasApiTokens;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'credentials';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    public $guarded = [
        'password', 'identifier'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identifier',
        'password',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'identifier'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'identifier'       => 'string',
        'password'         => 'hashed',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the user who created the credential.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Set the user of the credential.
     *
     * @param User|null $user
     * @return void
     */
    public function setCreator(?User $user): void
    {
        if ($user){
            $this->user()->associate($user);
        }
    }

    /**
     * Find the user instance for the given identifier.
     *
     * @param  string  $identifier
     * @return \App\Models\Credential
     */
    public function findForPassport($identifier)
    {
        return $this->where('identifier', $identifier)->first();
    }
}