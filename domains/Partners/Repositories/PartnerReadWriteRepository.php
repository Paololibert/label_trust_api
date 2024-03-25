<?php

declare(strict_types=1);

namespace Domains\Partners\Repositories;

use App\Models\Partner;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\TypePartnerEnum;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Partners\Clients\Repositories\ClientReadWriteRepository;
use Domains\Partners\Suppliers\Repositories\SupplierReadWriteRepository;
use Domains\Users\Repositories\UserReadWriteRepository;
use Exception;
use Throwable;

/**
 * ***`PartnerReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Partner $instance data.
 *
 * @package ***`Domains\Partners\Repositories`***
 */
class PartnerReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var ClientReadWriteRepository 
     */
    private $clientRWRep;

    /**
     * @var SupplierReadWriteRepository
     */
    private $supplierRWRep;

    /**
     * @var UserReadWriteRepository
     */
    private $userReadWriteRepository;

    /**
     * Create a new PartnerReadWriteRepository instance.
     *
     * @param  \App\Models\Partner $model
     * @return void
     */
    public function __construct(Partner $model, ClientReadWriteRepository $clientRWRep,SupplierReadWriteRepository $supplierRWRep ,UserReadWriteRepository $userReadWriteRepository)
    {
        parent::__construct($model);
        $this->clientRWRep = $clientRWRep;
        $this->supplierRWRep = $supplierRWRep; 
        $this->userReadWriteRepository = $userReadWriteRepository;
    }
    
    
    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return Partner               The created record.
     *
     * 
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): Partner
    {
        try {

            //dd($data);

            $theparent =  $this->model = parent::create($data);

            $partnerDetail = null;

            if($data['type_partner'] === TypePartnerEnum::CLIENT->value)
            {
                $partnerDetail = $this->clientRWRep->create($data['data']);

            }
            else if($data['type_partner'] === TypePartnerEnum::SUPPLIER->value)
            {
                $partnerDetail = $this->supplierRWRep->create($data['data']);

            }
            else throw new Exception("Unknown type of Partner", 1);

            if(!$partnerDetail) throw new Exception("Error occur while creating type of Partner", 1);
            
            $att = $partnerDetail->partners()->attach($theparent->id);

            $this->userReadWriteRepository->create(array_merge($data['user'], ["profilable_type"=>$this->model::class, "profilable_id"=>$this->model->id]));

            return $this->model->refresh();
            
        } catch (QueryException $exception) {
            
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }
}