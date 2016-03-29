<?php
/**
* 
*/
use Carbon\Carbon;
class Redemption extends Eloquent
{

	protected $table = "redemption";
	protected $SoftDelete = false;

	public static function getDataByMonth($idCommerce,$month){
		$count=0;
		$items = array();
		for ($i=1; $i <=30 ; $i+=5) {
			$day = $i;
			$end = 4;
			if($i>25){
				$end = 5;
			}
			$data = self::select('dateRedemption')
			->where('idCommerce','=',$idCommerce)
			->whereBetween('dateRedemption',array(date("Y").'-'.$month.'-'.$day,date("Y").'-'.$month.'-'.($day+$end)))
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

		$dailydata = $this->select(DB::raw('count(*) as redemptions, redemption.status,rwrd.name,idReward'))
		->join('reward as rwrd','rwrd.id','=','idReward')
		->where('redemption.idCommerce','=',Commerce::getCommerceID()->id)
		->where('redemption.status','!=','3')
		->whereBetween('dateRedemption',[$from, $to])
		->groupBy('idReward')
		->get();
		return $dailydata;
	}

	public function getUnconfirmedRedemptions($data){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $data->startDate)));
		$to   = date('Y-m-d',strtotime(str_replace('/', '-', $data->endDate)));
		$from = Carbon::parse($from);
		$to   = Carbon::parse($to);

		$dailydata = $this->select(DB::raw('count(*) as redemptions, redemption.status,rwrd.name,idReward'))
		->join('reward as rwrd','rwrd.id','=','idReward')
		->where('redemption.idCommerce','=',Commerce::getCommerceID()->id)
		->where('redemption.status','=','1')
		->whereBetween('dateRedemption',[$from, $to])
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
		->whereBetween('dateRedemption',[$from, $to])
		->where('redemption.status','!=','3')
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
		->whereBetween('dateRedemption',[$from, $to])
		->where('redemption.status','!=','3')
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
		->whereBetween('dateRedemption',[$from, $to])
		->where('redemption.status','!=','3')
		->where('idCommerce','=',Commerce::getCommerceID()->id)
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
		$dailyData = $this->select('dateRedemption as date', DB::raw('count(*) as redemptions'))
		->whereBetween('redemption.dateRedemption',[$fromComp, $toComp])
		->join('reward as rwrd','rwrd.id','=','idReward')	
		->where('redemption.idCommerce','=',Commerce::getCommerceID()->id)
		->where('redemption.status','!=','3')		
		->orderBy('redemption.dateRedemption','ASC')
		->get();
		$dailyData[0]->startPeriod = $fromComp;
		$dailyData[0]->endPeriod   = $toComp;
		return $dailyData[0];
	}

	
} // END MODEL