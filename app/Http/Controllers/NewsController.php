<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use Validator;
class NewsController extends Controller
{
    public function Page(Request $request) {
        return view('news', [
            'news' => News::PublicGetItems(),
            'last_news' => News::GetMultipleItems(3)
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
                'last_news' => News::GetMultipleItems(3)
            ])->with('autofocus', true);
        }
        return view('show_news', [
            'news' => News::PublicGetItem($id),
            'comments' => $comments,
            'last_news' => News::GetMultipleItems(3)
        ]);
    }
}
