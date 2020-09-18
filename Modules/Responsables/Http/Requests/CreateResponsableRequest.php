<?php

namespace Modules\Responsables\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateResponsableRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:3|confirmed'
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
            'email.required' => 'El email es requerido',
            'email.unique' => 'El email ya existe en el sistema',
            'password.required' => 'El password es requerido',
            'password.min' => 'El password debe contener como minimo 3 caracteres',
            'password.confirmed' => 'La confirmación del password no coincide'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
