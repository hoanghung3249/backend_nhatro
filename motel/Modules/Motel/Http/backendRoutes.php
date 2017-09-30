<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/motel'], function (Router $router) {
    $router->bind('motel', function ($id) {
        return app('Modules\Motel\Repositories\MotelRepository')->find($id);
    });
    $router->get('motels', [
        'as' => 'admin.motel.motel.index',
        'uses' => 'MotelController@index',
        'middleware' => 'can:motel.motels.index'
    ]);
    $router->get('motels/create', [
        'as' => 'admin.motel.motel.create',
        'uses' => 'MotelController@create',
        'middleware' => 'can:motel.motels.create'
    ]);
    $router->post('motels', [
        'as' => 'admin.motel.motel.store',
        'uses' => 'MotelController@store',
        'middleware' => 'can:motel.motels.create'
    ]);
    $router->get('motels/{motel}/edit', [
        'as' => 'admin.motel.motel.edit',
        'uses' => 'MotelController@edit',
        'middleware' => 'can:motel.motels.edit'
    ]);
    $router->put('motels/{motel}', [
        'as' => 'admin.motel.motel.update',
        'uses' => 'MotelController@update',
        'middleware' => 'can:motel.motels.edit'
    ]);
    $router->delete('motels/{motel}', [
        'as' => 'admin.motel.motel.destroy',
        'uses' => 'MotelController@destroy',
        'middleware' => 'can:motel.motels.destroy'
    ]);
// append

});
