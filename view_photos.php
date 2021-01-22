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
	$album_row = $album->fetch_assoc();
		
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$album_row['album_name'];?> - RafAlbums</title>
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
		<div class="albumdiv">
			<div class="uploaddivback" >
				<div class="row btn-group btn-group-lg text-center" style="width: 100%">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
						<a href="view_albums.php" class="btn backbtn btn-secondary" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to all albums</a>
					</div>					
				</div>
			</div>
			<div class="albumnameclass text-center">
				<div class="shortname albumnamediv" id="albumname<?=$album_row['album_id'];?>" data-id="<?=$album_row['album_id'];?>"><?=$album_row['album_name'];?></div>

				<button type="button" id="editalbumnamebtn<?=$album_row['album_id'];?>" data-id="<?=$album_row['album_id'];?>" title="Edit album name" class="btn btncustom btn-outline-dark editalbumnamebtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
			</div>	
			<div class="albumdescriptionclass text-center">
				<div class="albumdescriptiontext" id="albumdescription<?=$album_row['album_id'];?>" data-id="<?=$album_row['album_id'];?>"><?=$album_row['description'];?></div>			
				<div id="albumdescriptionbtndiv" class="albumdescriptionbtndiv">
					<button type="button" id="editalbumdescriptionbtn<?=$album_row['album_id'];?>" data-id="<?=$album_row['album_id'];?>" title="Edit album description" class="btn btncustom btn-outline-dark editalbumdescriptionbtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
				</div>
			</div>
			<div class="albumactionbtndiv">
				<div class="row btn-group btn-group-lg text-center" style="width: 100%;">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
						<!--
						<a href="index.php" class="btn btnmenucustom btn-primary" ><i class="fa fa-files-o" aria-hidden="true"></i> Show all albums</a>
						-->
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">					
						<form id="formadd" action="add_photos.php" method="POST">
							<input type="hidden" name="album_id" value="<?=$album_id;?>">
							<button type="submit" class="btn btnmenucustom btn-success" ><i class="fa fa-plus" aria-hidden="true"></i> Add photos</button>
						</form>					
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
						<!--
						<a href="#" class="btn btnmenucustom btn-secondary" >action??</a>
						-->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<div class="transparentbg album" >
	<div class="container" >		
	
		<div id="lback" onclick="gallery.hide()">
			<div id="lfront"></div>
		</div>
	
		<div class="gallery">
			<div id="galleryrecords" class="row">
			</div>			
		</div>
	</div>
</div>

<div class="bottomdiv">
</div>

</main>
<script>
$(document).ready(function() {
	
	var album_id = "<?php echo $album_id ?>";
	$.ajax({
		url: "load_photos.php",
		type: "POST",
		cache: false,
		data:{			
			album_id: album_id,
		},
		success: function(dataResult){
			$('#galleryrecords').html(dataResult); 			
		}
	});
	
	
//------------------------------------------------------------------------------------------	
//editing album name
	$(".editalbumnamebtn").click(function(){
		var id = $(this).attr("data-id");
		var elementid = "albumname" + id;
		//var editalbumnamebtnid = "editalbumnamebtn"+$(this).attr("id");
		var editalbumnamebtnid = "editalbumnamebtn" + id;
		$editalbumnamebtn = $(document.getElementById(editalbumnamebtnid));
		$editalbumnamebtn.hide();
		var $element = $(document.getElementById(elementid));
		var newcontalbumnameid = "newcont" +elementid;
		
		var currentval = $element.text();
		$element.html('<input type="text" class="newcontalbumnameclass form-control" id="'+newcontalbumnameid+'" value="" >'+
		'<div class="btn-group btn-group-md"><button type="button" id="savealbumname'+id+'" title="Save changes" class="btn btncustom btn-primary save" style="width: 5rem"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>'+
		'<button type="button" id="cancelalbumname'+id+'" title="Cancel changes" class="btn btncustom btn-warning cancel" style="width: 5rem"><i class="fa fa-times" aria-hidden="true"></i></button></div>');
		var $newcontelement = $(document.getElementById(newcontalbumnameid));
		$newcontelement.focus();	
		$newcontelement.attr("value", currentval);
		
		$('#newcontalbumname'+id).blur(function (e) {
			if ($(e.relatedTarget).attr('id') == 'savealbumname'+id)
				return;
			if ($(e.relatedTarget).attr('id') == 'cancelalbumname'+id)
				return;
			$element.text(currentval);
			$editalbumnamebtn.show();			
		});		
		
		$("#savealbumname"+id).click(function(){
			var newcont = $newcontelement.val();
			$element.text(newcont);
			 
			$.ajax({
				url: "update_album_name.php",
				type: "POST",
				cache: false,
				data:{
					album_id: id,				
					album_name: newcont				
				},
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){						
						//alert('Data updated successfully !');
						//location.reload();					
					}
				}
			});			 
				
			$editalbumnamebtn.show();
		});
	
		$("#cancelalbumname"+id).click(function() {			
			$element.text(currentval);
			$element.blur();
			$editalbumnamebtn.show();
		});		
	})

