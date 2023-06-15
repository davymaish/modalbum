<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhotosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('album_id')->unsigned()->nullable()->default(null);
            $table->index('album_id');

            $table->string('hash')->unique();

            $table->string('file_hash');

            $table->string('image_title')->nullable()->default(null);
            $table->text('image_description')->nullable();

            $table->char('image_extension', '5');
            $table->smallInteger('image_width')->unsigned();
            $table->smallInteger('image_height')->unsigned();
            $table->boolean('adult')->unsigned()->default(false);
            $table->index('adult');
            $table->boolean('private')->unsigned()->default(true);
            $table->index('private');
            $table->timestamp('expire')->nullable();

            $table->bigInteger('created_by')->unsigned()->default(1);
            $table->index('created_by');

            $table->timestamps();
        });

        Schema::create('albums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('hash')->unique();
            $table->string('album_title')->nullable()->default(null);
            $table->text('album_description')->nullable();
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
        Schema::drop('photos');
    }
}
