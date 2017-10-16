<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TextSection;
use Illuminate\Support\Facades\Validator;
use App\Traits\Controllers\Admin\TextPageTrait;
use App\Http\Requests\Admin\TextSection\UpdateRequest;
use App\Traits\CacheTrait;

class TextSectionController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->model_cache = 'TextSection';
        $this->key_cache = 'text_section';
        $this->method_cache = 'GetItems';
    }

    use CacheTrait;
    use TextPageTrait;

    public function Get($section) {
        $validator = Validator::make(
            ['section' => $section],
            ['section' => 'required|string|exists:text_sections,section']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }
        switch ($section) {
            case 'quote_of_day':
                $title = 'Цитата дня';
                break;
        }

        $this->parameters_cache = [$section];
        $this->tags_cache = [$this->key_cache, 'section', $section];

        $data = (object)[
            'title' => $title,
            'section' => $section,
            'active_lang' => $this->active_local,
            'data' => $this->PrepareData($this->GetOrCreateItemFromCache())
        ];

        return view('admin.news.quote_of_day.work_on', ['page' => $data]);
    }

    public function Update(UpdateRequest $request) {
        $i = 0;
        while ($i<count($this->active_local)) {
            $value = $request['value_'.$this->active_local[$i]->lang];
            TextSection::UpdateItem($request->section, $this->active_local[$i]->id, $value);
            $i++;
        }

        $this->tags_cache = [$this->key_cache, 'section', $request->section];
        $this->ForgetItemInCache();

        return response()->json(['status' => 'success']);
    }
}
