<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderManpower extends Model
{
    protected $table = 'po_manpower';

    public function po_daily_manpower()
    {
       return $this->hasMany('App\ProjectOrderDailyManpower', 'manpower_id', 'manpower_id');
    }

}