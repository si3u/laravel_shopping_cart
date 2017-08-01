<?php

namespace App\WorkOnImage;


class WorkOnImage {
    public function CreatePreview($url_img, $url_save, $exp_img, $width, $height) {
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
    public function DeleteImages($url, $images) {
        $i = 0;
        while ($i<count($images)) {
            $image = public_path().$url.$images[$i];
            if (file_exists($image)) {
                File::delete($image);
            }
            $i++;
        }
    }
}