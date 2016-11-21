<?php namespace App\Http\Controllers;

use App\ProjectOrder;
use App\ProjectOrderDaily;
use App\Manpower;
use App\Position;
use App\Equipment;
use App\ProjectOrderMaterials;
use App\ProjectOrderDailyManpower;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Validator;
use Redirect;
use Input;

class ProjectOrderController extends Controller {
    public function index() {
    	$po = ProjectOrder::all();

    	$data = array(
    	    'po' => $po
    	);

        return view('components.project-order.project_order', $data);
    }

    public function add($id = "") {
        $projectOrder = ProjectOrder::find($id);
        $data = array(
            "projectOrder" => $projectOrder
        );
    	return view('components.project-order.project-order-add', $data);
    }

    public function post(Request $request){
    	$id = $request->input('id');
        
        if($id != "") {
            array_splice(ProjectOrder::$validation_rules, 0, 1);
        }

    	$validate = Validator::make($request->all(), ProjectOrder::$validation_rules);
    	if ($validate->passes()) {
    	   
    	    $po_number = $request->input('po_number');
    	    $type = $request->input('type');
    	    $amount = $request->input('amount');
    	    $start_date = $request->input('start_date');
    	    $end_date = $request->input('end_date');
    	    $area = $request->input('area');
            $description = $request->input('description');
    	    $deliver_to = $request->input('deliver_to');

    	    if($id != "") {
	       		$po = ProjectOrder::find($id);
    	    }else{
    	        $po = new ProjectOrder;
    	    }
    	    
    	    $po->po_number = $po_number;
    	    $po->type = $type;
    	    $po->amount = $amount;
    	    $po->start_date = $start_date;
    	    $po->end_date = $end_date;
    	    $po->area = $area;
            $po->description = $description;
    	    $po->deliver_to = $deliver_to;

    	    if($po->save()){
    	        if($id != "") {
    	            return redirect()->action('ProjectOrderController@add', $id)->with('success', 'Manpower has been successfully saved');
    	        } else {
    	            return redirect()->action('ProjectOrderController@add')->with('success', 'Manpower has been successfully saved');
    	        }                  
    	    }
    	}else{
    	    if($id != "") {
    	        return redirect()->action('ProjectOrderController@add', $id)->withErrors($validate)->withInput();
    	    } else {
    	        return redirect()->action('ProjectOrderController@add')->withErrors($validate)->withInput();
    	    }
    	}
    }

    public function show($id, Request $request) {
        $projectOrder = ProjectOrder::find($id);
        $projectDaily = ProjectOrderDaily::where('po_id', $id)->get();
        $equipments = Equipment::all();
        $projectTotalExpenses = 0;

        //Get Total Expenses on all PO Dailies
        foreach ($projectDaily as $k=>$v) {
            $dateFormatted = new Carbon($v->date);
        	
            $v->isSunday = $dateFormatted->dayOfWeek == Carbon::SUNDAY;

            $dayStatus = "NORMAL";
            if($v->isSunday && !$v->isHoliday) {
                $dayStatus = "SUNDAY";
            }else if(!$v->isSunday && $v->isHoliday){
                $dayStatus = "HOLIDAY";
            }else if($v->isSunday && $v->isHoliday){
                $dayStatus = "SUNDAYHOLIDAY";
            }

            $v->totalCost = $v->getTotalCost($dayStatus);

        	$projectTotalExpenses = $projectTotalExpenses + $v->totalCost;
        }

        //Get All Materials on the PO
        $totalMaterialsExpense = 0;
        $projectOrderMaterials = ProjectOrderMaterials::where('po_id', $id)->get();
        foreach ($projectOrderMaterials as $k=>$v) {
        	$v->total_amount = ($v->quantity * $v->unit_cost) * $v->duration;
        	$totalMaterialsExpense = $totalMaterialsExpense + $v->total_amount;
        	$projectTotalExpenses = $projectTotalExpenses + $v->total_amount;
        }

        $error = $request->get('error');
        $data = array(
            "equipments" => $equipments,
            "projectOrder" => $projectOrder,
            "projectDaily" => $projectDaily,
            "projectOrderMaterials" => $projectOrderMaterials,
            "projectTotalExpenses" => $projectTotalExpenses,
            "totalMaterialsExpense" => $totalMaterialsExpense,
            "projectRemainingBalance" => $projectOrder->amount - $projectTotalExpenses,
            "error" => $error
        );

        return view('components.project-order.project-order-details', $data);
    }

