<?php

include_once('../inc/DB.php');
$htmlstring = '';

$facebook = '';
$twitter = '';
$linkedin = '';
$pinterest = '';
$behance = '';
$dribbble = '';

$sql = "SELECT * FROM `footer` where id='1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$facebook=$row["facebook"];
	$twitter=$row["twitter"];
	$linkedin=$row["linkedin"];
	$pinterest=$row["pinterest"];
	$behance=$row["behance"];
	$dribbble=$row["dribbble"];	

	if($facebook !== '')
		$htmlstring .= '<li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-facebook" href="'.$facebook.'"><i class="fa fa-facebook"></i></a></li>';
	
	if($twitter !== '')
		$htmlstring .= '<li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-twitter" href="'.$twitter.'"><i class="fa fa-twitter"></i></a></li>';
	
	if($linkedin !== '')
		$htmlstring .= '<li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-linkedin" href="'.$linkedin.'"><i class="fa fa-linkedin"></i></a></li>';
	
	if($pinterest !== '')
		$htmlstring .= '<li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-pinterest" href="'.$pinterest.'"><i class="fa fa-pinterest"></i></a></li>';
	
	if($behance !== '')
		$htmlstring .= '<li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-behance" href="'.$behance.'"><i class="fa fa-behance"></i></a></li>';
	
	if($dribbble !== '')
		$htmlstring .= '<li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-dribbble" href="'.$dribbble.'"><i class="fa fa-dribbble"></i></a></li>';
}

echo '<footer class="c-navbar u-mt-medium card" style="position:relative; bottom:0;">
   <!--<div class="c-toolbar u-justify-center" style="border-bottom: 2px solid #eff3f6;width: 100%;">
      <div class="col-12 col-lg-12 col-xl-12">
         <div class="row">
            <div class="col-12 col-md-6 c-toolbar__state" style="/*margin-bottom: 20px;*/">
               <h4 class="c-toolbar__state-number">About Us</h4>
               <span class="c-toolbar__state-title">About Us Text Goes Here
               </span>
            </div>
            <div class="col-12 col-md-2 c-toolbar__state">
               <a class="c-nav__link" href="#!">
                  <h4 class="c-toolbar__state-number">Home</h4>
               </a>
            </div>
            <div class="col-12 col-md-2 c-toolbar__state">
               <a class="c-nav__link" href="#!">
                  <h4 class="c-toolbar__state-number">Contact Us</h4>
               </a>
            </div>
            <div class="col-12 col-md-2 c-toolbar__state">
               <a class="c-nav__link" href="#!">
                  <h4 class="c-toolbar__state-number">About Us</h4>
               </a>
            </div>
         </div>
      </div>
   </div>-->
   <h2 class="c-navbar__title u-mr-auto u-justify-center" style="margin-top: 10px;">Copyright © 2020 Toolhub. All Rights Reserved.</h2>
   <!--<ul class="c-profile-card__social" style="margin-top: 10px; padding: 10px 0; border-bottom: 0;">
      <li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-facebook" href="#">
         <i class="fa fa-facebook"></i>
         </a>
      </li>
	  <li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-twitter" href="#">
         <i class="fa fa-twitter"></i>
         </a>
      </li>
      <li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-linkedin" href="#">
         <i class="fa fa-linkedin"></i>
         </a>
      </li>
	  <li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-pinterest" href="#">
         <i class="fa fa-pinterest"></i>
         </a>
      </li>      
      <li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-behance" href="#">
         <i class="fa fa-behance"></i>
         </a>
      </li>
      <li style="padding: 0px 5px 0px 0px;"><a class="c-profile-card__social-icon u-bg-dribbble" href="#">
         <i class="fa fa-dribbble"></i>
         </a>
      </li>
   </ul>-->
   <ul class="c-profile-card__social" style="margin-top: 10px; padding: 10px 0; border-bottom: 0;">'.$htmlstring.'</ul>
</footer>';

?>