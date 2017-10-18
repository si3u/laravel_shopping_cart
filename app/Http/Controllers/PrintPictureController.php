<?php
namespace App\Http\Controllers;

use App\Http\Requests\PrintRequest\CreatePrintRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\PrintPicture;

class PrintPictureController extends Controller
{
    private $date;

    public function __construct() {
        parent::__construct();

        $this->date = Carbon::now()->toDateString();
    }

    public function Create(CreatePrintRequest $request) {
        $path = public_path('assets/print_files/' . $this->date);
        File::makeDirectory($path, $mode = 0777, true, true);

        $exp = $request->file->getClientOriginalExtension();
        $file_name = uniqid('file_').'.'.$exp;
        $request->file->move(public_path('assets/print_files/'.$this->date.'/'), $file_name);

        PrintPicture::CreateItem(
            $request->tel,
            $request->width,
            $request->height,
            $request->canvas,
            $this->date.'/'.$file_name,
            $exp,
            $this->controller_lang_id
        );

        return response()->json([
            'status' => 'success',
            'message' => __('create_print.success')
        ]);
    }
}
