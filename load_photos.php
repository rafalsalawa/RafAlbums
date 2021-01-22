<?php
include 'database.php';
include 'photo_info.php';
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$album_id=$_POST['album_id'];		
$sql = "SELECT * FROM `photos` WHERE album_id=$album_id" ;	
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$camera = cameraUsed($row['photo_src']);
?>	
		
		
		<div id="position<?=$row['id'];?>" class='col-xs-8 col-sm-6 col-md-4 col-lg-3'>
			<div class='cardstyle mb-4 shadow-sm ' >
			
				<div class='bd-placeholder-img card-img-top'>										
					<a class="a-image" href="<?=$row['photo_src'];?>">
						<p class='wraper' >
							<img class="galleryimage" id="image<?=$row['id'];?>" src="<?=$row['thumb_src'];?>" alt="<?=$row['name'];?>" />		
						</p>
					</a>										
				</div>	
				
				<div class="namediv">
					<div class="shortname photonameclass doubleclickeditname" id="name<?=$row['id'];?>" data-id="<?=$row['id'];?>" ><?=$row['name'];?></div>
					
					<button type="button" id="editnamebtn<?=$row['id'];?>" data-id="<?=$row['id'];?>" title="Edit photo name" class="btn btncustom btn-outline-dark editnamebtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>	
				</div>
				
				<div class="btn-group btn-group-lg">
					
					<button type="button" title="Description" class="btn btncustom btn-outline-secondary" style="width: 25%" data-toggle="collapse" data-target="#collapsedescription<?=$row['id'];?>" aria-expanded="false" aria-controls="collapsedescription<?=$row['id'];?>"><i class="fa fa-file-text-o" aria-hidden="true"></i></button>
										
					<button type="button" title="Photo details" class="btn btncustom btn-md  btn-outline-info" style="width:25%" data-toggle="collapse" data-target="#collapseinfo<?=$row['id'];?>" aria-expanded="false" aria-controls="collapseinfo<?=$row['id'];?>">
					<i class="fa fa-info" aria-hidden="true"></i></button>		
					
					<a role="button" class="btn btncustom btn-outline-success" style="width:25%" title="Download photo" href="<?=$row['photo_src'];?>" download="<?=$row['name'];?>"><i class="fa fa-download" aria-hidden="true"></i></a>	
					
					<button type="button" title="Delete photo" class="btn btncustom btn-outline-danger delete" style="width:25%" data-id="<?=$row['id'];?>">
					<i class="fa fa-trash" aria-hidden="true"></i></button>
				</div>
				<div class="collapse " style="height: 14.5rem;" id="collapsedescription<?=$row['id'];?>" >
					
					<div id="description<?=$row['id'];?>" class="description doubleclickeditdescription" data-id="<?=$row['id'];?>"><?=$row['description'];?></div>	
					
					<div id="descriptiondiv<?=$row['id'];?>" class="descriptiondiv">
						<button type="button" id="editdescriptionbtn<?=$row['id'];?>" data-id="<?=$row['id'];?>" title="Edit photo description" class="btn btncustom btn-outline-dark editdescriptionbtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					</div>
					
				</div>	
				<div class="collapse " style="height: 14.5rem;" id="collapseinfo<?=$row['id'];?>">	
					<div class="info">	
						<table class="tableinfo">
							<tr><td>Name:</td>
								<td><?=$row['name'];?></td></tr>
							<tr><td>Execution date:</td>
								<td><?=$camera['date'];?></td></tr>
							<tr><td>Upload date:</td>
								<td><?=date_format(date_create($row['upload_date']),"d.m.Y H:i:s");?></td></tr>
							<tr><td>File size:</td>
								<td><?=$camera['filesize'];?></td></tr>
							<tr><td>Width (px):</td>
								<td><?=$camera['width'];?></td></tr>
							<tr><td>Height (px):</td>
								<td><?=$camera['height'];?></td></tr>	
							<tr><td>Camera brand:</td>
								<td><?=$camera['make'];?></td></tr>
							<tr><td>Camera model:</td>
								<td><?=$camera['model'];?></td></tr>	
							<tr><td>Exposure:</td>
								<td><?=$camera['exposure'];?></td></tr>
							<tr><td>Aperture:</td>
								<td><?=$camera['aperture'];?></td></tr>
							<tr><td>ISO:</td>
								<td><?=$camera['iso'];?></td></tr>
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
				<h3>There are no photos in this album yet.</h3>
				<p>You can change that by adding them :)</p>				
			</div>
		</div>			
	</div>
<?php
}
mysqli_close($conn);
?>
  
  	
