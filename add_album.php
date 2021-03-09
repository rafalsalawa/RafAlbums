<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add album - RafAlbums</title>	

	<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
	<link rel="manifest" href="site.webmanifest">
	<link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

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

			<div class="uploaddivback" >
				<div class="row btn-group btn-group-lg" style="width: 100%">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
						<a href="view_albums.php" class="btn backbtn btn-secondary" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to all albums</a>
					</div>					
				</div>
			</div>
			<div class="uploaddivbody">
				<form id="addalbumform" name="addalbumform" method="post" method="post" >
					<div class="row btn-group btn-group-lg text-center" style="width: 100%">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 ">
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 ">							
								<label for="album_name"><h3>Create album:</h3></label><br>
								<input type="text" id="album_name" class="createalbuminput" name="album_name" placeholder="Your album name" required><br>
								<span id = "nameMsg" style="color: red;"> </span> <br>
						</div>
					</div>	
					<div class="row btn-group btn-group-lg text-center" style="width: 100%">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 ">
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 ">											
							<button type="button" id="butsave" name="save" class="btn uploadbtn btn-success "><i class="fa fa-upload" aria-hidden="true"></i> Create</button>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
							<button type="button" id="butreset" name="reset" class="btn resetbtn btn-warning " ><i class="fa fa-times" aria-hidden="true"></i> Reset</button>
						</div>					
					</div>		
				</form>
			</div>						
		</div>	
	</div>	
</section>

<div class="container">	
		<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
		</div>
		<div class="alert alert-danger alert-dismissible" id="error" style="display:none;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
		</div>		
	</div>
</main>

<script>
$(document).ready(function() {	

	$('#butsave').on('click', function() {		
		var album_name = $('#album_name').val();
		var namebull = name_validation(album_name);

		if(namebull) {
			$.ajax({
				url: "create_album.php",
				type: "POST",
				data: {
					type: 1,
					album_name: album_name,										
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){						
						$('#addalbumform').find('input:text').val('');
						//$("#success").show();
						//$('#success').html('Album created successfully!'); 
						alert('Album created successfully!');						
					}
					else if(dataResult.statusCode==201){
						//$("#error").show();
						//$('#error').html('Album already exists!');
						document.getElementById("nameMsg").innerHTML = "Album already exists!";
					}
					
				}
			});	
		}		
	});

	$('#butreset').on('click', function() {
		$('#album_name').val('');
		document.getElementById("nameMsg").innerHTML = "";
	});
});


function name_validation(name) { 
	var letters = /^[A-Za-z0-9-' ]+$/;
	if(name.match(letters)) {
		document.getElementById("nameMsg").innerHTML = "";
		//document.getElementById("name").style.background = "#FFFFFF"; 
		return true;
	} else if (name==''){
		document.getElementById("nameMsg").innerHTML = "Fill album name!";
		//document.getElementById("name").style.background = "#F08080";
		return false;
	} else {
		document.getElementById("nameMsg").innerHTML = "Invalid album name!";
		//document.getElementById("name").style.background = "#F08080";
		return false;
	}
}

</script>

</body>
<?php include 'footer.php' ?>
</html>