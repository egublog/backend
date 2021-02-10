<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('talks')) {
            // テーブルが存在していればリターン
            return;
        }
        Schema::create('talks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('talk_data');
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');
            $table->boolean('yet');
            $table->timestamps();

            $table->foreign('from')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talks');
    }
}
