<?php

namespace Modules\Alumnos\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateAlumnoRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'grado_id' => 'required',
            'email' => "unique:users"
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
            'apellido.required' => 'El apellido es requerido',
            'apellido.max' => 'La cantidad maxima de caracteres aceptados es 255',
            'grado_id.required' => 'Debe seleccionar un grado',
            'email.unique' => 'El email ya existe en el sistema.'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
