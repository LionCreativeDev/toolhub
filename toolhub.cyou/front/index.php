<?php

include_once('../inc/DB.php');

if(isset($_POST["GetMore"]) && isset($_POST["offset"])){

$sql = "SELECT * FROM `tools` limit 8 offset ".trim($_POST["offset"]);
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
?>
<div class="col-sm-12 col-lg-3">
	<div class="c-card u-p-medium u-text-center u-mb-medium card" data-mh="landing-cards">

		<img class="u-mb-small" src="<?php echo $row["tool_icon"]; ?>" alt="tool icon">

		<h4 class="u-h4 u-text-bold u-mb-small"><?php echo $row["tool_name"]; ?></h4>
		
		<h5 class="u-h6 u-text-bold u-mb-small">
			<?php echo $row["tool_description"]; ?>
		</h5>
		
		<?php if($row["status"] === '1'){ ?>
		<h6><i class="fa fa-circle-o u-color-success u-mr-xsmall"></i>Available</h6>
		<a class="c-btn c-btn--info" href="<?php echo $row["tool_url"]; ?>">Use This Tools</a>
		<?php } elseif($row["status"] === '0') { ?>
		<h6><i class="fa fa-circle-o u-color-danger u-mr-xsmall"></i>Un-Available</h6>
		<a class="c-btn c-btn--info is-disabled" href="#">Use This Tools</a>
		<?php }?>						
	</div>
</div>
<?php 
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
		
		<?php require_once('../inc/header.php'); ?>
        <div class="se-pre-con"></div>
		<div class="container">
			
			<?php if($topadvertisement) { ?>
			<div class="row">
				<div class="col-sm-12 col-lg-12 col-md-12">
					<div class="c-card u-p-medium u-text-center u-mb-medium" data-mh="landing-cards">
						<!--<h4 class="u-h6 u-text-bold u-mb-small">
							
						</h4>-->
						<?php echo (isset($row["advertise_top"])) ? htmlspecialchars(base64_decode($row["advertise_top"])) : ''; ?>
					</div>
				</div>
			</div>
			<?php } ?>

			<div class="row rowtools">
			    <?php
				include_once('../inc/DB.php');
				
				$sql = "SELECT * FROM `tools` limit 8";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
			?>
				<div class="col-sm-12 col-lg-3">
					<div class="c-card u-p-medium u-text-center u-mb-medium card" data-mh="landing-cards">

						<img class="u-mb-small" src="<?php echo $row["tool_icon"]; ?>" alt="tool icon">

						<h4 class="u-h4 u-text-bold u-mb-small"><?php echo $row["tool_name"]; ?></h4>
						
						<h5 class="u-h6 u-text-bold u-mb-small">
							<?php echo $row["tool_description"]; ?>
						</h5>
						
						<?php if($row["status"] === '1'){ ?>
						<h6><i class="fa fa-circle-o u-color-success u-mr-xsmall"></i>Available</h6>
						<a class="c-btn c-btn--info card" href="<?php echo $row["tool_url"]; ?>">Use This Tools</a>
						<?php } elseif($row["status"] === '0') { ?>
						<h6><i class="fa fa-circle-o u-color-danger u-mr-xsmall"></i>Un-Available</h6>
						<a class="c-btn c-btn--info is-disabled card" href="#">Use This Tools</a>
						<?php }?>
					</div>
				</div>
			<?php 
					}
				}
			?>
				<!--<div class="col-sm-12 col-lg-4">
					<div class="c-card u-p-medium u-text-center u-mb-medium" data-mh="landing-cards">

						<img class="u-mb-small" src="img/icon-intro1.svg" alt="iPhone icon">

						<h3 class="u-h3 u-text-bold u-mb-small">Tool Name</h2>
						
						<h4 class="u-h6 u-text-bold u-mb-small">
							Check your performance. See the results of all your active campaings.
						</h4>
						
						<h6><i class="fa fa-circle-o u-color-success u-mr-xsmall"></i>Available</h5>
						<a class="c-btn c-btn--info" href="#">Use This Tools</a>
					</div>
				</div>

				<div class="col-sm-12 col-lg-4">
					<div class="c-card u-p-medium u-text-center u-mb-medium" data-mh="landing-cards">

						<img class="u-mb-small" src="img/icon-intro2.svg" alt="iPhone icon">
						
						<h3 class="u-h3 u-text-bold u-mb-small">Tool Name</h2>

						<h4 class="u-h6 u-text-bold u-mb-small">
							Start console and prepare new stuff for your customers or community!
						</h4>
						
						<h6><i class="fa fa-circle-o u-color-success u-mr-xsmall"></i>Available</h5>
						<a class="c-btn c-btn--info" href="#">Use This Tools</a>
					</div>
				</div>

				<div class="col-sm-12 col-lg-4">
					<div class="c-card u-p-medium u-text-center u-mb-medium" data-mh="landing-cards">

						<img class="u-mb-small" src="img/icon-intro3.svg" alt="iPhone icon">
						
						<h3 class="u-h3 u-text-bold u-mb-small">Tool Name</h2>

						<h4 class="u-h6 u-text-bold u-mb-small">
							All Files ready? <br>Start promoting your apps today.
						</h4>
						
						<h6><i class="fa fa-circle-o u-color-danger u-mr-xsmall"></i>Not Available</h5>
						<a class="c-btn c-btn--info" href="#">Use This Tools</a>
					</div>
				</div>-->
			</div>
			
			<div class="row">
				<div class="col u-mb-medium col-md-4"></div>
				<div class="col u-mb-medium col-md-4">
                    <a class="c-btn c-btn--success c-btn--fullwidth btnLoadMore" href="#">Load More</a>
                </div>
				<div class="col u-mb-medium col-md-4"></div>
			</div>
			
			<?php if(!empty($pagecontent)){ ?>
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<div class="c-post u-text-center">
                        <p class="c-post__content u-h5"><?php echo (!empty($pagecontent) ? $pagecontent : '') ?></p>
                    </div>
				</div>				
			</div>
			<?php } ?>
			
			<?php if($bottomadvertisement) { ?>
			<div class="row">
				<div class="col-sm-12 col-lg-12 col-md-12">
					<div class="c-card u-p-medium u-text-center u-mb-medium" data-mh="landing-cards">
						<!--<h4 class="u-h6 u-text-bold u-mb-small">
							
						</h4>-->
						
						<?php echo (isset($row["advertise_bottom"])) ? htmlspecialchars(base64_decode($row["advertise_bottom"])) : ''; ?>
					</div>
				</div>
			</div>
			<?php } ?>
						
			<?php if(!empty($pagecontent)){ ?>
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<div class="c-post u-text-center card">
						<p class="c-post__content u-h5"><?php echo (!empty($pagecontent) ? $pagecontent : '') ?></p>
					</div>
				</div>
			</div>
			<?php } ?>
			
		</div>

		<!-- Main javascsript -->
		<script src="../template/js/main.min.js"></script>
		<script>
		$(".btnLoadMore").on("click", function(e){
			e.preventDefault();
			var dataString = "GetMore=true&offset="+$(".c-card").length;
			//console.log(dataString);
			$.ajax({
				type:'POST',
				data:dataString,
				url:'index.php',
				success:function(data) {						
					//console.log(data);
					if(data !== "")
						$(".rowtools").append(data);
					else
						$(".btnLoadMore").remove();
				}
			}).fail(function (jqXHR, textStatus, error) {
				$('#editor-content-container').html(jqXHR.responseText);
				$('.c-alert--danger').find("label").text("Something Went Wrong!");
				$('.c-alert--danger').show();
			});
		});
		</script>
	</body>
</html>