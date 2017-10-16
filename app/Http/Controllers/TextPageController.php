<?php

namespace App\Http\Controllers;

use App\TextPage;
use Illuminate\Http\Request;

class TextPageController extends Controller
{
    public function __construct() {
        parent::__construct();


    }
    public function Page() {
        $id = null;
        switch ($this->route_name) {
            case 'public.text_page.payment':
                $id = 1;
                break;
            case 'public.text_page.delivery':
                $id = 2;
                break;
            case 'public.text_page.cooperation':
                $id = 3;
                break;
        }

        return view('text_page', [
            'value' => TextPage::GetItem($id, $this->controller_lang_id)->value
        ]);
    }
}
