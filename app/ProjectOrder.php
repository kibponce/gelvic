<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectOrder extends Model
{
    protected $table = 'po';

    public static $validation_rules = array(
        'type' => 'required | max:255',
        'area' => 'required | max:255',
        'start_date' => 'required | date',
        'end_date' => 'required | date',
        'amount' => 'numeric',
    );
}