//editing album description
	$(".editalbumdescriptionbtn").click(function(f){
		//f.stopPropagation();
		var id = $(this).attr("data-id");
		var elementid = "albumdescription" + id;
		//var editalbumdescriptionbtnid = $(this).attr("id");
		var editalbumdescriptionbtnid = "editalbumdescriptionbtn" + id;
		$editalbumdescriptionbtn = $(document.getElementById(editalbumdescriptionbtnid));
		$editalbumdescriptionbtn.hide();
		var albumdescriptionid = "albumdescription" + id;
		albumdescription = document.getElementById(albumdescriptionid);
		albumdescription.style.height = "15rem";
		var $element = $(document.getElementById(elementid));
		var newcontalbumdescriptionid = "newcont" +elementid;
		
		var currentval = $element.text();
		$element.html('<textarea class="newcontalbumdescriptionclass form-control" id="'+newcontalbumdescriptionid+'" ></textarea>'+
		'<div class="btn-group btn-group-md"><button type="button" id="savealbumdescription'+id+'" title="Save changes" class="btn btncustom btn-primary save" style="width: 5rem"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>'+
		'<button type="button" id="cancelalbumdescription'+id+'" title="Cancel changes" class="btn btncustom btn-warning cancel" style="width: 5rem"><i class="fa fa-times" aria-hidden="true"></i></button></div>');
				
		var $newcontelement = $(document.getElementById(newcontalbumdescriptionid));
		$newcontelement.focus();	
		$newcontelement.text(currentval);	
		
		$('#newcontalbumdescription'+id).blur(function (e) {
			if ($(e.relatedTarget).attr('id') == 'savealbumdescription'+id)
				return;
			if ($(e.relatedTarget).attr('id') == 'cancelalbumdescription'+id)
				return;
			$element.text(currentval);
			$editalbumdescriptionbtn.show();
			albumdescription.style.height = "12rem";				
		});		
		
		$("#savealbumdescription"+id).click(function() {
			var newcont = $newcontelement.val();
			$element.text(newcont);
			 
			$.ajax({
				url: "update_album_description.php",
				type: "POST",
				cache: false,
				data:{
					album_id: id,				
					description: newcont				
				},
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){						
						//alert('Data updated successfully !');
						//location.reload();					
					}
				}
			});	 
			
			$editalbumdescriptionbtn.show();
			albumdescription.style.height = "12rem";	
		});
		
		$("#cancelalbumdescription"+id).click(function() {			
			$element.text(currentval);
			$element.blur();
			$editalbumdescriptionbtn.show();
			albumdescription.style.height = "12rem";	
		});			
	})	
	
	
//------------------------------------------------------------------------------------------		
//not closing collapse with click inside
	$(document).click(function(event) {
		if (!$(event.target).is('.collapse') &&
			!$(event.target).is('.description') &&
			!$(event.target).is('.info') &&
			!$(event.target).is('.editdescriptionbtn') &&
			!$(event.target).is('.descriptiondiv') &&
			!$(event.target).is('.save') &&
			!$(event.target).is('.cancel') &&
			!$(event.target).is('td') &&
			!$(event.target).is('.form-control')) {
				$('.collapse').collapse('hide');	    
		}
	});
	
	

	
//------------------------------------------------------------------------------------------	
//editing photo name
	$(document).on("click", ".editnamebtn", function(){
		
		var id = $(this).attr("data-id");
		var elementid = "name" + id;
		//var editnamebtnid = "editnamebtn"+$(this).attr("id");
		var editnamebtnid = "editnamebtn" + id;
		$editnamebtn = $(document.getElementById(editnamebtnid));
		$editnamebtn.hide();
		var $element = $(document.getElementById(elementid));
		var newcontnameid = "newcont" +elementid;
		
		var currentval = $element.text();
		$element.html('<input type="text" class="newcontnameclass form-control" id="'+newcontnameid+'" value="" >'+
		'<div class="btn-group btn-block btn-group-md"><button type="button" id="savename'+id+'" title="Save changes" class="btn btncustom btn-primary save" style="width: 50%"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>'+
		'<button type="button" id="cancelname'+id+'" title="Cancel changes" class="btn btncustom btn-warning cancel" style="width: 50%"><i class="fa fa-times" aria-hidden="true"></i></button></div>');
		var $newcontelement = $(document.getElementById(newcontnameid));
		$newcontelement.focus();	
		$newcontelement.attr("value", currentval);	
		
		$('#newcontname'+id).blur(function (e) {
			if ($(e.relatedTarget).attr('id') == 'savename'+id)
				return;
			if ($(e.relatedTarget).attr('id') == 'cancelname'+id)
				return;
			$element.text(currentval);
			$editnamebtn.show();			
		});		
		
		$("#savename"+id).click(function(){
			var newcont = $newcontelement.val();
			$element.text(newcont);
			 
			$.ajax({
				url: "update_photo_name.php",
				type: "POST",
				cache: false,
				data:{
					id: id,				
					name: newcont,				
				},
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){						
						//alert('Data updated successfully !');
						//location.reload();					
					}
				}
			});			 
					
			$editnamebtn.show();
		});
	
		$("#cancelname"+id).click(function() {			
			$element.text(currentval);
			$element.blur();
			$editnamebtn.show();
		});		
	})

