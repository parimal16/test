<?php

namespace App;

use Exception;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;


class Availability extends Authenticatable
{
    use Notifiable;

    protected $table = 'tutors_availability';
    // To not save created_at and updated_at details into database.
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tutor_id', 'day', 'availability_time', 'un_availability_time', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'is_active', 'created_by', 'created_on', 'updated_by', 'updated_on'
    ];

    public function SaveAvailabilityData($user_mst_data) {
        try {
            $this->tutor_id = $user_avail_data['tutor_id'];
            $this->day = $user_avail_data['day'];
            $this->availability_time = $user_avail_data['availability_time'];
            $this->un_availability_time = $user_avail_data['un_availability_time'];
            $this->is_active = !empty($user_avail_data['is_active']) ? $user_avail_data['is_active'] : true;
            $this->created_by = $user_avail_data['tutor_id'];
            $this->created_on = date(Config::get('constants.default.system_datetime_format'));
            $this->updated_by = $user_avail_data['tutor_id'];
            $this->updated_on = date(Config::get('constants.default.system_datetime_format'));
            $this->save();
            return $this->id;
        } catch (Exception $e){
            throw $e;
        }
    }

    public function user() {
        return $this->belongsTo('App\Users');
    }

}
