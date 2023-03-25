	<!doctype html>
<html lang="en">
<head>
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<style type="text/css">
	.investors-item--data
	{
	margin:20px;
	}
	.percent {
	font-size: 30px;
	line-height: 36px;
	font-weight: bold;
	font-family: var(--bs-font-sans-serifm);
	margin-top: 40px;
	}
	.active .investors-item--wraper
	{
	background: linear-gradient(to right, #4633F0 0%, #FC6296 26%, #FEA345 100%) !important; 
	}
	.unapprove .investors-item{
     cursor: not-allowed !important;
	}
	.unapprove 
	{

	 pointer-events: none;  
	}
	.label-danger p
	{
		color: red;
		font-weight: 600;
		font-size: 14px;
	}

</style>

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
<h3 class="fw-normal2 text-white"> Deposit </h3>
</div>

<div class="dash-btn"><span class="text-white text-grad">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span>  <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div>
</div>
</div>
</div>
</div>

	<div class="admin-middle">
	<div class="container-fluid">
	<div class="row">
	<div class="col-sm-12">
	<div class="title text-center"> <span class=" text-grad">plans</span>
	<h2 class="text-white fw-bold mb-3 text-uppercase pla">BUSINESS PLAN</h2>
	</div>
	</div>
	</div>

	<div class="col-lg-11">

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

<form action="<? echo base_url();?>user/upgrade/wallet_payment" method="post">

<div class="row">
<?php

$last_pack = $this->db->query("select PackageId from  arm_history where TypeId='19' and  MemberId='".$this->session->MemberID."'")->row();


$i=0;

foreach($packages as $prows) { 
$i++;

  if($prows->PackageId <= $upline_package)
  {
  	 $class = "approve";
  	 $clr = "";
  }
  else
  {
  	$class = "unapprove";
  	$clr = "#dddddd";
  }

if($sponsor==0)
{
	 $class = "approve";
  	 $clr = "";
}


	?>
	<div class="col-lg-6">


	<div class="res selection <?php echo $class; ?>">

<input id="packageid<?php echo $i;?>"  name="packageid" type="radio" value="<?php echo $prows->PackageId;?>">

<label for="packageid<?php echo $i;?>" style="width: 100%;" > 
	<div class="investors-item" style="min-height: 149px;">


	<div class="level-grad-block grad-bg" style="background:<?php echo $clr; ?>">
	<div class="percent"> <?php echo number_format($prows->DirectCommission);?> <?php echo currency(); ?></div>
	<div class="label">Referal</div>

	</div>

	<div class="investors-item--wraper" style="display: block;">

<?php

if($last_pack->PackageId==$prows->PackageId)
{
?>

<div class="Activated" style="float: right;">
<p style="padding: 4px;
background: linear-gradient(135deg, #5937ea 0%,#ef5caf 48%,#fea348 100%);
width: 82px;
float: inline-end;
font-size: 17px;
font-weight: 667;">
Activated
</p>
</div>


<?
}
?>

	<div class="investors-item--data">
	<div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-01.png" class="img-fluid"></div>
	<div class="text-wrap">
	<div>Package Name</div>
	<div class="colored-value"><?php echo ucfirst($prows->PackageName);?></div>
	</div>
	</div>

	<div class="investors-item--data">
	<div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-02.png" class="img-fluid"></div>
	<div class="text-wrap">
	<div>Package Fee</div>
	<div class="colored-value"><?php echo $prows->PackageFee." ".currency();?></div>

	</div>
	</div>

<?php

if($last_pack->PackageId==$prows->PackageId)
{
?>

<button style="padding: 4px;
float: right;
background: linear-gradient(135deg, #5937ea 0%,#ef5caf 48%,#fea348 100%);
width: 100%;
margin-top: -17px;
float: inline-end;
font-size: 17px;
font-weight: 667;"   >

<a href="<?php echo base_url();?>user/upgrade/start_mining?packageid=<?php echo $prows->PackageId;?>">Start Mining</a>
</button>

<?
}
?>
	</div>
	</div>
	</label>

	</div>
	</div>
<?php }?>
</div>

	</div>

	<div class="row justify-content-center py-3">

		<div class="col-sm-12">
		<div class="text-center title position-relative z-in1">
		<span class="text-grad">Deposit</span>
		<h2 class="text-white fw-bold pla">Payment Methods</h2>
		</div>
		</div>


		<div class="col-sm-11">
		<div class="make-block box">
		<div class="account-bala">
		<p class="text-white text-center"><strong>Selected Wallet </strong></p>
		</div>


	<div class="payment-selection">
	<ul class="payment-list-detail ps-0">

<?php
$wallet = $this->db->query("SELECT * FROM `arm_walletadderss` ORDER BY wallet_id DESC limit 0,1")->row();
$check_wallet = explode(',',$wallet->wallet_support);
?>

	<?php
	if (in_array("1", $check_wallet))
	{
	?>
			<li class="selection">
			<input id="test1" name="payment" type="radio" value="1">
			<label for="test1"> <img style="height: 60px;" src="<?php echo base_url();?>assets/img/metamask.png" class="img-fluid"> </label>
			</li>
	<?
	}
	?>
	<?php
	if (in_array("2", $check_wallet))
	{
	?>
			<li class="selection">
			<input id="test2" name="payment" type="radio"  value="2">
			<label for="test2"> <img  style="height: 60px;background-color: white;" src="<?php echo base_url();?>assets/img/trust_wallet.png" class="img-fluid"> </label>
			</li>
	<?
	}
	?>

	</ul>
	</div>

	<div class="deposit-btn text-center">
	<input type="submit" class="btn btn-primary" value="Deposit">
	</div>

</form>

	</div>
	</div>

	</div>





<?php $this->load->view('user/login_footer');?>





	</div>
	</div>
	</div>
	</div>
	</div>


	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered wallet-pop">
	<div class="modal-content grad-bg">
	<div class="modal-body">
	<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>

	<h2 class="title fw-bold text-center text-white pb-3">Connect Your Wallet</h2>

	<div class="wallet-block1 bg-white p-3">
	<div class="row">

	<div class="col-sm-6">
	<div class="text-center pt-lg-1 py-1"><img src="<?php echo base_url();?>assets/styl/images/ethereumlogo.png" class="image-fluid"/></div>
	</div>
	<div class="col-sm-6">
	<div class="text-center">
	<div class="d-flex align-items-center wall-content">
	<img src="<?php echo base_url();?>assets/styl/images/thick.png" class="image-fluid pe-2"/>
	<a href="#" class="btn btn-primary w-100">Register with a wallet</a>
	</div>
	<span class="text-primary">Ethereum</span>
	</div>

	</div>

	</div>
	</div>


	<div class="wallet-block1 bg-white p-3">
	<div class="row">

	<div class="col-sm-6">
	<div class="text-center pt-lg-1 py-1"><img src="<?php echo base_url();?>assets/styl/images/wallet-logo.png" class="image-fluid"/></div>
	</div>
	<div class="col-sm-6">
	<div class="text-center">
	<div class="d-flex align-items-center wall-content">
	<img src="<?php echo base_url();?>assets/styl/images/quest.png" class="image-fluid pe-2"/>
	<a href="#" class="btn btn-primary w-100">Sign Up with WalletConnect</a>
	</div>
	<span class="text-primary">For all devices</span>
	</div>

	</div>

	</div>
	</div>


	<div class="float-lg-end text-center"><a href="#" class="btn btn-outline-light"><i class="fa-solid fa-circle-info pe-2"></i>Support</a></div>


	</div>

	</div>
	</div>
	</div>
	<!-- <script src="<?php echo base_url();?>assets/styl/js/admin.js"></script>  -->
	</body>
	</html>

<script type="text/javascript">

</script>