//editing photo description
	$(document).on("click", ".editdescriptionbtn", function(f){
		f.stopPropagation();
		var id = $(this).attr("data-id");
		var elementid = "description" + id;
		//var editdescriptionbtnid = $(this).attr("id");
		var descriptiondivid = "descriptiondiv" + id;
		$descriptiondiv = $(document.getElementById(descriptiondivid));
		$descriptiondiv.hide();
		var descriptionid = "description" + id;
		description = document.getElementById(descriptionid);
		description.style.height = "14.25rem";
		var $element = $(document.getElementById(elementid));
		var newcontdescriptionid = "newcont" +elementid;
		
		var currentval = $element.text();
		$element.html('<textarea class="newcontdescriptionclass form-control" id="'+newcontdescriptionid+'" ></textarea>'+
		'<div class="btn-group btn-block btn-group-md"><button type="button" id="savedescription'+id+'" title="Save changes" class="btn btncustom btn-primary save" style="width: 50%"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>'+
		'<button type="button" id="canceldescription'+id+'" title="Cancel changes" class="btn btncustom btn-warning cancel" style="width: 50%"><i class="fa fa-times" aria-hidden="true"></i></button></div>');
				
		var $newcontelement = $(document.getElementById(newcontdescriptionid));
		$newcontelement.focus();		
		$newcontelement.text(currentval);

		$('#newcontdescription'+id).blur(function (e) {
			if ($(e.relatedTarget).attr('id') == 'savedescription'+id)
				return;
			if ($(e.relatedTarget).attr('id') == 'canceldescription'+id)
				return;
			$element.text(currentval);
			$descriptiondiv.show();	
			description.style.height = "12rem";			
		});		
		
		$("#savedescription"+id).click(function() {
			var newcont = $newcontelement.val();
			$element.text(newcont);
			 
			$.ajax({
				url: "update_photo_description.php",
				type: "POST",
				cache: false,
				data:{
					id: id,				
					description: newcont,				
				},
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){						
						//alert('Data updated successfully !');
						//location.reload();					
					}
				}
			});	 
			
			$descriptiondiv.show();
			description.style.height = "12rem";
		});
		
		$("#canceldescription"+id).click(function() {			
			$element.text(currentval);
			$element.blur();
			$descriptiondiv.show();
			description.style.height = "12rem";
		});			
	})	
	

//------------------------------------------------------------------------------------------		
//deleting photo from database and main gallery view
	$(document).on("click", ".delete", function() { 		
		var id = $(this).attr("data-id");
		var position = "position" +id;
		var $element = $(document.getElementById(position));
		//var $element = $(this).parent().parent();
		if(confirm("Are you sure you want to delete this photo?"))	{
			$.ajax({
				url: "delete_photo.php",
				type: "POST",
				cache: false,
				data:{
					id: id
				},
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
						$element.fadeOut().remove();
						alert('Photo removed successfully.');
					} else if (dataResult.statusCode==201) {						
						alert('Error occured.');
					}
				}
			});
		}else {
			return false;
		}		
	});


//-------------------------------------------------------------------------------------------
//gallery init every time mousedown on specific image

	var gallery;
	$(document).on( "mousedown", ".galleryimage", function() { 	
		gallery = $('.gallery a.a-image').simpleLightbox();
		//console.log("image gallery create on mousedown");
	});	

//gallery destroy every time mousedown on gallery background
	$(document).on( "click", ".sl-overlay, .sl-close", function() {
		gallery.destroy();		
		//console.log("image gallery destroy on close");	
	});	

});

</script>

<?php include 'footer.php' ?>

</body>
</html>

<?php
		
}
else {
	header('Location: not_found.php');
	exit();
}
mysqli_close($conn);
?>