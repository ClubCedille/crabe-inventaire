<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class AddMoreFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'firstName');
            $table->string('lastName');
            $table->string('codeUniversel');
            $table->boolean('isAdmin')->default(false);
            $table->dateTime('membershipExpirationDate')->default(Carbon::now());
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
            $table->renameColumn('firstName', 'name');
            $table->dropColumn('lastName');
            $table->dropColumn('codeUniversel');
            $table->dropColumn('membershipExpirationDate');
            $table->dropColumn('isAdmin');
        });
    }
}
