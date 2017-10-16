<?php
namespace App\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Base\ModelBase
 *
 * @mixin \Eloquent
 */
class ModelBase extends Model {

    protected $active_localization_id;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        switch (app()->getLocale()) {
            case 'ru':
                $this->active_localization_id = 1;
            break;
            case 'ua':
                $this->active_localization_id = 2;
            break;
            case 'en':
                $this->active_localization_id = 3;
            break;
            default:
                $this->active_localization_id = 1;
        }
    }
}
