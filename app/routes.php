<?php

Route::group(array('prefix' => 'api/v1', 'namespace' => 'Kplus\Api\Controllers'), function()
{
    Route::post('customer/login', 'CustomerApiController@login');

    Route::group(array('before' => 'auth.basic'), function()
    {
        Route::get('cart', 'CartApiController@index');
        Route::post('cart/product/add', 'CartApiController@addProduct');
        Route::post('cart/product/update', 'CartApiController@updateProduct');
        Route::post('cart/product/delete', 'CartApiController@deleteProduct');

        Route::get('product/{id}', 'ProductApiController@show');
        Route::get('product/search/{term}', 'ProductApiController@search');

        Route::post('order/add', 'OrderApiController@createOrder');
    });
});

Route::group(array('namespace' => 'Kplus\Front\Controllers'), function(){
	
	Route::get('/login', 'LoginController@getIndex');

	Route::group(array('before' => 'auth'), function(){
		Route::get('/', 'HomeController@getIndex');
	});
});