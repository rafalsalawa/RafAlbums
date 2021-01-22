<?php
	include 'database.php';
	session_start();

	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: index.php");
		exit;
	}
	$album_id=$_POST['album_id'];
	
	$sql_album = "SELECT * FROM `albums` WHERE album_id=$album_id LIMIT 1";	
	$album = $conn->query($sql_album);
	if ($album->num_rows > 0) {
		while($album_row = $album->fetch_assoc()){
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$album_row['album_name'];?> - Add photos - RafAlbums</title>
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
						<form id="formadd" action="view_photos.php" method="POST">
							<input type="hidden" name="album_id" value="<?=$album_id;?>">
							<button type="submit" class="btn backbtn btn-secondary " ><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to <?=$album_row['album_name'];?> gallery</button>
						</form>	
					</div>
				</div>
			</div>

			<div class="uploaddivtitle">
				<h3>Add photos to album:</h3>
				<div class="shortname albumnamediv" id="" data-id=""><?=$album_row['album_name'];?></div>
			</div>	

			<div class="uploaddivbody">
				<form class="image-upload" method="post" action="" enctype="multipart/form-data">
					<div class="row btn-group btn-group-lg" style="width: 100%">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
							<div class="btn choosebtn btn-primary " >
								<label id="file-upload-label" for="file-upload" class="file-upload"><i class="fa fa-picture-o" aria-hidden="true"></i> Choose photos</label>
								<input id="file-upload" type="file" name="images[]" multiple="multiple" class="form-control" required/>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
							<button type="submit" class="btn uploadbtn btn-success "><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
							<button type="reset" class="btn resetbtn btn-warning "><i class="fa fa-times" aria-hidden="true"></i> Reset</button>
						</div>
					</div>
				</form>				
			</div>
			
		</div>	

		<div id="preview-images" class="row" >
		</div>
		
	</div>
</section>

</main>

<script type="text/javascript">

var album_id = "<?php echo $album_id ?>";
var preview_images = $("#preview-images");

$('.image-upload').on('submit', function(e){
	e.preventDefault();
	var formData = new FormData(this);
	formData.append('album_id', album_id);
	$.ajax({
		url : "upload_photos.php",
		type : "POST",
		data : formData,
		contentType:false,
		processData:false,
		//beforeSend : function() {
		//	preview_images.fadeOut(500);				
		//},
		success: function(data){
			//alert(data);
			alert("Upload successfull.");
			$(".image-upload")[0].reset(); 
			preview_images.fadeOut(500);								
		}
	});
});

$('.image-upload').on('reset', function(){		
	preview_images.fadeOut(500);						
});


$("#file-upload").on('change', function () {
	var countFiles = $(this)[0].files.length;
	
	var files = $(this)[0].files;
	var imgPath = $(this)[0].value;
			
	preview_images.empty();
		
	if (typeof (FileReader) != "undefined") {

		for (var i = 0; i < countFiles; i++) {
			var file = files[i];	
			if ( /\.(jpe?g|png|gif|bmp|webp)$/i.test(file.name) ) {
				var reader = new FileReader();
				reader.onload = (function(file) { 
					return function(e) { 
						$("<div class=' col-xs-8 col-sm-6 col-md-4 col-lg-3'><div class='cardstyle mb-4 shadow-sm'><img class='miniature' src='"+e.target.result+"'/><p class='shortname photonameclass'>"+file.name+"</p></div></div>").appendTo(preview_images);
					}
				})(file);
		
				reader.readAsDataURL(file);
			} else {
				alert("Please, choose files with valid image extensions: 'jpg', 'jepg', 'gif', 'png', 'bmp' or 'webp'.");
			}		
		}
		preview_images.show();

	} else {
		alert("This browser does not support FileReader.");
	}
	
});

</script>

</body>
<?php include 'footer.php' ?>
</html>


<?php
		}
	}
	else {
		header('Location: not_found.php');
		exit();
	}
	mysqli_close($conn);
?>