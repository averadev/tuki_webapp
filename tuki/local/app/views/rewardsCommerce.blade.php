<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="../css/ficha_style.css">
	<link href='https://fonts.googleapis.com/css?family=Roboto|Open+Sans:800|Oswald:300' rel='stylesheet' type='text/css'>
	<link media="all" type="text/css" rel="stylesheet" href="../vendor/css/foundation.min.css">
	<link rel="stylesheet" href="../vendor/plugins/font-awesome/css/font-awesome.css">
	<script src="../vendor/js/foundation/jquery.min.js"></script>

	<style type="text/css">
	.centerLogo{
		background-image: url("../api/assets/img/api/commerce/{{$commerce->image }}");
	}
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
		padding-bottom: 27px;
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
								<p class="infoSize commerceName ">{{$commerce->name}}</p>		
							</div>							
						</div>
						<div class="row paddingLeft20 tamRowInfoD">
							<!-- Dirección del comercio-->
							<div class="small-12 medium-7 large-7 columns">
								<p class="infoSize"><i class="fa fa-map-marker fa-lg paddingRightIcon"aria-hidden="true"></i><span id="branchAddress" class="branchInformation branchInformationAddress">{{$branchs[0]->address}}</span></p>							
							</div>
							<!-- Telefono del comercio-->
							<div class="small-12 medium-5 large-5 columns">
								<p class="infoSize"><i class="fa fa-phone fa-lg paddingRightIcon" aria-hidden="true"></i><span id="branchPhone" class="colorBranchPhone branchInformation">{{$branchs[0]->phone}}</span></p>								
							</div>
						</div>
					</div>
				</div>

				<!-- Mapa de ubicación comercios -->
				<div class=" small-12 medium-12 large-12 infColor infoPaddingMap">
					<div class="tamInfo border">
						<div id="map"></div>
					</div>
				</div>
		</div>
	</div>

	<div class="row small-up-1 medium-up-2 large-up-3  min-W">
		<!-- Rewards comercio-->
		@foreach($rewards AS $rewards)
		<div class="small-12 medium-4 large-4 columns inlineReward">
			<div class="rewardsPadding">
				<div class="border">
					<div class="row">
						<!--Img rew-->
						<div class="small-12 medium-12 large-12 columns">
							<div class="bottonBorderImageReward">
								<img src="../api/assets/img/api/rewards/{{$rewards->image }}" alt="">
							</div>
						</div>
					</div>
					<div class="row" style="height:130px;">
						<!--Descripción rew-->
						<div class="exD small-8 medium-8 large-8 columns" style="padding-right:0px;">
							<div class="divInfoRew">
								<p class="infoRewTxt">{{$rewards->name}}</p>
								<p><i><b>{{substr($rewards->description,0,20)}}...</b></i></p>
							</div>
						</div>
						<!--Puntos rew-->
						<div class="exP small-4 medium-4 large-4 columns" style="padding-left: 0px;">
							<div class ="small-12 medium-12 large-12 columns divPuntos">
								<div class="small-12 medium-12 large-12 columns txtPoints text-center">
									<div>
										<p class="ptsMargin puntos puntosSize" >{{$rewards->points}}</p>
										<p class="ptsMargin puntos ptsFont">PUNTOS</p>
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
		/*función mapa ubicaciones comercios (Google Maps - Javascript API)*/
		function initMap() {
			var myLatlng = {lat: {{$branchs[0]->lat}}, lng:{{$branchs[0]->long}}}; //Ubicación primer comercio por defecto
		  	var map = new google.maps.Map(document.getElementById('map'), {
		    	center: myLatlng,
		    	zoom: 12
		  	});
		  	var infoWindow = new google.maps.InfoWindow({map:map});;
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
			// Geolicalización
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {			
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
			    // Navegador no soporta geolocalización
			    handleLocationError(false, infoWindow, map.getCenter());
			  }	
			   
		}
		function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		  infoWindow.close();
		  infoWindow.setPosition(pos);
		  infoWindow.setContent(browserHasGeolocation ?
		                        'Error: El servicio de Geolocalización falló.' :
		                        'Error: Tu navegador no soporta Geolocalización');
		}
		//fin geolocalización
    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
    </script>
</body>
</html>