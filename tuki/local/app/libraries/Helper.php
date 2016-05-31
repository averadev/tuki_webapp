<?php
/**
LIBRERIA PARA CREAR FUNCIONES QUE SEAN UTILES PARA MODELOS O CONTROLES :)
*/
use Carbon\Carbon;
class Helper 
{
	/**
	* @var numberMonth recibe el numero del mes y retorna su nombre correspondiente
	*/
	public static function getNameMonth($numberMonth=0){
		$numberMonth = (int)$numberMonth;
		switch ($numberMonth) {
			case 1: return 'ENERO';
			case 2: return 'FEBRERO';
			case 3: return 'MARZO';
			case 4: return 'ABRIL';
			case 5: return 'MAYO';
			case 6: return 'JUNIO';
			case 7: return 'JULIO';
			case 8: return 'AGOSTO';
			case 9: return 'SEPTIEMBRE';
			case 10: return 'OCTUBRE';
			case 11: return 'NOVIEMBRE';
			case 12: return 'DICIEMBRE';
			default: return '';
		}
	}
	/**
	* @var year recibe el año
	* @var month recibe el numero del mes
	* @return fecha con el ultimo dia del mes
	*/
	public static function getLastMonthDay($month,$year){
		//$day = date("d",(mktime(0,0,0,$month+1,1,$year)-1));
		$day = date("d", mktime(0,0,0, $month+1, 0, $year));
		return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
	}
	/**
	* @var year recibe el año
	* @var month recibe el numero del mes
	* @return fecha con el primer dia del mes
	*/
	public static function getFirstMonthDay($month,$year){
	  return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
	}

	/**
	* @var $date fecha en formato dd/mm/yyyy
	* @return $data convertido a formato dd-mm-yyyy
	*/
	public static function convertDateOne($date){
		$your_date = date('Y-m-d',strtotime(str_replace('/', '-', $date)));
		return $your_date;
	}
	/**
	* @return Un arreglo con los meses
	*/
	public static function getArrayMonths(){
		$months = array(
			1  =>'ENERO',
			2  =>'FEBRERO',
			3  =>'MARZO',
			4  =>'ABRIL',
			5  =>'MAYO',
			6  =>'JUNIO',
			7  =>'JULIO',
			8  =>'AGOSTO',
			9  =>'SEPTIEMBRE',
			10 =>'OCTUBRE',
			11 =>'NOVIEMBRE',
			12 =>'DICIEMBRE'
		);
		$totalMonths = array();
		$currentMonth = intval(Carbon::now()->format('m'));
		foreach ($months as $key => $value) {
			$totalMonths[$key] =$months[$key];
			if($key == $currentMonth){
				break;
			}
		}
		return $totalMonths;
	}
	/**
	*
	*/
	public static function getStartEndYear($year){
		return array($year.'-01-01',$year.'-12-31');
	}
	/**
	* @return Un arreglo con una lista de años
	*/
	public static function getArrayYears(){
		$years = array(
			'2013' => 2013,
			'2014' => 2014,
			'2015' => 2015,
			'2016' => 2016
		);
		return $years;
	}
	/**
	* @var month recibe el mes en caso de ser null será el mes actual
	* @var year  recibe el año en caso de ser null será el año actual
	* @var day recibe el día en caso de ser null será viernes
	* @return Un arreglo con una lista de la semanas del mes con el día solicitado
	*/
	public static function getWeeksMonthByDay($month = null,$year = null,$day = 'Friday'){
			$month = is_null($month) ? date('n'):$month;
			$year  = is_null($year) ? date('Y'):$year;
			$first = self::getFirstMonthDay($month,$year);
			$last  = self::getLastMonthDay($month,$year);
			$pointer = new DateTime($first);
			$minDate = clone $pointer;
			$week = array();
			while($pointer->format('n') == $month){
				 if($pointer->format('l') == $day){
					 $week[0] = $minDate->format('Y-m-d');
					 $week[1] = $pointer->format('Y-m-d');
					 $minDate = clone $pointer;
					 $minDate->modify('+1day');
					 $weeks['week_'.$pointer->format('W').'_'.$pointer->format('n')] = $week;
				 }
				 if($pointer->format('Y-m-d') == $last && $minDate->format('n') == $month){
					 $week[0] = $minDate->format('Y-m-d');
					 $week[1] = $pointer->format('Y-m-d');
					 $weeks['week_last_'.$pointer->format('W').'_'.$pointer->format('n')] = $week;
				 }
				$pointer->modify('+1day');
			}
			return $weeks;
	}

	/**
	* @var rgb recibe un string con el codigo rgb
	*/
	public static function rgb2hex($rgb) {
		$hex = "#";
		$hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
		return $hex; // returns the hex value including the number sign (#)
	}

	/**
	*
	*/
	public static function randomPassword($length){
		return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , $length );
	}	

	/*Guarda imagenes*/

	public static function saveImage($imgdata,$prefixName,$pathimg,$extension){
		$time = microtime(true) * 10000;
		$client = Commerce::getCommerceID()->id;
		$client = (string)$client;		
		$name = "PARTNER_".$client.'_'.$prefixName.'_'.number_format($time, 0, '.', '').$extension;
		$path = $pathimg.$name;
		/*$path = public_path($pathimg.$name);*/
		list($type, $imgdata) = explode(';', $imgdata);
		list(, $imgdata)      = explode(',', $imgdata);
		$imgdata = base64_decode($imgdata);
		$img = Image::make($imgdata)->save($path);
		if($img){
			return $name;
		}
		return false;		
	}

	public static function nameMicroTime(){
		$time = microtime(true) * 10000;
		$client = Commerce::getCommerceID()->id;
		$client = (string)$client;
		return "PARTNER_".$client.'_PHOTO_'.number_format($time, 0, '.', '');
	}

	public static function getExtensionMime($type){
		switch($type)
			{
			case 'image/gif'    : $extension = 'gif';   break;
			case 'image/png'    : $extension = 'png';   break;
			case 'image/jpeg'   : $extension = 'jpeg';   break;
			default :
				$extension = 'jpg';
			break;
			}
		return $extension;
	}

	/*Reglas para validar que sea una imagen válida*/
	private static function validBase64($string){
		$decoded = base64_decode($string, true);
		// Check if there is no invalid character in string
		if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) return false;
		// Decode the string in strict mode and send the response
		 if(!base64_decode($string, true)) return false;
		// Encode and compare it to origional one
		if(base64_encode($decoded) != $string) return false;
		return true;
	}

}