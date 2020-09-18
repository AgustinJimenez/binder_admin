<?php

namespace Modules\Colegios\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColegioRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre'=> 'required|max:255'
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
            'nombre.max' => 'La cantidad maxima de caracteres aceptados es 255'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
