<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataNews extends Model
{
    protected $primaryKey = 'news_id';
    public $timestamps = false;

    public static function CreateItem($news_id, $lang_id, $topic, $text) {
        $item = new DataNews();
        $item->news_id = $news_id;
        $item->lang_id = $lang_id;
        $item->topic = $topic;
        $item->text = $text;
        $item->save();
    }

    public static function UpdateItem($news_id, $lang_id, $topic, $text) {
        $where = ['news_id' => $news_id, 'lang_id' => $lang_id];
        $update = ['topic' => $topic, 'text' => $text];
        DataNews::where($where)->update($update);
    }
}
