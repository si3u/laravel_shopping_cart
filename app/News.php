<?php

namespace App;

use App\Classes\Image;
use Carbon\Carbon;
use App\Base\ModelBase;
use Illuminate\Support\Facades\DB;

/**
 * App\News
 *
 * @property int $id
 * @property string|null $image
 * @property string|null $image_preview
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereImagePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class News extends ModelBase
{
    public $primaryKey = 'id';
    public $timestamps = true;
    private $carbon;
    private $image_intervention;

    public function __construct() {
        parent::__construct();

        $this->carbon = Carbon::now();
        $this->image_intervention = new Image();
    }

    protected function DataLocalization() {
        return $this->hasMany('App\DataNews', 'news_id');
    }

    protected function Comments() {
        return $this->hasMany('App\NewsComment', 'news_id');
    }


    // // //public
    protected function PublicGetItems() {
        return DB::table('news')
            ->orderBy('news.created_at', 'desc')
            ->join('data_news', 'news.id', '=', 'data_news.news_id')
            ->where('data_news.lang_id', $this->active_localization_id)
            ->select(
                'news.id',
                'news.image_preview',
                'news.created_at',
                'data_news.topic',
                'data_news.text'
            )
            ->paginate(3);
    }

    protected function GetMultipleItems($quantity) {
        return DB::table('news')
            ->orderBy('news.created_at', 'desc')
            ->join('data_news', 'news.id', '=', 'data_news.news_id')
            ->where('data_news.lang_id', $this->active_localization_id)
            ->select(
                'news.id',
                'news.image_preview',
                'news.created_at',
                'data_news.topic'
            )
            ->limit($quantity)->get();
    }

    protected function PublicGetItem($id) {
        return DB::table('news')
            ->where('news.id', $id)
            ->join('data_news', 'news.id', '=', 'data_news.news_id')
            ->where('data_news.lang_id', $this->active_localization_id)
            ->select(
                'news.id',
                'news.image',
                'news.created_at',
                'data_news.topic',
                'data_news.text'
            )
            ->first();
    }

    protected function GetComments($id) {
        return News::find($id)->Comments()->where('check_status', true)->orderBy('id', 'desc')->paginate(10);
    }

    // // //admin
    protected function GetItems() {
        return DB::table('news')
            ->orderBy('news.created_at', 'desc')
            ->join('data_news', 'news.id', '=', 'data_news.news_id')
            ->where('data_news.lang_id', 1)
            ->paginate(10);
    }

    protected function GetItem($id) {
        return News::find($id);
    }
    protected function GetItemAndLocalData($id, $active_local) {
        return News::find($id)->DataLocalization()->whereIn('lang_id', $active_local)->get();
    }

    protected function CreateItem($image = null, $image_preview = null) {
        return News::insertGetId([
            'image' => $image,
            'image_preview' => $image_preview,
            'created_at' => $this->carbon->toDateTimeString(),
            'updated_at' => $this->carbon->toDateTimeString(),
        ]);
    }

    protected function UpdateItem($id, $image, $image_preview) {
        $item = News::find($id);
        if ($item->image != null) {
            $this->image_intervention->DeleteImages('/assets/images/news/', [
                $item->image,
                $item->image_preview
            ]);
        }

        $item->image = $image;
        $item->image_preview = $image_preview;
        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function DeleteItem($id) {
        $news = News::find($id);
        if ($news->image != null) {
            $this->image_intervention->DeleteImages('/assets/images/news/', [
                $news->image,
                $news->image_preview
            ]);
        }
        $news->DataLocalization()->delete();
        $news->delete();
    }

    protected function Search($request) {
        $query = News::query();
        $query->join('data_news', 'news.id', '=', 'data_news.news_id');
        if (isset($request->text)) {
            switch ($request->option) {
                case '1':
                    $query->where('data_news.topic', 'LIKE', '%'.$request->text.'%');
                    break;
                case '2':
                    $query->where('data_news.text', 'LIKE', '%'.$request->text.'%');
                    break;
                case null:
                    $query->where('data_news.topic', 'LIKE', '%'.$request->text.'%');
                    $query->orWhere('data_news.text', 'LIKE', '%'.$request->text.'%');
                    break;
            }
        }
        if (isset($request->date_start) && isset($request->date_end)) {
            $query->whereBetween('news.created_at', [$request->date_start, $request->date_end]);
        }
        if (!isset($request->date_start) && isset($request->date_end)) {
            $query->where('news.created_at', '<=', $request->date_end);
        }
        if (isset($request->date_start) && !isset($request->date_end)) {
            $query->where('news.created_at', '>=', $request->date_start);
        }
        $query->select(
            'news.id',
            'news.image_preview',
            'news.created_at',
            'data_news.topic',
            'data_news.text'
        )->orderBy('news.created_at', 'desc')->groupBy('news.id');
        return $query->paginate(10);
    }
}
