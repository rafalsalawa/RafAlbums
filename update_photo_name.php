<?php
	include 'database.php';
		
	$id=$_POST['id'];
	//$album_name=$_POST['album_name'];
	//$author=$_POST['author'];
	$name=$_POST['name'];
	//$description=$_POST['description'];	
	//$upload_date=date('d.m.Y H:i:s', time());	
	//$photo_src=$_POST['photo_src'];
	//$thumb_src=$_POST['thumb_src'];
	
	$sql = "UPDATE `photos` 
	SET	`name`='$name'
	WHERE id=$id";
	
	
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
?>