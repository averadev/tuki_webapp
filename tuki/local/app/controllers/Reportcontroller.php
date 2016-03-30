<?php
use Carbon\Carbon;
class ReportController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Controlador para los reportes
	|--------------------------------------------------------------------------
	|
	*/
	function __construct(){
		//$this->beforeFilter('auth');
		//$this->beforeFilter('csrf',array('except'=>array('getIndex')));
	}
	public function getIndex(){
		if (Auth::check())
		{   
			$data = Commerce::getCommerceID();
			return View::make('reports.report')
			->with('commerce',$data);
		}
		return Redirect::to('/');
	}
	public function getReport(){
		if(Request::ajax()){
			$data = [
				'reportType' => trim(Input::get('reportType')),
				'startDate'  => trim(Input::get('startDate')),
				'endDate'    => trim(Input::get('endDate'))
			];
			$rules = [
				'reportType' =>	'required',
				'startDate'  => 'required',
				'endDate'    => 'required'
			];
			$validator = Validator::make($data,$rules);	
			if( $validator->passes()){
				$data  = (object)$data;
				if ($data->reportType == '01') { /*Reporte de actividades*/
					$redemption = new Redemption;
					$userCheckIn = new Log_user_checkin;
					$newUser  = new Log_new_user_commerce;
					$mainReport = $redemption->getDataByPeriod($data);
					$totalCheckIns = $userCheckIn->getTotalCheckInsByPeriod($data);
					$totalUsers = $newUser->getTotalUsersByPeriod($data);
					return Response::json(array('report' => 1,'totalUsers'=>$totalUsers,'totalCheckIns'=>$totalCheckIns,'dataRedemption' => $mainReport),200);								
				}elseif($data->reportType == '02'){ /* Reporte de afiliaciones y visitas*/
					$newUser  = new Log_new_user_commerce;
					$checkIn  = new Log_user_checkin;
					$dataComp 	 	= $newUser->compareOneMonth($data);
					$dataCompViews 	= $checkIn->compareOneMonth($data);
					$mainReport 	= $this->makeReport($data);

					return Response::json(array('report' => 2,'dataCommerce' => $mainReport,'dataComp' => $dataComp,'dataCompViews' => $dataCompViews),200);				
				}elseif ($data->reportType == '03') { /*Reporte de redenciones*/
					$redemption = new Redemption;
					$mainReport 		 = $redemption->getDataByPeriod($data);
					$dataCompRedemptions = $redemption->compareOneMonth($data);
					$unconfirRedemptions = $redemption->getUnconfirmedRedemptions($data);
					return Response::json(array('report' => 3,'dataRedemption' => $mainReport,'unconfirmedRedemptions'=>$unconfirRedemptions,'compRedemptions' => $dataCompRedemptions),200);		
				}
			}			
		}
	}

	public function makeReport($period){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $period->startDate)));
		$to   = date('Y-m-d',strtotime(str_replace('/', '-', $period->endDate)));
		
		$report = DB::select("select date_format((date),'%d-%m-%Y') as date, (SELECT count(*) FROM log_user_checkin WHERE date(log_user_checkin.dateAction) = dates.date AND idCommerce = '".Commerce::getCommerceID()->id."') as afiliations,
				(SELECT count(*) FROM log_new_user_commerce WHERE date(log_new_user_commerce.dateAction) = dates.date AND idCommerce = '".Commerce::getCommerceID()->id."') AS views
				FROM dates WHERE date BETWEEN '".$from ."' AND '".$to."' ORDER BY date ");
		return $report;
	}

	public function getMakeExcel(){
		var_dump(Input::all());
			$data = [
				'reportType' => trim(Input::get('reportType')),
				'startDate'  => trim(Input::get('startDate')),
				'endDate'    => trim(Input::get('endDate'))
			];
			$rules = [
				'reportType' =>	'required',
				'startDate'  => 'required',
				'endDate'    => 'required'
			];
			$validator = Validator::make($data,$rules);	
			if( $validator->passes()){
				$data  = (object)$data;
					Excel::create('Filename', function($excel) {
					
					    // Set the title
					    $excel->setTitle('Our new awesome title');
					
					    // Chain the setters
					    $excel->setCreator('Maatwebsite')
					          ->setCompany('Maatwebsite');
					
					    // Call them separately
					    $excel->setDescription('A demonstration to change the file properties');
					
					})->download('xls');
			}		
	}

	private function combineReport($newUserReport,$ReportCheckIn,$period){
		//$from = date('Y-m-d',strtotime(str_replace('/', '-', $period->startDate)));
		//$to   = date('Y-m-d',strtotime(str_replace('/', '-', $period->endDate)));
		//$from = Carbon::parse($from);
		//$to   = Carbon::parse($to);
		$data = array();
		//$interval = DateInterval::createFromDateString('1 day');
		//$period = new DatePeriod($from, $interval, $to);
		$equaldate = false;

		
			foreach ($newUserReport as $new_user) {
				foreach ($ReportCheckIn as $check_in) {
					if($check_in->date == $new_user->date){
						$report = new stdClass();
						$report->date			= $new_user->date;
						$report->afiliations	= $new_user->afiliations;
						$report->views			= $check_in->views;
						array_push($data, $report);
					}
				}			
				
				//if( $dt->toDateString() == $new_user->date  ){
				//	$report = new stdClass();
				//	$report->dateafiliation = $dt->toDateString();
				//	$report->afiliation = $new_user->afiliations;
				//	array_push($data, $report);	
				//}
			}

			return $data;

			//foreach ($ReportCheckIn as $key => $Checkin) {
			//	if( $dt->toDateString() == $Checkin->date ){	
			//		$report = new stdClass();
			//		$report->dateview = $dt->toDateString();
			//		$report->view = $Checkin->views;
			//		array_push($data, $report);		
			//	}
			//return  $data;
		}
}
