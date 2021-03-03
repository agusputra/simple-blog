<?php

use App\Enums\ROLE_TYPE;
use App\Role;
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

        if (!Role::count()) {
            $roleUser = Role::create(['name' => ROLE_TYPE::user]);
            $roleManager = Role::create(['name' => ROLE_TYPE::manager]);
            $roleAdmin = Role::create(['name' => ROLE_TYPE::admin]);
        }

        if (!User::count()) {
            User::create([
                'name' => 'User1',
                'email' => 'user1@example.com',
                'password' => Hash::make('123456')
            ])
                ->roles()
                ->attach($roleUser->id);

            User::create([
                'name' => 'Manager1',
                'email' => 'manager1@example.com',
                'password' => Hash::make('123456')
            ])
                ->roles()
                ->attach($roleManager->id);

            User::create([
                'name' => 'Admin1',
                'email' => 'admin1@example.com',
                'password' => Hash::make('123456')
            ])
                ->roles()
                ->attach($roleAdmin->id);
        }
    }
}
