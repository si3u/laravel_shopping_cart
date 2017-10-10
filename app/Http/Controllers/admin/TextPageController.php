<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TextPage\UpdateRequest;
use App\TextPage;
use App\Traits\Controllers\Admin\TextPageTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\CacheTrait;

class TextPageController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'TextPage';
        $this->key_cache = 'text_page';
        $this->method_cache = 'GetItems';
    }

    use TextPageTrait;
    use CacheTrait;

    public function Get($id) {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:text_pages,id']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        switch ($id) {
            case 1:
                $name = 'Доставка и оплата';
                break;
            case 2:
                $name = 'О нас';
                break;
            case 3:
                $name = 'Сотрудничество';
                break;
        }

        $this->parameters_cache = [$id];
        $this->tags_cache = ['text_page', 'item', $id];

        $data = (object)[
            'title' => 'Текстовая страница | '.$name,
            'id' => $id,
            'active_lang' => $this->active_local,
            'data' => $this->PrepareData($this->GetOrCreateItemFromCache())
        ];

        return view('admin.text_page.work_on', ['page' => $data]);
    }

    public function Update(UpdateRequest $request) {
        $i = 0;
        while ($i<count($this->active_local)) {
            $value = $request['value_'.$this->active_local[$i]->lang];
            TextPage::UpdateItem($request->id, $this->active_local[$i]->id, $value);
            $i++;
        }

        $this->tags_cache = ['text_page', 'item', $request->id];
        $this->ForgetItemInCache();

        return response()->json(['status' => 'success']);
    }
}