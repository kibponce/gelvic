<?php

namespace App;
use App\Rate;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderDailyManpower extends Model
{
    protected $table = 'po_dailies_manpower';
    const MAX_REG_HOUR = 8; 

    public function getRateAndHours() {
    	$regTotalHour = 0;
    	$regHourPay = 0;

    	$regTotalOTHour = 0;
    	$regHourOTPay = 0;

    	$regTotalNPHour = 0;
    	$regHourNPPay = 0;
    	$return = (object)[];

    	if($this->in) {
    		$time_in = new Carbon($this->in);
    		$time_in = $time_in->format('Y-m-D h:i:s');
    		$startTime = Carbon::parse($this->in);
    		
    	}

    	if($this->out) {
    		$time_out = new Carbon($this->out);
    		$time_out = $time_out->format('Y-m-d h:i:s');
    		$finishTime = Carbon::parse($this->out);
    		//return total hours where 12PM is not included
    		$regTotalHour = $finishTime->diffInHours($startTime);

    		

    		//return total hours for OT(above 5pm)
    		if($regTotalHour > self::MAX_REG_HOUR) {
    			$regTotalOTHour = $regTotalHour - self::MAX_REG_HOUR;
    			$regTotalHour = self::MAX_REG_HOUR;
    			
    		}

    		//return total hours for NP(above 10pm)
			$regTotalNPHour = $finishTime->diffInHoursFiltered(function(Carbon $date) {
	    	   return $date->hour >= 22 || $date->hour < 6; 
	    	}, $startTime);

	    	$regHourPay = Rate::getRegHourPay($regTotalHour, $this->rate, $this->day);
	    	$regHourOTPay = Rate::getRegHourOTPay($regTotalOTHour, $this->rate, $this->day);
	    	$regHourNPPay = Rate::getRegHourNPPay($regTotalNPHour, $this->rate, $this->day);	
    		
    	}
    	     
    	$return->regularTotalHour = $regTotalHour;
    	$return->regularHourPay = $regHourPay;

    	$return->regTotalOTHour = $regTotalOTHour;
    	$return->regularHourOTPay = $regHourOTPay;

    	$return->regTotalNPHour = $regTotalNPHour;
    	$return->regHourNPPay = $regHourNPPay;

    	$return->total = $regHourPay + $regHourOTPay + $regHourNPPay;

    	return $return;
    }

    public static function getTotal($data, $day = null) {
        $total = (object)[];
        //Regular
        $total_no_of_hours = 0;
        $total_reg_day= 0;

        //OT
        $total_ot_no_hours= 0;
        $total_ot = 0;

        //NP
        $total_np_no_hours= 0;
        $total_np = 0;

        $totalExpenses = 0;

        foreach ($data as $k=>$v) {
        	$v->day = $day;
            $v->rateAndHours = $v->getRateAndHours(); 

            //Regular
            $total_no_of_hours = $total_no_of_hours + $v->rateAndHours->regularTotalHour;
            $total_reg_day = $total_reg_day + $v->rateAndHours->regularHourPay;

            //OT
            $total_ot_no_hours = $total_ot_no_hours + $v->rateAndHours->regTotalOTHour;
            $total_ot = $total_ot + $v->rateAndHours->regularHourOTPay;

            //NP
            $total_np_no_hours = $total_np_no_hours + $v->rateAndHours->regTotalNPHour;
            $total_np = $total_np + $v->rateAndHours->regHourNPPay;

            $totalExpenses = $totalExpenses + $v->rateAndHours->total;
        }

        $total->total_no_of_hours = $total_no_of_hours;
        $total->total_reg_day = $total_reg_day;
        $total->total_ot_no_hours = $total_ot_no_hours;
        $total->total_ot = $total_ot;
        $total->total_np_no_hours = $total_np_no_hours;
        $total->total_np = $total_np;
        $total->total = $totalExpenses;

        return $total;
    }

}