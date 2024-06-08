<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class AuthHelper
{
    public static function customAuth($email, $password)
    {
        // Ganti 'dynamic_database' sesuai dengan nama koneksi database dinamis Anda
        $employees = DB::connection('dynamic')->table('employees')
            ->where('email', $email)
            ->first();

        if ($employees && password_verify($password, $employees->password)) {
            return true; // Autentikasi berhasil
        }

        return false; // Autentikasi gagal
    }
}
