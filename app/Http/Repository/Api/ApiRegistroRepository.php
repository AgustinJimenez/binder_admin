<?php 
namespace App\Http\Repository\Api;

class ApiRegistroRepository
{
    private $repo_responsable;
    private $repo_user;

    public function __construct( \ResponsableRepository $repo_responsable, \UserRepository $repo_user )
    {
        $this->repo_responsable = $repo_responsable;
        $this->repo_user = $repo_user;
        
    }
    //params: string
    //return: array
    public function parse_rare_arraystring_to_array($string)
    {
        return explode(",", str_replace( ["[","]",'"'], '', $string ));
    }

    //params: array
    //return: array
    public function validate_responsable_fields( $fields )
    {
        $rules = 
        [
            'invalid-fields' => 
            ( 
                !$fields or 
                !isset( $fields['nombre'] ) or 
                !isset( $fields['apellido'] ) or
                !isset( $fields['email'] ) or
                !isset( $fields['password'] ) or
                !isset( $fields['password_confirmation'] ) or
                !isset( $fields['tipo_encargado'] ) or
                !isset( $fields['secciones_ids'] ) or
                !isset( $fields['telefono'] ) or
                !isset( $fields['device_info'] ) or 
                !isset( $fields['device_info']['token'] ) or 
                (str_replace(' ', '', $fields['device_info']['token']) == '')
            ),

            'email-already-exist' => \User::where( 'email', $fields['email'] )->exists(),

            'password-mismatch' => ($fields['password'] != $fields['password_confirmation']),

            'password-min-length' => !( strlen($fields['password'])>=3 )

        ];

        $messages = 
        [
            'invalid-fields' => 'Error, datos enviados invalidos o faltantes.',
            'email-already-exist' => 'El email ya existe en el sistema.',
            'password-mismatch' => 'La confirmación del password no coincide',
            'password-min-length' => "La contraseña debe de tener 3 caracteres como minimo."
        ];

        
        if( $rules['invalid-fields'] )
            return ['error' => true, 'message' => $messages['invalid-fields'], 'debug-message' => $fields];

        if( $rules['email-already-exist'] )
            return ['error' => true, 'message' => $messages['email-already-exist'], 'debug-message' => $fields];

        if( $rules['password-mismatch'] )
            return ['error' => true, 'message' => $messages['password-mismatch'], 'debug-message' => $fields];

        if( $rules['password-min-length'] )
            return ['error' => true, 'message' => $messages['password-min-length'], 'debug-message' => $fields];

        return ['error' => false ];
    }
    //params: array
    //return: array
    public function store_usuario_responsable( $fields )
    {
        $fields['estado'] = 'pendiente';

        $user_data_processed = $this->repo_responsable->processUserData( $fields, true );

        $roles = $this->repo_responsable->getDefaultRole();

        $user = $this->repo_user->createWithRoles( $user_data_processed, $roles, true );

        $responsable = $this->repo_responsable->create( $fields + ['user_id' => $user->id] );

        $this->repo_responsable->create_responsable_access( $responsable->id );

        $create_responsable_suscripciones_result = $this->repo_responsable->create_responsable_suscripciones( $responsable->id, $fields['secciones_ids'], $fields['device_info'] );

        $has_error = ( !$user or !$user->id or !$responsable or !$responsable->id or $create_responsable_suscripciones_result['error'] );

        if( $has_error )
            return $create_responsable_suscripciones_result;
        else
            return 
            [
                'error' => false, 
                'message' => '',
                'result' =>
                [  
                    'user' => $user, 
                    'responsable' => $responsable, 
                    'suscripciones' => $create_responsable_suscripciones_result['suscripciones'],
                    'device' => $create_responsable_suscripciones_result['device']
                ] 
            ];
    }














    
}