<?php

  function blackwhite($image){
	   imagefilter($image, IMG_FILTER_GRAYSCALE);
	   return $image;
  }
  if(isset($_GET['hash'])){
  		

  	  $imagehash = $_GET['hash'];
  	  $imagetype = $_GET['type'];

   	 header("content-type: image/" . $imagetype);

   	  switch($imagetype){

   	   case "png":
   	   				$image = imagecreatefrompng("images/" . $imagehash . "." . $imagetype);
   	   				
   	   				$image = blackwhite($image);

	 				imagepng($image);

					break;
	   case "jpeg": 
	   case "jpg": $image = imagecreatefromjpeg("images/" . $imagehash . "." . $imagetype);
	   			   $image = blackwhite($image);
	      	   	   imagejpeg($image);
	   			   break;
	   default: "Incorrect Image type";
   	  }
	 
	  imagedestroy($image);

  }

?>