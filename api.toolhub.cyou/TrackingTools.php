<?php
// Turn off all error reporting
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING);

header("Access-Control-Allow-Origin: *");

//if($_SERVER['HTTP_REFERER'] !== 'https://toolhub.cyou/' && $_SERVER['HTTP_REFERER'] !== 'https://www.toolhub.cyou/'){
//    //die('Unauthorized access');
//    die('');
//}

header('Content-type: application/json');

class TrackingTools
{
	public static function mozcredentials($arg)
	{
		switch($arg){
			case "1":
					return array(
							"accessID"=>"mozscape-f4263ccdcf",
							"secretKey"=>"9a0cc2da6e5b0392405bc3f5a0ed59b7"
						);
			break;
			case "2":
					return array(
							"accessID"=>"mozscape-ae48533118",
							"secretKey"=>"c5bd3141afbeb693249c971fee3bd2ce"
						);
			break;
			case "3":
					return array(
							"accessID"=>"mozscape-b006091f02",
							"secretKey"=>"cbf3d76a3efe7765bf74da43d95f60e8"
						);
			break;
			case "4":
					return array(
							"accessID"=>"mozscape-c4ad58c523",
							"secretKey"=>"9e9feddb76ec901cc5b60b8e494c12d3"
						);
			break;
			case "5":
					return array(
							"accessID"=>"mozscape-b11dc789a9",
							"secretKey"=>"a68a44ad242c14554891ed578776d1cd"
						);
			break;
		}
	}
	
	function AlexaRank($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$userInput);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			
			$xml=curl_exec($ch);

