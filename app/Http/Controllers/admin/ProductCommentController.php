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
            ProductComment::UpdateReadStatus($id);
        }
        $data = (object)[
            'title' => 'Управление комментариями',
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
}