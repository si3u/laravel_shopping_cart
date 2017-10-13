<?php

namespace App\Http\Controllers;

use App\NewsComment;
use Illuminate\Http\Request;
use Validator;
use App\Traits\CacheTrait;
class NewsCommentController extends Controller
{
    public function __construct() {
        parent::__construct();

        $this->model_cache = 'NewsComment';
        $this->key_cache = 'news_comment';
        $this->tags_cache = [$this->key_cache, 'page'];
    }

    use CacheTrait;

    public function Create(Request $request) {
        $validator = Validator::make($request->all(), [
            'news_id' => 'required|integer|exists:news,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('autofocus', true)->withInput();
        }

        NewsComment::CreateItem($request->news_id, $request->name, $request->email, $request->message);

        $this->ForgetItemsOfPaginate();

        return redirect()->back()->with([
            'success' => __('news.comment.success'),
            'autofocus' => true
        ]);
    }
}
