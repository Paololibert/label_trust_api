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



        // Bind ReadWriteRepositoryInterface to DeviseReadWriteRepository
        $this->app->when(\Domains\Finances\Devises\Services\RESTful\DeviseRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\Devises\Repositories\DeviseReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to DeviseReadOnlyRepository
        $this->app->when(\Domains\Finances\Devises\Services\RESTful\DeviseRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\Devises\Repositories\DeviseReadOnlyRepository::class);


        // Bind ReadWriteRepositoryInterface to CategoriesDeCompteReadWriteRepository
        $this->app->when(\Domains\Finances\CategoriesDeCompte\Services\RESTful\CategorieDeCompteRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\CategoriesDeCompte\Repositories\CategorieDeCompteReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to CategoriesDeCompteReadOnlyRepository
        $this->app->when(\Domains\Finances\CategoriesDeCompte\Services\RESTful\CategorieDeCompteRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\CategoriesDeCompte\Repositories\CategorieDeCompteReadOnlyRepository::class);


        // Bind ReadWriteRepositoryInterface to ClassesDeCompteReadWriteRepository
        $this->app->when(\Domains\Finances\ClassesDeCompte\Services\RESTful\ClasseDeCompteRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\ClassesDeCompte\Repositories\ClasseDeCompteReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ClassesDeCompteReadOnlyRepository
        $this->app->when(\Domains\Finances\ClassesDeCompte\Services\RESTful\ClasseDeCompteRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\ClassesDeCompte\Repositories\ClasseDeCompteReadOnlyRepository::class);



        // Bind ReadWriteRepositoryInterface to PeriodesExerciceReadWriteRepository
        $this->app->when(\Domains\Finances\PeriodesExercice\Services\RESTful\PeriodeExerciceRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\PeriodesExercice\Repositories\PeriodeExerciceReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to PeriodesExerciceReadOnlyRepository
        $this->app->when(\Domains\Finances\PeriodesExercice\Services\RESTful\PeriodeExerciceRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\PeriodesExercice\Repositories\PeriodeExerciceReadOnlyRepository::class);



        // Bind ReadWriteRepositoryInterface to CompteReadWriteRepository
        $this->app->when(\Domains\Finances\Comptes\Services\RESTful\CompteRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\Comptes\Repositories\CompteReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ComptesReadOnlyRepository
        $this->app->when(\Domains\Finances\Comptes\Services\RESTful\CompteRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\Comptes\Repositories\CompteReadOnlyRepository::class);


        // Bind ReadWriteRepositoryInterface to JournalReadWriteRepository
        $this->app->when(\Domains\Finances\Journaux\Services\RESTful\JournalRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\Journaux\Repositories\JournalReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to JournauxReadOnlyRepository
        $this->app->when(\Domains\Finances\Journaux\Services\RESTful\JournalRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\Journaux\Repositories\JournalReadOnlyRepository::class);


        // Bind ReadWriteRepositoryInterface to PlanComptableReadWriteRepository
        $this->app->when(\Domains\Finances\PlansComptable\Services\RESTful\PlanComptableRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\PlansComptable\Repositories\PlanComptableReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to PlansComptableReadOnlyRepository
        $this->app->when(\Domains\Finances\PlansComptable\Services\RESTful\PlanComptableRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\PlansComptable\Repositories\PlanComptableReadOnlyRepository::class);


        // Bind ReadWriteRepositoryInterface to AccountReadWriteRepository
        $this->app->when(\Domains\Finances\PlansComptable\Accounts\Services\RESTful\AccountRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to AccountReadOnlyRepository
        $this->app->when(\Domains\Finances\PlansComptable\Accounts\Services\RESTful\AccountRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadOnlyRepository::class);


        // Bind ReadWriteRepositoryInterface to AccountReadWriteRepository
        $this->app->when(\Domains\Finances\PlansComptable\Accounts\Services\RESTful\AccountRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to AccountReadOnlyRepository
        $this->app->when(\Domains\Finances\PlansComptable\Accounts\Services\RESTful\AccountRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to ExerciceComptableReadWriteRepository
        $this->app->when(\Domains\Finances\ExercicesComptable\Services\RESTful\ExerciceComptableRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\ExercicesComptable\Repositories\ExerciceComptableReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ExercicesComptableReadOnlyRepository
        $this->app->when(\Domains\Finances\ExercicesComptable\Services\RESTful\ExerciceComptableRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Finances\ExercicesComptable\Repositories\ExerciceComptableReadOnlyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
