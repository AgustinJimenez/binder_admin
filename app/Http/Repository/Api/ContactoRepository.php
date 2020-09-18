<?php namespace App\Http\Repository\Api;

use Illuminate\Http\Request;
use Validator;


class ContactoRepository
{

    private $emails_repo;
    private $email_contacto;
    private $email_asunto;
    private $email_body_message = '';

    public function __construct( \EmailsRepository $emails_repo )
    {
        $this->emails_repo = $emails_repo;
        $this->email_contacto = env('MAIL_CONTACTO_EMAIL');
        $this->email_asunto = env('MAIL_CONTACTO_ASUNTO');
    }

    public function validate_request(Request &$re)
    {
        return Validator::make
        (
            $re->all(), 
            [
                'nombre' => 'required',
                'institucion' => 'required',
                'email' => 'nullable|email',
                'numero' => 'required'
            ], 
            [
                'required' => 'El campo (:attribute) es requerido',
                'email' => "El email es invalido"
            ]
        ); 
    }


    public function enviar_mail( $params )
    {
        foreach( $params as $key => $value )
            $this->email_body_message .= $key . " = " . $value . ", \n";

        $this->emails_repo->send( $this->email_contacto, $this->email_asunto, $this->email_body_message, 'Usuario', $params['email'], $params['nombre'] );
    }

}