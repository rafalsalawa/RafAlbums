<?php
	include 'database.php';
		
	$album_id=$_POST['album_id'];
	//$album_name=$_POST['album_name'];
	$description=$_POST['description'];		
	//$album_src=$_POST['album_src'];
	
	
	$sql = "UPDATE `albums` 
	SET	`description`='$description'
	WHERE album_id=$album_id";
	
	
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
?>