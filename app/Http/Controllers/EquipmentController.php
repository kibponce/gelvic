<?php namespace App\Http\Controllers;
use App\Equipment;
use Illuminate\Http\Request;

use Validator;
use Redirect;
use Input;

class EquipmentController extends Controller {
	public function __construct(){
	    $this->redirect_to_equipment_index = redirect()->action('EquipmentController@index');
	    $this->redirect_to_equipment_add = redirect()->action('EquipmentController@add');
	}

    public function index() {
    	$equipment = Equipment::all();

    	$data = array(
    	    'equipment' => $equipment
    	);
        return view('components.equipment.equipment', $data);
    }

    public function add($id = "") {
    	$equipment = Equipment::find($id);
    	$data = array(
    	    "equipment" => $equipment
    	);
        return view('components.equipment.add', $data);
    }

    public function post(Request $request) {
    	$id = $request->input('id');

    	$validate = Validator::make($request->all(), Equipment::$validation_rules);
    	if ($validate->passes()) {
    	   
    	    $equipment_id = $request->input('equipment_id');
    	    $name = $request->input('name');
    	    $rate = $request->input('rate');

    	    if($id != "") {
    	        $equipment = Equipment::find($id);
    	    }else{
    	        $equipment = new Equipment;
    	    }
    	    
    	    $equipment->equipment_id = $equipment_id;
    	    $equipment->name = $name;
    	    $equipment->rate = $rate;

    	    if($equipment->save()){  
    	    	if($id != "") {
    	    	    return redirect()->action('EquipmentController@add', $id)->with('success', 'Equipment has been successfully saved');
    	    	}else{
    	    		return $this->redirect_to_equipment_add->with('success', 'Equipment has been successfully saved');
    	    	}           
    	        
    	    }else{
    	    	return $this->redirect_to_equipment_add->with('error', 'Equipment save error');
    	    }
    	}else{
    		if($id != "") {
    		    return redirect()->action('EquipmentController@add', $id)->with('success', 'Equipment has been successfully saved');
    		}else{
    			return $this->redirect_to_equipment_add->withErrors($validate)->withInput();
    		}
    	}
    }
}