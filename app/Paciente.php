<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Util;

class Paciente extends Model
{
    protected $fillable = [
        'nome',
        'cns',
        'data_nascimento',
        'telefone',
        'telefone_secundario',
        'logradouro',
        'complemento',
        'bairro',
        'municipio',
        'estado',
        'cep',
        'fingerprint',
        'cpf'
    ];

    /**
     * Mutator Data Padrão MySQL.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataNascimentoAttribute($value)
    {
        $this->attributes['data_nascimento'] = Util::convertDateMySql($value);
    }

    /**
     * Accessor Data Padrão PT-BR.
     *
     * @param  string  $value
     * @return string
     */
    public function getDataNascimentoAttribute($value)
    {
        return Util::convertDatePtBr($value);
    }

    public function avaliacao()
    {
        return $this->hasMany('App\Avaliacao');
    }



}
