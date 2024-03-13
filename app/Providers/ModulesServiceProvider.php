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

        // Binds the implementation of DeviseRESTfulReadWriteServiceContract to the DeviseRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\Devises\Services\RESTful\Contracts\DeviseRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for DeviseRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of DeviseRESTfulReadWriteService
                return new \Domains\Finances\Devises\Services\RESTful\DeviseRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of DeviseRESTfulQueryServiceContract to the DeviseRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\Devises\Services\RESTful\Contracts\DeviseRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for DeviseRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of DeviseRESTfulQueryService
                return new \Domains\Finances\Devises\Services\RESTful\DeviseRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of CategorieDeCompteRESTfulReadWriteServiceContract to the CategorieDeCompteRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\CategoriesDeCompte\Services\RESTful\Contracts\CategorieDeCompteRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CategorieDeCompteRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of CategorieDeCompteRESTfulReadWriteService
                return new \Domains\Finances\CategoriesDeCompte\Services\RESTful\CategorieDeCompteRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of CategorieDeCompteRESTfulQueryServiceContract to the CategorieDeCompteRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\CategoriesDeCompte\Services\RESTful\Contracts\CategorieDeCompteRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CategorieDeCompteRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of CategorieDeCompteRESTfulQueryService
                return new \Domains\Finances\CategoriesDeCompte\Services\RESTful\CategorieDeCompteRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of ClasseDeCompteRESTfulReadWriteServiceContract to the ClasseDeCompteRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\ClassesDeCompte\Services\RESTful\Contracts\ClasseDeCompteRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ClasseDeCompteRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of ClasseDeCompteRESTfulReadWriteService
                return new \Domains\Finances\ClassesDeCompte\Services\RESTful\ClasseDeCompteRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of ClasseDeCompteRESTfulQueryServiceContract to the ClasseDeCompteRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\ClassesDeCompte\Services\RESTful\Contracts\ClasseDeCompteRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ClasseDeCompteRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of ClasseDeCompteRESTfulQueryService
                return new \Domains\Finances\ClassesDeCompte\Services\RESTful\ClasseDeCompteRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of PeriodeExerciceRESTfulReadWriteServiceContract to the PeriodeExerciceRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\PeriodesExercice\Services\RESTful\Contracts\PeriodeExerciceRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PeriodeExerciceRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of PeriodeExerciceRESTfulReadWriteService
                return new \Domains\Finances\PeriodesExercice\Services\RESTful\PeriodeExerciceRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of PeriodeExerciceRESTfulQueryServiceContract to the PeriodeExerciceRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\PeriodesExercice\Services\RESTful\Contracts\PeriodeExerciceRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PeriodeExerciceRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of PeriodeExerciceRESTfulQueryService
                return new \Domains\Finances\PeriodesExercice\Services\RESTful\PeriodeExerciceRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of PlanComptableRESTfulReadWriteServiceContract to the PlanComptableRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PlanComptableRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of PlanComptableRESTfulReadWriteService
                return new \Domains\Finances\PlansComptable\Services\RESTful\PlanComptableRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of PlanComptableRESTfulQueryServiceContract to the PlanComptableRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PlanComptableRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of PlanComptableRESTfulQueryService
                return new \Domains\Finances\PlansComptable\Services\RESTful\PlanComptableRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of CompteRESTfulReadWriteServiceContract to the CompteRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\Comptes\Services\RESTful\Contracts\CompteRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CompteRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of CompteRESTfulReadWriteService
                return new \Domains\Finances\Comptes\Services\RESTful\CompteRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of CompteRESTfulQueryServiceContract to the CompteRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\Comptes\Services\RESTful\Contracts\CompteRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CompteRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of CompteRESTfulQueryService
                return new \Domains\Finances\Comptes\Services\RESTful\CompteRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of JournalRESTfulReadWriteServiceContract to the JournalRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\Journaux\Services\RESTful\Contracts\JournalRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for JournalRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of JournalRESTfulReadWriteService
                return new \Domains\Finances\Journaux\Services\RESTful\JournalRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of JournalRESTfulQueryServiceContract to the JournalRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\Journaux\Services\RESTful\Contracts\JournalRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for JournalRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of JournalRESTfulQueryService
                return new \Domains\Finances\Journaux\Services\RESTful\JournalRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of ExerciceComptableRESTfulReadWriteServiceContract to the ExerciceComptableRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ExerciceComptableRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of ExerciceComptableRESTfulReadWriteService
                return new \Domains\Finances\ExercicesComptable\Services\RESTful\ExerciceComptableRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of ExerciceComptableRESTfulQueryServiceContract to the ExerciceComptableRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ExerciceComptableRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of ExerciceComptableRESTfulQueryService
                return new \Domains\Finances\ExercicesComptable\Services\RESTful\ExerciceComptableRESTfulQueryService($queryService);
            }
        );


        // Binds the implementation of EcritureComptableRESTfulReadWriteServiceContract to the EcritureComptableRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EcritureComptableRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of EcritureComptableRESTfulReadWriteService
                return new \Domains\Finances\EcrituresComptable\Services\RESTful\EcritureComptableRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of EcritureComptableRESTfulQueryServiceContract to the EcritureComptableRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for EcritureComptableRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of EcritureComptableRESTfulQueryService
                return new \Domains\Finances\EcrituresComptable\Services\RESTful\EcritureComptableRESTfulQueryService($queryService);
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
