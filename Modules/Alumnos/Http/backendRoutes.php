<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/alumnos'], function (Router $router) {
    $router->bind('alumno', function ($id) {
        return app('Modules\Alumnos\Repositories\AlumnoRepository')->find($id);
    });
    $router->get('alumnos', [
        'as' => 'admin.alumnos.alumno.index',
        'uses' => 'AlumnoController@index',
        'middleware' => 'can:alumnos.alumnos.index'
    ])->middleware('verifyColegioToken');

    $router->get('alumnos/create', [
        'as' => 'admin.alumnos.alumno.create',
        'uses' => 'AlumnoController@create',
        'middleware' => 'can:alumnos.alumnos.create'
    ])->middleware('verifyColegioToken');

    $router->post('alumnos', [
        'as' => 'admin.alumnos.alumno.store',
        'uses' => 'AlumnoController@store',
        'middleware' => 'can:alumnos.alumnos.create'
    ])->middleware('verifyColegioToken');

    $router->get('alumnos/{alumno}/edit', [
        'as' => 'admin.alumnos.alumno.edit',
        'uses' => 'AlumnoController@edit',
        'middleware' => 'can:alumnos.alumnos.edit'
    ])->middleware('verifyColegioToken');

    $router->put('alumnos/{alumno}', [
        'as' => 'admin.alumnos.alumno.update',
        'uses' => 'AlumnoController@update',
        'middleware' => 'can:alumnos.alumnos.edit'
    ])->middleware('verifyColegioToken');

    $router->delete('alumnos/{alumno}', [
        'as' => 'admin.alumnos.alumno.destroy',
        'uses' => 'AlumnoController@destroy',
        'middleware' => 'can:alumnos.alumnos.destroy'
    ]);

    $router->post('alumnos/index-ajax', [
        'as' => 'admin.alumnos.alumno.index-ajax',
        'uses' => 'AlumnoController@indexAjax',
        'middleware' => 'can:alumnos.alumnos.index'
    ]);

    $router->get('alumnos/remote-select', [
        'as' => 'admin.alumnos.alumno.remote-select',
        'uses' => 'AlumnoController@remoteChained',
        'middleware' => 'can:alumnos.alumnos.create'
    ]);

    $router->get('alumnos/index-responsables/{alumno}', [
        'as' => 'admin.alumnos.alumno.index-responsables',
        'uses' => 'AlumnoController@indexResponsables',
        'middleware' => 'can:alumnos.alumnos.index'
    ]);

    $router->post('alumnos/add-responsable', [
        'as' => 'admin.alumnos.alumno.add-responsable',
        'uses' => 'AlumnoController@addResponsable',
        'middleware' => 'can:alumnos.alumnos.create'
    ]);

    $router->delete('alumnos/remove-responsable/{id}', [
        'as' => 'admin.alumnos.alumno.remove-responsable',
        'uses' => 'AlumnoController@removeResponsable',
        'middleware' => 'can:alumnos.alumnos.destroy'
    ]);

    $router->bind('relacion', function ($id) {
        return app('Modules\Alumnos\Repositories\RelacionRepository')->find($id);
    });
    $router->get('relacions', [
        'as' => 'admin.alumnos.relacion.index',
        'uses' => 'RelacionController@index',
        'middleware' => 'can:alumnos.relacions.index'
    ]);
    $router->get('relacions/create', [
        'as' => 'admin.alumnos.relacion.create',
        'uses' => 'RelacionController@create',
        'middleware' => 'can:alumnos.relacions.create'
    ]);
    $router->post('relacions', [
        'as' => 'admin.alumnos.relacion.store',
        'uses' => 'RelacionController@store',
        'middleware' => 'can:alumnos.relacions.create'
    ]);
    $router->get('relacions/{relacion}/edit', [
        'as' => 'admin.alumnos.relacion.edit',
        'uses' => 'RelacionController@edit',
        'middleware' => 'can:alumnos.relacions.edit'
    ]);
    $router->put('relacions/{relacion}', [
        'as' => 'admin.alumnos.relacion.update',
        'uses' => 'RelacionController@update',
        'middleware' => 'can:alumnos.relacions.edit'
    ]);
    $router->delete('relacions/{relacion}', [
        'as' => 'admin.alumnos.relacion.destroy',
        'uses' => 'RelacionController@destroy',
        'middleware' => 'can:alumnos.relacions.destroy'
    ]);
// append


});
