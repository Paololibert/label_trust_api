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



        // Bind ReadWriteRepositoryInterface to EmployeeReadWriteRepository
        $this->app->when(\Domains\Employees\Services\RESTful\EmployeeRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Employees\Repositories\EmployeeReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to EmployeeReadOnlyRepository
        $this->app->when(\Domains\Employees\Services\RESTful\EmployeeRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Employees\Repositories\EmployeeReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to EmployeeContractuelReadWriteRepository
        $this->app->when(\Domains\Employees\EmployeeContractuels\Services\RESTful\EmployeeContractuelRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Employees\EmployeeContractuels\Repositories\EmployeeContractuelReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to EmployeeContractuelReadOnlyRepository
        $this->app->when(\Domains\Employees\EmployeeContractuels\Services\RESTful\EmployeeContractuelRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Employees\EmployeeContractuels\Repositories\EmployeeContractuelReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to EmployeeNonContractuelReadWriteRepository
        $this->app->when(\Domains\Employees\EmployeeNonContractuels\Services\RESTful\EmployeeNonContractuelRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Employees\EmployeeNonContractuels\Repositories\EmployeeNonContractuelReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to EmployeeNonContractuelReadOnlyRepository
        $this->app->when(\Domains\Employees\EmployeeNonContractuels\Services\RESTful\EmployeeNonContractuelRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Employees\EmployeeNonContractuels\Repositories\EmployeeNonContractuelReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to ContractReadWriteRepository
        $this->app->when(\Domains\Contrats\Services\RESTful\ContractRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Contrats\Repositories\ContractReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ContractReadOnlyRepository
        $this->app->when(\Domains\Contrats\Services\RESTful\ContractRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Contrats\Repositories\ContractReadOnlyRepository::class);


        // Bind ReadWriteRepositoryInterface to EmployeeNonContractuelReadWriteRepository
        $this->app->when(\Domains\Employees\EmployeeNonContractuels\Services\RESTful\EmployeeNonContractuelRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Employees\EmployeeNonContractuels\Repositories\EmployeeNonContractuelReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ContractReadOnlyRepository
        $this->app->when(\Domains\Employees\EmployeeNonContractuels\Services\RESTful\EmployeeNonContractuelRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Employees\EmployeeNonContractuels\Repositories\EmployeeNonContractuelReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to PartnerReadWriteRepository
        $this->app->when(\Domains\Partners\Services\RESTful\PartnerRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Partners\Repositories\PartnerReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ContractReadOnlyRepository
        $this->app->when(\Domains\Partners\Services\RESTful\PartnerRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Partners\Repositories\PartnerReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to SupplierReadWriteRepository
        $this->app->when(\Domains\Partners\Suppliers\Services\RESTful\SupplierRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Partners\Suppliers\Repositories\SupplierReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ContractReadOnlyRepository
        $this->app->when(\Domains\Partners\Suppliers\Services\RESTful\SupplierRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Partners\Suppliers\Repositories\SupplierReadOnlyRepository::class);


        // Bind ReadWriteRepositoryInterface to ClientReadWriteRepository
        $this->app->when(\Domains\Partners\Clients\Services\RESTful\ClientRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Partners\Clients\Repositories\ClientReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ContractReadOnlyRepository
        $this->app->when(\Domains\Partners\Clients\Services\RESTful\ClientRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Partners\Clients\Repositories\ClientReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to MagasinReadWriteRepository
        $this->app->when(\Domains\Magasins\Magasin\Services\RESTful\MagasinRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\Magasin\Repositories\MagasinReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to MagasinReadOnlyRepository
        $this->app->when(\Domains\Magasins\Magasin\Services\RESTful\MagasinRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\Magasin\Repositories\MagasinReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to StorageSpaceReadWriteRepository
        $this->app->when(\Domains\Magasins\StorageSpace\Services\RESTful\StorageSpaceRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\StorageSpace\Repositories\StorageSpaceReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to StorageSpaceReadOnlyRepository
        $this->app->when(\Domains\Magasins\StorageSpace\Services\RESTful\StorageSpaceRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\StorageSpace\Repositories\StorageSpaceReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to ArticleReadWriteRepository
        $this->app->when(\Domains\Articles\Article\Services\RESTful\ArticleRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Articles\Article\Repositories\ArticleReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ArticleReadOnlyRepository
        $this->app->when(\Domains\Articles\Article\Services\RESTful\ArticleRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Articles\Article\Repositories\ArticleReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to CategorieArticleReadWriteRepository
        $this->app->when(\Domains\Articles\CategorieArticle\Services\RESTful\CategorieArticleRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Articles\CategorieArticle\Repositories\CategorieArticleReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to CategorieArticleReadOnlyRepository
        $this->app->when(\Domains\Articles\CategorieArticle\Services\RESTful\CategorieArticleRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Articles\CategorieArticle\Repositories\CategorieArticleReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to ArticleIqpReadWriteRepository
        $this->app->when(\Domains\Magasins\ArticleIqp\Services\RESTful\ArticleIqpRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\ArticleIqp\Repositories\ArticleIqpReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to ArticleIqpReadOnlyRepository
        $this->app->when(\Domains\Magasins\ArticleIqp\Services\RESTful\ArticleIqpRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\ArticleIqp\Repositories\ArticleIqpReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to IQPReadWriteRepository
        $this->app->when(\Domains\Magasins\IQP\Services\RESTful\IQPRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\IQP\Repositories\IQPReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to IQPReadOnlyRepository
        $this->app->when(\Domains\Magasins\IQP\Services\RESTful\IQPRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\IQP\Repositories\IQPReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to CommandeReadWriteRepository
        $this->app->when(\Domains\Magasins\Commandes\Commande\Services\RESTful\CommandeRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\Commandes\Commande\Repositories\CommandeReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to CommandeReadOnlyRepository
        $this->app->when(\Domains\Magasins\Commandes\Commande\Services\RESTful\CommandeRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\Commandes\Commande\Repositories\CommandeReadOnlyRepository::class);

        // Bind ReadWriteRepositoryInterface to CommandeArticleReadWriteRepository
        $this->app->when(\Domains\Magasins\Commandes\CommandeArticle\Services\RESTful\CommandeArticleRESTfulReadWriteService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\Commandes\CommandeArticle\Repositories\CommandeArticleReadWriteRepository::class);

        // Bind ReadWriteRepositoryInterface to CommandeArticleReadOnlyRepository
        $this->app->when(\Domains\Magasins\Commandes\CommandeArticle\Services\RESTful\CommandeArticleRESTfulQueryService::class)
            ->needs(
                \Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface::class
            )
            ->give(\Domains\Magasins\Commandes\CommandeArticle\Repositories\CommandeArticleReadOnlyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
