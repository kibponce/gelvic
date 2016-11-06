<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';

    public static $validation_rules = array(
        'equipment_id' => 'required | unique:equipment',
        'name' => 'required | max:255',
        'rate' => 'required | numeric',
    );
}