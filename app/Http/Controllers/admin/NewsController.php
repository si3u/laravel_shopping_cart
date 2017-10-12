<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Image;
use App\DataNews;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\News\AddOrUpdateRequest;
use App\Http\Requests\Admin\News\SearchRequest;
use App\News;
use App\Traits\CacheTrait;
use App\Traits\Controllers\Admin\NewsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller {

    use NewsTrait;
    use CacheTrait;

    private $image_intervention;
    private $item_id;

    public function __construct() {
        parent::__construct();

        $this->image_intervention = new Image();

        $this->key_cache = 'news';
        $this->model_cache = 'News';
    }

    public function Page(Request $request) {
        $page = 1;
        if ($request->page !== null) {
            $page = $request->page;
        }

        $this->method_cache = 'GetItems';
        $this->tags_cache = ['news', 'paginate', $page];

        $data = (object)[
            'title' => 'Новости',
            'route_name' => $this->route_name,
            'news' => $this->GetOrCreateItemFromCache()
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
        $this->item_id = $id;

        $validator = Validator::make(
            ['id' => $this->item_id],
            ['id' => 'required|integer|exists:news,id']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        $this->tags_cache = ['news', 'item', $this->item_id];
        $this->method_cache = 'GetItem';
        $this->parameters_cache = [$this->item_id];

        $news = $this->GetOrCreateItemFromCache();

        $data = (object)[
            'title' => 'Обновление новости',
            'active_lang' => $this->active_local,
            'route_name' => $this->route_name,
            'item_id' => $id,
            'news' => $news,
            'data' => $this->PrepareDataLocal($id)
        ];
        return view('admin.news.work_on', ['page' => $data]);
    }

    public function Add(AddOrUpdateRequest $request) {
        if (isset($request->image)) {
            $exp = $request->image->getClientOriginalExtension();
            $image_name = uniqid('img_').'.'.$exp;
            $request->image->move(public_path('assets/images/news/'), $image_name);
            $preview_image_name = $this->image_intervention->CreatePreview(
                'assets/images/news/'.$image_name,
                'assets/images/news/',
                $exp,
                637, 422
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

        $this->tags_cache = ['news', 'paginate'];
        $this->ForgetItemsOfPaginate();

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

    private function DeleteAllItemsInCache() {
        $this->tags_cache = ['news', 'item', $this->item_id];
        if ($this->ExistItemInCache()) {
            $this->ForgetItemInCache();
        }
        $this->tags_cache = ['news', 'paginate'];
        $this->ForgetItemsOfPaginate();
    }


    public function Update(AddOrUpdateRequest $request) {
        $this->item_id = $request->item_id;

        if (isset($request->image)) {
            $exp = $request->image->getClientOriginalExtension();
            $image_name = uniqid('img_').'.'.$exp;
            $request->image->move(public_path('assets/images/news/'), $image_name);
            $preview_image_name = $this->image_intervention->CreatePreview(
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

        $this->DeleteAllItemsInCache();

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

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function Delete($id) {
        $this->item_id = $id;

        $validator = Validator::make(
            ['id' => $this->item_id], ['id' => 'required|integer|exists:news,id']
        );
        if ($validator->failed()) {
            return redirect()->route('admin/news')->withErrors($validator);
        }
        
        News::DeleteItem($this->item_id);

        $this->DeleteAllItemsInCache();

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