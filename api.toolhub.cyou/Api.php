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

//To delete 1 day older audio from texttospeech folder starts
$folderName = 'texttospeech';
if (file_exists($folderName)) {
    foreach (new DirectoryIterator($folderName) as $fileInfo) {
        if ($fileInfo->isDot()) {
        continue;
        }
        if ($fileInfo->isFile() && time() - $fileInfo->getCTime() >= 1*24*60*60) {
            unlink($fileInfo->getRealPath());
            //echo $fileInfo->getRealPath().'</br><br/>\n';
        }
    }
}
//To delete 1 day older audio from texttospeech folder ends

//To delete 1 day older screenshots from screenshots folder starts
$folderName = 'screenshots';
if (file_exists($folderName)) {
    foreach (new DirectoryIterator($folderName) as $fileInfo) {
        if ($fileInfo->isDot()) {
        continue;
        }
        if ($fileInfo->isFile() && time() - $fileInfo->getCTime() >= 1*24*60*60) {
            unlink($fileInfo->getRealPath());
            //echo $fileInfo->getRealPath().'</br><br/>\n';
        }
    }
}
//exit;
//To delete 1 day older screenshots from screenshots folder starts

header('Content-type: application/json');

class Api
{
	function GetAllTools()
	{
	    $tools = array();
		$dbServerName = "localhost";
        $dbUsername = "toolpqtu_toolhubuser";
        $dbPassword = "toolhubpassword";
        $dbName = "toolpqtu_toolhub";
        
        $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
        
        // check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
				
		$sql = "SELECT * FROM `tools`";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
			  array_push($tools,json_encode($row));
			}
			
			echo '{"success":"true","result":{"tools":['.join(",",$tools).']}}';
		}
	}
	
	function GetAllBanners()
	{
	    $banners = array();
		$dbServerName = "localhost";
        $dbUsername = "toolpqtu_toolhubuser";
        $dbPassword = "toolhubpassword";
        $dbName = "toolpqtu_toolhub";
        
        $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
        
        // check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
				
		$sql = "SELECT * FROM `banners`";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
			  array_push($banners,json_encode($row));
			}
			
			echo '{"success":"true","result":{"banners":['.join(",",$banners).']}}';
		}
	}
}


if(isset($_GET['pwd']) && $_GET['pwd'] != '' && $_GET['pwd'] == 'forapp')
{
    if(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'alltools')
    {
	    $websitetools = new Api();
	    $websitetools->GetAllTools();
    }
    elseif(isset($_GET['action']) && $_GET['action'] != '' && $_GET['action'] == 'allbanners')
    {
        $websitetools = new Api();
	    $websitetools->GetAllBanners();
    }
}

?>