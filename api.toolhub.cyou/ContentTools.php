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

class spin_my_data
{
    function randomSplit($string)
    {
        $string = Trim($string);
        $res = -1;
        $finalData = "";
        $loopinput = $this->parse_br($string);
        for ($loop = 0; $loop < count($loopinput); $loop++)
        {
            for ($loopx = 0; $loopx < count($loopinput[$loop]); $loopx++)
            {
                if (!$loopinput[$loop][$loopx] == "" || "/n")
                {
                    $res++;
                    if (strstr($loopinput[$loop][$loopx], "|"))
                    {
                        $out = explode("|", $loopinput[$loop][$loopx]);
                        $output[$res] = $out[rand(0, count($out) - 1)];
                    } else
                    {
                        $output[$res] = $loopinput[$loop][$loopx];
                    }
                }
            }
        }
        for ($loop = 0; $loop < count($output); $loop++)
        {
            $finalData .= $output[$loop];
        }
        return $finalData;
    }

    function spinMyData($data, $lang)
    {

        $patern_code_1 = "/<[^<>]+>/us";
        $patern_code_2 = "/\[[^\[\]]+\]/i";
        $patern_code_3 = '/\$@.*?\$@/i';

        $data = Trim($data);
        preg_match_all($patern_code_1, $data, $found1, PREG_PATTERN_ORDER);
        preg_match_all($patern_code_2, $data, $found2, PREG_PATTERN_ORDER);
        preg_match_all($patern_code_3, $data, $found3, PREG_PATTERN_ORDER);
        $htmlcodes = $found1[0];
        $bbcodes = $found2[0];
        $vbcodes = $found3[0];
        $founds = array();
        $current_dir = dirname(__file__);
        $sel_lang = Trim($lang);

        $arr_data = array_merge($htmlcodes, $bbcodes, $vbcodes);
        foreach ($arr_data as $code)
        {
            $code_md5 = md5($code);
            $data = str_replace($code, '%%!%%' . $code_md5 . '%%!%%', $data);
        }

        $file = file($current_dir . '/spinner_db/' . $sel_lang . '_db.sdata');

        foreach ($file as $line)
        {

            $synonyms = explode('|', $line);
            foreach ($synonyms as $word)
            {
                $word = trim($word);
                if ($word != '')
                {
                    $word = str_replace('/', '\/', $word);

                    if (preg_match('/\b' . $word . '\b/i', $data))
                    {
                        $founds[md5($word)] = str_replace(array("\n", "\r"), '', $line);
                        $data = preg_replace('/\b' . $word . '\b/i', md5($word), $data);

                    }
                }
            }

        }

        foreach ($arr_data as $code)
        {
            $code_md5 = md5($code);
            $data = str_replace('%%!%%' . $code_md5 . '%%!%%', $code, $data);
        }

        $array_count = count($founds);

        if ($array_count != 0)
        {
            foreach ($founds as $code => $value)
            {
                $data = str_replace($code, '{' . $value . '}', $data);
            }
        }

        return $data;
    }


    function parse_br($string)
    {
        @$string = explode("{", $string);
        for ($loop = 0; $loop < count($string); $loop++)
        {
            @$data[$loop] = explode("}", $string[$loop]);
        }
        return $data;
    }

}

