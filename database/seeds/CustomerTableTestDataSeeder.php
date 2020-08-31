<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTableTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('customers')->insert([
                [
                    'name'          => "Customer $i",
                    'postal_code'   => "111-2222",
                    'address'       => "Nagoya, Aichi, Japan",
                    'tel_no'        => "052-123-4567"
                ]
            ]);
        }
    }
}
