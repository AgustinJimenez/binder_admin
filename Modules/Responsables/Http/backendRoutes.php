<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/responsables'], function (Router $router) 
{
    $router->bind('responsable', function ($id) 
    {
        return \Responsable::find($id);
    });

    $router->get('responsables', [
        'as' => 'admin.responsables.responsable.index',
        'uses' => 'ResponsableController@index',
        'middleware' => 'can:responsables.responsables.index'
    ])->middleware('verifyColegioToken');
    
    $router->get('responsables/create', [
        'as' => 'admin.responsables.responsable.create',
        'uses' => 'ResponsableController@create',
        'middleware' => 'can:responsables.responsables.create'
    ])->middleware('verifyColegioToken');

    $router->post('responsables', [
        'as' => 'admin.responsables.responsable.store',
        'uses' => 'ResponsableController@store',
        'middleware' => 'can:responsables.responsables.create'
    ])->middleware('verifyColegioToken');

    $router->get('responsables/{responsable}/edit', [
        'as' => 'admin.responsables.responsable.edit',
        'uses' => 'ResponsableController@edit',
        'middleware' => 'can:responsables.responsables.edit'
    ])->middleware('verifyColegioToken');

    $router->put('responsables/{responsable}', [
        'as' => 'admin.responsables.responsable.update',
        'uses' => 'ResponsableController@update',
        'middleware' => 'can:responsables.responsables.edit'
    ])->middleware('verifyColegioToken');

    $router->delete('responsables/{responsable}', [
        'as' => 'admin.responsables.responsable.destroy',
        'uses' => 'ResponsableController@destroy',
        'middleware' => 'can:responsables.responsables.destroy'
    ])->middleware('verifyColegioToken');

    $router->post('responsables/index-ajax', [
        'as' => 'admin.responsables.responsable.index-ajax',
        'uses' => 'ResponsableController@indexAjax',
        'middleware' => 'can:responsables.responsables.index'
    ]);

    $router->get('responsables/index-alumnos/{responsable}', [
        'as' => 'admin.responsables.responsable.index-alumnos',
        'uses' => 'ResponsableController@indexAlumnos',
        'middleware' => 'can:responsables.responsables.index'
    ])->middleware('verifyColegioToken');

    $router->delete('responsables/remove-alumno/{id}', [
        'as' => 'admin.responsables.responsable.remove-alumno',
        'uses' => 'ResponsableController@removeAlumno',
        'middleware' => 'can:responsables.responsables.destroy'
    ])->middleware('verifyColegioToken');

    $router->put('responsables/update_responsable_ajax/{responsable}', 
        [
        'as' => 'admin.responsables.responsable.update_responsable_ajax',
        'uses' => 'ResponsableController@update_responsable_ajax',
        'middleware' => 'can:responsables.responsables.update_responsable_ajax'
    ]);

    $router->get('responsables/get_suscripciones/{responsable}', 
    [
        'as' => 'admin.responsables.responsable.get_suscripciones',
        'uses' => 'ResponsableController@get_suscripciones',
        'middleware' => 'can:responsables.responsables.get_suscripciones'
    ]);

});
