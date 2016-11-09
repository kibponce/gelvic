<?php namespace App\Http\Controllers;

use App\ProjectOrder;
use App\ProjectOrderDaily;
use App\Manpower;
use App\ProjectOrderManpower;
use App\ProjectOrderDailyManpower;
use Illuminate\Http\Request;

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

    public function show($id) {
        $projectOrder = ProjectOrder::find($id);
        $projectDaily = ProjectOrderDaily::where('po_id', $id)->get();
        $manpower = Manpower::whereDoesntHave('po_manpower', function ($query) use ($id) {
		    $query->where('po_id', '=', $id);
		})->get();
        $projectOrderManpower = ProjectOrderManpower::where('po_id', $id)->get();
        foreach ($projectOrderManpower as $k=>$v) {
        	$v->manpower = Manpower::find($v->manpower_id);
        }

        $data = array(
            "projectOrder" => $projectOrder,
            "projectDaily" => $projectDaily,
            "manpower" => $manpower,
            "projectOrderManpower" => $projectOrderManpower
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
    	$po_id = $projectDaily->po_id;
        $manpower = projectOrderManpower::where('po_id', $po_id)->whereDoesntHave('po_daily_manpower', function ($query) use ($po_daily_id) {
		    $query->where('po_daily_id', '=', $po_daily_id);
		})->get();

		foreach ($manpower as $k=>$v) {
			$v->manpower = Manpower::find($v->manpower_id);
		}

		$projectOrderDailyManpower = projectOrderDailyManpower::where('po_daily_id', $po_daily_id)->get();

		foreach ($projectOrderDailyManpower as $k=>$v) {
			$v->manpower = Manpower::find($v->manpower_id);
		}
    	$data = array(
            "projectDaily" => $projectDaily,
            "manpower" => $manpower,
            "projectOrderDailyManpower" => $projectOrderDailyManpower
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
}

