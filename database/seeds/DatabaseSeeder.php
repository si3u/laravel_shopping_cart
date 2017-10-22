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
        $this->call('CreateDefaultCategories');
        $this->call('CreateLocalization');
        $this->call('CreateTextPages');
        $this->call('CreatePrices');
        $this->call('CreateContacts');
        $this->call('CreateContactData');
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

class CreateDefaultCategories extends Seeder {
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

        //wallpaper
        DB::table('wallpaper_categories')->delete();
        DB::table('wallpaper_categories')->truncate();

        $data = [
            [
                'slug' => 'und-ru',
                'parent_id' => 0,
                'sorting_order' => 0,
            ]
        ];
        DB::table('wallpaper_categories')->insert($data);

        DB::table('data_wallpaper_categories')->delete();
        DB::table('data_wallpaper_categories')->truncate();

        $data = [
            [
                'category_id' => 1,
                'name' => 'Корневая категория',
                'lang_id' => 1,
            ]
        ];
        DB::table('data_wallpaper_categories')->insert($data);
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
            ['id' => 1, 'value' => 'Оплата', 'lang_id' => 1],
            ['id' => 1, 'value' => 'Оплата', 'lang_id' => 2],
            ['id' => 1, 'value' => 'Payment', 'lang_id' => 3],
            ['id' => 2, 'value' => 'Доставка', 'lang_id' => 1],
            ['id' => 2, 'value' => 'Доставка', 'lang_id' => 2],
            ['id' => 2, 'value' => 'Delivery', 'lang_id' => 3],
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
            ['contact_id' => 1, 'lang_id' => 1],
            ['contact_id' => 1, 'lang_id' => 2],
            ['contact_id' => 1, 'lang_id' => 3],
        ]);
    }
}

class CreateContactData extends Seeder {
    public function run() {
        DB::table('data_contacts')->delete();
        DB::table('data_contacts')->truncate();

        DB::table('data_contacts')->insert([
            'slug' => 'quote_of_day'
        ]);
    }
}

class CreateQuoteOfDay extends Seeder {
    public function run() {
        DB::table('text_sections')->delete();
        DB::table('text_sections')->truncate();

        DB::table('text_sections')->insert([
            'slug' => 'quote_of_day'
        ]);
    }
}
