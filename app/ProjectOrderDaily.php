<?php

namespace App;
use Carbon\Carbon;
use App\ProjectOrderDailyManpower;
use App\ProjectOrder;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderDaily extends Model
{
    protected $table = 'po_dailies';

    public function getTotalCost($day){
    	$projectOrderDailyManpower = projectOrderDailyManpower::where('po_daily_id', $this->id)->get();

        $total = ProjectOrderDailyManpower::getTotal($projectOrderDailyManpower, $day);

    	return $total->total;
    }

    public static function processProjectDialy($po_daily_id){
		$projectDaily = ProjectOrderDaily::find($po_daily_id);
	    $dateFormatted = new Carbon($projectDaily->date);
	    $projectDaily->date = $dateFormatted->format("m/d/Y");
	    $projectDaily->isSunday = $dateFormatted->dayOfWeek == Carbon::SUNDAY;
		$po_id = $projectDaily->po_id;
		$projectOrder = ProjectOrder::find($po_id);
	    $manpower = Manpower::whereDoesntHave('po_daily_manpower', function ($query) use ($po_daily_id) {
		    $query->where('po_daily_id', '=', $po_daily_id);
		})->get();

		$projectOrderDailyManpower = ProjectOrderDailyManpower::where('po_daily_id', $po_daily_id)->get();

	    $total = (object)[];
	    $totalA = (object)[];
	    $totalB = (object)[];
	    $totalC = (object)[];

	    $typeA = array();
	    $typeB = array();
	    $typeC = array();

	    $dayStatus = "NORMAL";
	    if($projectDaily->isSunday && !$projectDaily->isHoliday) {
	        $dayStatus = "SUNDAY";
	    }else if(!$projectDaily->isSunday && $projectDaily->isHoliday){
	        $dayStatus = "HOLIDAY";
	    }else if($projectDaily->isSunday && $projectDaily->isHoliday){
	        $dayStatus = "SUNDAYHOLIDAY";
	    }

		foreach ($projectOrderDailyManpower as $k=>$v) {
			$v->manpower = Manpower::find($v->manpower_id);

	        $type = Position::$position[$v->manpower->position];
			$time_in = "";
			$time_out = "";

			if($v->in) {
				$time_in = new Carbon($v->in);
				$time_in = $time_in->format('h:i A');				
			}
			
			if($v->out) {
				$time_out = new Carbon($v->out);
				$time_out = $time_out->format('h:i A');
			}			

			$v->time_in = $time_in;
			$v->time_out = $time_out;

	        switch($type) {
	            case "TYPE_A":
	                array_push($typeA, $v);
	                break;
	            case "TYPE_B":
	                array_push($typeB, $v);
	                break;
	            case "TYPE_C":
	                array_push($typeC, $v);
	                break;
	            default:
	        }
		}


	    $totalA = ProjectOrderDailyManpower::getTotal($typeA, $dayStatus);
	    $totalB = ProjectOrderDailyManpower::getTotal($typeB, $dayStatus);
	    $totalC = ProjectOrderDailyManpower::getTotal($typeC, $dayStatus);
	    $total  = ProjectOrderDailyManpower::getTotal($projectOrderDailyManpower, $dayStatus);

		$data = array(
	        "projectDaily" => $projectDaily,
	        "projectOrder" => $projectOrder,
	        "manpower" => $manpower,
	        "projectOrderDailyManpower" => $projectOrderDailyManpower,
	        "typeA" =>$typeA,
	        "totalA" =>$totalA,
	        "typeB" =>$typeB,
	        "totalB" =>$totalB,
	        "typeC" =>$typeC,
	        "totalC" =>$totalC,
	        "total" =>$total
	    );

	    return $data;

    }
}