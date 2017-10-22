<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductComment\SearchRequest;
use App\Http\Requests\Admin\WallpaperComment\UpdateRequest;
use App\WallpaperComment;
use Illuminate\Support\Facades\Validator;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;

class WallpaperCommentController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'WallpaperComment';
        $this->key_cache = 'wallpaper_comment';
    }

    use CacheTrait;

    public function Page(Request $request) {
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }

        $this->tags_cache = [$this->key_cache, 'page', $page];
        $this->method_cache = 'GetData';

        $data = (object)[
            'title' => 'Управление комментариями',
            'route_name' => $this->route_name,
            'comments' => $this->GetOrCreateItemFromCache()
        ];
        return view('admin.items.wallpaper.main', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:wallpaper_comments,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $comment = WallpaperComment::GetData($id);
        if ($comment->read_status == false) {
            $this->tags_cache = [$this->key_cache, 'page'];
            $this->ForgetItemsOfPaginate();

            $comment->read_status = true;
            $comment->save();
        }

        $data = (object)[
            'title' => 'Работа с комментарием',
            'route_name' => $this->route_name,
            'comment' => $comment
        ];
        return view('admin.items.wallpaper.comments.work_on', ['page' => $data]);
    }

    public function Update(UpdateRequest $request) {
        if (WallpaperComment::UpdateItem($request->id,
                                         $request->status,
                                         $request->name,
                                         $request->email,
                                         $request->message)) {

            $this->tags_cache = [$this->key_cache, 'page'];
            $this->ForgetItemsOfPaginate();

            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }

    public function Delete($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:wallpaper_comments,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        WallpaperComment::DeleteItem($id);

        $this->tags_cache = [$this->key_cache, 'page'];
        $this->ForgetItemsOfPaginate();

        return redirect()->route('admin/wallpaper/comments')->with('success', 'Комментарий успешно удален');
    }

    public function Search(SearchRequest $request) {
        $data = (object)[
            'title' => 'Поиск по комментариям',
            'route_name' => $this->route_name,
            'comments' => WallpaperComment::Search($request)
        ];
        if ($request->has('email')) {
            $data->old_email = $request->email;
        }
        if ($request->has('text_search')) {
            $data->old_text_search = $request->text_search;
        }
        if ($request->has('check_status')) {
            $data->old_check_status = $request->check_status;
        }
        if ($request->has('read_status')) {
            $data->old_read_status = $request->read_status;
        }
        if ($request->has('date_start')) {
            $data->old_date_start = $request->date_start;
        }
        if ($request->has('date_end')) {
            $data->old_date_end = $request->date_end;
        }
        if ($request->has('vendor_code')) {
            $data->old_vendor_code = $request->vendor_code;
        }

        return view('admin.items.wallpaper.comments.main', ['page' => $data]);
    }

    public function SendTrueStatus($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:wallpaper_comments,id']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
    }
}
