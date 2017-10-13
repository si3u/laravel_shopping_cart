<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
    protected $primaryKey = 'id';

    protected function CreateItem($id, $name, $email, $message) {
        $item = new NewsComment();
        $item->news_id = $id;
        $item->name = $name;
        $item->email = $email;
        $item->text = $message;
        $item->save();
    }

    protected function GetData($product_id = null) {
        $query = NewsComment::query();
        $query->join('news', 'news_comments.news_id', '=', 'news.id');
        $query->join('data_news', 'news_comments.news_id', '=', 'data_news.news_id');
        $query->where('data_news.lang_id', 1);
        if ($product_id != null) {
            $query->where('news_comments.id', $product_id);
        }
        if ($product_id == null) {
            $query->orderBy('news_comments.id', 'desc');
            $query->select(
                'news.id as news_id',
                'news.image_preview as news_image',
                'news_comments.id',
                'data_news.topic as news_topic',
                'news_comments.check_status',
                'news_comments.read_status',
                'news_comments.name',
                'news_comments.email',
                'news_comments.created_at'
            );
            return $query->paginate(10);
        }
        else {
            $query->select(
                'news.id as news_id',
                'news.image_preview as news_image',
                'news_comments.id',
                'data_news.topic as news_topic',
                'news_comments.check_status',
                'news_comments.read_status',
                'news_comments.name',
                'news_comments.email',
                'news_comments.text',
                'news_comments.created_at'
            );
            return $query->first();
        }
    }

    protected function UpdateItem($id, $status, $name, $email, $message) {
        $item = NewsComment::find($id);
        $item->check_status = $status;
        $item->name = $name;
        $item->email = $email;
        $item->text = $message;

        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function DeleteItem($id) {
        NewsComment::find($id)->delete();
    }
}
