<?php

namespace Modules\Horarios\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateHorarioExamenRequest extends BaseFormRequest
{
    public function rules()
    {
        return 
        [
            'fecha' => 'required',
            'materia' => 'required'
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return 
        [
            'fecha.required' => 'La fecha es requerida.',
            'materia.required' => 'La materia es requerida.'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
