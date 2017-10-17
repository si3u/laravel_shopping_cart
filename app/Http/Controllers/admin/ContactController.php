<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\DataContact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\UpdateRequest;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;
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

    public function Update(UpdateRequest $request) {
        $i = 0;
        while ($i < count($this->active_local)) {
            $lang_id = $this->active_local[$i]->id;
            $addresses = $request['addresses_'.$this->active_local[$i]->lang];
            $working_days = $request['working_days_'.$this->active_local[$i]->lang];

            DataContact::UpdateItem($lang_id, $addresses, $working_days);
            $i++;
        }

        Contact::UpdateItem($request->email, $request->tel);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
