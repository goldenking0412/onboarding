<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('question_id')->nullable();
            $table->text('value')->nullable();
            $table->text('data')->nullable();
            $table->string('folder')->nullable();
            $table->tinyInteger('is_reviewed')->default(0);
            $table->tinyInteger('is_complete')->default(0);
            $table->text('feedback')->nullable();
            $table->string('type')->nullable();
            $table->string('tracking_number')->nullable();
            $table->tinyInteger('is_received')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
