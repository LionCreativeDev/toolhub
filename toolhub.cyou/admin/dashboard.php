<?php
session_start();

if (!isset($_SESSION["userid"])) {
	header('location: login.php');
}

if(isset($_POST["toolid"]) && trim($_POST["toolid"]) !== '' && isset($_POST["status"]) && trim($_POST["status"]) !== '' && isset($_POST["UpdateStatus"]) && trim($_POST["UpdateStatus"]) !== '')
{
	include_once('../inc/DB.php');
	$errors=[];
	
	$toolid = trim($_POST['toolid']);
	$status = ((trim($_POST['status']) === '0') ? 'false' : 'true');
	
	$toolid = mysqli_real_escape_string($conn, trim($toolid));
	$status = mysqli_real_escape_string($conn, trim($status));
	
	if (empty($toolid)) { array_push($errors, "tool_id is required"); }
	if (empty($status)) { array_push($errors, "status is required"); }
	
	if (count($errors) == 0) 
	{
        $query = "Update tools set status='".(($status === 'false') ? '0' : '1')."' where tool_id = '".$toolid."';";
		//echo $query;
		mysqli_query($conn, $query);
		
		$query = "SELECT * FROM `tools` where status='".(($status === 'false') ? '0' : '1')."' and tool_id = '".$toolid."' LIMIT 1;";
		$result = mysqli_query($conn,$query);
		
		if(mysqli_num_rows($result) >= 1)
		{
			http_response_code(200);
            echo 'success';
		}
		else
		{
			http_response_code(405);
			echo 'failure';
		}
	}
	else
	{
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
                                <a class="c-menu__link is-active card" href="dashboard.php" style="background-color: #2ea1f8;color: #fff;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);transition: 0.3s;">
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
                        <h2 class="u-h3 u-mb-small"><i class="c-menu__icon fa fa-dashboard"></i> Dashboard</h2>
						
						<div class="row u-mb-large">
							<?php require_once('../inc/alerts.php'); ?>
							<div class="col-sm-12">
								<div class="c-table-responsive@desktop card">
									<table class="c-table">

										<caption class="c-table__title">
											All Tools <small>32 tools</small>
											
											<!--<a class="c-table__title-action" href="#!">
												<i class="fa fa-cloud-download"></i>
											</a>-->
										</caption>

										<thead class="c-table__head c-table__head--slim">
											<tr class="c-table__row">
											  <th class="c-table__cell c-table__cell--head">Tool Name</th>
											  <th class="c-table__cell c-table__cell--head">Tool Description</th>
											  <!--<th class="c-table__cell c-table__cell--head">Tool Image</th>-->
											  <!--<th class="c-table__cell c-table__cell--head">Budget</th>-->
											  <th class="c-table__cell c-table__cell--head">Status</th>
											  <th class="c-table__cell c-table__cell--head">
												  <span class="u-hidden-visually">Actions</span>
											  </th>
											</tr>
										</thead>

										<tbody>
										<?php include_once('../inc/DB.php');
				
												$sql = "SELECT * FROM `tools`";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													while ($row = $result->fetch_assoc()) {
													?>
											<tr class="c-table__row">
												<td class="c-table__cell">
													<div class="o-media">
														<div class="o-media__img u-mr-xsmall">
															<div class="c-avatar c-avatar--xsmall">
																<img class="c-avatar__img" src="<?php echo $row["tool_icon"]; ?>" alt="tool icon">
															</div>
														</div>
														<div class="o-media__body">
															<?php echo $row["tool_name"]; ?><!--<small class="u-block u-text-mute">External Company</small>-->
														</div>
													</div>
												</td>

												<td class="c-table__cell"><?php echo ($row["tool_description"] !== '' ? $row["tool_description"] : 'No Description'); ?>
													<!--<small class="u-block u-text-mute">in 3 months</small>-->
												</td>												

												<!--<td class="c-table__cell">$5,740
													<small class="u-block u-text-mute">Invoice Sent</small>
												</td>-->

												<td class="c-table__cell">
													<?php echo (($row["status"] === '1') ? '<i class="fa fa-circle-o u-color-success u-mr-xsmall"></i>Active' : '<i class="fa fa-circle-o u-color-warning u-mr-xsmall"></i>Un-Active')?>
												</td>

												<td class="c-table__cell u-text-right">
													<div class="c-dropdown dropdown">
														<button class="c-btn c-btn--secondary has-dropdown dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
														
														<div class="c-dropdown__menu dropdown-menu" aria-labelledby="dropdownMenuButton2">
    														<?php if($row["status"] === '0'){ ?>
    															<a class="c-dropdown__item dropdown-item activate" href="">Activate</a>
    														<?php } elseif($row["status"] === '1') { ?>
    															<a class="c-dropdown__item dropdown-item deactivate" href="">Deactivate</a>
    														<?php } ?>
    														<input type="hidden" value="<?php echo $row["tool_id"]; ?>" class='tool_id'>
    														<input type="hidden" value="<?php echo $row["status"]; ?>" class='status'>
    														<a class="c-menu__link" href="edittool.php?tool_id=<?php echo $row['tool_id'] ?>" target="_blank">
    															<i class="c-menu__icon fa fa-edit"></i>Edit Tool
    														</a>
														</div>
													</div>
												</td>
											</tr>
													<?php }
												} ?>
											
										</tbody>
									</table>
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
			function doAjaxRequest(id, status)
			{
				$('.c-alert').hide();
				//var toolid = $(this).parent().find(".tool_id").val(); 
				//var status = $(this).parent().find(".status").val();
				var dataString = 'toolid='+id+'&status='+status+'&UpdateStatus=true';
				$.ajax({
					type:'POST',
					data:dataString,
					url:'dashboard.php',
					success:function(data) {
					  //console.log(data);
					  $('.c-alert--success').find("label").text("Status Updated Successfully!");
					  $('.c-alert--success').show();
					  $(".c-table").parent().load("dashboard.php .c-table");
					}
				}).fail(function (jqXHR, textStatus, error) {
					// Handle error here
					//$('#editor-content-container').html(jqXHR.responseText);
					$('.c-alert--danger').find("label").text("Something Went Wrong!");
					$('.c-alert--danger').show();
				});
			}

			//$(document).ready(function(){
			$(document).on("click", ".activate", function(e) {
				e.preventDefault();
				$(this).parent().find(".status").val("1");
				
				var toolid = $(this).parent().find(".tool_id").val(); 
				var status = $(this).parent().find(".status").val();
				doAjaxRequest(toolid, status);
			})

			$(document).on("click", ".deactivate", function(e) {
				e.preventDefault();
				$(this).parent().find(".status").val("0");
				
				var toolid = $(this).parent().find(".tool_id").val(); 
				var status = $(this).parent().find(".status").val();
				doAjaxRequest(toolid, status);
			})
		//});
		</script>
	</body>
</html>