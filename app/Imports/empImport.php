<?php

namespace App\Imports;

use App\importUser ;
use Maatwebsite\Excel\Concerns\ToModel;

class empImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        return new importUser([
        'emp_id'     => $row[0],
         //='password' => Hash::make($row[2]),
        ]);
    }
}
