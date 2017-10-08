<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Controllers\Admin\ActiveLocalizationTrait;

class ActiveLocalizationController extends Controller {
    use ActiveLocalizationTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function Get() {
        return response()->json($this->GetItemsFromCache('all'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetActive() {
        return response()->json($this->GetItemsFromCache('active'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Update(Request $request) {
        $status = [false, false, false];
        if (isset($request->ru)) {
            $status[0] = true;
        }
        if (isset($request->ua)) {
            $status[1] = true;
        }
        if (isset($request->en)) {
            $status[2] = true;
        }
        if ($status[0] != true) {
            return response()->json([
                'error' => 'Русская локализация является основной локализацией. Выключить ее нельзя.'
            ]);
        }
        if (!in_array(true, array_values($status))) {
            return response()->json([
                'error' => 'Должна быть выбрана минимум одна локализация'
            ]);
        }
        if (ActiveLocalization::UpdateItem($status)) {
            $this->ForgetItemsOfCache();

            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }
}