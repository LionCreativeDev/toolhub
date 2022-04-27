<?php 
session_start();

if (!isset($_SESSION["userid"])) {
	header('location: login.php');
}

if(isset($_POST["settings"]) && trim($_POST["settings"]) !== '' && trim($_POST["settings"]) === 'advertisment'){
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
	
	$queryparts = [];
	if(isset($_POST["topadvertisment"]) && trim($_POST["topadvertisment"]) !== '')
		array_push($queryparts, "advertise_top='".base64_encode(trim($_POST["topadvertisment"]))."'");
	else
		array_push($queryparts, "advertise_top=''");
	
	if(isset($_POST["topenable"]) && trim($_POST["topenable"]) !== '')
		array_push($queryparts, "advertise_top_enable='".(trim($_POST["topenable"]) === 'true' ? '1' : '0')."'");
	
	if(isset($_POST["bottomadvertisment"]) && trim($_POST["bottomadvertisment"]) !== '')
		array_push($queryparts, "advertise_bottom='".base64_encode(trim($_POST["bottomadvertisment"]))."'");
	else
		array_push($queryparts, "advertise_bottom=''");
	
	if(isset($_POST["bottomenable"]) && trim($_POST["bottomenable"]) !== '')
		array_push($queryparts, "advertise_bottom_enable='".(trim($_POST["bottomenable"]) === 'true' ? '1' : '0')."'");
	
	if(isset($_POST["tag"]) && trim($_POST["tag"]) !== '')
		array_push($queryparts, "script_tag='".base64_encode(trim($_POST["tag"]))."'");
	else
		array_push($queryparts, "script_tag=''");
	
	$csv_string = implode(',', $queryparts);
	//echo $csv_string;
	//exit;
	
	include_once('../inc/DB.php');
	$query = "Update advertisement set ".$csv_string;
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
							
                            <!--<li class="c-menu__item">
                                <a class="c-menu__link" href="edittool.php">
                                    <i class="c-menu__icon fa fa-edit"></i>Edit Tool
                                </a>
                            </li>-->
							
							<li class="c-menu__item">
                                <a class="c-menu__link is-active card" href="advertisment.php" style="background-color: #2ea1f8;color: #fff;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;">
                                    <i class="c-menu__icon fa fa-eye" style="color:white;"></i>Advertisment Settings
                                </a>
                            </li>
                            
                            <li class="c-menu__item">
                                <a class="c-menu__link" href="settings.php">
                                    <i class="c-menu__icon fa fa-cog"></i>Settings
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
                        <h2 class="u-h3 u-mb-small"><i class="c-menu__icon fa fa-eye"></i> Advertisment</h2>
						
						<div class="row u-mb-large">
							<?php require_once('../inc/alerts.php'); ?>
							<div class="col-sm-12">
								<div class="c-table-responsive@desktop">
									<form class="c-search-form c-search-form--dark card">
											<?php include_once('../inc/DB.php');
				
												$sql = "SELECT * FROM `advertisement`";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													while ($row = $result->fetch_assoc()) {
													?>
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-map-marker"></i></span>
												<label class="c-field__label c-search-form__label" for="txtScriptTag">Script Tag</label>
												<input class="c-input" id="txtScriptTag" name="txtScriptTag" type="text" placeholder="ie <script data-ad-client='ca-pub-1234567890987654' async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>" value="<?php echo (isset($row["script_tag"])) ? htmlspecialchars(base64_decode($row["script_tag"])) : '';?>">
												<small class="c-field__message">Enter a script tag for google advertisment</small>
											</div>
										</div>

										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-eye"></i></span>
												<label class="c-field__label c-search-form__label" for="txtTopAdvertisment">Top Advertisment</label>
												<textarea class="c-input" id="txtTopAdvertisment" name="txtTopAdvertisment"><?php echo (isset($row["advertise_top"])) ? htmlspecialchars(base64_decode($row["advertise_top"])) : '';?></textarea>
												<small class="c-field__message">Code For Top Advertisment.</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-eye"></i></span>
												<label class="c-field__label c-search-form__label" for="search-position">Enable/Disable Top Advertisment</label>
												<div class="u-block u-mb-xsmall">
													<div class="c-switch cbtop <?php echo (isset($row["advertise_top_enable"]) && $row["advertise_top_enable"] === '1') ? 'is-active' : '';?>">
														<input class="c-switch__input" id="cbTop" name="cbTop" type="checkbox" <?php echo (isset($row["advertise_top_enable"]) && $row["advertise_top_enable"] === '1') ? 'checked="checked"' : '';?>>
														<label class="c-switch__label" for="cbTop"><?php echo (isset($row["advertise_top_enable"]) && $row["advertise_top_enable"] === '1') ? 'Disable' : 'Enable';?> Top Advertisment</label>
													</div>
												</div>
												<small class="c-field__message">To Enable/Disable Advertisment On Top.</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-eye"></i></span>
												<label class="c-field__label c-search-form__label" for="txtBottomAdvertisment">Bottom Advertisment</label>
												<textarea class="c-input" id="txtBottomAdvertisment" name="txtBottomAdvertisment"><?php echo (isset($row["advertise_bottom"])) ? htmlspecialchars(base64_decode($row["advertise_bottom"])) : '';?></textarea>
												<small class="c-field__message">Code For Bottom Advertisment.</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-eye"></i></span>
												<label class="c-field__label c-search-form__label" for="search-position">Enable/Disable Bottom Advertisment</label>
												<div class="u-block u-mb-xsmall">
													<div class="c-switch cbbottom <?php echo (isset($row["advertise_bottom_enable"]) && $row["advertise_bottom_enable"] === '1') ? 'is-active' : '';?>">
														<input class="c-switch__input" id="cbBottom" name="cbBottom" type="checkbox" <?php echo (isset($row["advertise_bottom_enable"]) && $row["advertise_bottom_enable"] === '1') ? 'checked="checked"' : '';?>>
														<label class="c-switch__label" for="cbBottom"><?php echo (isset($row["advertise_bottom_enable"]) && $row["advertise_bottom_enable"] === '1') ? 'Disable' : 'Enable';?> Bottom Advertisment</label>
													</div>
												</div>
												<small class="c-field__message">To Enable/Disable Advertisment On Bottom.</small>
											</div>
										</div>
													<?php }
												}?>
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
		<script>
		$(document).ready(function(){
			
			$("button").on("click", function(e){
				e.preventDefault();
				$('.c-alert').hide();
				var tag = $("#txtScriptTag").val();
				var topadvertisment = $("#txtTopAdvertisment").val();
				var topenable = ($('.cbtop').find("input[type=checkbox]:checked").length > 0 ? true : false);
				var bottomadvertisment = $("#txtBottomAdvertisment").val();
				var bottomenable = ($('.cbbottom').find("input[type=checkbox]:checked").length > 0 ? true : false);
				
				var dataString = 'tag='+encodeURIComponent(tag)+'&topadvertisment='+encodeURIComponent(topadvertisment)+'&topenable='+topenable+'&bottomadvertisment='+encodeURIComponent(bottomadvertisment)+'&bottomenable='+bottomenable+"&settings=advertisment";
				//console.log(dataString);
				$.ajax({
					type:'POST',
					data:dataString,
					url:'advertisment.php',
					success:function(data) {						
						console.log(data);
						$('.c-alert--success').find("label").text("Advertisment Updated Successfully!");
						$('.c-alert--success').show();
					}
				}).fail(function (jqXHR, textStatus, error) {
					$('#editor-content-container').html(jqXHR.responseText);
					$('.c-alert--danger').find("label").text("Something Went Wrong!");
					$('.c-alert--danger').show();
				});
				
			})
			
			$(".cbtop").on("click", function(){
				if($(this).find("input[type=checkbox]:checked").length > 0)
					$(this).find("label").html("Disable Top Advertisment");
				else
					$(this).find("label").html("Enable Top Advertisment");
			})

			$(".cbbottom").on("click", function(){
				if($(this).find("input[type=checkbox]:checked").length > 0)
					$(this).find("label").html("Disable Bottom Advertisment");
				else
					$(this).find("label").html("Enable Bottom Advertisment");
			})
		})
		</script>
	</body>
</html>