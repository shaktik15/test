 <?php
require __DIR__ . '/vendor/autoload.php';
$rsa = new \phpseclib\Crypt\RSA();
 try{	
	

	$plaintext = 'KBQ7tV7Y43';

    $url = 'https://apiv2.sirved.com/temp/temp';
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$headers = [						    
	    'Cache-Control: no-cache',
	    'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
	    'Content-Length: 0',
	    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
	    'X-MicrosoftAjax: Delta=true'				   
	];

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$abResponse = curl_exec ($ch);

	curl_close ($ch);
	$arrAB = json_decode($abResponse,true); 
	$a = $arrAB['a'];
	$b = $arrAB['b'];
		
	$currTime = time();
	$thisTimeStamp = $currTime - $a - $b; 
	$newText = $plaintext . '.' . $currTime. '.' . $thisTimeStamp;

	$rsa->setEncryptionMode(phpseclib\Crypt\RSA::ENCRYPTION_PKCS1);
	$publicKey = file_get_contents(realpath('public_key'));
	$rsa->loadKey($publicKey);
	$apiKey = base64_encode($rsa->encrypt($newText));
	echo $apiKey;exit;

 }catch(Exception $ex){
 	print_r($ex->getMessage());exit;
 }
?>