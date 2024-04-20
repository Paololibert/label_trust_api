<?php

namespace App\Imports;

use App\Models\Finances\PlanComptable;
use Core\Utils\Exceptions\ServiceException;
use Domains\Finances\PlansComptable\Repositories\PlanComptableReadWriteRepository;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPlanComptable implements ToModel
{
    /**
     * @var string
     */
    protected $plan_name;

    /**
     * @var PlanComptableReadWriteRepository
     */
    protected $repository;
    

    public function __construct(string $plan_name, PlanComptableReadWriteRepository $repository)
    {
        $this->plan_name    = $plan_name;
        $this->repository   = $repository;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        $data = $this->formatData($row);

        return $this->repository->create($data);
    }

    private function formatData($rows){

        dd($rows);
        $accounts = [];
        foreach ($rows as $key => $row) {
            $accounts[$key] = $row;
        }
        return $accounts;
    }
}
