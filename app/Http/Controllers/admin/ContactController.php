<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\UpdateRequest;
use App\Traits\CacheTrait;
use App\Traits\Controllers\Admin\ContactTrait;

class ContactController extends Controller {
    public function __construct() {
        parent::__construct();

    }

    use CacheTrait;
    use ContactTrait;

    public function PageUpdate() {
        $contact = Contact::GetItem();
        $data_contact = Contact::GetData();
        $data = (object)[
            'route_name' => $this->route_name,
            'active_lang' => $this->active_local,
            'title' => 'Контактная информация',
            'contact' => $contact,
            'lang_data' => $this->PreperaData($data_contact),
        ];

        return view('admin.contacts.work_on', ['page' => $data]);
    }
}
