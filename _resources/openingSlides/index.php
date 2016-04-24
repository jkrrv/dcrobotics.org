<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Slideshow Page</title>
<meta http-equiv="X-UA-Compatible" content="IE=8" />

<style type="text/css">
img {
  border:0;
}

body {
  font-family:'Trebuchet MS',Verdana;
  padding:0;
  margin:0;
}
</style>



<script type="text/javascript">
//<![CDATA[
var slideHeight=200;
var slideStepTime=26; //26
var slideChangeIncrement=4; //5
var slideChangeRate=40; //40
var slideChangePoint=21;
var slideAnchorDelay=600;
var slidesThroughBlack=true;
if (navigator.appName=="Microsoft Internet Explorer") {
	slidesThroughBlack=false;
}
var slidesRelUrl="";

var slideContent = <?php 
	echo "[";
	$row = 1;
	if (($handle = fopen($serverRoot . "slidesIndex.csv", "r")) !== false) {
		while (($data = fgetcsv($handle, 1000, "|")) !== false) {
			if ($row<>1) {
				echo ",";
			}
			echo "[\"";
			$num = count($data);
			for ($c=0; $c < $num; $c++) {
				if ($c<>0) {
					echo "\",\"";
				}
				echo $data[$c];
			}
			if ($row==1) {
				$slideInitial=$data[1];
			}
			$row++;
			echo "\"]";
		}
		fclose($handle);
	}
	echo "]";

?>;
//]]>
</script>

<script type="text/javascript" src="slideshow.js"></script>

</head>
<body onload="slidesOnLoad();">

<img src="<?php echo $slideInitial; ?>" alt="" style="display:none;" /> <!--forces onload (which starts slides moving) to wait until first image loads-->

<div id="slides" style="position:relative; margin:0; height:200px; width:960px; background-color:#000;" onmouseover="document.getElementById('slidesControl').style.display='block'; document.getElementById('slidesNavigator').style.display='block';" onmouseout="slidesMouseOut();">
	<div title="" id="slidesA" style="position:absolute; height:200px; width:100%; opacity:1; filter:alpha(opacity=100); margin:0 auto; border:0; background:url('<?php echo $slideInitial; ?>');"></div>
	<div title="" id="slidesB" style="position:absolute; height:200px; width:100%; opacity:0; filter:alpha(opacity=0);   margin:0 auto; border:0;"></div>
	<img src="<?php echo $slidesRelUrl; ?>clear.gif" alt="" id="slidesCountdown" height="250" style="width:20px; background-color:#999; position:absolute; bottom:0px; top:auto; right:0px; overflow:hidden; opacity:.6; filter:alpha(opacity=60); border:0px;" />
	<img src="<?php echo $slidesRelUrl; ?>clear.gif" alt="" style="width:100%; height:100%; Position:absolute; margin:0; overflow:hidden; border:0;" usemap="#slidesImageMap" />
	<div id="slidesNavigator" style="height:16px; display:none; position:absolute; bottom:0px; right:84px; top:auto; overflow:hidden; padding:2px; background-image:url('<?php echo $slidesRelUrl; ?>gry.png'); "></div>
	<div id="slidesControl" style="height:16px; display:none; position:absolute; bottom:0px; right:21px; top:auto; overflow:hidden; padding:2px; background-image:url('<?php echo $slidesRelUrl; ?>gry.png'); ">
		<a href="javascript:;" onclick="slideCommand('-');">	<img src="<?php echo $slidesRelUrl; ?>clear.gif" id="slidesBtnPrev" title="Previous" alt="|&lt;" 	onmouseover="changeOpacity(this,1);" onmouseout="changeOpacity(this,.6);" style="width:16px; height:16px; background:url(<?php echo $slidesRelUrl; ?>slideControlButtons.png) -34px 0; opacity:.6; filter:alpha(opacity=60); " /></a>
		<a href="javascript:;" onclick="slides();">		<img src="<?php echo $slidesRelUrl; ?>clear.gif" id="slidesBtnPlay" title="Pause" alt="||"		onmouseover="changeOpacity(this,1);" onmouseout="changeOpacity(this,.6);" style="width:16px; height:16px; background:url(<?php echo $slidesRelUrl; ?>slideControlButtons.png) -17px 0; opacity:.6; filter:alpha(opacity=60); " /></a>
		<a href="javascript:;" onclick="slideCommand('+');">	<img src="<?php echo $slidesRelUrl; ?>clear.gif" id="slidesBtnNext" title="Next" alt=">|" 		onmouseover="changeOpacity(this,1);" onmouseout="changeOpacity(this,.6);" style="width:16px; height:16px; background:url(<?php echo $slidesRelUrl; ?>slideControlButtons.png) -51px 0; opacity:.6; filter:alpha(opacity=60); " /></a>
	</div>
<map name="slidesImageMap" id="slidesImageMap">
<area alt="" />
</map>

<script type="text/javascript"></script>
</div>

</body>
</html>




