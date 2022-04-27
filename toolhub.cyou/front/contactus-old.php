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

			<div class="row" style="margin-top:50px;">
				<div class="o-page__card">
					<div class="c-card u-mb-xsmall">
						<header class="c-card__header u-pt-large">
							<a class="c-card__icon" href="#!">
								<img src="template/img/logo-login.svg" alt="Dashboard UI Kit">
							</a>
							<h1 class="u-h3 u-text-center u-mb-zero">Contact Us</h1>
						</header>
						
						<form class="c-card__body">
							<div class="c-field u-mb-small">
								<label class="c-field__label" for="input2">Name</label> 
								<input class="c-input" type="text" id="input2" placeholder="ie: john doe"> 
							</div>
							
							<div class="c-field u-mb-small">
								<label class="c-field__label" for="input1">E-mail address</label> 
								<input class="c-input" type="email" id="input1" placeholder="clark@dashboard.com"> 
							</div>

							<div class="c-field u-mb-small">
								<label class="c-field__label" for="input3">Message</label> 
								<textarea class="c-input" id="bio"></textarea>
							</div>

							<button class="c-btn c-btn--info c-btn--fullwidth" type="submit">Send</button>
							
						</form>
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