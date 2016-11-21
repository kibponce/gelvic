<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderEquipment extends Model
{
    protected $table = 'po_equipment';

    public static $validation_rules = array(
        'equipment_id' => 'required',
        'rate' => 'required | numeric',
        'duration' => 'required | numeric',
        'expense' => 'required | numeric'
    );
}