<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAvaliacao extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'fisioterapeuta_id' => 'required|exists:users,id',
            'data_avaliacao' => 'required|data',
            'numero_avaliacoes' => 'required|integer',
            'dias_semana' => 'required',
            'origem' => 'required',
            'cmc' => 'required',
        ];
    }
}
