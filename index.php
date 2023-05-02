<?php
if (array_key_exists('refresh',$_GET)){
	$img = imagecreatefrompng("template.png");
	// (A) CALCULATE TIME REMAINING
	$currentTimestamp= date('U');
	$expirationTimestamp=strtotime(date("Y-m-t", strtotime(date('u'))) . " 11:59 PM");
	$remainingTime = ($expirationTimestamp - $currentTimestamp)/60/60/24; //days
	$days = floor($remainingTime);
	$hours=floor($remainingTime*24-$days*24);
	$minutes=floor($remainingTime*24*60-$days*24-$hours*60);
	$seconds=floor($remainingTime*24*60*60-$days*24-$hours*60);
	if ($days<1){
		$expDateLbl= "Expires 11:59 PM Tomorrow";
		$remainingTimeLbl = $hours . " hrs " . $minutes . " mins";
		if ($hours<1){
			$remainingTimeLbl = $minutes . " mins " . $seconds . " sec";
		}
	}else{
		$expDateLbl="Expires " . date("g:i A, M j", strtotime(date("Y-m-t", strtotime(date('u'))) . " 11:59 PM"));
		$remainingTimeLbl = $days . " days " . $hours . " hrs";
	}
	//echo $expDateLbl. "<BR>";
	//echo $remainingTimeLbl. "<BR>";

	// (B) TEXT & FONT SETTINGS
	$txt = "Hello World";
	$fontFile = "./Roboto-Medium.ttf"; // CHANGE TO YOUR OWN!
	$fontFile2 = "./Roboto-Regular.ttf"; // CHANGE TO YOUR OWN!
	$fontSize = 26;
	$fontSize2 = 17;
	$fontColor = imagecolorallocate($img, 255, 255, 255);
	$fontColor2 = imagecolorallocate($img, 151, 151, 151);
	$angle = 0;

	// (D) DRAW TEXT ON IMAGE
	imagettftext($img, $fontSize, $angle, 60, 406, $fontColor, $fontFile, $remainingTimeLbl);
	imagettftext($img, $fontSize2, $angle, 60, 440, $fontColor2, $fontFile2, $expDateLbl);
	 
	// (E) OUTPUT IMAGE
	imagejpeg($img, "edit.jpg", 100);
}
?>
<img style="width:100%;height:100%" id="img" src="edit.jpg">
<script>
var d= setInterval(function(){
    img=document.getElementById('img');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var t= new Date().getTime();
			img.src="edit.jpg?t="+ t;
		}
	};
	xhttp.open("GET", "?refresh=true", true);
	xhttp.send();
	
},1000);
</script>