<?php
	include 'database.php';
	$id=$_POST['id'];
	
	$sql_src = "SELECT * FROM `photos` WHERE id=$id";	
	$result = $conn->query($sql_src);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$photo_src = $row['photo_src'];
		$thumb_src = $row['thumb_src'];
		if (file_exists($photo_src)) {
			unlink($photo_src); 
		}
		if (file_exists($thumb_src)) {
			unlink($thumb_src); 		
		}
	}
		
	$sql = "DELETE FROM `photos` WHERE id=$id";
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
	
?>
