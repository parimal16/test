<?php

namespace App;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Users extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    // To save created_at and updated_at details into database.
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'email_verified_at', 'created_at', 'updated_at'
    ];

    public function SaveUserData($user_mst_data) {
        try {
            $this->name = $user_mst_data['name'];
            $this->email = $user_mst_data['email'];
            $this->password = $user_mst_data['password'];
            $this->email_verified_at = date(Config::get('constants.default.system_datetime_format'));
            $this->save();
            return $this->id;
        } catch (Exception $e){
            throw $e;
        }
    }

    public function availibility() {
        return $this->hasMany('App\Availibility', 'tutor_id');
    }

}
