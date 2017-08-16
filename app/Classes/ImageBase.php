<?php
namespace App\ImageBase;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\Finder\SplFileInfo;

class ImageBase {
    public static function CreatePreview($url_img, $url_save, $exp_img, $width, $height) {
        $preview_name = uniqid('img_').'.'.$exp_img;
        $white_bg = Image::canvas($width, $height, '#fff');
        $pre_image = Image::make(public_path($url_img))
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        $white_bg->insert($pre_image, 'center');
        $white_bg->save(public_path($url_save.$preview_name));
        return $preview_name;
    }
    public static function DeleteImages($url, $images) {
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
    public static function CreateMask($url_img, $url_mask, $url_save, $exp) {
        $image = Image::make(public_path($url_img));
        $name = uniqid('img_').'.'.$exp;

        $image->insert($url_mask, 'center');
        $image->save(public_path($url_save.$name));

        return $name;
    }

    public static function ImageCrop($url, $url_save, $width, $height, $x, $y) {
        $img = Image::make(public_path($url));
        $info = new \SplFileInfo($url);
        $name = uniqid('img_').'.'.$info->getExtension();
        $img->crop($width, $height, $x, $y);
        $img->save(public_path($url_save.$name));

        return $name;
    }
}