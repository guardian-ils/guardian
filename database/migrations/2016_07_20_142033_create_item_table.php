<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('uuid_generate_v4()'));
            $table->text('barcode')->nullable()->default(null);
            $table->uuid('biblio_id')->references('id')->on('biblios');;
            $table->integer('copy')->nullable()->default(null);
            $table->text('volume')->nullable()->default(null);
            $table->string('isbn', 13)->nullable()->default(null);
            $table->uuid('location_id')->references('id')->on('locations');
            $table->timestamps();

            $table->primary('id');
            $table->unique('barcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
