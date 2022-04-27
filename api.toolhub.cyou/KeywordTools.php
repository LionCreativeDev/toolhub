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

class GoogleCustomSearch
{
	public $searchengineid = '8057db26d98b3889b';
	public $key = 'AIzaSyBkcNlZOydsPpH4epe9JMOlorcJzmzr0Rs';
	public $items = array();
	
	function clean_url($data)
	{
		$data = trim($data);
		$data = preg_replace('#^http(s)?://#', '', $data);
		$data = preg_replace('/^www\./', '', $data);
		$data = rtrim($data, '/');
		return $data;
	}

	function to_baseurl($url)
	{
		$url = $this->clean_url($url);
		$x = strstr($url, '/');
		$url = str_replace($x, "", $url);
		return $url;
	}
	
	function GetKeywordCompititiors($keyword)
	{
		//https://www.googleapis.com/customsearch/v1?key=AIzaSyBkcNlZOydsPpH4epe9JMOlorcJzmzr0Rs&userIp=&cx=8057db26d98b3889b&q=pizza%20hut&cr=countryUS&start=1
		
		global $searchengineid;
		global $key;
		global $links;
		
		if(isset($keyword) && !empty($keyword))
		{
			for ($i = 1; $i <= 10; $i++) {
				
				$ch = curl_init();

				$request = "https://www.googleapis.com/customsearch/v1?"."q=".urlencode( "$keyword" )."&cx=".$this->searchengineid."&key=" . $this->key ."&start=".( ($i - 1)*10 + 1);
				
				curl_setopt($ch, CURLOPT_URL, $request);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

				$output = curl_exec($ch);
				$output = json_decode($output);

				if (!curl_errno($ch)) {
					if(count($output->items) > 0)
					{
						foreach($output->items as $value){
							$links[] = trim($value->link);
						}
					}			
				}
				curl_close($ch);							
			}
			
			if(count($links) > 0)
				echo '{"success":"true","result":{"keyword":"'.$keyword.'","Competitor":'.json_encode($links).'}}';
			else
				echo '{"success":"false","result":"something went wrong!"}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function GetKeywordRank($WebsiteUrl, $keyword)
	{
		//https://www.googleapis.com/customsearch/v1?key=AIzaSyBkcNlZOydsPpH4epe9JMOlorcJzmzr0Rs&userIp=&cx=8057db26d98b3889b&q=pizza%20hut&cr=countryUS&start=1		
		global $searchengineid;
		global $key;
		global $links;
		$rank = 1;
		$position = '';
		
		if(isset($keyword) && !empty($keyword))
		{
			for ($i = 1; $i <= 10; $i++) {
				
				$ch = curl_init();

				$request = "https://www.googleapis.com/customsearch/v1?"."q=".urlencode( "$keyword" )."&cx=".$this->searchengineid."&key=" . $this->key ."&start=".( ($i - 1)*10 + 1);
				
				curl_setopt($ch, CURLOPT_URL, $request);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

				$output = curl_exec($ch);
				$output = json_decode($output);

				if (!curl_errno($ch)) {
					if(count($output->items) > 0)
					{
						foreach($output->items as $value){
							$links[] = trim($value->link);
							
							if($this->to_baseurl($value->link) == $this->to_baseurl($WebsiteUrl))
								$position = $rank;
							
							$rank++;
						}
					}
				}
				curl_close($ch);
			}
			
			if(count($links) > 0)
				echo '{"success":"true","result":{"domain":"'.$this->to_baseurl($WebsiteUrl).'","keyword":"'.$keyword.'","position":"'.($position != '' ? $position : '-').'","Competitor":'.json_encode($links).'}}';
			else
				echo '{"success":"false","result":"something went wrong!"}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
}

class KeywordTools
{
	function KeywordSuggestion($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=en-US&q=".urlencode($userInput));
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			
			$json=curl_exec($ch);

			if (!curl_errno($ch)) {
				$keywords = array();
				$json = json_decode($json, true);
				$keywords = $json[1];
	
				echo '{"success":"true","result":{"keyword":"'.$userInput.'","suggestion":'.json_encode($keywords).'}}';
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
	
	function KeywordDensity($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			require_once('libs/kd.php');
			
			$obj = new KD();
			$obj->domain = $userInput;
			$resdata = $obj->result();
			//echo json_encode($resdata);
			
			echo '{"success":"true","result":{"url":"'.$userInput.'","desity":'.json_encode($resdata).'}}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function RelatedKeyword($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://domchimp.com/api/tools/relatedqueries');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, '{"keyword":"'.$userInput.'"}');
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

			$headers = array();
			$headers[] = 'Authority: domchimp.com';
			$headers[] = 'Accept: application/json, text/plain, */*';
			// $headers[] = 'X-Xsrf-Token: eyJpdiI6IkNtdW5xTGVtaEpWR25oM3BIMW1pQnc9PSIsInZhbHVlIjoiMzBGMXJ3Wmx5TjRjWThlU1pURFlLZGFqRFcrb3NUaTVndkZ3aVdzT3UxY3NJWW9XZ2NzYWZzaVo0a2s4bDJMdyIsIm1hYyI6ImFjYWQ5NDYwZDUxODdiNzU3MzBlYjk1MTliMDU4N2I1ZTliM2VlNWRkNWJjMDhjMTY1ZjEwNjVkYWUwMzU0NDQifQ==';
			$headers[] = 'X-Requested-With: XMLHttpRequest';
			$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36';
			$headers[] = 'Content-Type: application/json;charset=UTF-8';
			$headers[] = 'Origin: https://domchimp.com';
			$headers[] = 'Sec-Fetch-Site: same-origin';
			$headers[] = 'Sec-Fetch-Mode: cors';
			$headers[] = 'Sec-Fetch-Dest: empty';
			$headers[] = 'Referer: https://domchimp.com/tools/keyword-explorer';
			$headers[] = 'Accept-Language: en-US,en;q=0.9';
			// $headers[] = 'Cookie: XSRF-TOKEN=eyJpdiI6IkNtdW5xTGVtaEpWR25oM3BIMW1pQnc9PSIsInZhbHVlIjoiMzBGMXJ3Wmx5TjRjWThlU1pURFlLZGFqRFcrb3NUaTVndkZ3aVdzT3UxY3NJWW9XZ2NzYWZzaVo0a2s4bDJMdyIsIm1hYyI6ImFjYWQ5NDYwZDUxODdiNzU3MzBlYjk1MTliMDU4N2I1ZTliM2VlNWRkNWJjMDhjMTY1ZjEwNjVkYWUwMzU0NDQifQ%3D%3D; domchimp_session=eyJpdiI6IlJsaWVGVHFlcGVzNVNSUVh2WTBWYXc9PSIsInZhbHVlIjoiSWNKMFwvd1h4VkNnV1VCSm5jTHNRVlQxOEtiQzcyT0xnRk1IbkNmMkVVT0RIMmJ0MWpMSVwvbUN4cW9CRUptRUhUIiwibWFjIjoiMDNiNDdkOTIzMDZkZTUxNDM4YzA0MzNhZGZjNDUwYjI3NGM4ZWM1YmJiYTkyMjkzY2UyZjdhOGFmMzI1ZGRiMyJ9';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$json = curl_exec($ch);

			if (!curl_errno($ch)) {
				$keywords = array();
				$json = json_decode($json, true);
				//print_r($json["data"]["items"]);
				$keywords = $json["queries"];
	
				echo '{"success":"true","result":{"keyword":"'.$userInput.'","relatedkeyword":'.json_encode($keywords).'}}';
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
	
	function OrganicKeyword($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, "https://app.wordstream.com/services/v1/free_keyword_tool/search?limit=50&offset=0&searchQueries=".$userInput);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$json=curl_exec($ch);

			if (!curl_errno($ch)) {
				$keywords = array();
				$json = json_decode($json, true);
				//print_r($json["data"]["items"]);
				$keywords = $json["data"];
	
				echo '{"success":"true","result":{"keyword":"'.$userInput.'","organickeywords":'.json_encode($keywords).'}}';
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
	
	function KeywordVolume($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, 'https://db2.keywordsur.fr/keyword_surfer_keywords?country=US&keywords=%5B%22'.str_replace(" ","+",$userInput).'%22%5D&limit=100');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			
			$json=curl_exec($ch);
			//print($json);
			
			if (!curl_errno($ch)) {
				$keywords = array();
				$json = json_decode($json, true);
				
				$volume = $json[$userInput]["search_volume"];
				$cpc = $json[$userInput]["cpc"];
				$competition = $json[$userInput]["competition"];
	
				echo '{"success":"true","result":{"keyword":"'.$userInput.'","volume":"'.$volume.'","cpc":"'.$cpc.'","competition":"'.$competition.'"}}';
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
	
	function KeywordPosition($domain, $keyword)
    {
		if(isset($domain) && !empty($domain) && isset($keyword) && !empty($keyword))
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://prod.sureoakdata.com/api/v1/keywordRankStatus?websiteToFind='.$domain.'&searchQuery='.$keyword.'&maxRank=100');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

			$headers = array();
			$headers[] = 'Authority: prod.sureoakdata.com';
			$headers[] = 'Content-Length: 0';
			$headers[] = 'Cache-Control: max-age=0';
			$headers[] = 'Authorization: Basic LTEwMzc1MjQ2MTIwOjEwMy43NS4yNDYuMTIw';
			$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36';
			$headers[] = 'Accept: */*';
			$headers[] = 'Origin: https://www.sureoak.com';
			$headers[] = 'Sec-Fetch-Site: cross-site';
			$headers[] = 'Sec-Fetch-Mode: cors';
			$headers[] = 'Sec-Fetch-Dest: empty';
			$headers[] = 'Referer: https://www.sureoak.com/';
			$headers[] = 'Accept-Language: en-US,en;q=0.9';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$json = curl_exec($ch);
			if (!curl_errno($ch)) {
				//print_r($result);
				$json = json_decode($json, true);
				
				$position = $json["ranksReported"][0];
				echo '{"success":"true","result":{"domain":"'.$domain.'","keyword":"'.$keyword.'","position":"'.$position.'"}}';
			}
			else
			{				
				//echo 'Error:' . curl_error($ch);
				echo '{"success":"false","result":"something went wrong!"}';
			}
			curl_close($ch);
			// $ch = curl_init();

			// curl_setopt($ch, CURLOPT_URL, 'https://searchenginereports.net/ajaxrequests/checkKeyPosNew/');
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			// curl_setopt($ch, CURLOPT_POSTFIELDS, "code=1&keyword=".$keyword."&checktype=bykeyword&domain=".$domain."%2F&searchEngine=https%3A%2F%2Fwww.google.com%2F&page=1&token=b7534bbb6db233e805c105f1ccd6522d&device=Desktop");
			// curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

			// $headers = array();
			// $headers[] = 'Authority: searchenginereports.net';
			// $headers[] = 'Accept: */*';
			// $headers[] = 'X-Requested-With: XMLHttpRequest';
			// $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36';
			// $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
			// $headers[] = 'Origin: https://searchenginereports.net';
			// $headers[] = 'Sec-Fetch-Site: same-origin';
			// $headers[] = 'Sec-Fetch-Mode: cors';
			// $headers[] = 'Sec-Fetch-Dest: empty';
			// $headers[] = 'Referer: https://searchenginereports.net/';
			// $headers[] = 'Accept-Language: en-US,en;q=0.9';
			// //$headers[] = 'Cookie: __cfduid=d5663644d00082a883da8dfe74236b4691602520584; ser=2hvd1jmn3jeuquu7tc1s4vq04ppp7673; cb-enabled=enabled; ser_grammarly_bioep_shown=true; ser_grammarly_bioep_shown_session=true';
			// $headers[] = 'Cookie: ser=2hvd1jmn3jeuquu7tc1s4vq04ppp7673; cb-enabled=enabled; ser_grammarly_bioep_shown=true; ser_grammarly_bioep_shown_session=true';
			// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			// //code=1&keyword=serp&checktype=bykeyword&domain=serprobot.com%2F&searchEngine=https%3A%2F%2Fwww.google.com%2F&page=1&token=b7534bbb6db233e805c105f1ccd6522d&device=Desktop

			// $json = curl_exec($ch);
			// //print_r($json);
			// if (!curl_errno($ch)) {
				// //print_r($result);
				// $json = json_decode($json, true);
				
				// $position = $json["data"]["p"];
				// echo '{"success":"true","result":{"domain":"'.$domain.'","keyword":"'.$keyword.'","position":"'.$position.'"}}';
			// }
			// else
			// {				
				// //echo 'Error:' . curl_error($ch);
				// echo '{"success":"false","result":"something went wrong!"}';
			// }
			// curl_close($ch);
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function KeywordCompetitor($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://searchenginereports.net/ajaxrequests/checkKeyPosNew/');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, "code=1&keyword=".$userInput."&checktype=bykeyword&domain=serprobot.com%2F&searchEngine=https%3A%2F%2Fwww.google.com%2F&page=1&token=b7534bbb6db233e805c105f1ccd6522d&device=Desktop");
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

			$headers = array();
			$headers[] = 'Authority: searchenginereports.net';
			$headers[] = 'Accept: */*';
			$headers[] = 'X-Requested-With: XMLHttpRequest';
			$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36';
			$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
			$headers[] = 'Origin: https://searchenginereports.net';
			$headers[] = 'Sec-Fetch-Site: same-origin';
			$headers[] = 'Sec-Fetch-Mode: cors';
			$headers[] = 'Sec-Fetch-Dest: empty';
			$headers[] = 'Referer: https://searchenginereports.net/';
			$headers[] = 'Accept-Language: en-US,en;q=0.9';
			//$headers[] = 'Cookie: __cfduid=d5663644d00082a883da8dfe74236b4691602520584; ser=2hvd1jmn3jeuquu7tc1s4vq04ppp7673; cb-enabled=enabled; ser_grammarly_bioep_shown=true; ser_grammarly_bioep_shown_session=true';
			$headers[] = 'Cookie: ser=2hvd1jmn3jeuquu7tc1s4vq04ppp7673; cb-enabled=enabled; ser_grammarly_bioep_shown=true; ser_grammarly_bioep_shown_session=true';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			//code=1&keyword=serp&checktype=bykeyword&domain=serprobot.com%2F&searchEngine=https%3A%2F%2Fwww.google.com%2F&page=1&token=b7534bbb6db233e805c105f1ccd6522d&device=Desktop

			$json = curl_exec($ch);
			//print_r($json);
			if (!curl_errno($ch)) {
				//print_r($result);
				$json = json_decode($json, true);
				
				$competitor = $json["data"]["serp_url"];
				echo '{"success":"true","result":{"keyword":"'.$userInput.'","Competitor":'.json_encode($competitor).'}}';
			}
			else
			{				
				//echo 'Error:' . curl_error($ch);
				echo '{"success":"false","result":"something went wrong!"}';
			}
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
	if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'keywordsuggestion')
	{
		$keywordtools = new KeywordTools();
		$keywordtools->KeywordSuggestion($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'keyworddensity')
	{
		$keywordtools = new KeywordTools();
		$keywordtools->KeywordDensity($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'relatedkeyword')
	{
		$keywordtools = new KeywordTools();
		$keywordtools->RelatedKeyword($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'organickeywords')
	{
		$keywordtools = new KeywordTools();
		$keywordtools->OrganicKeyword($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'keywordvolume')
	{
		$keywordtools = new KeywordTools();
		$keywordtools->KeywordVolume($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'keywordposition')
	{
	    //Old Working Code for Scraping postion
		//$keywordtools = new KeywordTools();
		//$keywordtools->KeywordPosition($_GET['domain'], $_GET['query']);
		//Old Working Code for Scraping postion
		
		//New Code Using Google Custom Search Api
		$googlecustomsearch = new GoogleCustomSearch();
		$googlecustomsearch->GetKeywordRank($_GET['domain'], $_GET['query']);
		//New Code Using Google Custom Search Api
		//echo '{"success":"true","result":{"domain":"google.com","keyword":"search engine","position":"7","Competitor":["https:\/\/searchengineland.com\/","https:\/\/www.searchenginejournal.com\/alternative-search-engines\/271409\/","https:\/\/en.wikipedia.org\/wiki\/Search_engine","https:\/\/www.searchenginejournal.com\/","https:\/\/www.google.com\/","https:\/\/www.searchenginewatch.com\/","https:\/\/www.google.com\/search\/howsearchworks\/crawling-indexing\/","https:\/\/www.searchenginewatch.com\/2018\/05\/21\/no-need-for-google-12-alternative-search-engines-in-2018\/","https:\/\/support.google.com\/websearch\/answer\/464?hl=en","https:\/\/developers.google.com\/search\/docs\/beginner\/seo-starter-guide","https:\/\/www.sec.gov\/search\/search.htm","https:\/\/www.startpage.com\/en\/","https:\/\/moz.com\/beginners-guide-to-seo","https:\/\/www.uspto.gov\/trademarks-application-process\/search-trademark-database","https:\/\/scholar.google.com\/","https:\/\/programpages.passweb.org\/search","http:\/\/www.bing.com\/","https:\/\/www.ecosia.org\/?c=en","https:\/\/www.kiddle.co\/","https:\/\/search.yahoo.com\/","https:\/\/www.ftc.gov\/news-events\/press-releases\/2013\/06\/ftc-consumer-protection-staff-updates-agencys-guidance-search","https:\/\/gs.statcounter.com\/search-engine-market-share","https:\/\/www.pnas.org\/content\/112\/33\/E4512?","https:\/\/www.forbes.com\/sites\/forbesagencycouncil\/2017\/05\/15\/are-you-maximizing-the-use-of-video-in-your-content-marketing-strategy\/","https:\/\/www.shodan.io\/","https:\/\/trends.google.com\/trends\/","https:\/\/www.wolframalpha.com\/","https:\/\/chrome.google.com\/webstore\/detail\/ecosia-the-search-engine\/eedlgdlajadkbbjoobobefphmfkcchfk?hl=en","https:\/\/search.google.com\/search-console\/about","https:\/\/bigfuture.collegeboard.org\/college-search","https:\/\/www.britannica.com\/technology\/search-engine","https:\/\/www.pewresearch.org\/internet\/2012\/03\/09\/search-engine-use-2012\/","https:\/\/duckduckgo.com\/","https:\/\/openi.nlm.nih.gov\/","https:\/\/www.census.gov\/foreign-trade\/schedules\/b\/","https:\/\/www.kayak.com\/","https:\/\/uscensus.prod.3ceonline.com\/","https:\/\/www.fastweb.com\/","https:\/\/www.seroundtable.com\/","https:\/\/www.coursera.org\/specializations\/seo","https:\/\/info.ecosia.org\/what","https:\/\/neilpatel.com\/blog\/alternative-search-engines\/","https:\/\/maps.yahoo.com\/","https:\/\/www.nature.com\/articles\/nature07634","https:\/\/www.merriam-webster.com\/dictionary\/search%20engine","https:\/\/www.ft.com\/content\/fd311801-e863-41fe-82cf-3d98c4c47e26","https:\/\/datasetsearch.research.google.com\/","http:\/\/infolab.stanford.edu\/~backrub\/google.html","https:\/\/www.crowdstrike.com\/endpoint-security-products\/falcon-cyber-threat-search-engine\/","https:\/\/ads.microsoft.com\/","https:\/\/ec.europa.eu\/eurostat\/ramon\/search\/index.cfm?TargetUrl=SRH_LABEL","https:\/\/www.momondo.com\/","https:\/\/tineye.com\/","https:\/\/www.webmd.com\/pill-identification\/default.htm","https:\/\/www.careeronestop.org\/Toolkit\/Training\/find-scholarships.aspx","https:\/\/www.bbc.com\/news\/technology-23945326","https:\/\/ccsearch.creativecommons.org\/","https:\/\/www.freefind.com\/","http:\/\/www.aetna.com\/dse\/search?site_id=dse%20","https:\/\/ahrefs.com\/blog\/alternative-search-engines\/","https:\/\/www.alarms.org\/kidrex\/","https:\/\/www.nytimes.com\/2007\/06\/03\/business\/yourmoney\/03google.html","https:\/\/www.simplyhired.com\/","https:\/\/www.irs.gov\/charities-non-profits\/tax-exempt-organization-search","https:\/\/www.idealist.org\/","https:\/\/www.microsoft.com\/en-us\/rewards\/default-mobile-search","https:\/\/www.sweetsearch.com\/","https:\/\/programmablesearchengine.google.com\/about\/","https:\/\/lucene.apache.org\/solr\/","https:\/\/www.mtu.edu\/umc\/services\/digital\/seo\/","https:\/\/www.wsj.com\/articles\/google-uses-its-search-engine-to-hawk-its-products-1484827203","https:\/\/lucene.apache.org\/solr\/","https:\/\/www.matrixscience.com\/","https:\/\/www.mtu.edu\/umc\/services\/digital\/seo\/","https:\/\/www.citeab.com\/","https:\/\/plato.stanford.edu\/entries\/ethics-search\/","https:\/\/authorservices.wiley.com\/author-resources\/Journal-Authors\/Prepare\/writing-for-seo.html","https:\/\/digital.com\/about\/altavista\/","https:\/\/onlinelibrary.wiley.com\/pb-assets\/assets\/17476593\/SEO_Guidelines_for_Authors_July_13-1509465663000.pdf","https:\/\/www.statista.com\/statistics\/216573\/worldwide-market-share-of-search-engines\/","https:\/\/www.smartinsights.com\/search-engine-marketing\/search-engine-statistics\/","https:\/\/ads.google.com\/home\/resources\/seo-vs-ppc\/","https:\/\/www.wordstream.com\/search-engine-marketing","https:\/\/www.reliablesoft.net\/top-10-search-engines-in-the-world\/","https:\/\/search.maven.org\/","https:\/\/www.library.illinois.edu\/ugl\/howdoi\/compare1\/","https:\/\/www.thesearchengineguys.com\/","https:\/\/support.mozilla.org\/en-US\/kb\/add-or-remove-search-engine-firefox","https:\/\/www.globalreach.com\/blog\/2020\/01\/28\/the-2nd-largest-search-engine-on-the-internet","https:\/\/yandex.com\/","https:\/\/www.base-search.net\/about\/en\/","https:\/\/www.csn.edu\/sites\/default\/files\/legacy\/PDFFiles\/Library\/dbasesearch3.pdf","https:\/\/mailchimp.com\/marketing-glossary\/seo\/","https:\/\/money.cnn.com\/2013\/04\/08\/technology\/security\/shodan\/","https:\/\/www.drupal.org\/project\/google_cse","https:\/\/theintercept.com\/2018\/08\/01\/google-china-search-engine-censorship\/","https:\/\/help.shopify.com\/en\/manual\/promoting-marketing\/seo","https:\/\/componentsearchengine.com\/","https:\/\/pipl.com\/","https:\/\/www.youtube.com\/watch?v=hF515-0Tduk"]}}';
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'keywordcompetitor')
	{
	    //Old woriking Code for Scraping competitor
		//$keywordtools = new KeywordTools();
		//$keywordtools->KeywordCompetitor($_GET['query']);
		//Old woriking Code for Scraping competitor
		
		//New Code Using Google Custom Search Api
		$googlecustomsearch = new GoogleCustomSearch();
		$googlecustomsearch->GetKeywordCompititiors($_GET['query']);
		//New Code Using Google Custom Search Api
		//echo '{"success":"true","result":{"keyword":"search engine","Competitor":["https:\/\/searchengineland.com\/","https:\/\/www.searchenginejournal.com\/alternative-search-engines\/271409\/","https:\/\/en.wikipedia.org\/wiki\/Search_engine","https:\/\/www.searchenginejournal.com\/","https:\/\/www.google.com\/","https:\/\/www.searchenginewatch.com\/","https:\/\/www.google.com\/search\/howsearchworks\/crawling-indexing\/","https:\/\/www.searchenginewatch.com\/2018\/05\/21\/no-need-for-google-12-alternative-search-engines-in-2018\/","https:\/\/support.google.com\/websearch\/answer\/464?hl=en","https:\/\/developers.google.com\/search\/docs\/beginner\/seo-starter-guide","https:\/\/www.sec.gov\/search\/search.htm","https:\/\/www.startpage.com\/en\/","https:\/\/moz.com\/beginners-guide-to-seo","https:\/\/www.uspto.gov\/trademarks-application-process\/search-trademark-database","https:\/\/scholar.google.com\/","https:\/\/programpages.passweb.org\/search","http:\/\/www.bing.com\/","https:\/\/www.ecosia.org\/?c=en","https:\/\/www.kiddle.co\/","https:\/\/search.yahoo.com\/","https:\/\/www.ftc.gov\/news-events\/press-releases\/2013\/06\/ftc-consumer-protection-staff-updates-agencys-guidance-search","https:\/\/gs.statcounter.com\/search-engine-market-share","https:\/\/www.pnas.org\/content\/112\/33\/E4512?","https:\/\/www.forbes.com\/sites\/forbesagencycouncil\/2017\/05\/15\/are-you-maximizing-the-use-of-video-in-your-content-marketing-strategy\/","https:\/\/www.shodan.io\/","https:\/\/trends.google.com\/trends\/","https:\/\/www.wolframalpha.com\/","https:\/\/chrome.google.com\/webstore\/detail\/ecosia-the-search-engine\/eedlgdlajadkbbjoobobefphmfkcchfk?hl=en","https:\/\/search.google.com\/search-console\/about","https:\/\/bigfuture.collegeboard.org\/college-search","https:\/\/www.britannica.com\/technology\/search-engine","https:\/\/www.pewresearch.org\/internet\/2012\/03\/09\/search-engine-use-2012\/","https:\/\/duckduckgo.com\/","https:\/\/openi.nlm.nih.gov\/","https:\/\/www.census.gov\/foreign-trade\/schedules\/b\/","https:\/\/www.kayak.com\/","https:\/\/uscensus.prod.3ceonline.com\/","https:\/\/www.fastweb.com\/","https:\/\/www.seroundtable.com\/","https:\/\/www.coursera.org\/specializations\/seo","https:\/\/info.ecosia.org\/what","https:\/\/neilpatel.com\/blog\/alternative-search-engines\/","https:\/\/maps.yahoo.com\/","https:\/\/www.nature.com\/articles\/nature07634","https:\/\/www.merriam-webster.com\/dictionary\/search%20engine","https:\/\/www.ft.com\/content\/fd311801-e863-41fe-82cf-3d98c4c47e26","https:\/\/datasetsearch.research.google.com\/","http:\/\/infolab.stanford.edu\/~backrub\/google.html","https:\/\/www.crowdstrike.com\/endpoint-security-products\/falcon-cyber-threat-search-engine\/","https:\/\/ads.microsoft.com\/","https:\/\/ec.europa.eu\/eurostat\/ramon\/search\/index.cfm?TargetUrl=SRH_LABEL","https:\/\/www.momondo.com\/","https:\/\/tineye.com\/","https:\/\/www.careeronestop.org\/Toolkit\/Training\/find-scholarships.aspx","https:\/\/www.bbc.com\/news\/technology-23945326","https:\/\/www.alarms.org\/kidrex\/","https:\/\/ccsearch.creativecommons.org\/","https:\/\/www.freefind.com\/","http:\/\/www.aetna.com\/dse\/search?site_id=dse%20","https:\/\/ahrefs.com\/blog\/alternative-search-engines\/","https:\/\/www.optimizely.com\/optimization-glossary\/search-engine-optimization\/","https:\/\/www.nytimes.com\/2007\/06\/03\/business\/yourmoney\/03google.html","https:\/\/www.simplyhired.com\/","https:\/\/www.irs.gov\/charities-non-profits\/tax-exempt-organization-search","https:\/\/www.idealist.org\/","https:\/\/www.microsoft.com\/en-us\/rewards\/default-mobile-search","https:\/\/www.sweetsearch.com\/","https:\/\/programmablesearchengine.google.com\/about\/","https:\/\/www.wsj.com\/articles\/google-uses-its-search-engine-to-hawk-its-products-1484827203","https:\/\/lucene.apache.org\/solr\/","https:\/\/www.mtu.edu\/umc\/services\/digital\/seo\/","https:\/\/www.citeab.com\/","https:\/\/plato.stanford.edu\/entries\/ethics-search\/","https:\/\/authorservices.wiley.com\/author-resources\/Journal-Authors\/Prepare\/writing-for-seo.html","https:\/\/digital.com\/about\/altavista\/","https:\/\/onlinelibrary.wiley.com\/pb-assets\/assets\/17476593\/SEO_Guidelines_for_Authors_July_13-1509465663000.pdf","https:\/\/www.statista.com\/statistics\/216573\/worldwide-market-share-of-search-engines\/","https:\/\/www.mushroomnetworks.com\/infographics\/youtube-the-2nd-largest-search-engine-infographic\/","https:\/\/www.elastic.co\/elasticsearch\/","https:\/\/www.dictionary.com\/browse\/search-engine","https:\/\/www.comscore.com\/Insights\/Rankings\/Comscore-Releases-February-2016-US-Desktop-Search-Engine-Rankings","https:\/\/www.smartinsights.com\/search-engine-marketing\/search-engine-statistics\/","https:\/\/ads.google.com\/home\/resources\/seo-vs-ppc\/","https:\/\/www.wordstream.com\/search-engine-marketing","https:\/\/www.reliablesoft.net\/top-10-search-engines-in-the-world\/","https:\/\/www.library.illinois.edu\/ugl\/howdoi\/compare1\/","https:\/\/search.maven.org\/","https:\/\/support.apple.com\/guide\/safari\/customize-searching-ibrwe75c2a3c\/mac","https:\/\/www.thesearchengineguys.com\/","https:\/\/support.mozilla.org\/en-US\/kb\/add-or-remove-search-engine-firefox","https:\/\/www.globalreach.com\/blog\/2020\/01\/28\/the-2nd-largest-search-engine-on-the-internet","https:\/\/yandex.com\/","https:\/\/www.base-search.net\/about\/en\/","https:\/\/www.csn.edu\/sites\/default\/files\/legacy\/PDFFiles\/Library\/dbasesearch3.pdf","https:\/\/mailchimp.com\/marketing-glossary\/seo\/","https:\/\/reelgood.com\/","https:\/\/money.cnn.com\/2013\/04\/08\/technology\/security\/shodan\/","https:\/\/www.drupal.org\/project\/google_cse","https:\/\/theintercept.com\/2018\/08\/01\/google-china-search-engine-censorship\/","https:\/\/help.shopify.com\/en\/manual\/promoting-marketing\/seo"]}}';
	}
}

exit;
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://searchenginereports.net/ajaxrequests/checkKeyPosNew/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, "code=1&keyword=serp&checktype=bykeyword&domain=serprobot.com%2F&searchEngine=https%3A%2F%2Fwww.google.com%2F&page=1&token=b7534bbb6db233e805c105f1ccd6522d&device=Desktop");
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Authority: searchenginereports.net';
$headers[] = 'Accept: */*';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'Origin: https://searchenginereports.net';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Referer: https://searchenginereports.net/';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
//$headers[] = 'Cookie: __cfduid=d5663644d00082a883da8dfe74236b4691602520584; ser=2hvd1jmn3jeuquu7tc1s4vq04ppp7673; cb-enabled=enabled; ser_grammarly_bioep_shown=true; ser_grammarly_bioep_shown_session=true';
$headers[] = 'Cookie: ser=2hvd1jmn3jeuquu7tc1s4vq04ppp7673; cb-enabled=enabled; ser_grammarly_bioep_shown=true; ser_grammarly_bioep_shown_session=true';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//code=1&keyword=serp&checktype=bykeyword&domain=serprobot.com%2F&searchEngine=https%3A%2F%2Fwww.google.com%2F&page=1&token=b7534bbb6db233e805c105f1ccd6522d&device=Desktop

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
else
{
	print_r($result);
}
curl_close($ch);

//apify proxy for google serp
$query = urlencode('seo');
$curl = curl_init('http://www.google.com/search?q=' . $query);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_PROXY, 'http://proxy.apify.com:8000');
// Replace <YOUR_PROXY_PASSWORD> below with your password
// found at https://my.apify.com/proxy
curl_setopt($curl, CURLOPT_PROXYUSERPWD, 'groups-GOOGLE_SERP:A83qxwv6BXDzCMyZd5dQGxWN2');
$response = curl_exec($curl);
curl_close($curl);
echo $response;
exit;
?>