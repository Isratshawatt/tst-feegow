<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('users');
            $table->integer('specialty_id')->comment('Id da especialidade');
            $table->string('specialty')->comment('Nome da especialidade');
            $table->integer('professional_id')->comment('Id do especialista');
            $table->string('professional')->comment('Nome do especialista');
            $table->string('name')->comment('nome do cliente');
            $table->integer('source_id')->comment('Id de origem (como conheceu)');
            $table->date('birthdate')->comment('data de aniversario do cliente');
            $table->string('cpf')->comment('cpf do cliente');
            $table->dateTime('dateconsult')->comment('data de consulta do cliente');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}
