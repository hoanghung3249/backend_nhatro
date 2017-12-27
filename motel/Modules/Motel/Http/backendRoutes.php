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
    $router->get('rooms', [
        'as' => 'admin.room.room.index',
        'uses' => 'RoomController@index',
        'middleware' => 'can:room.room.index',
    ]);
    $router->get('rooms-datatable', [
        'as' => 'admin.room.room.indextable',
        'uses' => 'RoomController@indextable',
        'middleware' => 'can:room.room.index',
    ]);
    $router->get('rooms/create', [
        'as' => 'admin.room.room.create',
        'uses' => 'RoomController@create',
        'middleware' => 'can:room.room.create',
    ]);
    $router->post('rooms/create', [
        'as' => 'admin.room.room.store',
        'uses' => 'RoomController@store',
        'middleware' => 'can:room.room.create',
    ]);
    $router->get('rooms/{id}/edit', [
        'as' => 'admin.room.room.edit',
        'uses' => 'RoomController@edit',
        'middleware' => 'can:room.room.edit',
    ]);
    $router->put('rooms/{id}/edit', [
        'as' => 'admin.room.room.update',
        'uses' => 'RoomController@update',
        'middleware' => 'can:room.room.edit',
    ]);
    $router->delete('rooms-delete/{id}', [
        'as' => 'admin.room.room.delete',
        'uses' => 'RoomController@delete',
        'middleware' => 'can:room.room.destroy',
    ]);
    $router->get('ajax-status', [
        'as' => 'admin.room.room.ajaxstatus',
        'uses' => 'RoomController@changeStatus',
        'middleware' => 'can:room.room.edit',
    ]);
    $router->get('bulk-delete', [
        'as' => 'admin.room.room.bulkdelete',
        'uses' => 'RoomController@bulkDelete',
        'middleware' => 'can:room.room.destroy',
    ]);


    //Bookings
    $router->get('bookings', [
        'as' => 'admin.bookings.bookings.index',
        'uses' => 'BookingsController@index',
        'middleware' => 'can:room.room.index',
    ]);
    $router->get('bookings-datatable', [
        'as' => 'admin.bookings.bookings.indextable',
        'uses' => 'BookingsController@indextable',
        'middleware' => 'can:room.room.index',
    ]);
    $router->get('bookings/create', [
        'as' => 'admin.bookings.bookings.create',
        'uses' => 'BookingsController@create',
        'middleware' => 'can:room.room.create',
    ]);
    $router->get('autocomplete-customer', [
        'as' => 'admin.bookings.bookings.autocompletecustomer',
        'uses' => 'BookingsController@getCustomer',
        'middleware' => 'can:room.room.create',
    ]);
    $router->get('ajax-remove-id', [
        'as' => 'admin.bookings.bookings.ajaxremoveid',
        'uses' => 'BookingsController@getIDCusBySession',
        'middleware' => 'can:room.room.create',
    ]);








    //Customer
    $router->get('customer-list', [
        'as' => 'admin.customer.customer.index',
        'uses' => 'CustomerController@index',
        'middleware' => 'can:room.room.index',
    ]);
    $router->get('customer-list-datatable', [
        'as' => 'admin.customer.customer.indextable',
        'uses' => 'CustomerController@indextable',
        'middleware' => 'can:room.room.index',
    ]);
    $router->get('customer-detail', [
        'as' => 'admin.customer.customer.customerdetail',
        'uses' => 'CustomerController@getCustomerDetail',
        'middleware' => 'can:room.room.index',
    ]);
    $router->get('customer/create', [
        'as' => 'admin.customer.customer.create',
        'uses' => 'CustomerController@create',
        'middleware' => 'can:room.room.index',
    ]);
    $router->post('customer/create', [
        'as' => 'admin.customer.customer.store',
        'uses' => 'CustomerController@store',
        'middleware' => 'can:room.room.create',
    ]);
    $router->get('customer/{id}/edit', [
        'as' => 'admin.customer.customer.edit',
        'uses' => 'CustomerController@edit',
        'middleware' => 'can:room.room.edit',
    ]);
    $router->put('customer/{id}/edit', [
        'as' => 'admin.customer.customer.update',
        'uses' => 'CustomerController@update',
        'middleware' => 'can:room.room.edit',
    ]);
    $router->delete('customer-delete/{id}', [
        'as' => 'admin.customer.customer.delete',
        'uses' => 'CustomerController@delete',
        'middleware' => 'can:room.room.destroy',
    ]);
    $router->get('bulk-delete-customer', [
        'as' => 'admin.customer.customer.bulkdelete',
        'uses' => 'CustomerController@bulkDelete',
        'middleware' => 'can:room.room.destroy',
    ]);




    //Config
    $router->get('config', [
        'as' => 'admin.config.config.index',
        'uses' => 'ConfigController@index',
        'middleware' => 'can:room.room.index',
    ]);
    $router->get('config-datatable', [
        'as' => 'admin.config.config.indextable',
        'uses' => 'ConfigController@indextable',
        'middleware' => 'can:room.room.index',
    ]);
    $router->post('config-post', [
        'as' => 'admin.config.config.post',
        'uses' => 'ConfigController@postConfig',
        'middleware' => 'can:room.room.index',
    ]);
});
