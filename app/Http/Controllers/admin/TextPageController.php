<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TextPage\UpdateRequest;
use App\TextPage;
use App\Traits\Controllers\Admin\TextPageTrait;
use Illuminate\Support\Facades\Validator;

class TextPageController extends Controller {

    use TextPageTrait;

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
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
        $data = (object)[
            'title' => 'Текстовая страница | '.$name,
            'id' => $id,
            'active_lang' => $this->active_local,
            'data' => $this->PrepareData($id)
        ];

        return view('admin.text_page.work_on', ['page' => $data]);
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Update(UpdateRequest $request) {
        $i = 0;
        while ($i<count($this->active_local)) {
            $value = $request['value_'.$this->active_local[$i]->lang];
            TextPage::UpdateItem($request->id, $this->active_local[$i]->id, $value);
            $i++;
        }
        return response()->json(['status' => 'success']);
    }
}