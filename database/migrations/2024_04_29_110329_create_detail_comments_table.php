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
        Schema::create('detail_comments', function (Blueprint $table) {
            $table->foreignId('commentId')->constrained('comments', 'commentId')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('activityId')->constrained('activities', 'activityId')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detail_comments');
    }
};
