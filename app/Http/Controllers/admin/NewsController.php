<?php

namespace App\Http\Controllers\Admin;

use App\DataNews;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\News\AddRequest;
use App\Http\Requests\Admin\News\SearchRequest;
use App\Http\Requests\Admin\News\UpdateRequest;
use App\Http\Requests\Common\ImageNotRequireRequest;
use App\ImageBase\ImageBase;
use App\News;
use App\Traits\Controllers\Admin\NewsTrait;
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

    public function Add(AddRequest $request) {
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

    public function Update(UpdateRequest $request) {
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

    public function Search(SearchRequest $request) {
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