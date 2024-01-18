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
        Schema::create('performance_reports', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->integer('plan');
            $table->integer('actual');
            $table->string('evidence_file')->nullable();
            $table->string('result_desc');
            $table->string('problem_identification')->nullable();
            $table->string('corrective_action')->nullable();

            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');

            $table->foreignId('initiative_id')->nullable();
            $table->foreign('initiative_id')->references('id')->on('initiatives')->onDelete('SET NULL');
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
        Schema::dropIfExists('performance_reports');
    }
};
