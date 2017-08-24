<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller {
    public function Page() {
        $data = (object)[
            'title' => 'Управление отзывами',
            'route_name' => $this->route_name,
            'reviews' => ProductReview::GetData()
        ];
        return view('admin.reviews.main', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:product_reviews,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $review = ProductReview::GetData($id);
        if (!$review->read_status) {
            $review->read_status = true;
            $review->save();
        }
        $data = (object)[
            'title' => 'Работа с отзывом',
            'route_name' => $this->route_name,
            'review' => $review,
        ];

        return view('admin.reviews.work_on', ['page' => $data]);
    }

    public function Update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:product_reviews,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'score' => 'required|integer|between:1,5',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        if (ProductReview::UpdateItem($request->id,
                                      $request->status,
                                      $request->score,
                                      $request->name,
                                      $request->email,
                                      $request->message)) {
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
            ['id' => 'required|integer|exists:product_reviews,id']
        );
        if ($validator->fails()) {
            return redirect()->route('products/reviews')->withErrors($validator);
        }

        ProductReview::DeleteItem($id);
        return redirect()->route('products/reviews')->with('success', 'Отзыв успешно удален');
    }

    public function Search(Request $request) {
        $validator = Validator::make($request->all(), [
            'vendor_code' => 'nullable|integer',
            'email' => 'nullable|email',
            'text_search' => 'nullable|string',
            'check_status' => 'nullable|integer',
            'read_status' => 'nullable|integer',
            'score' => 'nullable|integer',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date'
        ]);
        if ($validator->fails()) {
            redirect()->back()->withErrors($validator);
        }
        $data = (object)[
            'title' => 'Поиск по отзывам',
            'route_name' => $this->route_name,
            'reviews' => ProductReview::Search($request),
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

        return view('admin.reviews.main', ['page' => $data]);
    }
}