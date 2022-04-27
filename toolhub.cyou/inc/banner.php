<?php

include_once('../inc/DB.php');

//Local
//$top = 'http://localhost:8080/seotoolstationclonefront/template/img/BannerTop540x120.png';
//$rtop = 'http://localhost:8080/seotoolstationclonefront/template/img/BannerRightTop220x540.png';
//$rbottom = 'http://localhost:8080/seotoolstationclonefront/template/img/BannerRightBottom220x300.png';
//$bottom = 'http://localhost:8080/seotoolstationclonefront/template/img/BannerBottom540x120.png';
//Local

//online
$top = 'https://toolhub.cyou/template/img/BannerTop540x120.png';
$rtop = 'https://toolhub.cyou/template/img/BannerRightTop220x540.png';
$rbottom = 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png';
$bottom = 'https://toolhub.cyou/template/img/BannerBottom540x120.png';
//online

if(isset($_GET["toolid"]) && $_GET["toolid"] !== ""){
	$sql = "SELECT * FROM `banners` where tools_id='".$_GET["toolid"]."' and enable='1'";
	$result = $conn->query($sql);
	//print_r($result);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		
		if($row["topbannerurl"] !== "")
			$top = $row["topbannerurl"];
		
		if($row["bannerrighttopurl"] !== "")
			$rtop = $row["bannerrighttopurl"];
		
		if($row["bannerrightbottomurl"] !== "")
			$rbottom = $row["bannerrightbottomurl"];
		
		if($row["bottombannerurl"] !== "")
			$bottom = $row["bottombannerurl"];
	}

	echo '{"success":"true","result":{"top":"'.htmlentities($top).'","rtop":"'.htmlentities($rtop).'","rbottom":"'.htmlentities($rbottom).'","bottom":"'.htmlentities($bottom).'"}}';
}

?>