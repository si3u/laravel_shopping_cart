<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductReview\SearchRequest;
use App\Http\Requests\Admin\WallpaperReview\UpdateRequest;
use App\WallpaperReview;
use Illuminate\Support\Facades\Validator;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;

class WallpaperReviewController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'WallpaperReview';
        $this->key_cache = 'wallpaper_review';
        $this->tags_cache = ['wallpaper_review', 'page'];
    }

    use CacheTrait;

    public function Page(Request $request) {
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }

        $this->tags_cache = ['wallpaper_review', 'page', $page];
        $this->method_cache = 'GetData';

        $data = (object)[
            'title' => 'Управление отзывами',
            'route_name' => $this->route_name,
            'reviews' => $this->GetOrCreateItemFromCache()
        ];
        return view('admin.items.wallpaper.reviews.main', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:wallpaper_reviews,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $review = WallpaperReview::GetData($id);
        if (!$review->read_status) {
            $this->ForgetItemsOfPaginate();

            $review->read_status = true;
            $review->save();
        }
        $data = (object)[
            'title' => 'Работа с отзывом',
            'route_name' => $this->route_name,
            'review' => $review,
        ];

        return view('admin.items.wallpaper.reviews.work_on', ['page' => $data]);
    }

    public function Update(UpdateRequest $request) {
        if (WallpaperReview::UpdateItem($request->id, $request->status, $request->score, $request->name,
                                      $request->email, $request->message)) {

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
            ['id' => 'required|integer|exists:wallpaper_reviews,id']
        );
        if ($validator->fails()) {
            return redirect()->route('wallpaper/reviews')->withErrors($validator);
        }

        WallpaperReview::DeleteItem($id);

        $this->ForgetItemsOfPaginate();

        return redirect()->route('wallpaper/reviews')->with('success', 'Отзыв успешно удален');
    }

    public function Search(SearchRequest $request) {
        $data = (object)[
            'title' => 'Поиск по отзывам',
            'route_name' => $this->route_name,
            'reviews' => WallpaperReview::Search($request),
        ];
        if ($request->has('vendor_code')) {
            $data->old_vendor_code = $request->vendor_code;
        }
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
        if ($request->has('score')) {
            $data->old_score = $request->score;
        }
        if ($request->has('date_start')) {
            $data->old_date_start = $request->date_start;
        }
        if ($request->has('date_end')) {
            $data->old_date_end = $request->date_end;
        }

        return view('admin.items.wallpaper.reviews.main', ['page' => $data]);
    }
}
