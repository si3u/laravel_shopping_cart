<?php

namespace App\Http\Controllers;

use App\Price;
use App\DefaultSize;
use App\Traits\Controllers\PriceTrait;
use Illuminate\Http\Request;
use App\Http\Requests\Price\CalculatePriceRequest;

class PriceController extends Controller
{
    private $prices;

    public function __construct() {
        parent::__construct();

        $this->prices = Price::GetData();
    }

    use PriceTrait;

    public function Page() {
        $prices = null;

        $default_sizes = DefaultSize::GetItemsStatic();

        $i = 0;
        $count = count($default_sizes);
        while ($i < $count) {
            $prices[] = [
                'size' => $default_sizes[$i]->width.'x'.$default_sizes[$i]->height,
                'price_natural' => $this->CalculatePrice(
                    $default_sizes[$i]->width,
                    $default_sizes[$i]->height,
                    true
                ),
                'price_artificial' => $this->CalculatePrice(
                    $default_sizes[$i]->width,
                    $default_sizes[$i]->height
                )
            ];

            $i++;
        }

        return view('price', [
            'prices' => $prices
        ]);
    }

    public function PublicCalculatePrice(CalculatePriceRequest $request) {
        $price = null;
        if ($request->canvas === '0') {
            $price = $this->CalculatePrice($request->width, $request->height);
        }
        else {
            $price = $this->CalculatePrice($request->width, $request->height, true);
        }

        return response()->json([
            'result' => $price
        ]);
    }
}
