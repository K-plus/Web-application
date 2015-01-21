<?php

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		 User::create([
		 	'name' => 'John Doe',
		 	'email' => 'johndoe@gmail.com',
		 	'password' => Hash::make('password')
		 ]);

		foreach(range(1, 25) as $index)
		{
			User::create([
				'name' => $faker->name,
				'email' => $faker->email,
				'password' => $faker->word
			]);
		}
	}

}