<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Position extends Model {
    public static $position = array(
            // TYPE A
            "SUPERVISOR" => "TYPE_A",
            "LEADMAN" => "TYPE_A",
            "SAFETY_OFFICER" => "TYPE_A",
            "WIELDER_A" => "TYPE_A",
            "ELECTRICIAN_A" => "TYPE_A",
            "MACHINIST" => "TYPE_A",
            "DRIVER_A" => "TYPE_A",

            // TYPE B
            "SAFETY_OFFICER_B" => "TYPE_B",
            "WIELDER_B" => "TYPE_B",
            "OPERATOR" => "TYPE_B",
            "ELECTRICIAN_B" => "TYPE_B",
            "DRIVER_B" => "TYPE_B",
            "TIME_KEEPER" => "TYPE_B",
            "TOOL_KEEPER" => "TYPE_B",
            "EXPEDITER" => "TYPE_B",

            // TYPE C
            "WIELDER_C" => "TYPE_C",
            "CARPENTER" => "TYPE_C",
            "ELECTRICIAN_C" => "TYPE_C",
            "HELPER" => "TYPE_C",
        );
}
