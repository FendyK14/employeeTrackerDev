<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SetDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Session::has('employee')){
            Log::info('Session check succ in middleware');
            return redirect('/login');
        }
        $employee = Session::get('employee');
        Log::info('Employee session in middleware', ['employee' => $employee->employeeName]);

        $compDatabaseName = $this->searchCompanyName($employee->companyId);
        $database_name = 'etrac_' . strtolower(str_replace(' ', '_', $compDatabaseName));

        $this->setDynamicDatabase($database_name);

        return $next($request);
    }

    private function setDynamicDatabase($companyDatabase){
        Config::set('database.connections.dynamic', [
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
        ]);

        // DB::purge('dynamic');
        // DB::reconnect('dynamic');
        DB::setDefaultConnection('dynamic');
        Log::info('Middleware > Database connection set', ['database' => $companyDatabase]);
    }

    protected function searchCompanyName($companyId){
        $companies = DB::connection('mysql')->table('companies')->where('companyId', $companyId)->first();

        return $companies->companyName;
    }
}
