<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Util;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class EvolucaoDiaria extends Model
{
    use SoftDeletes;

    protected $table = 'evolucoes_diarias';

    protected $fillable = [
        'avaliacao_id',
        'fechamento_id',
        'fisioterapeuta_id',
        'numero_evolucao',
        'data',
        'descricao',
        'completa',
        'pausa',
    ];

    public static $condutaMantida = [2,3,4,6,7,8,10,11,12,14,15,16,18,19,21,22,23,25,26,27,29,30,31,33,34,35,37,38,39];

    public function avaliacao()
    {
        return $this->hasOne('App\Avaliacao', 'id', 'avaliacao_id');
    }

    /**
     * Mutator Data Padrão MySQL.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = Util::convertDateMySql($value);
    }

    /**
     * Accessor Data Padrão PT-BR.
     *
     * @param  string  $value
     * @return string
     */
    public function getDataAttribute($value)
    {
        return Util::convertDatePtBr($value);
    }

    /**
     * Accessor Data Padrão PT-BR.
     *
     * @return object
     */
    public static function listaTratamentoDiario()
    {
        return DB::table('evolucoes_diarias')
            ->join('avaliacoes', 'avaliacoes.id', '=', 'evolucoes_diarias.avaliacao_id')
            ->join('pacientes', 'pacientes.id', '=', 'avaliacoes.paciente_id')
            ->join('users', 'users.id', '=', 'evolucoes_diarias.fisioterapeuta_id')
            ->where('data', date("Y-m-d"))
            ->where('evolucoes_diarias.completa', '=',0)
            ->select( 'pacientes.nome','evolucoes_diarias.completa', 'users.name as fisioterapeuta')
            ->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return object
     */
    public static function carregarListaDiariaDigitaisPacientes()
    {
        return DB::table('evolucoes_diarias')
            ->join('avaliacoes', 'avaliacoes.id', '=', 'evolucoes_diarias.avaliacao_id')
            ->join('pacientes', 'pacientes.id', '=', 'avaliacoes.paciente_id')
            ->join('users', 'users.id', '=', 'evolucoes_diarias.fisioterapeuta_id')
            ->where('data', date("Y-m-d"))
            ->where('evolucoes_diarias.completa', '=',0)
            ->select( 'pacientes.id','pacientes.fingerprint')
            ->get();
    }

}
