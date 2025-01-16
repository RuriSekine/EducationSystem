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
        Schema::create('classes_clear_checks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('users_id')->nullable(false);/*カラム定義*/
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');/*usersテーブルid紐づけ*/
            $table->unsignedInteger('grade_id')->nullable(false);/*カラム定義*/
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');/*gradesテーブルid紐づけ*/
            $table->boolean('clear_flg')->default(false);/*curriculum_progressテーブルflagと関係*/
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
        Schema::dropIfExists('classes_clear_checks');
    }
};
