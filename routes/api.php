<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/user', function (Request $request) 
{
    return $request->user();
})->middleware('auth:api');


Route::prefix('v1')->group( function( $router ) 
{
    $router->get('/colegio/search', 'Api\SeleccionColegio@search_colegio');
    $router->get('/password/{forgot_password_token}/reset', 'Api\PasswordRecover@getReset');
    $router->post('contacto', 'Api\Contacto@recibir_mensaje');
    $router->post('/password/{forgot_password_token}/reset', 
    [ 
        'as' => 'api.v1.forgot_password.reset.post',
        'uses' => 'Api\PasswordRecover@postReset'
    ]);
    
    $router->middleware(['ColegioTokenControlMiddleware'])->group(function( $router )
    {

        $router->post('/login', 'Api\Login@postLogin');
        $router->get('/login/get_logo', 'Api\Login@get_colegio_logo_url');
        $router->get('/login/check_colegio_token', 'Api\Login@get_check_colegio_token');
        
        $router->get('/registrar', 'Api\Registro@getRegistrar');
        $router->post('/registrar', 'Api\Registro@postRegistrar');

        $router->post('/password/recover', 'Api\PasswordRecover@postRecover');
       
        
        $router->middleware(['VerifyResponsableMiddleware'])->group(function( $router )
        {
            $router->get('/inicio', 'Api\Inicio@get_inicio');

            $router->get('/perfil/show', 'Api\Usuario@show');
            $router->get('/perfil/edit', 'Api\Usuario@edit');
            $router->put('/perfil/edit', 'Api\Usuario@update');

            $router->get('/avisos/side_menu', 'Api\SideMenu@getSideMenuGrados');

            $router->get('/avisos/index', 'Api\Avisos@index');
            $router->get('/avisos/aviso', 'Api\Avisos@get_aviso');
            $router->post('/avisos/visto', 'Api\Avisos@post_create_visto');

            $router->get('/noticias/index', 'Api\Noticias@get_noticia_index');
            $router->get('/noticias/noticia/detalle', 'Api\Noticias@get_noticia_detalles');

            $router->get('/horarios/examenes/index', 'Api\Horarios@get_examenes_index');
            $router->get('/horarios/clases/index', 'Api\Horarios@get_clases_index');
            $router->get('/horarios/examenes/detalle', 'Api\Horarios@get_horario_examen_by_id');
            $router->get('/horarios/clases/detalle', 'Api\Horarios@get_horario_clase_by_id');
        });
        

    });
    
});
