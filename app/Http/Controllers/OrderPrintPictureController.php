<?php
namespace App\Http\Controllers;

use App\Http\Requests\OrderPrintPicture\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\OrderPrintPicture;

class OrderPrintPictureController extends Controller
{
    private $date;

    public function __construct() {
        parent::__construct();
    }

    public function Create(CreateRequest $request) {
        $path = storage_path('print_files/');
        $exp = $request->file->getClientOriginalExtension();
        $file_name = uniqid('file_').'.'.$exp;
        $request->file->move(storage_path('print_files/'), $file_name);

        OrderPrintPicture::CreateItem(
            $request->tel,
            $request->width,
            $request->height,
            $request->canvas,
            $file_name,
            $exp,
            $this->controller_lang_id
        );

        return response()->json([
            'status' => 'success',
            'message' => __('create_print.success')
        ]);
    }
}
