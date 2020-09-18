<?php

namespace Modules\Grados\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoriaRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'nombre' => 'required|max:255',
            // 'colegio_id' => 'required',
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
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'La cantidad maxima de caracteres aceptados es 255',
            // 'colegio_id.required' => 'Debe seleccionar un colegio',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
