<?php

use Illuminate\Database\Seeder;

class ResponseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            ['id' => TYPE_SINGLE_RESPONSE, 'name' => 'Una respuesta', 'system_evaluation' => true],
            ['id' => TYPE_MULTIPLE_RESPONSE, 'name' => 'Varias respuestas', 'system_evaluation' => true],
            ['id' => TYPE_OPEN_RESPONSE, 'name' => 'Respuesta abierta', 'system_evaluation' => false],
            ['id' => TYPE_FILE_RESPONSE, 'name' => 'Subir archivo', 'system_evaluation' => false],
        ]);
    }
}
