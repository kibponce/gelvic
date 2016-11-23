<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';

    public static $validation_rules = array(
        'equipment' => 'required',
        'duration' => 'required | numeric',
    );
}