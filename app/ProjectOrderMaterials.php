<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderMaterials extends Model
{
    protected $table = 'po_materials';

    public static $validation_rules = array(
        'description' => 'required',
        'quantity' => 'required | numeric',
        'unit' => 'required',
        'unit_cost' => 'required | numeric',
        'duration' => 'required | numeric'
    );
}