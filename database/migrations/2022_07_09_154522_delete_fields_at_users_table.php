<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFieldsAtUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('province_id');
            $table->dropColumn('regencies_id');
            $table->dropColumn('zip_code');
            $table->dropColumn('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->longText('address');
            $table->integer('province_id');
            $table->integer('regencies_id');
            $table->integer('zip_code');
            $table->string('phone_number');
        });
    }
}
