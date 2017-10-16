<?php
namespace App\Traits\Controllers;

trait PriceTrait {
    private function CalculatePrice($width, $height, $natural_canvas = false) {
        $x = null;
        $y = null;

        if ($natural_canvas) {
            $x = ($width * $height) * $this->prices->natural_canvas;
        }
        else {
            $x = ($width * $height) * $this->prices->artificial_canvas;
        }

        $y = 2 * ($width + $height) * $this->prices->running_meter;

        return $x + $y;
    }
}
