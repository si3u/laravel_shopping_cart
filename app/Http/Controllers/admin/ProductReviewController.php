<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller {
    public function Page() {
        $data = (object)[
            'title' => 'Управление комментариями',
            'route_name' => $this->route_name,
        ];
        return true;
    }
}