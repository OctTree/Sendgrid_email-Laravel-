<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaillogsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maillogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('s_email');
            $table->string('r_email');
            $table->string('subject');
            $table->string('message');
            $table->integer('u_id')->nullable();
            $table->integer('c_id')->nullable();
            $table->enum('status', ['B','D', 'O', 'C'])->nullable();
            $table->string('msg_id');
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
        Schema::dropIfExists('maillogs_tables');
    }
}
