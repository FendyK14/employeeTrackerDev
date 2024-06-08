<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('employeeId');
            $table->string('employeeName', 100);
            $table->date('DOB');
            $table->string('employeeEmail')->unique();
            $table->string('noTelp', 15);
            $table->string('password', 100);
            $table->string('gender', 1);
            $table->string('employeeAddress');
            $table->foreignId('companyId')->constrained(DB::raw('`' . env('DB_DATABASE') . '`.`companies`'), 'companyId')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('companyId')->constrained('companies', 'companyId')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('positionId')->constrained('positions', 'positionId')->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
