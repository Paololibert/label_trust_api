<?php

namespace App\Imports;

use App\Models\Account;
use Domains\Finances\PlansComptable\Repositories\PlanComptableReadWriteRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class PlanComptableSheetImport implements OnEachRow
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


    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        
        $group = Group::firstOrCreate([
            'name' => $row[1],
        ]);
    
        $group->users()->create([
            'name' => $row[0],
        ]);
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($this->isClasseRow($row)) {
            // Handle "classe" row
            $this->processClasseRow($row);
        } else {
            // Handle "compte details" row
            $this->processCompteDetailsRow($row);
        }
    }

    private function isClasseRow(array $row): bool
    {
        // Add logic to determine if the row represents a "classe" row
        // For example, check if certain columns contain specific values or patterns
        // Return true if it's a "classe" row, false otherwise
        return true;
    }

    private function processClasseRow(array $row): void
    {
        // Process the "classe" row
        // For example, create a Classe model instance and save it to the database
    }

    private function processCompteDetailsRow(array $row): void
    {
        // Process the "compte details" row
        // For example, create a CompteDetails model instance and save it to the database
    }
}
