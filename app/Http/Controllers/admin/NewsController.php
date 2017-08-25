<?php

namespace App\Http\Controllers\Admin;

use App\DataNews;
use App\Http\Controllers\Controller;
use App\ImageBase\ImageBase;
use App\News;
use App\Traits\Controllers\Admin\NewsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller {

    use NewsTrait;

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

    public function Search(Request $request) {
        $validation = Validator::make($request->all(), [
            'text' => 'nullable|string',
            'option' => 'nullable|integer',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation);
        }
        $news = News::Search($request);
        $data = (object)[
            'title' => 'Поиск новостей',
            'route_name' => $this->route_name,
            'news' => $news
        ];
        if ($request->has('text')) {
            $data->old_text = $request->text;
        }
        if ($request->has('option')) {
            $data->old_option = $request->option;
        }
        if ($request->has('date_start')) {
            $data->old_date_start = $request->date_start;
        }
        if ($request->has('date_end')) {
            $data->old_date_end = $request->date_end;
        }
        return view('admin.news.main', ['page' => $data]);
    }
}