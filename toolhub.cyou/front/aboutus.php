<!doctype html>
<html lang="en-us">
	<?php 
	require_once('../inc/head.php');
	?>

	<body>
		
		<?php require_once('../inc/header.php'); ?>

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

			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<div class="c-post u-text-center">
						<h2 class="u-mb-xsmall">About Us</h2>
                        <p class="c-post__content u-h5 card"><?php echo (!empty($pagecontent) ? $pagecontent : '') ?></p>
                    </div>
				</div>				
			</div>

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
		</div>

		<!-- Main javascsript -->
		<script src="../template/js/main.min.js"></script>
	</body>
</html>