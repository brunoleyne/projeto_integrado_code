<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 80);
            $table->index(['nome']);
            $table->string('cns', 20);
            $table->index(['cns']);
            $table->date('data_nascimento');
            $table->string('telefone', 15);
            $table->string('telefone_secundario', 15)->nullable();
            $table->string('logradouro', 80);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 50);
            $table->string('municipio', 50);
            $table->string('estado', 2);
            $table->string('cep', 9);
            $table->text('fingerprint')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}
