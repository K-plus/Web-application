<?php

class DatabaseSeeder extends Seeder {

    private $tables = [
        'orders',
        'order_lines',
        'shop_product_stock',
        'shops',
        'users'
    ];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        $this->cleanDatabase();

        Eloquent::unguard();

		$this->call('UsersTableSeeder');
		$this->call('ProductsTableSeeder');
		$this->call('ShopsTableSeeder');
		$this->call('ShopProductStockTableSeeder');
	}

    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach($this->tables as $tableName)
        {
            DB::table($tableName)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

}
