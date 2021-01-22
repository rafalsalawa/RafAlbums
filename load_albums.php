<?php
include 'album_info.php';
include 'database.php';
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
$user_id = $_SESSION["user_id"];
//$album_id=$_POST['album_id'];		
$sql = "SELECT * FROM `albums` WHERE user_id=$user_id";	
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$albumInfo = AlbumInfo($conn, $row['album_id']);
				
?>	
		
		
		<div id="position<?=$row['album_id'];?>" class='col-xs-8 col-sm-6 col-md-4 col-lg-3'>
			<div class='cardstyle mb-4 shadow-sm ' >
			
				<div class='bd-placeholder-img card-img-top'>						
					<form id="form<?=$row['album_id'];?>" class="formalbumimage" action="view_photos.php" method="POST"> 
						<div class="wraper">
							<input name="submit" type="image" class="albumimage" 
								src="<?php 
								$sql_thumb = "SELECT `thumb_src` FROM `photos` WHERE `photos`.`album_id`=".$row['album_id']." LIMIT 1 " ;
								$thumb = $conn->query($sql_thumb);
								if ($thumb->num_rows > 0) {
									$thumb_src = $thumb->fetch_assoc();
									echo $thumb_src['thumb_src'];
								} else {
									echo "empty_image_placeholder.png";
								}								
								?>" 
								alt="<?=$row['album_name'];?>" />
							<input name="album_id" type="hidden" value="<?=$row['album_id'];?>" />
						</div>	
					</form>					
				</div>	
				
				<div class="namediv">
					<div class="shortname photonameclass doubleclickeditname" id="album_name<?=$row['album_id'];?>" data-id="<?=$row['album_id'];?>" ><?=$row['album_name'];?></div>
					<!--
					<button type="button" id="editnamebtn<?=$row['id'];?>" data-id="<?=$row['id'];?>" title="Edit photo name" class="btn btncustom btn-outline-dark editnamebtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>	
					-->
				</div>
				
				<div class="btn-group btn-group-lg">
					
					<button type="button" title="Description" class="btn btncustom btn-outline-secondary" style="width: 25%" data-toggle="collapse" data-target="#collapsedescription<?=$row['album_id'];?>" aria-expanded="false" aria-controls="collapsedescription<?=$row['album_id'];?>"><i class="fa fa-file-text-o" aria-hidden="true"></i></button>
										
					<button type="button" title="Album details" class="btn btncustom btn-md  btn-outline-info" style="width:25%" data-toggle="collapse" data-target="#collapseinfo<?=$row['album_id'];?>" aria-expanded="false" aria-controls="collapseinfo<?=$row['album_id'];?>">
					<i class="fa fa-info" aria-hidden="true"></i></button>		
					<!--
					<a role="button" class="btn btncustom btn-outline-success" style="width:25%" title="Download photo" href="<?=$row['photo_src'];?>" download="<?=$row['album_name'];?>"><i class="fa fa-download" aria-hidden="true"></i></a>	
					-->
					
					<button type="button" title="Delete album" class="btn btncustom btn-outline-danger delete" style="width:25%" data-id="<?=$row['album_id'];?>">
					<i class="fa fa-trash" aria-hidden="true"></i></button>
					
				</div>
				<div class="collapse" id="collapsedescription<?=$row['album_id'];?>" >
					<!--
					<div class="descriptiondiv">
						<button type="button" id="editdescriptionbtn<?=$row['album_id'];?>" data-id="<?=$row['album_id'];?>" title="Edit photo description" class="btn btncustom btn-outline-dark editdescriptionbtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					</div>	
					-->
					<div class="descriptionalbum doubleclickeditdescription" id="description<?=$row['album_id'];?>" data-id="<?=$row['album_id'];?>"><?=$row['description'];?></div>	
					
				</div>	
				<div class="collapse" id="collapseinfo<?=$row['album_id'];?>">	
					<div class="infoalbum">	
						<table class="tableinfo">
							<tr><td>Name:</td>
								<td><?=$row['album_name'];?></td></tr>
							<tr><td>Creation date:</td>
								<td><?=date_format(date_create($row['creation_date']),"d.m.Y H:i:s");?></td></tr>
							<tr><td>Files count:</td>
								<td><?=$albumInfo['albumCount'];?></td></tr>	
							<tr><td>Album size:</td>
								<td><?=$albumInfo['albumSize'];?></td></tr>	
						</table>
					</div>					
				</div>							
			</div>
		</div>
<?php	
	}
}
else {
?>
<div class="container">
		<div class="albumdiv">
			<div class="nophotosdiv">
				<h3>There are no albums here yet.</h3>
				<p>You can change that by adding them :)</p>				
			</div>
		</div>			
	</div>
<?php
}
mysqli_close($conn);
?>
  
  	
