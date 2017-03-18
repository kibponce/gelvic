<?php

namespace App;
use App\Rate;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderDailyEquipment extends Model {
    protected $table = 'po_dailies_equipment';

    public static $validation_rules = array(
        'equipment' => 'required',
        'duration' => 'required | numeric',
    );
}