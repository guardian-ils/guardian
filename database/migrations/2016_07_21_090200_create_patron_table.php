<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatronTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patrons', function (Blueprint $table) {
            $table->uuid('id');
            $table->text('library_card_number');
            $table->text('name');
            $table->text('address');
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->date('birthday')->nullable();
            $table->uuid('branch_id')->references('id')->on('branches'); // home branch of the patron
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
        Schema::drop('patrons');
    }
}
