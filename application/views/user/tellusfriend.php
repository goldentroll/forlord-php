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

 @media only screen and (max-width:767px) {

.form-control {
padding: 10px !important;

}
em{
	display: contents;
	position: absolute;
	bottom: 0px;
}
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
    <h3 class="fw-normal2 text-white"> Tellus Friend</h3>
    </div>
   <div class="dash-btn"><span class="text-white text-grad " style="font-size:14px;">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span>  <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div>
    </div>
    </div>
    </div>
    </div>
    <div class="admin-middle">
    <div class="container-fluid">

	<div class="bskt">
	<?php if($this->session->flashdata('error_message')) { ?>  
	<div class="alert alert-danger alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<?php echo $this->session->flashdata('error_message');?>
	</div>  

	<?php } ?>

	<?php if($this->session->flashdata('success_message')) { ?>    
	<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<?php echo $this->session->flashdata('success_message');?>
	</div>
	<?php } ?>
	</div>
	<?php 
	if($tellus){
	$message = urldecode($tellus->Message);
	$refer_link = '<a href="'.base_url().'user/register/process/'.$member->ReferralName.'" target="_blank">Click here</a>';
	$site_link = '<a href="'.base_url().'" target="_blank">Click here</a>';

	$user_name = $this->session->userdata('full_name');
	$message = str_replace('[YOUR_NAME]', $user_name, $message);
	$message = str_replace('[REFER_LINK]', $refer_link, $message);
	$message = str_replace('[SITE_LINK]', $site_link, $message);
	}
	?>
	<div class="row">
	<div class="col-lg-11">
	<div class="box box-primary">
	<div class="box-header with-border">
	<h3 class="box-title"></h3>

	<div class="row">
	<div class="col-sm-12">
	<div class="title text-center"> <span class=" text-grad">Tell a Friend</span>
	<h2 class="text-white fw-bold mb-3 text-uppercase">Message </h2>
	</div>
	</div>
	</div>

	<div class="box-body">
	<form class="form-horizontal" id="tellus-forms" method="post" action="<?php echo base_url();?>user/tellus/add" >
	<div class=""> 
	<span class="">
	<ul class="nav panel-tabs">
	<li  class="active"><a href="#tab1" data-toggle="tab"></a></li>
	<li id="message-content"><a></a></li>
	</ul>
	</span> 
	</div>

	<div class="panel-body">
	<div class="tab-content">
	<div class="tab-pane active" id="tab1">
	<br/><br/>
	<div class="row mt40">
	<div class="col-sm-12">
	<div class="row">
	<div class="col-sm-12">
	<div class="trans-table bg-primary rounded-1" style="overflow-x: auto;">
	<table id="example1" class="table table-bordered  table-striped" >
	<tr style="background: linear-gradient(135deg, #5937ea 0%,#ef5caf 48%,#fea348 100%);">
	<td ><label for="inputName" class="control-label">First Name</label></td>
	<td ><label for="inputName" class="control-label">Last Name</label></td>
	<td ><label for="inputName" class="control-label">Email</label></td>
	</tr>
	<tr>
	<td><input type="text" class="form-control"  id="firstname1" name="firstname[]" placeholder="firstname"></td>
	<td><input type="text" class="form-control"  id="lastname1" name="lastname[]" placeholder="lastname"></td>
	<td><input type="email" class="form-control" id="email1"  name="email[]" placeholder="Email"></td>
	</tr>
	<tr>
	<td><input type="text" class="form-control"  name="firstname[]" placeholder="firstname"></td>
	<td><input type="text" class="form-control"  name="lastname[]" placeholder="lastname"></td>
	<td><input type="email" class="form-control"  name="email[]" placeholder="Email"></td>
	</tr>
	<tr>
	<td><input type="text" class="form-control"  name="firstname[]" placeholder="firstname"></td>
	<td><input type="text" class="form-control"  name="lastname[]" placeholder="lastname"></td>
	<td><input type="email" class="form-control"  name="email[]" placeholder="Email"></td>
	</tr>
	<tr>
	<td><input type="text" class="form-control"  name="firstname[]" placeholder="firstname"></td>
	<td><input type="text" class="form-control"  name="lastname[]" placeholder="lastname"></td>
	<td><input type="email" class="form-control"  name="email[]" placeholder="Email"></td>
	</tr>
	<tr>
	<td><input type="text" class="form-control"  name="firstname[]" placeholder="firstname"></td>
	<td><input type="text" class="form-control"  name="lastname[]" placeholder="lastname"></td>
	<td><input type="email" class="form-control"  name="email[]" placeholder="Email"></td>
	</tr>
	<input type="hidden" name="memberid" value="<?php echo $this->session->MemberID;?>">
	<input type="hidden" name="web_mode" value="1">
	</table>


	<div class="form-group">
	<div class="col-sm-offset-10 col-sm-10">
	<button type="button" id="button_add" class="btn btn-primary">Next</button>
	</div>
	</div>
	</div>
	</div>
</div>
</div>
</div>
	</div>
	<div class="tab-pane" id="tab2">
	<br/><br/>
	<div class="row mt40">
	<div class="col-sm-12">
	<div class="form-group">
	<textarea id="compose-textarea" class="form-control" style="height: 300px" name="message">
	<?php 
	if($tellus){ echo $message; } else { echo ""; } ?>
	</textarea>
	</div>
	<div class="form-group">
	<div class="col-sm-offset-10 col-sm-10">
	<button type="submit" id="button_message" class="btn btn-primary">Submit</button>
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
</div>
</div>
<?php $this->load->view('user/login_footer');?>
</div>
</div>
</div>
</div>
</div>
</body>


	<script src="<?php echo base_url();?>assets/user/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?php echo base_url();?>assets/user/js/jquery-ui.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="<?php echo base_url();?>assets/user/bootstrap/js/bootstrap.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

	<script src="<?php echo base_url();?>assets/user/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script type="text/javascript">
	function tellusFunc() {
	if ($('#tellus-forms').valid()) {
	if($('#firstname1').val()!=='' && $('#lastname1').val()!=='' && $('#email1').val()!=='')
	// if($('#inputName1').val()!=='')
	{
	$('#tellus-forms').submit();
	}
	}
	}
	</script>

	<script src="<?php echo base_url();?>assets/allcp/forms/js/jquery.validate.min.js"></script>
	<script src="<?php echo base_url();?>assets/user/js/js/app.min.js"></script>
	<script type="text/javascript">

	(function($) {

	$(document).ready(function() {

	$.validator.methods.smartCaptcha = function(value, element, param) {
	return value == param;
	};


	$.validator.addMethod("alpha", function(value, element) {
	return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
	});

	$("#tellus-forms").validate({

	errorClass: "text-danger",
	validClass: "text-success",
	errorElement: "em",

	// Rules

	rules: {
	firstname1: {
	required: true,
	alpha: true,
	minlength: 3

	},
	lastname1: {
	required: true,
	alpha: true
	},
	email1: {
	required: true,
	email: true
	}

	},

	messages: {
	firstname1: {
	required: 'Please enter firstname',
	alpha: 'Enter only characters',
	minlength: 'please enter minimum 3 characters'

	},
	lastname1: {
	required: 'Please enter firstname',
	alpha: 'Enter only characters'
	},
	email1: {
	required: 'Please enter Email',
	email: 'Enter a VALID email address'
	}

	},


	highlight: function(element, errorClass, validClass) {
	$(element).closest('.field').addClass(errorClass).removeClass(validClass);
	},
	unhighlight: function(element, errorClass, validClass) {
	$(element).closest('.field').removeClass(errorClass).addClass(validClass);
	},
	errorPlacement: function(error, element) {
	if (element.is(":radio") || element.is(":checkbox")) {
	element.closest('.option-group').after(error);
	} else {
	error.insertAfter(element.parent());
	}
	}

	});

	});

	})(jQuery);

	</script>


	<script>
	$(function () {
	//Add text editor
	$("#compose-textarea").wysihtml5();
	});

	$(document).delegate('#button_add', 'click', function() {
	if ($('#tellus-forms').valid()) {
	if($('#firstname1').val()==='') {
	$('#firstname1').css('border', '1px solid red');
	} else {
	$('#firstname1').css('border', '1px solid #ccc');
	}
	if($('#lastname1').val()==='') {
	$('#lastname1').css('border', '1px solid red');
	} else {
	$('#lastname1').css('border', '1px solid #ccc');
	}
	if($('#email1').val()!=='')
	{
	$('#message-content').html('<a data-toggle="tab" href="#tab2"> Message</a>');
	$('#email1').css('border', '1px solid #ccc');
	$('a[href=\'#tab2\']').trigger('click');
	} else {
	$('#email1').css('border', '1px solid red');
	}

	}

	});

	</script>

	</body>
	</html>
