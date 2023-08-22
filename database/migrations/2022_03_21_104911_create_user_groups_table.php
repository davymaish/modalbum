<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('group');
            $table->string('group_code');
            $table->text('description')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('group_id')->unsigned()->after('id');
            $table->boolean('active')->unsigned()->default(false)->after('password');
            $table->foreign('group_id')->references('id')->on('user_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['group_id', 'active']);
        });

        Schema::enableForeignKeyConstraints();
        Schema::dropIfExists('user_groups');
    }
}
