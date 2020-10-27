<?php

use App\Customer;
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
            factory(Customer::class)->create();
        }
    }
}
