<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvolucoesDiariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechamentos_mensais', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_inicial')->unique();
            $table->date('data_final')->unique();
            $table->boolean('finalizado')->default(0);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('evolucoes_diarias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('avaliacao_id');
            $table->foreign('avaliacao_id')->references('id')->on('avaliacoes')->onDelete('cascade');
            $table->unsignedInteger('fechamento_id');
            $table->foreign('fechamento_id')->references('id')->on('fechamentos_mensais')->onDelete('cascade');
            $table->unsignedInteger('fisioterapeuta_id');
            $table->foreign('fisioterapeuta_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedSmallInteger('numero_evolucao');
            $table->date('data');
            $table->index('data');
            $table->string('descricao')->nullable();
            $table->boolean('completa')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('evolucoes_diarias');
        Schema::dropIfExists('fechamentos_mensais');
    }
}
