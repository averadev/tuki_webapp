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

}