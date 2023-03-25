<!doctype html>
<html lang="en">
<head>
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<link href="<?php echo base_url();?>assets/user/fonts/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/user/css/ionicons.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/morris/morris.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<style type="text/css">
	em
	{
		position: absolute;
		z-index: 1;
		right: 61px;
	}
	.form-control:disabled, .form-control[readonly] {
    background-color: gray !important;
    opacity: 1;
}
</style>
<body class="">
<div class="wrapper dash-bg">
<?php $this->load->view('user/user_aside');?>
<div id="content">
    <div id="content">
    <div class="admin_main">
    <button type="button" id="sidebarCollapse" class="toggle">
    <div class="toggle_admin"> <img src="<?php echo base_url();?>assets/styl/images/toggle-ic.png" class="img-fluid" /> </div>
    </button>
    <div class="admin-top position-relative">
    <div class="row">
    <div class="col-sm-12">
    <div class="d-lg-flex justify-content-between">
    <div class="admin-head position-relative">
    <h3 class="fw-normal2 text-white">Edit Profile </h3>
    </div>
    <div class="dash-btn"><span class="text-white text-grad " style="font-size:14px;">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span>  <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div>
    </div>
    </div>
    </div>
    </div>
    <div class="admin-middle">
    <div class="container-fluid">

	<div class="row">
	<div class="col-md-12">
	<div class="box">

	<div class="box-body">
	<div class="row">
	<div class="prfle">


	<div class="row">
	<div class="col-sm-12">
	<div class="title text-center"> 
	<h2 class="text-white fw-bold mb-3 text-uppercase"><?php echo  ucwords($this->lang->line('edit')." ".$this->lang->line('profile'));?> </h2>
	</div>
	</div>
	</div>


	<div class="col-md-12">

	<div class="col-lg-12">
	<?php if($this->session->flashdata('error_message')) { ?>
<div class="alert alert-danger">
	<label class="label label-danger col-lg-12"><?php echo ucwords($this->session->flashdata('error_message'));?></label>
</div>
	<?php unset($_SESSION['error_message']); } ?>

	<?php if($this->session->flashdata('success_message')) { ?>
		<div class="alert alert-success">
	<label class="label label-success col-lg-12"><?php echo ucwords($this->session->flashdata('success_message'));?></label>
</div>
	<?php unset($_SESSION['success_message']); } ?>
	</div>

	<p style="color: red"> Note :</p><p> If You Update the  Transaction Password Means  <a href="<?php echo base_url();?>user/profile/changetransaction">Click here</a></p>

	<form method="post" action="" class="form" id="form-register" autocomplete="off" enctype="multipart/form-data">

  <div class="form-back position-relative z-in1 bord-grad">
  <div class="row">

  <div class="col-sm-12">

  <label for="text-white mb-3" style="color: white;margin-bottom: 10px;
  "><?php echo ucwords($this->lang->line('profileimage'));?></label>

	<div class="fileupload-preview thumbnail mb-3">
	<img style="width: 100px;" src="<?php echo base_url(); if(isset($member->ProfileImage)){echo $member->ProfileImage; }?>" alt="<?php echo ucwords($this->lang->line('profileimage'));?>">
	</div>

	<div class="mb-3 form-block position-relative">
	<input type="file"  name="profileimage" class="form-control" value="<?php if(isset($member->ProfileImage)){echo $member->ProfileImage; }?>">
	</div>
	<?php echo form_error('profileimage'); ?>
	</div>



	<div class="col-md-12">
	<?php 
	$customfield = array(); 
	$customdata = json_decode($member->CustomFields);
	foreach ($customdata as $key => $value) {
	array_push($customfield, $key);
	}

	foreach ($requirefields as $row) {
	$fname = $row->ReuireFieldName;

	if($row->FieldEnableStatus==1 && $row->ReuireFieldName!='Password' && $row->ReuireFieldName!='Email' && $row->ReuireFieldName!='Country'&& $row->ReuireFieldName!='UserName')
	{ 
	if(in_array($row->ReuireFieldName,$customfield)){ 

	if($row->ReuireFieldName=='bankwire')
	$disp="Bank Name";
	else if($row->ReuireFieldName=='bankwireacno')
	$disp="Bankwire Account Number";
	else
	$disp=$row->ReuireFieldName;
	?>

	<h3><?php echo  ucwords($disp); ?><?php if($row->ReuireFieldStatus=='1') {$st = 'required';?> <sup> <em class="state-error">*</em> </sup><?php } else{$st="";}?></h3>

	<?php if($row->ReuireFieldStatus=='1') {$st = 'required';}else{$st="";}?>
	<input type="text" name="<?php echo  $row->ReuireFieldName; ?>" id="<?php echo  $row->ReuireFieldName; ?>" class="gui-input " placeholder="<?php echo  $this->lang->line('place_'.$row->ReuireFieldName); ?>" value="<?php echo set_value($fname,isset($customdata->$fname) ? $customdata->$fname : ''); ?>" <?php echo  $st;?> >

	<h4> <?php echo form_error($row->ReuireFieldName); ?> </h4><?php
	$st='';    
	}
	else
	{
	if($row->ReuireFieldName=='Phone'){?>
	<h3><?php echo  "Mobile Phone"; ?><sup> <em class="state-error">*</em> </sup></h3>
	<?php if($row->ReuireFieldStatus=='1') {$st = 'required';}else{$st="";}?>

	<?php 
	$find_coun=$this->db->query("select * from arm_country where country_id='".$member->Country."'")->row();
	if($find_coun)
	{
	$pho='+'.$find_coun->code;
	}
	else
	$pho='';
	?>
	<h4> <?php echo form_error($row->ReuireFieldName); ?></h4>
	<?php
	$st='';
	}else{?>

<div class="col-lg-12">
<div class="mb-3 form-block position-relative">
<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
</div>
<label for="" class="mb-3"><?php echo  ucwords($row->ReuireFieldName); ?><small class="text-danger">*</small></label>
<input type="text" name="<?php echo  $row->ReuireFieldName; ?>" id="<?php echo  $row->ReuireFieldName; ?>"  class="form-control mb-3"  placeholder="<?php echo  $row->ReuireFieldName; ?>" value="<?php echo set_value($fname,isset($member->$fname) ? $member->$fname : ''); ?>" <?php echo  $st;?> >
	<h4> <?php echo form_error($row->ReuireFieldName); ?></h4>
</div>
</div>

	<?php
	$st='';
	}
	}
	}
	elseif ($row->ReuireFieldName=='UserName') {   ?>

<?php if($row->ReuireFieldStatus=='1') {$st = 'required';}else{$st="";}?>

	<div class="col-lg-12">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
	</div>
	<label for="" class="mb-3"><?php echo  ucwords($this->lang->line('lbl_'.$row->ReuireFieldName)); ?><small class="text-danger">*</small></label>

	<input type="text" name="<?php echo  $row->ReuireFieldName; ?>" id="<?php echo  $row->ReuireFieldName; ?>" class="form-control mb-3" placeholder="<?php echo  $this->lang->line('place_'.$row->ReuireFieldName); ?>" readonly value="<?php echo set_value($fname,isset($member->$fname) ? $member->$fname : ''); ?>" <?php echo  $st;?> readonly>
	<h4> <?php echo form_error($row->ReuireFieldName); ?></h4>

	</div>
	</div>

	<?php
	$st=''; 
	}
	elseif ($row->ReuireFieldName=='Email') {   ?>
	<?php if($row->ReuireFieldStatus=='1') {$st = 'email required';}else{$st="";}?>


	<div class="col-lg-12">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
	</div>


	<label for="" class="mb-3"><?php echo  ucwords($this->lang->line('lbl_'.$row->ReuireFieldName)); ?><small class="text-danger">*</small></label>

<?php
	$vendorstatus=$this->common_model->GetRow("KeyValue='useremailchangestatus'","arm_setting");
	$content=$vendorstatus->ContentValue;


	if($content=='1')
	{?>
	<input type="text" name="<?php echo  $row->ReuireFieldName; ?>" <?php if($row->ReuireFieldName=='Email'){ echo 'readonly';}?> id="<?php echo  $row->ReuireFieldName; ?>" class="form-control mb-3" placeholder="<?php echo  $this->lang->line('place_'.$row->ReuireFieldName); ?>" value="<?php echo set_value($fname,isset($member->$fname) ? $member->$fname : ''); ?>" <?php echo  $st;?> >
	<?php } else {?>
	<input type="text" name="<?php echo  $row->ReuireFieldName; ?>" id="<?php echo  $row->ReuireFieldName; ?>" class="form-control mb-3" placeholder="<?php echo  $this->lang->line('place_'.$row->ReuireFieldName); ?>" value="<?php echo set_value($fname,isset($member->$fname) ? $member->$fname : ''); ?>" <?php echo  $st;?> readonly>
	<?php } ?>
	<h4> <?php echo form_error($row->ReuireFieldName); ?> </h4>

	</div>
	</div>
	<?php 
	$st=''; 
	}
	elseif($row->ReuireFieldName=='Country')
	{ 
	if($row->ReuireFieldStatus=='1') {
	$st = 'required';
	} 
	else {
	$st="";
	} 
	?>

	<?php
	}

	}
	?>

	<?php

	$getpayment = $this->db->query("select * from arm_paymentsetting where PaymentStatus='1' and PaymentName!='epin'")->result();

	$getpayments_user = $this->db->query("select * from arm_members where MemberId='".$this->session->userdata('MemberID')."'")->row();

	$payment_det =  $getpayments_user->Payments;

	$explode_payments = json_decode($payment_det);

	$all_payments = array();

	foreach ($explode_payments as $rows=>$values) 
	{
	$all_payments[$rows] = $values;
	}

	?>

	<?php
	foreach($country as $crows) 
	{ 
	?>
	<input type="hidden" name="count" id="count<?php echo $crows->country_id?>" value="<?php echo $crows->code?>">
	<?php 
	} 
	?>
	<?php	
	$propassstaus = $this->common_model->GetRow("Page='usersetting' AND KeyValue='profilepassordstatus'", "arm_setting");
	if($propassstaus->ContentValue == 1) 	 
	{ ?>


	<div class="col-lg-12">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
	</div>
	<label for="" class="mb-3"><?php echo ucwords($this->lang->line('transactionpassword')); ?></label>

	<input type="password" name="tPassword" class="form-control mb-3" placeholder="Enter <?php echo ucwords($this->lang->line('transactionpassword')); ?> " required />

	<h4><?php echo form_error('tPassword'); ?></h4>

	</div>
	</div>

	<?php 
	}
	?>

	<div class="col-lg-12">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
	</div>
	<label for="" class="mb-3"><?php echo ucwords($this->lang->line('loginpassword')); ?></label>
	<input type="password" name="Password" class="form-control mb-3" placeholder="Enter <?php echo ucwords($this->lang->line('loginpassword')); ?> " required />
	<h4><?php echo form_error('Password'); ?></h4>
	</div>
	</div>

	<input type="hidden" name="memberid" id="memberid" value="<?php echo $this->session->userdata('MemberID');?>">
	<input type="hidden" name="web_mode" value="1">
	
	<div class="col-sm-12 text-center">
	<div class="checkbox mb-3 position-relative">
	<label class="text-white">
	<input type="submit" name="reg" class="btn btn-primary" value="<?php echo ucwords($this->lang->line('update')); ?>"/> 
	</label>
	</div>
	</div>
	</div>

	</div>
	</form>
	</div>

	</div>
	</div>
	</div>
	<div class="box-footer">
	<div class="row">
	<div class="col-md-12">
	<div class="dshfrom text-center">
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
</form>
</div>
</div>
</div>
</div>
<?php $this->load->view('user/login_footer');?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</body>


	<script src="<?php echo base_url();?>assets/user/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

	<script src="<?php echo base_url();?>assets/user/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

	<script src="<?php echo base_url();?>assets/user/js/plugins/knob/jquery.knob.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
	<script src="<?php echo base_url();?>assets/user/js/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="<?php echo base_url();?>assets/user/js/plugins/datepicker/bootstrap-datepicker.js"></script>

	<!--<script src="plugins/fastclick/fastclick.min.js"></script>-->
	<script src="<?php echo base_url();?>assets/user/js/js/app.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/fileupload/fileupload.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/holder/holder.min.js"></script>

	<!--    <script src="js/js/demo.js"></script>-->
	<script type="text/javascript">
	function country_change(str)
	{

	var code=document.getElementById('count'+str).value;
	document.getElementById('code').value='+'+code;


	}
	</script>


	<script type="text/javascript">
	(function($) {

	$(document).ready(function() {

	$("#username").keyup(function(e){

	var username = $(this).val();
	if(username)
	{
	$.ajax({
	type    : 'post',
	url     : '<?php echo base_url();?>user/fund/checkmember/'+username,
	success : function(msg)
	{
	$('#nameverify').val(msg);
	}
	});
	}

	});
	$("#username").focusout(function(e){

	var username = $(this).val();
	if(username)
	{
	$.ajax({
	type    : 'post',
	url     : '<?php echo base_url();?>user/fund/checkmember/'+username,
	success : function(msg)
	{
	$('#nameverify').val(msg);
	}
	});
	}

	});

	$("#transferamount").click(function(e){

	var username = $('#username').val();

	if(username)
	{
	$.ajax({
	type    : 'post',
	url     : '<?php echo base_url();?>user/fund/checkmember/'+username,
	success : function(msg)
	{
	$('#nameverify').val(msg);
	}
	});
	}

	});
	});

	})(jQuery);
	</script>

	<script type="text/javascript">

	function calculatepay(amount)
	{

	var adminfee = $('#fee').val();
	var ftype = $('#ftype').val();
	var mtype= $('#mtype').val();
	if(mtype=='receiver')
	{
	var payamount = parseFloat(amount).toFixed(2);
	var fee = parseFloat(adminfee).toFixed(2);
	if(ftype =='percentage')
	{
	var fee = parseFloat(parseFloat(amount) * parseFloat(adminfee / 100)).toFixed(2);
	}

	}
	else
	{
	if(ftype =='percentage')
	{
	var fee = parseFloat(parseFloat(amount) * parseFloat(adminfee / 100)).toFixed(2);
	var payamount = parseFloat(parseFloat(fee) + parseFloat(amount)).toFixed(2);

	}
	else
	{
	var fee = parseFloat(adminfee).toFixed(2);
	var payamount =  parseFloat(parseFloat(amount) +  parseFloat(adminfee)).toFixed(2) ;
	}
	}
	$('#payableamount').val(payamount);
	$('#adminfee').val(fee);

	}
	</script>




	</body>
	</html>
