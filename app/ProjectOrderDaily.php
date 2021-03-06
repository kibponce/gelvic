<?php

namespace App;
use Carbon\Carbon;
use App\ProjectOrderDailyManpower;
use App\ProjectOrderDailyEquipment;
use App\ProjectOrder;
use App\Equipment;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProjectOrderDaily extends Model
{
	use SoftDeletes;
    protected $table = 'po_dailies';

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
   protected $dates = ['deleted_at'];

    public function getTotalCost($day){
    	$projectOrderDailyManpower = ProjectOrderDailyManpower::where('po_daily_id', $this->id)
    													->join('po_dailies', function ($q) {
    														$q->select('po_dailies.id as po_daily_id', 'po_dailies.*');
    														$q->on('po_dailies.id','=', 'po_dailies_manpower.po_daily_id');
    													})
    													->select('po_dailies_manpower.id as id', 'po_dailies_manpower.*', 'po_dailies.id as daily_id', 'po_dailies.date', 'po_dailies.status', 'po_dailies.activity', 'po_dailies.isHoliday', 'po_dailies.isRegular', 'po_dailies.isSpecial')
    													->get();

        $total = ProjectOrderDailyManpower::getTotal($projectOrderDailyManpower, false);

    	return $total->total;
    }

    public static function processProjectDialy($po_daily_id, $isBilling = false){
		$projectDaily = ProjectOrderDaily::find($po_daily_id);
	    $dateFormatted = new Carbon($projectDaily->date);
	    $projectDaily->date = $dateFormatted->format("m/d/Y");
	    $projectDaily->isSunday = $dateFormatted->dayOfWeek == Carbon::SUNDAY;
		$po_id = $projectDaily->po_id;
		$projectOrder = ProjectOrder::find($po_id);
	    $manpower = Manpower::whereDoesntHave('po_daily_manpower', function ($query) use ($po_daily_id) {
		    $query->where('po_daily_id', '=', $po_daily_id);
		})->get();

		$projectOrderDailyManpower = ProjectOrderDailyManpower::where('po_daily_id', $po_daily_id)
														->join('po_dailies', function ($q) {
															$q->select('po_dailies.id as po_daily_id', 'po_dailies.*');
															$q->on('po_dailies.id','=', 'po_dailies_manpower.po_daily_id');
														})
														->select('po_dailies_manpower.id as id', 'po_dailies_manpower.*', 'po_dailies.id as daily_id', 'po_dailies.date', 'po_dailies.status', 'po_dailies.activity', 'po_dailies.isHoliday', 'po_dailies.isRegular', 'po_dailies.isSpecial')
														->get();

	    $total = (object)[];
	    $totalA = (object)[];
	    $totalB = (object)[];
	    $totalC = (object)[];

	    $typeA = array();
	    $typeB = array();
	    $typeC = array();

	    //Get what type of day
	    $dayStatus = "NORMAL";
	    if($projectDaily->isSunday && !$projectDaily->isHoliday && !$projectDaily->isRegular) {
	        $dayStatus = "SUNDAY";
	    }else if($projectDaily->isSpecial && $projectDaily->isHoliday){
	        $dayStatus = "SUNDAYHOLIDAY";
	    }else if(!$projectDaily->isSunday && $projectDaily->isHoliday){
	        $dayStatus = "HOLIDAY";
	    }else if($projectDaily->isSunday && $projectDaily->isHoliday){
	        $dayStatus = "SUNDAYHOLIDAY";
	    }else if($projectDaily->isSpecial){
			$dayStatus = "SUNDAY";
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
	            	if($isBilling){
	            		$v->rate = $projectOrder->type_a;
	            	}
	                array_push($typeA, $v);
	                break;
	            case "TYPE_B":
	            	if($isBilling){
	            		$v->rate = $projectOrder->type_b;
	            	}
	                array_push($typeB, $v);
	                break;
	            case "TYPE_C":
	            	if($isBilling){
	            		$v->rate = $projectOrder->type_c;
	            	}
	                array_push($typeC, $v);
	                break;
	            default:
	        }
		}

		//process the total project daily of a person
	    $totalA = ProjectOrderDailyManpower::getTotal($typeA, $isBilling);
	    $totalB = ProjectOrderDailyManpower::getTotal($typeB, $isBilling);
	    $totalC = ProjectOrderDailyManpower::getTotal($typeC, $isBilling);
	    $total  = ProjectOrderDailyManpower::getTotal($projectOrderDailyManpower, $isBilling);

		$data = array(
	        "dayStatus" => $dayStatus,
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