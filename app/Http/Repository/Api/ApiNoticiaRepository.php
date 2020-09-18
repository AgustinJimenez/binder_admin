<?php namespace App\Http\Repository\Api;

use Illuminate\Http\Request;

class ApiNoticiaRepository
{
    private $repo_responsable;
    private $repo_user;

    public function __construct( \ResponsableRepository $repo_responsable, \UserRepository $repo_user )
    {
        $this->repo_responsable = $repo_responsable;
        $this->repo_user = $repo_user;
        
    }

    public function noticia_detalle_validate( Request $re )
    {
        $rules = 
        [
            'invalid-fields' => 
            ( 
                !$re->has('noticia_id')
            )

        ];

        $messages = 
        [
            'invalid-fields' => 'Error, datos enviados invalidos o faltantes.'
        ];

        foreach( $rules as $key => $rule )
            if( $rule )
                return ['error' => true, 'message' => $messages[ $key ], 'debug-message' => $re->all() ];

        return ['error' => false ];
    }



}