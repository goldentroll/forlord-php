<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('user/meta');?>
<?php
$sitelogo = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'",'arm_setting');
$site_login = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogin'",'arm_setting');
$sitelogin=$site_login->ContentValue;
$width = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='width'",'arm_setting');
$height = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='height'",'arm_setting');

if($sitelogin)
$imglogin=$sitelogin;
else
$imglogin="assets/user/img/login.png";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<style type="text/css">
.form-back {
min-height: 50vh;
}
 
.alert-danger p
{
  color: #dc3545 !important;
}
</style>

<style type="text/css">
.logo1 {
background: transparent !important;
text-align: center;
padding: 13px 0;
border-radius: 12px;
}
</style>

</head>
<?php
$img_disp=base_url().''.$imglogin;
?>

  <section class="banner-bg position-relative bann-af">
  <div class="position-relative z-in1">
  <header>
  <div class="container">
  <div class="row">

  <div class="col-sm-12">
  <div class="logo1 col-lg-3 text-center">
  <a href="<?php echo base_url();?>">
   <img style="width:<?php echo $width->ContentValue ; ?>px; height:<?php echo $height->ContentValue;?>px;"  src="<?php echo base_url(). $sitelogo->ContentValue;?>" class="image-fluid" alt="Logo"/>
 </a>
  </div>
  </div>

  </div>
  </div>
  </header>

  <div class="banner-sec">
  <div class="container">
  <div class="row">


  <div class="col-sm-8 offset-sm-2">
  <div class="form-sec">
  <div class="title text-center">
  <span class="text-grad">Login your account</span><br>
  <h2 class="text-white pla fw-bold">LOGIN ACCOUNT</h2>
  </div>

  <?php if($this->session->flashdata('success_message')) { ?>
  <div class="flashmessage">
  <div class="alert alert-success alert-dismissable">
  <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
  <?php echo ucwords($this->session->flashdata('success_message')); ?>
  </div>
  </div><br/>
  <?php } ?> 
  <?php if($this->session->flashdata('error_message')) { ?>
  <div class="alert alert-danger alert-dismissable">
  <?php echo ucwords($this->session->flashdata('error_message'));?>
  </div>
  <br/>
  <?php } ?>

  <h4><?php echo ucwords(form_error('error_message')); ?> </h4>

  <form class="" method="post" action="" autocomplete="off">

  <div class="form-back position-relative z-in1 bord-grad">
  <div class="row">
    
  <div class="col-sm-12">
  <div class="mb-3 form-block position-relative">
  <div class="form-ico bg-gradient rounded-circle box"><i class="fa fa-edit text-white"></i></div>
  <label for="">User Name <span class="text-danger">*</span></label>
  <input  type="text" name="username" class="form-control mt-2" id="" aria-describedby="" placeholder="<?php echo $this->lang->line('place_username');?>" required>
  </div>
  </div>

  <input type="hidden" name="web_mode" value="1">

  <div class="col-sm-12">
  <div class="mb-3 form-block position-relative">
  <div class="form-ico bg-gradient rounded-circle box"><i class="fa fa-eye text-white"></i></div>
  <label for="">Password <span class="text-danger">*</span></label>
  <input type="password" id="pwd" name="password"  class="form-control mt-2" id="" aria-describedby="" placeholder="<?php echo $this->lang->line('place_password');?>" required>
  </div>
  </div>


  <div class="lockscreen-item" style="background:none;">
  <?php   
  $captchaset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='usecaptcha'", "arm_setting");

  if($captchaset->ContentValue=="On") {
  $sitekey = $this->common_model->GetRow("Page='reCaptcha' AND KeyValue='siteKey'", "arm_setting");
  ?>
  <div class="g-recaptcha" data-sitekey="<?php echo $sitekey->ContentValue;?>"></div>

  <?php 
  } 
  ?>
  </div>
  <?php echo ucwords(form_error('g-recaptcha-response')); ?>

<br>
  <div class="col-sm-12 text-center">
  <div class="form-btn">
    <input type="submit" value="submit" class="btn btn-primary"></div>

<br>
<br>

<div class="help-block text-center">
<a href="<?php echo base_url();?>user/register" style="font-weight:normal;"><?php echo $this->lang->line('lbl_create_new');?></a>
</div>
<div class="help-block text-center">
<a href="<?php echo base_url();?>login/forgot" style="font-weight:normal;"><?php echo $this->lang->line('lbl_forgot_password');?></a>
</div>

  </div>
  </div>
  </div>
</form>
  </div>
  </div>




  </div>
  </div>
  </div>
  </div>

  </section>


  <body>
    <!-- Automatic element centering -->
    
 

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url();?>assets/user/js/jquery-2.2.1.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url();?>assets/user/bootstrap/js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
 
$(document).ready(function() {
$(".glyphicon").bind("click", function() {
 
if ($('#pwd').attr('type') =='password'){
$('#pwd').attr('type','text');
$('.glyphicon').removeClass('glyphicon-eye-open');
$('.glyphicon').addClass('glyphicon-eye-close');
}else if($('#pwd').attr('type') =='text'){
$('#pwd').attr('type','password');
$('.glyphicon').removeClass('glyphicon-eye-close');
$('.glyphicon').addClass('glyphicon-eye-open');
}
})
});
 
</script>
  </body>
</html>
