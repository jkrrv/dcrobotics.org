<?php

echo "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";


$baseHref="http://dcrobotics.org";
$serverRoot="";
$siteName="DC Robotics";

$formatter = 	array(array(	"		<div class=\"navCol\">\n			<a href=\"",
				"\" class=\"nav ", "\"><span class=\"navP\">",
				"</span></a><br />\n",
				"		</div>\n"
		),array(	"			<a href=\"",
				"\" class=\"nav ", "\"><span class=\"nav2\">",
				"</span></a><br />\n",
				"		</div>\n"
		),9 => array(	"		<div class=\"navColR\">\n			<a href=\"",
				"\" class=\"nav ", "\"><span class=\"navP\">",
				"</span></a><br />\n",
				"		</div><div style=\"background-image:url('" . $baseHref . "navDivid.png'); float:right; width:1px; height:25px;\" ></div>\n"
		));

?>

<?php

if (!isset($csv)) {
	$csv;
	$row = 1;
	if (($handle = fopen($serverRoot . "nav.csv", "r"))) {
		while (($data = fgetcsv($handle, 1000, ","))) {
			$num = count($data);
			for ($c=0; $c < $num; $c++) {
				$csv[$row][$c] = $data[$c];
			}
			$row++;
		}
		fclose($handle);
	}
}

?>

