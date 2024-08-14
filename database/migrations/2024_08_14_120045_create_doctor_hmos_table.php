<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorHmosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_hmos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_detail_id')->constrained('doctor_details')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('hmo_id')->constrained('hmos')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('doctor_hmos');
    }
}
