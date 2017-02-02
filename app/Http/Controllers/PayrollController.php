<?php namespace App\Http\Controllers;
use App\Manpower;
use App\ProjectOrderDailyManpower;
use App\ProjectOrderDaily;
use Illuminate\Http\Request;

use Validator;
use Redirect;
use Input;

class PayrollController extends Controller {
	public function index($start = null, $end = null) {
		$manpower = [];
		if($start != null) {
			$manpower = Manpower::whereHas('po_daily_manpower', function ($query) use ($start, $end) {
			    $query->whereHas('po_daily', function ($q) use ($start, $end) {
			        $q->whereBetween('date', [$start, $end]);
			    });
			})->get();
		}

		foreach($manpower as $k=>$v) {
			$v->payroll = ProjectOrderDailyManpower::where('manpower_id', $v->id)
							->join('po_dailies', function ($q) use ($start, $end) {
								$q->on('po_dailies.id','=', 'po_dailies_manpower.po_daily_id');
								$q->whereBetween('date', [$start, $end]);
							})
							->select('po_dailies_manpower.id as id', 'po_dailies_manpower.*', 'po_dailies.id as daily_id', 'po_dailies.date', 'po_dailies.status', 'po_dailies.activity', 'po_dailies.isHoliday', 'po_dailies.isRegular')
							->get();

			$v->payrollTotal = ProjectOrderDailyManpower::getTotal($v->payroll, false);
		}

		$data = array(
            'manpower' => $manpower,
            'start' => $start,
            'end' => $end
        );

        return view('components.payroll.payroll', $data);
	}

}