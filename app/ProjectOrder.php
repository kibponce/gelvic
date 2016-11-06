<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectOrder extends Model
{
    protected $table = 'po';

    public static $validation_rules = array(
        'po_number' => 'required | unique:po',
        'type' => 'required | max:255',
        'area' => 'required | max:255',
        'start_date' => 'required | date',
        'end_date' => 'required | date',
        'amount' => 'required | numeric',
    );
}