<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    protected $table = 'manpower';

    public static $validation_rules = array(
        'employee_id' => 'required | unique:manpower',
        'first_name' => 'required | max:255',
        'last_name' => 'required | max:255',
        'birthdate' => 'required | date',
        'address' => 'required',
        'position' => 'required',
        'rate' => 'required | numeric',
    );

    public function po_manpower()
    {
       return $this->hasMany('App\ProjectOrderManpower', 'manpower_id', 'id');
    }

    public function po_daily_manpower()
    {
       return $this->hasMany('App\ProjectOrderDailyManpower', 'manpower_id', 'id');
    }
}