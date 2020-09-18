<?php namespace App\Http\Repository;

class EmailsRepository
{
	private $email_origin;
	private $email_origin_alias;
    public function __construct()
    {
        $this->email_origin = env('MAIL_FROM_ADDRESS');
        $this->email_origin_alias = env('MAIL_FROM_NAME'); 
    }

    public function send( $email, $title, $body, $user_alias = 'Usuario', $from_email = null, $from_alias = null, $template = 'emails.basic' )
    {
        $contenido = [ 'title' => $title, 'body' => $body];
        
    	\Mail::send( $template , $contenido, function($message) use ($email, $contenido, $user_alias, $from_email, $from_alias, $template)
        {
            $message->to( $email, $user_alias)->subject( $contenido['title'] );
            $message->from( ( $from_email ? $from_email : $this->email_origin ), ( $from_alias ? $from_alias : $this->email_origin_alias ) );
        });
    }

}