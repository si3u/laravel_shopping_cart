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
        $this->call('CreateLocalization');
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

        $data = [
            [
                'slug' => 'und-ru',
                'parent_id' => 0,
                'sorting_order' => 0,
            ]
        ];
        DB::table('categories')->insert($data);

        DB::table('data_categories')->delete();
        DB::table('data_categories')->truncate();

        $data = [
            [
                'category_id' => 1,
                'name' => 'Не определено',
                'lang_id' => 1,
            ]
        ];
        DB::table('data_categories')->insert($data);
    }
}

class CreateLocalization extends Seeder {
    public function run() {
        DB::table('active_localizations')->delete();
        DB::table('active_localizations')->truncate();

        $data = [
            [
                'lang' => 'ru',
                'name' => 'Русский',
                'status' => true
            ],
            [
                'lang' => 'ua',
                'name' => 'Украинский',
                'status' => false
            ],
            [
                'lang' => 'en',
                'name' => 'English',
                'status' => false
            ]
        ];

        DB::table('active_localizations')->insert($data);
    }
}
