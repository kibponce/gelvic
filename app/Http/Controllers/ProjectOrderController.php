<?php namespace App\Http\Controllers;

use App\ProjectOrder;
use App\ProjectOrderDaily;
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
        $data = array(
            "projectOrder" => $projectOrder,
            "projectDaily" => $projectDaily
        );

        return view('components.project-order.project-order-details', $data);
    }

    public function generateDaily(Request $request) {
    	$po_id = $request->input('po_id');
    	$date = $request->input('date');

    	$po_daily = ProjectOrderDaily::where('po_id', $po_id)
    									->where('date', $date);

 		if($po_daily->get()->count() > 0) {
 			echo 'naa na';
 		}else{
 			$po_daily = new ProjectOrderDaily;
 			$po_daily->po_id = $po_id;
 			$po_daily->date = $date;
 			$po_daily->save();
 		}
    }

    public function showProjectDaily($po_daily_id){
    	$projectDaily = ProjectOrderDaily::find($po_daily_id);
    	$data = array(
            "projectDaily" => $projectDaily
        );

        return view('components.project-order.project-daily', $data);
    }
}

