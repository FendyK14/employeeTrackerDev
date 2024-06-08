<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('detail_employee_groups', function (Blueprint $table) {
            $table->foreignId('employeeId')->constrained('employees', 'employeeId')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('groupId')->constrained('groups', 'groupId')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('isLeader');
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
        Schema::dropIfExists('detail_employee_groups');
    }
};
