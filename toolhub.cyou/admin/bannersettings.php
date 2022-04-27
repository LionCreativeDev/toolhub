<?php
session_start();

if (!isset($_SESSION["userid"])) {
	header('location: login.php');
}

$btop = '';
$brtop = '';
$brbottom = '';
$bbottom = '';
$enable=false;

function SaveImage($name)
{
	try {
		if (empty($_FILES[$name])) {
			throw new Exception('Image file is missing');
		}
		$image = $_FILES[$name];
		// check INI error
		if ($image['error'] !== 0) {
			if ($image['error'] === 1) 
				throw new Exception('Max upload size exceeded');
				
			throw new Exception('Image uploading error: INI Error');
		}
		// check if the file exists
		if (!file_exists($image['tmp_name']))
			throw new Exception('Image file is missing in the server');
		$maxFileSize = 2 * 10e6; // in bytes
		if ($image['size'] > $maxFileSize)
			throw new Exception('Max size limit exceeded'); 
		// check if uploaded file is an image
		$imageData = getimagesize($image['tmp_name']);
		if (!$imageData)
			throw new Exception('Invalid image');
		$mimeType = $imageData['mime'];
		// validate mime type
		$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
		if (!in_array($mimeType, $allowedMimeTypes)) 
			throw new Exception('Only JPEG, PNG and GIFs are allowed');
		
		// nice! it's a valid image
		// get file extension (ex: jpg, png) not (.jpg)
		$fileExtention = strtolower(pathinfo($image['name'] ,PATHINFO_EXTENSION));
		// create random name for your image
		$fileName = mt_rand() . '-' . $image['name']; // anyfilename.jpg
		// Create the path starting from DOCUMENT ROOT of your website
		//$path = '/examples/image-upload/images/' . $fileName;
		$path = '/home/toolpqtu/public_html/template/img/banner/' . $fileName;
		// file path in the computer - where to save it 
		$destination = $_SERVER['DOCUMENT_ROOT'] . $path;

		if (!move_uploaded_file($image['tmp_name'], $path))
			throw new Exception('Error in moving the uploaded file');

		// create the url
		$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
		
		$domain = $protocol . $_SERVER['SERVER_NAME'];
		$url = $domain.'/template/img/banner/'.$fileName; //For Online
		//$url = 'http://localhost:8080/seotoolstationclonefront/template/img/banner/'.$fileName; //For Local
		return $url;

	} catch (Exception $e) {
		return "Unable To Upload Image File";
	}
}

function DeleteOldBanner($tool_id, $type, $conn)
{
	$sql = "SELECT * FROM `banners` where tools_id='".$tool_id."'";
	$result = $conn->query($sql);

	$filetodelete = '';
	
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if($type==="top")
			{
				$filetodelete = basename(parse_url($row["topbannerurl"], PHP_URL_PATH));
			}
			
			if($type==="righttop")
			{
				$filetodelete = basename(parse_url($row["bannerrighttopurl"], PHP_URL_PATH));
			}
			
			if($type==="rightbottom")
			{
				$filetodelete = basename(parse_url($row["bannerrightbottomurl"], PHP_URL_PATH));
			}
			
			if($type==="bottom")
			{
				$filetodelete = basename(parse_url($row["bottombannerurl"], PHP_URL_PATH));
			}
		}
	}
	
	if($filetodelete !== '')
	{
		//$completepath = 'C:\\xampp\\htdocs\\seotoolstationclonefront\\template\\img\\banner\\'.$filetodelete; //for local
		$completepath = '/home/toolpqtu/public_html/template/img/banner/'.$filetodelete; //for online
		
		if(file_exists($completepath)){
			if (!unlink($completepath)) {
				//echo '('.$completepath.') file not deleted<br>';
			}
		}
	}
}

