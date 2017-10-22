<?php

namespace App;

use App\Base\ModelBase;

class Contact extends ModelBase
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    public static $static_local_id;

    public function __construct() {
        parent::__construct();

        self::$static_local_id  = $this->active_localization_id;
    }

    protected function DataLocalization() {
        return $this->hasMany('App\DataContact', 'contact_id');
    }

    public static function PuclicGetData() {
        return Contact::find(1)
            ->join('data_contacts', 'contacts.id', '=', 'data_contacts.contact_id')
            ->where('data_contacts.lang_id', self::$static_local_id)
            ->first();
    }

    protected function GetItem() {
        return Contact::find('1');
    }

    protected function GetData() {
        return Contact::find(1)->DataLocalization()->get();
    }

    public static function GetEmail() {
        return Contact::find(1)->select('email')->first();
    }

    protected function UpdateItem($email, $tel) {
        Contact::where('id', 1)->update(['email' => $email, 'tel' => $tel]);
    }
}
