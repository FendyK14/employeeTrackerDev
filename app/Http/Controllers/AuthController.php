<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Show view login
    public function index()
    {
        //check session 'employee' first
        if (Session::has('employee')) {
            $employee = Session::get('employee');
            $compDatabaseName = $this->searchCompanyName($employee->companyId);
            $this->setDynamicDatabase($compDatabaseName);
            // Log::info('Database index login', ['database name' => $compDatabaseName]);
        }

        // has login
        if (Auth::guard('employee')->check()) {
            return redirect('dashboard');
        }

        return view('auth.login');
    }

    // Show view register company
    public function index_register_company()
    {
        return view('auth.register_company');
    }

    // Show view register user
    public function index_register_user()
    {
        // $positions = Position::all();
        $companies = Company::all();

        return view('auth.register_user', compact('companies'));
    }

    // Logic login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'employeeEmail' => 'required|email',
            'password' => 'required'
        ]);

        $companies = DB::table('companies')->get();

        foreach ($companies as $company) {
            $databaseName = 'etrac_' . strtolower(str_replace(' ', '_', $company->companyName));
            $this->setDynamicDatabase($databaseName);

            if (Auth::guard('employee')->attempt($credentials)) {
                if ($request->remember_me) {
                    Cookie::queue('authEmail', $request->employeeEmail, 120);
                    Cookie::queue('authPassword', $request->password, 120);
                }
                Session::put('employee', Auth::guard('employee')->user());
                return redirect('dashboard');
            } else {
                DB::purge('dynamic');
            }
        }
        return redirect()->back()->with('status', 'Login Failed!');
    }

    // Logic register company
    public function register_company(Request $request)
    {
        // $existingCompany = Company::where('companyName', $request->companyName)->first();

        // if ($existingCompany){
        //     // Log::info("Nama perusahaan sudah terdaftar", ['nama comp' => $request->companyName]);
        //     return redirect()->route('RegisterUser');
        // }

        $request->validate([
            'companyName' => 'required|unique:companies',
            'companyEmail' => 'required|unique:companies,companyEmail',
            'companyPhone' => 'required',
            'companyAddress' => 'required',
        ]);
        // create company
        Company::create([
            'companyName' => $request->companyName,
            'companyEmail' => $request->companyEmail,
            'companyPhone' => $request->companyPhone,
            'companyAddress' => $request->companyAddress,
        ]);

        $this->createCompanyDatabase($request->companyName); //create new database for company
        //redirect to user register view
        return redirect()->route('RegisterUser');
    }

    // Logic register user
    public function register_user(Request $request)
    {
        // $request->validate([
        //     'employeeName' => 'required',
        //     'employeeEmail' => 'required|email',
        //     'DOB' => 'required',
        //     'noTelp' => 'required',
        //     'gender' => 'required',
        //     'employeeAddress' => 'required',
        //     'password' => 'required',
        //     'password_confirmation' => 'required|same:password',
        //     'companyId' => 'required',
        //     'positionId' => 'required',
        // ]);
        $company = Company::findOrFail($request->companyId); //findOrFail min 1 arg, primarykey

        $databaseName = 'etrac_' . strtolower(str_replace(' ', '_', $company->companyName));

        // Set koneksi ke database dinamis
        $this->setDynamicDatabase($databaseName);

        $tables = DB::connection('dynamic')->select('SHOW TABLES');

        if (empty($tables)) {
            // run migration for company database
            $this->runCompanyMigrations($company->database_name);
        }

        $request->validate([
            'employeeName' => 'required',
            'employeeEmail' => 'required|email',
            'DOB' => 'required|date|after:01/01/1900|before:today',
            'noTelp' => 'required|numeric|digits_between:1,15',
            'gender' => 'required',
            'employeeAddress' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'companyId' => 'required',
            'positionId' => 'required',
        ]);

        // $existingEmployee = Employee::where('employeeEmail', $request->employeeEmail)->first();

        // if ($existingEmployee){
        //     // Log::info("email sudah terdaftar di company ini", ['nama comp' => $company->companyName, 'email' => $request->employeeEmail]);
        //     return redirect()->route('Login');
        // }

        Employee::create([
            'employeeName' => $request->employeeName,
            'employeeEmail' => $request->employeeEmail,
            'DOB' => $request->DOB,
            'noTelp' => $request->noTelp,
            'gender' => $request->gender,
            'employeeAddress' => $request->employeeAddress,
            'password' => bcrypt($request->password),
            'companyId' => $request->companyId,
            'positionId' => $request->positionId,
        ]);

        return redirect()->route('Login');
    }

    // logic logout
    public function logout()
    {
        $employee = Session::get('employee');
        $compDatabaseName = $this->searchCompanyName($employee->companyId);
        $this->setDynamicDatabase($compDatabaseName);
        // Log::info('Database logout', ['database name' => $compDatabaseName]);

        Auth::guard('employee')->logout();
        Cookie::queue(Cookie::forget('authEmail'));
        Cookie::queue(Cookie::forget('authPassword'));
        Session::invalidate();
        Session::regenerateToken();

        return redirect('login');
    }

    // logic createCompanyDatabase
    public function createCompanyDatabase($companyName)
    {
        $databaseName = 'etrac_' . strtolower(str_replace(' ', '_', $companyName));

        DB::statement("CREATE DATABASE {$databaseName}");

        return $databaseName;
    }

    // logic set dynamic database
    private function setDynamicDatabase($companyDatabase)
    {
        $dynamicConfig = [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'database' => $companyDatabase,
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ];
        Config::set('database.connections.dynamic', $dynamicConfig);
        DB::setDefaultConnection('dynamic');
    }

    public function runCompanyMigrations($database_name)
    {
        config(['database.connections.dynamic' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $database_name,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]]);

        Artisan::call('migrate', [
            '--database' => 'dynamic',
            '--path' => 'database/migrations/main'
        ]);
    }

    protected function searchCompanyName($companyId)
    {
        $companies = DB::connection('mysql')->table('companies')->where('companyId', $companyId)->first();
        $databaseName = 'etrac_' . strtolower(str_replace(' ', '_', $companies->companyName));

        return $databaseName;
    }
}
