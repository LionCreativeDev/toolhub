<?php

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']) && isset($_POST['action']))
{
	$name = trim($_POST["name"]);
	$email = trim($_POST["email"]);
	
	$message = '<html><body>';
    $message .= '<p style="font-size:18px;">'.$email.' Contacted on ToolHub.</p>';
    $message .= '<p style="font-size:16px;">'.trim($_POST["message"]).'</p>';
    $message .= '</body></html>';
	
	$to = 'support@toolhub.cyou';
	$subject = $email . ' Contacted on ToolHub';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: donotreply@toolhub.cyou'."\r\n" .'X-Mailer: PHP/' . phpversion();

	//mail($to, $subject, $message, $headers);

	if (mail($to, $subject, $message, $headers)) {
		echo '{"success":"true","message":"Thank You For Contacting Us. Our Support Team Will Get Back To You Soon!"}';
		
		//To client
		$message1 = '<html><body>';
        $message1 .= '<p style="font-size:18px;">Thank you for getting in touch! </p>';
        $message1 .= '<p style="font-size:16px;">We appreciate you contacting us. Our support team will get back in touch with you soon!</p>';
        $message1 .= '<p style="font-size:16px;">Have a great day!</p>';
        $message1 .= '</body></html>';
    	
    	$to1 = $email;
    	$subject1 = 'Thank you for getting in touch at ToolHub';
    
        $headers1  = 'MIME-Version: 1.0' . "\r\n";
        $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    	$headers1 .= 'From: donotreply@toolhub.cyou'."\r\n" .'X-Mailer: PHP/' . phpversion();
    	
    	mail($to1, $subject1, $message1, $headers1);
    	//To client
		
	} else {
		echo '{"success":"false","message":"Something Went Wrong! Try Again Later."}';
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

			<!--<div class="row" style="margin-top:50px;">
				<div class="o-page__card">
				    require_once('../inc/alerts.php');
					<div class="c-card u-mb-xsmall card">
						<header class="c-card__header u-pt-large">
							<a class="c-card__icon" href="#!">
								<img src="../template/img/logo-login.svg" alt="Dashboard UI Kit">
							</a>
							<h1 class="u-h3 u-text-center u-mb-zero">Contact Us</h1>
						</header>
						
						<form class="c-card__body">
							<div class="c-field u-mb-small">
								<label class="c-field__label" for="txtName">Name</label> 
								<input class="c-input" type="text" id="txtName" placeholder="ie: john doe"> 
							</div>
							
							<div class="c-field u-mb-small">
								<label class="c-field__label" for="txtEmail">E-mail address</label> 
								<input class="c-input" type="email" id="txtEmail" placeholder="clark@dashboard.com"> 
							</div>

							<div class="c-field u-mb-small">
								<label class="c-field__label" for="txtMessage">Message</label> 
								<textarea class="c-input" id="txtMessage"></textarea>
							</div>

							<button class="c-btn c-btn--info c-btn--fullwidth btnSend" type="submit">Send</button>
							
						</form>
					</div>				
				</div>
			</div>-->
			
			<div class="row u-mt-medium">
				<div class="col-xl-5">
					<?php require_once('../inc/alerts.php'); ?>
					<div class="c-card u-mb-xsmall card">
						<header class="c-card__header u-pt-large">
							<a class="c-card__icon" href="#">
								<img src="../template/img/logo-login.svg" alt="login">
							</a>
							<h1 class="u-h3 u-text-center u-mb-zero">Contact Us</h1>
						</header>
						
						<form class="c-card__body">
							<div class="c-field u-mb-small">
								<label class="c-field__label" for="txtName">Name</label> 
								<input class="c-input" type="text" id="txtName" placeholder="ie: john doe"> 
							</div>
							
							<div class="c-field u-mb-small">
								<label class="c-field__label" for="txtEmail">E-mail address</label> 
								<input class="c-input" type="email" id="txtEmail" placeholder="clark@dashboard.com"> 
							</div>

							<div class="c-field u-mb-small">
								<label class="c-field__label" for="txtMessage">Message</label> 
								<textarea class="c-input" id="txtMessage"></textarea>
							</div>

							<button class="c-btn c-btn--info c-btn--fullwidth btnSend" type="submit">Send</button>
							
						</form>
					</div>
				</div>
				
				<?php if(!empty($pagecontent)){ ?>
				<div class="col-xl-7">
				    <div class="card">
    					<ul class="c-tabs__list nav nav-tabs" id="myTab" role="tablist">
    						<li><div class="c-tabs__link active" id="nav-contact-tab" data-toggle="tab" role="tab" aria-controls="nav-contact" aria-selected="true">Contact Us</div></li>
    					</ul>
    					<div class="c-tabs__content tab-content u-mb-large" id="nav-tabContent" style="height: 100%;">
    						<div class="c-tabs__pane active u-pb-medium" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" style="height: 85%;">
    							<p class="c-feed__comment" style="height: 100%; width:100%;"><?php echo (!empty($pagecontent) ? $pagecontent : '') ?></p>
    						</div>
    					</div>
					</div>
				</div>
				<?php } ?>
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
		<script>
		$(document).ready(function(){
			$(".btnSend").on("click", function(e){
				e.preventDefault();
				$('.c-alert').hide();
				$(".btnSend").attr("disabled","disabled");
				$(".se-pre-con").show();
				
				if($("#txtName").val().trim() !== '' && $("#txtEmail").val().trim() !== '' && $("#txtMessage").val().trim() !== ''){
					var name = $("#txtName").val();
					var email = $("#txtEmail").val();
					var message = $("#txtMessage").val();

					var dataString = 'name='+encodeURIComponent(name)+'&email='+encodeURIComponent(email)+'&message='+encodeURIComponent(message)+'&action=contactus';
					$.ajax({
						type:'POST',
						data:dataString,
						url:'contactus.php',
						success:function(data) {						
							console.log(data);
							var response = JSON.parse(data);
							if(response["success"] === 'true')
							{
								$('.c-alert--success').find("label").html(response["message"]);
								$('.c-alert--success').show();
								$(".btnSend").removeAttr("disabled");
								$(".se-pre-con").hide();
								
								setTimeout(function(){
									document.location = "contactus.php";
								},3000);
							}
							else
							{
								$('.c-alert--danger').find("label").html(response["message"]);
								$('.c-alert--danger').show();
								$(".btnSend").removeAttr("disabled");
								$(".se-pre-con").hide();
							}
						}
					}).fail(function (jqXHR, textStatus, error) {
						//$('#editor-content-container').html(jqXHR.responseText);
						$('.c-alert--danger').find("label").html("Something Went Wrong!");
						$('.c-alert--danger').show();
						$(".btnSend").removeAttr("disabled");
						$(".se-pre-con").hide();
					});
				}
				else
				{
					if($("#txtName").val().trim() === '' && $("#txtEmail").val().trim() === '' && $("#txtMessage").val().trim() === ''){
						$('.c-alert--danger').find("label").html("Please Provide Your Name, Email And Password!");
						$('.c-alert--danger').show();
					}
					else if($("#txtName").val().trim() === ''){
						$('.c-alert--danger').find("label").html("Please Provide Your Name!");
						$('.c-alert--danger').show();
					}
					else if($("#txtEmail").val().trim() === ''){
						$('.c-alert--danger').find("label").html("Please Provide Your Email!");
						$('.c-alert--danger').show();
					}
					else if($("#txtMessage").val().trim() === ''){
						$('.c-alert--danger').find("label").html("Please Provide Your Message!");
						$('.c-alert--danger').show();
					}
					$(".btnSend").removeAttr("disabled");
					$(".se-pre-con").hide();
				}
			})
		})
		</script>
	</body>
</html>