class ContentTools
{	
    function ArticleRewriter($userInput)
    {
		if(isset($userInput) && !empty($userInput))
		{
			//$userInput = 'So I think this is the perfect time to publish my first-hand list of useful increase website speed WordPress plugin. To verify whether these plugins work for your site or not, I recommend you to note down your site speed using Google Page Speed Insights or a similar tool before and after installation.
			//This way you will better comprehend their effect. Feel free to share your experience with these plugins after installing, & please do let me know if I am missing something.';
			$spinmydata = new spin_my_data();
			$spinned=$spinmydata->spinMyData($userInput,'en');
			//echo $spinned;
			$spinned_data=$spinmydata->randomSplit($spinned); 
			$spinned_data = preg_replace_callback('/([.!?]\s*\w)/', function($m){ return strtoupper(strlen($m[1]) ? "$m[1]$m[2]" : $m[2]); }, $spinned_data);
			$spinned_data = implode(PHP_EOL, array_map("ucfirst", explode(PHP_EOL, $spinned_data)));
			$spinned_data = ucfirst($spinned_data);
			//echo $spinned_data;
			echo '{"success":"true","result":{"userInput":"'.$userInput.'","rewrite":"'.$spinned_data.'"}}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
    }
	
	function Spinner($userInput)
	{
		if(isset($userInput) && !empty($userInput))
		{
			//https://spinbot.info/php/process.php
			//POST
			//data
			//lang {en, du, fr, sp, ge, tr, in}
			//<option value="en">English</option>
			//<option value="du">Dutch</option>
			//<option value="fr">French</option>
			//<option value="sp">Spanish</option>
			//<option value="ge">Germany</option>
			//<option value="tr">Turkish</option>
			//<option value="in">Indonesian</option>
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"https://spinbot.info/php/process.php");
			curl_setopt($ch, CURLOPT_POST, 1);

			// In real life you should use something like:
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('data' => $userInput,'lang'=>'en')));

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			//echo $server_output;
			
