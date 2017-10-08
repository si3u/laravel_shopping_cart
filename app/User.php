<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * App\User
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string|null $remember_token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @property string|null $email
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 */
class User extends Model implements Authenticatable, \Illuminate\Contracts\Auth\CanResetPassword
{
    use Notifiable;
    use \Illuminate\Auth\Authenticatable;
    use CanResetPassword;

    public $timestamps = false;

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }
}
