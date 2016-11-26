<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';

    public static $validation_rules = array(
        'equipment_id' => 'required',
        'name' => 'required',
        'rate' => 'required | numeric',
    );

    public static $validation_rules_po = array(
        'equipment' => 'required',
        'duration' => 'required | numeric',
    );
}