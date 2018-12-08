<?php

use Illuminate\Database\Seeder;

class CarTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cartypes')->insert([
            'title' => str_random(7),
            'introduce' => str_random(25),]);
    }
}
