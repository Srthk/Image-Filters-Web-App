<?php

require_once("imagefilter.inc.php");

function getMimeType($filename)
{
    $mimetype = false;
    if(function_exists('finfo_fopen')) {
        // open with FileInfo
    } elseif(function_exists('getimagesize')) {
        // open with GD
    } elseif(function_exists('exif_imagetype')) {
       // open with EXIF
    } elseif(function_exists('mime_content_type')) {
       $mimetype = mime_content_type($filename);
    }
    return $mimetype;
}

$validImageFormat = array('jpg','jpeg','png');

if(is_array($_FILES)) {

	if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {

			$sourcePath = $_FILES['userImage']['tmp_name'];

			$targetPath = "images/" . $_FILES['userImage']['name'];

						if(move_uploaded_file($sourcePath,$targetPath)){
								
							$ext = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

							$hash = hash_file('md5', $targetPath);
							$fileHash = $hash . "." . $ext;
							$tempName = $hash . "_temp." . $ext;
							$newFileName = "images/" . $fileHash;

							rename($targetPath, $newFileName);
							
							$imageObject = new imageFilters($hash, $ext);

							list($width,$height) = $imageObject->displayWidthHeight();


							if(in_array(strtolower($ext), $validImageFormat)) {


							?>

							<img src="<?php echo $newFileName; ?>" id="<?php echo $fileHash; ?>" class='dropped-image' height="<?php echo $height; ?>" width="<?php echo $width; ?>"hspace=15 />

<?php
					}

				}
		}
}

?>