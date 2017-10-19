<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Http\Controllers\Controller;

class FileDownloadController extends Controller {
    public function Run($model, $file_name) {
        $path = '';
        switch ($model) {
            case 'print_picture':
                $path = storage_path('print_files/'.$file_name);
                break;
        }
        return response()->download($path);
    }
}
