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

class DomainTools
{
	function DomainAge($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$arr = array("http://","https://","www.");
			$domain = str_replace($arr,"",$userInput);
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://ipty.de/domage/api.php?mode=full&domain='.$domain);
			//curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch); // $response will contain all headers
			//print_r($response);

			if (!curl_errno($ch)) {
				
				if($response !== "" && strpos($response, '"creation"') !== false)
				{
					$json = json_decode($response, true);
					
					echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","age":"'.$json["result"]["creation"]["years"].' year(s)"}}';
				}
				else
				{
					echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","age":"-"}}';
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
	
	function DomainToIP($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$arr = array("http://","https://","www.");
			$domain = str_replace($arr,"",$userInput);
			$ip = gethostbyname($domain);
			
			if($ip !== '')
				echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","ip":"'.$ip.'"}}';
			else
				echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","ip":"'.$ip.'"}}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function DomainAvailability($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$arr = array("http://","https://","www.");
			$domain = str_replace($arr,"",$userInput);
			
			if (gethostbyname($domain) != $domain) {
				echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","availability":"Not Available"}}';
			}
			else {
				echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","availability":"Available"}}';
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function DomainHost($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			//$arr = array("http://","https://","www.");
			//$domain = str_replace($arr,"",$userInput);
			$domain = str_ireplace('www.', '', parse_url($userInput, PHP_URL_HOST));
			$ip = gethostbyname($domain);
			
			if($ip !== ''){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://ipwhois.app/json/'.$ip);
				//curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($ch); // $response will contain all headers
				//print_r($response);

				if (!curl_errno($ch)) {
					if($response !== "" && strpos($response, '"success":true') !== false)
					{
						$json = json_decode($response, true);
						
						echo '{"success":"true","result":{"url":"'.$userInput.'","domain":"'.$domain.'","host":"'.$json["org"].'"}}';
					}
					else
					{
						echo '{"success":"false","result":"expired domain"}';
					}
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
				echo '{"success":"false","result":"something went wrong!"}';
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
}

if(isset($_GET['query']) && $_GET['query'] != '')
{
	if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'domainage')
	{
		$domaintools = new DomainTools();
		$domaintools->DomainAge($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'domaitoip')
	{
		$domaintools = new DomainTools();
		$domaintools->DomainToIP($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'domainavailability')
	{
		$domaintools = new DomainTools();
		$domaintools->DomainAvailability($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'domainhost')
	{
		$domaintools = new DomainTools();
		$domaintools->DomainHost($_GET['query']);
	}
	
}

?>