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

class WebsiteTools
{
	function MinifyCSS($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			//$url = 'https://cssminifier.com/raw';
			//$css = $userInput;
			
			//// init the request, set various options, and send it
			//$ch = curl_init();

			//curl_setopt_array($ch, [
			//	CURLOPT_URL => $url,
			//	CURLOPT_RETURNTRANSFER => true,
			//	CURLOPT_POST => true,
			//	CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
			//	CURLOPT_POSTFIELDS => http_build_query([ "input" => $css ])
			//]);

			//$minified = curl_exec($ch);
			
			//if (!curl_errno($ch)) {
			//	echo '{"success":"true","result":{"css":"'.$userInput.'","minified":"'.$minified.'"}}';
			//} else {
			//	echo '{"success":"false","result":"something went wrong!"}';
			//}
			
			//// finally, close the request
			//curl_close($ch);
			
			require __DIR__ . DIRECTORY_SEPARATOR . 'libs/HtmlCSSJSMinifier.php';			
			//$minified = minify_css($userInput);
			//echo '{"success":"true","result":{"css":"'.urlencode($userInput).'","minified":"'.urlencode($minified).'"}}';
			
			if($userInput === "infile"){
				$userInput = file_get_contents($_FILES['csssource']['tmp_name']);
				
				if($userInput !== ''){
					$minified = minify_css($userInput);
				
					echo '{"success":"true","result":{"css":"'.urlencode($userInput).'","minified":"'.rawurlencode($minified).'"}}';
				}
				else{
					echo '{"success":"false","result":"please provide valid input!"}';
				}
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function MinifyJS($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			#working code from api
			// // setup the URL and read the JS from a file
			// $url = 'https://javascript-minifier.com/raw';
			// $js = $userInput;// file_get_contents('ready.js');

			// // init the request, set various options, and send it
			// $ch = curl_init();

			// curl_setopt_array($ch, [
				// CURLOPT_URL => $url,
				// CURLOPT_RETURNTRANSFER => true,
				// CURLOPT_POST => true,
				// CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
				// CURLOPT_POSTFIELDS => http_build_query([ "input" => urlencode($js) ])
			// ]);

			// $minified = curl_exec($ch);

			// if (!curl_errno($ch)) {
				// echo '{"success":"true","result":{"js":"'.urlencode($userInput).'","minified":"'.urlencode($minified).'"}}';
			// } else {
				// echo '{"success":"false","result":"something went wrong!"}';
			// }
			
			// // finally, close the request
			// curl_close($ch);
			#working code from api
			
			require __DIR__ . DIRECTORY_SEPARATOR . 'libs/HtmlCSSJSMinifier.php';			
			//$minified = minify_js($userInput);
			//echo '{"success":"true","result":{"js":"'.urlencode($userInput).'","minified":"'.urlencode($minified).'"}}';
			
			if($userInput === "infile"){
				$userInput = file_get_contents($_FILES['jssource']['tmp_name']);
				
				if($userInput !== ''){
					$minified = minify_js($userInput);
				
					echo '{"success":"true","result":{"js":"'.urlencode($userInput).'","minified":"'.rawurlencode($minified).'"}}';
				}
				else{
					echo '{"success":"false","result":"please provide valid input!"}';
				}
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function MinifyHTML($userInput, array $options = [])
    {
		if(isset($userInput) && !empty($userInput))
		{
			//require 'TinyHtmlMinifier.php';
			
			//$minifier = new TinyHtmlMinifier($options);
			//$minified = $minifier->minify($userInput);
			
			require __DIR__ . DIRECTORY_SEPARATOR . 'libs/HtmlCSSJSMinifier.php';
			
			//$minified = minify_html($userInput);
			
			//echo '{"success":"true","result":{"html":"'.urlencode($userInput).'","minified":"'.urlencode($minified).'"}}';
			
			if($userInput === "infile"){
				$userInput = file_get_contents($_FILES['htmlsource']['tmp_name']);
				
				if($userInput !== ''){
					$minified = minify_html($userInput);
				
					echo '{"success":"true","result":{"html":"'.urlencode($userInput).'","minified":"'.htmlentities($minified).'"}}';
				}
				else{
					echo '{"success":"false","result":"please provide valid input!"}';
				}
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function GooglePageSpeed($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$psiurl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=".$userInput;//"https://www.googleapis.com/pagespeedonline/v2/runPagespeed?";
			//&key=yourAPIKey

			// init the request, set various options, and send it
			$ch = curl_init();

			curl_setopt_array($ch, [
				CURLOPT_URL => $psiurl,
				CURLOPT_RETURNTRANSFER => true,
				//	CURLOPT_POST => true,
				CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
				//CURLOPT_POSTFIELDS => http_build_query([ "input" => $js ])
			]);

			$GooglePageSpeedResponse = curl_exec($ch);

			if (!curl_errno($ch)) {
				//echo '{"success":"true","result":{"html":"'.$userInput.'","minified":"'.$minified.'"}}';
				$results = json_decode($GooglePageSpeedResponse, true);
				$lighthouseResult = $results["lighthouseResult"];
				
				$FCP = $lighthouseResult["audits"]["first-contentful-paint"]["displayValue"];
				$SI = $lighthouseResult["audits"]["speed-index"]["displayValue"];
				$TTI = $lighthouseResult["audits"]["interactive"]["displayValue"];
				$FMP = $lighthouseResult["audits"]["first-meaningful-paint"]["displayValue"];
				$FCI = $lighthouseResult["audits"]["first-cpu-idle"]["displayValue"];
				$EIL = $lighthouseResult["audits"]["estimated-input-latency"]["displayValue"];
				
				echo '{"success":"true","result":{"FCP":"'.$FCP.'","SI":"'.$SI.'","TTI":"'.$TTI.'","FMP":"'.$FMP.'","FCI":"'.$FCI.'","EIL":"'.$EIL.'"}}';
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
	
	function GoogleMobileFriendly($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			//Using google api
			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_URL, 'https://searchconsole.googleapis.com/v1/urlTestingTools/mobileFriendlyTest:run?key=AIzaSyB5goczZjqwcIunpduJGBGbVH68xTjpCyM&url='.$userInput);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($ch, CURLOPT_POST, 1);
			// //curl_setopt($ch, CURLOPT_POSTFIELDS, "{url: '".$userInput."'}");

			// $headers = array();
			// $headers[] = 'Content-Type: application/json';
			// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			// $result = curl_exec($ch);

			// if (!curl_errno($ch)) {
				// if (strpos($result, 'testStatus') !== false) {
					// $results = json_decode($result, true);
					// $mobileFriendliness = $results["mobileFriendliness"];
					
					// echo '{"success":"true","result":"'.$mobileFriendliness.'"}';
				// }
				// else{
					// echo '{"success":"false","result":"too many task, try later!"}';
				// }
			// } else {
				// echo '{"success":"false","result":"something went wrong!"}';
			// }

			// // finally, close the request
			// curl_close($ch);
			//Using google api
			
			//using scraper https://technicalseo.com/tools/mobile-friendly/
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://technicalseo.com/tools/assets/scripts/mobile-friendly.php');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([ "url" => $userInput ]));
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

			$headers = array();
			$headers[] = 'Authority: technicalseo.com';
			$headers[] = 'Accept: */*';
			$headers[] = 'X-Requested-With: XMLHttpRequest';
			$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36';
			//$headers[] = 'Content-Type: multipart/form-data; boundary=----WebKitFormBoundaryzlrSTk4XUHDNKv5O';
			$headers[] = 'Origin: https://technicalseo.com';
			$headers[] = 'Sec-Fetch-Site: same-origin';
			$headers[] = 'Sec-Fetch-Mode: cors';
			$headers[] = 'Sec-Fetch-Dest: empty';
			$headers[] = 'Referer: https://technicalseo.com/tools/mobile-friendly/';
			$headers[] = 'Accept-Language: en-US,en;q=0.9';
			//$headers[] = 'Cookie: __cfduid=deec0f4fd5b55c74d0c96d04fa55b22781606039397; mode=light; OptanonConsent=isIABGlobal=false&datestamp=Sun+Nov+22+2020+15%3A03%3A24+GMT%2B0500+(Pakistan+Standard+Time)&version=6.0.0&landingPath=https%3A%2F%2Ftechnicalseo.com%2Ftools%2Fmobile-friendly%2F&groups=C0002%3A1%2CC0004%3A1&hosts=&legInt=';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (!curl_errno($ch)) {
				if (strpos($result, 'mobile_friendly') !== false) {
					$results = json_decode($result, true);
					$mobileFriendliness = $results["mobile_friendly"];
					
					echo '{"success":"true","result":{"url":"'.$results["url"].'","mobile_friendly":"'.$mobileFriendliness.'"}}';
				}
				else{
					echo '{"success":"false","result":"too many task, try later!"}';
				}
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
			curl_close($ch);
			//using scraper https://technicalseo.com/tools/mobile-friendly/			
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function DetectWordpressTheme($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $userInput);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			//curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, "{url: '".$userInput."'}");

			$headers = array();
			$headers[] = 'Content-Type: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);

			if (!curl_errno($ch)) {	
				//Instantiate the DOMDocument class.
				$htmlDom = new DOMDocument;
				 
				//Parse the HTML of the page using DOMDocument::loadHTML
				@$htmlDom->loadHTML($result);
				 
				//Extract the links from the HTML.
				$links = $htmlDom->getElementsByTagName('link');

				$stylecss = '';
				foreach($links as $link){ 
					//Get the link text.
					$linkText = $link->nodeValue;
					//Get the link in the href attribute.
					$linkHref = $link->getAttribute('href');
					//echo $linkHref.'</br>';
					
					//if(strpos($linkHref, '/woocommerce/') === false && strpos($linkHref, 'style.css') !== false)  // old not working if multiple style.css
					if(strpos($linkHref, '/woocommerce/') === false && strpos($linkHref, '/themes/') !== false && strpos($linkHref, 'style.css') !== false)//check only for style.css in theme folder
					{
						$stylecss = $linkHref;
						if(strpos($linkHref, 'http://') === false && strpos($linkHref, 'https://') === false)
							$stylecss = $userInput.'/'.$stylecss;
						//echo $stylecss;
					}
				}
				
				$resultsArray = array();
				
				if($stylecss !== '')
				{
					//$styleHref = trim($matches[1]);
					$styleSrc = file_get_contents($stylecss);
					
					$chSheet = curl_init();
					curl_setopt($chSheet, CURLOPT_URL, $stylecss);
					curl_setopt($chSheet, CURLOPT_RETURNTRANSFER, 1);

					$headers = array();
					$headers[] = 'Content-Type: application/json';
					curl_setopt($chSheet, CURLOPT_HTTPHEADER, $headers);

					$result = curl_exec($chSheet);

					if (!curl_errno($chSheet)) {
						preg_match("/\Theme Name:(.*?)\n/i",$styleSrc,$name);
						preg_match("/\Version:(.*?)\n/i",$styleSrc,$version);
						preg_match("/\Theme URI:(.*?)\n/i",$styleSrc,$uri);
						
						if(sizeof($name) !== 0)
							$resultsArray['ThemeName']=trim($name[1]);
						
						if(sizeof($version) !== 0)
							$resultsArray['ThemeVersion']=trim($version[1]);
						
						if(sizeof($uri) !== 0)
							$resultsArray['ThemeUrl']=trim($uri[1]);
						
						//Extract the meta from the HTML.
						$metas = $htmlDom->getElementsByTagName('meta');
						$wordpressmeta = '';
						foreach($metas as $meta){
							//Get the link in the href attribute.
							$metaContent = $meta->getAttribute('content');
							//echo $metaContent.'</br>';
							
							if(strpos($metaContent, 'WordPress') !== false || strpos($metaContent, 'wordpress') !== false)
							{
								$wordpressmeta = $metaContent;
								//echo $wordpressmeta;
							}
						}

						$wordpresslicense = '';
						try {
							error_reporting(E_ALL ^ E_WARNING);
							$src = file_get_contents($userInput.'/license.txt');
							if(strpos($src, 'WordPress') !== false || strpos($src, 'wordpress') !== false)
							{
								$wordpresslicense = 'true';
								//echo $wordpresslicense;
							}
						}
						catch(Exception $e) {
						  //echo 'Message: ' .$e->getMessage();
						  $wordpresslicense = 'false';
						}
						
						//$iswordpress = false;
						if($wordpressmeta !== '' || $wordpresslicense === 'true')
						{
							//$iswordpress = 'true';
							$resultsArray['IsWordpress']='true';
						}
						else
						{
							$resultsArray['IsWordpress']='false';
						}
						
						//echo(trim($name[1]).' '.$version[1].' '.$uri[1]);
						echo '{"success":"true","result":'.json_encode($resultsArray).'}';
					} else {
						echo '{"success":"false","result":"something went wrong!"}';
					}

					// finally, close the request
					curl_close($chSheet);
				}
				else
				{
					echo '{"success":"false","result":"Theme Not Detected!"}';
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
	
	function GetHttpHeaders($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			//old working code 
			// $ch = curl_init();
			// $headers = [];
			// curl_setopt($ch, CURLOPT_URL, $userInput);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// // this function is called by curl for each header received
			// curl_setopt($ch, CURLOPT_HEADERFUNCTION,
			  // function($curl, $header) use (&$headers)
			  // {
				// $len = strlen($header);
				// $header = explode(':', $header, 2);
				// if (count($header) < 2) // ignore invalid headers
				  // return $len;

				// $headers[strtolower(trim($header[0]))][] = trim($header[1]);

				// return $len;
			  // }
			// );

			// $data = curl_exec($ch);
			// //$parsed = json_encode($headers);
			
			// if (!curl_errno($ch)) {
				// if(sizeof($headers) !== 0)
				// {
					// $parsed = json_encode($headers);
					// $parsed = str_replace('["','"',$parsed);
					// $parsed = str_replace('"]','"',$parsed);
					
					// echo '{"success":"true","result":['.$parsed.']}';
				// }
				// else{
					// echo '{"success":"true","result":"No Header Found!"}';
				// }
			// } else {
				// echo '{"success":"false","result":"something went wrong!"}';
			// }
			
			// curl_close ($ch);
			//old working code
			
			$ch = curl_init();
			$headers = [];
			curl_setopt($ch, CURLOPT_URL, $userInput);
			//return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//enable headers
			curl_setopt($ch, CURLOPT_HEADER, 1);
			//get only headers
			curl_setopt($ch, CURLOPT_NOBODY, 1);
			// $output contains the output string
			$output = curl_exec($ch);

			$data = curl_exec($ch);
			//$parsed = json_encode($headers);
			
			if (!curl_errno($ch)) {				
				$headers = [];
				$output = rtrim($output);
				$data = explode("\n",$output);
				$headers['status'] = $data[0];
				array_shift($data);

				foreach($data as $part){
					$middle = explode(":",$part,2);
					if ( !isset($middle[1]) ) { $middle[1] = null; }

					$headers[trim($middle[0])] = trim($middle[1]);
				}
				
				if(sizeof($headers) !== 0)
				{
					$parsed = json_encode($headers);
					$parsed = str_replace('["','"',$parsed);
					$parsed = str_replace('"]','"',$parsed);
					
					echo '{"success":"true","result":['.$parsed.']}';
				}
				else{
					echo '{"success":"true","result":"No Header Found!"}';
				}
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
			
			curl_close ($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function CheckCompression($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init($userInput);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
			curl_setopt($ch, CURLOPT_HEADER, 1); // include headers in curl response
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
				'Accept-Encoding: gzip, deflate', // request gzip
				'Accept-Language: en-US,en;q=0.5',
				'Connection: keep-alive',
				'SomeBull: BeingIgnored',
				'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:16.0) Gecko/20100101 Firefox/16.0'
			  )
			);
			$response = curl_exec($ch);

			if ($response === false) {
				die('Error fetching page: ' . curl_error($ch));
			}

			$info = curl_getinfo($ch);

			for ($i = 0; $i <= $info['redirect_count']; ++$i) {
				list($headers, $response) = explode("\r\n\r\n", $response, 2);
			}

			curl_close($ch);

			$headers = explode("\r\n", $headers); // split headers into one per line
			$hasGzip = false;
			$hasBr = false;
			
			$compressionenabled = false;
			$compressiontype = '';

			foreach($headers as $header) { // loop over each header
				if (stripos($header, 'Content-Encoding') !== false) { // look for a Content-Encoding header
					if (strpos($header, 'gzip') !== false) { // see if it contains gzip
						$hasGzip = true;
					}
					elseif(strpos($header, 'br') !== false)
					{
						$hasBr = true;
					}
				}
			}
			
			if($hasGzip || $hasBr)
			{
				$compressionenabled = "true";
				
				if($hasGzip)
					$compressiontype = "Gzip";
				elseif($hasBr)
					$compressiontype = "br";
			}
			else
			{
				$compressionenabled = "false";
				$compressiontype = "-";
			}
			
			echo '{"success":"true","result":{"url":"'.$userInput.'","compression":"'.$compressionenabled.'","compressiontype":"'.$compressiontype.'"}}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function CheckNS($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$userInput = preg_replace('/^www\./', '', parse_url($userInput, PHP_URL_HOST));
			
			$results = dns_get_record($userInput, DNS_NS);

			$temp = 1;
			$resultsString = '';
			foreach($results as $result)
			{	
				if($temp === 1)
					$resultsString .= '"ns'.$temp.'":"'.$result["target"].'",';
				else
					$resultsString .= '"ns'.$temp.'":"'.$result["target"].'"';
				$temp++;
			}
			
			echo '{"success":"true","result":{"url":"'.$userInput.'",'.$resultsString.'}}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function GetPageSource($userInput)
	{
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $userInput);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			//echo $server_output;
			
			// Further processing ...
			if (!curl_errno($ch)) {
				$server_output = str_replace(array("\n", "\r"), '', $server_output);
				
				echo '{"success":"true","result":{"url":"'.$userInput.'","source":"'.rawurlencode($server_output).'"}}';
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function GetScreenShot($userInput)
	{
		if(isset($userInput) && !empty($userInput))
		{
			$url = 'http://PhantomJScloud.com/api/browser/v2/a-demo-key-with-low-quota-per-ip-address/';
			$payload = '{url:"'.$userInput.'",renderType:"png"}';
			$options = array(
				'http' => array(
					'header'  => "Content-type: application/json\r\n",
					'method'  => 'POST',
					'content' => $payload
				)
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) { 
			/* Handle error */ 
				echo '{"success":"false","result":"something went wrong!"}';
			}
			else{
				//file_put_contents(__DIR__.'/screenshots/'.strtotime("now").'screenshots.jpg',$result);
				$filename = '/screenshots/'.strtotime("now").'screenshots.png';
				file_put_contents(__DIR__.$filename,$result);
				
				$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
				echo '{"success":"true","result":{"url":"'.$userInput.'","png":"'.$link.$filename.'"}}';
			}
			
			// exit;
			
			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_URL, 'https://phantomjscloud.com/api/browser/v2/a-demo-key-with-low-quota-per-ip-address/');
			// curl_setopt($ch, CURLOPT_POST, 1);
			// // Attach encoded JSON string to the POST fields
			// curl_setopt($ch, CURLOPT_POSTFIELDS, '{url:"'.$userInput.'",renderType:"png"}');

			// // Set the content type to application/json
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

			// $server_output = curl_exec($ch);
			
			// // Further processing ...
			// if (!curl_errno($ch)) {
				// $filename = '/screenshots/'.strtotime("now").'screenshots.jpg';
				// file_put_contents(__DIR__.$filename,$server_output);
				
				// $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
				
				// echo '{"success":"true","result":'.$link.$filename.'}';
			// } else {
				// echo '{"success":"false","result":"something went wrong!"}';
			// }
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
}

if(isset($_GET['query']) && $_GET['query'] != '')
{
	if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'minifycss')
	{
		$websitetools = new WebsiteTools();
		$websitetools->MinifyCSS($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'minifyjs')
	{
		$websitetools = new WebsiteTools();
		$websitetools->MinifyJS($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'minifyhtml')
	{
		$websitetools = new WebsiteTools();
		$websitetools->MinifyHTML($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'googlepagespeed')
	{
		$websitetools = new WebsiteTools();
		$websitetools->GooglePageSpeed($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'mobilefriendly')
	{
		$websitetools = new WebsiteTools();
		$websitetools->GoogleMobileFriendly($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'detectwordpresstheme')
	{
		$websitetools = new WebsiteTools();
		$websitetools->DetectWordpressTheme($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'httpheaders')
	{
		$websitetools = new WebsiteTools();
		$websitetools->GetHttpHeaders($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'checkcompression')
	{
		$websitetools = new WebsiteTools();
		$websitetools->CheckCompression($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'checkns')
	{
		$websitetools = new WebsiteTools();
		$websitetools->CheckNS($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'pagesource')
	{
		$websitetools = new WebsiteTools();
		$websitetools->GetPageSource($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'screenshot')
	{
		$websitetools = new WebsiteTools();
		$websitetools->GetScreenShot($_GET['query']);
	}	
}

?>