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
                            <?php require_once('../inc/sidemenu.php'); ?>
                        </ul>
                    </aside>
                </div>

                <div class="col-md-9 col-xl-9">
                    <main>
                        
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
						
                        <h2 class="u-h3 u-mb-small">Check Domain Host</h2>
						
						<?php if($available){ ?>
						<div class="row">
						    <?php require_once('../inc/alerts.php'); ?>
							<div class="col-sm-12">
								
								<form class="c-search-form c-search-form--dark">

									<div class="c-search-form__section">
										<div class="c-field has-icon-left">
											<span class="c-field__icon"><i class="fa fa-link"></i></span>
											<label class="c-field__label c-search-form__label" for="txtUrl">Url</label>
											<input class="c-input" id="txtUrl" type="url" placeholder="ie: https://www.google.com">
											<small class="c-field__message">Enter website url to check domain host</small>
										</div>
									</div>

									<button class="c-btn c-btn--info" type="submit">Check Domain Host</button>
								</form>								
							</div>
						</div>
						
						<div class="row result" style="display:none;">
							<div class="col-sm-12 col-lg-12 col-xl-12">
								<div class="c-state-card card" data-mh="state-cards" style="height: 143px;">
									<div class="c-state-card__icon c-state-card__icon--info">
										<i class="fa fa-lock"></i>
									</div>

									<div class="c-state-card__content">
										<p class="c-state-card__meta">Domain Host</p>
										<h5 class="c-state-card__number"><span class="u-text-success host"></span></h5>
									</div>
								</div>
							</div><!-- // .col-md-3 -->
						</div>
						<?php } else { ?>
						<div class="c-alert c-alert--info alert">
							<i class="c-alert__icon fa fa-info-circle"></i> <label>This Tool Is Currently Unavailable! Please Try Later. Thanks.</label><button class="c-close" data-dismiss="alert" type="button">×</button>
						</div>
						<?php }?>
						
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
						
					</main>
                </div>
                
            </div>
        </div>
		
		<!-- Main javascsript -->
		<script src="../template/js/main.min.js"></script>
		<?php if($available){ ?>
		<script>
		    var elm;
            function isValidURL(u){
                if(!elm){
                    elm = document.createElement('input');
                    elm.setAttribute('type', 'url');
                }
                
                elm.value = u;
                return elm.validity.valid;
            }
            
			$('button[type=submit]').click(function(e){
				e.preventDefault();
				
				if(isValidURL($('#txtUrl').val())){
    				$('.result').hide();
    				$.ajax({
    					//beforeSend: function() { textreplace(description); },
    					type: "GET",  
    					url: "https://api.toolhub.cyou/DomainTools.php?action=domainhost&query="+$('#txtUrl').val(),
    					success: function(serverresponse){
    						var response = serverresponse;
    						
    						if(response["success"] === 'true')
    						{
    							console.log(response['result']['host']);
    							$('.host').html(response['result']['host']);
    							$('.result').show();
    						}
    						else if(response["success"] === 'false')
    						{
    							console.log(response['result']);
    							$('.c-alert--warning').find('label').text(response['result']);
    							$('.c-alert--warning').show();
    						}
    					},
    					error: function(XMLHttpRequest, textStatus, errorThrown) {
    						console.log('Something went wrong!');
    						$('.c-alert--warning').find('label').text('Something went wrong!');
    						$('.c-alert--warning').show();
    					}
    				});
				}
				else
				{
			    	$('.c-alert--warning').find('label').text('Input Is Invalid! Please Provide Valid Website Url');
					$('.c-alert--warning').show();
				}
			})
		</script>
		<?php }?>
	</body>
</html>