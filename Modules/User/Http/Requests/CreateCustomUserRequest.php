<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:3|confirmed',
            // 'colegio_id' => 'required',
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
            'password.required' => 'El password es requerido',
            'password.min' => 'El password debe contener como minimo 3 caracteres',
            'password.confirmed' => 'La confirmación del password no coincide',
            // 'colegio_id' => 'Debe seleccionar un colegio',
            'roles.required' => 'Debe seleccionar un rol',
            'roles.not_in' => 'Rol con valor invalido.'
        ];
    }
}
