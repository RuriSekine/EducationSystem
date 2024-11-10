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
        Schema::create('curriculum_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curriculums_id');/*カラム定義*/
            $table->foreign('curriculums_id')->references('id')->on('curriculums')->onDelete('cascade');
            $table->unsignedInteger('users_id');/*カラム定義*/
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');/*usersテーブルid紐づけ*/
            $table->boolean('clear_flg')->default(false);
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
        Schema::dropIfExists('curriculum_progress');
    }
};
