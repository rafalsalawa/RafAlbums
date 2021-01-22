<?php
//include 'database.php';
//$album_id = 1;
//AlbumInfo($album_id);

function AlbumInfo($conn, $album_id) {
	$albumCount = 0;
	$albumSize = 0;
	
	$sqlinfo = "SELECT * FROM `photos` WHERE `album_id`=$album_id";	
	$result = $conn->query($sqlinfo);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$imagePath = $row['photo_src'];
			$fileSize = filesize($imagePath);				
			$albumCount++;
			$albumSize = $albumSize + $fileSize; 				
		}
		
		if ($albumSize >= 1073741824) {
			$albumSize = number_format($albumSize / 1073741824, 2) . ' GB';
		}		
		elseif ($albumSize >= 1048576) {
			$albumSize = number_format($albumSize / 1048576, 2) . ' MB';
		}
		elseif ($albumSize >= 1024) {
			$albumSize = number_format($albumSize / 1024, 2) . ' KB';
		}
		elseif ($albumSize > 1) {
			$albumSize = $albumSize . ' bytes';
		}
		elseif ($albumSize == 1) {
			$albumSize = $albumSize . ' byte';
		} else {
			$albumSize = '0 bytes';
		}  
		$return = array();
		$return['albumCount'] = $albumCount;
		$return['albumSize'] = $albumSize;
		return $return;
		//echo ($return['albumCount']);
		//echo ($return['albumSize']);
	}
	else {
		$return = array();
		$return['albumCount'] = 0;
		$return['albumSize'] = 0;		
		return $return;
		//echo ($return['albumCount']);
		//echo ($return['albumSize']);
	}	
}
//mysqli_close($conn);
?>