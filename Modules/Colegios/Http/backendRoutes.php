<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/colegios'], function (Router $router) {
    $router->bind('colegio', function ($id) {
        return app('Modules\Colegios\Repositories\ColegioRepository')->find($id);
    });
    $router->get('colegios', [
        'as' => 'admin.colegios.colegio.index',
        'uses' => 'ColegioController@index',
        'middleware' => 'can:colegios.colegios.index'
    ]);
    $router->get('colegios/create', [
        'as' => 'admin.colegios.colegio.create',
        'uses' => 'ColegioController@create',
        'middleware' => 'can:colegios.colegios.create'
    ]);
    $router->post('colegios', [
        'as' => 'admin.colegios.colegio.store',
        'uses' => 'ColegioController@store',
        'middleware' => 'can:colegios.colegios.create'
    ]);
    $router->get('colegios/{colegio}/edit', [
        'as' => 'admin.colegios.colegio.edit',
        'uses' => 'ColegioController@edit',
        'middleware' => 'can:colegios.colegios.edit'
    ]);
    $router->put('colegios/{colegio}', [
        'as' => 'admin.colegios.colegio.update',
        'uses' => 'ColegioController@update',
        'middleware' => 'can:colegios.colegios.edit'
    ]);
    $router->delete('colegios/{colegio}', [
        'as' => 'admin.colegios.colegio.destroy',
        'uses' => 'ColegioController@destroy',
        'middleware' => 'can:colegios.colegios.destroy'
    ]);
    $router->post('set-colegio/{colegio}', [
        'as' => 'admin.colegios.colegio.set-colegio',
        'uses' => 'ColegioController@set_colegio',
        'middleware' => 'can:colegios.colegios.set-colegio'
    ]);
// append

});
