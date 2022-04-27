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
						
                        <h2 class="u-h3 u-mb-small">Minify HTML</h2>
						
						<?php if($available){ ?>
						<div class="row">
							<?php require_once('../inc/alerts.php'); ?>
							<div class="col-sm-12">
								
								<form class="c-search-form c-search-form--dark">

									<!--<div class="c-search-form__section">
										<div class="c-field has-icon-left">
											<span class="c-field__icon"><i class="fa fa-map-marker"></i></span>
											<label class="c-field__label c-search-form__label" for="search-location">Location</label>
											<input class="c-input" id="search-location" type="text" placeholder="All">
											<small class="c-field__message">Enter a city, state or country</small>
										</div>
									</div>-->

									<div class="c-search-form__section">
										<div class="c-field has-icon-left">
											<!--<span class="c-field__icon"><i class="fa fa-user-o"></i></span>
											<label class="c-field__label c-search-form__label" for="search-position">Position</label>-->
											<textarea class="c-input" id="txtHtml"></textarea>
											<!--<small class="c-field__message">Use commas for multiple skills</small>-->
										</div>
									</div>

									<button class="c-btn c-btn--info" type="submit">Minify Html</button>
								</form>								
							</div>
						</div>
						
						<div class="row result" style="display:none;">
							<div class="col-sm-12 col-lg-12 col-xl-12">
								<div class="c-search-form c-search-form--dark">

									<div class="c-search-form__section">
										<div class="c-field has-icon-left">
											<!--<span class="c-field__icon"><i class="fa fa-user-o"></i></span>-->
											<label class="c-field__label c-search-form__label" for="search-position">Minified HTML</label>
											<textarea class="c-input" id="txtMinifiedHTML"></textarea>
											<!--<small class="c-field__message">Enter article to rewrite.</small>-->
										</div>
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
			function decodeHTMLEntities(text) {
				var textArea = document.createElement('textarea');
				textArea.innerHTML = text;
				return textArea.value;
			}
			
			$('button[type=submit]').click(function(e){
				e.preventDefault();
				$('.result').hide();
				
				var blob;
				var BlobBuilder = window.MozBlobBuilder || window.WebKitBlobBuilder || window.BlobBuilder;
				
				if(BlobBuilder) {
					// android
					var oBuilder = new BlobBuilder();
					var aFileParts = [''+$('#txtHtml').val()+''];
					oBuilder.append(aFileParts[0]);
					blob = oBuilder.getBlob("text\/plain"); // the blob
					
				} else {
					// everyone else
					blob = new Blob([''+$('#txtHtml').val()+''], { 'type': 'text/plain' });    
				}
				
				var data = new FormData();
				data.append('htmlsource', blob);
				
				$.ajax({
					//beforeSend: function() { textreplace(description); },
					type: 'POST',
					data: data,
					contentType: false,
					processData: false,
					url: "https://api.toolhub.cyou/WebsiteTools.php?action=minifyhtml&query=infile",
					success: function(serverresponse){
						var response = serverresponse;
						
						if(response["success"] === 'true')
						{
							//console.log(response['result']['minified']);
							$('#txtMinifiedHTML').val(decodeHTMLEntities(response['result']['minified']));
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
			})
		</script>
		<?php }?>
	</body>
</html>