<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model implements Authenticatable, \Illuminate\Contracts\Auth\CanResetPassword
{
    use Notifiable;
    use \Illuminate\Auth\Authenticatable;
    use CanResetPassword;

    public $timestamps = false;

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }
}
