<?php

namespace App;

use App\ImageBase\ImageBase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
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
class News extends Model
{
    public $primaryKey = 'id';
    public $timestamps = true;
    private $carbon;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->carbon = Carbon::now();
    }
    protected function DataLocalization() {
        return $this->hasMany('App\DataNews', 'news_id');
    }

    protected function GetItems() {
        return DB::table('news')
            ->orderBy('news.created_at', 'desc')
            ->join('data_news', 'news.id', '=', 'data_news.news_id')
            ->where('data_news.lang_id', 1)
            ->paginate();
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
            ImageBase::DeleteImages('/assets/images/news/', [
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
            ImageBase::DeleteImages('/assets/images/news/', [
                $news->image,
                $news->image_preview
            ]);
        }
        $news->DataLocalization()->delete();
        $news->delete();
    }
}
