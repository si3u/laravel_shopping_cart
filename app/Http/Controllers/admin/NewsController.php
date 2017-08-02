<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\DataNews;
use App\Http\Controllers\Controller;
use App\ImageBase\ImageBase;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class NewsController extends Controller {
    private $active_local;
    private $route_name;

    public function __construct() {
        $this->active_local = ActiveLocalization::GetActive();
        $this->route_name = Route::currentRouteName();
    }

    public function Page() {
        $data = (object)[
            'title' => 'Новости',
            'news' => News::GetItems()
        ];
        return view('admin.news.main', ['page' => $data]);
    }

    public function PageAdd() {
        $data = (object)[
            'title' => 'Добавление новости',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name
        ];
        return view('admin.news.work_on', ['page' => $data]);
    }

    public function PageUpdate() {
        $data = (object)[
            'title' => 'Добавление новости',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name
        ];
        return view('admin.news.work_on', ['page' => $data]);
    }

    public function Add(Request $request) {
        if (isset($request->image)) {
            $validator = Validator::make(
                ['image' => $request->image],
                ['image' => 'mimes:jpg,jpeg,png|max:2048']
            );
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
        }
        $i = 0;
        $count = count($this->active_local);
        while ($i<$count) {
            $validator = Validator::make($request->all(), [
                'topic_'.$this->active_local[$i]->lang => 'required|string|min:1|max:255',
                'text_'.$this->active_local[$i]->lang => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
            $i++;
        }

        if (isset($request->image)) {
            $exp = $request->image->getClientOriginalExtension();
            $image_name = uniqid('img_').'.'.$exp;
            $request->image->move(public_path('assets/images/news/'), $image_name);
            $preview_image_name = ImageBase::CreatePreview(
                'assets/images/news/'.$image_name,
                'assets/images/news/',
                $exp,
                300, 300
            );
            $item_id = News::CreateItem($image_name, $preview_image_name);
        }
        else {
            $item_id = $item_id = News::CreateItem();
        }

        $i = 0;
        while ($i<$count) {
            $topic = $request['topic_'.$this->active_local[$i]->lang];
            $text = $request['text_'.$this->active_local[$i]->lang];
            DataNews::CreateItem($item_id, $this->active_local[$i]->id, $topic, $text);
            $i++;
        }
        if (isset($request->image)) {
            return response()->json([
                'status' => 'success',
                'item_id'  => $item_id,
                'image' => $preview_image_name
            ]);
        }
        return response()->json([
            'status' => 'success',
            'item_id'  => $item_id
        ]);
    }

    public function Update(Request $request) {
        if (isset($request->image)) {
            $validator = Validator::make(
                ['image' => $request->image],
                ['image' => 'mimes:jpg,jpeg,png|max:2048']
            );
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
        }
        $validator = Validator::make(
            ['item_id' => $request->item_id],
            ['item_id' => 'required|integer|exists:news,id']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        $i = 0;
        $count = count($this->active_local);
        while ($i<$count) {
            $validator = Validator::make($request->all(), [
                'topic_'.$this->active_local[$i]->lang => 'required|string|min:1|max:255',
                'text_'.$this->active_local[$i]->lang => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
            $i++;
        }

        if (isset($request->image)) {
            $exp = $request->image->getClientOriginalExtension();
            $image_name = uniqid('img_').'.'.$exp;
            $request->image->move(public_path('assets/images/news/'), $image_name);
            $preview_image_name = ImageBase::CreatePreview(
                'assets/images/news/'.$image_name,
                'assets/images/news/',
                $exp,
                300, 300
            );

            News::UpdateItem($request->item_id, $image_name, $preview_image_name);
        }
        $i = 0;
        while ($i<$count) {
            $topic = $request['topic_'.$this->active_local[$i]->lang];
            $text = $request['text_'.$this->active_local[$i]->lang];
            DataNews::UpdateItem($request->item_id, $this->active_local[$i]->id, $topic, $text);
            $i++;
        }

        if (isset($request->image)) {
            return response()->json([
                'status' => 'success',
                'image' => $preview_image_name
            ]);
        }
        return response()->json([
            'status' => 'success',
        ]);
    }
}