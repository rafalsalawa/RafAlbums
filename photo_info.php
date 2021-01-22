<?php
// details of image
function cameraUsed($imagePath) {

	// check if the variable is set and if the file itself exists before continuing
    if ((isset($imagePath)) and (file_exists($imagePath))) {
		
		//$allowed_ext = array("jpg", "jpeg", "png", "gif", "bmp", "webp");
		$allowed_ext = array("jpg", "jpeg");	
		$ext = strtolower(pathinfo(basename($imagePath))['extension']);
		if(in_array($ext, $allowed_ext)) { 
	   
			// arrays which contains the information 
			$exif_ifd0 = @exif_read_data($imagePath ,'IFD0' ,0);      
			$exif_exif = @exif_read_data($imagePath ,'EXIF' ,0);
			 
			//error control
			$notFound = "Unavailable";
		 
			// Make
			if (@array_key_exists('Make', $exif_ifd0)) {
				$camMake = $exif_ifd0['Make'];
			} else {
				$camMake = $notFound;
			}
		 
			// Model
			if (@array_key_exists('Model', $exif_ifd0)) {
				$camModel = $exif_ifd0['Model'];
			} else {
				$camModel = $notFound; 
			}
			
			// FileSize
			$camFileSize = filesize($imagePath);			
								
			if ($camFileSize >= 1048576) {
				$camFileSize = number_format($camFileSize / 1048576, 2) . ' MB';
			}
			elseif ($camFileSize >= 1024) {
				$camFileSize = number_format($camFileSize / 1024, 2) . ' KB';
			}
			elseif ($camFileSize > 1) {
				$camFileSize = $camFileSize . ' bytes';
			}
			elseif ($camFileSize == 1) {
				$camFileSize = $camFileSize . ' byte';
			} else {
				$camFileSize = '0 bytes';
			}  
/*
			
			if (@array_key_exists('FileSize', $exif_ifd0)) {
				$camFileSize = $exif_ifd0['FileSize'];					
				if ($camFileSize >= 1048576) {
					$camFileSize = number_format($camFileSize / 1048576, 2) . ' MB';
				}
				elseif ($camFileSize >= 1024) {
					$camFileSize = number_format($camFileSize / 1024, 2) . ' KB';
				}
				elseif ($camFileSize > 1) {
					$camFileSize = $camFileSize . ' bytes';
				}
				elseif ($camFileSize == 1) {
					$camFileSize = $camFileSize . ' byte';
				} else {
					$camFileSize = '0 bytes';
				}  
			} else {
				$camFileSize = $notFound;
			}
*/			
			list($width, $height, $type, $attr) = getimagesize($imagePath);
			$camWidth = $width;
			$camHeight = $height;
/*			
			// Width
			if (@array_key_exists('Width', $exif_ifd0['COMPUTED'])) {
				$camWidth = $exif_ifd0['COMPUTED']['Width'];
			} else {
			$camWidth = $notFound;
			}
		  
			// Height
			if (@array_key_exists('Height', $exif_ifd0['COMPUTED'])) {
				$camHeight = $exif_ifd0['COMPUTED']['Height'];
			} else {
			$camHeight = $notFound;
			}
*/
			// Exposure
			if (@array_key_exists('ExposureTime', $exif_ifd0)) {
				$camExposure = $exif_ifd0['ExposureTime'];
			} else {
				$camExposure = $notFound;
			}
		 
			// Aperture
			if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
				$camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
			} else {
				$camAperture = $notFound;
			}
			 
			// Date
			if (@array_key_exists('DateTime', $exif_ifd0)) {
				$camDate = $exif_ifd0['DateTime'];
				$camDate = date_create($camDate);
				$camDate = date_format($camDate,"d.m.Y H:i:s");
			} else {
				$camDate = $notFound;
			}
			   
			// ISO
			if (@array_key_exists('ISOSpeedRatings',$exif_exif)) {
				$camIso = $exif_exif['ISOSpeedRatings'];
			} else {
				$camIso = $notFound;
			}
			 
			$return = array();
			$return['date'] = $camDate;
			$return['filesize'] = $camFileSize;
			$return['width'] = $camWidth;
			$return['height'] = $camHeight;
			$return['make'] = $camMake;
			$return['model'] = $camModel;
			$return['exposure'] = $camExposure;
			$return['aperture'] = $camAperture;
			$return['iso'] = $camIso;
			return $return;
		} else {
			$filesize = filesize($imagePath);
			list($width, $height, $type, $attr) = getimagesize($imagePath);
			
			//$notSupported = "Not supported";
			$notSupported = "Unavailable";
			$return = array();
			$return['date'] = $notSupported;
			$return['filesize'] = $filesize;
			$return['width'] = $width;
			$return['height'] = $height;
			$return['make'] = $notSupported;
			$return['model'] = $notSupported;
			$return['exposure'] = $notSupported;
			$return['aperture'] = $notSupported;
			$return['iso'] = $notSupported;
			return $return;
			//return false;
			
		}
	} else {
		$return = "No data available";
		return $return;
    }
}

?>