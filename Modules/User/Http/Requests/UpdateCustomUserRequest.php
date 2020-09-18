<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => "required|email|unique:users,email,{$this->request->get('user_id')}",
            'password' => 'confirmed',
            'roles' => 'required|not_in:1',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es requerido',
            'last_name.required' => 'El apellido es requerido',
            'email.required' => 'El email es requerido',
            'email.unique' => 'El email ya existe en el sistema',
            'password.confirmed' => 'La confirmación del password no coincide',
            'roles.required' => 'Debe seleccionar un rol',
            'roles.not_in' => 'Rol con valor invalido.'
        ];
    }
}
