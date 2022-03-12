<?php

namespace Hemend\Library;

class Strings {
	public static function convertWordsFromArabicToPersian($text)
	{
		$find = array(
			'ي',
			'ك'
		);
			
		$replace = array(
			'ی',
			'ک'
		);
		return str_replace($find, $replace, $text);
	}
	
	//ex: balalArast => Balal Arast
	public static function splitAtCapitalLetters($subject, $splitBy = ' ')
	{
		if(!$subject) {
			return $subject;
		}
	
		return preg_replace('/(?<=\\w)(?=[A-Z])/', '$1'.$splitBy.'$2', $subject);
	}
	
	public static function stringToCapitalLetters($subject, $separate = ' ', $delimiter = ' ,-_')
	{
		if(!$subject) {
			return $subject;
		}
	
		$delimiterSplit = str_split($delimiter);
		$subject = ucwords($subject, $delimiter);
		return str_replace($delimiterSplit, $separate, $subject);
	}
	
	/**
	 *
	 * @param	string	$subject	ex: '1,2,3,4,5,6,7,8,9,10'
	 * @param	string	$delimiter	ex: ','
	 * @param	integer	$count		ex: 5
	 * @param	integer	$len		ex: 0
	 */
	public static function subStringByDelimiter($subject, $delimiter, $count, $len = 0)
	{
		$tok = strtok($subject, $delimiter);
		while($tok !== FALSE && $count--)
		{
		    $len += strlen($tok) + !!$count;
		    $tok = strtok($delimiter);
		}
		
		return substr($subject, 0, $len);
	}
	
	public static function generateRandomCode($length = 6)
	{
		$pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
	}
}
