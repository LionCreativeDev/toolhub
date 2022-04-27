<?php

// Start the session
session_start();

function mozcredentials($arg)
{
	switch ($arg) {
		case "1":
			return array(
				"accessID" => "mozscape-f4263ccdcf",
				"secretKey" => "9a0cc2da6e5b0392405bc3f5a0ed59b7"
			);
			break;
		case "2":
			return array(
				"accessID" => "mozscape-ae48533118",
				"secretKey" => "c5bd3141afbeb693249c971fee3bd2ce"
			);
			break;
		case "3":
			return array(
				"accessID" => "mozscape-b006091f02",
				"secretKey" => "cbf3d76a3efe7765bf74da43d95f60e8"
			);
			break;
		case "4":
			return array(
				"accessID" => "mozscape-c4ad58c523",
				"secretKey" => "9e9feddb76ec901cc5b60b8e494c12d3"
			);
			break;
		case "5":
			return array(
				"accessID" => "mozscape-b11dc789a9",
				"secretKey" => "a68a44ad242c14554891ed578776d1cd"
			);
			break;
			
		case "6":
			return array(
				"accessID" => "mozscape-edb9ba93a0",
				"secretKey" => "19ef30cea316fa87f7ac5e630fef8852"
			);
			break;
		case "7":
			return array(
				"accessID" => "mozscape-b7697f29f4",
				"secretKey" => "ebe3c682b7d7e3c5b49d8012b0e56a72"
			);
			break;
		case "8":
			return array(
				"accessID" => "mozscape-7cf69efa97",
				"secretKey" => "3d436b65ce2d2514b00e512f82d3fe7e"
			);
			break;
		case "9":
			return array(
				"accessID" => "mozscape-a59031b32d",
				"secretKey" => "e8077b8381efd1685274b10baf09be5d"
			);
			break;
		case "10":
			return array(
				"accessID" => "mozscape-a2b9fabe64",
				"secretKey" => "67b3b603baf5ca4eaedc2dc5311e19c2"
			);
			break;
		case "11":
			return array(
				"accessID" => "mozscape-98806d16ac",
				"secretKey" => "6ee187e360cd945a60cf5d45f01bc84e"
			);
			break;
	}
}

function GetMoz(&$cycle, &$DA, &$PA, &$MOZ_RANK, &$IP, $checkurl)
{
	$cycle = $_SESSION['apikey'];
	// Get your access id and secret key here: https://moz.com/products/api/keys

	//To get Random Api key
	//$x = mozcredentials(rand(1, 17)); //Range 1-17
	
	//To get 1 0f 17 api for each url
	$x = mozcredentials($_SESSION['apikey']);
	//echo $x["accessID"].'<br/>';
	//echo $x["secretKey"].'<br/>';

	$accessID = $x["accessID"];
	$secretKey = $x["secretKey"];
	// Set your expires times for several minutes into the future.
	// An expires time excessively far in the future will not be honored by the Mozscape API.
	$expires = time() + 300;
	// Put each parameter on a new line.
	$stringToSign = $accessID . "\n" . $expires;
	// Get the "raw" or binary output of the hmac hash.
	$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
	// Base64-encode it and then url-encode that.
	$urlSafeSignature = urlencode(base64_encode($binarySignature));
	// Specify the URL that you want link metrics for.
	$objectURL = $checkurl;
	// Add up all the bit flags you want returned.
	// Learn more here: https://moz.com/help/guides/moz-api/mozscape/api-reference/url-metrics
	
	//For Parameters
	//https://moz.com/help/links-api/making-calls/url-metrics
	$PageAuthority = 34359738368; //upa
	$DomainAuthority = 68719476736; //pda
	//$MozRank = 65536; //Root Domain : pmrp pmrr
	$MozRank = 16384; //Root Domain : umrp umrr
	$SubdomainSpamScore = 67108864; //fspsc
	$cols = ($PageAuthority + $DomainAuthority + $MozRank + $SubdomainSpamScore);
	
	// Put it all together and you get your request URL.
	// This example uses the Mozscape URL Metrics API.
	$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/" . urlencode($objectURL) . "?Cols=" . $cols . "&AccessID=" . $accessID . "&Expires=" . $expires . "&Signature=" . $urlSafeSignature;
	// Use Curl to send off your request.
	$options = array(
		CURLOPT_RETURNTRANSFER => true
	);
	$ch = curl_init($requestUrl);
	curl_setopt_array($ch, $options);
	$json = curl_exec($ch);
	
	if (!curl_errno($ch)) {
		if (isset($json)) {
			//var_dump($json);
			//exit();
			$jsonDecode = json_decode($json);
			//var_dump($jsonDecode);
			$DA = isset($jsonDecode->pda) ? $jsonDecode->pda : '-';
			$PA = isset($jsonDecode->upa) ? $jsonDecode->upa : '-';
			$MOZ_RANK = isset($jsonDecode->umrp) ? $jsonDecode->umrp : '-';
			//$Spam_Score = $jsonDecode->fspsc;
			
			//sleep(11);	// We waited 11 seconds (delay required for the Moz API with free account)
			$domain = parse_url('http://' . str_replace(array('https://', 'http://','www.'), '', $checkurl), PHP_URL_HOST);
			$IP = gethostbyname($domain);
		}
	}
	else{
		//$DA = "- accessID ".$accessID." secretKey ".$secretKey;
		$DA = "-";
		$PA = "-";
		$MOZ_RANK = "-";
	}
	curl_close($ch);
}

$cycle = '';
$DA = ''; //pda
$PA = ''; //upa
$MOZ_RANK = ''; //pmrp
//$Spam_Score = ''; //fspsc
$IP = '';

if (isset($_GET["url"])) {
	
	if (!isset($_SESSION['apikey']) || $_SESSION['apikey'] == '')
	{
		$_SESSION['apikey'] = 1;
	}
	elseif (isset($_SESSION['apikey']) && $_SESSION['apikey'] >= '12')
	{
		$_SESSION['apikey'] = 1;
	}
	
	$checkurl = trim($_GET["url"]);
	GetMoz($cycle, $DA, $PA, $MOZ_RANK, $IP, $checkurl);
	
	//sleep 1 second to for free moz api
	sleep(1);
	
	echo '{"cycle":"'.$cycle.'","url":"'.$checkurl.'","DA":"'.$DA.'","PA":"'.$PA.'","MOZRANK":"'.$MOZ_RANK.'","IP":"'.$IP.'"}';
	
	if(isset($_SESSION['apikey']))
	{
		$temp = $_SESSION['apikey'];
		$temp = $temp+1;
		$_SESSION['apikey'] = $temp;
	}
}
?>