<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
            ['id' => PRODUCT_COURSE, 'name' => 'Curso'],
            ['id' => PRODUCT_SIMULATOR, 'name' => 'Simulador'],
            ['id' => PRODUCT_EXAM, 'name' => 'Evaluacion'],
        ]);
    }
}
