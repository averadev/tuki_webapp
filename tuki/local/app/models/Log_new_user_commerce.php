<?php
/**
* 
	MODELO PARA NUEVOS USUARIOS
*/
use Carbon\Carbon;
class Log_new_user_commerce extends Eloquent
{

	protected $table = "log_new_user_commerce";
	protected $SoftDelete = false;
	
	public static function getDataByMonthNewUser($month){
		$month = (string)$month;
		$count=0;
		$items = array();
		for ($i=1; $i <=30 ; $i+=5) {
			$day = $i;
			$end = 4;
			if($i>25){
				$end = 5;
			}
			$data = self::select('dateAction')
			->where('idCommerce','=',Commerce::getCommerceID()->id)
			->whereBetween('dateAction',array(date("Y").'-'.$month.'-'.$day,date("Y").'-'.$month.'-'.($day+$end).' 23:59:59'))
			->count();
			 $items[$count++] = $data;
		}
		return $items;
	}
	/*Obtiene un arreglo con el numero de total de afiliados por cada dia en un rango de fechas*/
	public function getNewUserReportByPeriod($data){  
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate)));
		$from = Carbon::parse($from);
		$to   = Carbon::parse($to);
		$check =  Carbon::parse($from)->format('d-m-Y H:i:s');
		$dailyData = $this->select(DB::raw("date_format((dateAction),'%d-%m-%Y') as date"), DB::raw('count(*) as afiliations'))
		->whereBetween(DB::raw('DATE(dateAction)'), array($from,$to))
		->where('idCommerce','=',Commerce::getCommerceID()->id)
		->groupBy('date')
		->orderBy('date','ASC')
		->get();
	  	return $dailyData;
	}

	public function getNewUserReportByPeriodTwo($data){  
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate)));
		$from = Carbon::parse($from);
		$to   = Carbon::parse($to);
		$check =  Carbon::parse($from)->format('d-m-Y H:i:s');
		$dailyData = $this->select(DB::raw("date_format((dateAction),'%d-%m-%Y') as date"), DB::raw('count(*) as afiliations'))
		->whereBetween(DB::raw('DATE(dateAction)'), array($from,$to))
		->where('idCommerce','=',Commerce::getCommerceID()->id)
		->groupBy('dateAction')
		->orderBy('dateAction','ASC')
		->get();
	  	return $dailyData;
	}

	public static function getMonthPeriod($month){
		$from = date('Y-'.$month.'-01');
		$from = Carbon::parse($from);
		$to = $from->copy()->lastOfMonth()->format('Y-m-d');
		$dailyData = self::select('idUser')
		->whereBetween(DB::raw('DATE(dateAction)'), array($from,$to))
		->where('idCommerce','=',Commerce::getCommerceID()->id)
		->get()
		->count();
	  	return $dailyData;
	}

	public static function getLastMonthPeriod($month){
		$first = date('Y-'.$month.'-01');
		$first = Carbon::parse($first);
		$from = $first->copy()->subMonth();
		$to = $from->copy()->lastOfMonth();
		$dailyData = self::select('idUser')
		->whereBetween(DB::raw('DATE(dateAction)'), array($from,$to))
		->where('idCommerce','=',Commerce::getCommerceID()->id)
		->get()
		->count();
	  	return $dailyData;	
	}

	public static function getLasRelativePeriodMonth($month){
		$first = date('Y-'.$month.'-01');
		$first = Carbon::parse($first);
		$from = $first->copy()->subMonth();
		$currentDay = Carbon::now()->format('d');
		$currentMonth = intval(Carbon::now()->format('m'));
		$monthSelected = intval($month);
		$to = $from->copy()->lastOfMonth();
		if($currentMonth == $monthSelected){
			$to = $to->format('Y-m-'.$currentDay.'');
		}
		$dailyData = self::select('idUser')
		->whereBetween(DB::raw('DATE(dateAction)'), array($from,$to))
		->where('idCommerce','=',Commerce::getCommerceID()->id)
		->get()
		->count();
	  	return $dailyData;		
	}

	public function compareOneMonth($data){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate)));
		if($from != $to){
			$from 	   = Carbon::parse($from);
			$to 	   = Carbon::parse($to);
			$totalDays = $from->diffInDays($to);
			$months = ceil($totalDays/30);
			$fromComp  = $from->copy()->subMonths($months);
			$toComp    = $fromComp->copy()->addDays($totalDays);
			if($toComp->gte($from)){
				$toComp = $from->copy()->subDays(1);
			}
		}else{
			$from = carbon::parse($from);
			$fromComp  = $from->copy()->subMonth();
			$toComp = $fromComp;
		}
		$dailyData = $this->select('dateAction as date', DB::raw('count(*) as afiliations'))
		->whereBetween(DB::raw('DATE(dateAction)'), array($fromComp,$toComp))
		->where('idCommerce','=',Commerce::getCommerceID()->id)
		->orderBy('dateAction','ASC')
		->get();

		$dailyData[0]->startPeriod = $fromComp;
		$dailyData[0]->endPeriod   = $toComp;
		return $dailyData[0];
	}


	/*Obtiene el numero total de nuevos usuarios en un periodo seleccionado, ex 100 usuarios nuevos*/
	public function getTotalUsersByPeriod($data){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = (date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate))));
		$dailyData = self::select('idUser')
		->whereBetween(DB::raw('DATE(dateAction)'), array($from,$to))
		->where('idCommerce','=',Commerce::getCommerceID()->id)
		->get()
		->count();
	  	return $dailyData;	
	}




	
} // END MODEL