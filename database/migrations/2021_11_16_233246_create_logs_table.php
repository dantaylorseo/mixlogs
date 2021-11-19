<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('application_id');
            $table->string('service');
            $table->string('source');
            $table->timestamp('timestamp');
            $table->string('appid');
            $table->string('traceid');
            $table->string('requestid');
            $table->string('sessionid')->nullable();
            $table->string('locale')->nullable();
            $table->integer('seqid')->nullable();
            $table->integer('offset');
            $table->json('events')->nullable();
            $table->json('request')->nullable();
            $table->json('response')->nullable();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