			if (!curl_errno($ch)) {
				$xml = new SimpleXMLElement($xml);
				
				$rank=isset($xml->SD[1]->POPULARITY)?$xml->SD[1]->POPULARITY->attributes()->TEXT:0;
				$web=(string)$xml->SD[0]->attributes()->HOST;
				//echo $web." has Alexa Rank ".$rank;
				$alexa = trim($rank);
				
				$alexa = isset($alexa) ? trim($alexa) : 'NA';
	
				echo '{"success":"true","result":{"domain":"'.$userInput.'","alexarank":"'.$alexa.'"}}';
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
			
			// finally, close the request
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function MozRank($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			// if (!apc_exists('mozapikeynumber')) {
				// $var = 1;
				// $key = 'mozapikeynumber';
				// apc_store($key, $var);
			// }
			// elseif (apc_exists('mozapikeynumber')) {
				// if(apc_fetch('mozapikeynumber') < 5)
				// {
					// apc_delete('mozapikeynumber');
					// apc_store('mozapikeynumber', 1);
				// }
				// else
				// {
					// apc_inc('mozapikeynumber');
				// }
			// }
			$x = TrackingTools::mozcredentials(rand(1 , 5)); //Range 1-5
	
			$accessID = $x["accessID"];
			$secretKey = $x["secretKey"];
			$expires = time() + 300;
			$stringToSign = $accessID."\n".$expires;
			$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
			$urlSafeSignature = urlencode(base64_encode($binarySignature));
			$objectURL = $userInput;

			//$PageAuthority = 34359738368; //upa
			//$DomainAuthority = 68719476736; //pda
			//$MozRank = 65536; //Root Domain : pmrp pmrr
			//$SubdomainSpamScore	= 67108864; //fspsc
			//$cols = ($PageAuthority + $DomainAuthority + $MozRank + $SubdomainSpamScore);
			$PageAuthority = 34359738368; //upa
			$DomainAuthority = 68719476736; //pda
			//$MozRank = 65536; //Root Domain : pmrp pmrr
			$MozRank = 16384; //Root Domain : umrp umrr
			$SubdomainSpamScore = 67108864; //fspsc
			$cols = ($PageAuthority + $DomainAuthority + $MozRank + $SubdomainSpamScore);
			
			$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;

			$options = array(
				CURLOPT_RETURNTRANSFER => true
				);
			$ch = curl_init($requestUrl);
			curl_setopt_array($ch, $options);
			$json = curl_exec($ch);
			//echo $json;
			if (!curl_errno($ch))
			{
				$jsonDecode = json_decode($json);
				$DA = strpos($json, 'pda') !== false ? $jsonDecode->pda : '-';
				$PA = strpos($json, 'upa') !== false ? $jsonDecode->upa : '-';
				$MOZ_RANK = strpos($json, 'umrp') !== false ? $jsonDecode->umrp : '-';
				
				echo '{"success":"true","result":{"domain":"'.$userInput.'","da":'.$DA.',"pa":"'.$PA.'","mozrank":"'.$MOZ_RANK.'"}}';
			}
			else
			{
				echo '{"success":"false","result":"something went wrong!"}';
			}
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}	
	
	function SocialShares($userInput)
	{
		if(isset($userInput) && !empty($userInput))
		{
			$baseUrl = 'https://free.sharedcount.com';
			$apikey = "fe20209bd473f8bf4a612efe08f802db978e5e65";
			$request = $baseUrl.'?apikey='.$apikey.'&url='.$userInput;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $request);
			$json = curl_exec($ch);		
			
			if (!curl_errno($ch))
			{
				if(strpos($json, '"Error"') === false)
					echo '{"success":"true","result":{"url":"'.$userInput.'","shares":'.preg_replace("/\s+/", "", $json).'}}';
				else
					echo '{"success":"false","result":"something went wrong!"}';
			}
			else
			{
				echo '{"success":"false","result":"something went wrong!"}';
			}
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function MalwareChecker($userInput)
	{
		if(isset($userInput) && !empty($userInput))
		{
			$request = 'https://sitecheck.sucuri.net/scanner/?scan='.$userInput.'&serialized&alfred';
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $request);
			$json = curl_exec($ch);		
			
			if (!curl_errno($ch))
			{
				if(strpos($json, '"BLACKLIST"') !== false)
				{
					$json = json_decode($json, true);
					$scanresults = $json["BLACKLIST"]["INFO"];
					echo '{"success":"true","result":{"url":"'.$userInput.'","results":'.json_encode($scanresults).'}}';
				}
				else
				{
					echo '{"success":"false","result":"something went wrong!"}';
				}
			}
			else
			{
				echo '{"success":"false","result":"something went wrong!"}';
			}
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function WWWRedirect($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $userInput);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch); // $response will contain all headers

			if (!curl_errno($ch)) {
				$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
				
				if($url !== "" && strpos($url, 'www.') !== false)	
					echo '{"success":"true","result":{"url":"'.$userInput.'","redirected":"true","redirectedurl":"'.$url.'"}}';
				else
					echo '{"success":"true","result":{"url":"'.$userInput.'","redirected":"false"}}';
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
			
			// finally, close the request
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function ServerStatus($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$start_time = microtime(true);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $userInput);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch); // $response will contain all headers
			//print_r($response);

			if (!curl_errno($ch)) {
				//$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				
				//$HttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				//$total_time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
				//$connect_time = curl_getinfo($ch, CURLINFO_CONNECT_TIME);
				//$namelookup_time = curl_getinfo($ch, CURLINFO_NAMELOOKUP_TIME);
				$end_time = microtime(true);
				$timeDiff = round(((float)$end_time - (float)$start_time), 3);
				
				echo '{"success":"true","result":{"url":"'.$userInput.'","statuscode":"'.$http_status.'","responsetime":"'.$timeDiff.'","status":"Online"}}';
			} else {
				echo '{"success":"true","result":{"url":"'.$userInput.'","statuscode":"-","responsetime":"-","status":"Offline"}}';
			}
			
			// finally, close the request
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function CheckGoogleCache($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$start_time = microtime(true);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://webcache.googleusercontent.com/search?q=cache:'.$userInput);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch); // $response will contain all headers
			//print_r($response);

			if (!curl_errno($ch)) {
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				
				if($http_status !== 404)
					echo '{"success":"true","result":{"url":"'.$userInput.'","googlecache":"true"}}';
				else 
					echo '{"success":"true","result":{"url":"'.$userInput.'","googlecache":"false"}}';
			} else {
				echo '{"success":"true","result":{"url":"'.$userInput.'","googlecache":"false"}}';
			}
			
			// finally, close the request
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function CheckGoogleIndex($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$start_time = microtime(true);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://webcache.googleusercontent.com/search?q=cache:'.$userInput);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch); // $response will contain all headers
			//print_r($response);

			if (!curl_errno($ch)) {
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				
				if($http_status !== 404)
					echo '{"success":"true","result":{"url":"'.$userInput.'","indexed":"true"}}';
				else 
					echo '{"success":"true","result":{"url":"'.$userInput.'","indexed":"false"}}';
			} else {
				echo '{"success":"true","result":{"url":"'.$userInput.'","indexed":"false"}}';
			}
			
			// finally, close the request
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function WebsitLinksCounter($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$pUrl = parse_url($userInput);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $userInput);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch); // $response will contain all headers
			//print_r($response);

			if (!curl_errno($ch)) {
				
				// Load the HTML into a DOMDocument
				$doc = new DOMDocument;
				@$doc->loadHTML($response);

				// Look for all the 'a' elements
				$links = $doc->getElementsByTagName('a');

				$numExternal = 0;
				$numInternal = 0;
				foreach ($links as $link) {

					// Exclude if not a link
					preg_match_all('/\S+/', strtolower($link->getAttribute('rel')), $rel);
					if (!$link->hasAttribute('href')) {
						continue;
					}

					// Exclude if internal link
					$href = $link->getAttribute('href');

					if (substr($href, 0, 2) === '//') {
						// Deal with protocol relative URLs as found on Wikipedia
						$href = $pUrl['scheme'] . ':' . $href;
					}

					$pHref = @parse_url($href);
					if (!$pHref || !isset($pHref['host']) || strtolower($pHref['host']) === strtolower($pUrl['host'])) {
						$numInternal++;
						continue;
					}

					// Increment counter otherwise
					//echo 'URL: ' . $link->getAttribute('href') . "\n";
					$numExternal++;
				}
				echo '{"success":"true","result":{"url":"'.$userInput.'","internal":"'.$numInternal.'","external":"'.$numExternal.'","total":"'.($numExternal+$numInternal).'"}}';
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
			
			// finally, close the request
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function DetectIpClass($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$arr = array("http://","https://","www.");
			$domain = str_replace($arr,"",$userInput);
			$ip = gethostbyname($domain);
			$ipparts = explode(" ",$ip);
			
			$class = '';
			if($ipparts[0] >= 0 && $ipparts[0] <= 127)
				$class = "A";
			elseif($ipparts[0] >= 128 && $ipparts[0] <= 191)
				$class = "B";
			elseif($ipparts[0] >= 192 && $ipparts[0] <= 223)
				$class = "C";
			elseif($ipparts[0] >= 224 && $ipparts[0] <= 239)
				$class = "D";
			elseif($ipparts[0] >= 240 && $ipparts[0] <= 255)
				$class = "E";
				
			echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","ip":"'.$ip.'","class":"'.$class.'"}}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function TextToCodeRatio($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();
			curl_setopt_array($ch, [
				CURLOPT_URL => 'http://beautifytools.com/text-to-code-ratio.php',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => 'url='.urlencode($userInput),
			]);

			$json = curl_exec($ch);
			
			if (!curl_errno($ch)) {
				
				//{"page_size":149059,"text_size":44697,"code_size":104362,"text_to_code_ratio":"29.99"}
				$page_size = '-';
				$text_size = '-';
				$code_size = '-';
				$text_to_code_ratio = '-';
				
				if(strpos($json, '"page_size"') !== false && strpos($json, '"text_size"') !== false){
					
					$json = json_decode($json, true);
					
					$page_size = $json["page_size"];
					$text_size = $json["text_size"];
					$code_size = $json["code_size"];
					$text_to_code_ratio = $json["text_to_code_ratio"];
					
					echo '{"success":"true","result":{"url":"'.$userInput.'","pagesize":"'.$page_size.' bytes","textsize":"'.$text_size.' bytes","codesize":"'.$code_size.' bytes","ratio":"'.$text_to_code_ratio.' %"}}';
				}
				else{
					echo '{"success":"true","result":{"url":"'.$userInput.'","pagesize":"'.$page_size.'","textsize":"'.$text_size.'","codesize":"'.$code_size.'","ratio":"'.$text_to_code_ratio.'"}}';
				}
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
			
			// finally, close the request
			curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
}

if(isset($_GET['query']) && $_GET['query'] != '')
{
	if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'alexarank')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->AlexaRank($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'mozrank')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->MozRank($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'socialshares')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->SocialShares($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'malwarechecker')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->MalwareChecker($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'wwwredirect')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->WWWRedirect($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'serverstatus')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->ServerStatus($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'checkgooglecache')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->CheckGoogleCache($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'checkgoogleindex')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->CheckGoogleIndex($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'websitlinkscounter')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->WebsitLinksCounter($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'detectipclass')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->DetectIpClass($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'texttocoderatio')
	{
		$trackingtools = new TrackingTools();
		$trackingtools->TextToCodeRatio($_GET['query']);
	}
}

?>