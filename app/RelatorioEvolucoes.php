<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Util;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class RelatorioEvolucoes extends Model
{
    protected $table = 'relatorio_evolucoes';

    protected $fillable = [
        'paciente_nome',
        'data_inicial',
        'data_alta',
        'data_evolucao',
        'fisioterapeuta',
        'tipo_cid',
        'evolucao_completa',
        'numero_evolucao',
    ];

    /**
     * Accessor Data Padrão PT-BR.
     *
     * @param  string  $value
     * @return string
     */
    public function getDataInicialAttribute($value)
    {
        return Util::convertDatePtBr($value);
    }

    public function getDataAltaAttribute($value)
    {
        return Util::convertDatePtBr($value);
    }

    public function getDataEvolucaottribute($value)
    {
        return Util::convertDatePtBr($value);
    }
}
