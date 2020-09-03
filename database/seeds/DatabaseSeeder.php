<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(UnitsTableSeeder::class);

        if (config('app.debug', false)) {
            $this->call(CustomerTableTestDataSeeder::class);
            $this->call(ProductTableTestDataSeeder::class);
        }
    }
}
