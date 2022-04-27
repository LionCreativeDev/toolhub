<?php
include_once('../inc/DB.php');
$tool_id = '';
if (isset($_GET["tool_id"]) && !empty($_GET["tool_id"])) {


    $tool_id = $_GET["tool_id"];

    $notify = "";
    $stmt = mysqli_query($conn, "SELECT * FROM tools WHERE tool_id = '$tool_id'");
    $row = $stmt->fetch_assoc();

    $tool_name = $row['tool_name'];
    $tool_description = $row['tool_description'];
    $tool_url = $row['tool_url'];
    $tool_icon = $row['tool_icon'];
    $tool_status = $row['status'];    
} else {
    header("Location: dashboard.php");
}

if (isset($_POST['edit_tool'])) {

	//include_once('../inc/DB.php');

	if ((!empty($_POST["tool_name"]) && isset($_POST["tool_name"])) && (!empty($_POST["tool_url"]) && isset($_POST["tool_url"])) && (isset($_POST["tool_status_edit"])))
	{
		$target_dir = "../front/tool-icons/";
		$target_file = $target_dir . basename($_FILES["tool_icon"]["name"]);


		if ($_FILES["tool_icon"]["name"] != "") {

			$tool_icon_edit = "https://toolhub.cyou/tool-icons/" . $_FILES["tool_icon"]["name"];

			move_uploaded_file($_FILES["tool_icon"]["tmp_name"], $target_file);

			$pos = strrpos($tool_icon, '/');

			$delete_icon_name = substr($tool_icon, $pos);

			$delete_tool_icon = '';
			$delete_tool_icon = "../front/tool-icons" . $delete_icon_name;

			unlink($delete_tool_icon);
		} else {
			$tool_icon_edit = $tool_icon;
		}

		$tool_name_edit = mysqli_real_escape_string($conn, trim($_POST['tool_name']));

		$tool_description_edit = mysqli_real_escape_string($conn, trim($_POST['tool_description']));

		$tool_url_edit = mysqli_real_escape_string($conn, trim($_POST['tool_url']));

		$tool_icon_edit =  mysqli_real_escape_string($conn, trim($tool_icon_edit));

		$tool_status_edit = mysqli_real_escape_string($conn, trim($_POST['tool_status_edit']));

		$query = "UPDATE tools SET tool_name='$tool_name_edit' , tool_description='$tool_description_edit', tool_url='$tool_url_edit' , tool_icon='$tool_icon_edit' , status='$tool_status_edit' WHERE tool_id='$tool_id'";

		$stmt = mysqli_query($conn, $query);

		if ($stmt) {
			$stmt = mysqli_query($conn, "SELECT * FROM tools WHERE tool_id = '$tool_id'");
			$row = $stmt->fetch_assoc();

			$tool_name = $row['tool_name'];
			$tool_description = $row['tool_description'];
			$tool_url = $row['tool_url'];
			$tool_icon = $row['tool_icon'];
			$tool_status = $row['status']; 
			
			$notify = '<div class="c-alert c-alert--success alert"><i class="c-alert__icon fa fa-check-circle"></i>
				<label>Tool Edit Successfully!.</label>
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
                            <a class="c-menu__link" href="addtool.php">
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
                    <h2 class="u-h3 u-mb-small"> <i class="c-menu__icon fa fa-edit"></i> Edit Tool</h2>
                    <?php echo $notify; ?>
                    <div class="row u-mb-large">
                        <?php require_once('../inc/alerts.php'); ?>
                        <div class="col-sm-12">
                            <div class="c-table-responsive@desktop">
                                <form action="edittool.php?tool_id=<?php echo trim($_GET["tool_id"]); ?>" class="c-search-form c-search-form--dark card" method="POST" enctype="multipart/form-data">

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
                                            <input class="c-input" id="tool_name" name="tool_name" type="text" placeholder="Tool Name" value="<?php echo $tool_name; ?>">
                                            <small class="c-field__message">Enter a Tool Name</small>
                                        </div>
                                    </div>

                                    <div class="c-search-form__section">
                                        <label class="c-field__label c-search-form__label" for="tool_description">Tool Description</label>
                                        <textarea class="c-input" id="tool_description" name="tool_description" placeholder="Tool Description">
                                            <?php echo $tool_description; ?>
                                        </textarea>
                                        <small class="c-field__message">Enter a Tool Description</small>
                                    </div>

                                    <div class="c-search-form__section">
                                        <div class="c-field has-icon-left">
                                            <span class="c-field__icon"><i class="fa fa-link"></i></span>
                                            <label class="c-field__label c-search-form__label" for="tool_url">Tool Url</label>
                                            <input class="c-input" id="tool_url" name="tool_url" type="text" placeholder="Tool URL" value="<?php echo $tool_url; ?>">
                                            <small class="c-field__message">Enter a Tool URL</small>
                                        </div>
                                    </div>

                                    <div class="c-search-form__section">
                                        <div class="c-field has-icon-left">
                                            <span class="c-field__icon"><i class="fa fa-file-image-o"></i></span>
                                            <label class="c-field__label c-search-form__label" for="tool_icon">Tool Icon</label>
                                            <input class="c-input" id="tool_icon" name="tool_icon" type="file">
                                            <small class="c-field__message">Insert Tool Image</small>
                                        </div>
                                    </div>

                                    <div class="c-search-form__section">
                                        <div class="c-field has-icon-left">
                                            <label class="c-field__label c-search-form__label" for="tool_icon"> <i class="fa fa-picture-o"></i> Previous Tool Icon</label>
                                            <img src="<?php echo $tool_icon ?>" width="140px" height="140px" />
                                        </div>
                                    </div>

                                    <div class="c-search-form__section">
                                        <div class="c-field has-icon-left">
                                            <label class="c-field__label c-search-form__label" for="tool_icon"> Previous Tool Status</label>
                                            <span style="color: #7f8fa4;font-weight: 600">
                                                <?php echo ($tool_status == "1") ? "<p style='color:green;'>Activated</p>" : "<p style='color:red;'>Un-Activated</p>"; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="c-search-form__section">
                                        <div class="c-field has-icon-left">
                                            <!-- <span class="c-field__icon"></span> -->
                                            <label class="c-field__label c-search-form__label" for="tool_icon"> Status</label>

                                            <input class="c-choice--radio" name="tool_status_edit" type="radio" value="1" <?php echo ($tool_status == "1") ? "checked" : ""; ?>>

                                            <span style="color: #7f8fa4;font-weight: 600">Activate</span>

                                            <input class="c-choice--radio" name="tool_status_edit" type="radio" value="0" <?php echo ($tool_status == "0") ? "checked" : ""; ?>>

                                            <span style="color: #7f8fa4;font-weight: 600">De-Activate</span>

                                            <small class="c-field__message" style="display:block;">Select Tool Status</small>
                                        </div>
                                    </div>


                                    <button class="c-btn c-btn--info" type="submit" name="edit_tool">Save Changes</button>
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