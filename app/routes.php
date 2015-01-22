<?php

// , 'before' => 'auth.basic'
Route::group(['prefix' => 'api/v1'], function()
{


    Route::get('cart', 'CartApiController@index');

    // POST /customer/login (email, password)

    // GET /product/{id}

    // GET /cart
    // POST /cart/product/add (id)
    // POST /cart/product/update (id, qty)
    // POST /cart/product/delete (id)




//    Route::get('/products/{id}', function ($id) {
//        //return Product::find($id);
//    });

    //Route::resource('products', 'ProductsController');
    //Route::resource('orders', 'OrdersController');

});