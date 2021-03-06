<?php
/**
* 	Modelo para los canjes/recompensas
*/
use Carbon\Carbon;
class Redemption extends Eloquent
{

	protected $table = "redemption";
	protected $SoftDelete = false;

	public static function getDataByMonthRedemption($month){
		$count=0;
		$items = array();
		for ($i=1; $i <=30 ; $i+=5) {
			$day = $i;
			$end = 4;
			if($i>25){
				$end = 5;
			}
			$data = self::select('dateRedemption')
			->whereIn('idBranch',Commerce::getBranchLoggedIn())
			->whereBetween('dateRedemption',array(date("Y").'-'.$month.'-'.$day,date("Y").'-'.$month.'-'.($day+$end).' 23:59:59'))
			->count();
			 $items[$count++] = $data;
		}
		return $items;
	}

	public function getDataByPeriod($data){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate)));
		$from = Carbon::parse($from);
		$to   = Carbon::parse($to);

		$dailydata = $this->select(DB::raw('rwrd.name,count(*) as redemptions'))
		->join('reward as rwrd','rwrd.id','=','idReward')
		->whereIn('redemption.idBranch',Commerce::getBranchLoggedIn())
		->where('redemption.status','!=','3')
		->whereBetween(DB::raw('DATE(dateRedemption)'), array($from,$to))
		->groupBy('idReward')
		->get();
		return $dailydata;
	}

	public function getUnconfirmedRedemptions($data){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate)));
		$from = Carbon::parse($from);
		$to   = Carbon::parse($to);
		$dailydata = $this->select(DB::raw('rwrd.name,count(*) as redemptions'))
		->join('reward as rwrd','rwrd.id','=','idReward')
		->whereIn('redemption.idBranch',Commerce::getBranchLoggedIn())
		->where('redemption.status','=','1')
		->whereBetween(DB::raw('DATE(dateRedemption)'), array($from,$to))
		->groupBy('idReward')
		->get();
		return $dailydata;
	}
	/*Dashboard*/
	public static function getMonthPeriod($month){
		$from = date('Y-'.$month.'-01');
		$from = Carbon::parse($from);
		$to = $from->copy()->lastOfMonth()->format('Y-m-d');
		$dailyData = self::select('idUser')
		->whereBetween(DB::raw('DATE(dateRedemption)'), array($from,$to))
		->where('redemption.status','!=','3')
		->whereIn('redemption.idBranch',Commerce::getBranchLoggedIn())
		->get()
		->count();
	  	return $dailyData;
	}

	/*Regresa total de las redenciones dentro de un mes seleccionado*/
	public static function getLastMonthPeriod($month){
		$first = date('Y-'.$month.'-01');
		$first = Carbon::parse($first);
		$from = $first->copy()->subMonth();
		$to = $from->copy()->lastOfMonth();
		$dailyData = self::select('idUser')
		->whereBetween(DB::raw('DATE(dateRedemption)'), array($from,$to))
		->where('redemption.status','!=','3')
		->whereIn('redemption.idBranch',Commerce::getBranchLoggedIn())
		->get()
		->count();
	  	return $dailyData;	
	}

	/*Obtiene las redenciones de un mes relativo seleccionado*/
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
		->whereBetween(DB::raw('DATE(dateRedemption)'), array($from,$to))
		->where('redemption.status','!=','3')
		->whereIn('redemption.idBranch',Commerce::getBranchLoggedIn())
		->get()
		->count();
	  	return $dailyData;		
	}	
	/*Dashboard fin*/
	public function compareOneMonth($data){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate)));
		if($from != $to){
			$from 	   = Carbon::parse($from);
			$to 	   = Carbon::parse($to);
			$totalDays = $from->diffInDays($to);
			$months    = ceil($totalDays/30);
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
		$dailyData = $this->select('dateRedemption as date', DB::raw('count(*) as redemptions'))
		->whereBetween(DB::raw('DATE(redemption.dateRedemption)'), array($fromComp,$toComp))
		->join('reward as rwrd','rwrd.id','=','idReward')	
		->whereIn('redemption.idBranch',Commerce::getBranchLoggedIn())
		->where('redemption.status','!=','3')		
		->orderBy('redemption.dateRedemption','ASC')
		->get();
		$dailyData[0]->startPeriod = $fromComp;
		$dailyData[0]->endPeriod   = $toComp;
		return $dailyData[0];
	}

	
} // END MODEL