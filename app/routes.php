<?php

Route::group(array('prefix' => 'api/v1', 'namespace' => 'Kplus\Api\Controllers'), function()
{
    Route::post('customer/login', 'CustomerApiController@login');
    Route::get('product/search/{term}', 'ProductApiController@search');
    Route::get('product/{id}', 'ProductApiController@show');
    Route::get('ads/store/{id}', 'AdvertisementController@getAdvertisement');

    Route::group(array('before' => 'auth.basic'), function()
    {
        Route::get('cart', 'CartApiController@index');
        Route::post('cart/product/add', 'CartApiController@addProduct');
        Route::post('cart/product/update', 'CartApiController@updateProduct');
        Route::post('cart/product/delete', 'CartApiController@deleteProduct');
        Route::post('cart/product/substract', 'CartApiController@substractProduct');
        
        Route::post('order/add', 'OrderApiController@processOrder');

        Route::group(array('before'=> 'is_admin'), function() {
            Route::post('product/create', 'ProductApiController@create');
            Route::post('product/update/{id}', 'ProductApiController@update');
            Route::get('product/delete/{id}', 'ProductApiController@delete');
        });
       
    });
});

Route::group(array('namespace' => 'Kplus\Front\Controllers'), function(){
	
    Route::get('/logout', array('as' => 'logout', 'uses' => 'SessionController@getLogout'));
	Route::get('/login', array('as' => 'login', 'uses' => 'SessionController@getIndex'));
    Route::post('/authenticate', array('as' => 'authenticate', 'uses' => 'SessionController@postLogin'));
    
    Route::get('/registreer', array('as' => 'registration', 'uses' => 'CustomerController@getRegistrationIndex'));
    Route::post('/register', array('as' => 'registration', 'uses' => 'CustomerController@postRegistration'));

    Route::get('/', array('as' => 'home', 'uses' => 'HomeController@getIndex'));
    Route::get('/producten', array('as' => 'products', 'uses' => 'ProductController@getIndex'));

    // Need the user to log in
    Route::group(array('before' => 'auth'), function(){
    	Route::get('/boodschappenlijst', array('as' => 'cart', 'uses' => 'CartController@getIndex'));
        Route::get('/facturen', array('as' => 'orders', 'uses' => 'OrderController@getIndex'));
	});

    // The admin needs to be logged in
    Route::group(array('before' => 'is_admin'), function(){
        Route::get('/voorraadbeheer', array('as' => 'stockmanagement', 'uses' => 'StockController@getIndex'));
        Route::get('/voorraadbeheer/product/{product_id}', 'StockController@show');
        Route::get('/voorraadbeheer/nieuw/product', 'StockController@create');
    });
});

View::composer('kplus/includes/MenuView.twig', function($view){
    if(Session::has('username') && Session::has('is_admin') ) {
        $view->with('username', Crypt::decrypt(Session::get('username')) );
        $view->with('is_admin', Crypt::decrypt(Session::get('is_admin')) );
    } else {
        $view->with('username', 'Gast');
    }

});

View::composer('kplus/BaseView.twig', function($view){
    $view->with('baseurl' , Config::get('app.baseurl') );
    $view->with('SITE', Config::get('app.constants.site') );
    if(Session::has('username')){
        $view->with('username', Crypt::decrypt(Session::get('username')) );
    } else {
        $view->with('username', 'Gast');
    }
});