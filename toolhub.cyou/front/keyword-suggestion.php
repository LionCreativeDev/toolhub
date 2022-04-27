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
						
                        <h2 class="u-h3 u-mb-small">Get Keyword Suggestion</h2>
						
						<?php if($available){ ?>
						<div class="row">
							<?php require_once('../inc/alerts.php'); ?>
							<div class="col-sm-12">
								
								<form class="c-search-form c-search-form--dark">

									<div class="c-search-form__section">
										<div class="c-field has-icon-left">
											<span class="c-field__icon"><i class="fa fa-key"></i></span>
											<label class="c-field__label c-search-form__label" for="txtUrl">Keyword</label>
											<input class="c-input" id="txtkeyword" type="text" placeholder="ie: seo">
											<small class="c-field__message">Enter keyword to get suggestion</small>
										</div>
									</div>

									<button class="c-btn c-btn--info" type="submit">Get Suggestions</button>
								</form>								
							</div>
						</div>
						
						<div class="row result" style="display:none;">
							<div class="col-sm-12 col-lg-12 col-xl-12">
								<article class="c-stage card" id="stages">
									<a class="c-stage__header u-flex u-justify-between" data-toggle="collapse" href="#stage-panel1" aria-expanded="true" aria-controls="stage-panel1">
										<div class="o-media">
											<div class="c-stage__header-title o-media__body">
												<h6 class="u-mb-zero">Keyword Suggestions <small class="tk"></small></caption></h6>
											</div>
										</div>
										
										<i class="fa fa-angle-down u-text-mute"></i>
									</a>

									<div class="c-stage__panel c-stage__panel--mute collapse show" id="stage-panel1" style="">
										<div class="u-p-medium">
											<ul>
											</ul>
										</div>
									</div><!-- // .c-stage__panel -->									
								</article>
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
			$('button[type=submit]').click(function(e){
				e.preventDefault();
				$('.result').hide();
				$('.result ul li').remove();
				$.ajax({
					//beforeSend: function() { textreplace(description); },
					type: "GET",  
					url: "https://api.toolhub.cyou/KeywordTools.php?action=keywordsuggestion&query="+$('#txtkeyword').val(), 
					success: function(serverresponse){
						var response = serverresponse;
						
						if(response["success"] === 'true')
						{
							//console.log(response['result']['list']);
							var list = response['result']['suggestion'];
							
							list.forEach(myFunction);
							function myFunction(value) {								
								$('.result ul').append('<li class="u-mb-xsmall u-text-small u-color-primary"><i class="fa fa-check u-color-success u-text-mute u-mr-xsmall"></i>'+value+'</li>');
							}
							
							$('.tk').text(list.length + ' suggestions');
							
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