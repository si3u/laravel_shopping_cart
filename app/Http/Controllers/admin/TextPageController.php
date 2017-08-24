<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TextPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TextPageController extends Controller {
    private function PrepareData($id) {
        $data = TextPage::GetItems($id);
        $prepare_data = null;
        foreach ($data as $datum) {
            if ($datum->lang_id == 1) {
                $prepare_data['ru'] = (object)[
                    'value' => $datum->value
                ];
            }
            elseif ($datum->lang_id == 2) {
                $prepare_data['ua'] = (object)[
                    'value' => $datum->value
                ];
            }
            else {
                $prepare_data['en'] = (object)[
                    'value' => $datum->value
                ];
            }
        }
        return (object)$prepare_data;
    }

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

    public function Update(Request $request) {
        $validator = Validator::make(
            ['id' => $request->id],
            ['id' => 'required|integer|exists:text_pages,id']
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ]);
        }

        $i = 0;
        while ($i<count($this->active_local)) {
            $validator = Validator::make($request->all(), [
                'value_'.$this->active_local[$i]->lang => 'required|string|min:10'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages()
                ]);
            }
            $i++;
        }

        $i = 0;
        while ($i<count($this->active_local)) {
            $value = $request['value_'.$this->active_local[$i]->lang];
            TextPage::UpdateItem($request->id, $this->active_local[$i]->id, $value);
            $i++;
        }
        return response()->json(['status' => 'success']);
    }
}