<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->unsignedInteger('medico_id');
            $table->foreign('medico_id')->references('id')->on('medicos')->onDelete('cascade');
            $table->unsignedInteger('fisioterapeuta_id');
            $table->foreign('fisioterapeuta_id')->references('id')->on('users')->onDelete('cascade');

            $table->date('data_avaliacao')->nullable();
            $table->enum('situacao', ['Ativo', 'Afastado', 'Aposentado', 'Desempregado'])->nullable();
            $table->string('cid', 15)->nullable();
            $table->string('origem', 20)->nullable();
            $table->string('cmc', 20)->nullable();
            $table->string('tipo_cid', 1)->nullable();
            $table->string('diagnostico')->nullable();
            $table->string('queixas')->nullable();
            $table->text('anamnese')->nullable();
            $table->enum('dor', ['Intensa', 'Moderada', 'Leve'])->nullable();
            $table->string('codigo', 20)->nullable();
            $table->string('localizacao_dor')->nullable();
            $table->unsignedTinyInteger('evas')->nullable();
            $table->enum('edema', ['Ausente', 'Presente'])->nullable();
            $table->string('localizacao_edema')->nullable();
            $table->text('medidas_adm')->nullable();
            $table->enum('forca_muscular', ['Preservada', 'Limitada'])->nullable();
            $table->unsignedTinyInteger('escala_fm')->nullable();
            $table->string('descricao')->nullable();
            $table->enum('atividades_domesticas', ['Dependende','Semi-dependente','Independente'])->nullable();
            $table->enum('atividades_comunidade', ['Dependende','Semi-dependente','Independente'])->nullable();
            $table->enum('auto_cuidado', ['Dependende','Semi-dependente','Independente'])->nullable();
            $table->enum('marcha', ['Dependende','Semi-dependente','Independente'])->nullable();
            $table->text('tratamento_realizado')->nullable();
            $table->text('condicoes_alta')->nullable();
            $table->date('data_alta')->nullable();
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
        Schema::dropIfExists('avaliacoes');
    }
}
