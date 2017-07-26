<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('AdminCreate');
    }
}
class AdminCreate extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'login' => 'admin',
                'password' => Hash::make('admin'),
            ],
            [
                'login' => 'admin_reserved',
                'password' => Hash::make('aotP39'),
            ]
        ];

        DB::table('users')->delete();
        DB::table('users')->truncate();
        DB::table('users')->insert($data);
    }
}
