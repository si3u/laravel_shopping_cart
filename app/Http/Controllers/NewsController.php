<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\TextSection;
use Validator;

class NewsController extends Controller
{
    private $quote_of_day;

    public function __construct() {
        parent::__construct();

        $this->quote_of_day = TextSection::GetItem('quote_of_day', $this->controller_lang_id)->value;
    }

    public function Page(Request $request) {
        return view('news', [
            'news' => News::PublicGetItems(),
            'last_news' => News::GetMultipleItems(3),
            'quote_of_day' => $this->quote_of_day
        ]);
    }

    public function Show($id) {
        $validator = Validator::make([
            'id' => $id
        ], [
            'id' => 'required|exists:news,id'
        ]);
        if ($validator->fails()) {
            return abort(404);
        }

        $comments = News::GetComments($id);
        if ($comments->currentPage() > 1) {
            return view('show_news', [
                'news' => News::PublicGetItem($id),
                'comments' => $comments,
                'last_news' => News::GetMultipleItems(3),
                'quote_of_day' => $this->quote_of_day
            ])->with('autofocus', true);
        }
        return view('show_news', [
            'news' => News::PublicGetItem($id),
            'comments' => $comments,
            'last_news' => News::GetMultipleItems(3),
            'quote_of_day' => $this->quote_of_day
        ]);
    }
}
