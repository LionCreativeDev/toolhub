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
                        
                        <h2 class="u-h3 u-mb-small">Check SSL Certificate Info</h2>
						
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
											<small class="c-field__message">Enter website url to check ssl certificate info</small>
										</div>
									</div>

									<button class="c-btn c-btn--info" type="submit">Check SSL Certificate Info</button>
								</form>								
							</div>
						</div>
						
						<div class="row result" style="display:none;">
							<div class="col-sm-12 col-lg-12 col-xl-12">
								
								<div class="c-card u-p-medium u-text-small u-mb-small card">
									<h6 class="u-text-bold">Server Info</h6>

									<dl class="u-flex u-pv-small u-border-bottom">
										<dt class="u-width-25">Domain</dt>
										<dd><label class="lbldomain"></label></dd>
									</dl>

									<dl class="u-flex u-pv-small u-border-bottom">
										<dt class="u-width-25">SAN's</dt>
										<dd><label class="lblsan"></label></dd>
									</dl>

									<dl class="u-flex u-pv-small u-border-bottom">
										<dt class="u-width-25">Certificate Validity</dt>
										<dd><label class="lblvalidity"></label></dd>
									</dl>
									
									<dl class="u-flex u-pv-small u-border-bottom">
										<dt class="u-width-25">Algorithm</dt>
										<dd><label class="lblalgorithm"></label></dd>
									</dl>
								</div>
								
								<div class="c-card u-p-medium u-text-small u-mb-small card">
									<h6 class="u-text-bold">Certificate Chain Info</h6>

									<dl class="u-flex u-pv-small u-border-bottom">
										<dt class="u-width-25">Common Name</dt>
										<dd><label class="lblcommonname"></label></dd>
									</dl>

									<dl class="u-flex u-pv-small u-border-bottom">
										<dt class="u-width-25">Organization</dt>
										<dd><label class="lblorganization"></label></dd>
									</dl>

									<dl class="u-flex u-pv-small u-border-bottom">
										<dt class="u-width-25">Location</dt>
										<dd><label class="lbllocation"></label></dd>
									</dl>
									
									<dl class="u-flex u-pv-small u-border-bottom">
										<dt class="u-width-25">Algorithm</dt>
										<dd><label class="lblalgorithm2"></label></dd>
									</dl>
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
				$('.result').hide();
				
				if(isValidURL($('#txtUrl').val())){
    				$.ajax({
    					//beforeSend: function() { textreplace(description); },
    					type: "GET",  
    					url: "https://api.toolhub.cyou/PasswordTools.php?action=certificateinfo&query="+$('#txtUrl').val(),
    					success: function(serverresponse){
    						var response = serverresponse;
    						
    						if(response["success"] === 'true')
    						{
    							console.log(response['result']);
    							$(".lbldomain").text(response['result']['certificateHostName']['primaryName']);
    							$(".lblsan").text(response['result']['certificateHostName']['sans'].toString().replace(/,/g, ", "));
    							$(".lblalgorithm").text(response['result']['signatureAlgorithm']);
    							$(".lblvalidity").text(response['result']['certificateDuration']);
    							$(".lblcommonname").text(response['result']['certChain']['oldChain'][0]['parsedCert']['issuer']['commonName']);
    							$(".lblorganization").text(response['result']['certChain']['oldChain'][0]['parsedCert']['issuer']['organizationName']);
    							
    							$(".lblalgorithm2").text(response['result']['certChain']['oldChain'][0]['parsedCert']['signatureAlgorithm']);
    							$(".lbllocation").text(response['result']['certChain']['oldChain'][0]['parsedCert']['issuer']['countryName']);
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