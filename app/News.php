<?php

namespace App;

use App\ImageBase\ImageBase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    public $primaryKey = 'id';
    public $timestamps = true;
    private $carbon;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->carbon = Carbon::now();
    }

    protected function GetItems() {
        return DB::table('news')
            ->orderBy('news.created_at', 'desc')
            ->join('data_news', 'news.id', '=', 'data_news.news_id')
            ->where('data_news.lang_id', 1)
            ->paginate();
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
        ImageBase::DeleteImages('/assets/images/news/', [
            $item->image,
            $item->image_preview
        ]);

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
                $news->image, $news->preview_image
            ]);
        }
        $news->delete();
    }
}
