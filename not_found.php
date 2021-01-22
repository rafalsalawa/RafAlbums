<!DOCTYPE html>
<html lang="en">
<head>
	<title>RafAlbums</title>
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

<section class="transparentbg text-center">
	<div class="container">
		<div class="uploaddiv">
			<div class="uploaddivtitle">
				<h3>We have a problem</h3>
			</div>	
			<div class="uploaddivbody">
				<p>We couldn't find what You're looking for :(</p>
				<p>Sorry for inconvenience - we'll redirect You to main page in few seconds.</p><br>
				<p>Redirect to main page <a class="linktop" href="index.php" >now</a>.</p>
			</div>
		</div>			
	</div>
</section>

</main>

<?php include 'footer.php' ?>


<script>
$(document).ready(function(){
	setTimeout(function(){redirect()}, 5000);
	
	function redirect() {
		location.replace("index.php");
	}
});

	
</script>

</body>
</html>	