<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/grados'], function (Router $router) {
    $router->bind('grado', function ($id) {
        return app('Modules\Grados\Repositories\GradoRepository')->find($id);
    });
    $router->get('grados', [
        'as' => 'admin.grados.grado.index',
        'uses' => 'GradoController@index',
        'middleware' => 'can:grados.grados.index'
    ])->middleware('verifyColegioToken');

    $router->get('grados/create', [
        'as' => 'admin.grados.grado.create',
        'uses' => 'GradoController@create',
        'middleware' => 'can:grados.grados.create'
    ])->middleware('verifyColegioToken');

    $router->post('grados', [
        'as' => 'admin.grados.grado.store',
        'uses' => 'GradoController@store',
        'middleware' => 'can:grados.grados.create'
    ])->middleware('verifyColegioToken');

    $router->get('grados/{grado}/edit', [
        'as' => 'admin.grados.grado.edit',
        'uses' => 'GradoController@edit',
        'middleware' => 'can:grados.grados.edit'
    ])->middleware('verifyColegioToken');

    $router->put('grados/{grado}', [
        'as' => 'admin.grados.grado.update',
        'uses' => 'GradoController@update',
        'middleware' => 'can:grados.grados.edit'
    ])->middleware('verifyColegioToken');

    $router->delete('grados/{grado}', [
        'as' => 'admin.grados.grado.destroy',
        'uses' => 'GradoController@destroy',
        'middleware' => 'can:grados.grados.destroy'
    ]);
    $router->bind('categoria', function ($id) {
        return app('Modules\Grados\Repositories\CategoriaRepository')->find($id);
    });
    $router->get('categorias', [
        'as' => 'admin.grados.categoria.index',
        'uses' => 'CategoriaController@index',
        'middleware' => 'can:grados.categorias.index'
    ])->middleware('verifyColegioToken');

    $router->get('categorias/create', [
        'as' => 'admin.grados.categoria.create',
        'uses' => 'CategoriaController@create',
        'middleware' => 'can:grados.categorias.create'
    ])->middleware('verifyColegioToken');

    $router->post('categorias', [
        'as' => 'admin.grados.categoria.store',
        'uses' => 'CategoriaController@store',
        'middleware' => 'can:grados.categorias.create'
    ])->middleware('verifyColegioToken');

    $router->get('categorias/{categoria}/edit', [
        'as' => 'admin.grados.categoria.edit',
        'uses' => 'CategoriaController@edit',
        'middleware' => 'can:grados.categorias.edit'
    ]);
    $router->put('categorias/{categoria}', [
        'as' => 'admin.grados.categoria.update',
        'uses' => 'CategoriaController@update',
        'middleware' => 'can:grados.categorias.edit'
    ]);
    $router->delete('categorias/{categoria}', [
        'as' => 'admin.grados.categoria.destroy',
        'uses' => 'CategoriaController@destroy',
        'middleware' => 'can:grados.categorias.destroy'
    ]);
    $router->bind('seccion', function ($id) {
        return app('Modules\Grados\Repositories\SeccionRepository')->find($id);
    });
    $router->get('seccions', [
        'as' => 'admin.grados.seccion.index',
        'uses' => 'SeccionController@index',
        'middleware' => 'can:grados.seccions.index'
    ])->middleware('verifyColegioToken');

    $router->get('seccions/create', [
        'as' => 'admin.grados.seccion.create',
        'uses' => 'SeccionController@create',
        'middleware' => 'can:grados.seccions.create'
    ])->middleware('verifyColegioToken');

    $router->post('seccions', [
        'as' => 'admin.grados.seccion.store',
        'uses' => 'SeccionController@store',
        'middleware' => 'can:grados.seccions.create'
    ])->middleware('verifyColegioToken');
    
    $router->get('seccions/{seccion}/edit', [
        'as' => 'admin.grados.seccion.edit',
        'uses' => 'SeccionController@edit',
        'middleware' => 'can:grados.seccions.edit'
    ]);
    $router->put('seccions/{seccion}', [
        'as' => 'admin.grados.seccion.update',
        'uses' => 'SeccionController@update',
        'middleware' => 'can:grados.seccions.edit'
    ]);
    $router->delete('seccions/{seccion}', [
        'as' => 'admin.grados.seccion.destroy',
        'uses' => 'SeccionController@destroy',
        'middleware' => 'can:grados.seccions.destroy'
    ]);
// append



});
