
<?php 
$logodet = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='footercontent'",'arm_setting');
$sitelogo = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'",'arm_setting');
$address = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='address'",'arm_setting');
$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
$width = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='width'",'arm_setting');
$height = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='height'",'arm_setting');


$facebook= $this->Generalsetting_model->Getsite('facebook');
$twitter = $this->Generalsetting_model->Getsite('twitter');
$pinterest= $this->Generalsetting_model->Getsite('pinterest');
$whatsapp= $this->Generalsetting_model->Getsite('whatsapp');
$youtube= $this->Generalsetting_model->Getsite('youtube');
$instagram= $this->Generalsetting_model->Getsite('instagram');
$telegram= $this->Generalsetting_model->Getsite('telegram');
$Ticktok= $this->Generalsetting_model->Getsite('Ticktok');



//footer content
$userfooter=$this->db->query("select * from arm_cms_page where navTitle='footerContent'")->row();
$footer_content=urldecode($userfooter->pageContentHTML);


// //social media
// $socialmedia=$this->db->query("select * from arm_cms_page where navTitle='socialMedia'")->row();
// $socialmedia_content=urldecode($socialmedia->pageContentHTML);
?>

<footer class="bg-primary foot position-relative foot-af">
<div class="position-relative z-in1">
<div class="container">
<div class="row">
<div class="col-lg-10 offset-lg-1">

<div class="row">

<div class="col-sm-4 order-sm-1 order-2">
<div class="footcont d-flex align-items-center justify-content-center">
<img src="<?php echo base_url()?>assets/styl/images/foot2.png" class="image-fluid me-1">
<a class="text-white fw-bold" href="<?php echo $telegram;?>"   >Live Telegram Chat</a>
</div>
</div>

<div class="col-sm-4 order-sm-2 order-1">
<div class="logo">
	<a href="<?php echo base_url();?>">


	<img style="width:<?php echo $width->ContentValue ; ?>px; height:<?php echo $height->ContentValue;?>px;" src="<?php echo base_url().$sitelogo->ContentValue;?>" class="image-fluid"/>


	</a>
      </div>
</div>

<div class="col-sm-4 order-3">
<div class="footcont d-flex align-items-center justify-content-center">
<img src="<?php echo base_url()?>assets/styl/images/foot1.png" class="image-fluid me-1">
<a class="text-white fw-bold"  href="<?php echo base_url();?>contactus" >Support Service</a>
</div>
</div>


</div>

</div>

<div class="col-lg-12">
<ul class="footnav list-unstyled">

<li><a href="<?php echo base_url();?>">Home</a></li>
<li><a href="<?php echo base_url();?>user/cms/Aboutus">About us</a></li>
<li><a href="<?php echo base_url();?>user/cms/Termscondition">Terms & Condition</a></li>
<li><a href="<?php echo base_url();?>user/faq">Faq</a></li>
<li><a href="<?php echo base_url();?>contactus">Contact us</a></li>
<li><a href="<?php echo base_url();?>user/latestnews">News</a></li>

</ul>

<ul class="footnav list-unstyled">

<li><a href="<?php echo base_url();?>user/cms/fbd">Forlord Business Details </a></li>
<li><a href="<?php echo base_url();?>user/cms/lacademy">Learning Academy </a></li>
<li><a href="<?php echo base_url();?>user/cms/networking">Networking</a></li>

</ul>
</div>

<div class="col-lg-12">
<div class="foot-cont d-lg-flex align-items-center justify-content-between">
<?php
print_r($footer_content);
?>
 

<ul class="list-unstyled social-ico">

<li class="grad-bg"><a href="<?php echo $facebook;?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
<li class="grad-bg"><a href="<?php echo $twitter;?>"  target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
<li class="grad-bg"><a href="<?php echo $instagram;?>" target="_blank"><i class="fa-brands fa-instagram-square"></i></a></li>
<li class="grad-bg"><a href="<?php echo $youtube;?>"  target="_blank"><i class="fa-brands fa-youtube-square"></i></a></li>
<li class="grad-bg"><a href="<?php echo $telegram;?>"  target="_blank"><i class="fa-solid fa-paper-plane"></i></a></li>
<li class="grad-bg"><a href="<?php echo $pinterest;?>"  target="_blank"><i class="fa-brands fa-pinterest"></i></a></li>
<li class="grad-bg"><a href="<?php echo $Ticktok;?>"  target="_blank"><i class="fa-brands fa-tiktok"></i> </a></li>
<li class="grad-bg"><a href="<?php echo $whatsapp;?>"  target="_blank"><i class="fa-brands fa-whatsapp"></i></a></li>

</ul>


</div>
</div>
<div class="col-lg-12">
<h6 class="copy text-center"><strong><p><strong><?php echo  htmlspecialchars($logodet->ContentValue);?></strong></p></h6>

</div>

</div>
</div>
</div>
</footer>
