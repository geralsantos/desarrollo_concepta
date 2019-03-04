<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(SessionTypeSeeder::class);
        $this->call(MultimediaTypeSeeder::class);
        $this->call(ResponseTypeSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(DefaultUsersSeeder::class);
    }
}