    public function generateDaily(Request $request) {
    	$po_id = $request->input('po_id');
    	$date = $request->input('date');

    	$po_daily = ProjectOrderDaily::where('po_id', $po_id)
    									->where('date', $date);

 		if($po_daily->get()->count() > 0) {
 			$projecy_daily = $po_daily->get()->first();
 			return redirect()->action('ProjectOrderController@showProjectDaily', $projecy_daily->id);
 		}else{
 			$po_daily = new ProjectOrderDaily;
 			$po_daily->po_id = $po_id;
 			$po_daily->date = $date;
 			if($po_daily->save()){
 				return redirect()->action('ProjectOrderController@showProjectDaily', $po_daily->id);
 			}
 		}
    }

    public function showProjectDaily($po_daily_id){
    	$projectDaily = ProjectOrderDaily::find($po_daily_id);
        $dateFormatted = new Carbon($projectDaily->date);
        $projectDaily->date = $dateFormatted->format("m/d/Y");
        $projectDaily->isSunday = $dateFormatted->dayOfWeek == Carbon::SUNDAY;
    	$po_id = $projectDaily->po_id;
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

        return view('components.project-order.project-daily', $data);
    }

    public function assignManpowerToProject($po_id, $manpower_id) {
    	$po_manpower = new ProjectOrderManpower;
    	$po_manpower->po_id = $po_id;
    	$po_manpower->manpower_id = $manpower_id;

    	if($po_manpower->save()) {
    		return redirect()->action('ProjectOrderController@show', $po_id)->with('success', 'Manpower has been successfully added');
    	}
    }

    public function deleteManpowerFromProject($id) {
    	$po_manpower = ProjectOrderManpower::find($id);

    	if($po_manpower->delete()){
    		return redirect()->action('ProjectOrderController@show', $po_manpower->po_id)->with('success', 'Manpower has been successfully deleted');
    	}
    }

    public function assignManpowerToProjectDaily($po_daily_id, $manpower_id) {
    	$manpower = Manpower::find($manpower_id);
    	$po_daily_manpower = new ProjectOrderDailyManpower;
    	$po_daily_manpower->po_daily_id = $po_daily_id;
    	$po_daily_manpower->manpower_id = $manpower_id;
    	$po_daily_manpower->rate = $manpower->rate;

    	if($po_daily_manpower->save()) {
    		return redirect()->action('ProjectOrderController@showProjectDaily', $po_daily_id)->with('success', 'Manpower has been successfully added');
    	}
    }

    public function postManpowerDailyLog(Request $request){
    	$in = $request->input('in');
    	$out = $request->input('out');
    	$id = $request->input('id');

    	$manpower_daily = ProjectOrderDailyManpower::find($id);
    	$project_daily = ProjectOrderDaily::find($manpower_daily->po_daily_id);
    	$date = $project_daily->date;
    	$dateTime_in = Carbon::createFromFormat('Y-m-d H:i a', $in);
    	$dateTime_out = Carbon::createFromFormat('Y-m-d H:i a', $out);

    	$time_in = Carbon::instance($dateTime_in);
    	$time_out = Carbon::instance($dateTime_out);
        
    	$manpower_daily->in = $time_in->toDateTimeString();
    	$manpower_daily->out = $time_out->toDateTimeString();
    	if($manpower_daily->save()){
    		return redirect()->action('ProjectOrderController@showProjectDaily', $manpower_daily->po_daily_id)->with('success', 'Manpower Time Log is updated');
    	}
    }

    public function updateActivity(Request $request) {
        $activity = $request->input("activity");
        $daily_id = $request->input("daily_id");
        $holiday = $request->input("holiday");
        $daily = ProjectOrderDaily::find($daily_id);
        $daily->isHoliday = intval($holiday);
        $daily->activity = $activity;
        if($daily->save()){
            return redirect()->action('ProjectOrderController@showProjectDaily', $daily->id)->with('success', 'Daily Activty is succesfully updated');
        }
    }

    public function deleteDailyManpower($id, $po_daily_id) {
        $manpower_daily = ProjectOrderDailyManpower::find($id);

        $manpower_daily->delete();
        return redirect()->action('ProjectOrderController@showProjectDaily', $po_daily_id)->with('success', 'Manpower is succesfully removed');
    }
}

