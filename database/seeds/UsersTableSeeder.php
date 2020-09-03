<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理者
        DB::table('users')->insert([
            [
                'name'              => 'root',
                'email'             => 'root@root',
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'is_admin'          => 1
            ]
        ]);

        // ゲスト
        if (config('app.debug', false)) {
            DB::table('users')->insert([
                [
                    'name'              => 'guest',
                    'email'             => 'guest@guest',
                    'password'          => Hash::make('password'),
                    'remember_token'    => Str::random(10),
                    'is_admin'          => 0
                ]
            ]);
        }
    }
}
