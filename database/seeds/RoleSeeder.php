<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => ROLE_ADMIN, 'name' => 'admin'],
            ['id' => ROLE_COORDINATOR, 'name' => 'coordinador'],
        ]);
    }
}
