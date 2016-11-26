<?php namespace App\Http\Controllers;
use App\Equipment;
use App\ProjectOrderEquipment;
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

    			return $this->redirect_to_equipment_add->withErrors($validate)->withInput();
    		
    	}
    }

    public function projectPost(Request $request) {
        $po_id = $request->input('po_id');
        $validate = Validator::make($request->all(), Equipment::$validation_rules_po);
        if ($validate->passes()) {
            $equipment = $request->input('equipment');
            $equipmentData = Equipment::find($equipment);
            $duration = $request->input('duration');
            $rate = $equipmentData->rate;
            $expense = $request->input('expense') != "" ? $request->input('expense') : 0;

            $projectEquipment = new ProjectOrderEquipment;
            $projectEquipment->equipment_id = $equipment;
            $projectEquipment->po_id = $po_id;
            $projectEquipment->duration = $duration;
            $projectEquipment->rate = $rate;
            $projectEquipment->expense = $expense;
            if($projectEquipment->save()){
                return redirect()->action('ProjectOrderController@show', $po_id)->with('success', 'Equipment has been successfully added');
            }
        }else{
            return redirect()->action('ProjectOrderController@show', array( 'id' => $po_id, 'error' => "EQUIPMENT"))->withErrors($validate)->withInput();
        }
    }

    public function projectDelete($id, $po_id){
        $po_equipment = ProjectOrderEquipment::find($id);

        if($po_equipment->delete()){
            return redirect()->action('ProjectOrderController@show', $po_id)->with('success', 'Equipment has been successfully removed');
        }
    }

}