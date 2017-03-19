<?php

namespace App;
use App\Rate;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderDailyManpower extends Model
{
    protected $table = 'po_dailies_manpower';
    const MAX_REG_HOUR = 8; 

    //Process the rate and hours of manpower's daily
    //return object
    public function getRateAndHours() {
        $paxCount = 0;

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

            //Make 12pm not counted on total hours
            if(!$this->is_paid_break){
                $regTotalHour = $finishTime->diffInHoursFiltered(function(Carbon $date) {
                   return $date->hour != 12;
                }, $startTime);
            }

            if($regTotalHour <= 8){
                $paxCount = $regTotalHour / 8;
            }else{
                $paxCount = 1;
            }

    		//return total hours for OT(above 5pm)
    		if($regTotalHour > self::MAX_REG_HOUR) {
    			$regTotalOTHour = $regTotalHour - self::MAX_REG_HOUR;
    			$regTotalHour = self::MAX_REG_HOUR;
    		}

    		//return total hours for NP(above 10pm)
			$regTotalNPHour = $finishTime->diffInHoursFiltered(function(Carbon $date) {
	    	   return $date->hour >= 22 || $date->hour < 6; 
	    	}, $startTime);
			
			//If manpower has is special, make rate to sunday
			if($this->is_special) {
				$this->day = "SUNDAY";
			}

	    	$regHourPay = Rate::getRegHourPay($regTotalHour, $this->rate, $this->day);
	    	$regHourOTPay = Rate::getRegHourOTPay($regTotalOTHour, $this->rate, $this->day);
	    	$regHourNPPay = Rate::getRegHourNPPay($regTotalNPHour, $this->rate, $this->day);	
    		
    	}
    	     
        $return->paxCount = $paxCount;

    	$return->regularTotalHour = $regTotalHour;
    	$return->regularHourPay = $regHourPay;

    	$return->regTotalOTHour = $regTotalOTHour;
    	$return->regularHourOTPay = $regHourOTPay;

    	$return->regTotalNPHour = $regTotalNPHour;
    	$return->regHourNPPay = $regHourNPPay;

    	$return->total = $regHourPay + $regHourOTPay + $regHourNPPay;

    	return $return;
    }

    //process the total project daily of a person
    public static function getTotal($data, $isBilling = false) {
        $total = (object)[];
        //Pax Count
        $total_pax = 0;
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
            $dateFormatted = new Carbon($v->date);
            $v->isSunday = $dateFormatted->dayOfWeek == Carbon::SUNDAY;
            $dayStatus = "NORMAL";
            if($v->isSunday && !$v->isHoliday && !$v->isRegular) {
                $dayStatus = "SUNDAY";
            }else if($v->isSpecial && $v->isHoliday){
                $dayStatus = "SUNDAYHOLIDAY";
            }else if(!$v->isSunday && $v->isHoliday){
                $dayStatus = "HOLIDAY";
            }else if($v->isSunday && $v->isHoliday){
                $dayStatus = "SUNDAYHOLIDAY";
            }else if($v->isSpecial){
                $dayStatus = "SUNDAY";
            }else if($v->isSpecial && $v->isHoliday){
                $dayStatus = "SUNDAYHOLIDAY";
            }

        	$v->day = $dayStatus;
            $v->rateAndHours = $v->getRateAndHours(); 

            //Pax Count
            $total_pax = $total_pax + $v->rateAndHours->paxCount;

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

        $total->total_pax = $total_pax;
        $total->total_no_of_hours = $total_no_of_hours;
        $total->total_reg_day = $total_reg_day;
        $total->total_ot_no_hours = $total_ot_no_hours;
        $total->total_ot = $total_ot;
        $total->total_np_no_hours = $total_np_no_hours;
        $total->total_np = $total_np;
        $total->total = $totalExpenses;

        return $total;
    }


    public function po_daily()
    {
       return $this->hasMany('App\ProjectOrderDaily', 'id', 'po_daily_id');
    }

}