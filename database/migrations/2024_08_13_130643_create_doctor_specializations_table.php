<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_specializations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_detail_id')->constrained('doctor_details')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('specialization_id')->constrained('specializations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('sub_specialization_id')->nullable()->constrained('sub_specializations')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('doctor_specializations');
    }
}
