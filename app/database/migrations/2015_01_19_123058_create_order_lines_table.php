<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_lines', function(Blueprint $table)
		{
			$table->increments('id');
			
			 $table->integer('order_id')->unsigned()->index();
			 $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

			 $table->integer('product_id')->unsigned()->index();
			 $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

			$table->integer('qty');
			$table->integer('unit_price');
			$table->integer('subtotal');
			
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_lines');
	}

}
