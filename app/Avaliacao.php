<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Util;

class Avaliacao extends Model
{

    protected $table = 'avaliacoes';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'fisioterapeuta_id',
        'data_avaliacao',
        'situacao',
        'cid',
        'diagnostico',
        'queixas',
        'anamnese',
        'dor',
        'codigo',
        'localizacao_dor',
        'evas',
        'edema',
        'localizacao_edema',
        'medidas_adm',
        'forca_muscular',
        'escala_fm',
        'descricao',
        'atividades_domesticas',
        'atividades_comunidade',
        'auto_cuidado',
        'marcha',
        'tratamento_realizado',
        'condicoes_alta',
        'data_alta',
        'tipo_cid',
        'cmc',
        'origem',
        'pausa',
        'origem_outros'
    ];

    public static $enumSituacao = ['Ativo' => 'Ativo', 'Afastado' => 'Afastado', 'Aposentado' => 'Aposentado', 'Desempregado' => 'Desempregado'];
    public static $enumDor = ['Intensa' => 'Intensa', 'Moderada' => 'Moderada', 'Leve' => 'Leve'];
    public static $enumForcaMuscular = ['Preservada' => 'Preservada', 'Limitada' => 'Limitada'];
    public static $enumAtividades = ['Dependende' => 'Dependende', 'Semi-dependente' => 'Semi-dependente', 'Independente' => 'Independente'];
    public static $enumEdema = ['Ausente' => 'Ausente', 'Presente' => 'Presente'];

    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }

    public function medico()
    {
        return $this->belongsTo('App\Medico');
    }

    public function fisioterapeuta()
    {
        return $this->belongsTo('App\User', 'fisioterapeuta_id', 'id');
    }

    public function evolucoes()
    {
        return $this->hasMany('App\EvolucaoDiaria', 'avaliacao_id', 'id');
    }

    /**
     * Mutator Data Padrão MySQL.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataAvaliacaoAttribute($value)
    {
        $this->attributes['data_avaliacao'] = Util::convertDateMySql($value);
    }

    /**
     * Accessor Data Padrão PT-BR.
     *
     * @param  string  $value
     * @return string
     */
    public function getDataAvaliacaoAttribute($value)
    {
        return Util::convertDatePtBr($value);
    }

    /**
     * Mutator Data Padrão MySQL.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataAltaAttribute($value)
    {
        $this->attributes['data_alta'] = Util::convertDateMySql($value);
    }

    /**
     * Accessor Data Padrão PT-BR.
     *
     * @param  string  $value
     * @return string
     */
    public function getDataAltaAttribute($value)
    {
        return Util::convertDatePtBr($value);
    }

    /**
     * Para Datatables
     */
    public static function scopeForDataTables($query)
    {
        return $query
            ->select(['avaliacoes.id', 'avaliacoes.data_avaliacao', 'avaliacoes.pausa', 'pacientes.nome as paciente', 'users.name as fisioterapeuta'])
            ->join('pacientes', 'pacientes.id', '=', 'avaliacoes.paciente_id')
            ->join('users', 'users.id', '=', 'avaliacoes.fisioterapeuta_id');
    }
}
