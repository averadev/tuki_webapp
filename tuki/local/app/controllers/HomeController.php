<?php

class HomeController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Controlador para la pagina Home / Dashboard
	|--------------------------------------------------------------------------
	|
	*/

	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('csrf',array('except'=>array('getIndex','getMakeCharts')));
	}	

	public function getIndex(){
			$id = Auth::id();
			$data = Commerce::find($id);
			$dataCommerce = new stdClass();
			$dataCommerce->id = $data->id;
			$dataCommerce->image = $data->image;
			$dataCommerce->name = $data->name;
			$now = new DateTime();
  			$month = $now->format('n');		
			$dataChart = json_encode(Log_new_user_commerce::getDataByMonth($data,'03'));					
			return View::make('welcome.home')
			->with('commerce',$dataCommerce)
			->with('chartcom',$dataChart)
			->with('month',$month);
	}

	public function getMakeCharts(){
		if(Request::ajax()){
			$data = [
				'commerce'	=> trim(Input::get('commerce')),
				'month'   	=> trim(Input::get('month')),
				'chartType' => trim(Input::get('chart'))
			];
			$rules = [
				'commerce' 	=> 'required',
				'month'   	=> 'required',
				'chartType' => 'required'
			];
			$validator = Validator::make($data,$rules);
			if( $validator->passes() ){
				$data = (object)$data;
				if($data->chartType == 1){
  					$report = new stdClass();
  					$report->totalCurrentMonthCheckIns = Log_new_user_commerce::getMonthPeriod($data->month);
  					$report->totalLastMonthCheckIns = Log_new_user_commerce::getLastMonthPeriod($data->month);
  					$report->totalLastMonthSamePeriod = Log_new_user_commerce::getLasRelativePeriodMonth($data->month);					
					$dataChart = Log_new_user_commerce::getDataByMonth($data->commerce,$data->month);
					return Response::json(array('success' => true,'dataPercents'=>$report,'data' => $dataChart,'chart'=>1,),200);
				}
				if($data->chartType == 2){
  					$report = new stdClass();
  					$report->totalCurrentMonthCheckIns = Log_user_checkin::getMonthPeriod($data->month);
  					$report->totalLastMonthCheckIns = Log_user_checkin::getLastMonthPeriod($data->month);
  					$report->totalLastMonthSamePeriod = Log_user_checkin::getLasRelativePeriodMonth($data->month);
					$dataChart = Log_user_checkin::getDataByMonth($data->commerce,$data->month);
					return Response::json(array('success' => true, 'dataPercents'=>$report, 'data' => $dataChart,'chart'=>2),200);
				}
				if($data->chartType == 3){
  					$report = new stdClass();
  					$report->totalCurrentMonthCheckIns = Redemption::getMonthPeriod($data->month);
  					$report->totalLastMonthCheckIns = Redemption::getLastMonthPeriod($data->month);
  					$report->totalLastMonthSamePeriod = Redemption::getLasRelativePeriodMonth($data->month);									
					$dataChart = Redemption::getDataByMonth($data->commerce,$data->month);
					return Response::json(array('success' => true,'dataPercents'=>$report,'data' => $dataChart,'chart'=>3),200);
				}
			}
		}
	}

	public function getLogout(){
		Auth::logout();
		return Redirect::to('/');
	}


}
