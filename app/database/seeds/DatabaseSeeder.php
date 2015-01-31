<?php

class DatabaseSeeder extends Seeder {

    private $tables = [
        'orders',
        'order_lines',
        'users',
        'products',
        'carts',
        'cart_lines'
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
		$this->call('CartsTableSeeder');
        $this->call('StoreTableSeeder');
        $this->call('AdvertisementsTableSeeder');
        
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
