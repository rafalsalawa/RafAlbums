<?php
include 'database.php';
session_start();
$user_id = $_SESSION["user_id"];

if($_POST['type']==1){
	$album_name=$_POST['album_name'];
	
	$duplicate=mysqli_query($conn,"SELECT * FROM albums WHERE user_id = '$user_id' AND album_name='$album_name'");
	
	if (mysqli_num_rows($duplicate)>0) {
		echo json_encode(array("statusCode"=>201));
	} else {
		date_default_timezone_set("Europe/Warsaw");
		$creation_date =date("Y-m-d H:i:s", time());
		$sql = "INSERT INTO `albums` (`album_id`, `user_id`, `album_name`, `description`, `creation_date`, `album_src`) VALUES (NULL, '$user_id', '$album_name','','$creation_date','')";
		
		if (mysqli_query($conn, $sql)) {
			$album_id = mysqli_insert_id($conn);
			
			$photos_src = "photos";
			$album_src = "photos/$album_id";
			$update = mysqli_query($conn,"UPDATE `albums` SET `album_src`='$album_src' WHERE `album_id`=$album_id");
			
			if (!file_exists($photos_src)) {
				mkdir("$photos_src");		
			}
			if (!file_exists($album_src)) {
				mkdir("$album_src");		
			}
			$thumb_album_src = "$album_src/thumbnails";
			if (!file_exists($thumb_album_src)) {
				mkdir("$thumb_album_src");		
			}							
			
			echo json_encode(array("statusCode"=>200));
		} 
		else {
			echo json_encode(array("statusCode"=>201));
		}
	}
	mysqli_close($conn);
}	
?>
