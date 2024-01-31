<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('prn');
            $table->string('student_name');
            $table->string('false_number');
            $table->unsignedBigInteger('college_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('exam_id');
            $table->timestamps();

            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
