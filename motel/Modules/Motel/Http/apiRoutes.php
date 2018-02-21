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
    $router->get('get-news-of-current-user', [
        'as' => 'admin.motel.motel.getnewsofcurrentuser',
        'uses' => 'ApiMotelController@getNewsOfCurrenUser',
    ]);
    $router->get('delete-news-of-user', [
        'as' => 'admin.motel.motel.deletenewsofuser',
        'uses' => 'ApiMotelController@deleteNewsOfUser',
    ]);
    $router->get('filter-motel', [
        'as' => 'admin.motel.motel.filtermotel',
        'uses' => 'ApiMotelController@getListFilter',
    ]);
    $router->post('post-news', [
        'as' => 'admin.motel.motel.postnews',
        'uses' => 'ApiMotelController@postNews',
    ]);
    $router->get('get-room-of-user', [
        'as' => 'admin.motel.motel.getroomofuser',
        'uses' => 'ApiMotelController@getRoomOfUser',
    ]);
    $router->get('like-news', [
        'as' => 'admin.motel.motel.likenews',
        'uses' => 'ApiMotelController@likeNews',
    ]);
    $router->get('get-news-liked-of-user', [
        'as' => 'admin.motel.motel.getnewslikedofuser',
        'uses' => 'ApiMotelController@getNewsLikedOfUser',
    ]);
    $router->get('unlike-news-by-user', [
        'as' => 'admin.motel.motel.unlikenewsbyuser',
        'uses' => 'ApiMotelController@unlikeNewsByUser',
    ]);   
});