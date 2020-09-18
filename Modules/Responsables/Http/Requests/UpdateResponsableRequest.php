<?php

namespace Modules\Responsables\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateResponsableRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'email' => "required|email|unique:users,email,{$this->request->get('user_id')}",
            'password' => 'confirmed',
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
            'password.confirmed' => 'La confirmación del password no coincide',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
