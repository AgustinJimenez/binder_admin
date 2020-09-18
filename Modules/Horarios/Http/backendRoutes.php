<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/horarios'], function (Router $router) {
    $router->bind('horarioclase', function ($id) {
        return app('Modules\Horarios\Repositories\HorarioClaseRepository')->find($id);
    });
    $router->get('horarioclases', [
        'as' => 'admin.horarios.horarioclase.index',
        'uses' => 'HorarioClaseController@index',
        'middleware' => 'can:horarios.horarioclases.index'
    ])->middleware('verifyColegioToken');

    $router->get('horarioclases/create', [
        'as' => 'admin.horarios.horarioclase.create',
        'uses' => 'HorarioClaseController@create',
        'middleware' => 'can:horarios.horarioclases.create'
    ])->middleware('verifyColegioToken');
    
    $router->post('horarioclases', [
        'as' => 'admin.horarios.horarioclase.store',
        'uses' => 'HorarioClaseController@store',
        'middleware' => 'can:horarios.horarioclases.create'
    ]);
    $router->get('horarioclases/{horarioclase}/edit', [
        'as' => 'admin.horarios.horarioclase.edit',
        'uses' => 'HorarioClaseController@edit',
        'middleware' => 'can:horarios.horarioclases.edit'
    ])->middleware('verifyColegioToken');
    $router->put('horarioclases/{horarioclase}', [
        'as' => 'admin.horarios.horarioclase.update',
        'uses' => 'HorarioClaseController@update',
        'middleware' => 'can:horarios.horarioclases.edit'
    ]);
    $router->delete('horarioclases/{horarioclase}', [
        'as' => 'admin.horarios.horarioclase.destroy',
        'uses' => 'HorarioClaseController@destroy',
        'middleware' => 'can:horarios.horarioclases.destroy'
    ]);
    $router->bind('horarioexamen', function ($id) {
        return app('Modules\Horarios\Repositories\HorarioExamenRepository')->find($id);
    });
    $router->get('horarioexamens', [
        'as' => 'admin.horarios.horarioexamen.index',
        'uses' => 'HorarioExamenController@index',
        'middleware' => 'can:horarios.horarioexamens.index'
    ])->middleware('verifyColegioToken');
    
    $router->post('horarioexamens/index_ajax', [
        'as' => 'admin.horarios.horarioexamen.index_ajax',
        'uses' => 'HorarioExamenController@index_ajax',
        'middleware' => 'can:horarios.horarioexamens.index_ajax'
    ]);
    $router->get('horarioexamens/create', [
        'as' => 'admin.horarios.horarioexamen.create',
        'uses' => 'HorarioExamenController@create',
        'middleware' => 'can:horarios.horarioexamens.create'
    ])->middleware('verifyColegioToken');;
    $router->post('horarioexamens', [
        'as' => 'admin.horarios.horarioexamen.store',
        'uses' => 'HorarioExamenController@store',
        'middleware' => 'can:horarios.horarioexamens.create'
    ]);
    $router->get('horarioexamens/{horarioexamen}/edit', [
        'as' => 'admin.horarios.horarioexamen.edit',
        'uses' => 'HorarioExamenController@edit',
        'middleware' => 'can:horarios.horarioexamens.edit'
    ]);
    $router->put('horarioexamens/{horarioexamen}', [
        'as' => 'admin.horarios.horarioexamen.update',
        'uses' => 'HorarioExamenController@update',
        'middleware' => 'can:horarios.horarioexamens.edit'
    ]);
    $router->delete('horarioexamens/{horarioexamen}', [
        'as' => 'admin.horarios.horarioexamen.destroy',
        'uses' => 'HorarioExamenController@destroy',
        'middleware' => 'can:horarios.horarioexamens.destroy'
    ]);
// append


});
