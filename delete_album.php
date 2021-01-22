<?php
include 'database.php';

$album_id=$_POST['album_id'];
$sql = "SELECT * FROM `albums` WHERE album_id=$album_id" ;	
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$album_src = $row['album_src'];

if (file_exists($album_src)) {
	Delete($album_src);	
}

$sqlpp = "DELETE FROM `photos` WHERE album_id=$album_id";
mysqli_query($conn, $sqlpp);

$sqlppp = "DELETE FROM `albums` WHERE album_id=$album_id" ;
if (mysqli_query($conn, $sqlppp)) {				
	echo json_encode(array("statusCode"=>200));
} else {
	echo json_encode(array("statusCode"=>201));
}		
	
function Delete($path) {
	if (is_dir($path) === true)	{		
		$files = array_diff(scandir($path), array('.', '..'));
		
		foreach ($files as $file) {			
			Delete(realpath($path) . DIRECTORY_SEPARATOR . $file);
		}
		return rmdir($path);
		
	} elseif (is_file($path) === true)	{			
		return unlink($path);
	}
	return false;
}

mysqli_close($conn);
?>
