<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPrintPicture extends Model
{
    public $timestamps = true;

    protected function GetItems() {
        return OrderPrintPicture::orderBy('order_print_pictures.id', 'desc')
        ->leftJoin('setting_order_statuses', 'order_print_pictures.processing_status', '=', 'setting_order_statuses.id')
        ->select(
            'order_print_pictures.id',
            'order_print_pictures.tel',
            'order_print_pictures.width',
            'order_print_pictures.height',
            'order_print_pictures.canvas',
            'order_print_pictures.read_status',
            'order_print_pictures.processing_status',
            'order_print_pictures.file',
            'order_print_pictures.file_exp',
            'order_print_pictures.local',
            'order_print_pictures.created_at',
            'setting_order_statuses.name as processing_name'
        )
        ->paginate(10);
    }

    protected function CreateItem($tel, $width, $height, $canvas, $file, $exp, $local) {
        $status = SettingOrderStatus::GetActive();
        if ($status == null) {
            $status = 0;
        }

        $item = new OrderPrintPicture();

        $item->tel = $tel;
        $item->width = $width;
        $item->height = $height;
        $item->canvas = $canvas;
        $item->file = $file;
        $item->file_exp = $exp;
        $item->local = $local;
        $item->processing_status = $status;

        $item->save();
    }
}
