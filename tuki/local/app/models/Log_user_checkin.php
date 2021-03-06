<?php
/**
* 
	MODELO PARA VISITAS DE LOS USUARIOS
*/
use Carbon\Carbon;
class Log_user_checkin extends Eloquent
{
	protected $table = "log_user_checkin";
	protected $SoftDelete = false;

	public static function getDataByMonthUser_checkin($month){
		$count=0;
		$items = array();
		for ($i=1; $i <=30 ; $i+=5) {
			$day = $i;
			$end = 4;
			if($i>25){
				$end = 5;
			}
			$data = self::select('dateAction')
			->whereIn('idBranch',Commerce::getBranchLoggedIn())
			->whereBetween('dateAction',array(date("Y").'-'.$month.'-'.$day,date("Y").'-'.$month.'-'.($day+$end).' 23:59:59'))
			->count();
			 $items[$count++] = $data;
		}
		return $items;
	}

	/*Obtiene un arreglo con el numero de total de visitas por cada dia en un rango de fechas*/	
	public function getCheckInReportByPeriod ($data){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate)));
		$from = Carbon::parse($from);
		$to   = Carbon::parse($to);
		$check =  Carbon::parse($from)->format('d-m-Y H:i:s');
		$dailyData = $this->select(DB::raw("date_format((dateAction),'%d-%m-%Y') as date"), DB::raw('count(*) as views'))
		->whereBetween(DB::raw('DATE(dateAction)'), array($from,$to))
		->whereIn('idBranch',Commerce::getBranchLoggedIn())
		->groupBy('date')
		->orderBy('date','ASC')
		->get();
	  	return $dailyData;		
	}

	/*Obtiene el numero total de visitas en un periodo seleccionado, ex 100 visitas*/
	public function getTotalCheckInsByPeriod($data){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = (date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate))));
		$dailyData = self::select('idUser')
		->whereBetween(DB::raw('DATE(dateAction)'), array($from,$to))
		->whereIn('idBranch',Commerce::getBranchLoggedIn())
		->get()
		->count();
	  	return $dailyData;	
	}

	public static function getMonthPeriod($month){
		$from = date('Y-'.$month.'-01');
		$from = Carbon::parse($from);
		$to = $from->copy()->lastOfMonth()->format('Y-m-d');
		$dailyData = self::select('idUser')
		->whereBetween(DB::raw('DATE(dateAction)'), array($from,$to))
		->whereIn('idBranch',Commerce::getBranchLoggedIn())
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
		->whereIn('idBranch',Commerce::getBranchLoggedIn())
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
		->whereIn('idBranch',Commerce::getBranchLoggedIn())
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
			
			//$fromComp = $from->copy()->subDays($totalDays)->subMonth();
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
		$dailyData = $this->select('dateAction as date', DB::raw('count(*) as views'))
		->whereBetween(DB::raw('DATE(dateAction)'), array($fromComp,$toComp))
		->whereIn('idBranch',Commerce::getBranchLoggedIn())
		->orderBy('dateAction','ASC')
		->get();

		$dailyData[0]->startPeriod = $fromComp;
		$dailyData[0]->endPeriod   = $toComp;
		return $dailyData[0];

	}

} // END MODEL