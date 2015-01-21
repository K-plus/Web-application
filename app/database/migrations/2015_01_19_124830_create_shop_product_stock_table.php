<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopProductStockTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_product_stock', function(Blueprint $table)
		{
             $table->increments('id');
			 $table->integer('product_id')->unsigned()->index();
			 $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

			 $table->integer('shop_id')->unsigned()->index();
			 $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');

             $table->integer('stock');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_product_stock');
	}

}
