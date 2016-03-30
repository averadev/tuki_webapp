<div class="white-color large-12 large-centered columns" style="padding: 0px;">
	<div class="row" >
		<div style="padding-left: 30px;" class="large-9 large-centered columns columns">			
			<img   class="header-logo left" src="vendor/login/logo.png" alt="tuki" />			
		</div>
		<div  class="large-3 large-centered columns columns listblock">
			<ul class="menu">
				<li> 
					<a href="{{URL::to('/')}}" >
						<img style="width: 50px; height: 43px; font-family: HelveticaNeuel;" class="" src="{{ 	$commerce->image }}" alt="logo" />
					</a>  
				</li>
				<li>  
					<a href="{{URL::to('/logout')}}" >
						<img class="" src="vendor/img/log_out.png" alt="logout" />
					</a>  
				</li>
			</ul>		
		</div>
	</div>
</div>