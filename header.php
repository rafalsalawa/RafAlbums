<?php


?>
<header>
	<div class="collapse headercontainer" id="navbarHeader">
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-md-8 py-2">
					<h4 class="text-white"><i class="fa fa-info-circle" aria-hidden="true"></i> Info</h4>
					<p class="text-muted">RafAlbums service provides a platform for storing graphic files in a convenient way for You. Take advantage of its possibilities and enjoy moments - captured and organized in photo albums.</p>
				</div>
				<div class="col-sm-4 col-md-4 py-2">
					<h4 class="text-white"><i class="fa fa-refresh" aria-hidden="true"></i> Contact us</h4>
					<ul class="list-unstyled">
						<li><a href="#" class="text-white"><i class="fa fa-facebook-square" aria-hidden="true"></i> Like on Facebook</a></li>
						<li><a href="#" class="text-white"><i class="fa fa-twitter-square" aria-hidden="true"></i> Followon Twitter</a></li>
						<li><a href="#" class="text-white"><i class="fa fa-envelope" aria-hidden="true"></i> Email us</a></li>						
					</ul>										
				</div>
			</div>
		</div>
	</div>

	<div class="headernavbar navbar navbar-dark shadow-sm">
		<div class="container d-flex justify-content-between">
			<div class="mr-auto p-2">
				<a href="index.php" class="navbar-brand d-flex align-items-center">
					<i class="fa fa-camera" aria-hidden="true"><span style="font-family: Arial, Helvetica, sans-serif;"<strong> RafAlbums</strong></i>
				</a>
			</div>
			<div class="p-2">
				<label class="switch">
					<input type="checkbox" id="accept" >
					<span class="slider" title="Changing background"></span>
				</label>
			</div>			
			<div class="p-2">	
				<div class="range-wrap" title="Shift speed">
					<div class="range-value" id="rangeV"></div>
					<input id="range" type="range" min="3" max="30" value="5" step="1">
				</div>
			</div>			
			<div class="p-2">
				<button id="navbarbtn" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
			</div>
			<?php 
		if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {					
		} else {?>
			<div class="p-2">
				<a href="logout.php" title="Log out" class="btn btn-danger" style="border-radius: 0 !important;"><i class="fa fa-power-off" aria-hidden="true"></i></a>
			</div>		
		<?php
		}
		?>
		</div>	
	</div>

</header>

<script src="js/changingbg.js" type='text/javascript'></script>