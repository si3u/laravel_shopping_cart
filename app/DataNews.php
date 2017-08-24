<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DataNews
 *
 * @property int $news_id
 * @property int $lang_id
 * @property string $topic
 * @property string $text
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataNews whereLangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataNews whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataNews whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataNews whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataNews whereNewsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataNews whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataNews whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataNews whereTopic($value)
 * @mixin \Eloquent
 */
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
