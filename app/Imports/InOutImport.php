<?php

namespace App\Imports;

use App\InOutSetting;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class InOutImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        return new InOutSetting([
            'user_id'     => $row['emp_id'],
            'time_in'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['time_in'])->format('H:i'),
            'time_out'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['time_out'])->format('H:i'),   
        ]);
    }
}
