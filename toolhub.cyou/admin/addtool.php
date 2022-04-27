<?php

$notify = "";
// Adding tools
if (isset($_POST['add_tool'])) {

    include_once('../inc/DB.php');


    if ((!empty($_POST["tool_name"]) && isset($_POST["tool_name"])) && (!empty($_POST["tool_url"]) && isset($_POST["tool_url"])) && (!empty($_FILES["tool_icon"]) && isset($_FILES["tool_icon"])) && (!empty($_POST["tool_status"]) && isset($_POST["tool_status"]))) 
	{
        $target_dir = "../front/tool-icons/";
        $target_file = $target_dir . basename($_FILES["tool_icon"]["name"]);
        $tool_icon = $_FILES["tool_icon"]["name"];

        $tool_name = mysqli_real_escape_string($conn, trim($_POST['tool_name']));

        $tool_description = mysqli_real_escape_string($conn, trim($_POST['tool_description']));

        $tool_url = mysqli_real_escape_string($conn, trim($_POST['tool_url']));

        $tool_icon =  mysqli_real_escape_string($conn, "https://www.toolhub.cyou/tool-icons/" . trim($tool_icon));

        $tool_status = mysqli_real_escape_string($conn, trim($_POST['tool_status']));

        $query = "INSERT INTO tools (tool_name,tool_description,tool_url,tool_icon,status)
                    VALUES('$tool_name','$tool_description','$tool_url','$tool_icon','$tool_status')";
        move_uploaded_file($_FILES["tool_icon"]["tmp_name"], $target_file);

        echo $query . '<br>';
        // exit;
        // $stmt = false;

        $stmt = mysqli_query($conn, $query);
        //var_dump($stmt);
        //exit;
        if ($stmt) {

            $notify = '<div class="c-alert c-alert--success alert"><i class="c-alert__icon fa fa-check-circle"></i>
                    <label>Tool Added Successfully!.</label>
                    <button class="c-close" data-dismiss="alert" type="button">×</button></div>';
			
			header( "refresh:3;url=dashboard.php" );
        } else {

            $notify = '<div class="c-alert c-alert--danger alert"><i class="c-alert__icon fa fa-times-circle"></i> 
                    <label>Something Went Wrong!</label>
                    <button class="c-close" data-dismiss="alert" type="button">×</button></div>';
        }
    } else {
        $notify = '<div class="c-alert c-alert--danger alert"><i class="c-alert__icon fa fa-times-circle"></i> 
                    <label>All Fields Are Required!</label>
                    <button class="c-close" data-dismiss="alert" type="button">×</button></div>';
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
                            <a class="c-menu__link is-active card" href="addtool.php" style="background-color: #2ea1f8;color: #fff;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;">
                                <i class="c-menu__icon fa fa-plus" style="color:white;"></i>Add Tool
                            </a>
                        </li>

                        <li class="c-menu__item">
                            <a class="c-menu__link" href="advertisment.php">
                                <i class="c-menu__icon fa fa-eye"></i>Advertisment Settings
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
                    <h2 class="u-h3 u-mb-small"><i class="c-menu__icon fa fa-plus"></i> Add New Tool</h2>
                    <?php echo $notify; ?>
                    <div class="row u-mb-large">
                        <?php require_once('../inc/alerts.php'); ?>
                        <div class="col-sm-12">
                            <div class="c-table-responsive@desktop">
                                <form class="c-search-form c-search-form--dark card" method="POST" action="addtool.php" enctype="multipart/form-data">

                                    <!--<h5 class="c-search-form__label">Sort By</h5>
										<div class="c-search-form__section u-flex">
											<div class="c-choice c-choice--radio u-mr-small">
												<input class="c-choice__input" id="radio1" name="radios" type="radio">
												<label class="c-choice__label" for="radio1">Related to you</label>
											</div>

											<div class="c-choice c-choice--radio">
												<input class="c-choice__input" id="radio2" name="radios" type="radio">
												<label class="c-choice__label" for="radio2">Name</label>
											</div>
										</div>

										<h5 class="c-search-form__label">Only</h5>
										<div class="c-search-form__section">
											<div class="c-choice c-choice--checkbox">
												<input class="c-choice__input" id="checkbox1" name="checkboxes" type="checkbox">
												<label class="c-choice__label" for="checkbox1">In Your Circles</label>
											</div>

											<div class="c-choice c-choice--checkbox">
												<input class="c-choice__input" id="checkbox2" name="checkboxes" type="checkbox">
												<label class="c-choice__label" for="checkbox2">Available for work</label>
											</div>

											<div class="c-choice c-choice--checkbox">
												<input class="c-choice__input" id="checkbox3" name="checkboxes" type="checkbox">
												<label class="c-choice__label" for="checkbox3">Active Users</label>
											</div>
										</div>-->

                                    <div class="c-search-form__section">
                                        <div class="c-field has-icon-left">
                                            <span class="c-field__icon"><i class="fa fa-cog"></i></span>
                                            <label class="c-field__label c-search-form__label" for="tool_name">Tool Name</label>
                                            <input class="c-input" id="tool_name" name="tool_name" type="text" placeholder="Tool Name">
                                            <small class="c-field__message">Enter a Tool Name</small>
                                        </div>
                                    </div>

                                    <div class="c-search-form__section">
                                        <div class="c-field has-icon-left">
                                            <span class="c-field__icon"><i class="fa fa-link"></i></span>
                                            <label class="c-field__label c-search-form__label" for="tool_url">Tool Url</label>
                                            <input class="c-input" id="tool_url" name="tool_url" type="text" placeholder="Tool URL">
                                            <small class="c-field__message">Enter a Tool URL</small>
                                        </div>
                                    </div>

                                    <div class="c-search-form__section">
                                            <label class="c-field__label c-search-form__label" for="tool_description">Tool Description</label>
                                            <textarea class="c-input" id="tool_description" name="tool_description"  placeholder="Tool Description"></textarea>
                                            <small class="c-field__message">Enter a Tool Description</small>
                                    </div>

                                    <div class="c-search-form__section">
                                        <div class="c-field has-icon-left">
                                            <span class="c-field__icon"><i class="fa fa-file-image-o"></i></span>
                                            <label class="c-field__label c-search-form__label" for="tool_icon">Tool Icon</label>
                                            <input class="c-input" id="tool_icon" name="tool_icon" type="file">
                                            <small class="c-field__message">Insert Tool Icon</small>
                                        </div>
                                    </div>

                                    <div class="c-search-form__section">
                                        <div class="c-field has-icon-left">
                                            <!-- <span class="c-field__icon"></span> -->
                                            <label class="c-field__label c-search-form__label" for="tool_icon"> Status</label>

                                            <input class="c-choice--radio" name="tool_status" type="radio" checked value="1">

                                            <span style="color: #7f8fa4;font-weight: 600">Activate</span>

                                            <input class="c-choice--radio" name="tool_status" type="radio" value="0">

                                            <span style="color: #7f8fa4;font-weight: 600">De-Activate</span>

                                            <small class="c-field__message" style="display:block;">Select Tool Status</small>
                                        </div>
                                    </div>

                                    <button class="c-btn c-btn--info" type="submit" name="add_tool">Add Tool</button>
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
	CKEDITOR.replace('tool_description');
	CKEDITOR.instances.tool_description.on('change', function() { 
		console.log(CKEDITOR.instances.tool_description.getData());
		$("#tool_description").val(encodeURIComponent(CKEDITOR.instances.tool_description.getData()));
	});
	</script>
</body>

</html>