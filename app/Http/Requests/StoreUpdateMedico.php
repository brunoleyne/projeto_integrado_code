<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateMedico extends FormRequest
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
        $medico = $this->route('medico');

        $rules = [
            'nome' => 'required|max:80',
            'crm' => 'required||max:7|unique:medicos,crm'
        ];

        if (isset($medico->id)) {
            $rules['crm'] = 'required||max:7|unique:medicos,crm,'. $medico->id;
        }

        return $rules;
    }
}
