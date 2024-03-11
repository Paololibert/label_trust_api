<?php

namespace App\Models\Oauths;

use Core\Data\Eloquent\Contract\ModelContract;

class OauthAuthCode extends ModelContract
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
    protected $table = 'oauth_auth_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'client_id', 'scopes', 'revoked', 'expires_at', 'password_client', 'revoked' 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id'    => 'string',
        'name'    => 'string',
        'secret'    => 'string',
        'provider'    => 'string',
        'personal_access_client'    => 'boolean',
        'password_client'    => 'boolean',
        'revoked'    => 'boolean'
    ];

    public function authorable(): ?string
    {
        return null;
    }
}
