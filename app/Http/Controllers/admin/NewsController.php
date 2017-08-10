<?php

namespace App\Http\Controllers\Admin;

use App\DataNews;
use App\Http\Controllers\Controller;
use App\ImageBase\ImageBase;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller {
    private function PrepareDataLocal($id) {
        $data_local = News::GetItemAndLocalData($id, $this->active_local_id);
        $prepare_data_local = null;
        foreach ($data_local as $item) {
            $key = '';
            switch ($item->lang_id) {
                case 1:
                    $key = 'ru';
                    break;
                case 2:
                    $key = 'ua';
                    break;
                case 3:
                    $key = 'en';
                    break;
            }
            $prepare_data_local[$key] = (object)[
                'topic' => $item->topic,
                'text' => $item->text,
                'meta_title' => $item->meta_title,
                'meta_description' => $item->meta_description,
                'meta_keywords' => $item->meta_keywords,
                'tags' => $item->tags,
            ];
        }
        return (object)$prepare_data_local;
    }

    public function Page() {
        $data = (object)[
            'title' => 'Новости',
            'route_name' => $this->route_name,
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

    public function PageUpdate($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:news,id']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        $data = (object)[
            'title' => 'Обновление новости',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'item_id' => $id,
            'news' => News::GetItem($id),
            'data' => $this->PrepareDataLocal($id)
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
        while ($i<$this->count_active_local) {
            $validator = Validator::make($request->all(), [
                'topic_'.$this->active_local[$i]->lang => 'required|string|min:1|max:255',
                'text_'.$this->active_local[$i]->lang => 'required|string',
                'meta_title_'.$this->active_local[$i]->lang => 'string|max:255',
                'meta_description_'.$this->active_local[$i]->lang => 'string',
                'meta_keywords_'.$this->active_local[$i]->lang => 'string',
                'tags_'.$this->active_local[$i]->lang => 'string',
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
        while ($i<$this->count_active_local) {
            $topic = $request['topic_'.$this->active_local[$i]->lang];
            $text = $request['text_'.$this->active_local[$i]->lang];
            $meta_title = $request['meta_title_'.$this->active_local[$i]->lang];
            $meta_description = $request['meta_description_'.$this->active_local[$i]->lang];
            $meta_keywords  = $request['meta_keywords_'.$this->active_local[$i]->lang];
            $tags = $request['tags_'.$this->active_local[$i]->lang];

            DataNews::CreateItem($item_id, $this->active_local[$i]->id, $topic, $text,
                                 $meta_title, $meta_description, $meta_keywords, $tags);
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
        while ($i<$this->count_active_local) {
            $validator = Validator::make($request->all(), [
                'topic_'.$this->active_local[$i]->lang => 'required|string|min:1|max:255',
                'text_'.$this->active_local[$i]->lang => 'required|string',
                'meta_title_'.$this->active_local[$i]->lang => 'string|max:255',
                'meta_description_'.$this->active_local[$i]->lang => 'string',
                'meta_keywords_'.$this->active_local[$i]->lang => 'string',
                'tags_'.$this->active_local[$i]->lang => 'string',
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
        while ($i<$this->count_active_local) {
            $topic = $request['topic_'.$this->active_local[$i]->lang];
            $text = $request['text_'.$this->active_local[$i]->lang];
            $meta_title = $request['meta_title_'.$this->active_local[$i]->lang];
            $meta_description = $request['meta_description_'.$this->active_local[$i]->lang];
            $meta_keywords  = $request['meta_keywords_'.$this->active_local[$i]->lang];
            $tags = $request['tags_'.$this->active_local[$i]->lang];

            DataNews::UpdateItem($request->item_id, $this->active_local[$i]->id, $topic, $text,
                                 $meta_title, $meta_description, $meta_keywords, $tags);
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

    public function Delete($id) {
        $validator = Validator::make(
            ['id' => $id], ['id' => 'required|integer|exists:news,id']
        );
        if ($validator->failed()) {
            return redirect()->route('admin/news')->withErrors($validator);
        }
        News::DeleteItem($id);
        return redirect()->route('admin/news')->with('success', 'Новость была успешно удалена');
    }
}