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
        Schema::create('generate_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_account');
            $table->foreign('id_account')->references('id')->on('accounts');
            $table->string('ticket_generator');
            $table->string('value');
            $table->string('account_number_generator');
            $table->string('ticket_expiration')->date_format();
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
        Schema::dropIfExists('generate_tickets');
    }
};
