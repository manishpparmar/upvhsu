<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChestXrayResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chest_xray_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->nullable();
            $table->foreign('patient_id')->references('patient_id')->on('patient_info')->onDelete('cascade');
            $table->integer('medical_appointment_id')->unsigned()->index()->nullable();
            $table->foreign('medical_appointment_id')->references('id')->on('medical_appointments')->onDelete('cascade');
            $table->integer('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('staff_id')->on('staff_info')->onDelete('cascade');
            $table->integer('xray_staff_id');
            $table->foreign('xray_staff_id')->references('staff_id')->on('staff_info')->onDelete('cascade');
            $table->text('xray_result');
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
        Schema::dropIfExists('chest_xray_results');
    }
}
