<?php

use App\Invoice;
use Illuminate\Database\Seeder;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 10;
        for ($i = 0; $i < $count; $i++) {
            factory(Invoice::class)->create();
        }
    }
}
