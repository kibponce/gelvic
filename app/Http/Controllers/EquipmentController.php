<?php namespace App\Http\Controllers;

class EquipmentController extends Controller {
    public function index()
    {
        return view('components.equipment.equipment');
    }
}