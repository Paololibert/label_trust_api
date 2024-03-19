<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Binds the implementation of PermissionRESTfulReadWriteServiceContract to the PermissionRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Permissions\Services\RESTful\Contracts\PermissionRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PermissionRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);
                
                // Create and return an instance of PermissionRESTfulReadWriteService
                return new \Domains\Permissions\Services\RESTful\PermissionRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of PermissionRESTfulQueryServiceContract to the PermissionRESTfulQueryService class.
        $this->app->bind(
            \Domains\Permissions\Services\RESTful\Contracts\PermissionRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by PermissionRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);
 
                // Create and return an instance of PermissionRESTfulQueryService
                return new \Domains\Permissions\Services\RESTful\PermissionRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of RoleRESTfulReadWriteServiceContract to the RoleRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Roles\Services\RESTful\Contracts\RoleRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for RoleRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);
                
                // Create and return an instance of RoleRESTfulReadWriteService
                return new \Domains\Roles\Services\RESTful\RoleRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of RoleRESTfulQueryServiceContract to the RoleRESTfulQueryService class.
        $this->app->bind(
            \Domains\Roles\Services\RESTful\Contracts\RoleRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by RoleRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);
 
                // Create and return an instance of RoleRESTfulQueryService
                return new \Domains\Roles\Services\RESTful\RoleRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of PersonRESTfulReadWriteServiceContract to the PersonRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Users\People\Services\RESTful\Contracts\PersonRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PersonRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);
                
                // Create and return an instance of PersonRESTfulReadWriteService
                return new \Domains\Users\People\Services\RESTful\PersonRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of PersonRESTfulQueryServiceContract to the PersonRESTfulQueryService class.
        $this->app->bind(
            \Domains\Users\People\Services\RESTful\Contracts\PersonRESTfulQueryServiceContract::class,
            function ($app) {

                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);
 
                // Create and return an instance of PersonRESTfulQueryService
                return new \Domains\Users\People\Services\RESTful\PersonRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of CompanyRESTfulReadWriteServiceContract to the CompanyRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Users\Companies\Services\RESTful\Contracts\CompanyRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CompanyRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);
                
                // Create and return an instance of CompanyRESTfulReadWriteService
                return new \Domains\Users\Companies\Services\RESTful\CompanyRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of CompanyRESTfulQueryServiceContract to the CompanyRESTfulQueryService class.
        $this->app->bind(
            \Domains\Users\Companies\Services\RESTful\Contracts\CompanyRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CompanyRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);
 
                // Create and return an instance of CompanyRESTfulQueryService
                return new \Domains\Users\Companies\Services\RESTful\CompanyRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of UserRESTfulReadWriteServiceContract to the UserRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Users\Services\RESTful\Contracts\UserRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for UserRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of UserRESTfulReadWriteService
                return new \Domains\Users\Services\RESTful\UserRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of UserRESTfulQueryServiceContract to the UserRESTfulQueryService class.
        $this->app->bind(
            \Domains\Users\Services\RESTful\Contracts\UserRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for UserRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of UserRESTfulQueryService
                return new \Domains\Users\Services\RESTful\UserRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of UniteMesureRESTfulReadWriteServiceContract to the UniteMesureRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\UniteMesures\Services\RESTful\Contracts\UniteMesureRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for UniteMesureRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of UniteMesureRESTfulReadWriteService
                return new \Domains\UniteMesures\Services\RESTful\UniteMesureRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of UniteMesureRESTfulQueryServiceContract to the UniteMesureRESTfulQueryService class.
        $this->app->bind(
            \Domains\UniteMesures\Services\RESTful\Contracts\UniteMesureRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for UniteMesureRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of UniteMesureRESTfulQueryService
                return new \Domains\UniteMesures\Services\RESTful\UniteMesureRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of DepartementRESTfulReadWriteServiceContract to the DepartementRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Departements\Services\RESTful\Contracts\DepartementRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for DepartementRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of DepartementRESTfulReadWriteService
                return new \Domains\Departements\Services\RESTful\DepartementRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of DepartementRESTfulQueryServiceContract to the DepartementRESTfulQueryService class.
        $this->app->bind(
            \Domains\Departements\Services\RESTful\Contracts\DepartementRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for DepartementRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of DepartementRESTfulQueryService
                return new \Domains\Departements\Services\RESTful\DepartementRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of PosteRESTfulReadWriteServiceContract to the PosteRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Postes\Services\RESTful\Contracts\PosteRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PosteRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of PosteRESTfulReadWriteService
                return new \Domains\Postes\Services\RESTful\PosteRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of PosteRESTfulQueryServiceContract to the PosteRESTfulQueryService class.
        $this->app->bind(
            \Domains\Postes\Services\RESTful\Contracts\PosteRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PosteRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of PosteRESTfulQueryService
                return new \Domains\Postes\Services\RESTful\PosteRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of UniteTravailleRESTfulReadWriteServiceContract to the UniteTravailleRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\UniteTravailles\Services\RESTful\Contracts\UniteTravailleRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for UniteTravailleRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of UniteTravailleRESTfulReadWriteService
                return new \Domains\UniteTravailles\Services\RESTful\UniteTravailleRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of UniteTravailleRESTfulQueryServiceContract to the UniteTravailleRESTfulQueryService class.
        $this->app->bind(
            \Domains\UniteTravailles\Services\RESTful\Contracts\UniteTravailleRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for UniteTravailleRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of UniteTravailleRESTfulQueryService
                return new \Domains\UniteTravailles\Services\RESTful\UniteTravailleRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of CategoryOfEmployeeRESTfulReadWriteServiceContract to the CategoryOfEmployeeRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\CategoriesOfEmployees\Services\RESTful\Contracts\CategoryOfEmployeeRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CategoryOfEmployeeRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of CategoryOfEmployeeRESTfulReadWriteService
                return new \Domains\CategoriesOfEmployees\Services\RESTful\CategoryOfEmployeeRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of CategoryOfEmployeeRESTfulQueryServiceContract to the CategoryOfEmployeeRESTfulQueryService class.
        $this->app->bind(
            \Domains\CategoriesOfEmployees\Services\RESTful\Contracts\CategoryOfEmployeeRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CategoryOfEmployeeRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of CategoryOfEmployeeRESTfulQueryService
                return new \Domains\CategoriesOfEmployees\Services\RESTful\CategoryOfEmployeeRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of EmployeeRESTfulReadWriteServiceContract to the EmployeeRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Employees\Services\RESTful\Contracts\EmployeeRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EmployeeRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of EmployeeRESTfulReadWriteService
                return new \Domains\Employees\Services\RESTful\EmployeeRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of EmployeeRESTfulQueryServiceContract to the EmployeeRESTfulQueryService class.
        $this->app->bind(
            \Domains\Employees\Services\RESTful\Contracts\EmployeeRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EmployeeRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of EmployeeRESTfulQueryService
                return new \Domains\Employees\Services\RESTful\EmployeeRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of EmployeeContractuelRESTfulReadWriteServiceContract to the EmployeeContractuelRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EmployeeRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of EmployeeContractuelRESTfulReadWriteService
                return new \Domains\Employees\EmployeeContractuels\Services\RESTful\EmployeeContractuelRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of EmployeeContractuelRESTfulQueryServiceContract to the EmployeeContractuelRESTfulQueryService class.
        $this->app->bind(
            \Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EmployeeContractuelRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of EmployeeContractuelRESTfulQueryService
                return new \Domains\Employees\EmployeeContractuels\Services\RESTful\EmployeeContractuelRESTfulQueryService($queryService);
            }
        );
        
        // Binds the implementation of EmployeeNonContractuelRESTfulReadWriteServiceContract to the EmployeeNonContractuelRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EmployeeRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of EmployeeContractuelRESTfulReadWriteService
                return new \Domains\Employees\EmployeeNonContractuels\Services\RESTful\EmployeeNonContractuelRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of EmployeeNonContractuelRESTfulQueryServiceContract to the EmployeeNonContractuelRESTfulQueryService class.
        $this->app->bind(
            \Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EmployeeNonContractuelRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of EmployeeNonContractuelRESTfulQueryService
                return new \Domains\Employees\EmployeeNonContractuels\Services\RESTful\EmployeeNonContractuelRESTfulQueryService($queryService);
            }
        );
        
        // Binds the implementation of ContractRESTfulReadWriteServiceContract to the ContractRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Contrats\Services\RESTful\Contracts\ContractRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ContractRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of ContractRESTfulReadWriteService
                return new \Domains\Contrats\Services\RESTful\ContractRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of ContractRESTfulQueryServiceContract to the ContractRESTfulQueryService class.
        $this->app->bind(
            \Domains\Contrats\Services\RESTful\Contracts\ContractRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ContractRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of ContractRESTfulQueryService
                return new \Domains\Contrats\Services\RESTful\ContractRESTfulQueryService($queryService);
            }
        );
        
        // Binds the implementation of EmployeeContractuelRESTfulReadWriteServiceContract to the EmployeeContractuelRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EmployeeContractuelRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of ContractRESTfulReadWriteService
                return new \Domains\Employees\EmployeeContractuels\Services\RESTful\EmployeeContractuelRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of ContractRESTfulQueryServiceContract to the ContractRESTfulQueryService class.
        $this->app->bind(
            \Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ContractRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of ContractRESTfulQueryService
                return new \Domains\Employees\EmployeeContractuels\Services\RESTful\EmployeeContractuelRESTfulQueryService($queryService);
            }
        );

        
        // Binds the implementation of EmployeeNonContractuelRESTfulReadWriteServiceContract to the EmployeeNonContractuelRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EmployeeNonContractuelRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of ContractRESTfulReadWriteService
                return new \Domains\Employees\EmployeeNonContractuels\Services\RESTful\EmployeeNonContractuelRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of ContractRESTfulQueryServiceContract to the ContractRESTfulQueryService class.
        $this->app->bind(
            \Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ContractRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of ContractRESTfulQueryService
                return new \Domains\Employees\EmployeeNonContractuels\Services\RESTful\EmployeeNonContractuelRESTfulQueryService($queryService);
            }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
