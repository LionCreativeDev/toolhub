<?php 
session_start();

if (!isset($_SESSION["userid"])) {
	header('location: login.php');
}

$title='';
$keywords='';
$description='';
$pagecontent='';

if(isset($_POST["tool_id"]) && trim($_POST["tool_id"]) !== '' && isset($_POST["settings"]) && trim($_POST["settings"]) !== '' && trim($_POST["settings"]) === 'save'){
// && isset($_POST["tag"]) && trim($_POST["tag"]) !== '' 
// && isset($_POST["topadvertisment"]) && trim($_POST["topadvertisment"]) !== '' 
// && isset($_POST["topenable"]) && trim($_POST["topenable"]) !== ''
// && isset($_POST["bottomadvertisment"]) && trim($_POST["bottomadvertisment"]) !== ''
// && isset($_POST["bottomenable"]) && trim($_POST["bottomenable"]) !== '')

	// echo $_POST["tag"].'</br>';
	// echo $_POST["topadvertisment"].'</br>';
	// echo $_POST["topenable"].'</br>';
	// echo $_POST["bottomadvertisment"].'</br>';
	// echo $_POST["bottomenable"].'</br>';
	include_once('../inc/DB.php');
	
	$tool_id = mysqli_real_escape_string($conn, trim($_POST['tool_id']));
	
	$queryparts = [];
	if(isset($_POST["pagetitle"]) && trim($_POST["pagetitle"]) !== '')
		array_push($queryparts, "tool_title='".trim($_POST["pagetitle"])."'");
	else
		array_push($queryparts, "tool_title=''");
	
	if(isset($_POST["metakeywords"]) && trim($_POST["metakeywords"]) !== '')
		array_push($queryparts, "meta_keyword='".base64_encode(trim($_POST["metakeywords"]))."'");
	else
		array_push($queryparts, "meta_keyword=''");
	
	if(isset($_POST["metadescription"]) && trim($_POST["metadescription"]) !== '')
		array_push($queryparts, "meta_description='".base64_encode(trim($_POST["metadescription"]))."'");
	else
		array_push($queryparts, "meta_description=''");
	
	if(isset($_POST["pagecontent"]) && trim($_POST["pagecontent"]) !== '')
		array_push($queryparts, "tool_text='".(trim($_POST["pagecontent"]))."'");
	else
		array_push($queryparts, "tool_text=''");
	
	$csv_string = implode(',', $queryparts);
	//echo $csv_string;
	//exit;
	
	$query = "Update settings set ".$csv_string.' where tools_id=\''.$tool_id.'\';';
	//echo $query;
	//mysqli_query($conn, $query);
	
	if (mysqli_query($conn, $query)) {
		http_response_code(200);
        echo 'success';
	} else {
		http_response_code(405);
		echo 'failure';
	}
	exit;
}
elseif(isset($_POST["tool_id"]) && trim($_POST["tool_id"]) !== '' && isset($_POST["action"]) && trim($_POST["action"]) !== '' && trim($_POST["action"]) === 'settings')
{
	include_once('../inc/DB.php');
	$tool_id = mysqli_real_escape_string($conn, trim($_POST['tool_id']));
	
	$sql = "SELECT * FROM `settings` where tools_id='".$tool_id."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {												
			//echo  '<option value="'.$row["tool_id"].'">'.$row["tool_name"].'</option>';
			$title=$row["tool_title"];
			$keywords=$row["meta_keyword"];
			$description=$row["meta_description"];
			$pagecontent=$row["tool_text"];
			
			echo '{"title":"'.$title.'","keywords":"'.$keywords.'","description":"'.$description.'","pagecontent":"'.base64_encode($pagecontent).'"}';
		}
	}
	exit;
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
                                <a class="c-menu__link is-active card" href="settings.php" style="background-color: #2ea1f8;color: #fff;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;">
                                    <i class="c-menu__icon fa fa-cog" style="color:white;"></i>Settings
                                </a>
                            </li>
                            
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="footersettings.php">
                                    <i class="c-menu__icon fa fa-cog"></i>Footer Settings
                                </a>
                            </li>
                            
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="bannersettings.php">
                                    <i class="c-menu__icon fa fa-image"></i>Banners Settings
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
                        <h2 class="u-h3 u-mb-small">Settings</h2>
						
						<div class="row u-mb-large">
							<?php require_once('../inc/alerts.php'); ?>
							<div class="col-sm-12">
								<div class="c-table-responsive@desktop">
									<form class="c-search-form c-search-form--dark card">
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-cog"></i></span>
												<label class="c-field__label c-search-form__label" for="txtScriptTag">Tool Page Title</label>
												<select id="tool_id" class="c-input">
												<option value="-1">Index</option>
												<option value="-2">About</option>
												<option value="-3">Contact Us</option>
												<?php include_once('../inc/DB.php');
				
												$sql = "SELECT * FROM `tools`";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													while ($row = $result->fetch_assoc()) {												
														echo  '<option value="'.$row["tool_id"].'">'.$row["tool_name"].'</option>';
													}
												}?>
													
												</select>
												<small class="c-field__message">Enter a tool page title for search engine and browser</small>
											</div>
										</div>
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-globe"></i></span>
												<label class="c-field__label c-search-form__label" for="txtPageTitle">Tool Page Title</label>
												<input class="c-input" id="txtPageTitle" name="txtPageTitle" type="text" placeholder="ie: Toolhub" value="">
												<small class="c-field__message">Enter a tool page title for search engine and browser</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-globe"></i></span>
												<label class="c-field__label c-search-form__label" for="txtMetaKeyword">Tool Meta Keyword</label>
												<input class="c-input" id="txtMetaKeyword" name="txtMetaKeyword" type="text" placeholder="ie: seo tools, free seo tool" value="">
												<small class="c-field__message">Enter a tool page meta keywords(s) for search engine</small>
											</div>
										</div>

										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-google"></i></span>
												<label class="c-field__label c-search-form__label" for="txtMetaDescription">Tool Meta Description</label>
												<textarea class="c-input" id="txtMetaDescription" name="txtMetaDescription"></textarea>
												<small class="c-field__message">Enter a tool page meta description for search engine</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-globe" style="display:none;"></i></span>
												<label class="c-field__label c-search-form__label" for="txtPageText">Tool Page Text</label>
												<textarea class="c-input" id="txtPageText" name="txtPageText"></textarea>
												<small class="c-field__message">Enter a tool page text</small>
											</div>
										</div>
													
										<button class="c-btn c-btn--info" type="submit">Save Settings</button>
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
		<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
		<script>
		$(document).ready(function(){
			$("#txtPageTitle").val("");
			$("#txtMetaKeyword").val("");
			$("#txtMetaDescription").val("");
			$("#txtPageText").val("");
			CKEDITOR.replace('txtPageText');
			
			function SetValues(toolid){
				var dataString = 'tool_id='+encodeURIComponent(toolid)+"&action=settings";
				//console.log(dataString);
				$.ajax({
					type:'POST',
					data:dataString,
					url:'settings.php',
					success:function(data) {						
						console.log(data);
						var data = JSON.parse(data);
						$("#txtPageTitle").val(data["title"]);
						$("#txtMetaKeyword").val(atob(data["keywords"]));
						$("#txtMetaDescription").val(atob(data["description"]));
						//$("#txtPageText").val(atob(data["pagecontent"]));
						CKEDITOR.instances.txtPageText.setData(atob(data["pagecontent"]));
					}
				}).fail(function (jqXHR, textStatus, error) {
					$('#editor-content-container').html(jqXHR.responseText);
					$('.c-alert--danger').find("label").text("Something Went Wrong!");
					$('.c-alert--danger').show();
				});
			}
			
			setTimeout(function(){
				SetValues("-1");
			},1000);
			
			$(document).on('change', 'select', function() {
				console.log($(this).val()); // the selected options’s value

				// if you want to do stuff based on the OPTION element:
				//var opt = $(this).find('option:selected')[0];
				// use switch or if/else etc.
				
				//var dataString = 'tool_id='+encodeURIComponent($(this).val())+"&action=settings";
				//console.log(dataString);
				// $.ajax({
					// type:'POST',
					// data:dataString,
					// url:'settings.php',
					// success:function(data) {						
						// console.log(data);
						// var data = JSON.parse(data);
						// $("#txtPageTitle").val(data["title"]);
						// $("#txtMetaKeyword").val(data["keywords"]);
						// $("#txtMetaDescription").val(data["description"]);
						// $("#txtPageText").val(data["pagecontent"]);
					// }
				// }).fail(function (jqXHR, textStatus, error) {
					// $('#editor-content-container').html(jqXHR.responseText);
					// $('.c-alert--danger').find("label").text("Something Went Wrong!");
					// $('.c-alert--danger').show();
				// });
				SetValues($(this).val());
			});
			
			$("button").on("click", function(e){
				e.preventDefault();
				$('.c-alert').hide();
				var pagetitle = $("#txtPageTitle").val();
				var metakeywords = $("#txtMetaKeyword").val();
				var metadescription = $("#txtMetaDescription").val();
				var pagecontent = CKEDITOR.instances.txtPageText.getData();//$("#txtPageText").val();
				
				var dataString = 'tool_id='+$("select").val()+'&pagetitle='+encodeURIComponent(pagetitle)+'&metakeywords='+encodeURIComponent(metakeywords)+'&metadescription='+encodeURIComponent(metadescription)+'&pagecontent='+encodeURIComponent(pagecontent)+"&settings=save";
				//console.log(dataString);
				$.ajax({
					type:'POST',
					data:dataString,
					url:'settings.php',
					success:function(data) {
						console.log(data);
						$('.c-alert--success').find("label").text("Page Settings Saved Successfully!");
						$('.c-alert--success').show();
					}
				}).fail(function (jqXHR, textStatus, error) {
					$('#editor-content-container').html(jqXHR.responseText);
					$('.c-alert--danger').find("label").text("Something Went Wrong!");
					$('.c-alert--danger').show();
				});
				
			})
		})
		</script>
	</body>
</html>