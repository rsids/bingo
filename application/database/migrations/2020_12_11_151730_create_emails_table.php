<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('subject');
            $table->string('body');
            $table->integer('sent');
        });
        Schema::table('cards', function (Blueprint $table) {
            $table->foreignId('email_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
        Schema::table('cards', function (Blueprint $table) {
            $table->removeColumn('email_id');
        });
    }
}
