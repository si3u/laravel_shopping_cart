<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\NewsComment
 *
 * @property int $id
 * @property int $news_id
 * @property int $check_status
 * @property int $read_status
 * @property string $name
 * @property string $email
 * @property string $text
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsComment whereCheckStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsComment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsComment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsComment whereNewsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsComment whereReadStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsComment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsComment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    protected function Search($request) {
        $query = NewsComment::query();
        $query->join('news', 'news_comments.news_id', '=', 'news.id');
        $query->join('data_news', 'news_comments.news_id', '=', 'data_news.news_id');

        if (isset($request->email)) {
            $query->where('news_comments.email', $request->email);
        }
        if (isset($request->text_search)) {
            $query->where('news_comments.text', 'LIKE', '%'.$request->text_search.'%');
        }
        if (isset($request->check_status)) {
            if ($request->check_status == '1') {
                $query->where('news_comments.check_status', true);
            }
            if ($request->check_status == '2') {
                $query->where('news_comments.check_status', false);
            }
        }
        if (isset($request->read_status)) {
            $query->where('news_comments.read_status', false);
        }
        if (isset($request->id_news)) {
            $query->where('news.id', $request->id_news);
        }
        if (isset($request->date_start) && isset($request->date_end)) {
            $query->whereBetween(
                'news_comments.created_at',
                [$request->date_start, $request->date_end]
            );
        }
        if (!isset($request->date_start) && isset($request->date_end)) {
            $query->where('news_comments.created_at', '<=', $request->date_end);
        }
        if (isset($request->date_start) && !isset($request->date_end)) {
            $query->where('news_comments.created_at', '>=', $request->date_start);
        }
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
        return $query->where('data_news.lang_id', 1)
            ->orderBy('news_comments.created_at', 'desc')
            ->paginate(10);
    }
}
