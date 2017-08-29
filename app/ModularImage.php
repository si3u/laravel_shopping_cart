<?php

namespace App;

use App\Classes\Image;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ModularImage
 *
 * @property int $id
 * @property string $image
 * @property string $preview_image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModularImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModularImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModularImage wherePreviewImage($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModularImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModularImage whereUpdatedAt($value)
 */
class ModularImage extends Model
{
    protected $primaryKey = 'id';
    private $image_intervention;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->image_intervention = new Image();
    }

    protected function Sizes() {
        return $this->hasMany('App\SizeModularImage', 'modular_image_id');
    }

    protected function GetItems() {
        return ModularImage::orderBy('id', 'desc')->paginate(10);
    }

    public static function GetAllItems() {
        return ModularImage::select('id', 'image')->get();
    }

    protected function CreateItem($image, $preview_image) {
        $item = new ModularImage();
        $item->image = $image;
        $item->preview_image = $preview_image;
        if ($item->save()) {
            return true;
        }
        return false;
    }

    protected function GetItem($id) {
        return (object)[
            'data' => ModularImage::find($id),
            'sizes' => ModularImage::find($id)->Sizes()->orderBy('number', 'asc')->get()
        ];
    }

    protected function DeleteItem($id) {
        $item = ModularImage::find($id);
        $this->image_intervention->DeleteImages('/assets/images/modular/', [
            $item->image, $item->preview_image
        ]);
        $item->delete();
    }
}
