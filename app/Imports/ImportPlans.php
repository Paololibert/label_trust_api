<?php

namespace App\Imports;

use Core\Utils\Exceptions\ServiceException;
use Domains\Finances\PlansComptable\Repositories\PlanComptableReadWriteRepository;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportPlans implements WithMultipleSheets, SkipsUnknownSheets
{
    use WithConditionalSheets, Importable;

    protected $plan_comptable_name;

    /**
     * @var PlanComptableReadWriteRepository
     */
    protected $plan_comptable_repository;

    public function __construct(string $plan_comptable_name, PlanComptableReadWriteRepository $planComptableRepository)
    {
        $this->plan_comptable_name = $plan_comptable_name;
        $this->plan_comptable_repository = $planComptableRepository;
    }

    public function sheets(): array
    {
        return [
            "Plan comptable général"    => new AccountsImport(plan_comptable_name: $this->plan_comptable_name, planComptableRepository: $this->plan_comptable_repository),
            "Plan analytique"           => new ImportPlanAnalytique(),
        ];
    }

    public function conditionalSheets(): array
    {
        // Define the conditions to include or exclude sheets based on your criteria
        return [
            'Plan comptable général' => true, // Include the sheet 'Plan comptable général'
            'Plan analytique' => false, // Exclude the sheet 'Plan analytique'
            // Add more conditions as needed
        ];
    }
    
    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        throw new ServiceException("Sheet {$sheetName} was skipped", 1);
    }
}
