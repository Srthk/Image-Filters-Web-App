<?php
class imageFilters{
	
	private $image; // image object
	private $imageName; // name of image (hash)
	private $type;	// file extension
	private $filterType;
	private $imageURL; 
	private $tempImage;
	private $height;
	private $width;

	public function __construct($image,$type){

		$this->imageName = $image;
		$this->type = $type;
		$this->setImageURL();
		$this->validateImage();
	}
	
	public function setImageURL($slug = ""){

		$this->imageURL = "images/" . $this->imageName . "." . $this->type;
		$this->tempImage = "images/" . $this->imageName . "_temp." . $this->type;
		$this->duplicate();
		list($this->width, $this->height) = getimagesize($this->imageURL);

	}

	public function fetchImageURL($slug = ""){

	}

	//function to maintain the aspect ratio of image displayed within the canvas of 500x500
	public function displayWidthHeight(){

		$width = $this->width;
		$height = $this->height;

		$array = array($width,$height);

		if($height <= 500 && $width <= 500){
			return $array;
		}
		else{
			if(max($array) == $width){
				$array = $this->adjustAspect($width,$height);
			}
			else{
				$array = $this->adjustAspect($height,$width, true);
			}
		}

		return $array;
	}
	private function adjustAspect($value1, $value2, $swap = false, $threshold = 500){
		 $factor = $value1 / $threshold;
		 
		 if($swap)
		 	return array($value2/$factor,500);

		 return array(500,$value2/$factor);
	}
	public function getHeight(){

		if($this->height < 500){
			return $this->height . "px";
		}
		else
			return "500px";
	}

	public function getWidth(){
		
		if($this->width < 500){
			return $this->width . "px";
		}
		else
			return "500px";
	}
	public function reset(){
		$this->validateImage("imageURL");
		$this->duplicate(true);
	}
	public function duplicate($force = false){

		if($force || !file_exists($this->tempImage)){
			$this->validateImage("imageURL");
			$this->displayImage(false);
		}
		
	}
	public function validateImage($imageVar = "tempImage"){

	switch($this->type){

	   	   case "png":
	   	   			   $this->image = imagecreatefrompng($this->{$imageVar});
	   	   				
	   	   				break;

		   case "jpeg": 
		   case "jpg":
					   $this->setMemory($imageVar);
		   			   $this->image = imagecreatefromjpeg($this->{$imageVar});
		   			  
		   			   break;

		   default: die("Incorrect Image type");
	  	}

	}
	private function setMemory($imageVar){

		$imageInfo = getimagesize($this->{$imageVar}); 

		$memoryNeeded = round(($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $imageInfo['channels'] / 8 + Pow(2,16)) * 1.65); 
						if (function_exists('memory_get_usage') && memory_get_usage() + $memoryNeeded > (integer)ini_get('memory_limit') *pow(1024, 2)) {
						 ini_set('memory_limit', 2 * (integer) ini_get('memory_limit') + ceil(((memory_get_usage() + $memoryNeeded) - (integer) ini_get('memory_limit') * pow(1024, 2)) / pow(1024, 2)) . 'M'); 
						}

	}
	public function setFilter($filtertype){

			$this->filtertype = $filtertype;
	}

	public function setHeader(){

    	 header("content-type: image/" . $this->type);

    }

	public function blackwhite(){
	   imagefilter($this->image, IMG_FILTER_GRAYSCALE);
	   imagefilter($this->image, IMG_FILTER_CONTRAST, 30);
		

    }

    public function brightness($value = 50){

    	 imagefilter($this->image, IMG_FILTER_BRIGHTNESS, $value);

    }
    public function smooth($value = 6){
    	  imagefilter($this->image, IMG_FILTER_SMOOTH, $value);
    }
    public function echoImage($id, $source, $class = "dropped-image"){

    	list($width,$height) = $this->displayWidthHeight();

		echo "<img id='" . $id . "' class='$class' src='" . $source  . "?" . time() . "' height='$height' width='$width'>";

    }
    public function displayImage($echo = true){

    	switch($this->type){

		   	   case "png":

		   	   				imagepng($this->image,$this->tempImage);
		   	   				break;

			   case "jpeg": 
			   case "jpg":

			   			   imagejpeg($this->image, $this->tempImage);
			   			   break;

			   default: die("Incorrect Image type");
   	  	}
   	  	

   	  	if($echo)
   	  		$this->echoImage($this->imageName, $this->tempImage);

    }

    public function __destruct(){
    	imagedestroy($this->image);
    }

}