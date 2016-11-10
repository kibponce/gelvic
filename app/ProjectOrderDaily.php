<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderDaily extends Model
{
    protected $table = 'po_dailies';

    public function getTotalCost(){
    	$projectOrderDailyManpower = projectOrderDailyManpower::where('po_daily_id', $this->id)->get();
    	$totalExpenses = 0;
    	foreach ($projectOrderDailyManpower as $k=>$v) {
    		$v->manpower = Manpower::find($v->manpower_id);
    		$time_in = "";
    		$time_out = "";
    		$total = 0;

    		if($v->in) {
    			$time_in = new Carbon($v->in);
    			$time_in = $time_in->format('h:i A');
    			$startTime = Carbon::parse($v->in);
    			
    		}
    		
    		if($v->out) {
    			$time_out = new Carbon($v->out);
    			$time_out = $time_out->format('h:i A');
    			$finishTime = Carbon::parse($v->out);
    			$total = $finishTime->diffInHours($startTime);
    		}
    		
    		$v->time_in = $time_in;
    		$v->time_out = $time_out;
    		$v->total = $total;
    		$v->totalCost = $total * $v->rate;
    		$totalExpenses = $totalExpenses + $v->totalCost;
    	}

    	return $totalExpenses;
    }
}