if(isset($_POST["settings"]) && trim($_POST["settings"]) !== '' && trim($_POST["settings"]) === 'save' && isset($_POST["enable"]) && trim($_POST["enable"]) !== '' && isset($_POST["tool_id"]) && trim($_POST["tool_id"]) !== ''){
	include_once('../inc/DB.php');
	
	$enable = mysqli_real_escape_string($conn, trim($_POST['enable']));
	$tool_id = mysqli_real_escape_string($conn, trim($_POST['tool_id']));
	
	if($enable === '1')
	{
		$btopurl = '';
		$brtopurl = '';
		$brbottomurl = '';
		$bbottomurl = '';
		
		if(isset($_FILES['imgBtop'])){
			$btopurl = SaveImage('imgBtop');
			DeleteOldBanner($tool_id, 'top', $conn);
		}
		elseif(!isset($_FILES['imgBtop']))
		{
			$btopurl = 'https://toolhub.cyou/template/img/BannerTop540x120.png'; //Online
			//$btopurl = 'http://localhost:8080/seotoolstationclonefront/template/img/BannerTop540x120.png'; //Local
			DeleteOldBanner($tool_id, 'top', $conn);
		}
		
		if(isset($_FILES['imgBrtop'])){
			$brtopurl = SaveImage('imgBrtop');
			DeleteOldBanner($tool_id, 'righttop', $conn);
		}
		elseif(!isset($_FILES['imgBrtop']))
		{
			$brtopurl = 'https://toolhub.cyou/template/img/BannerRightTop220x540.png'; //Online
			//$brtopurl = 'http://localhost:8080/seotoolstationclonefront/template/img/BannerRightTop220x540.png'; //Local
			DeleteOldBanner($tool_id, 'righttop', $conn);
		}
		
		if(isset($_FILES['imgBrbottom'])){
			$brbottomurl = SaveImage('imgBrbottom');
			DeleteOldBanner($tool_id, 'rightbottom', $conn);
		}
		elseif(!isset($_FILES['imgBrbottom']))
		{
			$brbottomurl = 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png'; //Online
			//$brbottomurl = 'http://localhost:8080/seotoolstationclonefront/template/img/BannerRightBottom220x300.png'; //Local
			DeleteOldBanner($tool_id, 'rightbottom', $conn);
		}
		
		if(isset($_FILES['imgBbottom'])){
			$bbottomurl = SaveImage('imgBbottom');
			DeleteOldBanner($tool_id, 'bottom', $conn);
		}
		elseif(!isset($_FILES['imgBbottom']))
		{
			$bbottomurl = 'https://toolhub.cyou/template/img/BannerBottom540x120.png'; //Online
			//$bbottomurl = 'http://localhost:8080/seotoolstationclonefront/template/img/BannerBottom540x120.png'; //Local
			DeleteOldBanner($tool_id, 'bottom', $conn);
		}
		
		$query = "Update banners set topbannerurl='".$btopurl."', bannerrighttopurl='".$brtopurl."', bannerrightbottomurl='".$brbottomurl."', bottombannerurl='".$bbottomurl."' where tools_id='".$tool_id."';";
		
		if (mysqli_query($conn, $query)) {
			http_response_code(200);
			echo 'success';
		} else {
			http_response_code(405);
			echo 'failure';
		}
		exit;
	}
	elseif($enable === '0'){
		$query = "Update banners set enable='0' where tools_id='".$tool_id."';";
		
		if (mysqli_query($conn, $query)) {
			http_response_code(200);
			echo 'success';
		} else {
			http_response_code(405);
			echo 'failure';
		}
	}
	exit;
}
elseif(isset($_POST["tool_id"]) && trim($_POST["tool_id"]) !== '' && isset($_POST["action"]) && trim($_POST["action"]) !== '' && trim($_POST["action"]) === 'settings')
{
	include_once('../inc/DB.php');
	$tool_id = mysqli_real_escape_string($conn, trim($_POST['tool_id']));
	
	$sql = "SELECT * FROM `banners` where tools_id='".$tool_id."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$btop = $row["topbannerurl"];
			$brtop = $row["bannerrighttopurl"];
			$brbottom = $row["bannerrightbottomurl"];
			$bbottom = $row["bottombannerurl"];
			$enable= ($row["enable"] === '1' ? true : false);
			echo '{"btop":"'.$btop.'","brtop":"'.$brtop.'","brbottom":"'.$brbottom.'","bbottom":"'.$bbottom.'","enable":"'.$enable.'"}';
		}
	}
	exit;
}
else{
	include_once('../inc/DB.php');
	
	$sql = "SELECT * FROM `banners` where tools_id='1'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$btop = $row["topbannerurl"];
			$brtop = $row["bannerrighttopurl"];
			$brbottom = $row["bannerrightbottomurl"];
			$bbottom = $row["bottombannerurl"];
			$enable= ($row["enable"] === '1' ? true : false);
		}
	}
}

