<?php

if( empty($_GET['url']) ){
	echo '{TOR_ERROR}';
	die();
}


// REFRESH
if( ! empty($_GET['renew']) && $_GET['renew'] == '1' ){
	$ip = '127.0.0.1';
	$port = '9051';
	$auth = 'tor_auth_key';
	$command = 'signal NEWNYM';

	$fp = fsockopen($ip,$port,$error_number,$err_string,10);

	if( ! $fp ){
		echo '{TOR_ERROR}';
		die();
	}

	fwrite($fp, "AUTHENTICATE \"".$auth."\"\n");
	$received = fread($fp,512);

	fwrite($fp,$command."\n");
	$received = fread($fp,512);

	// TOR IP renew is slow
	sleep(1);
}

// REQUEST

$url = base64_decode($_GET['url']);

$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';


// get_url
$html = shell_exec('curl -A "'. $agent .'" --proxy http://127.0.0.1:8118 --silent "' . $url . '"');

echo $html;