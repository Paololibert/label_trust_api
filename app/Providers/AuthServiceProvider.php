<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Permission;
use Core\Utils\Exceptions\ApplicationException;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Throwable;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    public function register(): void {
        Passport::ignoreMigrations();
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();


        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    dd($user);
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (Throwable $exception) {
            throw new ApplicationException(previous: $exception);
            
            report($exception);
        }

        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