?>

<!doctype html>
<html lang="en-us">
	<?php 
	require_once('../inc/head.php');
	?>

	<body>
		
		<?php require_once('../inc/admin-header.php'); ?>

		<div class="container">
            <div class="row">
			
                <div class="col-xl-3 u-hidden-down@wide">
                    <aside class="c-menu u-ml-medium c-card" style="padding: 10px;">
                        <h4 class="c-menu__title">Menu</h4>
                        <ul class="u-mb-medium">
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="dashboard.php">
                                    <i class="fa fa-dashboard u-mr-xsmall"></i>Dashboard
                                </a>
                            </li>
							
							<li class="c-menu__item">
                                <a class="c-menu__link" href="addtool.php">
                                    <i class="c-menu__icon fa fa-plus"></i>Add Tool
                                </a>
                            </li>
							
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="edittool.php">
                                    <i class="c-menu__icon fa fa-edit"></i>Edit Tool
                                </a>
                            </li>
							
							<li class="c-menu__item">
                                <a class="c-menu__link" href="advertisment.php">
                                    <i class="c-menu__icon fa fa-eye"></i>Advertisment Settings
                                </a>
                            </li>
							
							<li class="c-menu__item">
                                <a class="c-menu__link" href="settings.php">
                                    <i class="c-menu__icon fa fa-eye"></i>Settings
                                </a>
                            </li>
                            
                            <li class="c-menu__item">
                                <a class="c-menu__link is-active card" href="bannersettings.php" style="background-color: #2ea1f8;color: #fff;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;">
                                    <i class="c-menu__icon fa fa-image" style="color:white;"></i>Banners Settings
                                </a>
                            </li>
							
                            <!--<li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <i class="c-menu__icon fa fa-bullhorn"></i>Live Streams
                                </a>
                            </li>
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <i class="c-menu__icon fa fa-newspaper-o"></i>Press
                                </a>
                            </li>
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <i class="c-menu__icon fa fa-diamond"></i>Favourites
                                </a>
                            </li>
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <i class="c-menu__icon fa fa-map-o"></i>Places
                                </a>
                            </li>-->
                        </ul>

                        <!--<h4 class="c-menu__title">Your Events</h4>
                        <ul>
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <img src="img/sidebar-icon1.png" class="u-mr-xsmall" style="width: 14px;" alt="Icon 1">Classes
                                </a>
                            </li>
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <img src="img/sidebar-icon2.png" class="u-mr-xsmall" style="width: 14px;" alt="Icon 2">People
                                </a>
                            </li>
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <img src="img/sidebar-icon3.png" class="u-mr-xsmall" style="width: 14px;" alt="Icon 3">Networking
                                </a>
                            </li>
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <img src="img/sidebar-icon4.png" class="u-mr-xsmall" style="width: 14px;" alt="Icon 4">Hi-Skill
                                </a>
                            </li>
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <img src="img/sidebar-icon5.png" class="u-mr-xsmall" style="width: 14px;" alt="Add icon">Going to Buy
                                </a>
                            </li>
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="#">
                                    <img src="img/sidebar-icon6.png" class="u-mr-xsmall" style="width: 14px;" alt="Add icon">Add New List
                                </a>
                            </li>
                        </ul>-->
                    </aside>
                </div>

                <div class="col-md-9 col-xl-9">
                    <main>
                        <h2 class="u-h3 u-mb-small">Banners Settings</h2>
						
						<div class="row u-mb-large">
							<?php require_once('../inc/alerts.php'); ?>
							<div class="col-sm-12">
								<div class="c-table-responsive@desktop">
									<form class="c-search-form c-search-form--dark card">
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-cog"></i></span>
												<label class="c-field__label c-search-form__label" for="tool_id">Tool Page Title</label>
												<select id="tool_id" class="c-input">
												<!--<option value="-1">Index</option>
												<option value="-2">About</option>
												<option value="-3">Contact Us</option>-->
												<?php include_once('../inc/DB.php');
				
												$sql = "SELECT * FROM `tools`";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													while ($row = $result->fetch_assoc()) {												
														echo  '<option value="'.$row["tool_id"].'">'.$row["tool_name"].'</option>';
													}
												}?>
													
												</select>
												<small class="c-field__message">Select page to change banner settings</small>
											</div>
										</div>
										
										<div class="c-search-form__section" style="border-bottom: 1px solid gray;">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-image"></i></span>
												<label class="c-field__label c-search-form__label" for="imgBtop">Banner Top</label>
												<input class="c-input" id="imgBtop" name="imgBtop" type="file">
												<!--<input class="c-input" id="txtBtop" name="txtBtop" type="text" placeholder="ie: https://toolhub.cyou/template/img/BannerTop540x120.png" value="<?php echo $btop; ?>">-->
												<small class="c-field__message">Enter a Banner Top Url (Width 540px, Height 120px), Default Banner is <a href="https://toolhub.cyou/template/img/BannerTop540x120.png" target="blank">BannerTop540x120.png</a></small>
											</div>
											<div class="c-field has-icon-left u-mt-small u-mb-medium">
												<div class="c-choice c-choice--checkbox">
													<input class="c-choice__input" id="cbDefaultTop" name="cbDefaultTop" type="checkbox">
													<label class="c-choice__label" for="cbDefaultTop">Set Default Banner Top</label>
												</div>
											</div>
											<?php if(!empty($btop)){ ?>
											<div class="c-field has-icon-left">
												<label class="c-field__label c-search-form__label" for="tool_icon"> <i class="fa fa-picture-o"></i> Previous Banner Top Image</label>
												<img src="<?php echo $btop; ?>" style="max-height: 70px;">
											</div>
											<?php } ?>
										</div>
										
										<div class="c-search-form__section" style="border-bottom: 1px solid gray;">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-image"></i></span>
												<label class="c-field__label c-search-form__label" for="imgBrtop">Banner Right(Top)</label>
												<input class="c-input" id="imgBrtop" name="imgBrtop" type="file">
												<!--<input class="c-input" id="txtBrtop" name="txtBrtop" type="text" placeholder="ie: https://toolhub.cyou/template/img/BannerRightTop220x540.png" value="<?php echo $brtop; ?>">-->
												<small class="c-field__message">Enter a Banner Right(Top) Url (Width 220px, Height 540px), Default Banner is <a href="https://toolhub.cyou/template/img/BannerRightTop220x540.png" target="blank">BannerRightTop220x540.png</a></small>
											</div>
											<div class="c-field has-icon-left u-mt-small u-mb-medium">
												<div class="c-choice c-choice--checkbox">
													<input class="c-choice__input" id="cbDefaultTopRight" name="cbDefaultTopRight" type="checkbox">
													<label class="c-choice__label" for="cbDefaultTopRight">Set Default Banner Right(Top)</label>
												</div>
											</div>
											<?php if($brtop !== ""){ ?>
											<div class="c-field has-icon-left">
												<label class="c-field__label c-search-form__label" for="tool_icon"> <i class="fa fa-picture-o"></i> Previous Banner Right(Top) Image</label>
												<img src="<?php echo $brtop; ?>"  style="max-height: 120px;">
											</div>
											<?php } ?>
										</div>
										
										<div class="c-search-form__section" style="border-bottom: 1px solid gray;">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-image"></i></span>
												<label class="c-field__label c-search-form__label" for="imgBrbottom">Banner Right(Bottom)</label>
												<input class="c-input" id="imgBrbottom" name="imgBrbottom" type="file">
												<!--<input class="c-input" id="txtBrbottom" name="txtBrbottom" type="text" placeholder="ie: https://toolhub.cyou/template/img/BannerRightBottom220x300.png" value="<?php echo $brbottom; ?>">-->
												<small class="c-field__message">Enter a Banner Right(Bottom) Url (Width 220px, Height 300px), Default Banner is <a href="https://toolhub.cyou/template/img/BannerRightBottom220x300.png" target="blank">BannerRightBottom220x300.png</a></small>
											</div>
											<div class="c-field has-icon-left u-mt-small u-mb-medium">
												<div class="c-choice c-choice--checkbox">
													<input class="c-choice__input" id="cbDefaultBottomRight" name="cbDefaultBottomRight" type="checkbox">
													<label class="c-choice__label" for="cbDefaultBottomRight">Set Default Banner Right(Bottom)</label>
												</div>
											</div>
											<?php if($brbottom !== ""){ ?>
											<div class="c-field has-icon-left">
												<label class="c-field__label c-search-form__label" for="tool_icon"> <i class="fa fa-picture-o"></i> Previous Banner Right(Bottom) Image</label>
												<img src="<?php echo $brbottom; ?>" style="max-height: 120px;">
											</div>
											<?php } ?>
										</div>
										
										<div class="c-search-form__section" style="border-bottom: 1px solid gray;">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-image"></i></span>
												<label class="c-field__label c-search-form__label" for="imgBbottom">Banner Bottom</label>
												<input class="c-input" id="imgBbottom" name="imgBbottom" type="file">
												<!--<input class="c-input" id="txtBbottom" name="txtBbottom" type="text" placeholder="ie: https://toolhub.cyou/template/img/BannerBottom540x120.png" value="<?php echo $bbottom; ?>">-->
												<small class="c-field__message">Enter a Banner Bottom Url (Width 540px, Height 120px), Default Banner is <a href="https://toolhub.cyou/template/img/BannerBottom540x120.png" target="blank">BannerBottom540x120.png</a></small>
											</div>							
											<div class="c-field has-icon-left u-mt-small u-mb-medium">
												<div class="c-choice c-choice--checkbox">
													<input class="c-choice__input" id="cbDefaultBottom" name="cbDefaultBottom" type="checkbox">
													<label class="c-choice__label" for="cbDefaultBottom">Set Default Banner Bottom</label>
												</div>
											</div>
											<?php if($bbottom !== ""){ ?>
											<div class="c-field has-icon-left">
												<label class="c-field__label c-search-form__label" for="tool_icon"> <i class="fa fa-picture-o"></i> Previous Banner Bottom Image</label>
												<img src="<?php echo $bbottom; ?>" style="max-height: 70px;">
											</div>
											<?php } ?>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<div class="u-block u-mb-xsmall">
													<div class="c-switch">
														<input class="c-switch__input" id="cbenable" type="checkbox" <?php echo ($enable == '1' ? 'checked="checked"' : ''); ?>>
														<label class="c-switch__label" for="cbenable"><?php echo ($enable == '1' ? 'Disable Banner On This Page' : 'Enable Banner On This Page'); ?></label>
													</div>
												</div>
												<small class="c-field__message">To Enable or Disable Banners On Page</small>
												<!--<span class="c-field__icon"><i class="fa fa-image"></i></span>
												<label class="c-field__label c-search-form__label" for="txtDribbble">Enable</label>
												<input class="c-input" id="txtEnable" name="txtEnable" type="text" placeholder="ie: " value="<?php echo $enable; ?>">
												<small class="c-field__message">To Enable or Disable Banners On Page</small>-->
											</div>
										</div>
													
										<button class="c-btn c-btn--info u-mt-small btnSave" type="submit">Save Settings</button>
									</form>
								</div>								
							</div>
						</div>
						
					</main>
                </div>
                
            </div>
        </div>
		
		<!-- Main javascsript -->
		<script src="../template/js/main.min.js"></script>
		<script>
		$(document).ready(function(){
			$("#cbDefaultTop").click(function(){
				if($(this).is(":checked")){
					$("#imgBtop").val(null);
					$("#imgBtop").prop("disabled", true); //console.log("checked");
				}
				else{
					$("#imgBtop").prop("disabled", false); //console.log("unchecked");
				}
			})

			$("#cbDefaultTopRight").click(function(){
				if($(this).is(":checked"))
				{
					$("#imgBrtop").val(null);
					$("#imgBrtop").prop("disabled", true); //console.log("checked");
				}
				else
				{
					$("#imgBrtop").prop("disabled", false); //console.log("unchecked");
				}
			})

			$("#cbDefaultBottomRight").click(function(){
				if($(this).is(":checked"))
				{
					$("#imgBrbottom").val(null);
					$("#imgBrbottom").prop("disabled", true); //console.log("checked");
				}
				else
				{
					$("#imgBrbottom").prop("disabled", false); //console.log("unchecked");
				}
			})

			$("#cbDefaultBottom").click(function(){
				if($(this).is(":checked"))
				{
					$("#imgBbottom").val(null);
					$("#imgBbottom").prop("disabled", true); //console.log("checked");
				}
				else
				{
					$("#imgBbottom").prop("disabled", false); //console.log("unchecked");
				}
			})
			
			$(".c-switch").click(function(){
				if($("#cbenable").is(":checked")){
					$('label[for="cbenable"]').text('Disable Banner On This Page');
					$("#cbenable").attr("checked","checked");
					$("#cbenable").parent().addClass("is-active");
				}
				else{
					$('label[for="cbenable"]').text('Enable Banner On This Page');
					$("#cbenable").removeAttr("checked");
					$("#cbenable").parent().removeClass("is-active");
				}
			});
			
			function SetValues(toolid){
				var dataString = 'tool_id='+encodeURIComponent(toolid)+"&action=settings";
				//console.log(dataString);
				$.ajax({
					type:'POST',
					data:dataString,
					url:'bannersettings.php',
					success:function(data) {
						//debugger;
						//console.log(data);
						var data = JSON.parse(data);
						$("#txtBtop").val(data["btop"]);
						$("#txtBrtop").val(data["brtop"]);
						$("#txtBrbottom").val(data["brbottom"]);
						$("#txtBbottom").val(data["bbottom"]);
						
						//for Online
						if(data["btop"] === 'https://toolhub.cyou/template/img/BannerTop540x120.png')
							$("#cbDefaultTop").click();
						
						if(data["brtop"] === 'https://toolhub.cyou/template/img/BannerRightTop220x540.png')
							$("#cbDefaultTopRight").click();
						
						if(data["brbottom"] === 'https://toolhub.cyou/template/img/BannerRightBottom220x300.png')
							$("#cbDefaultBottomRight").click();
						
						if(data["bbottom"] === 'https://toolhub.cyou/template/img/BannerBottom540x120.png')
							$("#cbDefaultBottom").click();
						//for Online
						
						//for Local
						//if(data["btop"] === 'http://localhost:8080/seotoolstationclonefront/template/img/BannerTop540x120.png')
							//$("#cbDefaultTop").click();
						
						//if(data["brtop"] === 'http://localhost:8080/seotoolstationclonefront/template/img/BannerRightTop220x540.png')
							//$("#cbDefaultTopRight").click();
						
						//if(data["brbottom"] === 'http://localhost:8080/seotoolstationclonefront/template/img/BannerRightBottom220x300.png')
							//$("#cbDefaultBottomRight").click();
						
						//if(data["bbottom"] === 'http://localhost:8080/seotoolstationclonefront/template/img/BannerBottom540x120.png')
							//$("#cbDefaultBottom").click();
						//for Local
						
						if(data["enable"] == '1'){
							$('label[for="cbenable"]').text('Disable Banner On This Page');
							$("#cbenable").attr("checked","checked");
							$("#cbenable").parent().addClass("is-active");
						}
						else{
							$('label[for="cbenable"]').text('Enable Banner On This Page');
							$("#cbenable").removeAttr("checked");
							$("#cbenable").parent().removeClass("is-active");
						}
					}
				}).fail(function (jqXHR, textStatus, error) {
					$('#editor-content-container').html(jqXHR.responseText);
					$('.c-alert--danger').find("label").text("Something Went Wrong!");
					$('.c-alert--danger').show();
				});
			}
			
			setTimeout(function(){
				SetValues($("#tool_id").children("option:selected").val());
			},1000);
			
			$(".btnSave").on("click", function(e){
				e.preventDefault();
				//debugger;
				$('.c-alert').hide();
				
				if(($("#cbDefaultTop").is(":checked") || document.getElementById("imgBtop").files.length > 0) && ($("#cbDefaultTopRight").is(":checked") || document.getElementById("imgBrtop").files.length > 0) && ($("#cbDefaultBottomRight").is(":checked") || document.getElementById("imgBrbottom").files.length > 0) && ($("#cbDefaultBottom").is(":checked") || document.getElementById("imgBbottom").files.length > 0)){
					var formdata = new FormData();
					
					if(!$("#cbDefaultTop").is(":checked") && document.getElementById("imgBtop").files.length > 0){
						formdata.append('imgBtop', $('#imgBtop')[0].files[0]);
					}
					else
					{
						formdata.append('topbannerurl', encodeURIComponent("https://toolhub.cyou/template/img/BannerTop540x120.png")); //Online
						//formdata.append('topbannerurl', encodeURIComponent("http://localhost:8080/seotoolstationclonefront/template/img/BannerTop540x120.png"));//Local						
					}
					
					if(!$("#cbDefaultTopRight").is(":checked") && document.getElementById("imgBrtop").files.length > 0){
						formdata.append('imgBrtop', $('#imgBrtop')[0].files[0]);
					}
					else
					{
						formdata.append('bannerrighttopurl', encodeURIComponent("https://toolhub.cyou/template/img/BannerRightTop220x540.png")); //Online
						//formdata.append('bannerrighttopurl', encodeURIComponent("http://localhost:8080/seotoolstationclonefront/template/img/BannerRightTop220x540.png")); //Local
					}
					
					if(!$("#cbDefaultBottomRight").is(":checked") && document.getElementById("imgBrbottom").files.length > 0){
						formdata.append('imgBrbottom', $('#imgBrbottom')[0].files[0]);
					}
					else
					{
						formdata.append('bannerrightbottomurl', encodeURIComponent("https://toolhub.cyou/template/img/BannerRightBottom220x300.png")); //Online
						//formdata.append('bannerrightbottomurl', encodeURIComponent("http://localhost:8080/seotoolstationclonefront/template/img/BannerRightBottom220x300.png")); //Local
					}
					
					if(!$("#cbDefaultBottom").is(":checked") && document.getElementById("imgBbottom").files.length > 0){
						formdata.append('imgBbottom', $('#imgBbottom')[0].files[0]);
					}
					else
					{
						formdata.append('bottombannerurl', encodeURIComponent("https://toolhub.cyou/template/img/BannerBottom540x120.png")); //Online
						//formdata.append('bottombannerurl', encodeURIComponent("http://localhost:8080/seotoolstationclonefront/template/img/BannerBottom540x120.png")); //Local
					}
					
					if($("#cbenable").is(":checked")){
						formdata.append("enable","1");
						formdata.append("settings","save");
					}
					else{
						formdata.append("enable","0");
						formdata.append("settings","save");
					}
					formdata.append("tool_id",$("#tool_id").children("option:selected").val());
					
					$.ajax({
						type:'POST',
						data:formdata,
						url:'bannersettings.php',
						processData: false,
						contentType: false,
						success:function(data) {
							//console.log(data);
							$('.c-alert--success').find("label").text("Banner Settings Saved Successfully!");
							$('.c-alert--success').show();
							setTimeout(function(){
								SetValues($("#tool_id").children("option:selected").val());
							},1000);
						}
					}).fail(function (jqXHR, textStatus, error) {
						$('#editor-content-container').html(jqXHR.responseText);
						$('.c-alert--danger').find("label").text("Something Went Wrong!");
						$('.c-alert--danger').show();
					});
				}
				else{
					
					if(!$("#cbDefaultTop").is(":checked") && document.getElementById("imgBtop").files.length == 0)
					{
						$('.c-alert--danger').find("label").text("Please Provide Image or Select Set Default Banner Top");
						$('.c-alert--danger').show();
					}
					else if(!$("#cbDefaultTopRight").is(":checked") && document.getElementById("imgBrtop").files.length == 0)
					{
						$('.c-alert--danger').find("label").text("Please Provide Image or Select Set Default Banner Right(Top)");
						$('.c-alert--danger').show();
					}
					else if(!$("#cbDefaultBottomRight").is(":checked") && document.getElementById("imgBrbottom").files.length == 0)
					{
						$('.c-alert--danger').find("label").text("Please Provide Image or Select Set Default Banner Right(Bottom)");
						$('.c-alert--danger').show();
					}
					else if(!$("#cbDefaultBottom").is(":checked") && document.getElementById("imgBbottom").files.length == 0)
					{
						$('.c-alert--danger').find("label").text("Please Provide Image or Select Set Default Banner Bottom");
						$('.c-alert--danger').show();
					}
				}
			})
			
			$(document).on('change', 'select', function() {
				//console.log($(this).val()); // the selected options’s value
				SetValues($(this).val());
			});
		});
		//https://makitweb.com/how-to-upload-multiple-image-files-with-jquery-ajax-and-php/
		</script>
	</body>
</html>