<?php

use Illuminate\Database\Seeder;

class SessionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('session_types')->insert([
            ['id' => SESSION_FACE, 'name' => 'Presencial'],
            ['id' => SESSION_VIRTUAL, 'name' => 'Virtual'],
        ]);
    }
}
