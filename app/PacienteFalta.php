<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Util;
use Illuminate\Support\Facades\DB;

class PacienteFalta extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'paciente_id',
        'data'
    ];

    protected $dates = [
        'data'
    ];

    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
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

    public static function listaPacientesAusentes()
    {
        return DB::table('paciente_faltas')
            ->join('pacientes', 'pacientes.id', '=', 'paciente_faltas.paciente_id')
            ->select( 'pacientes.nome', DB::raw("DATE_FORMAT(STR_TO_DATE(data, '%Y-%m-%d'), '%d/%m/%Y') as data"))
            ->orderBy('data', 'desc');
    }
}
