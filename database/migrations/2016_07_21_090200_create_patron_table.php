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
            $table->uuid('id')->default(DB::raw('uuid_generate_v4()'));
            $table->text('library_card_number');
            $table->text('name');
            $table->text('address')->nullable()->default(null);
            $table->text('phone')->nullable()->default(null);
            $table->text('email')->nullable()->default(null);
            $table->date('birthday')->nullable();
            $table->uuid('branch_id')->references('id')->on('branches'); // home branch of the patron
            $table->timestamps();

            $table->primary('id');
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
