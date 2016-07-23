<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBibTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biblios', function (Blueprint $table) {
            $table->uuid('id');
            $table->text('title');
            $table->text('author')->nullable()->default(null);
            $table->text('call_number');
            $table->jsonb('marc');
            $table->timestamps();

            $table->primary('id');
            $table->index(['title', 'author', 'call_number'], 'biblio_data_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biblios', function (Blueprint $table) {
            $table->dropIndex('biblio_data_index');
        });
        Schema::drop('biblios');
    }
}
