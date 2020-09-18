<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\BasePublicController;

class Login extends BasePublicController
{
    private $colegio_repo;
    private $device_repo;
    private $access_repo;

    public function __construct( \CustomColegioRepository $colegio_repo, \CustomDispositivoRepository $device_repo, \CustomAccessRepository $access_repo)
    {
        parent::__construct();
        $this->colegio_repo = $colegio_repo;
        $this->device_repo = $device_repo;
        $this->access_repo = $access_repo;
    }

    public function get_check_colegio_token()
    {
        return ['error' => false];
    }

    public function get_colegio_logo_url( Request $re )
    {
        //$colegio_repo = new \CustomColegioRepository;

        return ['error' => false, 'data' => array('imagen_url' => $this->colegio_repo->get_colegio_logo( $re->colegio_token ) ) ];
    }

    public function postLogin(Request $re)
    {
        
        if( !$re->filled('email') or !$re->filled('password') )
            return ['error' => true, 'message' => "Datos invalidos.", 'debug-message' => $re->all()];

        if
        ( 
            !\User::where('email', $re['email'])->whereHas('colegio', function( $colegio_q ) use ($re)
            {
                $colegio_q->where('token', $re->colegio_token);
            })
            ->exists() 
        )
            return ['error' => true, 'message' => "El email (" . $re['email'] . ") no esta registrado en el sistema.", 'debug-message' => $re->all()];

        $credentials = 
        [
            'email' => $re->email,
            'password' => $re->password,
        ];

        $error_msg = $this->auth->login($credentials, false /*remember*/ );

        if( $error_msg )
            return [ 'error' => true, 'message' => "Datos invalidos." ];
        

        $user = $this->auth->user();

        if( !$user->colegio )
            return ['error' => true, 'message' => "El usuario no esta asociado a ningun colegio.", 'debug-message' => $user ];

        if( !$user->responsable )
            return ['error' => true, 'message' => "El usuario no es ningun responsable.", 'debug-message' => $user ];

        if( $user->responsable->estado != 'aprobado' )
            return ['error' => true, 'message' => "El usuario no esta aprobado para usar la aplicacion.", 'debug-message' => $user ];

        if( !$user->responsable->access )
            return ['error' => true, 'message' => "El usuario no tiene token de acceso.", 'debug-message' => $user ];

        if( !$re->filled('device_token') )
            return ['error' => true, 'message' => "No se encontro token de dispositivo.", 'debug-message' => $re->all() ];

        $device = $this->device_repo->create_if_not_exists( $re->device_token, $re->device_info );
        
        $user->responsable->access->responsable_has_logged_with_device_token( $device->token );

        return ['error' => false, 'others' => [ 'responsable_access_token' => $user->responsable->access->token, 'colegio_nombre' => $user->colegio->nombre ] ];
    }

}