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
            $table->increments('id',10);
            $table->foreignId('users_id')->constrained()->onDelete('cascade');/*usersテーブルid紐づけ*/
            $table->foreignId('grade_id')->constrained()->onDelete('cascade');/*gradesテーブルid紐づけ*/
            $table->boolean('clear_flg')->default(false);/*curriculum_progressテーブルflagと一緒*/
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
