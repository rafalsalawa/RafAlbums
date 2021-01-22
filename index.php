<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome - RafAlbums</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href="css/gallerystyle.css" rel="stylesheet">	
	<link href="css/switchslider.css" rel="stylesheet">	
	<link href="css/inputrange.css" rel="stylesheet">	
	<link href="css/changingbg.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/simplelightbox.css" rel="stylesheet" type="text/css">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" type="text/javascript"></script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-3.0.0.js"><\/script>')</script>	
		
	<script src="js/bootstrap.bundle.js"></script>			
	
	<script src="js/simple-lightbox.js" type="text/javascript" ></script>		
	<script src="js/thumbnail.js" type='text/javascript'></script>

	<!--
	<script src='js/parallaxbackground.js' type='text/javascript'></script> 	
	<script src='js/parallax.min.js' type='text/javascript'></script> 
	-->

  	<style>	
	</style>
</head>

<body>

<?php include 'header.php' ?>

<main role="main">

<section class="transparentbg ">
	<div class="container">
		<div class="albumdiv text-center">
		
			<div class="page-header">
				<h1>Hello<?php 
				if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {	
					echo ", welcome to RafAlbums!";			
				} else {
					echo ", <b>".htmlspecialchars($_SESSION["username"])."</b>!";
				}
				?>
				</h1>
			</div><br>	
			<div class="albumactionbtndiv">
				<div class="row btn-group btn-group-lg" style="width: 100%">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">        				
					<?php
					if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
					?>
						<a href="login.php" class="btn noborder widthfull btn-primary" style="border-radius: 0 !important;"><i class="fa fa-pencil" aria-hidden="true"></i> Sign in to Your Account</a>
					<?php
					} else {
					?>
						<a href="view_albums.php" class="btn noborder widthfull btn-primary"><i class="fa fa-picture-o" aria-hidden="true"></i> View Your albums</a>
						<a href="reset_password.php" class="btn noborder widthfull btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Reset Your password</a>
						<a href="logout.php" class="btn noborder widthfull btn-danger" ><i class="fa fa-power-off" aria-hidden="true"></i> Sign out of Your Account</a>
					<?php
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
	
<div class="bottomdiv">
</div>

</main>

<?php include 'footer.php' ?>

</body>
</html>