<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('survey_name');
            $table->timestamps();
        });

        Schema::create('question_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('survey_id');
            $table->string('name');
            $table->integer('section_order');
            $table->timestamps();

            $table->foreign('survey_id')->references('id')->on('surveys');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default('textarea');
            $table->text('question')->nullable();
            $table->integer('question_order');
            $table->unsignedInteger('question_section_id')->nullable();
            $table->timestamps();

            $table->foreign('question_section_id')->references('id')->on('question_sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_sections');
        Schema::dropIfExists('surveys');


    }
}
