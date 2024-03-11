<?php

namespace App\Models\Oauths;

use Core\Data\Eloquent\Contract\ModelContract;

class OauthPersonalAccessClient extends ModelContract
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
    protected $table = 'oauth_personal_access_clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'client_id'    => 'string'
    ];

    public function authorable(): ?string
    {
        return null;
    }
}
