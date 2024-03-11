<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind ReadWriteRepositoryInterface to PermissionReadWriteRepository
        $this->app->when(\Domains\Permissions\Services\RESTful\PermissionRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Permissions\Repositories\PermissionReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to PermissionReadOnlyRepository
        $this->app->when(\Domains\Permissions\Services\RESTful\PermissionRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Permissions\Repositories\PermissionReadOnlyRepository::class);

    
        // Bind ReadWriteRepositoryInterface to RoleReadWriteRepository
        $this->app->when(\Domains\Roles\Services\RESTful\RoleRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Roles\Repositories\RoleReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to RoleReadOnlyRepository
        $this->app->when(\Domains\Roles\Services\RESTful\RoleRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Roles\Repositories\RoleReadOnlyRepository::class);

    
        // Bind ReadWriteRepositoryInterface to PersonReadWriteRepository
        $this->app->when(\Domains\Users\People\Services\RESTful\PersonRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Users\People\Repositories\PersonReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to PersonReadOnlyRepository
        $this->app->when(\Domains\Users\People\Services\RESTful\PersonRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Users\People\Repositories\PersonReadOnlyRepository::class);

    
        // Bind ReadWriteRepositoryInterface to CompanyReadWriteRepository
        $this->app->when(\Domains\Users\Companies\Services\RESTful\CompanyRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Users\Companies\Repositories\CompanyReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to CompanyReadOnlyRepository
        $this->app->when(\Domains\Users\Companies\Services\RESTful\CompanyRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Users\Companies\Repositories\CompanyReadOnlyRepository::class);

    
        // Bind ReadWriteRepositoryInterface to UserReadWriteRepository
        $this->app->when(\Domains\Users\Services\RESTful\UserRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Users\Repositories\UserReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to UserReadOnlyRepository
        $this->app->when(\Domains\Users\Services\RESTful\UserRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Users\Repositories\UserReadOnlyRepository::class);


    
        // Bind ReadWriteRepositoryInterface to UniteMesureReadWriteRepository
        $this->app->when(\Domains\UniteMesures\Services\RESTful\UniteMesureRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\UniteMesures\Repositories\UniteMesureReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to UniteMesureReadOnlyRepository
        $this->app->when(\Domains\UniteMesures\Services\RESTful\UniteMesureRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\UniteMesures\Repositories\UniteMesureReadOnlyRepository::class);

    
        // Bind ReadWriteRepositoryInterface to DepartementReadWriteRepository
        $this->app->when(\Domains\Departements\Services\RESTful\DepartementRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Departements\Repositories\DepartementReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to DepartementReadOnlyRepository
        $this->app->when(\Domains\Departements\Services\RESTful\DepartementRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Departements\Repositories\DepartementReadOnlyRepository::class);

    
        // Bind ReadWriteRepositoryInterface to PosteReadWriteRepository
        $this->app->when(\Domains\Postes\Services\RESTful\PosteRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Postes\Repositories\PosteReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to PosteReadOnlyRepository
        $this->app->when(\Domains\Postes\Services\RESTful\PosteRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Postes\Repositories\PosteReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to UniteTravailleReadWriteRepository
        $this->app->when(\Domains\UniteTravailles\Services\RESTful\UniteTravailleRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\UniteTravailles\Repositories\UniteTravailleReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to UniteTravailleReadOnlyRepository
        $this->app->when(\Domains\UniteTravailles\Services\RESTful\UniteTravailleRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\UniteTravailles\Repositories\UniteTravailleReadOnlyRepository::class);


        // Bind ReadWriteRepositoryInterface to CategoryOfEmployeeReadWriteRepository
        $this->app->when(\Domains\CategoriesOfEmployees\Services\RESTful\CategoryOfEmployeeRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\CategoriesOfEmployees\Repositories\CategoryOfEmployeeReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to CategoryOfEmployeeReadOnlyRepository
        $this->app->when(\Domains\CategoriesOfEmployees\Services\RESTful\CategoryOfEmployeeRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\CategoriesOfEmployees\Repositories\CategoryOfEmployeeReadOnlyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
