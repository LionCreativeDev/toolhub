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

class IPTools
{
	function VisitorIP()
    {
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
			$ip = $client;
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
			$ip = $forward;
		else
			$ip = $remote;
		
		if($ip !== ""){
			if($ip !== "::1")
				echo '{"success":"true","result":{"ip":"'.$ip.'"}}';
			elseif($ip === "::1")
				echo '{"success":"true","result":{"ip":"localhost"}}';
		}
		else
		{
			echo '{"success":"false","result":"something went wrong!"}';
		}
	}
	
	function VisitorLocation()
    {
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
			$ip = $client;
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
			$ip = $forward;
		else
			$ip = $remote;
		//$ip = '23.254.164.114';
		
		if($ip !== "")
		{
			if($ip !== "::1")
			{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://ip-api.com/json/'.$ip);
				//curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($ch); // $response will contain all headers
				//print_r($response);

				if (!curl_errno($ch)) 
				{
					if($response !== "" && strpos($response, '"status":"success"') !== false){
						
						$json = json_decode($response, true);
						
						echo '{"success":"true","result":{"ip":"'.$ip.'","location":"'.$json["city"].', '.$json["regionName"].', '.$json["country"].'"}}';
					}
					else
					{
						echo '{"success":"true","result":{"ip":"'.$ip.'","location":"-"}}';
					}
				}
				else
				{
					echo '{"success":"false","result":"something went wrong!"}';
				}
				
				// finally, close the request
				curl_close($ch);
			}
			elseif($ip === "::1")
			{
				echo '{"success":"true","result":{"ip":"localhost","location":"-"}}';
			}
		}
		else
		{
			echo '{"success":"false","result":"something went wrong!"}';
		}
	}
	
	function CheckBlacklist($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$arr = array("http://","https://","www.");
			$domain = str_replace($arr,"",$userInput);
			
			$path = explode('/', $domain);
            $domain = $path[0];
			
			$data = array('url' => urlencode($domain), 'submit' => 'Submit');
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://seotoolstation.com/blacklist-lookup/output');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

			$headers = array();
			$headers[] = 'Connection: keep-alive';
			$headers[] = 'Cache-Control: max-age=0';
			$headers[] = 'Upgrade-Insecure-Requests: 1';
			$headers[] = 'Origin: https://seotoolstation.com';
			$headers[] = 'Content-Type: application/x-www-form-urlencoded';
			$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36';
			$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
			$headers[] = 'Sec-Fetch-Site: same-origin';
			$headers[] = 'Sec-Fetch-Mode: navigate';
			$headers[] = 'Sec-Fetch-User: ?1';
			$headers[] = 'Sec-Fetch-Dest: document';
			$headers[] = 'Referer: https://seotoolstation.com/blacklist-lookup';
			$headers[] = 'Accept-Language: en-US,en;q=0.9';
			$headers[] = 'Cookie: PHPSESSID=d6319af51df88bb96f4c3efcea8d23da';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			
			if (!curl_errno($ch)) 
			{
				$result = str_replace('class="table table-hover table-bordered table-striped"','class="table table-hover table-bordered table-striped" id="mytable"',$result);
				$doc = new DOMDocument;
				@$doc->loadHTML($result);
				
				$thirdTable = $doc->getElementsByTagName('table')->item(1);
				
				$data = array();
				// iterate over each row in the table
				foreach($thirdTable->getElementsByTagName('tr') as $tr)
				{
					$tds = $tr->getElementsByTagName('td'); // get the columns in this row					
					//echo $tds->item(1)->nodeValue; // B
					//echo $tds->item(2)->nodeValue; // C
					$data[] = array($tds->item(1)->nodeValue => $tds->item(2)->nodeValue);
				}
				
				echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","list":'.json_encode($data).'}}';
			}
			else
			{
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
	
	function CheckWhois($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			require_once('libs/whois.php');
			
			$arr = array("http://","https://");
			$domain = str_replace($arr,"",$userInput);
			
			$whois = new whois();
			$result = $whois->whoislookup($domain);
			if($result !== "" && strpos($result, 'Error: ') === false){
				echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","whois":'.json_encode($result).'}}';
			}
			else{
				echo '{"success":"false","result":"something went wrong!"}';
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	// function DomainAvailability($userInput)
    // {
		// if(isset($userInput) && !empty($userInput))
		// {
			// require_once('libs/DomainAvailability.php');
			
			// $arr = array("http://","https://","www.");
			// $domain = str_replace($arr,"",$userInput);
			
			// $domainavailability = new DomainAvailability();
			// $result = $domainavailability->isAvailable($domain);
			// if($result !== "" && strpos($result, 'Error: ') === false){
				// echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","is-available":"'.json_encode($result).'"}}';
			// }
			// else{
				// echo '{"success":"false","result":"something went wrong!"}';
			// }
		// }
		// else
		// {
			// echo '{"success":"false","result":"please provide valid input!"}';
		// }
	// }
	
	// function DomainAge($userInput)
    // {
		// if(isset($userInput) && !empty($userInput))
		// {
			// error_reporting(0);
			// ini_set('display_errors', 0);
			
			// require_once('libs/DomainAge.php');
			
			// $arr = array("http://","https://","www.");
			// $domain = str_replace($arr,"",$userInput);
			
			// $DomainAge = new DomainAge();
			// $result = $DomainAge->age($domain);
			// if($result !== "" && strpos($result, 'Error: ') === false){
				// echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","age":'.json_encode($result).'}}';
			// }
			// else{
				// echo '{"success":"false","result":"something went wrong!"}';
			// }
		// }
		// else
		// {
			// echo '{"success":"false","result":"please provide valid input!"}';
		// }
	// }
}

if(isset($_GET['action']) && $_GET['action'] != '')
{
	if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'visitorip')
	{
		$iptools = new IPTools();
		$iptools->VisitorIP();
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'visitorlocation')
	{
		$iptools = new IPTools();
		$iptools->VisitorLocation();
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'checkblacklist')
	{
		$iptools = new IPTools();
		$iptools->CheckBlacklist($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'checkwhois')
	{
		$iptools = new IPTools();
		$iptools->CheckWhois($_GET['query']);
	}	
	// elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'domainavailability')
	// {
		// //https://api.toolhub.cyou/IPTools.php?action=domainavailability&query=https://www.toblay.com
		// $iptools = new IPTools();
		// $iptools->DomainAvailability($_GET['query']);
	// }
	// elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'domainage')
	// {
		// //https://api.toolhub.cyou/IPTools.php?action=domainage&query=https://www.toblay.com
		// $iptools = new IPTools();
		// $iptools->DomainAge($_GET['query']);
	// }
}

?>