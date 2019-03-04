<?php

use Illuminate\Database\Seeder;

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            'name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@concepta.app',
            'password' => '',
            'username' => 'admin',
            'personal_email' => 'personal@concepta.app',
            'dni' => '00000000',
        ]);
    }
}
