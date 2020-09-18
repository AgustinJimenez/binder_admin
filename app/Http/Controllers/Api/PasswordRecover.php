<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\BasePublicController;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Modules\Page\Repositories\PageRepository;

class PasswordRecover extends BasePublicController
{
    private $page;
    private $app;
    private $repo_mails;
    private $repo_forgot_password;
    private $repo_api_user;
    public function __construct( \EmailsRepository $repo_mails, \ForgotPasswordRepository $repo_forgot_password, PageRepository $page, Application $app, \ApiUsuarioRepository $repo_api_user)
    {
        parent::__construct();
        
        $this->repo_mails = $repo_mails;
        $this->repo_forgot_password = $repo_forgot_password;
        $this->page = $page;
        $this->app = $app;
        $this->repo_api_user = $repo_api_user;
    }

    public function postRecover(Request $re)
    {   
        if( !isset( $re['email'], $re['token'] )  )
            return ['error' => true, 'message' => 'No se enviaron los datos requeridos.', 'debug-message' => $re->all()];

        if( !\User::where('email', $re['email'])->whereHas('responsable')->exists()  )
            return ['error' => true, 'message' => 'El email ' . $re['email'] . ' no esta registrado en el sistema.'];
        
        $forgot_password_result = $this->repo_forgot_password->save( $re->all() );
        if( $forgot_password_result['error'] )
            return $forgot_password_result;

        $link = route('api.v1.forgot_password.reset.post', [$forgot_password_result['data']['forgot_password']->token] );
        $this->repo_mails->send( $re['email'], 'Email de recuperacion', 'Link para cambiar contraseña ' . $link );

        return [
                    'error' => false, 
                    'debug-message' => $re->all(), 
                    'others' => 
                    [
                        'email' => $re['email']
                    ]
                ];
    }

    public function getReset( $forgot_password_token, Request $re )
    {
        $reset_data = \ForgotPassword::find($forgot_password_token);
        if( !$reset_data or ($reset_data->used and $reset_data->expired) ) 
            $this->app->abort('404');

        return view("reset-password/index", compact('reset_data'));
    }
    public function postReset($forgot_password_token, Request $re )
    {
        $reset_data = \ForgotPassword::find($forgot_password_token);
        $reset_data->used  = true;
        $result = $this->repo_api_user->update([ 'responsable_id' => \User::where('email', $reset_data->email)->first()->responsable->id, 'password' => $re->password ], false, false);
        if( $result['error'] )
        {
            dd($result);
        }
        $reset_data->save();
        $message = 'Contraseña cambiada correctamente.';
        return view("reset-password/empty-message", compact('message'));
    }

}