<?php

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        User::create([
            'name' => 'Jeroen Lammerts',
            'email' => 'jeroenlammerts@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'name' => 'Vasco de Krijger',
            'email' => 'vascodekrijger@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'name' => 'Wahid Nory',
            'email' => 'wahid.kl@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::create([
            'name' => 'Bas Helder',
            'email' => 'helderbas@gmail.com',
            'password' => Hash::make('password')
        ]);

//		foreach(range(1, 25) as $index)
//		{
//			User::create([
//				'name' => $faker->name,
//				'email' => $faker->email,
//				'password' => $faker->word
//			]);
//		}
	}

}