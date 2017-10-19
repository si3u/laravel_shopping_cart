<?php

namespace App\Http\Controllers;

use App\NewsComment;
use Illuminate\Http\Request;
use Validator;
use App\Traits\CacheTrait;
use App\Http\Requests\News\CreateRequest;

class NewsCommentController extends Controller
{
    public function __construct() {
        parent::__construct();

        $this->model_cache = 'NewsComment';
        $this->key_cache = 'news_comment';
        $this->tags_cache = [$this->key_cache, 'page'];
    }

    use CacheTrait;

    public function Create(CreateRequest $request) {

        NewsComment::CreateItem($request->news_id, $request->name, $request->email, $request->message);

        $this->ForgetItemsOfPaginate();

        return response()->json([
            'status' => 'success',
            'message' => __('news.comment.success')
        ]);
    }
}
