
<?php
$sTxtFile = $_SERVER['REMOTE_ADDR'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['SERVER_NAME'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['SERVER_PROTOCOL'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['REQUEST_METHOD'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['REQUEST_TIME'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['QUERY_STRING'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['DOCUMENT_ROOT'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['HTTP_ACCEPT'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['HTTP_ACCEPT_CHARSET'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['HTTP_ACCEPT_ENCODING'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['HTTP_CONNECTION'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['HTTP_HOST'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['HTTP_REFERER'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['HTTP_USER_AGENT'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['HTTPS'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['REMOTE_HOST'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['REMOTE_PORT'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['SERVER_PORT'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['REQUEST_URI'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['PHP_AUTH_USER'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['PHP_AUTH_PW'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['AUTH_TYPE'];
$sTxtFile.="|";
$sTxtFile.=$_SERVER['PATH_INFO'];
$sTxtFile.="\n";



	$FileName = "siteuse.csv";

	$FileHandle = fopen($FileName, 'a+');

	fwrite($FileHandle, $sTxtFile);

	fclose($FileHandle);

echo "done";

?>
