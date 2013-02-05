<?php

include("random-user-agent.php");

$ip = '127.0.0.1';
$port = '9050';
$auth = 'PASSWORD';
$command = 'signal NEWNYM';

$fp = fsockopen($ip,$port,$error_number,$err_string,10);
if(!$fp) { echo "ERROR: $error_number : $err_string";
    return false;
} else {
    fwrite($fp,"AUTHENTICATE \"".$auth."\"\n");
    $received = fread($fp,512);
    fwrite($fp,$command."\n");
    $received = fread($fp,512);
}
 
fclose($fp);
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://kidswhogive.com/wp_kwg/wp-content/themes/custom/voteWork.php");
curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:9050");
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, "submissionId=156");

for ($i = 0; $i < 1000000000000; $i++) {
	curl_setopt($ch, CURLOPT_USERAGENT, random_user_agent());
	$response = curl_exec($ch);
	echo "finished one request";
	sleep(rand(1, 5));
}

//echo $response;
?>
