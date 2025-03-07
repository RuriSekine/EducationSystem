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
        Schema::create('delivery_times', function (Blueprint $table) {
            $table->increments('id'); // ID
            $table->unsignedInteger('curriculums_id')->nullable(false); // カリキュラムID（curriculumsテーブルのidと紐づく）
            $table->dateTime('delivery_from')->nullable(false); // 公開開始日
            $table->dateTime('delivery_to')->nullable(false); // 公開終了日
            $table->timestamps();
            // リレーションを組むための外部キー制約
            $table->foreign('curriculums_id')->references('id')->on('curriculums')
                  ->onDelete('cascade'); // curriculumsのidが削除されたら、関連するdelivery_timesも削除
        });
    }
  
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_times');
    }
};
