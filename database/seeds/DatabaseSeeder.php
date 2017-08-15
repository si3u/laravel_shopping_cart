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
        $this->call('CreateTextPages');
        $this->call('CreatePrices');
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
                'name' => 'Корневая категория',
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
                'status' => true
            ]
        ];

        DB::table('active_localizations')->insert($data);
    }
}

class CreateTextPages extends Seeder {
    public function run() {
        DB::table('text_pages')->delete();
        DB::table('text_pages')->truncate();
        $data = [
            ['id' => 1, 'value' => 'Доставка и оплата', 'lang_id' => 1],
            ['id' => 1, 'value' => 'Доставка і оплата', 'lang_id' => 2],
            ['id' => 1, 'value' => 'Payment and delivery', 'lang_id' => 3],
            ['id' => 2, 'value' => 'О нас', 'lang_id' => 1],
            ['id' => 2, 'value' => 'Про нас', 'lang_id' => 2],
            ['id' => 2, 'value' => 'About us', 'lang_id' => 3],
            ['id' => 3, 'value' => 'Сотрудничество', 'lang_id' => 1],
            ['id' => 3, 'value' => 'Співробітництво', 'lang_id' => 2],
            ['id' => 3, 'value' => 'Cooperation', 'lang_id' => 3]
        ];

        DB::table('text_pages')->insert($data);
    }
}

class CreatePrices extends Seeder {
    public function run() {
        DB::table('prices')->delete();
        DB::table('prices')->truncate();

        DB::table('prices')->insert([
            'natural_canvas' => null
        ]);
    }
}

class CreateContacts extends Seeder {
    public function run() {
        DB::table('contacts')->delete();
        DB::table('contacts')->truncate();

        DB::table('contacts')->insert([
            'id' => 1
        ]);
    }
}