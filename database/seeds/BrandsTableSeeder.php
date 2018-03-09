<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert(['name' => 'ACNE']);
        DB::table('brands')->insert(['name' => 'RONHILL']);
        DB::table('brands')->insert(['name' => 'ALBIRRD']);
        DB::table('brands')->insert(['name' => 'ODDMOLLY']);
        DB::table('brands')->insert(['name' => 'STASIS']);


    }
}
