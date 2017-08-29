<?php
namespace App\Traits\Controllers\Admin;

use App\Classes\Image;
use App\ModularImage;
use App\Product;
use Illuminate\Support\Facades\File;

trait ProductTrait {
    private $image_intervention;

    public function __construct() {
        $this->image_intervention = new Image();
    }

    /**
     * @param $data
     * @param $option
     * @return array
     */
    private function PrepareActiveData($data, $option) {
        $i = 0;
        $count = count($data);
        $result = [];
        while ($i < $count) {
            switch ($option) {
                case 'category':
                    $result[] = $data[$i]->category_id;
                    break;
                case 'color':
                    $result[] = $data[$i]->color_id;
                    break;
                case 'size':
                    $result[] = $data[$i]->size_id;
                    break;
            }
            $i++;
        }
        return $result;
    }

    /**
     * @param $id
     * @return object
     */
    private function PrepareDataLocal($id) {
        $data_local = Product::GetDataLocalization($id);
        $prepare_data_local = null;
        foreach ($data_local as $item) {
            $key = '';
            switch ($item->lang_id) {
                case 1:
                    $key = 'ru';
                    break;
                case 2:
                    $key = 'ua';
                    break;
                case 3:
                    $key = 'en';
                    break;
            }
            $prepare_data_local[$key] = (object)[
                'name' => $item->name,
                'meta_title' => $item->meta_title,
                'meta_description' => $item->meta_description,
                'meta_keywords' => $item->meta_keywords,
                'tags' => $item->tags,
            ];
        }
        return (object)$prepare_data_local;
    }

    /**
     * @param $date
     * @param $item_id
     * @param $image
     * @param $exp
     * @return array
     */
    private function CreateModularImages($date, $item_id, $image, $exp) {
        $modular_images = ModularImage::GetAllItems();
        $count = count($modular_images);
        $i = 0;
        $path = public_path('assets/images/product_modular/' . $item_id);
        File::makeDirectory($path, $mode = 0777, true, true);
        $data_product_modular = [];
        while ($i < $count) {
            $url_img = 'assets/images/products/'.$date.'/'.$image;
            $url_modular = 'assets/images/modular/'.$modular_images[$i]->image;
            $url_save = 'assets/images/product_modular/' . $item_id . '/';
            $name_modular_image = $this->image_intervention->CreateMask(
                $url_img, $url_modular, $url_save, $exp
            );
            $preview_modular_image = $this->image_intervention->CreatePreview(
                'assets/images/product_modular/'.$item_id.'/'.$name_modular_image,
                $url_save,
                $exp, 520, 320
            );
            $data_product_modular[] = [
                'product_id' => $item_id,
                'modular_image_id' => $modular_images[$i]->id,
                'image' => $item_id.'/'.$name_modular_image,
                'preview_image' => $item_id.'/'.$preview_modular_image,
            ];

            $i++;
        }
        return $data_product_modular;
    }
}