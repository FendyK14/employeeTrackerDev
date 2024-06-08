<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\withHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Auth;

class EmployeesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        // Cek apakah email sudah ada di database
        $existingEmployee = Employee::where('employeeEmail', $row['employee_email'])->first();

        if ($existingEmployee) {
            // Jika email sudah ada, return null untuk tidak menambah data baru
            return null;
        }

        // Mendapatkan ID perusahaan saat ini
        $companyId = Auth::guard('employee')->user()->companyId;

        return new Employee([
            //collect data dari excel
            'employeeName' => $row['employee_name'],
            'DOB' => Date::excelToDateTimeObject($row['dob']),
            'gender' => $row['gender'],
            'employeeEmail' => $row['employee_email'],
            'noTelp' => $row['no_telp'],
            'employeeAddress' => $row['employee_address'],
            'positionId' => $row['position_id'],
            'password' => bcrypt('password'),
            'companyId' => $companyId,
        ]);
    }
}
