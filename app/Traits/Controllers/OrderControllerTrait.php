<?php
namespace App\Traits\Controllers;
use App\ImageBase\ImageBase;
use App\Product;

trait OrderControllerTrait {
    private function CreateCropImage($product_id, $width, $height, $top, $left) {
        $product = Product::GetItem($product_id);
        $image_url = '/assets/images/products/'.$product->preview_image;
        $save_url = '/assets/images/orders/'.$this->date.'/';
        return $this->date.'/'.ImageBase::ImageCrop($image_url, $save_url, $width, $height, $top, $left);
    }

    private function CalculatePrice($canvas, $width, $height) {
        $x = null;
        $y = null;
        if ($canvas == 0) {
            $x = ($width * $height) * $this->prices->natural_canvas;
        }
        else {
            $x = ($width * $height) * $this->prices->artificial_canvas;
        }
        $y = 2 * ($width + $height) * $this->prices->running_meter;

        return $x + $y;
    }

    private function CreateOrderItems($order_id, $items) {
        foreach ($items as $item) {
            $item_price = null;
            $item_price = $this->CalculatePrice($item['canvas'], $item['width'], $item['height']);
            $this->full_price += $item_price;
            if ($item['type'] == 1) {
                $this->order_items[] = [
                    'order_id' => $order_id,
                    'product_id' => $item['product_id'],
                    'width' => $item['width'],
                    'height' => $item['height'],
                    'canvas' => $item['canvas'],
                    'type' => $item['type'],
                    'modular_id' => $item['modular_id'],
                    'crop_image' => null,
                    'price' => $item_price
                ];
            }
            else {
                $crop_image = $this->CreateCropImage(
                    $item['product_id'],
                    $item['crop']['width'],
                    $item['crop']['height'],
                    $item['crop']['left'], $item['crop']['top']
                );
                $this->order_items[] = [
                    'order_id' => $order_id,
                    'product_id' => $item['product_id'],
                    'type' => $item['type'],
                    'width' => $item['width'],
                    'height' => $item['height'],
                    'canvas' => $item['canvas'],
                    'modular_id' => null,
                    'crop_image' => $crop_image,
                    'price' => $item_price
                ];
            }
        }
    }
}