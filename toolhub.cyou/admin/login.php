<?php
session_start();

if (isset($_SESSION["userid"])) {
	if (isset($_SERVER["HTTP_REFERER"])) {
		header("location: " . $_SERVER["HTTP_REFERER"]);
	} else {
		header('location: dashboard.php');
	}
}

$message = "";
if(isset($_POST['action']) && isset($_POST['email']) && isset($_POST['password']))
{
	include_once('../inc/DB.php');

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$query = "SELECT * FROM users WHERE user_email = '".$email."' and user_password = '".$password."' limit 1;";
	$result = mysqli_query($conn,$query);
	
	$message = '';
	if(mysqli_num_rows($result) >= 1)
	{
		while ($row = $result->fetch_assoc()) {
			$_SESSION['userid'] = $row["user_id"];
			$_SESSION['username'] = $row["user_name"];
			$_SESSION["email"] = $row["user_email"];
			$_SESSION["role"] = $row["user_role"];
			echo '{"success":"true","message":"Login Successfully!"}';
		}
	}
	else
	{
		echo '{"success":"false","message":"Invalid Username or Password!"}';
	}
	
	exit;
}
?>
<!doctype html>
<html lang="en-us">
	<?php 
	require_once('../inc/head.php');
	?>
    <body class="o-page o-page--center">

        <div class="o-page__card">
			<?php require_once('../inc/alerts.php'); ?>
            <div class="c-card u-mb-xsmall card">
                <header class="c-card__header u-pt-large">
                    <a class="c-card__icon" href="#!">
                        <img src="../template/img/logo-login.svg" alt="Dashboard UI Kit">
                    </a>
                    <h1 class="u-h3 u-text-center u-mb-zero">Welcome Admin! Please login.</h1>
                </header>
                
                <form class="c-card__body">
                    <div class="c-field u-mb-small">
                        <label class="c-field__label" for="txtEmail">Log in with your e-mail address</label> 
                        <input class="c-input" type="email" id="txtEmail" placeholder="clark@dashboard.com"> 
                    </div>

                    <div class="c-field u-mb-small">
                        <label class="c-field__label" for="txtPassword">Password</label> 
                        <input class="c-input" type="password" id="txtPassword" placeholder="Numbers, Letters..."> 
                    </div>

                    <button class="c-btn c-btn--info c-btn--fullwidth btnLogin" type="submit">Sign in to Dashboard</button>

                    <!--<span class="c-divider c-divider--small has-text u-mv-medium">Login via social networks</span>

                    <div class="o-line">
                        <a class="c-icon u-bg-twitter" href="#!">
                            <i class="fa fa-twitter"></i>
                        </a>

                        <a class="c-icon u-bg-facebook" href="#!">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a class="c-icon u-bg-pinterest" href="#!">
                            <i class="fa fa-pinterest"></i>
                        </a>

                        <a class="c-icon u-bg-dribbble" href="#!">
                            <i class="fa fa-dribbble"></i>
                        </a>
                    </div>-->
                </form>
            </div>

            <!--<div class="o-line">
                <a class="u-text-mute u-text-small" href="register.html">Don’t have an account yet? Get Started</a>
                <a class="u-text-mute u-text-small" href="forgot-password.html">Forgot Password?</a>
            </div>-->
        </div>

        <script src="../template/js/main.min.js"></script>
		<script>
		$(document).ready(function(){
			$('.c-alert').css({"margin-bottom":"50px"});
			
			$(".btnLogin").on("click", function(e){
				e.preventDefault();
				$('.c-alert').hide();
				
				if($("#txtEmail").val().trim() !== '' && $("#txtPassword").val().trim() !== ''){
					var email = $("#txtEmail").val();
					var password = $("#txtPassword").val();

					var dataString = 'email='+encodeURIComponent(email)+'&password='+encodeURIComponent(password)+'&action=login';
					$.ajax({
						type:'POST',
						data:dataString,
						url:'login.php',
						success:function(data) {						
							console.log(data);
							var response = JSON.parse(data);
							if(response["success"] === 'true')
							{
								$('.c-alert--success').find("label").html(response["message"]);
								$('.c-alert--success').show();
								
								setTimeout(function(){
									document.location = "dashboard.php";
								},2000);
							}
							else
							{
								$('.c-alert--danger').find("label").html(response["message"]);
								$('.c-alert--danger').show();
							}
						}
					}).fail(function (jqXHR, textStatus, error) {
						//$('#editor-content-container').html(jqXHR.responseText);
						$('.c-alert--danger').find("label").html("Something Went Wrong!");
						$('.c-alert--danger').show();
					});
				}
				else
				{
					if($("#txtEmail").val().trim() === '' && $("#txtPassword").val().trim() === ''){
						$('.c-alert--danger').find("label").html("Please Provide Email And Password!");
						$('.c-alert--danger').show();
					}
					else if($("#txtEmail").val().trim() === ''){
						$('.c-alert--danger').find("label").html("Please Provide Email!");
						$('.c-alert--danger').show();
					}
					else if($("#txtPassword").val().trim() === ''){
						$('.c-alert--danger').find("label").html("Please Provide Password!");
						$('.c-alert--danger').show();
					}
				}
			})
		})
		</script>
	</body>
</html>