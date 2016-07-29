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
            $table->uuid('id')->default(DB::raw('uuid_generate_v4()'));
            $table->text('title');
            $table->text('author')->nullable()->default(null);
            $table->text('call_number');
            $table->jsonb('marc');
            $table->timestamps();

            $table->primary('id');
            $table->index(['title'], 'biblio_title_index');
            $table->index(['author'], 'biblio_author_index');
            $table->index(['call_number'], 'biblio_call_number_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('biblios');
    }
}
