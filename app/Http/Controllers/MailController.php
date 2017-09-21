<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\Mail\SendMailRequest;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    private $send_to;

    public function __construct() {
        parent::__construct();
        $this->send_to = Contact::GetEmail()->email;
    }

    public function SendEmail(SendMailRequest $request) {
        $data = [
            'title' => $request->get('title'),
            'email' => $request->get('email'),
            'text_message' => $request->get('text_message'),
            'name' => $request->get('name')
        ];
        if (isset($this->send_to)) {
            Mail::send('email.support', $data, function ($message) use ($data) {
                $message->from($data['email']);
                $message->to($this->send_to);
                $message->subject($data['title'].' | Отправлено с '.$_SERVER['SERVER_NAME']);
            });
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }
}
