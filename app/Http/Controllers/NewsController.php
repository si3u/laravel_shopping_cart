<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;

class NewsController extends Controller
{
    public function Page(Request $request) {
        return view('news', [
            'news' => News::PublicGetItems()
        ]);
    }
}
