<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Roboto|Open+Sans:800|Oswald:300' rel='stylesheet' type='text/css'> 
	<link media="all" type="text/css" rel="stylesheet" href="../../vendor/css/foundation.min.css">
	<link rel="stylesheet" href="../../css/ficha_rew_style.css">
	<link rel="stylesheet" href="../../vendor/plugins/font-awesome/css/font-awesome.css">
	<script src="../../vendor/js/foundation/jquery.min.js"></script>
	<script src="../../js/fichaRew.js"></script>	
	<title>{{$reward->name}}</title>

	<style type="text/css">
	.bkg{
		height: 100%;
		border: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		padding: 0px;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
	}
	.infoRewBorder{
		border-left: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		border-right: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		border-bottom: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		border-bottom-right-radius: 5px;
		border-bottom-left-radius: 5px;
	}
	.divImgComm{
		height: 100%;
		background-image: url("../../api/assets/img/api/commerce/{{$commerce->image }}");
		background-repeat: no-repeat;
		background-position: center;
	}
	.divPts{
		height: 100%;
		background-color: black;
		border-top: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		border-left: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		text-align: center;
	}
	.colorBranchPhone{
		color: rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
	}
	@media screen and (min-width: 640px){
		.divPts{
			border-left: none;
			border-right: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
			border-top-right-radius: 5px;
		}
	}
	</style>
</head>
<body>
	<div id="row" class="">

		<div id="divImgRew" class="row divRew">
			<div id="InterRew" class="small-12 medium-12 large-12 columns divInter paddingTop" >
				<div class="small-12 medium-12 large-12 columns bkg">
					<div class="divImgRew crop">
						<!-- Img rew -->
						<img id="imgRewSize" src="../../api/assets/img/api/rewards/{{$reward->image }}" alt="">
						<!-- Puntos rew -->					
						<div class="small-12 medium-12 large-12 columns aux1"></div>
						<div class="small-12 medium-12 large-12 columns auxPts">						
							<div id="pts" class="small-4 medium-4 large-4 small-push-8 columns divPts">
								<p class="puntos puntosSize">{{$reward->points}}</p>
								<p class="puntos ptsFont">PUNTOS</p>
							</div>
						</div>
					</div>				
				</div>
			</div>
		</div>
		
		<div id="secDiv">
			<!-- Información rew -->
			<div id="rewInfo" class="row">
				<div class="small-12 columns">
					<div id="rewBorder" class="divInfoRew infoRewBorder">
						<!-- Nombre rew -->
						<p class="infoRewTxt">{{$reward->name}}</p>
						<!-- Descripción rew -->
						<p class="infoDescRew"><i><b>{{$reward->description}}</b></i></p>
					</div>
				</div>
			</div>

			<div id="divComm" class="row divComm">
				<!-- Información comercio -->
				<div class="small-12 medium-12 large-12 columns divInter paddingTopComm">
					<div class="small-12 medium-12 large-12  columns bkg">
						<!-- Logo comercio -->
						<div class="small-4 medium-4 large-4 columns divImgComm"></div>
						<div class="small-8 medium-8 large-8 columns divCommInfo">
							<!-- Nombre -->
							<p class="commName"><span class="bold-text">{{$commerce->name}}</span></p>
							<!-- Telefono -->
							<p class="infoComm"><i class="fa fa-phone fa-lg paddingRightIcon" aria-hidden="true"></i><span class="colorBranchPhone"><b>{{$branch[0]->phone}}</b></span></p>
							<!-- Dirección -->
							<p class="infoComm"><i class="fa fa-map-marker fa-lg paddingRightIcon"aria-hidden="true"></i> <b>{{$branch[0]->address}}</b></p>					
						</div>
					</div>
				</div>
			</div>
			
			<div id="eX" class="row divExInfo">
				<!-- Información adicional Tuki -->
				<div id="exInfo" class="small-12 medium-8 medium-offset-2 large-6 large-offset-3 columns divInter paddingTop">
					<p class="exTextInfo text-center">Para mayor información sobre el programa de lealtad <b>TUKI</b> visita:</p>
					<a href="http://tukicard.com/"><p class="text-center linkTukiStyle"><b>www.tukicard.com</b></p></a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>