<?php

namespace Modules\Noticias\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateNoticiaRequest extends BaseFormRequest
{
    public function rules()
    {
        return 
        [
            'titulo' => 'required',
            'fecha' => 'required',
            'contenido' => 'required'
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
            'titulo.required' => 'El titulo es requerido',
            'fecha.required' => 'La fecha es requerida',
            'contenido.required' => 'El contenido es requerido'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
