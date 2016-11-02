<?php namespace App\Http\Controllers;
use App\Position;
use App\Manpower;
use Illuminate\Http\Request;

use Validator;
use Redirect;
use Input;

class ManpowerController extends Controller {
    public function __construct(){
        $this->redirect_to_manpower_index = redirect()->action('ManpowerController@index');
        $this->redirect_to_manpower_add = redirect()->action('ManpowerController@add');
    }

    public function index() {
        $manpower = Manpower::all();

        $data = array(
            'manpower' => $manpower
        );
        return view('components.manpower.manpower', $data);
    }

    public function add($id = "") {
        $positions = Position::$position;
        $manpower = Manpower::find($id);
        $data = array(
            "positions" => $positions,
            "manpower" => $manpower
        );
        return view('components.manpower.add', $data);
    }

    public function post(Request $request) {
        $id = $request->input('id');
        
        if($id != "") {
            array_splice(Manpower::$validation_rules, 0, 1);
        }
        
        $validate = Validator::make($request->all(), Manpower::$validation_rules);
        if ($validate->passes()) {
           
            $employee_id = $request->input('employee_id');
            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $birthdate = $request->input('birthdate');
            $address = $request->input('address');
            $position = $request->input('position');
            $rate = $request->input('rate');

            if($id != "") {
                $manpower = Manpower::find($id);
            }else{
                $manpower = new Manpower;
            }
            
            $manpower->employee_id = $employee_id;
            $manpower->first_name = $first_name;
            $manpower->last_name = $last_name;
            $manpower->position = $position;
            $manpower->address = $address;
            $manpower->birthdate = $birthdate;
            $manpower->rate = $rate;

            if($manpower->save()){
                if($id != "") {
                    return redirect()->action('ManpowerController@add', $id)->with('success', 'Manpower has been successfully saved');
                } else {
                    return $this->redirect_to_manpower_add->with('success', 'Manpower has been successfully saved');
                }               
               
            }
        }else{
            if($id != "") {
                return redirect()->action('ManpowerController@add', $id)->withErrors($validate)->withInput();
            } else {
                return $this->redirect_to_manpower_add->withErrors($validate)->withInput();
            }
        }

       
    }
}