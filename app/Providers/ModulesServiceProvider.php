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
        // Binds the implementation of DeviseRESTfulReadWriteServiceContract to the DeviseRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\Devises\Services\RESTful\Contracts\DeviseRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for DeviseRESTfulReadWriteService
                 * Create and return an instance of DeviseRESTfulReadWriteService
                 */
                return new \Domains\Finances\Devises\Services\RESTful\DeviseRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\Devises\Repositories\DeviseReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of DeviseRESTfulQueryServiceContract to the DeviseRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\Devises\Services\RESTful\Contracts\DeviseRESTfulQueryServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for DeviseRESTfulQueryService
                 * Create and return an instance of DeviseRESTfulQueryService
                 */
                return new \Domains\Finances\Devises\Services\RESTful\DeviseRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        $app->make( \Domains\Finances\Devises\Repositories\DeviseReadOnlyRepository::class)
                    )
                );
            }
        );


        // Binds the implementation of CategorieDeCompteRESTfulReadWriteServiceContract to the CategorieDeCompteRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\CategoriesDeCompte\Services\RESTful\Contracts\CategorieDeCompteRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for CategorieDeCompteRESTfulReadWriteService
                 * Create and return an instance of CategorieDeCompteRESTfulReadWriteService
                 */
                return new \Domains\Finances\CategoriesDeCompte\Services\RESTful\CategorieDeCompteRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\CategoriesDeCompte\Repositories\CategorieDeCompteReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of CategorieDeCompteRESTfulQueryServiceContract to the CategorieDeCompteRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\CategoriesDeCompte\Services\RESTful\Contracts\CategorieDeCompteRESTfulQueryServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for ClasseDeCompteRESTfulQueryService
                 * Create and return an instance of ClasseDeCompteRESTfulQueryService
                 */
                return new \Domains\Finances\CategoriesDeCompte\Services\RESTful\CategorieDeCompteRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        $app->make( \Domains\Finances\CategoriesDeCompte\Repositories\CategorieDeCompteReadOnlyRepository::class)
                    )
                );
            }
        );


        // Binds the implementation of ClasseDeCompteRESTfulReadWriteServiceContract to the ClasseDeCompteRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\ClassesDeCompte\Services\RESTful\Contracts\ClasseDeCompteRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for ClasseDeCompteRESTfulReadWriteService
                 * Create and return an instance of ClasseDeCompteRESTfulReadWriteService
                 */
                return new \Domains\Finances\ClassesDeCompte\Services\RESTful\ClasseDeCompteRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\ClassesDeCompte\Repositories\ClasseDeCompteReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of ClasseDeCompteRESTfulQueryServiceContract to the ClasseDeCompteRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\ClassesDeCompte\Services\RESTful\Contracts\ClasseDeCompteRESTfulQueryServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for ClasseDeCompteRESTfulQueryService
                 * Create and return an instance of ClasseDeCompteRESTfulQueryService
                 */
                return new \Domains\Finances\ClassesDeCompte\Services\RESTful\ClasseDeCompteRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        $app->make( \Domains\Finances\ClassesDeCompte\Repositories\ClasseDeCompteReadOnlyRepository::class)
                    )
                );
            }
        );


        // Binds the implementation of PeriodeExerciceRESTfulReadWriteServiceContract to the PeriodeExerciceRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\PeriodesExercice\Services\RESTful\Contracts\PeriodeExerciceRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for PeriodeExerciceRESTfulReadWriteService
                 * Create and return an instance of PeriodeExerciceRESTfulReadWriteService
                 */
                return new \Domains\Finances\PeriodesExercice\Services\RESTful\PeriodeExerciceRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\PeriodesExercice\Repositories\PeriodeExerciceReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of PeriodeExerciceRESTfulQueryServiceContract to the PeriodeExerciceRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\PeriodesExercice\Services\RESTful\Contracts\PeriodeExerciceRESTfulQueryServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for PeriodeExerciceRESTfulQueryService
                 * Create and return an instance of PeriodeExerciceRESTfulQueryService
                 */
                return new \Domains\Finances\PeriodesExercice\Services\RESTful\PeriodeExerciceRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        $app->make( \Domains\Finances\PeriodesExercice\Repositories\PeriodeExerciceReadOnlyRepository::class)
                    )
                );
            }
        );


        // Binds the implementation of PlanComptableRESTfulReadWriteServiceContract to the PlanComptableRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for PlanComptableRESTfulReadWriteService
                 * Create and return an instance of PlanComptableRESTfulReadWriteService
                 */
                return new \Domains\Finances\PlansComptable\Services\RESTful\PlanComptableRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\PlansComptable\Repositories\PlanComptableReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of PlanComptableRESTfulQueryServiceContract to the PlanComptableRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulQueryServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for PlanComptableRESTfulQueryService
                 * Create and return an instance of PlanComptableRESTfulQueryService
                 */
                return new \Domains\Finances\PlansComptable\Services\RESTful\PlanComptableRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        $app->make( \Domains\Finances\PlansComptable\Repositories\PlanComptableReadOnlyRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of AccountRESTfulReadWriteServiceContract to the AccountRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts\AccountRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for AccountRESTfulReadWriteService
                 * Create and return an instance of AccountRESTfulReadWriteService
                 */
                return new \Domains\Finances\PlansComptable\Accounts\Services\RESTful\AccountRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadWriteRepository::class)
                    )
                );

            }
        );

        // Binds the implementation of AccountRESTfulQueryServiceContract to the AccountRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts\AccountRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for AccountRESTfulQueryService
                return new \Domains\Finances\PlansComptable\Accounts\Services\RESTful\AccountRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        new \Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadOnlyRepository(new \App\Models\Finances\Account)
                    )
                );
            }
        );

        // Binds the implementation of SubAccountRESTfulReadWriteServiceContract to the SubAccountRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts\SubAccountRESTfulReadWriteServiceContract::class,
            function ($app) {
                return new \Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\SubAccountRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make(\Domains\Finances\PlansComptable\Accounts\SubAccounts\Repositories\SubAccountReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of SubAccountRESTfulQueryServiceContract to the SubAccountRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts\SubAccountRESTfulQueryServiceContract::class,
            function ($app) {
                // Create and return an instance of SubAccountRESTfulQueryService
                return new \Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\SubAccountRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        new \Domains\Finances\PlansComptable\Accounts\SubAccounts\Repositories\SubAccountReadOnlyRepository(new \App\Models\Finances\SubAccount)
                    )
                );
            }
        );


        // Binds the implementation of CompteRESTfulReadWriteServiceContract to the CompteRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\Comptes\Services\RESTful\Contracts\CompteRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for CompteRESTfulReadWriteService
                 * Create and return an instance of CompteRESTfulReadWriteService
                 */
                return new \Domains\Finances\Comptes\Services\RESTful\CompteRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\Comptes\Repositories\CompteReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of CompteRESTfulQueryServiceContract to the CompteRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\Comptes\Services\RESTful\Contracts\CompteRESTfulQueryServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for CompteRESTfulQueryService
                 * Create and return an instance of CompteRESTfulQueryService
                 */
                return new \Domains\Finances\Comptes\Services\RESTful\CompteRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        $app->make( \Domains\Finances\Comptes\Repositories\CompteReadOnlyRepository::class)
                    )
                );
            }
        );


        // Binds the implementation of JournalRESTfulReadWriteServiceContract to the JournalRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\Journaux\Services\RESTful\Contracts\JournalRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for JournalRESTfulReadWriteService
                 * Create and return an instance of JournalRESTfulReadWriteService
                 */
                return new \Domains\Finances\Journaux\Services\RESTful\JournalRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\Journaux\Repositories\JournalReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of JournalRESTfulQueryServiceContract to the JournalRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\Journaux\Services\RESTful\Contracts\JournalRESTfulQueryServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for JournalRESTfulQueryService
                 * Create and return an instance of JournalRESTfulQueryService
                 */
                return new \Domains\Finances\Journaux\Services\RESTful\JournalRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        $app->make( \Domains\Finances\Journaux\Repositories\JournalReadOnlyRepository::class)
                    )
                );
            }
        );


        // Binds the implementation of ExerciceComptableRESTfulReadWriteServiceContract to the ExerciceComptableRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for ExerciceComptableRESTfulReadWriteService
                 * Create and return an instance of ExerciceComptableRESTfulReadWriteService
                 */
                return new \Domains\Finances\ExercicesComptable\Services\RESTful\ExerciceComptableRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\ExercicesComptable\Repositories\ExerciceComptableReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of ExerciceComptableRESTfulQueryServiceContract to the ExerciceComptableRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulQueryServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for ExerciceComptableRESTfulQueryService
                 * Create and return an instance of ExerciceComptableRESTfulQueryService
                 */
                return new \Domains\Finances\ExercicesComptable\Services\RESTful\ExerciceComptableRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        $app->make( \Domains\Finances\ExercicesComptable\Repositories\ExerciceComptableReadOnlyRepository::class)
                    )
                );
            }
        );


        // Binds the implementation of EcritureComptableRESTfulReadWriteServiceContract to the EcritureComptableRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulReadWriteServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for EcritureComptableRESTfulReadWriteService
                 * Create and return an instance of EcritureComptableRESTfulReadWriteService
                 */
                return new \Domains\Finances\EcrituresComptable\Services\RESTful\EcritureComptableRESTfulReadWriteService(
                    new \Core\Logic\Services\Manager\ReadWriteService(
                        $app->make( \Domains\Finances\EcrituresComptable\Repositories\EcritureComptableReadWriteRepository::class)
                    )
                );
            }
        );

        // Binds the implementation of EcritureComptableRESTfulQueryServiceContract to the EcritureComptableRESTfulQueryService class.
        $this->app->bind(
            \Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulQueryServiceContract::class,
            function ($app) {
                /**
                 * Resolve the necessary dependencies for EcritureComptableRESTfulQueryService
                 * Create and return an instance of EcritureComptableRESTfulQueryService
                 */
                return new \Domains\Finances\EcrituresComptable\Services\RESTful\EcritureComptableRESTfulQueryService(
                    new \Core\Logic\Services\Manager\QueryService(
                        $app->make( \Domains\Finances\EcrituresComptable\Repositories\EcritureComptableReadOnlyRepository::class)
                    )
                );
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

        
        // Binds the implementation of PartnerRESTfulReadWriteServiceContract to the PartnerRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Partners\Services\RESTful\Contracts\PartnerRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PartnerRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of PartnerRESTfulReadWriteService
                return new \Domains\Partners\Services\RESTful\PartnerRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of PartnerRESTfulQueryServiceContract to the PartnerRESTfulQueryService class.
        $this->app->bind(
            \Domains\Partners\Services\RESTful\Contracts\PartnerRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for PartnerRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of PartnerRESTfulQueryService
                return new \Domains\Partners\Services\RESTful\PartnerRESTfulQueryService($queryService);
            }
        );

        
        
        // Binds the implementation of SupplierRESTfulReadWriteServiceContract to the SuppliertRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Partners\Suppliers\Services\RESTful\Contracts\SupplierRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for SupplierRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of ContractRESTfulReadWriteService
                return new \Domains\Partners\Suppliers\Services\RESTful\SupplierRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of ContractRESTfulQueryServiceContract to the ContractRESTfulQueryService class.
        $this->app->bind(
            \Domains\Partners\Suppliers\Services\RESTful\Contracts\SupplierRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ContractRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of ContractRESTfulQueryService
                return new \Domains\Partners\Suppliers\Services\RESTful\SupplierRESTfulQueryService($queryService);
            }
        );
        

        
        // Binds the implementation of ClientRESTfulReadWriteServiceContract to the ClientRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Partners\Clients\Services\RESTful\Contracts\ClientRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ClientRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of ContractRESTfulReadWriteService
                return new \Domains\Partners\Clients\Services\RESTful\ClientRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of ContractRESTfulQueryServiceContract to the ContractRESTfulQueryService class.
        $this->app->bind(
            \Domains\Partners\Clients\Services\RESTful\Contracts\ClientRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ContractRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of ContractRESTfulQueryService
                return new \Domains\Partners\Clients\Services\RESTful\ClientRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of MagasinRESTfulReadWriteServiceContract to the MagasinRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Magasins\Magasin\Services\RESTful\Contracts\MagasinRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for MagasinRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of MagasinRESTfulReadWriteService
                return new \Domains\Magasins\Magasin\Services\RESTful\MagasinRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of MagasinRESTfulQueryServiceContract to the MagasinRESTfulQueryService class.
        $this->app->bind(
            \Domains\Magasins\Magasin\Services\RESTful\Contracts\MagasinRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for MagasinRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of MagasinRESTfulQueryService
                return new \Domains\Magasins\Magasin\Services\RESTful\MagasinRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of StorageSpaceRESTfulReadWriteServiceContract to the StorageSpaceRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Magasins\StorageSpace\Services\RESTful\Contracts\StorageSpaceRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for StorageSpaceRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of StorageSpaceRESTfulReadWriteService
                return new \Domains\Magasins\StorageSpace\Services\RESTful\StorageSpaceRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of StorageSpaceRESTfulQueryServiceContract to the StorageSpaceRESTfulQueryService class.
        $this->app->bind(
            \Domains\Magasins\StorageSpace\Services\RESTful\Contracts\StorageSpaceRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for StorageSpaceRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of StorageSpaceRESTfulQueryService
                return new \Domains\Magasins\StorageSpace\Services\RESTful\StorageSpaceRESTfulQueryService($queryService);
            }
        );

        // Binds the implementation of ArticleRESTfulReadWriteServiceContract to the ArticleRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Articles\Article\Services\RESTful\Contracts\ArticleRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ArticleRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of ArticleRESTfulReadWriteService
                return new \Domains\Articles\Article\Services\RESTful\ArticleRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of ArticleRESTfulQueryServiceContract to the ArticleRESTfulQueryService class.
        $this->app->bind(
            \Domains\Articles\Article\Services\RESTful\Contracts\ArticleRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for ArticleRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of ArticleRESTfulQueryService
                return new \Domains\Articles\Article\Services\RESTful\ArticleRESTfulQueryService($queryService);
            }
        );
        
        // Binds the implementation of CategorieArticleRESTfulReadWriteServiceContract to the CategorieArticleRESTfulReadWriteService class.
        $this->app->bind(
            \Domains\Articles\CategorieArticle\Services\RESTful\Contracts\CategorieArticleRESTfulReadWriteServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CategorieArticleRESTfulReadWriteService
                $readWriteService = $app->make(\Core\Logic\Services\Contracts\ReadWriteServiceContract::class);

                // Create and return an instance of CategorieArticleRESTfulReadWriteService
                return new \Domains\Articles\CategorieArticle\Services\RESTful\CategorieArticleRESTfulReadWriteService($readWriteService);
            }
        );

        // Binds the implementation of CategorieArticleRESTfulQueryServiceContract to the CategorieArticleRESTfulQueryService class.
        $this->app->bind(
            \Domains\Articles\CategorieArticle\Services\RESTful\Contracts\CategorieArticleRESTfulQueryServiceContract::class,
            function ($app) {
                // Resolve the necessary dependencies for CategorieArticleRESTfulQueryService
                $queryService = $app->make(\Core\Logic\Services\Contracts\QueryServiceContract::class);

                // Create and return an instance of CategorieArticleRESTfulQueryService
                return new \Domains\Articles\CategorieArticle\Services\RESTful\CategorieArticleRESTfulQueryService($queryService);
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
