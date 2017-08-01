<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    private $image;
    protected $primaryKey = 'id';
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->image = new WorkOnImage();
    }

    protected function CreateItem($topic, $text, $image = null, $image_preview = null) {
        $item = new News();
        $item->topic = $topic;
        $item->text = $text;
        if ($image != null) {
            $item->image = $image;
            $item->image_preview = $image_preview;
        }
        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function UpdateItem($id, $topic, $text, $image = null, $image_preview = null) {
        $item = News::find($id);

    }

    protected function DeleteItem($id) {
        $news = News::find($id);
        if ($news->image != null) {
            $this->image->DeleteImages('/assets/images/items/', [
                $news->image, $news->preview_image
            ]);
        }
        $news->delete();
    }
}
