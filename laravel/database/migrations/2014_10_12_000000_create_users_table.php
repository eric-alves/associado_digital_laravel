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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->string("cpfcnpj");
            $table->date("nascimento");
            $table->string("conta");
            $table->char("sexo");
            $table->string("pai");
            $table->string("mae");
            $table->integer("status");
            $table->string("token");
            $table->string("cooperativa", 4);
            $table->string("matricula_empresa");
            $table->string("nome_empresa");

            $table->timestamps();

            $table->unique(['cpfcnpj', 'cooperativa']);
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
