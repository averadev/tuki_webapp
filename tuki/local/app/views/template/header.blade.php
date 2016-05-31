<div class="white-color small-12 small-centered medium-12 medium-centered large-12 large-centered columns" style="padding: 0px;">
	<div class="row" >
		<div style="padding-left: 30px;" class=" small-8 small-centered medium-8 medium-centered large-9 large-centered columns columns">			
			<img   class="header-logo left" src="vendor/login/logo.png" alt="tuki" />			
		</div>
		<div  class="small-4 small-centered medium-4 medium-centered large-3 large-centered columns columns listblock">
			<ul class="menu">
				<li> 
					<a href="{{URL::to('/')}}" >
						<img id="logo_header" style="width: 50px; height: 50px; font-family: HelveticaNeuel;" class=""  src="api/assets/img/api/commerce/{{$commerce->image }}" alt="logo" />
					</a>  
				</li>
				<li>  
					<a href="{{URL::to('/logout')}}" >
						<img style="width: 50px; height: 50px;" class="" src="vendor/img/log_out.png" alt="logout" />
					</a>  
				</li>
			</ul>		
		</div>
	</div>
</div>