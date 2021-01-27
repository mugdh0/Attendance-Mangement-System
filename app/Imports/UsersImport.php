<?php

namespace App\Imports;

use App\Attendance;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        return new Attendance([
        'user_id'     => $row[1],
         'time'    => $row[0],
         'status'    => $row[8],
         //='password' => Hash::make($row[2]),
        ]);
    }
}
