<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\Api\ContactoRepository;

class Contacto extends Controller
{
    private $contacto;

    public function __construct( ContactoRepository $contacto )
    {
        $this->contacto = $contacto;
    }

    public function recibir_mensaje(Request $re)
    {
        if( $validation = $this->contacto->validate_request( $re ) and $validation->fails() )
            return ['error' => true, 'message' => implode(', ', $validation->errors()->all() ) ];
        
        $this->contacto->enviar_mail( $re->all() );

        return ['error' => false];
    }

}