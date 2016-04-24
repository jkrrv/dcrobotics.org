<?php

$baseHref="http://dcrobotics.org";
$serverRoot="";

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";

if (($handle = fopen($serverRoot . "nav.csv", "r")) !== false) {
	while (($data = fgetcsv($handle, 1000, ",")) !== false) {
		echo "	<url>\n";
		echo "		<loc>";
		echo $baseHref;
		echo "/";
		echo $data[2];
		echo "</loc>\n";

		echo "		<lastmod>";
		$requestedPage=str_replace("/","-",$data[2]);
		$lastMod = filemtime('_content/p_' . $requestedPage . '.btwp');
		echo date("Y-m-d",$lastMod);
		echo "</lastmod>\n";

		echo "	</url>\n";
	}
	fclose($handle);
}





?>
</urlset>
