<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            [ 'name' => '個' ],
            [ 'name' => '本' ],
            [ 'name' => '枚' ],
            [ 'name' => '台' ],
            [ 'name' => '組' ],
        ]);
    }
}
