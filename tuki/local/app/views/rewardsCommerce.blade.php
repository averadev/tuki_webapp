<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="../css/ficha_style.css">
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<link media="all" type="text/css" rel="stylesheet" href="../vendor/css/foundation.min.css">
	<link rel="stylesheet" href="../vendor/plugins/font-awesome/css/font-awesome.css">
	<meta charset="UTF-8">
	<script src="../vendor/js/foundation/jquery.min.js"></script>
 	<script src="http://maps.google.com/maps/api/js?sensor=true&.js"></script>
 	<script src="https://rawgit.com/HPNeo/gmaps/master/gmaps.js"></script>
 	

	<title>TUKI: {{$commerce->name}}</title>

	<style>
	.border{
		border-style: solid;
		border-width: 4px;
		border-color: rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		border-radius: 5px;
	}
	.bottonBorderImageReward{
		border-bottom: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		text-align: center;
	}
	.divPuntos{
		border-top: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		border-left: 4px solid rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
		background-color: black;
		padding:0; 
		height:100%;
		margin-top: -20px;
		padding-bottom: 20px;
	}
	.colorBranchPhone{
		font-weight: bold;
		color: rgb({{$commerce->colorR}},{{$commerce->colorG}},{{$commerce->colorB}});
	}

	</style>
</head>
<body>	
	<div class="row min-W">
		<!-- Logotipo del comercio -->
		<div class=" small-12 medium-4 columns logoPadding">
			<div class="medium-12 columns logoContenedor infoColor border ">
				<div class="centerLogo">
					<img class="imgCenter" src="../api/assets/img/api/commerce/{{$commerce->image }}" alt="">		
				</div>
			</div>			
		</div>

		<div class=" small-12 medium-8 columns ">
			<!-- Informacion del comercio -->
				<div class="medium-12 infColor infoPadding">
					<div  class="tamInfo border">
						<div class="row paddingTop20 paddingLeft20 tamRowInfo">
							<!-- Nombre del comercio-->
							<div class="medium-6 columns">
								<p class="infoSize"><span class="commerceName">{{$commerce->name}}</span></p>		
								<!--<h3 class="commerceName">{{$commerce->name}}</h3>-->
							</div>
							<!-- Telefono del comercio-->
							<div class="medium-6 columns">
								<p class="infoSize"><i class="fa fa-phone paddingRightIcon" aria-hidden="true"></i><span id="branchPhone" class="colorBranchPhone">{{$branchs[0]->phone}}</span></p>								
							</div>
						</div>
						<div class="row paddingLeft20 tamRowInfo">
							<!-- Dirección del comercio-->
							<div class="medium-12 columns">
								<p class="infoSize"><i class="fa fa-map-marker paddingRightIcon"aria-hidden="true"></i><span id="branchAddress">{{$branchs[0]->address}}</span></p>							
							</div>
						</div>
					</div>
				</div>

				<!-- Mapa de ubicacion del comercio -->
				<div class=" medium-12 infColor infoPaddingMap">
					<div class="tamInfo border">
						<div id="map"></div>
					</div>
				</div>
		</div>
	</div>

	<div class="row medium-up-2 large-up-3  min-W">
		<!-- Rewards del comercio-->
		@foreach($rewards AS $rewards)
		<div class="small-12 medium-4 columns inlineReward">
			<div class="rewardsPadding">
				<div class="border">
					<div class="row">
						<div class="small-12 medium-12 columns">
							<div class="bottonBorderImageReward">
								<img src="../api/assets/img/api/rewards/{{$rewards->image }}" alt="">
							</div>
						</div>
					</div>
					<div class="row" style="max-height:99px;">
						<div class="small-8 medium-8 columns" style="padding-right:0;">
							<div class="medium-12 columns rewardDesc">
									<p><span class="bold-text" style="">{{$rewards->name}}</span></p>
							</div>
							<div class="medium-12 columns rewardDesc">
								<p>{{substr($rewards->description,0,20)}}...</p>
							</div>	
						</div>

						<div class="small-4 medium-4 columns">
							<div class ="medium-12 columns divPuntos">
								<div class="medium-12 columns txtPoints" style="padding:0; text-align: center;">
									<p><span class="puntos puntosSize">{{$rewards->points}}</span></p>
									<p><span class="puntos">PUNTOS</span></p>
								</div>
							</div>
							
						</div>
					</div>						
				</div>				
			</div>
		</div>
		@endforeach
	</div>
		
	<div class="row rowTopPaddingRegresar min-W">
		<div class="small-12 medium-12 columns">
			<a id="btnColor"class="large expanded button border" href="javascript:history.back(1)">REGRESAR AL SITIO</a>
		</div>
	</div>

	<div class="row min-W">
		<div class="medium-12 columns">
			<p class = "footerInfo">Para mayor información sobre el programa de lealtad <span class="bold-text">TUKI</span> visita:</p>
			<a href=""><p class="footerInfo linkTukiStyle">www.tukicard.com</p></a>
		</div>
	</div>

	<!-- Script ubicación sucursales-->
	<script>
	var map = new GMaps({
    	div: '#map',
    	zoom: 12,
    	lat: {{$branchs[0]->lat}},
    	lng: {{$branchs[0]->long}},
    	streetViewControl : false,	
	});

	@if(count($branchs) > 1){
		GMaps.geolocate({
		  success: function(position) {
		    map.setCenter(position.coords.latitude, position.coords.longitude);
		  },
		  error: function(error) {
		  },
		  not_supported: function() {
		    alert("Tu navegador no soporta geolocalización");
		  },
		  always: function() {
		  }
		});
	}
	@endif

	@foreach($branchs As $branchs) 
	map.addMarker({
		lat: {{$branchs->lat}},
  		lng: {{$branchs->long}},
  		title: '{{$branchs->name}}',
  		infoWindow:{
  			content:'{{$branchs->name}}'
  		},
  		click: function(e){
  			document.getElementById('branchPhone').innerHTML = '{{$branchs->phone}}';
  			document.getElementById('branchAddress').innerHTML = '{{$branchs->address}}';
  		}
	});
	@endforeach
	</script>
	<!-- Fin script ubicación sucursales -->
</body>
</html>