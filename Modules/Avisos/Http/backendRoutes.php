<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/avisos'], function (Router $router) 
{
    
    $router->bind('aviso', function ($id) 
    {
        return \Aviso::find($id);
    });
    $router->bind('categoria', function ($id) 
    {
        return \Categoria::find($id);
    });
    $router->bind('grado', function ($id) 
    {
        return \Grado::find($id);
    });
    $router->bind('seccion', function ($id) 
    {
        return \Seccion::find($id);
    });
    
    $router->get('avisos', [
        'as' => 'admin.avisos.aviso.index',
        'uses' => 'AvisoController@index',
        'middleware' => 'can:avisos.avisos.index'
    ])->middleware('verifyColegioToken');

    $router->post('avisos/index_ajax', [
        'as' => 'admin.avisos.aviso.index_ajax',
        'uses' => 'AvisoController@index_ajax',
        'middleware' => 'can:avisos.avisos.index_ajax'
    ]);

    $router->get('avisos/vistos/{aviso}/{categoria}/{grado}/{seccion}', 
    [
        'as' => 'admin.avisos.aviso.vistos',
        'uses' => 'AvisoController@vistos',
        'middleware' => 'can:avisos.avisos.vistos'
    ]);
    
    $router->post('avisos/vistos_index_ajax', [
        'as' => 'admin.avisos.aviso.vistos_index_ajax',
        'uses' => 'AvisoController@vistos_index_ajax',
        'middleware' => 'can:avisos.avisos.vistos_index_ajax'
    ]);
    
    
    $router->delete('avisos/delete_avisos_ajax', [
        'as' => 'admin.avisos.aviso.delete_avisos_ajax',
        'uses' => 'AvisoController@delete_avisos_ajax',
        'middleware' => 'can:avisos.avisos.delete_avisos_ajax'
    ]);
    $router->get('avisos/ver_detalle/{aviso}', [
        'as' => 'admin.avisos.aviso.ver_detalle',
        'uses' => 'AvisoController@ver_detalle',
        'middleware' => 'can:avisos.avisos.ver_detalle'
    ]);
    
    $router->get('avisos/create_general', [
        'as' => 'admin.avisos.aviso.create_general',
        'uses' => 'AvisoController@create_general',
        'middleware' => 'can:avisos.avisos.create_general'
    ])->middleware('verifyColegioToken');

    $router->get('avisos/create_por_categoria', [
        'as' => 'admin.avisos.aviso.create_por_categoria',
        'uses' => 'AvisoController@create_por_categoria',
        'middleware' => 'can:avisos.avisos.create_por_categoria'
    ])->middleware('verifyColegioToken');

    $router->get('avisos/create_por_grado', [
        'as' => 'admin.avisos.aviso.create_por_grado',
        'uses' => 'AvisoController@create_por_grado',
        'middleware' => 'can:avisos.avisos.create_por_grado'
    ])->middleware('verifyColegioToken');

    $router->get('avisos/create_por_seccion', [
        'as' => 'admin.avisos.aviso.create_por_seccion',
        'uses' => 'AvisoController@create_por_seccion',
        'middleware' => 'can:avisos.avisos.create_por_seccion'
    ])->middleware('verifyColegioToken');

    $router->get('avisos/create', [
        'as' => 'admin.avisos.aviso.create',
        'uses' => 'AvisoController@create',
        'middleware' => 'can:avisos.avisos.create'
    ])->middleware('verifyColegioToken');

    $router->post('avisos', [
        'as' => 'admin.avisos.aviso.store',
        'uses' => 'AvisoController@store',
        'middleware' => 'can:avisos.avisos.create'
    ]);
    $router->get('avisos/{aviso}/edit', [
        'as' => 'admin.avisos.aviso.edit',
        'uses' => 'AvisoController@edit',
        'middleware' => 'can:avisos.avisos.edit'
    ]);
    $router->put('avisos/{aviso}', [
        'as' => 'admin.avisos.aviso.update',
        'uses' => 'AvisoController@update',
        'middleware' => 'can:avisos.avisos.edit'
    ]);
    $router->delete('avisos/{aviso}', [
        'as' => 'admin.avisos.aviso.destroy',
        'uses' => 'AvisoController@destroy',
        'middleware' => 'can:avisos.avisos.destroy'
    ]);
// append

});
