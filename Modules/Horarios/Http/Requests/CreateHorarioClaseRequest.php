<?php

namespace Modules\Horarios\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateHorarioClaseRequest extends BaseFormRequest
{
    public function rules()
    {
        return 
        [
            'seccion_id' => 'required'
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
            'seccion_id.required' => 'La Seccion es requerida.'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
