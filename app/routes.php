<?php

Route::group(['prefix' => 'api/v1'], function()
{
    Route::post('customer/login', 'CustomerApiController@login');

    Route::group(array('before' => 'auth.basic'), function()
    {
        Route::get('cart', 'CartApiController@index');
        Route::post('cart/product/add', 'CartApiController@addProduct');
        Route::post('cart/product/update', 'CartApiController@updateProduct');
        Route::post('cart/product/delete', 'CartApiController@deleteProduct');

        Route::get('product/{id}', 'ProductApiController@show');
    });
});