<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\Finances\ClasseDeCompte;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportAccounts implements ToArray
{

    public function array(array $array)
    {
        return $array;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ClasseDeCompte($row);
    }
}
