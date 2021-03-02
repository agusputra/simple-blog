<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        if (!User::firstWhere('email', 'user1@example.com')) {
            User::create([
                'name' => 'User1',
                'email' => 'user1@example.com',
                'password' => Hash::make('123456')
            ]);
        }
    }
}
