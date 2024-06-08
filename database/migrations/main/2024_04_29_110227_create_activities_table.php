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
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('activityId');
            $table->string('activityName', 50);
            $table->string('description')->nullable();
            $table->string('status', 10);
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->string('priority', 1);
            $table->foreignId('employeeId')->constrained('employees', 'employeeId')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('projectId')->constrained('projects', 'projectId')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('subActivityId')->constrained('sub_activities', 'subActivityId')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('activities');
    }
};
