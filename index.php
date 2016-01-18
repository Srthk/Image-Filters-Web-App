<!DOCTYPE html>
<html ng-app="demo">
<head>
<title>jQuery Drag and Drop Image Upload</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<link rel="stylesheet" href="slider.css">
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.19/angular.min.js'></script>
<script src='https://dl.dropbox.com/s/d7w7583y2nicoo3/angular-progress-arc.min.js'></script>
<!-- Latest compiled and minified JavaScript -->
<script src='slider.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<style>
.upload-drop-zone {
  height: 202px;
  border-width: 2px;
  margin-bottom: 20px;
}

/* skin.css Style*/
.upload-drop-zone {
  color: #ccc;
  border-style: dashed;
  border-color: #ccc;
  line-height: 200px;
  text-align: center
}
.boxed-image{
	border: 2px dashed #ccc;
	display: none;
	padding: 5px;
}
.filter-button{
	background-color: #6300bc;
	color: #fff;
	cursor:pointer;
	height: 70px;
	line-height: 70px;
	text-align: center;
	vertical-align: middle;
}

</style>
<script>
$(document).ready(function() {
	$("#drop-area").on('dragenter', function (e){
	e.preventDefault();
	//$(this).css('background', '#BBD5B8');
	});

	$("#drop-area").on('dragover', function (e){
	e.preventDefault();
	});

	$("#drop-area").on('drop', function (e){
	//$(this).css('background', '#D8F9D3');
	e.preventDefault();
	var image = e.originalEvent.dataTransfer.files;
	createFormData(image);
	});
});

function createFormData(image) {
	var formImage = new FormData();
	formImage.append('userImage', image[0]);
	uploadFormData(formImage);
}

function uploadFormData(formData) {
	$.ajax({
	url: "upload.php",
	type: "POST",
	data: formData,
	contentType:false,
	cache: false,
	processData: false,
	success: function(data){
		$('.boxed-image').show();
		// $('#original-image').html("Original Image");
		$('#original-image').html(data);
		$('#drop-area').hide();
		//$('#original-image').html("");
		filterImage("reset");

	}

});

}

function filterImage(filter){
	var img = $('.dropped-image').attr('src');
	var temphash = img.split("/");
	var hash = temphash[1].split(".")[0].split("_")[0];
	var type = temphash[1].split(".")[1].split("?")[0];

	var value = $('#progress-percentage').text();
	var intensity = value.replace("%","");

	var url = "imageprocessor.php?hash=" + hash + "&type=" + type.toLowerCase() + "&filter=" + filter + "&bintensity=" + intensity;
	console.log(url);
	//window.open(url,'_blank');
	$.ajax({
	url: url,
	type: "GET",
	contentType:false,
	cache: false,
	processData: false,
	success: function(data){
		$('.boxed-image').show();
		$('#edited-image').html(data);
	}
	});
}
</script>
</head>
<body>
<div class='container'>
<div class='col-md-6 boxed-image'>
<span id='original-image'><img src='http://sierrafire.cr.usgs.gov/images/loading.gif' width='300'></span>
</div>
<div class='col-md-6 boxed-image' style='border-left: 0px;'>
	<span id='edited-image'><img src='http://sierrafire.cr.usgs.gov/images/loading.gif' width='300'></span>
</div>
</div>
<div class='container'>
<div class="upload-drop-zone" id="drop-area">Or drag and drop files here</div>

<!-- <div id="drop-area"><h3 class="drop-text">Drag and Drop Images Here</h3></div>
 -->
 <div class='filters'>

 <div class='col-md-1 filter-button' onclick="filterImage('reset');" style='background-color:#bcbcbc'>
	Reset
 </div>
	
 <div class='col-md-1 filter-button' onclick="filterImage('blackwhite');" style='background-color:#000'>
 	BBW 
 </div>

<div class='col-md-1 filter-button' onclick="filterImage('smooth');" style='background-color:#444'>
	MILF
</div> 

  </div>
</div>

<div class='container'>
<div class='col-md-3'>
 	<div ng-controller="DemoCtrl">
    
    <div class="progress-wrapper">
      <progress-arc complete="progress" stroke="{{barColor}}"></progress-arc>
      <p class="progress-text" id='progress-percentage'>{{progress * 100 | number:0}}%</p>
    </div>
    
    <input type="range" class="control" min="0.00" max="1.00" step="0.05" ng-model="progress" />
    
  	</div>
  </div>
 <div class="col-md-3">
	
</div>

 <div class="col-md-3">
</div>
 </div>

 <div class="container">
 <div class="col-md-3">
   <button class='btn btn-primary' onclick="filterImage('bright');">Set Brightness</button>
  </div>
  </div>
</body>
</html>