<?php
use Illuminate\Routing\Router;
$router->group(['prefix' =>'/motel','middleware'=>['auth:api','motel.api.key']], function (Router $router) {
	$router->get('send-mail-again', [
        'as' => 'admin.motel.motel.sendmailagain',
        'uses' => 'ApiMotelController@SendMailAgain',
    ]);
	$router->get('update-roles', [
        'as' => 'admin.motel.motel.sendmailagain',
        'uses' => 'ApiMotelController@getUpdateRoles',
    ]);
	$router->post('update-profile', [
        'as' => 'admin.motel.motel.updateprofile',
        'uses' => 'ApiMotelController@postUpdateProfile',
    ]);
    $router->get('get-news', [
        'as' => 'admin.motel.motel.getnews',
        'uses' => 'ApiMotelController@getNews',
    ]);
    $router->get('filter-motel', [
        'as' => 'admin.motel.motel.filtermotel',
        'uses' => 'ApiMotelController@getListFilter',
    ]);
    $router->post('post-news', [
        'as' => 'admin.motel.motel.postnews',
        'uses' => 'ApiMotelController@postNews',
    ]);   
});