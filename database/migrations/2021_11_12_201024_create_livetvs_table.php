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
        Schema::create('livetvs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('album_id')->unsigned()->nullable()->default(null);
            $table->index('album_id');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('featured_image', 255)->nullable();
            $table->text('embed')->nullable();
            $table->enum('live', ['yes', 'no'])->default('no');
            $table->enum('featured', ['yes', 'no'])->default('no');
            $table->integer('views')->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('livetvs');
    }
};
