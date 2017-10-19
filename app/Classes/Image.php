<?php
namespace App\Classes;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

class Image {
    /**
     * @param $url_img
     * @param $url_save
     * @param $exp_img
     * @param $width
     * @param $height
     * @param null $bg_color
     * @return string
     */
    public function CreatePreview($url_img, $url_save, $exp_img, $width, $height, $bg_color = null, $insert = null) {
        if ($bg_color == null) {
            $bg_color = '#fff';
        }
        $preview_name = uniqid('img_').'.'.$exp_img;
        $preview_image = ImageIntervention::canvas($width, $height, $bg_color);
        $image = ImageIntervention::make(public_path($url_img))
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        $insert_default = 'center';
        if ($insert != null) {
            $insert_default = $insert;
        }
        $preview_image->insert($image, $insert_default);
        $preview_image->save(public_path($url_save.$preview_name));
        return $preview_name;
    }

    /**
     * @param $url
     * @param $images
     */
    public function DeleteImages($url, $images) {
        $i = 0;
        $count = count($images);
        while ($i<$count) {
            $image = public_path().$url.$images[$i];
            if (file_exists($image)) {
                File::delete($image);
            }
            $i++;
        }
    }

    /**
     * @param $url_img
     * @param $url_mask
     * @param $url_save
     * @param $exp
     * @return string
     */
    public function CreateMask($url_img, $url_mask, $url_save, $exp) {
        $image = ImageIntervention::make(public_path($url_img));
        $name = uniqid('img_').'.'.$exp;

        $image->insert($url_mask, 'center');
        $image->save(public_path($url_save.$name));

        return $name;
    }

    /**
     * @param $url
     * @param $url_save
     * @param $width
     * @param $height
     * @param $x
     * @param $y
     * @return string
     */
    public function ImageCrop($url, $url_save, $width, $height, $x, $y) {
        $img = ImageIntervention::make(public_path($url));
        $info = new \SplFileInfo($url);

        $name = uniqid('img_').'.'.$info->getExtension();

        $img->crop($width, $height, $x, $y);
        $img->save(public_path($url_save.$name));

        return $name;
    }
}
