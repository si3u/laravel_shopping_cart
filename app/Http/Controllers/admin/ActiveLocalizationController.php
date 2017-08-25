<?php

namespace App\Http\Controllers\Admin;

use App\ActiveLocalization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActiveLocalizationController extends Controller {
    public function Get() {
        return response()->json(ActiveLocalization::GetAll());
    }
    public function GetActive() {
        return response()->json(ActiveLocalization::GetActive());
    }

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
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }
}