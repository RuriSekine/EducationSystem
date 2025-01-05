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
        Schema::create('curriculums',function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title')->nullable(false);
            $table->string('thumbnail');
            $table->longText('description')->nullable();
            $table->mediumText('video_url')->nullable();
            $table->tinyInteger('alway_delivery_flg')->nullable(false);
            $table->unsignedInteger('grade_id')->nullable(false);
            $table->foreign('grade_id')->references('id')->on('grades');
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
        Schema::dropIfExists('curriculums');
    }
};
