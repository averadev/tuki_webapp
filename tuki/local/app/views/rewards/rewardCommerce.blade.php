<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
	<link media="all" type="text/css" rel="stylesheet" href="../../vendor/css/foundation.min.css">
	<link rel="stylesheet" href="../../vendor/plugins/font-awesome/css/font-awesome.css">
	<script src="../../vendor/js/foundation/jquery.min.js"></script>
	<meta charset="UTF-8">
	<title>{{$reward->name}}</title>

   
	<style type="text/css">

	body{
		min-width: 300px;
	}
	*{
		font-family: 'Roboto', sans-serif;
	}
	.divRew{
		
		height: 350px;
	}
	.divComm{
		height: 150px;
	}
	.divExInfo{
		height: 120px;
	}
	.divInter{
		height: 100%;

	}
	.bkg{
		height: 100%;
		border: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		padding: 0px;
		border-radius: 5px;	
	}
	.divImgRew{
		width: 100%;
		height: 70%;
		background-image: url("../../api/assets/img/api/rewards/{{$reward->image }}");
		background-repeat: no-repeat;
		background-size: 100% 100%;
		background-position: center;
	}
	.imgRew{
		height: 100%;
	}
	.divInfoRew{
		width: 100%;
		height: 30%;
		border-top: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		padding: 10px;
	}
	.infoRewTxt{
		text-transform: uppercase;
		margin: 0;
	}
	.divImgComm{
		height: 100%;
		background-image: url("../../api/assets/img/api/commerce/{{$commerce->image }}");
		background-repeat: no-repeat;
		background-size: 80% 80%;
		background-position: center;
	}
	.imgComm{
		height: 100%;
	}
	.divCommInfo{
		padding-top: 5px;
		height: 100%;
	}
	.commName{
		text-transform: uppercase;
		margin-top: 10px;
		margin-bottom: 0px;
	}
	.infoComm{
		margin: 0px;
	}
	.divAux{
		width: 100%;
		height: 50%;
		margin: 0px;
		padding: 0px;

	}
	.divPts{
		width: 35%;
		height: 100%;
		background-color: black;
		border-top: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		border-left: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		text-align: center;
	}
	.puntos{
		color:white;
		margin: 0px;
	}
	.puntosSize{		
		font-size: 35px;
	}
	.ptsFont{
		font-size: 30px;
	}
	.ptsFont{
		font-family: 'Oswald', sans-serif;
	}
	.paddingRightIcon{
		padding-right: 10px;
	}
	.colorBranchPhone{
		color: rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
	}
	.paddingTop{
		padding-top: 20px;
	}
	.paddingTopComm{
		padding-top: 10px;
	}
	.linkTukiStyle{
		color: black;
		text-decoration: underline;
	}
	.bold-text{
		font-weight: bold;
	}
	/*Tamaño fuente de los puntos*/
	@media screen and (max-width: 410px) {
		@if(strlen($reward->description) > 100)
			.divRew{				
				height: 450px;
				}
			.divImgRew{
				height: 60%;
				}
			.divInfoRew{
				height: 40%;
			}
		@endif{}
		.puntosSize{		
			font-size: 30px;
		}
		.ptsFont{
			font-size: 25px;
		}
	}
	@media screen and (min-width: 410px) and (max-width: 450px){
		@if(strlen($reward->description) > 100)
			.divRew{				
				height: 430px;
				}
		@endif{}
		.puntosSize{		
			font-size: 30px;
		}
		.ptsFont{
			font-size: 25px;
		}
	}
	@media screen and (min-width: 450px) and (max-width: 550px){

		.divRew{			
		height: 430px;
		}
		.divImgRew{
			background-size: 80% 100%;
		}
		.divPts{
			width: 30%;
		}
		.divImgComm{
			background-size: 60% 80%;
		}

	}
	@media screen and (min-width: 550px) and (max-width: 750px) {
		
		.divRew{			
			height: 450px;
		}
		.divImgRew{
			background-size: 80% 100%;
		}
		.divPts{
			width: 30%;
		}
		.divImgComm{
			background-size: 60% 80%;
		}
		
	}
	@media screen and (min-width: 750px) and (max-width: 1024px){
		.divRew{			
			height: 460px;
		}
		.divImgRew{
			background-size: 85% 100%;
		}
		.divPts{
			width: 30%;
		}
		.divImgComm{
			background-size: 50% 80%;
		}
	}
	@media screen and (min-width: 1024px){
		.divRew{			
			height: 430px;
		}
		.divImgRew{
			background-size: 85% 100%;
		}
		.divPts{
			width: 25%;
		}
		.divComm{
			height: 120px;
		}
		.divImgComm{
			background-size: 50% 90%;
		}

	}
	

	</style>
</head>
<body>

	<div class="row divRew">
		<div class="small-12 medium-8 medium-offset-2 large-6 large-offset-3 columns divInter paddingTop" >
			<div class="small-12 medium-12 large-12 columns bkg ">
				<div class="divImgRew">					
					<div class="small-12 medium-12 large-12 columns" style="width: 100%; height: 60%; padding: 0px;"></div>
					<div class="small-12 medium-12 large-12 columns" style="width: 100%; height: 40%; padding: 0px; ">
						<div class="small-7 medium-7 large-7 columns"></div>
						<div class="small-5 medium-5 large-5 columns divPts">
							<p class="puntos puntosSize"><b>{{$reward->points}}</b></p>
							<p class="puntos ptsFont">PUNTOS</p>
						</div>
					</div>
				</div>
				<div class="divInfoRew">
					<p class="infoRewTxt"><b>{{$reward->name}}</b></p>
					<p><i>{{$reward->description}}</i></p>
				</div>
				
			</div>
		</div>
	</div>
	<div class="row divComm">
		<div class="small-12 medium-8 medium-offset-2 large-6 large-offset-3 columns divInter paddingTopComm">
			<div class="small-12 medium-12 large-12  columns bkg">
				<div class="small-4 medium-4 large-4 columns divImgComm">
				</div>
				<div class="small-8 medium-8 large-8 columns divCommInfo">
					<p class="commName"><span class="upTxt bold-text">{{$commerce->name}}</span></p>
					
					<p class="infoComm"><i class="fa fa-phone fa-lg paddingRightIcon" aria-hidden="true"></i><span class="colorBranchPhone"><b>{{$branch[0]->phone}}</b></span></p>

					<p class="infoComm"><i class="fa fa-map-marker fa-lg paddingRightIcon"aria-hidden="true"></i> <b>{{$branch[0]->address}}</b></p>

					
				</div>
			</div>
		</div>
	</div>
	<div class="row divExInfo">
		<div class="small-12 medium-8 medium-offset-2 large-6 large-offset-3 columns divInter paddingTop">
			<div class="small-12 medium-12 large-12 columns">
				<p class="text-center">Para mayor información sobre el programa de lealtad <b>TUKI</b> visita:</p>
				<a href="http://tukicard.com/"><p class="text-center linkTukiStyle"><b>www.tukicard.com</b></p></a>
			</div>
		</div>
	</div>

</body>

</html>