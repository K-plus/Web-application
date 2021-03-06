<?php

use Faker\Factory as Faker;
use Kplus\Models\User;

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

        User::create([
            'name' => 'Piet de Manager',
            'email' => 'piet@kplus.nl',
            'password' => Hash::make('password123'),
            'is_admin' => '1'
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