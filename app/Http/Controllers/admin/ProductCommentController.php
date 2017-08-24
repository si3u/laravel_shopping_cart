<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\ProductComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCommentController extends Controller {
    public function Page() {
        $data = (object)[
            'title' => 'Управление комментариями',
            'route_name' => $this->route_name,
            'comments' => ProductComment::GetData()
        ];
        return view('admin.comments.main', ['page' => $data]);
    }

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:product_comments,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $comment = ProductComment::GetData($id);
        if ($comment->read_status == false) {
            $comment->read_status = true;
            $comment->save();
        }
        $data = (object)[
            'title' => 'Работа с комментарием',
            'route_name' => $this->route_name,
            'comment' => $comment
        ];
        return view('admin.comments.work_on', ['page' => $data]);
    }

    public function Update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:product_comments,id',
            'status' => 'required|boolean',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'message' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        if (ProductComment::UpdateItem($request->id,
                                       $request->status,
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
            ['id' => 'required|integer|exists:product_comments,id']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        ProductComment::DeleteItem($id);
        return redirect()->route('admin/comments')->with('success', 'Комментарий успешно удален');
    }

    public function Search(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email',
            'vendor_code' => 'nullable|integer',
            'text_search' => 'nullable|string|max:255',
            'check_status' => 'nullable|integer',
            'read_status' => 'nullable|',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data = (object)[
            'title' => 'Поиск по комментариям',
            'route_name' => $this->route_name,
            'comments' => ProductComment::Search($request)
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

        return view('admin.comments.main', ['page' => $data]);
    }

    public function SendTrueStatus($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:product_comments,id']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

    }
}