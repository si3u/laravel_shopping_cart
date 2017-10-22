<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataNews extends Model
{
    protected $primaryKey = 'news_id';
    public $timestamps = false;

    public static function CreateItem($news_id,
                                      $lang_id,
                                      $topic,
                                      $text,
                                      $meta_title = null,
                                      $meta_description = null,
                                      $meta_keywords = null,
                                      $tags = null) {
        $item = new DataNews();
        $item->news_id = $news_id;
        $item->lang_id = $lang_id;
        $item->topic = $topic;
        $item->text = $text;
        $item->meta_title = $meta_title;
        $item->meta_description = $meta_description;
        $item->meta_keywords = $meta_keywords;
        $item->tags = $tags;
        $item->save();
    }

    public static function UpdateItem($news_id,
                                      $lang_id,
                                      $topic,
                                      $text,
                                      $meta_title = null,
                                      $meta_description = null,
                                      $meta_keywords = null,
                                      $tags = null) {
        $where = ['news_id' => $news_id, 'lang_id' => $lang_id];
        if (DataNews::where($where)->count() == 0) {
            DataNews::insert(['news_id' => $news_id, 'lang_id' => $lang_id]);
        }
        $update = [
            'topic' => $topic,
            'text' => $text,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'tags' => $tags,
        ];
        DataNews::where($where)->update($update);
    }
}
