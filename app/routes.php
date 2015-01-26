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
	
    Route::get('/logout', array('as' => 'logout', 'uses' => 'SessionController@getLogout'));
	Route::get('/login', array('as' => 'login', 'uses' => 'SessionController@getIndex'));
    Route::post('/authenticate', array('as' => 'authenticate', 'uses' => 'SessionController@postLogin'));
    
    Route::get('/', array('as' => 'home', 'uses' => 'HomeController@getIndex'));

    // Need the user to log in
    Route::group(array('before' => 'auth'), function(){
    	Route::get('/cart', array('as' => 'cart', 'uses' => 'CartController@getIndex'));
	});
});

View::composer('kplus/includes/MenuView.twig', function($view){
    if(Session::has('username')) {
        $view->with('username', Crypt::decrypt(Session::get('username')) );
    } else {
        $view->with('username', 'Gast');
    }
});