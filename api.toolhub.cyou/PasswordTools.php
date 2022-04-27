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

class CheckPasswordComplexity
{
	//https://github.com/peeyush-budhia/PHP-Check-Password-Complexity/blob/master/class.CheckPasswordComplexity.php
    function checkPassword($password)
    {
        $strength = ['Excellent', 'Strong', 'Good', 'Week'];

        if ($this->isEnoughLength($password, 8) && $this->containsMixedCase($password) && $this->containsDigits($password) && $this->containsSpecialChars($password)) {
            return $strength[0];
        } elseif ($this->isEnoughLength($password, 8) && $this->containsMixedCase($password) && $this->containsDigits($password)) {
            return $strength[1];
        } elseif ($this->isEnoughLength($password, 8) && $this->containsMixedCase($password)) {
            return $strength[2];
        } elseif ($this->isEnoughLength($password, 8) && $this->containsDigits($password)) {
            return $strength[2];
        } elseif ($this->isEnoughLength($password, 8) && $this->containsSpecialChars($password)) {
            return $strength[2];
        } else {
            return $strength[3];
        }
    }

    private function isEnoughLength($password, $length)
    {
        if (empty($password)) {
            return false;
        } elseif (strlen($password) < $length) {
            return false;
        } else {
            return true;
        }
    }

    private function containsMixedCase($password)
    {
        if (preg_match('/[a-z]+/', $password) && preg_match('/[A-Z]+/', $password)) {
            return true;
        } else {
            return false;
        }
    }

    private function containsDigits($password)
    {
        if (preg_match("/\d/", $password)) {
            return true;
        } else {
            return false;
        }
    }

    private function containsSpecialChars($password)
    {
        if (preg_match("/[^\da-z]/", $password)) {
            return true;
        } else {
            return false;
        }
    }
}

class PasswordTools
{	
    function ConvertToMd5($word)
    {
		if(isset($word) && !empty($word))
		{
			$result = md5($word);
			echo '{"success":"true","result":{"word":"'.$word.'","md5":"'.$result.'"}}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
    }
	
	function Encrypt($word)
    {
		if(isset($word) && !empty($word))
		{
			if (CRYPT_STD_DES == 1)
				$desresult = crypt($word, 'st');
			else
				$desresult = 'not supported';
			
			$md5result = md5($word);
			$sha1result = sha1($word);
			
			echo '{"success":"true","result":{"des":"'.$desresult.'","md5":"'.$md5result.'","sha1":"'.$sha1result.'"}}';
		}
		else
		{
			echo '{"success":"false","result":"please provide valid input!"}';
		}
    }
	
	function GeneratePassword($length)
    {
		if(isset($length) && !empty($length))
		{
			//free password generation api url (https://passwordwolf.com/api/?length=8&upper=off&lower=off&special=on&repeat=1)
			// Generating Password
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
			$password = substr(str_shuffle($chars), 0, ($length >= 8 && $length <=16) ? $length : $length=rand(8,16));
			
			echo '{"success":"true","result":{"length":"'.$length.'","password":"'.$password.'"}}';
		}
		else
		{
			echo '{"success":"false","result":"something went wrong!"}';
		}
	}
	
	function PasswordStrength($password)
    {
		if(isset($password) && !empty($password))
		{			
			// if (strlen($password) < 8 && !preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)) {
				// echo '{"success":"true","result":{"password":"'.$password.'","password":"Easy"}}';
			// }
			// else if (strlen($password) < 8 && preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)) {
				// echo '{"success":"true","result":{"password":"'.$password.'","password":"Medium"}}';
			// }
			// else if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)) {
				// echo '{"success":"true","result":{"password":"'.$password.'","password":"Hard"}}';
			// }
			
			//working 1st starts
			// if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)){
				// //echo "Your password is strong.";
				// echo '{"success":"true","result":{"password":"'.$password.'","strength":"Strong"}}';
			// } else {
				// //echo "Your password is not safe.";
				// echo '{"success":"true","result":{"password":"'.$password.'","strength":"Not Safe"}}';
			// }
			//working 1st ends
			
			//working 2nd starts
			// $uppercase = preg_match('@[A-Z]@', $password);
			// $lowercase = preg_match('@[a-z]@', $password);
			// $number    = preg_match('@[0-9]@', $password);
			// $specialChars = preg_match('@[^\w]@', $password);

			// if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
				// //echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
				// echo '{"success":"true","result":{"password":"'.$password.'","strength":"Not Safe","message":"Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character."}}';
			// }else{
				// //echo 'Strong password.';
				// echo '{"success":"true","result":{"password":"'.$password.'","strength":"Strong"}}';
			// }
			//working 2nd ends
			
			//echo '{"success":"true","result":{"length":"'.$length.'","password":"'.$password.'"}}';
			
			$checkpasswordcomplexity = new CheckPasswordComplexity();
			$strength = $checkpasswordcomplexity->checkPassword($_GET['query']);
			
			echo '{"success":"true","result":{"password":"'.$password.'","strength":"'.$strength.'"}}';
		}
		else
		{
			echo '{"success":"false","result":"something went wrong!"}';
		}
	}
	
	function CertificateInfo($query)
	{
		if(isset($query) && !empty($query))
		{
			//https://ssltools.godaddy.com/cert/check
			//POST
			//url
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"https://ssltools.godaddy.com/cert/check");
			curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS,"postvar1=value1&postvar2=value2&postvar3=value3");

			// In real life you should use something like:
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('url' => $query)));

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			//echo $server_output;
			
			// Further processing ...
			if (!curl_errno($ch)) {
				echo '{"success":"true","result":'.$server_output.'}';
			} else {
				echo '{"success":"false","result":"something went wrong!"}';
			}
			
			curl_close ($ch);
		}
		else
		{
			echo '{"success":"error","result":"please provide valid input!"}';
		}
	}
}

if(isset($_GET['query']) && $_GET['query'] != '')
{
	if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'md5')
	{
		$passwordtools = new PasswordTools();
		$passwordtools->ConvertToMd5($_GET['query']);
	}
	else if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'encrypt')
	{
		$passwordtools = new PasswordTools();
		$passwordtools->Encrypt($_GET['query']);
	}
	else if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'password')
	{
		$passwordtools = new PasswordTools();
		$passwordtools->GeneratePassword($_GET['query']);
	}
	else if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'strength')
	{
		$passwordtools = new PasswordTools();
		$passwordtools->PasswordStrength($_GET['query']);
	}
	else if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'certificateinfo')
	{
		$passwordtools = new PasswordTools();
		$passwordtools->CertificateInfo($_GET['query']);
	}
}

?>