<?php

namespace Hemend\Library;

class Numbers {
	public static function getDigits($number){
		return preg_replace("/[^0-9]/i", '', $number);
	}
	
	public static function latinToPersian($string) {
	    //arrays of persian and latin numbers
	    $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
	    $latin_num = range(0, 9);
	    
	    $string = str_replace($latin_num, $persian_num, $string);
	    
	    return $string;
	}
	
	public static function persianToLatin($string) {
	    //arrays of persian and latin numbers
	    $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
	    $arabic_num = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
	    $latin_num = range(0, 9);
	    
	    $string = str_replace($persian_num, $latin_num, $string);
	    $string = str_replace($arabic_num, $latin_num, $string);
	    
	    return $string;
	}
	
	public static function zerofill($num, $zerofill)
	{
		return str_pad((int) $num, $zerofill, '0', STR_PAD_LEFT);
	}
	
	public static function isDecimal($number)
	{
		return is_numeric( $number ) && floor( $number ) != $number;
	}
}