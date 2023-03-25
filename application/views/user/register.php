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
   
    h4 em
    {
      font-size:15px !important;
      font-weight: 700;
      color: red;
    }
      .form-control:disabled, .form-control[readonly] {
    background-color: gray !important;
    opacity: 1;
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


    <div class="col-lg-12">
    <div class="form-sec">
    <div class="title text-center">
    <span class="text-grad">Signup your account</span><br>
    <h2 class="text-white pla fw-bold">REGISTER ACCOUNT</h2>
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


    <?php 
    $find_min=$this->db->query("select * from arm_setting where Page='usersetting' and KeyValue='minuserpasswordlength'")->row();
    $find_max=$this->db->query("select * from arm_setting where Page='usersetting' and KeyValue='maxuserpasswordlength'")->row();
    ?>    

  <div class="form-back position-relative z-in1 bord-grad">

    <form method="post" action="" id="form-register" name="registerform">
    <div class="col-lg-12">

     <div class="row">



  <div class="col-lg-6" style="display: none;">

  <h4 class="text-grad"><?php echo "Membership Package";?></h4>
  <hr width="100%" size="1" nosade="">

  <div class="mb-3 form-block position-relative" style="display: none;">
  <label for=""><?php echo  ucwords($this->lang->line('selectpackage'));?><sup> <em class="state-error">*</em> </sup></label>
  <select id="PackageId" name="PackageId" class="form-select mt-2">
<option value="1">Free</option>
<option value="2">Premium</option>
  </select>
  <h4> <?php echo form_error('PackageId','<em class="state-error">','</em>');?></h4>
  </div>
  </div>


  <div class="col-lg-6">

  <h4 class="text-grad"><?php echo "Sponsor Details";?></h4>
  <hr width="100%" size="1" nosade="">

  <div class="mb-3 form-block position-relative">
  <div class="form-ico bg-gradient rounded-circle box"><i class="fa fa-edit text-white"></i>
  </div>
  <label for=""><?php echo  "Direct Sponsor Username ID";?>
  <sup>
  </label>

  <input type="text" readonly name="SponsorName" id="SponsorName" class="form-control mt-2" placeholder="Enter SponsorName" value="<?php echo set_value('uplineid',isset($SponsorName)? $SponsorName : '');?>">

  <h4> <?php echo form_error('SponsorName','<em class="state-error">','</em>');?></h4>
  </div>
  </div>



    <?php 
    $mlsetting   = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
    if($mlsetting->Id==4 && $mlsetting->upline_detail==1) {
    ?>
    <div class="">
    <h2><?php echo $this->lang->line('uplinedetails');?></h2>
    <hr width="100%" size="1" nosade="">
    <h3><?php echo  ucwords($this->lang->line('place_uplineid'));?><sup> <em class="state-error">*</em> </sup></h3>
    <input type="text" name="uplineid" id="uplineid" class="gui-input" placeholder="<?php echo  ucwords($this->lang->line('place_uplineid'));?>" value="<?php echo set_value('uplineid',isset($SponsorName)? $SponsorName : '');?>" required><?php if($mlsetting->upline_detail==1){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo  base_url();?>user/genealogy" target="_blank">Upline Details</a><?}?>
    <h4> <?php echo form_error('uplineid');?></h4>
    </div>
    <?php 
    } 
    ?>

    <?php 
    if($mlsetting->Id==4 && $mlsetting->Position==1) { 
    ?>
    <div class="">
    <h2><?php echo "Select Position";?></h2>
    <hr width="100%" size="1" nosade="">
    <h3><?php echo  ucwords($this->lang->line('selectposition'));?><sup> <em class="state-error">*</em> </sup></h3> 
    <select id="position" name="position" class="field select" required>
    <option value="" selected="selected"><?php echo $this->lang->line('selectposition');?></option>
    <option value="Left" <?php if(set_value('position', isset($position) ? $position : '')=='Left') echo 'selected'; ?> ><?php echo ucfirst($this->lang->line('lbl_left'));?></option>
    <option value="Right" <?php if(set_value('position', isset($position) ? $position : '')=='Right') echo 'selected'; ?> ><?php echo ucfirst($this->lang->line('lbl_right'));?></option>
    </select><?php if($mlsetting->upline_detail==1){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo  base_url();?>user/genealogy" target="_blank">Upline Details</a><?}?>
    <h4> <?php echo form_error('position');?></h4>
    </div>
    <?php } ?>

  <div class="col-sm-12 text-center">
  <div class="checkbox mt-3 position-relative">
  <label class="text-white">
    <h4 class="text-grad text-center"><?php echo ucwords($this->lang->line('memberaccessinformation'));?></h4>
    <hr width="100%" size="1" nosade="">

</label>
</div>
</div>

<?php
foreach ($requirefields as $row) {
if($row->FieldEnableStatus==1 && $row->ReuireFieldName!='Password' && $row->ReuireFieldName!='Email' && $row->ReuireFieldName!='Country' && $row->ReuireFieldName!='Phone' && $row->ReuireFieldName!='Gender' && $row->ReuireFieldName!='City' && $row->ReuireFieldName!='Address')
{
if($row->ReuireFieldName=='Phone')
{
?>

<?
}
else
{
if($row->ReuireFieldName=='bankwire')
$disp="Bank Name";
else if($row->ReuireFieldName=='bankwireacno')
$disp="Bankwire Account Number";
else
$disp=$row->ReuireFieldName;
?>

  <div class="col-lg-6">
  <div class="mb-3 form-block position-relative">
  <div class="form-ico bg-gradient rounded-circle box">

<?php

if($row->ReuireFieldName=="FirstName")
{
?>
    <i class="fa fa-user text-white"></i>
<?
}
else
{
  ?>
 <i class="fa fa-user text-white"></i>
  <?
}
?>


  </div>
  <label for="" class=""><?php echo ucwords($disp);?> <small class="text-danger">*</small>
  </label>
  <input type="text" name="<?php echo  $row->ReuireFieldName; ?>" id="<?php echo  $row->ReuireFieldName; ?>"placeholder="<?php echo  ($this->lang->line('place_'.$row->ReuireFieldName)) ? $this->lang->line('place_'.$row->ReuireFieldName) : $row->ReuireFieldName; ?>" value="<?php echo  set_value($row->ReuireFieldName); ?>" <?php echo  $st;?> class="form-control mt-2" required>
<h4><?php echo form_error($row->ReuireFieldName,'<em class="state-error">','</em>'); ?></h4>
</div>
</div>
<?php
}
$st='';
}
elseif ($row->ReuireFieldName=='Password') {   ?>
<?php if($row->ReuireFieldStatus=='1') {$st = 'required';}else{$st="";}?>


<div class="col-lg-6">
<div class="mb-3 form-block position-relative">
<div class="form-ico bg-gradient rounded-circle box"> <i class="fa-solid fa-envelope text-white"></i>
</div>
<label for="" class="mb-2">Email <small class="text-danger">*</small>
</label>

<input type="Email" name="Email" id="Email" class="form-control mb-3" placeholder="Email" value="" required>

<h4><?php echo form_error('Email','<em class="state-error">','</em>'); ?></h4>
</div>
</div>


<div class="col-lg-6">
<div class="mb-3 form-block position-relative">
<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
</div>
<label for="" class="mb-2"><?php echo  ucwords(($this->lang->line('lbl_'.$row->ReuireFieldName)) ? $this->lang->line('lbl_'.$row->ReuireFieldName) : $row->ReuireFieldName); ?> <small class="text-danger">*</small>
</label>

 <input type="password" name="<?php echo  $row->ReuireFieldName; ?>" id="<?php echo  $row->ReuireFieldName; ?>" class="form-control mb-3" placeholder="<?php echo  $this->lang->line('place_'.$row->ReuireFieldName); ?>" value="" <?php echo  $st;?> required>

<h4><?php echo form_error($row->ReuireFieldName,'<em class="state-error">','</em>'); ?></h4>
</div>
<p style="color:red;">( Note: Minimum <?php echo $find_min->ContentValue;?> characters  Required)</p>
</div>
   

<div class="col-lg-6">
<div class="mb-3 form-block position-relative">
<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
</div>
<label for="" class="mb-2"><?php echo  ucwords(($this->lang->line('lbl_re_'.$row->ReuireFieldName)) ? $this->lang->line('lbl_re_'.$row->ReuireFieldName) : $row->ReuireFieldName); ?> <small class="text-danger">*</small>
</label>

<input type="password" name="RepeatPassword" id="RepeatPassword" class="form-control mb-3" placeholder="<?php echo  $this->lang->line('place_re_'.$row->ReuireFieldName); ?>" value="" <?php echo  $st;?>>
<h4><?php echo form_error('RepeatPassword','<em class="state-error">','</em>'); ?></h4>

</div>
</div>
    <?php 
    $st=''; } 

    elseif ($row->ReuireFieldName=='Email') {   ?>
    <?php if($row->ReuireFieldStatus=='1') {$st = 'email required';}else{$st="";}?>
    <?php $st=''; }

    elseif($row->ReuireFieldName=='Country' && $row->FieldEnableStatus==1) { 

    if($row->ReuireFieldStatus=='1') {
    $st = 'required';}else{$st="";
    } 
    ?>

    <h4><?php echo form_error('Country','<em class="state-error">','</em>'); ?></h4>
    <?php }
    elseif($row->ReuireFieldName=='Gender' && $row->FieldEnableStatus==1) { 

    if($row->ReuireFieldStatus=='1') {
    $st = 'required';}else{$st="";
    } 
    ?>
    <?php }

    } ?>
    <?php   
    $captchaset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='usecaptcha'", "arm_setting");

    if($captchaset->ContentValue=="On") {
    $sitekey = $this->common_model->GetRow("Page='reCaptcha' AND KeyValue='siteKey'", "arm_setting");
    if ($sitekey->ContentValue) {

    ?>
    <h3><?php echo ucwords($captchaset->KeyValue);?><sup> <em class="state-error">*</em> </sup></h3>
    <div class="g-recaptcha" data-sitekey="<?php echo $sitekey->ContentValue;?>" style="padding-left: 40px;"></div>
    <h4><?php echo form_error('g-recaptcha-response','<em class="state-error">','</em>'); ?></h4>

    <?php 
    } }
    ?>
  <input type="hidden" name="web_mode" value="1">
  <div class="col-lg-12">
  <h3></h3>
  <h4> <?php echo form_error('terms','<em class="state-error">','</em>'); ?></h4>
  </div>

  <div class="col-sm-12 text-center">
  <div class="checkbox mb-3 position-relative">
  <label class="text-white">

<input type="checkbox" name="terms" <?php if(set_value('terms')){ echo"checked='checked'";} ?> /> 
  <a target="_blank" href="<?php echo base_url(); ?>user/cms/Termscondition" ><?php echo  $this->lang->line('terms');?></a>
  </div>
  <div class="form-btn"><input type="submit" name="reg"  class="btn btn-primary" value="Register Now"/> </div>
  </div>



    </div>

    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
  </h3>
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
</div>
</div>
</section>
    </body>


    <!-- check password-->

    </html>
    <?php $this->load->view('user/common_footer'); ?>

    <script src="<?php echo  base_url(); ?>assets/user/js/jquery-2.2.1.js" type="text/javascript"></script>
    <script src="<?php echo  base_url(); ?>assets/user/js/bootstrap.js" type="text/javascript"></script>

    <script src="<?php echo  base_url(); ?>assets/user/js/css3-animate-it.js"></script>

    <script type="text/javascript">
    jQuery('.carousel').carousel({
    interval: 7000
    })
    $(window).load(function() {
    $(".se-pre-con").fadeOut("slow");;
    });

    function country_change(str)
    {
    var code=document.getElementById('count'+str).value;
    document.getElementById('code').value='+'+code;
    }
    </script>

    <?php $this->load->view('user/common_script');?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