<!-- Source Code (c) Copyright 2008 - <?php echo date("Y"); ?>  James Kurtz ('11) -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<!-- to make IE do as it should: -->
<meta http-equiv="X-UA-Compatible" content="IE=8" />

<?php 
echo "<title>";  // location determination and title bar

$pageLoc=substr($_SERVER['SCRIPT_FILENAME'],strlen($serverRoot));

if (strstr($pageLoc,".php")) {
	$pageLoc=substr($pageLoc,0,strpos($pageLoc,".php"));
}
if (strstr($pageLoc,"index")) {
	$pageLoc=substr($pageLoc,0,strpos($pageLoc,"index"));
}
if (strstr($pageLoc,"/")) {
	$pageLoc=substr($pageLoc,0,strpos($pageLoc,"/"));
}
if ($pageLoc=="edit") {
	echo $siteName . " | Editor";
	$pageLoc=0;
} else {
	$row = 1;
	while ($csv[$row][2] !== $pageLoc) {
		$row++;
	}
	echo $csv[$row][3];
	$pageLoc=$row;
}


echo "</title>";

?>

<script type="text/javascript">
//<![CDATA[
if (location.hash.substring(1)!="") {
	if (!!(window.history && window.history.pushState)) {
		location.href="<?php echo $baseHref; ?>/"+location.hash.substring(1);
	} else {
		location.href="<?php echo $baseHref; ?>#"+location.hash.substring(1);
	}
}

window.onload = function() {
	if (location.hash!="") {
		setTimeout("loadNewPage(location.hash.substring(1))",1);
	}
	prepLinks();
}

function prepLinks() {
	var lnks = document.links;
	if (lnks) {
		for (var i = 0; i < lnks.length; ++i) {
			if (lnks[i].className.indexOf('_noajax')==-1 && (lnks[i].onclick=="" || lnks[i].onclick==null) && lnks[i].href.indexOf('mailto:')==-1) {
				lnks[i].onclick = linkOnClick;
			}
		}
	}
}

function linkOnClick()
{
	var h = this.href;
	var c = this.className;
	var siteName = "DC Robotics";
	if (c.indexOf('_confirm') != -1) { // has class _confirm (to confirm desire to go to new page)
		if (!confirm("This page is not controlled by <?php echo $siteName; ?>. \n\nContinue?")) {
			return false;
		}
	}
	if (c.indexOf('_blank') != -1) { // has class _blank (to get around XHTML Strict lack of target)
		window.open(h);
		return false;
	}
	if (c.indexOf('_parent') != -1) { // has class _parent (to get around XHTML Strict lack of target)
		return true;
	}
	if (h.indexOf('.') == -1) { // no domains, no extensions, assume ajax
		loadNewPage(h);
		return false;
	}
	if (h.indexOf("<?php echo $baseHref; ?>") != -1) { // links to something on the site
		if (h.substring("<?php echo $baseHref; ?>".length + h.indexOf("<?php echo $baseHref; ?>")).indexOf('.')==-1 && h.replace(/[^\.]/g,'').length == "<?php echo $baseHref; ?>".replace(/[^\.]/g,'').length) { //same domain, no extensions
			if (!!(window.history && window.history.pushState)) {
				window.history.pushState('Object', 'Title', '/'+h.substring("<?php echo $baseHref; ?>".length + h.indexOf("<?php echo $baseHref; ?>")));
			} else {
				if (location.pathname=="" || location.pathname=="/") {
					location.hash=h.substring("<?php echo $baseHref; ?>".length + 1);
				} else {
					if(h.substring("<?php echo $baseHref; ?>".length + 1)=="") {
						location.href="<?php echo $baseHref; ?>";
					} else {
						location.href="<?php echo $baseHref; ?>#"+h.substring("<?php echo $baseHref; ?>".length + 1);
					}
				}
			}
			loadNewPage(h.substring("<?php echo $baseHref; ?>".length+1));
			return false;
		}
		if (h.substring("<?php echo $baseHref; ?>".length + h.indexOf("<?php echo $baseHref; ?>")).indexOf('.')==-1) { // internal URL, different domain
			return true;
		}  // internal URL, with extension
		return true;
	}
	return true;
}

function loadNewPage(h) {
	clearTimeout('slidesTimer');
	document.getElementById('corset').innerHTML="<span style='align:center; width:100%;'>Loading...</span>"
	if (window.XMLHttpRequest) {  // for decent browsers
		ajax=new XMLHttpRequest();
	} else { //for old Microsoft browsers
		ajax=new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajax.onreadystatechange=function() {
		document.getElementById('top').style.display="block";
		if (ajax.readyState==1) {
			document.getElementById('corset').innerHTML="Loading... <br />Server Contacted";
		} else if (ajax.readyState==2) {
			document.getElementById('corset').innerHTML="Loading... <br />Request Received";
		} else if (ajax.readyState==3) {
			document.getElementById('corset').innerHTML="Loading... <br />Processing Request";
			prepLinks();
		} else if (ajax.readyState==4 && ajax.status==200) {
			document.getElementById('corset').innerHTML=ajax.responseText;
			prepLinks();
		} else if (ajax.readyState==4 && ajax.status==404) {
			document.getElementById('corset').innerHTML="We looked everywhere, but couldn't find the content you requested.";
		}
	}
	h = h.replace("/","-");
	ajax.open("GET","_content/p_" + h + ".btwp",true);
	ajax.send();
}

//]]>
</script>

<link rel="SHORTCUT ICON" href="<?php echo $baseHref; ?>/_formatting/dcrobotics.ico" />

<style type="text/css">@import url('<?php echo $baseHref; ?>/_style.css');</style>

<?php
if ($pageLoc==0) {

include $serverRoot . '_editor/head.txt';

}
?>

</head>
<body>
<div id="greenThing"> <!-- green frame -->
	<div style="width:960px; height:120px; margin:0 auto 0 auto; background-image:url(<?php echo $baseHref; ?>/_formatting/top.jpg)" id="top" class="dontPrint">
		<!--<img src="<?php echo $baseHref; ?>/_formatting/logo.png" alt="DC Robotics" style="position:relative; border:none; height:215px; top:-13px; left:0;" />-->
	</div>
	<div style="width:97%; text-align:center;"  class="onlyPrint">
		<img src="<?php echo $baseHref; ?>/_formatting/logo-print.png" alt="DC Robotics" style="height:150px; margin:0;" />
	</div>
	<div style="width:880px; height:25px; background-image:url('<?php echo $baseHref; ?>/_formatting/nav.png'); margin:0 auto 0 auto; padding:0 40px 0 40px;" id="nav" class="dontPrint" >

<?php 

		echo "<div style=\"background-image:url('" . $baseHref . "/_formatting/navDivid.png'); float:left; width:1px; height:25px;\" ></div><!-- first nav divider line.  Others handled by background in nav -->";






if ($pageLoc!==0) {
	include $serverRoot . '_nav.php';
} else {
	// bypass _nav.php (and thus ignore CSV)
	echo $formatter[0][0] . $baseHref . "/edit#" . $formatter[0][1] . "Site Editor" . $formatter[0][2];
	echo $formatter[1][0] . $baseHref . "/edit?editor=docmgr" . $formatter[1][1] . "Documents" . $formatter[1][2];
	echo $formatter[0][3];
	echo $formatter[9][0] . $baseHref . "/edit?do=account" . $formatter[9][1] . $_REQUEST["ufname"] . "&nbsp;" . $_REQUEST["ulname"] . $formatter[9][2];
	echo $formatter[1][0] . $baseHref . "/edit?do=account" . $formatter[1][1] . "My Account" . $formatter[1][2];
	echo $formatter[1][0] . $baseHref . "/?do=logout" . $formatter[1][1] . "Logout" . $formatter[1][2];
	echo $formatter[9][3];
}

	


unset($csv);

?>



	</div>


	<div id="corset"> <!-- 	yellowish body box -->
