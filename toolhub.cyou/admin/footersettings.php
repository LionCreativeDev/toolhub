<?php 
session_start();

if (!isset($_SESSION["userid"])) {
	header('location: login.php');
}

if(isset($_POST["settings"]) && trim($_POST["settings"]) !== '' && trim($_POST["settings"]) === 'save'){
	include_once('../inc/DB.php');
	
	$facebook = mysqli_real_escape_string($conn, trim($_POST['facebook']));
	$twitter = mysqli_real_escape_string($conn, trim($_POST['twitter']));
	$linkedin = mysqli_real_escape_string($conn, trim($_POST['linkedin']));
	$pinterest = mysqli_real_escape_string($conn, trim($_POST['pinterest']));
	$behance = mysqli_real_escape_string($conn, trim($_POST['behance']));
	$dribbble = mysqli_real_escape_string($conn, trim($_POST['dribbble']));
	
	//echo $csv_string;
	//exit;
	
	$query = "Update footer set facebook='".$facebook."', twitter='".$twitter."', linkedin='".$linkedin."', pinterest='".$pinterest."', behance='".$behance."', dribbble='".$dribbble."' where id='1';";
	
	if (mysqli_query($conn, $query)) {
		http_response_code(200);
        echo 'success';
	} else {
		http_response_code(405);
		echo 'failure';
	}
	exit;
}

$facebook = '';
$twitter = '';
$linkedin = '';
$pinterest = '';
$behance = '';
$dribbble = '';

include_once('../inc/DB.php');

$sql = "SELECT * FROM `footer` where id='1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {												
		//echo  '<option value="'.$row["tool_id"].'">'.$row["tool_name"].'</option>';
		$facebook=$row["facebook"];
		$twitter=$row["twitter"];
		$linkedin=$row["linkedin"];
		$pinterest=$row["pinterest"];
		$behance=$row["behance"];
		$dribbble=$row["dribbble"];
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
                                    <i class="c-menu__icon fa fa-cog"></i>Footer Settings
                                </a>
                            </li>
                            
                            <li class="c-menu__item">
                                <a class="c-menu__link is-active card" href="footersettings.php" style="background-color: #2ea1f8;color: #fff;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;">
                                    <i class="c-menu__icon fa fa-cog" style="color:white;"></i>Settings
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
												<span class="c-field__icon"><i class="fa fa-facebook"></i></span>
												<label class="c-field__label c-search-form__label" for="txtFacebook">Facebook</label>
												<input class="c-input" id="txtFacebook" name="txtFacebook" type="text" placeholder="ie: https://www.facebook.com/toolhub" value="<?php echo $facebook; ?>">
												<small class="c-field__message">Enter a facebook page page url</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-twitter"></i></span>
												<label class="c-field__label c-search-form__label" for="txtTwitter">Twitter</label>
												<input class="c-input" id="txtTwitter" name="txtTwitter" type="text" placeholder="ie: http://twitter.com/toolhub" value="<?php echo $twitter; ?>">
												<small class="c-field__message">Enter a twitter page page url</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-linkedin"></i></span>
												<label class="c-field__label c-search-form__label" for="txtLinkedIn">LinkedIn</label>
												<input class="c-input" id="txtLinkedIn" name="txtLinkedIn" type="text" placeholder="ie: https://www.linkedin.com/in/toolhub" value="<?php echo $linkedin; ?>">
												<small class="c-field__message">Enter a linkedin page page url</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-pinterest"></i></span>
												<label class="c-field__label c-search-form__label" for="txtPinterest">Pinterest</label>
												<input class="c-input" id="txtPinterest" name="txtPinterest" type="text" placeholder="ie: https://www.pinterest.com/" value="<?php echo $pinterest; ?>">
												<small class="c-field__message">Enter a pinterest page page url</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-behance"></i></span>
												<label class="c-field__label c-search-form__label" for="txtBehance">Behance</label>
												<input class="c-input" id="txtBehance" name="txtBehance" type="text" placeholder="ie: https://www.behance.net/toolhub" value="<?php echo $behance; ?>">
												<small class="c-field__message">Enter a behance page page url</small>
											</div>
										</div>
										
										<div class="c-search-form__section">
											<div class="c-field has-icon-left">
												<span class="c-field__icon"><i class="fa fa-dribbble"></i></span>
												<label class="c-field__label c-search-form__label" for="txtDribbble">Dribbble</label>
												<input class="c-input" id="txtDribbble" name="txtDribbble" type="text" placeholder="ie: https://dribbble.com/shots/toolhub" value="<?php echo $dribbble; ?>">
												<small class="c-field__message">Enter a dribbble page page url</small>
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
		<script>
		$(document).ready(function(){
			$("button").on("click", function(e){
				e.preventDefault();
				$('.c-alert').hide();
				
				var dataString = 'facebook='+$("#txtFacebook").val()+'&twitter='+$("#txtTwitter").val()+'&linkedin='+$("#txtLinkedIn").val()+'&pinterest='+$("#txtPinterest").val()+'&behance='+$("#txtBehance").val()+'&dribbble='+$("#txtDribbble").val()+"&settings=save";
				//console.log(dataString);
				$.ajax({
					type:'POST',
					data:dataString,
					url:'footersettings.php',
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
		});
		</script>
	</body>
</html>