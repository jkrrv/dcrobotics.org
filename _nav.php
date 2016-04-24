<?php



if (!isset($csv)) {
	$csv;
	$row = 1;
	if (($handle = fopen($serverRoot . "nav.csv", "r")) !== false) {
		while (($data = fgetcsv($handle, 1000, ",")) !== false) {
			$num = count($data);
			for ($c=0; $c < $num; $c++) {
				$csv[$row][$c] = $data[$c];
			}
			$row++;
		}
		fclose($handle);
	}
}

for ($i=1; $i<=count($csv); $i++) {
	switch ($csv[$i][0]) {
	 case 0:
		echo $formatter[0][0] . $baseHref . "/" . $csv[$i][2] . $formatter[0][1] . $csv[$i][4] . $formatter[0][2] . $csv[$i][1] . $formatter[0][3];
	 break;
	 case 1:
		echo $formatter[1][0] . $baseHref . "/" . $csv[$i][2] . $formatter[1][1] . $csv[$i][4] . $formatter[1][2] . $csv[$i][1] . $formatter[1][3]; 
	}
	if ($csv[$i+1][0] < 1) {
		echo $formatter[0][4];
	}
}


?>
