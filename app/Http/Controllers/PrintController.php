<?php
namespace App\Http\Controllers;

use App\Http\Requests\PrintRequest\CreatePrintRequest;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function Create(CreatePrintRequest $request) {
        
        return response()->json($request);
    }
}
