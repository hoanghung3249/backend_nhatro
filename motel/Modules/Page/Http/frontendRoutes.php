<?php

use Illuminate\Routing\Router;

/** @var Router $router */
if (! App::runningInConsole()) {
    $router->get('/', [
        'uses' => 'PublicController@homepage',
        'as' => 'homepage',
        'middleware' => config('asgard.page.config.middleware'),
    ]);
    // $router->get('/backend', [
    //     'uses' => 'PublicController@backend',
    //     'as' => 'login',
    //     //'middleware' => config('asgard.page.config.middleware'),
    // ]);
    $router->any('{uri}', [
        'uses' => 'PublicController@uri',
        'as' => 'page',
        'middleware' => config('asgard.page.config.middleware'),
    ])->where('uri', '.*');
}
