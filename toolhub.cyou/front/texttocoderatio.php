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
						
                        <h2 class="u-h3 u-mb-small">Check Text-To-Code Ratio</h2>
						
						<?php if($available){ ?>
						<div class="row">
							<?php require_once('../inc/alerts.php'); ?>
							<div class="col-sm-12">
								
								<form class="c-search-form c-search-form--dark">

									<div class="c-search-form__section">
										<div class="c-field has-icon-left">
											<span class="c-field__icon"><i class="fa fa-link"></i></span>
											<label class="c-field__label c-search-form__label" for="txtUrl">Url</label>
											<input class="c-input" id="txtUrl" type="url" placeholder="ie: google.com">
											<small class="c-field__message">Enter website url to check text-to-code ratio</small>
										</div>
									</div>

									<button class="c-btn c-btn--info" type="submit">Check Ratio</button>
								</form>								
							</div>
						</div>
						
						<div class="row result" style="display:none;">
							<div class="col-sm-12 col-lg-12 col-xl-12">
								<div class="c-card c-card--responsive u-mb-medium card">
									<table class="c-table">
										<caption class="c-table__title">Text To Code Ratio</caption>
										<thead class="c-table__head c-table__head--slim">
											<tr class="c-table__row">
												<th class="c-table__cell c-table__cell--head">Website Icon</th>
												<th class="c-table__cell c-table__cell--head">Page Size</th>
												<th class="c-table__cell c-table__cell--head">Text Size</th>
												<th class="c-table__cell c-table__cell--head">Code Size</th>
												<th class="c-table__cell c-table__cell--head">Text To Code Ratio</th>
											</tr>
										</thead>

										<tbody>
											<tr class="c-table__row">
												<td class="c-table__cell c-table__cell--img o-media">
													<div class="o-media__img u-mr-xsmall">
														<img src="" style="width:56px;" alt="Website Icon" class="webicon">
													</div>

													<div class="o-media__body">
														<span class="u-block u-text-mute u-text-small domain"></span>
													</div>
												</td>
												<td class="c-table__cell"><span class="u-block u-text-small ps"></span></td>
												<td class="c-table__cell"><span class="u-block u-text-small ts"></span></td>
												<td class="c-table__cell"><span class="u-block u-text-small cs"></span></td>
												<td class="c-table__cell"><span class="u-text-small c-badge c-badge--success ratio"></span></td>
											</tr>
										</tbody>
									</table>
									
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
			$('button[type=submit]').click(function(e){
				e.preventDefault();
				$('.result').hide();
				$.ajax({
					//beforeSend: function() { textreplace(description); },
					type: "GET",  
					url: "https://api.toolhub.cyou/TrackingTools.php?action=texttocoderatio&query="+$('#txtUrl').val(),
					success: function(serverresponse){
						var response = serverresponse;
						
						if(response["success"] === 'true')
						{
							$('.domain').html(response['result']['domain']);
							$('.webicon').attr("src", "https://www.google.com/s2/favicons?sz=32&domain_url="+response['result']['url']);
							$('.ps').html(response['result']['pagesize']);
							$('.ts').html(response['result']['textsize']);
							$('.cs').html(response['result']['codesize']);
							$('.ratio').html(response['result']['ratio']);
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