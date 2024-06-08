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
        Schema::create('performances', function (Blueprint $table) {
            $table->bigIncrements('performanceId');
            $table->string('description')->nullable();
            $table->integer('attendanceScore');
            $table->integer('communicationScore');
            $table->integer('responsibilityScore');
            $table->integer('qualityWorkScore');
            $table->integer('collaborationScore');
            $table->date('evaluationDate');
            $table->string('notes', 100)->nullable();
            $table->string('status', 10);
            $table->foreignId('employeeId')->constrained('employees', 'employeeId')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('performances');
    }
};
