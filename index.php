?php

$noNav=false;

require('_top.php') ;

$realRequestedPage = str_replace("/","-",$_GET['requestedPage']);

if (file_exists('_content/p_' . $realRequestedPage . '.btwp')) {
	include('_content/p_' . $realRequestedPage . '.btwp') ;
	$lastMod = filemtime('_content/p_' . $realRequestedPage . '.btwp');
	echo "<span id=\"lastModified\">Last Modified on ";
	echo date("D M j, Y g:i:s A e", $lastMod);
	echo "</span>";
} else {
	include('_content/404.btwe') ;
}




require('_bottom.php') ;

?>
