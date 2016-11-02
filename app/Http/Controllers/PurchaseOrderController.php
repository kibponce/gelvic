<?php namespace App\Http\Controllers;

class PurchaseOrderController extends Controller {
    public function index()
    {
        return view('components.purchase-order.purchase_order');
    }
}