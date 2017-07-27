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
        $this->call('CreateAdmin');
        $this->call('CreateDefaultCategory');
    }
}
class CreateAdmin extends Seeder {
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

class CreateDefaultCategory extends Seeder {
    public function run() {
        DB::table('categories')->delete();
        DB::table('categories')->truncate();

        $now_date = \Carbon\Carbon::now();
        DB::table('categories')->insert([
            'name' => 'Не определено',
            'slug' => 'null',
            'created_at' => $now_date,
            'updated_at' => $now_date,
        ]);
    }
}
