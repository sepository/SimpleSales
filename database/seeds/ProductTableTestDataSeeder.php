<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('products')->insert([
                [
                    'name'      => "Product $i",
                    'price'     => 1000,
                    'unit_id'   => 1,
                    'summary'   => 'Test data.'
                ]
            ]);
        }
    }
}
