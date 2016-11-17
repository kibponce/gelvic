<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Position extends Model {
    public static $position = array(
            "SUPERVISOR" => "TYPE_A",
            "SAFETY OFFICER" => "TYPE_B",
            "WIELDER" => "TYPE_B",
            "CARPENTER" => "TYPE_C"
        );
}
