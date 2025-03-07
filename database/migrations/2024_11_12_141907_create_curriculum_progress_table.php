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
            $table->unsignedInteger('curriculums_id')->nullable(false);/*カラム定義*/
            $table->foreign('curriculums_id')->references('id')->on('curriculums')->onDelete('cascade'); //curriculumsテーブルidと紐づけ・curriculumsテーブルidが削除されたらonDelete('cascade')でcurriculums_idも削除される
            $table->unsignedInteger('users_id')->nullable(false);/*カラム定義*/
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');//usersテーブルidと紐づけ・usersテーブルidが削除されたらonDelete('cascade')でusers_idも削除される。
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
