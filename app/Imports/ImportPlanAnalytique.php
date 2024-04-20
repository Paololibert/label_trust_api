<?php

namespace App\Imports;

use App\Models\Finances\PlanComptable;
use Core\Utils\Exceptions\ServiceException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPlanAnalytique implements ToModel//, SkipsUnknownSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        return new PlanComptable([
            
        ]);
    }
}
