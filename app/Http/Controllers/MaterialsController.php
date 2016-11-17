<?php namespace App\Http\Controllers;
use App\ProjectOrderMaterials;
use Illuminate\Http\Request;

use Validator;
use Redirect;
use Input;

class MaterialsController extends Controller {
	public function post(Request $request) {
		$po_id = $request->input('po_id');
		$validate = Validator::make($request->all(), ProjectOrderMaterials::$validation_rules);
		if ($validate->passes()) {
			$description = $request->input('description');
			$quantity = $request->input('quantity');
			$unit = $request->input('unit');
			$unit_cost = $request->input('unit_cost');
			$duration = $request->input('duration');

			$po_materials = new ProjectOrderMaterials;
			$po_materials->po_id = $po_id;
			$po_materials->description = $description;
			$po_materials->quantity = $quantity;
			$po_materials->unit = $unit;
			$po_materials->unit_cost = $unit_cost;
			$po_materials->duration = $duration;

			if($po_materials->save()){
				return redirect()->action('ProjectOrderController@show', $po_id)->with('success', 'Materials has been successfully added');
			}
		}else{
			return redirect()->action('ProjectOrderController@show', array( 'id' => $po_id, 'error' => "MATERIALS"))->withErrors($validate)->withInput();
		}
	}

	public function delete($id, $po_id) {
		$po_materials = ProjectOrderMaterials::find($id);

		if($po_materials->delete()){
			return redirect()->action('ProjectOrderController@show', $po_id)->with('success', 'Materials has been successfully removed');
		}
	}
}