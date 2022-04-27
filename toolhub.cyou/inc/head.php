<?php

include_once('../inc/DB.php');

//for checking advertisement is enabled
$topadvertisement = true;
$bottomadvertisement = true;
$scripttag = '';
$tool_id = '';

$query = "SELECT * FROM advertisement limit 1;";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result) >= 1)
{
	while ($row = $result->fetch_assoc()) 
	{
		if($row["advertise_top_enable"])
			$topadvertisement = true;
		else
			$topadvertisement = false;
		
		if($row["advertise_bottom_enable"])
			$bottomadvertisement = true;
		else
			$bottomadvertisement = false;
			
		if($row["script_tag"])
			$scripttag = $row["script_tag"];
	}
}
//for checking advertisement is enabled


//for checking this tools is enabled
$available = false;

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
	 $url = "https://";
else  
	 $url = "http://";
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL   
$url.= $_SERVER['REQUEST_URI']; 

/**$result = $conn->query("SELECT * FROM `tools` where tool_url = '".$url."' and status='0'"); 
if($result->num_rows > 0 )
{
	$available = false;
}
else
{
	$available = true;
}**/
$result = $conn->query("SELECT * FROM `tools` where tool_url = '".$url."'"); 
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$tool_id = $row["tool_id"];
		
		if($row["status"] === '0')
			$available = false;
		else
			$available = true;
	}
}
//for checking this tools is enabled

//to get page title, meta keyword, meta description and page content
$page = basename($_SERVER['PHP_SELF']);

if($page==='index.php')
	$tool_id= '-1';
elseif($page==='aboutus.php')
	$tool_id= '-2';
elseif($page==='contactus.php')
	$tool_id= '-3';


$title='';
$keywords='';
$description='';
$pagecontent='';

$sql = "SELECT * FROM `settings` where tools_id='".$tool_id."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {												
		//echo  '<option value="'.$row["tool_id"].'">'.$row["tool_name"].'</option>';
		$title=$row["tool_title"];
		$keywords=$row["meta_keyword"];
		$description=$row["meta_description"];
		$pagecontent=$row["tool_text"];
		
		//echo '{"title":"'.$title.'","keywords":"'.$keywords.'","description":"'.$description.'","pagecontent":"'.base64_encode($pagecontent).'"}';
	}
}
//to get page title, meta keyword, meta description and page content

echo '<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	'.(!empty($title) ? '<title>'.$title.'</title>' : '<title>Tool Hub</title>').'
	'.(!empty($keywords) ? '<meta name="keywords" content="'.base64_decode($keywords).'">' : '') .'
	'.(!empty($description) ? '<meta name="description" content="'.base64_decode($description).'">' : '<meta name="description" content="Free Seo Tools">') .'
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="tool_id" content="'.$tool_id.'">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600" rel="stylesheet">

	<!-- Favicon -->
	<link rel="apple-touch-icon" href="../template/apple-touch-icon.png">
	<link rel="shortcut icon" href="../template/favicon.ico" type="image/x-icon">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="../template/css/main.min.css">
	'.(($scripttag !== '') ? base64_decode($scripttag) : '').'
	<style type="text/css">
		@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}
		
		/* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it\'s not present, don\'t show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
        	position: fixed;
        	left: 0px;
        	top: 0px;
        	width: 100%;
        	height: 100%;
        	z-index: 9999;
        	background: url(https://toolhub.cyou/tool-icons/spinner.gif) center no-repeat #ffffff85;
        	display:none;
        }
        
        .card {
          /* Add shadows to create the "card" effect */
          box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
          transition: 0.3s;
        }
        
        /* On mouse-over, add a deeper shadow */
        .card:hover {
          box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        
        /* Add some padding inside the card container */
        .container {
          padding: 2px 16px;
        }

	</style>
</head>';

?>