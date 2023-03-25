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
    <h3 class="fw-normal2 text-white">Edit Password </h3>
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
	<div class="col-lg-12">
	<?php if($this->session->flashdata('error_message')) { ?>
	<label class="label label-danger col-lg-12"><?php echo ucwords($this->session->flashdata('error_message'));?></label>
	<?php unset($_SESSION['error_message']); } ?>

	<?php if($this->session->flashdata('success_message')) { ?>
	<label class="label label-success col-lg-12"><?php echo ucwords($this->session->flashdata('success_message'));?></label>
	<?php unset($_SESSION['success_message']); } ?>
	</div>

	<div class="row">
	<div class="col-sm-12">
	<div class="title text-center"> 
	<h2 class="text-white fw-bold mb-3 text-uppercase"><?php echo  ucwords($this->lang->line('pagetitle_updatepassword'));?></h2>
	</div>
	</div>
	</div>

<?php 
$find_min=$this->db->query("select * from arm_setting where Page='usersetting' and KeyValue='minuserpasswordlength'")->row();
$find_max=$this->db->query("select * from arm_setting where Page='usersetting' and KeyValue='maxuserpasswordlength'")->row();
?>
<!-- //starts -->

	<div class="row">
	<div class="box">

	<div class="box-body">
	<div class="row">
	<div class="prfle">


	<?php if($this->session->flashdata('error_message')) { ?>    

	<label class="label label-danger col-lg-12"><?php echo ucwords($this->session->flashdata('error_message'));?></label>

	<?php unset($_SESSION['error_message']); } ?>

	<?php if($this->session->flashdata('success_message')) { ?>    

	<label class="label label-success col-lg-12"><?php echo ucwords($this->session->flashdata('success_message'));?></label>

	<?php unset($_SESSION['success_message']); } ?>
	</div>

	<div class="col-lg-11">

	<form method="post" action="" class="form" id="form-register" autocomplete="off" enctype="multipart/form-data">
  <div class="form-back position-relative z-in1 bord-grad">

<div class="row">

	<div class="col-lg-6">
	<div class="mb-3 form-block position-relative">
	<label for="text-white mb-3" style="color: white;margin-bottom: 10px;
	"><?php echo  ucwords($this->lang->line('newpassword')); ?><small class="text-danger"> *</small></label>
	<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
	</div>
	<input type="password" name="newpassword" value="" class="form-control mb-3" required>
	</div>
	<?php echo form_error('newpassword'); ?>
	<p style="color:red;">( Note: Minimum <?php echo $find_min->ContentValue;?> characters  Required)</p>
	</div>

	<div class="col-lg-6">
	<div class="mb-3 form-block position-relative">
	<label for="text-white mb-3" style="color: white;margin-bottom: 10px;
	"><?php echo  ucwords($this->lang->line('repeatpassword')); ?><small class="text-danger"> *</small></label>
	<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
	</div>
	<input type="password" name="repeatpassword" value="" class="form-control mb-3" required>

	</div>
	<?php echo form_error('repeatpassword'); ?>
	</div>

	<input type="hidden" name="memberid" id="memberid" value="<?php echo $this->session->userdata('MemberID');?>">
	<input type="hidden" name="web_mode" value="1">


	<div class="col-lg-6">
	<div class="mb-3 form-block position-relative">
	<label for="text-white mb-3" style="color: white;margin-bottom: 10px;
	"><?php echo  ucwords($this->lang->line('cpassword')); ?><small class="text-danger"> *</small></label>
	<div class="form-ico bg-gradient rounded-circle box"> <i class="fa fa-unlock-alt text-white"></i>
	</div>
	<input type="password" name="currentpassword" value="" class="form-control mb-3" required>

	</div>
	<?php echo form_error('currentpassword'); ?>
	</div>

	<div class="col-lg-12 text-center">
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
	</div>
	</div>
	</div>

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
</body>
</html>

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

	<!--    <script src="js/js/demo.js"></script>-->


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
