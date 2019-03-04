<?php

use Illuminate\Database\Seeder;

class MultimediaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('multimedia_types')->insert([
            ['id' => MULTIMEDIA_TYPE_IMAGE, 'name' => 'Imagen'],
            ['id' => MULTIMEDIA_TYPE_VIDEO_EMBED, 'name' => 'Vídeo'],
        ]);
    }
}
