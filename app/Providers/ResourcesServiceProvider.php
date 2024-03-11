<?php

namespace App\Providers;

use App\Http\Requests\Roles\v1\CreateRoleRequest;
use App\Http\Requests\Roles\v1\UpdateRoleRequest;
use App\Http\Requests\Users\v1\CreateUserRequest;
use App\Http\Requests\Users\v1\UpdateUserRequest;
use Core\Utils\Requests\CreateResourceRequest;
use Core\Utils\Requests\UpdateResourceRequest;
use Illuminate\Support\ServiceProvider;

class ResourcesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind ReadOnlyRepositoryInterface to PermissionReadOnlyRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\PermissionController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface::class
            )
            ->give(\Domains\Permissions\Repositories\PermissionReadOnlyRepository::class);

        
        // Bind ReadOnlyRepositoryInterface to RoleReadOnlyRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\RoleController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface::class
            )
            ->give(\Domains\Roles\Repositories\RoleReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to RoleReadWriteRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\RoleController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Roles\Repositories\RoleReadWriteRepository::class);

        // Bind ReadOnlyRepositoryInterface to UserReadOnlyRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\UserController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface::class
            )
            ->give(\Domains\Users\Repositories\UserReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to UserReadWriteRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\UserController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Users\Repositories\UserReadWriteRepository::class);

        

        // Bind ReadOnlyRepositoryInterface to DepartementReadOnlyRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\DepartementController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface::class
            )
            ->give(\Domains\Departements\Repositories\DepartementReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to DepartementReadWriteRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\DepartementController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Departements\Repositories\DepartementReadWriteRepository::class);

        
        // Bind ReadOnlyRepositoryInterface to PosteReadOnlyRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\PosteController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface::class
            )
            ->give(\Domains\Postes\Repositories\PosteReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to PosteReadWriteRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\PosteController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Postes\Repositories\PosteReadWriteRepository::class);

        
        // Bind ReadOnlyRepositoryInterface to UniteMesureReadOnlyRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\UniteMesureController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface::class
            )
            ->give(\Domains\UniteMesures\Repositories\UniteMesureReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to UniteMesureReadWriteRepository
        $this->app->when(\App\Http\Controllers\API\RESTful\V1\UniteMesureController::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\UniteMesures\Repositories\UniteMesureReadWriteRepository::class);

        
            // Bind ReadOnlyRepositoryInterface to UniteTravailleReadOnlyRepository
            $this->app->when(\App\Http\Controllers\API\RESTful\V1\UniteTravailleController::class)
                ->needs(
                    \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface::class
                )
                ->give(\Domains\UniteTravailles\Repositories\UniteTravailleReadOnlyRepository::class);

            // Bind ReadWriteRepositoryInterface to UniteTravailleReadWriteRepository
            $this->app->when(\App\Http\Controllers\API\RESTful\V1\UniteTravailleController::class)
                ->needs(
                    \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
                )
                ->give(\Domains\UniteTravailles\Repositories\UniteTravailleReadWriteRepository::class);

            
        
            // Bind ReadOnlyRepositoryInterface to CategoryOfEmployeeReadOnlyRepository
            $this->app->when(\App\Http\Controllers\API\RESTful\V1\CategoryOfEmployeeController::class)
                ->needs(
                    \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface::class
                )
                ->give(\Domains\CategoriesOfEmployees\Repositories\CategoryOfEmployeeReadOnlyRepository::class);

            // Bind ReadWriteRepositoryInterface to CategoryOfEmployeeReadWriteRepository
            $this->app->when(\App\Http\Controllers\API\RESTful\V1\CategoryOfEmployeeController::class)
                ->needs(
                    \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
                )
                ->give(\Domains\CategoriesOfEmployees\Repositories\CategoryOfEmployeeReadWriteRepository::class);
        }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
