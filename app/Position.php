<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Position extends Model {
    public static $position = array(
            "SUPERVISOR",
            "SAFETY OFFICER",
            "WIELDER",
            "CARPENTER"
        );
}
