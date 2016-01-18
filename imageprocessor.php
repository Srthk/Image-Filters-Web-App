<?php

  require("imagefilter.inc.php");
  

  if(isset($_GET['hash'])){
  		

  	  $imagehash = $_GET['hash'];
  	  $imagetype = $_GET['type'];
      $filtertype = $_GET['filter'];
      $intensity = $_GET['bintensity'];

      $imageObject = new imageFilters($imagehash, $imagetype);


      switch($filtertype){

        case "blackwhite": 
                          $imageObject->blackwhite();
                          break;
        case "bright":       
                          $imageObject->brightness($intensity);
                          break;
        case "smooth":    $imageObject->smooth();
                          break;
        case "reset": 
                          $imageObject->reset();
                          break;
        default:         echo "";                 
      }

      $imageObject->displayImage();
			
  }

?>