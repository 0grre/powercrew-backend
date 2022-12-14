<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->integer('zipCode')->nullable();
            $table->string('city')->nullable();
            $table->string('primaryPhone')->nullable();
            $table->string('secondaryPhone')->nullable();
            $table->date('birthDate')->nullable();
            $table->foreignId('current_team_id')->nullable();
            $table->dateTime('disabled_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
