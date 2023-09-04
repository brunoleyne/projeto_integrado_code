<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Util;

class FechamentoMensal extends Model
{
    protected $table = 'fechamentos_mensais';

    protected $fillable = [
        'data_inicial',
        'data_final',
        'finalizado'
    ];

    /**
     * Mutator Data Padrão MySQL.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataInicialAttribute($value)
    {
        $this->attributes['data_inicial'] = Util::convertDateMySql($value);
    }

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

    /**
     * Mutator Data Padrão MySQL.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataFinalAttribute($value)
    {
        $this->attributes['data_final'] = Util::convertDateMySql($value);
    }

    /**
     * Accessor Data Padrão PT-BR.
     *
     * @param  string  $value
     * @return string
     */
    public function getDataFinalAttribute($value)
    {
        return Util::convertDatePtBr($value);
    }
}
