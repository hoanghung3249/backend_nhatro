<?php
use Illuminate\Routing\Router;
/** @var Router $router */
$router->group(['prefix' =>'/members', 'middleware' => ['auth:api']], function (Router $router) {
        $router->get('getLogout',['uses'=>'AuthController@getLogout','as'=>'api.members.members.getLogout', 'before'=>'is_guest']);
        $router->post('change-password',['uses'=>'AuthController@postChangepassword','as'=>'api.members.members.postchangepassword', 'before'=>'is_guest']);
        
});
//,'middleware' => ['apiLog']
$router->group(['prefix' =>'/members'], function (Router $router) {
       $router->post('postLogin',['uses'=>'AuthController@postLogin','as'=>'api.members.members.postLogin', 'before'=>'is_guest']);
       $router->post('postSignup',['uses'=>'AuthController@postSignup','as'=>'api.members.members.postSignup', 'before'=>'is_guest']);
       $router->get('senttomail',['uses'=>'AuthController@activeUser','as'=>'api.members.members.senttomail', 'before'=>'is_guest']);
       $router->get('listcountry',['uses'=>'AuthController@getListcountry','as'=>'api.members.members.listcountry', 'before'=>'is_guest']);
       $router->post('forgot-password',['uses'=>'AuthController@postForgotpassword','as'=>'api.members.members.postForgotpassword', 'before'=>'is_guest']);
       $router->get('newpassword',['uses'=>'AuthController@getNewpassword','as'=>'api.members.members.getNewpassword', 'before'=>'is_guest']);
       $router->post('newpassword',['uses'=>'AuthController@postNewpassword','as'=>'api.members.members.postNewpassword', 'before'=>'is_guest']);
});