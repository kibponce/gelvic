<?php
namespace App;

class Rate {
	// REGULAR
	public static function reg($rate) {
		return $rate;
	}

	public static function regOT($rate) {
		return ($rate  * 1.25);
	}

	public static function regNP($rate) {
		return ( $rate * 0.10 );
	}

	//SUNDAY
	public static function sundayNormal($rate) {
		return ($rate  * 1.3);
	}

	public static function sundayOT($rate) {
		return ($rate  * 1.69);
	}

	public static function sundayNP($rate) {
		return ($rate  * 0.13);
	}

	//HOLIDAY
	public static function holidayNormal($rate) {
		return ($rate  * 2);
	}

	public static function holidayOT($rate) {
		return ($rate  * 2.6);
	}

	public static function holidayNP($rate) {
		return ($rate  * 0.2);
	}


	//SUNDAY + HOLIDAY
	public static function sundayHolidayNormal($rate) {
		return ($rate  * 2.6);
	}

	public static function sundayHolidayOT($rate) {
		return ($rate  * 3.38);
	}

	public static function sundayHolidayNP($rate) {
		return ($rate  * 0.2);
	}

	public static function getNormalRate($rate, $day = null) {
		switch($day) {
			case "HOLIDAY":
				return self::holidayNormal($rate);
				break;
			case "SUNDAY":
				return self::sundayNormal($rate);
				break;
			case "SUNDAYHOLIDAY":
				return self::sundayHolidayNormal($rate);
				break;
			default :
				return self::reg($rate);
				break;
		}
	}

	public static function getOTRate($rate, $day = null) {
		switch($day) {
			case "HOLIDAY":
				return self::holidayOT($rate);
				break;
			case "SUNDAY":
				return self::sundayOT($rate);
				break;
			case "SUNDAYHOLIDAY":
				return self::sundayHolidayOT($rate);
				break;
			default :
				return self::regOT($rate);
				break;
		}
	}

	public static function getNPRate($rate, $day = null) {
		switch($day) {
			case "HOLIDAY":
				return self::holidayNP($rate);
				break;
			case "SUNDAY":
				return self::sundayNP($rate);
				break;
			case "SUNDAYHOLIDAY":
				return self::sundayHolidayNP($rate);
				break;
			default :
				return self::regNP($rate);
				break;
		}
	}


    public static function getRegHourPay($totalHours = null, $rate = null, $day = null) {
    	return $totalHours * self::getNormalRate($rate, $day);
    }

    public static function getRegHourOTPay($totalHours = null, $rate = null, $day = null) {
    	return $totalHours * self::getOTRate($rate, $day);
    }

    public static function getRegHourNPPay($totalHours = null, $rate = null, $day = null) {
    	return $totalHours * self::getNPRate( $rate, $day );
    }
}
