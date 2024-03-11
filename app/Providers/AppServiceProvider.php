<?php

namespace App\Providers;

use Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface;
use Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\Manager\QueryService;
use Core\Logic\Services\Manager\ReadWriteService;
use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;
use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\Controllers\RESTful\Contracts\RESTfulResourceControllerContract;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Binds DTOInterface to BaseDTO
        $this->app->bind(DTOInterface::class, BaseDTO::class);
        $this->app->bind(RESTfulResourceControllerContract::class, RESTfulResourceController::class);

        // Binds ReadOnlyRepositoryInterface to EloquentReadOnlyRepository
        $this->app->bind(ReadOnlyRepositoryInterface::class, EloquentReadOnlyRepository::class);

        // Binds ReadWriteRepositoryInterface to EloquentReadWriteRepository
        $this->app->bind(ReadWriteRepositoryInterface::class, EloquentReadWriteRepository::class);
        
        /**
         * Binds implementations to their respective interfaces in the application's service container.
         * This allows for dependency injection and facilitates the use of interfaces throughout the application.
         */

        // Binds the implementation of QueryServiceContract to the QueryService class.
        $this->app->bind(
            QueryServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by QueryService
                $readOnlyRepository = $app->make(ReadOnlyRepositoryInterface::class);

                // Create and return an instance of QueryService
                return new QueryService($readOnlyRepository);
            }
        );

        // Binds the implementation of ReadWriteServiceContract to the ReadWriteService class.
        $this->app->bind(
            ReadWriteServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by ReadWriteService
                $readWriteRepository = $app->make(ReadWriteRepositoryInterface::class);

                // Create and return an instance of ReadWriteService
                return new ReadWriteService($readWriteRepository);
            }
        );



        // Binds the implementation of RestJsonQueryServiceContract to the RestJsonQueryService class.
        $this->app->bind(
            RestJsonQueryServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by RestJsonQueryService
                $readOnlyRepository = $app->make(ReadOnlyRepositoryInterface::class);
                $queryService = $app->make(QueryServiceContract::class, [$readOnlyRepository]);

                // Create and return an instance of RestJsonQueryService
                return new RestJsonQueryService($queryService);
            }
        );

        // Binds the implementation of RestJsonReadWriteServiceContract to the RestJsonReadWriteService class.
        $this->app->bind(
            RestJsonReadWriteServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by RestJsonReadWriteService
                $readWriteRepository = $app->make(ReadWriteRepositoryInterface::class);

                $queryService = new ReadWriteService($readWriteRepository);

                // Create and return an instance of RestJsonReadWriteService
                return new RestJsonReadWriteService($queryService);
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
