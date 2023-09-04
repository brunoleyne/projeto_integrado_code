<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePaciente extends FormRequest
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
        $paciente= $this->route('paciente');

        $rules = [
            'nome' => 'required|max:80',
            'cns' => 'required|max:20|unique:pacientes,cns',
            'data_nascimento' => 'required|data',
            'telefone' => 'required|max:15',
            'telefone_secundario' => 'max:15',
            'logradouro' => 'required|max:80',
            'complemento' => 'max:50',
            'bairro' => 'required|max:50',
            'municipio' => 'required|max:50',
            'estado' => 'required|max:2',
            'cep' => 'required|max:9',
            'cpf' => 'max:14|cpf',
        ];

        if (isset($paciente->id)) {
            $rules['cns'] = 'required||max:20|unique:pacientes,cns,'. $paciente->id;
        }

        return $rules;
    }
}
