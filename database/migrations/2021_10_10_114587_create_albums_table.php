<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('hash')->unique();
            $table->string('title')->nullable()->default(null);
            $table->text('description')->nullable();
            $table->boolean('adult')->unsigned()->default(false);
            $table->index('adult');
            $table->boolean('private')->unsigned()->default(true);
            $table->index('private');
            $table->timestamp('expire')->nullable();

            $table->bigInteger('created_by')->unsigned()->default(1);
            $table->index('created_by');

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
        Schema::drop('albums');
    }
}
