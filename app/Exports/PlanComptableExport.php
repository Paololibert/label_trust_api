<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class PlanComptableExport implements FromArray, WithMapping, ShouldAutoSize
{
    protected $plan;

    public function __construct(array $plan)
    {
        $this->plan = $plan;
    }

    public function array(): array
    {
        return $this->plan;
    }

    public function map($row): array
    {
        return [
            $row['classes']['intitule'],
            $row['classes']['class_number'],
            $row['classes']['comptes'][0][0], // Account Number
            $row['classes']['comptes'][0][1], // Account Name
        ];
    }
}
