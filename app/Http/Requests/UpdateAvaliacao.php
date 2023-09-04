<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvaliacao extends FormRequest
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
            'diagnostico' => 'max:230',
            'queixas' => 'max:230',
            'anamnese' => 'max:65000',
            'dor' => 'in:Intensa,Moderada,Leve',
            'codigo' => 'max:20',
            'localizacao_dor' => 'max:230',
            'evas' => 'digits_between:0,10',
            'edema' => 'in:Ausente,Presente',
            'localizacao_edema' => 'max:230',
            'medidas_adm' => 'max:65000',
            'forca_muscular' => 'in:Preservada,Limitada',
            'escala_fm' => 'digits_between:1,5',
            'descricao' => 'max:230',
            'atividades_domesticas' => 'in:Dependende,Semi-dependente,Independente',
            'atividades_comunidade' => 'in:Dependende,Semi-dependente,Independente',
            'auto_cuidado' => 'in:Dependende,Semi-dependente,Independente',
            'marcha' => 'in:Dependende,Semi-dependente,Independente',
            'tratamento_realizado' => 'max:65000',
            'condicoes_alta' => 'max:65000',
            'situacao' => 'required|in:Ativo,Afastado,Aposentado,Desempregado',
            'cid' => 'required|max:20',
        ];
    }
}