			// Further processing ...
			if (!curl_errno($ch)) {
				echo '{"success":"true","result":{"userInput":"'.$userInput.'","spinned":"'.$server_output.'"}}';
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
	
	public static function element_to_obj($element) {
		$obj = array( "tag" => $element->tagName );
		foreach ($element->attributes as $attribute) {
			$obj[$attribute->name] = $attribute->value;
		}
		foreach ($element->childNodes as $subElement) {
			if ($subElement->nodeType == XML_TEXT_NODE) {
				$obj["html"] = $subElement->wholeText;
			}
			else {
				$obj["children"][] = ContentTools::element_to_obj($subElement);
			}
		}
		return $obj;
	}
	
	function PlagiarismCheker($userInput)
	{
		if(isset($userInput) && !empty($userInput))
		{
			//http://gh-export.us/google_plagiarism/ajax.php?start=1
			//POST
			//text
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"http://gh-export.us/google_plagiarism/ajax.php?start=1");
			curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS,"postvar1=value1&postvar2=value2&postvar3=value3");

			// In real life you should use something like:
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('text' => $userInput)));

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			//echo $server_output;
			
			// Further processing ...
			if (!curl_errno($ch)) {
				// $dom = new DOMDocument();
				// // set error level
				// $internalErrors = libxml_use_internal_errors(true);
				// $dom->loadHTML($server_output);
				// // Restore error level
				// libxml_use_internal_errors($internalErrors);
				// $element = $dom->documentElement;
				// $obj = array( "tag" => $element->tagName );
				// foreach ($element->attributes as $attribute) {
					// $obj[$attribute->name] = $attribute->value;
				// }
				// foreach ($element->childNodes as $subElement) {
					// if ($subElement->nodeType == XML_TEXT_NODE) {
						// $obj["html"] = $subElement->wholeText;
					// }
					// else {
						// $obj["children"][] = ContentTools::element_to_obj($subElement);
					// }
				// }
				// $server_output = $obj;
		
				// echo '{"success":"true","result":'.json_encode($server_output).'}';
				
				echo '{"success":"true","result":{"plagiarism":"'.rawurlencode($server_output).'"}}';
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function STS($userInput)//Youtube Content ID API
	{
		if(isset($userInput) && !empty($userInput))
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"https://seotoolstation.com/sts-content-hunter/users.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS,"postvar1=value1&postvar2=value2&postvar3=value3");

			// In real life you should use something like:
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('action'=>'getVideo','searchstring' => $userInput)));

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			//echo $server_output;
			
			// Further processing ...
			if (!curl_errno($ch)) {
				$server_output = strip_tags($server_output);
				
				echo '{"success":"true","result":'.json_encode($server_output).'}';			
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function TextToSpeech($userInput)
	{
		if(isset($userInput) && !empty($userInput))
		{
			//https://seotoolstation.com/?route=play-tts
			//POST
			//read
			require_once(__DIR__ . DIRECTORY_SEPARATOR . 'libs/voicerss_tts.php');

			$words = str_word_count($userInput);
			$charater = strlen($userInput);

			if($words <= 50){
			    //Working code for web application(return audio tag) starts
				//$tts = new VoiceRSS;
				//$voice = $tts->speech([
				//	'key' => '0441ee4cbcfa4ade975f1b971d190b59',
				//	'hl' => 'en-us',
				//	'v' => 'Linda',
				//	'src' => $userInput,
				//	'r' => '0',
				//	'c' => 'mp3',
				//	'f' => '44khz_16bit_stereo',
				//	'ssml' => 'false',
				//	'b64' => 'true'
				//]);

				//echo '{"success":"true","result":{"audio":"<audio src=\"' . $voice['response'] . '\" autoplay=\"autoplay\" controls></audio>"}}';
				////echo '{"success":"false","result":"'.$words.'"}';
				//working code for web application(return audio tag) ends
				
				//Working code for web application(return audio tag for web and sound url for mobile application) starts
				if($_SERVER['HTTP_USER_AGENT'] === "okhttp/3.12.12"){
				    $tts = new VoiceRSS;
    				$voice = $tts->speech([
    					'key' => '0441ee4cbcfa4ade975f1b971d190b59',
    					'hl' => 'en-us',
    					'v' => 'Linda',
    					'src' => $userInput,
    					'r' => '0',
    					'c' => 'mp3',
    					'f' => '44khz_16bit_stereo',
    					'ssml' => 'false',
    					'b64' => 'false'
    				]);
				
				    $t=time();
                    
				    $filename = date("Y-m-d",$t).'-'.$t.'-audio.mp3';
				    file_put_contents('texttospeech/'.$filename, $voice['response']);
				    $resultanturl = 'https://api.toolhub.cyou/texttospeech/'.$filename;
				    
				    echo '{"success":"true","result":"'.$resultanturl.'"}';
				}
				else{
				    $tts = new VoiceRSS;
    				$voice = $tts->speech([
    					'key' => '0441ee4cbcfa4ade975f1b971d190b59',
    					'hl' => 'en-us',
    					'v' => 'Linda',
    					'src' => $userInput,
    					'r' => '0',
    					'c' => 'mp3',
    					'f' => '44khz_16bit_stereo',
    					'ssml' => 'false',
    					'b64' => 'true'
    				]);
				    echo '{"success":"true","result":{"audio":"<audio src=\"' . $voice['response'] . '\" autoplay=\"autoplay\" controls></audio>"}}';
				    //echo '{"success":"false","result":"'.$words.'"}';
				}
				//Working code for web application(return audio tag for web and sound url for mobile application) ends
			}
			else{
				echo '{"success":"false","result":"Maximum 50 words are allowed!. Your text is of '.$words.' words."}';
			}
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
	
	function WordCount($userInput)
	{
		$userInput = trim($userInput);
		if(isset($userInput) && !empty($userInput))
		{
			$words = str_word_count($userInput);
			$charater = strlen($userInput);
			
			echo '{"success":"true","result":{"words":"'.$words.'","character":"'.$charater.'"}}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
	}
}

if(isset($_GET['query']) && $_GET['query'] != '')
{
	if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'articlerewriter')
	{
		$contenttools = new ContentTools();
		$contenttools->ArticleRewriter($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'spin')
	{
		$contenttools = new ContentTools();
		$contenttools->Spinner($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'plagiarismcheker')
	{
		$contenttools = new ContentTools();
		$contenttools->PlagiarismCheker($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'sts')
	{
		$contenttools = new ContentTools();
		$contenttools->STS($_GET['query']);
	}
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'tts')
	{
		$contenttools = new ContentTools();
		$contenttools->TextToSpeech($_GET['query']);
	}
	
	elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'wordcount')
	{
		$contenttools = new ContentTools();
		$contenttools->WordCount($_GET['query']);
	}
}

?>