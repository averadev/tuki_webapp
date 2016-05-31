<?php
use Carbon\Carbon;
class ReportController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Controlador para el modulo de reportes
	| Code By CarlosKF - GeekBucket -
	|--------------------------------------------------------------------------
	|
	*/
	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('csrf',array('except'=>array('getIndex','getMakeExcel','getReport')));
	}
	public function getIndex(){
			$data = Commerce::getCommerceID();
			return View::make('reports.report')
			->with('commerce',$data);
	}
	public function getReport(){
		if(Request::ajax()){
			$data = [
				'reportType' => trim(Input::get('reportType')),
				'startDate'  => trim(Input::get('startDate')),
				'endDate'    => trim(Input::get('endDate'))
			];
			$rules = [
				'reportType' =>	'required|min:1|max:10|size:2',
				'startDate'  => 'required|date_format:"d/m/Y"',
				'endDate'    => 'required|date_format:"d/m/Y"'
			];
			$validator = Validator::make($data,$rules);	
			if( $validator->passes()){
				$data  = (object)$data;
				if ($data->reportType == '01') { /*Reporte de actividades*/
					$redemption 	= new Redemption;
					$userCheckIn 	= new Log_user_checkin;
					$newUser  		= new Log_new_user_commerce;
					$mainReport 	= $redemption->getDataByPeriod($data);
					$totalCheckIns 	= $userCheckIn->getTotalCheckInsByPeriod($data);
					$totalUsers 	= $newUser->getTotalUsersByPeriod($data);
					return Response::json(array('report' => 1,'totalUsers'=>$totalUsers,'totalCheckIns'=>$totalCheckIns,'dataRedemption' => $mainReport),200);								
				}elseif($data->reportType == '02'){ /* Reporte de afiliaciones y visitas*/
					$newUser  		= new Log_new_user_commerce;
					$checkIn  		= new Log_user_checkin;
					$dataComp 	 	= $newUser->compareOneMonth($data);
					$dataCompViews 	= $checkIn->compareOneMonth($data);
					//$mainReport 	= $this->makeReport($data);
					$totalVisitsByPeriod = $checkIn->getCheckInReportByPeriod($data); /*Numero total visitas en el periodo*/
					$totalUsersByPeriod	 = $newUser->getNewUserReportByPeriod($data);	  /*Numero total usuarios registrados en el periodo */

					$totalNewUsersAndVisits = $this->combineReport($totalUsersByPeriod->toArray(),$totalVisitsByPeriod->toArray(),$data); /*Combina los reportes de visitas y nuevos usuarios*/

					return Response::json(array('report' => 2,'dataCommerce' => $totalNewUsersAndVisits,'dataComp' => $dataComp,'dataCompViews' => $dataCompViews),200);				
				}elseif ($data->reportType == '03') { /*Reporte de redenciones*/
					$redemption 		= new Redemption;
					$mainReport 		 = $redemption->getDataByPeriod($data);
					$dataCompRedemptions = $redemption->compareOneMonth($data);
					$unconfirRedemptions = $redemption->getUnconfirmedRedemptions($data);
					return Response::json(array('report' => 3,'dataRedemption' => $mainReport,'unconfirmedRedemptions'=>$unconfirRedemptions,'compRedemptions' => $dataCompRedemptions),200);		
				}
			}			
		}
	}

	private function makeReport($period){
		$from = date('Y-m-d',strtotime(str_replace('/', '-', $period->startDate)));
		$to   = (date('Y-m-d',strtotime(str_replace('/', '-', $period->endDate))));
		
		$report = DB::select("select date_format((date),'%d-%m-%Y') as date, (SELECT count(*) FROM log_user_checkin WHERE date(log_user_checkin.dateAction) = dates.date AND idCommerce = '".Commerce::getCommerceID()->id."') as views,
				(SELECT count(*) FROM log_new_user_commerce WHERE date(log_new_user_commerce.dateAction) = dates.date AND idCommerce = '".Commerce::getCommerceID()->id."') AS afiliations
				FROM dates WHERE date BETWEEN '".$from ."' AND '".$to."' ORDER BY date ");
		return $report;
	}

	/*Exporta los reportes en Excel*/
	public function getMakeExcel(){
		$data = [
			'reportType' => trim(Input::get('reportType')),
			'startDate'  => trim(Input::get('startDate')),
			'endDate'    => trim(Input::get('endDate'))
		];
		$rules = [
			'reportType' =>	'required|min:1|max:10|size:2',
			'startDate'  => 'required|date_format:"d/m/Y"',
			'endDate'    => 'required|date_format:"d/m/Y"',
		];
		$validator = Validator::make($data,$rules);	
			$data  = (object)$data;
		if( $validator->passes()){
			if ($data->reportType == '01') { /*Reporte de actividades*/
				$this->makeActivitiesReport($data);
			}
			if ($data->reportType == '02'){ /*Reporte de afiliaciones y visitas*/
				$this->makeCheckInAndNewUsersReport($data);
			}
			if($data->reportType == '03'){ /*Reporte de redenciones*/
				$this->makeRedemptionsReport($data);
			}
		}
	}

	/*Combina el reporte de afiliaciones con el de visitas*/
	private function combineReport($newUserReport,$ReportCheckIn,$period){
		$data = array_merge($newUserReport,$ReportCheckIn);
		$tmp = [];			
		foreach ($data as $val) {
			$tmp[$val['date']] = array_merge(
				isset($tmp[$val['date']]) ? $tmp[$val['date']] : [],
				$val
			);
		}
		$result = array_values($tmp);
		foreach ($result as $key => $value) {
			if (!(array_key_exists("afiliations",$value)))
			{
				$temp = $result[$key]["views"];
				unset($result[$key]["views"]);
				$result[$key]["afiliations"] = 0;
				$result[$key]["views"] = $temp;
				
			}
			if (!(array_key_exists("views",$value)))
			{
				$result[$key]["views"] = 0;
			}
		}
		function sortFunction( $a, $b ) {
			return strtotime($a["date"]) - strtotime($b["date"]);
		}
		usort($result, "sortFunction");
		return  $result;

	}
	
	/*METODOS PARA GENERAR LOS REPORTES EN EXCEL*/

	/*BEGIN REPORTE DE ACTIVIDADES*/

	private function makeActivitiesReport($data){
		$startSelectedPeriod = $this->makeDateWithMonthNames($data->startDate);
		$endSelectedPeriod	 = $this->makeDateWithMonthNames($data->endDate);
		$selectedPeriod = $startSelectedPeriod.' - '.$endSelectedPeriod;
		$redemption 	= new Redemption;
		$userCheckIn 	= new Log_user_checkin;
		$newUser  		= new Log_new_user_commerce;
		$mainReport 	= $redemption->getDataByPeriod($data);
		$totalCheckIns 	= $userCheckIn->getTotalCheckInsByPeriod($data);
		$totalUsers 	= $newUser->getTotalUsersByPeriod($data);
		$arrayReport 	= $mainReport->toArray();
		$totalUsers 	= $newUser->getTotalUsersByPeriod($data);
		$totalRedemptions = 0;
		$totalRows = 0;
		foreach ($arrayReport as $key => $value) {
			$totalRedemptions = $totalRedemptions + $value['redemptions'];
			$totalRows++;
		}
		foreach ($arrayReport as $key => $value) {
			$arrayReport[$key]['porcent'] = $this->makePercent($value['redemptions'],$totalRedemptions);
		}
		$recVisit = $this->makePercent($totalRedemptions,$totalCheckIns);		
		if( !$totalUsers ){ /*Si el denominador es  0 */
			$avgVisitClient = 0; 
		}else{
			$avgVisitClient =ceil($totalCheckIns/$totalUsers);
		}
		Excel::create('reporte-actividades', function($excel) use($arrayReport,$totalRows,$totalRedemptions,$totalCheckIns,$totalUsers,$recVisit,$avgVisitClient,$selectedPeriod) {
			$excel->sheet('Actividades', function($sheet) use($arrayReport,$totalRows,$totalRedemptions,$totalCheckIns,$totalUsers,$recVisit,$avgVisitClient,$selectedPeriod) {  							
				$sheet->rows(array(
					array('Recompensa','Total','% Total')
				));
				$sheet->rows($arrayReport);
				$sheet->rows(array(
					array('Total',$totalRedemptions,'100%')
				));
				$TotalesRow = $totalRows+2;
				$sheet->cells('A'.$TotalesRow.':C'.$TotalesRow.'', function($cells) {			
					$cells->setBackground('#DCF4FF');
				});				
				$totalRows+=2;
				$sheet->cells('A1:C1', function($cells) {		
					$cells->setFont(array(
						'size' => '13',
						'bold' =>  true
					));				
				});
				$sheet->cells('B1:C1', function($cells) {
					$cells->setAlignment('right');			
					$cells->setFont(array(
						'size' => '13',
						'bold' =>  true
					));				
				});				
				$sheet->cells('C1:C'.($totalRows).'', function($cells) {/*Alinear columna %total a la derecha*/
					$cells->setAlignment('right');
				});
				 $sheet->rows(array(
					array(''),
					array(''),
					array('Periodo seleccionado: ',$selectedPeriod),
					array('Total de visitas registradas: ',$totalCheckIns),
					array('Total de nuevos clientes: ',$totalUsers),
					array('Recompensas por visitas: ',$recVisit),
					array('Visitas promedio por cliente: ',$avgVisitClient)
				));
				$startResults = $totalRows+3;
				$sheet->mergeCells('B'.$startResults.':D'.$startResults.'');  /*merge the cells to fit the date period*/
				/*Combinar columnas de resultados para que se ajuste al formato*/
				$labelRows = $totalRows+3;
				for ($i=0; $i <5 ; $i++) {
					$sheet->mergeCells('B'.($startResults+$i).':D'.($startResults+$i).''); 
				}
				$endResults   = $startResults+4;
				$percentLabel = $endResults-1;
				$sheet->cells('B'.$startResults.':D'.$startResults.'', function($cells) {			
					$cells->setAlignment('left');
				});				
				$sheet->cells('B'.$percentLabel.'', function($cells) {			
					$cells->setAlignment('left');
				});
				$sheet->cells('A'.$startResults.':A'.$endResults.'', function($cells) {			
					$cells->setFont(array(
						'size'       => '12',
						'bold'       =>  true
					));				
				});
			});
		})->export('xls');
	}

	/*BEGIN REPORTE DE AFILIACIONES Y VISITAS*/

	private function makeCheckInAndNewUsersReport($data){
		$startSelectedPeriod = $this->makeDateWithMonthNames($data->startDate);
		$endSelectedPeriod	 = $this->makeDateWithMonthNames($data->endDate);
		$selectedPeriod = $startSelectedPeriod.' - '.$endSelectedPeriod;		
		$newUser  		= new Log_new_user_commerce;
		$checkIn  		= new Log_user_checkin;
		$dataComp 	 	= $newUser->compareOneMonth($data);
		$dataCompViews 	= $checkIn->compareOneMonth($data);
		$startLastPeriod = $dataComp->startPeriod->format('d-m-Y');
		$startLastPeriod = $this->makeDateWithMonthNames($startLastPeriod);
		$endLastPeriod	 = $dataComp->endPeriod->format('d-m-Y');
		$endLastPeriod  = $this->makeDateWithMonthNames($endLastPeriod);
		$makeLastPeriod = $startLastPeriod.' - '.$endLastPeriod;

		$totalVisitsByPeriod = $checkIn->getCheckInReportByPeriod($data); /*Numero total visitas en el periodo*/
		$totalUsersByPeriod	 = $newUser->getNewUserReportByPeriod($data);	  /*Numero total usuarios registrados en el periodo */
		$mainReport = $this->combineReport($totalUsersByPeriod->toArray(),$totalVisitsByPeriod->toArray(),$data); /*Combina los reportes de visitas y nuevos usuarios*/
		//var_dump($mainReport);
		//$mainReport 	= $this->makeReport($data);
		$arrayReport = json_encode($mainReport);
		$arrayReport = json_decode($arrayReport, true);
		$countNewUsers = 0;
		$countCheckIns = 0;
		$totalRows = 0;
		$checkarray = null;
		foreach ($arrayReport as $key => $value) {
			$arrayReport[$key]['date'] = $this->makeDateWithMonthNames($value['date']);
			if($value['afiliations'] == 0  && $value['views']==0){ /*Elimino las fechas en donde no se registraron visitas y tampoco redenciones*/
				unset($arrayReport[$key]);
			}
			$countNewUsers = $countNewUsers + $value['afiliations'];
			$countCheckIns = $countCheckIns + $value['views']; /*checkins = visitas*/
		}
		foreach ($arrayReport as $key => $value) {
			$arrayReport[$key]['porcentAfi'] = $this->makePercent($value['afiliations'],$countNewUsers);
			$arrayReport[$key]['porcentViews'] = $this->makePercent($value['views'],$countCheckIns);			
			$totalRows++;
		}
		$crecAfi = $this->getPercentPeriod($countNewUsers,$dataComp->afiliations);
		$crecVis = $this->getPercentPeriod($countCheckIns,$dataCompViews->views);
		Excel::create('reporte-visitas-afiliaciones', function($excel) use($arrayReport,$totalRows,$countCheckIns,$countNewUsers,$selectedPeriod,$makeLastPeriod,$dataComp,$dataCompViews,$crecAfi,$crecVis) {
			$excel->sheet('Visitas-Afiliaciones', function($sheet) use($arrayReport,$totalRows,$countCheckIns,$countNewUsers,$selectedPeriod,$makeLastPeriod,$dataComp,$dataCompViews,$crecAfi,$crecVis) {
				$sheet->rows(array(
					array('Fecha','Afiliaciones','Visitas','% Afiliaciones','% Visitas')
				));
				$sheet->rows($arrayReport);
				$sheet->rows(array(
					array('Total',$countNewUsers,$countCheckIns,'100%','100%')
				));
				$sheet->cells('A'.($totalRows+2).':E'.($totalRows+2).'', function($cells) {			
					$cells->setBackground('#DCF4FF');
				});
				$sheet->cells('D1:E'.($totalRows+2).'', function($cells) {/*Alinear columna %total a la derecha*/
					$cells->setAlignment('right');
				});				
				$sheet->cells('A1:E1', function($cells) {			
					$cells->setFont(array(
						'size' => '13',
						'bold' =>  true
					));				
				});
				$sheet->cells('B1:E1', function($cells) {			
					$cells->setAlignment('right');
				});
				 $sheet->rows(array(
					array(''),
					array(''),
					array('Periodo seleccionado: ','','','',$selectedPeriod),
					array('Periodo anterior: ','','','',$makeLastPeriod),
					array('Afiliaciones en el periodo anterior: ','','','',$dataComp->afiliations),
					array('Visitas en el periodo anterior: ','','','',$dataCompViews->views),
					array('Crecimiento de afiliaciones vs periodo anterior: ','','','',$crecAfi), 					
					array('Crecimiento de visitas vs periodo anterior: ','','','',$crecVis)
				));
				$labelRows = $totalRows+5;
				for ($i=0; $i <6 ; $i++) {
					$sheet->mergeCells('A'.($labelRows+$i).':D'.($labelRows+$i).'');
				}
				for ($i=0; $i <6 ; $i++) {
					$sheet->mergeCells('E'.($labelRows+$i).':G'.($labelRows+$i).''); /*merge the cells to fit the date period*/
				}
				$sheet->cells('A'.($labelRows).':D'.($labelRows+5).'', function($cells) {			
					$cells->setFont(array(
						'size'       => '12',
						'bold'       =>  true
					));				
				});
			});
		})->export('xls');
	}

	/*BEGIN REPORTE DE REDENCIONES*/

	private function makeRedemptionsReport($data){
		$startSelectedPeriod = $this->makeDateWithMonthNames($data->startDate);
		$endSelectedPeriod	 = $this->makeDateWithMonthNames($data->endDate);
		$selectedPeriod = $startSelectedPeriod.' - '.$endSelectedPeriod;			
		$redemption 		 = new Redemption;
		$mainReport 		 = $redemption->getDataByPeriod($data);
		$dataCompRedemptions = $redemption->compareOneMonth($data);
		$unconfirRedemptions = $redemption->getUnconfirmedRedemptions($data);
		$arrayReport 		 = $mainReport->toArray();
		$unconfirRedemptions = $unconfirRedemptions->toArray();
		$totalRedemptions = 0;
		$totalUnconfirmed = 0;
		$totalRowsRedemptions = 0;
		$totalRowUnconfirmed = 0;
		foreach ($arrayReport as $key => $value) {
			$totalRedemptions = $totalRedemptions + $value['redemptions'];
			$totalRowsRedemptions++;
		}
		foreach ($unconfirRedemptions as $key => $value) {
			$totalUnconfirmed = $totalUnconfirmed + $value['redemptions'];
			$totalRowUnconfirmed++;
		}
		foreach ($arrayReport as $key => $value) {
			$arrayReport[$key]['percent'] = $this->makePercent($value['redemptions'],$totalRedemptions);
		}
		foreach ($unconfirRedemptions as $key => $value) {
			$unconfirRedemptions[$key]['percent'] = $this->makePercent($value['redemptions'],$totalUnconfirmed);
		}
		$totalRows = $totalRowsRedemptions + $totalRowUnconfirmed+5;
		$startLastPeriod = $dataCompRedemptions->startPeriod->format('d-m-Y');
		$startLastPeriod = $this->makeDateWithMonthNames($startLastPeriod);
		$endLastPeriod	 = $dataCompRedemptions->endPeriod->format('d-m-Y');
		$endLastPeriod  = $this->makeDateWithMonthNames($endLastPeriod);
		$makeLastPeriod = $startLastPeriod.' - '.$endLastPeriod;
		$crecimiento = $this->getPercentPeriod($totalRedemptions,$dataCompRedemptions->redemptions);


		Excel::create('reporte-Redenciones', function($excel) use($arrayReport,$unconfirRedemptions,$totalRedemptions,$totalUnconfirmed,$selectedPeriod,$makeLastPeriod,$dataCompRedemptions,$crecimiento,$totalRows,$totalRowsRedemptions) {
			$excel->sheet('Redenciones', function($sheet) use($arrayReport,$unconfirRedemptions,$totalRedemptions,$totalUnconfirmed,$selectedPeriod,$makeLastPeriod,$dataCompRedemptions,$crecimiento,$totalRows,$totalRowsRedemptions) {
				$sheet->rows(array(
					array('Recompensa','Total','% Total')
				));				
				$sheet->rows($arrayReport);
				$sheet->rows(array(
					array('Total',$totalRedemptions,'100%')
				));				
				$sheet->rows(array(
					array(''),  					
					array('Recompensa sin confirmar','Total','% Total')
				));
				$sheet->rows($unconfirRedemptions);
				$sheet->rows(array(
					array('Total',$totalUnconfirmed,'100%')
				));				
				$sheet->rows(array(
					array(''),
					array(''),
					array('Periodo seleccionado: ',$selectedPeriod),
					array('Periodo anterior: ',$makeLastPeriod),
					array('Redenciones periodo anterior: ',$dataCompRedemptions->redemptions),
					array('Crecimiento vs periodo anteior: ',$crecimiento)
				));

				/*Formato*/
				/*Asignar bold font a header de rendenciones*/
				$sheet->cells('A1:C1', function($cells) {			
					$cells->setFont(array(
						'size' => '13',
						'bold' =>  true
					));				
				});
				/*Asignar bold font a header de  rendenciones sin confirmar*/
				$sheet->cells('A'.($totalRowsRedemptions+4).':C'.($totalRowsRedemptions+4).'', function($cells) {			
					$cells->setFont(array(
						'size' => '13',
						'bold' =>  true
					));				
				});				
				/*Pintar fila total redenciones de color azul*/
				$sheet->cells('A'.($totalRowsRedemptions+2).':C'.($totalRowsRedemptions+2).'', function($cells) {			
					$cells->setBackground('#DCF4FF');
				});
				/*Pintar fila total unconfirmadas de color azul*/
				$sheet->cells('A'.($totalRows).':C'.($totalRows).'', function($cells) {			
					$cells->setBackground('#DCF4FF');
				});
				/*Alinear a la izquierda columnas de porcentaje*/
				$sheet->cells('C1:C'.($totalRows).'', function($cells) {			
					$cells->setAlignment('right');
				});
				/*Combinar columnas de resultados para que se ajuste al formato*/
				$labelRows = $totalRows+3;
				for ($i=0; $i <4 ; $i++) {
					$sheet->mergeCells('B'.($labelRows+$i).':D'.($labelRows+$i).'');
				}
				/*Poner fuente negrita a los labels de los resultados*/
				$sheet->cells('A'.($labelRows).':A'.($labelRows+3).'', function($cells) {			
					$cells->setFont(array(
						'size'       => '12',
						'bold'       =>  true
					));				
				});
			});
		})->export('xls');
	}

	private function makePercent($numerador,$denominador){ /*Metodo para calcular el porcentaje*/
		if( !$denominador ){ /*Si el denominador es  0 */
			return '0%';
		}
		$percent = round(($numerador/$denominador)*100);
		return $percent.' %';		
	}

	private function makeDateWithMonthNames($date){
		$day  = substr($date,0,2);
		$month = substr($date,3,4);
		$year   = substr($date,6,9);
		$month = (int)$month;
		$monthName = $this->getMonthNames($month);
		$date =  $day.'/'.$monthName.'/'.$year;
		return $date;
	}

	private function getPercentPeriod ($numerador,$denominador){
		if( !$denominador ){ /*Si el denominador es  0 */
			return 'N/A';
		}		
		$percent = ($numerador-$denominador);
		$percent = round(($percent/$denominador)*100);
		return $percent." %";
	}

	private function getMonthNames ($number){
		$monthNames = ["","Ene", "Feb", "Mar", "Abr", "May", "Jun",
		"Jul", "Ago", "Sep", "Oct", "Nov", "Dec"];
		return $monthNames[$number];	
	}

}
