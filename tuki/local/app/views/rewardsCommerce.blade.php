<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="../css/test.css">
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
	<link media="all" type="text/css" rel="stylesheet" href="../vendor/css/foundation.min.css">
	<link rel="stylesheet" href="../vendor/plugins/font-awesome/css/font-awesome.css">
	<meta charset="UTF-8">
	<script src="../vendor/js/foundation/jquery.min.js"></script>

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
		padding-bottom: 16px;
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
		<div class=" small-12 medium-4 large-4 columns logoPadding">
			<div class="small-12 medium-12 large-12 columns logoContenedor infoColor border ">
				<div class="centerLogo">
					<img class="imgCenter" src="../api/assets/img/api/commerce/{{$commerce->image }}" alt="">		
				</div>
			</div>			
		</div>

		<div class=" small-12 medium-8 large-8 columns ">
			<!-- Informacion del comercio -->
				<div class="small-12 medium-12 large-12 infColor infoPadding">
					<div  class="tamInfo border">
						<div class="row paddingTop20 paddingLeft20 tamRowInfoN">
							<!-- Nombre del comercio-->
							<div class="small-12 medium-12 large-12 columns">
								<p class="infoSize"><span class="commerceName">{{$commerce->name}}</span></p>		
							</div>							
						</div>
						<div class="row paddingLeft20 tamRowInfoD">
							<!-- Dirección del comercio-->
							<div class="small-7 medium-7 large-7 columns">
								<p class="infoSize"><i class="fa fa-map-marker fa-lg paddingRightIcon"aria-hidden="true"></i><span id="branchAddress" class="branchInformation branchInformationAddress">{{$branchs[0]->address}}</span></p>							
							</div>
							<!-- Telefono del comercio-->
							<div class="small-5 medium-5 large-5 columns">
								<p class="infoSize"><i class="fa fa-phone fa-lg paddingRightIcon" aria-hidden="true"></i><span id="branchPhone" class="colorBranchPhone branchInformation">{{$branchs[0]->phone}}</span></p>								
							</div>
						</div>
					</div>
				</div>

				<!-- Mapa de ubicacion del comercio -->
				<div class=" small-12 medium-12 large-12 infColor infoPaddingMap">
					<div class="tamInfo border">
						<div id="map"></div>
					</div>
				</div>
		</div>
	</div>

	<div class="row small-up-1 medium-up-2 large-up-3  min-W">
		<!-- Rewards del comercio-->
		@foreach($rewards AS $rewards)
		<div class="small-12 medium-4 large-4 columns inlineReward">
			<div class="rewardsPadding">
				<div class="border">
					<div class="row">
						<div class="small-12 medium-12 large-12 columns">
							<div class="bottonBorderImageReward">
								<img src="../api/assets/img/api/rewards/{{$rewards->image }}" alt="">
							</div>
						</div>
					</div>
					<div class="row" style="max-height:99px;">
						<div class="exD small-8 medium-8 large-8 columns" style="padding-right:0px;">
							<div class="divInfoRew">
								<p class="infoRewTxt"><b>{{$rewards->name}}</b></p>
								<p><i>{{substr($rewards->description,0,20)}}...</i></p>
							</div>
						</div>

						<div class="exP small-4 medium-4 large-4 columns" style="padding-left: 0px;">
							<div class ="small-12 medium-12 large-12 columns divPuntos">
								<div class="small-12 medium-12 large-12 columns txtPoints" style="margin-top: 10px; padding:0; text-align: center;">
									<div>
										<p class="ptsMargin"><span class="puntos puntosSize bold-text">{{$rewards->points}}</span></p>
										<p class="ptsMargin"><span class="puntos ptsFont">PUNTOS</span></p>
									</div>
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
		<div class="small-12 medium-12 large-12 columns">
			<a id="btnColor"class="large expanded button border" href="javascript:history.back(1)">REGRESAR AL SITIO</a>
		</div>
	</div>

	<div class="row min-W">
		<div class="small-12 medium-12 large-12 columns">
			<p class="text-center">Para mayor información sobre el programa de lealtad <b>TUKI</b> visita:</p>
			<a href="http://tukicard.com/"><p class="text-center linkTukiStyle"><b>www.tukicard.com</b></p></a>
		</div>
	</div>

	
	<script type="text/javascript">
		function initMap() {
			var myLatlng = {lat: {{$branchs[0]->lat}}, lng:{{$branchs[0]->long}}}; //Ubicación primer comercio por defecto
		  	var map = new google.maps.Map(document.getElementById('map'), {
		    	center: myLatlng,
		    	zoom: 12
		  	});
		  	var infoWindow;
		  	var pos, posB;
		  	//Marcadores
		  	@foreach($branchs AS $Branchs)
		  	
		  	var marker = new google.maps.Marker({
			    position: {lat: {{$Branchs->lat}}, lng:{{$Branchs->long}}},
			    map: map,
			    title:'{{$Branchs->name}}'
		  	});

		  	marker.addListener('click', function() {
		  		infoWindow.open(map,this);
		  		infoWindow.setContent('{{$Branchs->name}}');
		  		infoWindow.setPosition({lat: {{$Branchs->lat}}, lng:{{$Branchs->long}}});
		  		map.setCenter({lat: {{$Branchs->lat}}, lng:{{$Branchs->long}}})
			    document.getElementById('branchPhone').innerHTML = '{{$Branchs->phone}}';
  				document.getElementById('branchAddress').innerHTML = '{{$Branchs->address}}';
			});

			@endforeach		  
			//fin Marcadores
			// Geolocation.
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					infoWindow = new google.maps.InfoWindow({map});			
			      	pos = {
			        lat: position.coords.latitude,
			        lng: position.coords.longitude
			      };
			      infoWindow.close();
			      map.setCenter(pos);
			    }, function() {
			      handleLocationError(true, infoWindow, map.getCenter());
			      
			    });
			  } else {
			    // Browser doesn't support Geolocation
			    handleLocationError(false, infoWindow, map.getCenter());
			  }	
			   
		}
		function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		  infoWindow.setPosition(pos);
		  infoWindow.setContent(browserHasGeolocation ?
		                        'Error: El servicio de Geolocalización falló.' :
		                        'Error: Tu navegador no soporta Geolocalización');
		}
    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3ImDzGxDJa82HNYzPeKbIoAMu1JnPz_M&callback=initMap">
    </script>
</body>
</html>