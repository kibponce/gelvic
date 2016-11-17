<?php

namespace App;
use Carbon\Carbon;
use App\ProjectOrderDailyManpower;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderDaily extends Model
{
    protected $table = 'po_dailies';

    public function getTotalCost($day){
    	$projectOrderDailyManpower = projectOrderDailyManpower::where('po_daily_id', $this->id)->get();

        $total = ProjectOrderDailyManpower::getTotal($projectOrderDailyManpower, $day);

    	return $total->total;
    }
}