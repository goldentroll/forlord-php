	<!doctype html>
	<html lang="en">
<!-- 
	<link href="<?php echo base_url();?>assets/user/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" /> -->


	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">


	<head>
	<?php $this->load->view('user/meta');?>
	<?php $this->load->view('user/index_header');?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">

	<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
	</head>


	<link href="<?php echo base_url();?>assets/user/fonts/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/css/ionicons.min.css">

	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/css/feather.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/morris/morris.css">

	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>



	<body class="">
	<div class="wrapper dash-bg">

	<?php $this->load->view('user/user_aside');?>

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
	<h3 class="fw-normal2 text-white"> <?php echo  ucwords($this->lang->line('pagetitle'));?> </h3>
	</div>
	   <div class="dash-btn"><span class="text-white text-grad " style="font-size:14px;">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span>  <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div>
	</div>
	</div>
	</div>
	</div>
	<div class="admin-middle">
	<div class="container-fluid">
	<div class="row">

	<div class="col-sm-12">
	<div class="title text-center"> <span class="text-grad">Quick Stats</span>
	<h2 class="text-white fw-bold mb-3 text-uppercase pla"><?php echo  ucwords($this->lang->line('pagetitle'));?></h2>
	</div>
	</div>
	</div>

	<div class="col-lg-4">
	<label class="text-white">No referral <span style="  border: 1px  black;padding-left: 20px;margin-left: 5px;background-color:<?php echo $noreferral;?> ; border-radius: 50%;"></span></label>

	</div>
	<div class="col-lg-4">
	<label  class="text-white">One referral<span style=" border: 1px  black;padding-left: 20px;margin-left: 5px;background-color:<?php echo $onereferral;?>  ;border-radius: 50%;"></span></label>
	</div>
	<div class="col-lg-4">
	<label  class="text-white">2 more referral<span style=" border: 1px  black;padding-left: 20px;margin-left: 5px;background-color:<?php echo $tworeferral;?>  ; border-radius: 50%;"></span></label>

	</div>

	<!-- //starts -->

	<div class="row">
	<div class="col-lg-11">
	<div class="box">

	<div class="box-body form-back position-relative z-in1 bord-grad">
	<div class="row">

<div class="col-xs-12">
<?php if($this->session->flashdata('error_message')) { ?>    

<label class="label label-danger col-lg-12"><?php echo ucwords($this->session->flashdata('error_message'));?></label>

<?php unset($_SESSION['error_message']); } ?>

<?php if($this->session->flashdata('success_message')) { ?>    

<label class="label label-success col-lg-12"><?php echo ucwords($this->session->flashdata('success_message'));?></label>

<?php unset($_SESSION['success_message']); } ?>
</div>


	<?php
$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

	if($mlsetting->Id==1)
	{
	$path="force";
	}
	else if($mlsetting->Id==2)
	{
	$path="unilevel";
	}
	else if($mlsetting->Id==3)
	{
	$path	="monoline";
	}
	else if($mlsetting->Id==4)
	{
	$path= "binary";
	}
	else if($mlsetting->Id==5)
	{
	$path= "board";
	}
	else if($mlsetting->Id==6)
	{
	$path= "xup";
	}
	else if($mlsetting->Id==7)
	{
	$path= "oddeven";
	}
	else if($mlsetting->Id==8)
	{
	$path= "board1";
	}
	else if($mlsetting->Id==9)
	{
	$path= "binaryhyip";
	}
	?>

	<div class="col-md-12">
	<?php if($mlsetting->Id==5)
	{
	?>
	<div class="regform">

	Select Board : 
	<select name="board" id="board"  class="board field select" onchange="showgen(this.value)">
	<?php 
	$bplan = $this->db->query("SELECT DISTINCT(BoardId) FROM `arm_boardmatrix` WHERE `MemberId`='".$this->session->MemberID."' ");
	for($i=0;$i< $bplan->num_rows(); $i++)
	{
	$bpid = ""; 
	$bpid = $bplan->row($i)->BoardId;
	$bdet = $this->common_model->GetRow("PackageId='".$bpid."'","arm_boardplan");
	?>
	<option value="<?php echo $i;?>" <?//if($i==0){echo"selected";}?>><?php echo $bdet->PackageName?></option>
	<?php } ?>
	</select>


	</div><?php } ?>
	<?php if($mlsetting->Id==8)
	{?>
	<div class="regform">

	Select Board : 
	<select name="board" id="board"  class="board field select" onchange="showgen(this.value)">
	<?php 
	$bplan = $this->db->query("SELECT DISTINCT(BoardId) FROM `arm_boardmatrix1` WHERE `MemberId`='".$this->session->MemberID."' ");
	for($i=0;$i< $bplan->num_rows(); $i++)
	{
	$bpid = ""; 
	$bpid = $bplan->row($i)->BoardId;
	$bdet = $this->common_model->GetRow("PackageId='".$bpid."'","arm_boardplan");
	?>
	<option value="<?php echo $i;?>" <?//if($i==0){echo"selected";}?>><?php echo $bdet->PackageName?></option>
	<?php } ?>
	</select>


	</div><?php } ?>
	<br><br><br><br>


	<?php if($mlsetting->Id==5 || $mlsetting->Id==8)
	{ 	
	for($i=0; $i< $bplan->num_rows(); $i++)
	{  ?>


	<iframe class="col-xs-12 genview" style ="display:none;"  id="<?php echo  "gen_".$i;?>" width="1050px" height="700px" src="<?php echo base_url()."genealogy/".$path;?>/genealogyview/view/<?php  echo $bplan->row($i)->BoardId?>/<?php echo $this->session->MemberID;?>" style="padding-top:5px; margin-top:-80px;  margin-right: 2px;"></iframe>

	<?						
	}	
	}
	elseif($mlsetting->Id==4){	?>

	<iframe class="col-xs-12" height="700px" src="<?php echo base_url()."genealogy/".$path;?>/genealogyview1/view/<?php echo $this->session->MemberID?>" style="padding-top:5px; margin-top:-80px;  margin-right: 2px;"></iframe>
	<?php 	}	
	else
	{?>
	<iframe class="col-xs-12" height="700px" src="<?php echo base_url()."genealogy/".$path;?>/genealogyview/view/<?php echo $this->session->MemberID?>" style="padding-top:5px; margin-top:-80px;  margin-right: 2px;"></iframe>
	<?php } ?>

	</div>
	</div>
	</div>

	<div class="box-footer">
	<div class="row">
	<div class="col-md-12">
	<div class="dshfrom text-center">
	<!-- //<input type="button" value="update now" /> -->
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

	function showgen(id)
	{
	// console.log(id);
	var shid ='gen_'+id;
	$('.genview').css("display","none");
	$('#'+shid).css("display","block");

	}
	$(document).ready(function() {
	// alert($('#board').val());
	var id = $('#board').val();
	var shid ='gen_'+id;
	$('#'+shid).css("display","block");
	} );


	</script>





	</body>
	</html>
