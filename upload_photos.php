<?php 
include 'database.php';
	
if(isset($_POST['album_id'])){
	$album_id=$_POST['album_id'];
    
    if(is_array($_FILES)){		
        foreach ($_FILES['images']['name'] as $key => $value) {
            $file_name = explode(".", $_FILES['images']['name'][$key]);
            $allowed_ext = array("jpg", "jpeg", "png", "gif", "bmp", "webp");
			
            if(in_array($file_name[1], $allowed_ext)) { 	
                $sourcePath = $_FILES['images']['tmp_name'][$key];
				date_default_timezone_set("Europe/Warsaw");
				$_date =date("dmYHis", time());
				$upload_date =date("Y-m-d H:i:s", time());

                $new_name = sha1_file($sourcePath). "_" . $_date .  "_" . $file_name[0] . '.' . $file_name[1];
                $targetPath = "photos/".$album_id."/".$new_name;
				$thumbTargetPath = "photos/".$album_id."/thumbnails/".$new_name;
				
				
				
                if(move_uploaded_file($sourcePath, $targetPath)) {  
                    
					$insert = $conn->query("INSERT INTO `photos`(`id`, `album_id`, `name`, `description`, `upload_date`, `photo_src`, `thumb_src`) VALUES (NULL,'".$album_id."', '".$file_name[0]."', '', '".$upload_date."', '".$targetPath."', '".$thumbTargetPath."')");
                
					$maxLong = 600; // max width or height of thumbnail image
					
					// extract image size
					$ext = strtolower(pathinfo($new_name)['extension']);
					list ($width, $height) = getimagesize($targetPath);
					$ratio = $width > $height ? $maxLong / $width : $maxLong / $height ;
					$newWidth = ceil($width * $ratio);
					$newHeight = ceil($height * $ratio);

					// image size change
					$fnCreate = "imagecreatefrom" . ($ext=="jpg" ? "jpeg" : $ext);
					$fnOutput = "image" . ($ext=="jpg" ? "jpeg" : $ext);
					$source = $fnCreate($targetPath);
					$destination = imagecreatetruecolor($newWidth, $newHeight);

					// for transparent images only
					if ($ext=="png" || $ext=="gif") {
						imagealphablending($destination, false);
						imagesavealpha($destination, true);
						imagefilledrectangle(
							$destination, 0, 0, $newWidth, $newHeight, imagecolorallocatealpha($destination, 255, 255, 255, 127)
						);
					}

					// save rescaled images
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
					$fnOutput($destination, $thumbTargetPath);					
				}				
            }			
        }				
		echo "Upload successful!";
	}
} else {
	echo "Invalid album id!";
}
?>