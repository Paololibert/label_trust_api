<?php

declare(strict_types=1);

namespace App\Models;

use Core\Data\Eloquent\Casts\PhoneNumberCast;
use Core\Data\Eloquent\Contract\ModelContract;
use Core\Data\Eloquent\ORMs\HasRoles;
use Core\Utils\Enums\Users\TypeOfAccountEnum;
use Core\Utils\Enums\Users\UserAccountStatus;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

/**
 * Class ***`User`***
 *
 * This model represents the `users` table in the database.
 * It extends the ModelContract class and provides access to the database table associated with the model.
 *
 * @property  string    $name;
 * @property  string    $slug;
 * @property  string    $key;
 * @property  string    $description;
 *
 * @package ***`\App\Models`***
 */
/**
 * Class ***`User`***
 *
 * This model represents user accounts in the application, providing authentication and authorization features.
 * It extends the base `ModelContract` class, providing access to the underlying database table associated with the model.
 *
 * @property string             $type_of_account            - The type_of_account of the user.
 * @property string             $username                   - The username of the user.
 * @property string             $userable_type              - The type of associated user details (polymorphic relation).
 * @property string             $userable_id                - The ID of associated user details (polymorphic relation).
 * @property string             $phone_number               - The phone number of the person.
 * @property string             $email                      - The email address of the person.
 * @property string             $address                    - The address of the company.
 * @property UserAccountStatus  $account_status             - The account status of the user (enum).
 * @property bool               $can_be_delete              - Indicates if the user account can be deleted.
 * @property bool               $email_verified             - Indicates if the user's email has been verified.
 * @property \DateTime|null     $email_verified_at          - The timestamp when the email was verified.
 * @property bool               $account_activated          - Indicates if the user account has been activated.
 * @property \DateTime|null     $account_activated_at       - The timestamp when the account was activated.
 * @property bool               $account_verified           - Indicates if the user account has been verified.
 * @property \DateTime|null     $account_verified_at        - The timestamp when the account was verified.
 * @property string|null        $email_verification_token   - The token used for email verification.
 *
 * @package ***`App\Models`***
 */
class User extends ModelContract implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable, HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    public $guarded = [
        'userable_type',
        'userable_id',
        'account_status',
        'userable_type', 'userable_id',
        'profilable_type', 'profilable_id',
        'email_verified', 'email_verified_at',
        'account_verified', 'account_verified_at',
        'account_activated', 'account_activated_at',
    ];// 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_of_account',
        'username',
        'phone_number',
        'email',
        'address'
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'email_verified_at',
        'account_activated_at',
        'account_verified_at'
    ];

    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'type_of_account'          => TypeOfAccountEnum::DEFAULT,
        'email'                    => NULL,
        'account_status'           => UserAccountStatus::DEFAULT,
        'can_be_delete'            => true,
        'email_verified'           => false,
        'email_verified_at'        => NULL,
        'account_activated'        => false,
        'account_activated_at'     => NULL,
        'account_verified'         => false,
        'account_verified_at'      => NULL,
        'email_verification_token' => NULL,
        'address'                  => NULL
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'type_of_account',
        'email',
        'account_status',
        'userable_type', 'userable_id',
        'email_verified', 'email_verified_at',
        'account_verified', 'account_verified_at',
        'account_activated', 'account_activated_at',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'username',
        'phone_number',
        'email',
        'address',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type_of_account'           => TypeOfAccountEnum::class,
        'username'                  => 'string',
        'userable_type'             => 'string',
        'userable_id'               => 'string',
        'profilable_type'           => 'string',
        'profilable_id'             => 'string',
        'phone_number'              => PhoneNumberCast::class,
        'email'                     => 'string',
        'address'                   => 'string',
        'account_status'            => UserAccountStatus::class,
        'email_verified_at'         => 'datetime:Y-m-d H:i:s',
        'email_verified'            => 'boolean',
        'account_activated_at'      => 'datetime:Y-m-d H:i:s',
        'account_activated'         => 'boolean',
        'account_verified_at'       => 'datetime:Y-m-d H:i:s',
        'account_verified'          => 'boolean',
        'email_verification_token'  => 'string',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'userable'
    ];

    public function getUnmodifiableAttributes() {
        return [
            "email"
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();
        static::observe(\App\Observers\UserObserver::class);
    }

    /**
     * Get the user who created the credential.
     *
     * @return HasOne|null
     */
    public function credential(): ?HasOne
    {
        return $this->hasOne(Credential::class, 'user_id');
    }

    /**
     * Get the user who created the credential.
     *
     * @return HasMany|null
     */
    public function credentials(): HasMany
    {
        return $this->hasMany(Credential::class, 'user_id');
    }
    
    /**
     * Get the user details.
     *
     * @return MorphTo
     */
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Get the profil details.
     *
     * @return MorphTo
     */
    public function profilable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Interact with the user's last name.
     * 
     * @return Attribute
     */
    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value,
            set: fn (string $value) => $this->manageUsername($value)
        );
    }

    private function manageUsername(string $value)
    {
        // Remove special characters (except dot) and trim whitespace
        $baseUsername = strtolower(trim(preg_replace('/[^a-zA-Z0-9.]/', '', $value)));
        $username = $baseUsername;
        $suffix = 1;
    
        while (!$this->isUnique("username", $username)) {
            $username = $baseUsername . $suffix;
            $suffix++;
        }

        return strtolower($username);
    }
}
