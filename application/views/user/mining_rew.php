<?php 
$PackageName=$packages[0]->PackageName;
$mining_reward=(float)$packages[0]->mining_reward;
$PackageId=$packages[0]->PackageId;
$ucondition = "MemberId='".$this->session->MemberID."'";
$userdetails = $this->common_model->GetRow($ucondition,"arm_members");
$memberid= $userdetails->MemberId;

?>
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
	<?php 
			$rcondition = "memberid =" . "'" . $this->session->MemberID . "' AND PackageId='" . $packageid . "' ";
			$datas = $this->common_model->GetRow($ucondition,"Mining_reward");
			$today_fe=$datas->DateAdded;			
			$next_run=$datas->mechureddate;
			// echo $today_fe."<br>";
			// echo $next_run."<br>";
			$accept_date = date("Y-m-d H:i:s");
			if($accept_date>=$next_run){
				$contes="Collect & ";
				
			}
			else{
				$contes=" ";

			}
			
			?>

<div class="row justify-content-center py-2">

		<div class="col-sm-12">
		<div class="text-center title position-relative z-in1">
		<span class="text-grad">Mining Reward</span>
		<h2 class="text-grad fw-bold pla">Mining Reward</h2>
		
		<input type="hidden" name="packagename" id="packagename" value="<?php echo ucfirst($PackageName);?>">
		<input type="hidden" name="PackageId" id="PackageId"value="<?php echo $PackageId;?>">
		<input type="hidden" name="memberid" id="memberid" value="<?php echo $memberid;?>">
		</div>
		</div>
		<?php 
		$token=$this->common_model->GetRow("id='1'","arm_tokens");
		$last_minin_pac=$this->db->query("select * from Mining_reward where memberid='".$memberid."' and PackageId='".$PackageId."'  order by id desc limit 1")->result();
		$active_date=$last_minin_pac[0]->DateAdded;
		$next_run_date=$last_minin_pac[0]->next_run_date;
		$Status=$last_minin_pac[0]->Status;
		
		if($Status=='1'){
		?>
		<div class="col-sm-11">
		<div class="make-block box">
		<form action="" method="post">
		<div class="account-bala">
		<p class="text-white text-center"><strong>Package for Mining Rewards </strong></p>
		<div class="payment-selection">
			<ul class="payment-list-detail ps-0">
				<li class="selection">
					<div class="investors-item--data">
					<div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-01.png" class="img-fluid"></div>
					<div class="text-wrap">
					<div>Package Name</div>
					<div class="colored-value"><?php echo ucfirst($PackageName);?></div>
					</div>
					</div>
				</li>
				<input type="hidden" name="packagename" value="<?php echo ucfirst($PackageName);?>">
				<li class="selection">
					<div class="investors-item--data">
					<div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-01.png" class="img-fluid"></div>
					<div class="text-wrap">
					<div>Mining Rewards</div>
					<div class="colored-value"><?php echo $token->token_symbol; ?> <?php echo number_format($mining_reward,2);?></div>
					</div>
					</div>
				</li>

				<li class="selection">
					<div class="investors-item--data">
					<div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-01.png" class="img-fluid"></div>
					<div class="text-wrap">
					<div>Per Hours Rewards</div>
					<div class="colored-value"><?php echo $token->token_symbol; ?> 
					<?php
					 $perhour=$mining_reward/24;
					 
					 echo round($perhour, 2)."/Hour";
					?>
						
					</div>
					</div>
					</div>
				</li>

				<input type="hidden" name="mining_reward" value="<?php echo $mining_reward;?>">
			</ul>
		</div>
		<input type="hidden" name="PackageId" value="<?php echo $PackageId;?>">
		<div class="deposit-btn text-center">
		
		<button id="stopbtn" class="btn btn-primary" disabled>
			Stop MIning
		</button>
		</div>
		</form>
		</div>
		</div>
		</div>
	<?php }else{?>



		<div class="col-sm-11">
		<div class="make-block box">
		<form action="<? echo base_url();?>user/upgrade/mining_payment" method="post">
		<div class="account-bala">
		<p class="text-white text-center"><strong>Package for Mining Rewards</strong></p>
		<div class="payment-selection">
			<ul class="payment-list-detail ps-0">
				<li class="selection">
					<div class="investors-item--data">
					<div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-01.png" class="img-fluid"></div>
					<div class="text-wrap">
					<div>Package Name</div>
					<div class="colored-value" id="PackageName"><?php echo ucfirst($PackageName);?></div>
					</div>
					</div>
				</li>
				<input type="hidden" name="packagename" id="packagename" value="<?php echo ucfirst($PackageName);?>">
				<input type="hidden" name="memberid" id="memberid" value="<?php echo $memberid;?>">
				<li class="selection">
					<div class="investors-item--data">
					<div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-01.png" class="img-fluid"></div>
					<div class="text-wrap">
					<div>Mining Rewards</div>
					<div class="colored-value" ><?php echo $token->token_symbol; ?> <?php echo number_format($mining_reward,6);?></div>
					</div>
					</div>
				</li>
				<li class="selection">
					<div class="investors-item--data">
					<div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-01.png" class="img-fluid"></div>
					<div class="text-wrap">
					<div>Per Hours Rewards</div>
					<div class="colored-value"><?php echo $token->token_symbol; ?> 
					<?php
					 $perhour=$mining_reward/24;
					 echo $perhour."/Hour";
					?>
						
					</div>
					</div>
					</div>
				</li>
				<input type="hidden" name="mining_reward" value="<?php echo $mining_reward;?>">
			</ul>
		</div>
		<input type="hidden" name="PackageId" id="PackageId"value="<?php echo $PackageId;?>">
		<div class="deposit-btn text-center">
		<button id="btn1" class="btn btn-primary"><?php echo $contes; ?>   Start Mining</button>
		</div>
		</form>
		</div>
		</div>
		</div>
<?php }?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
//var dayInMilliseconds = 1000 * 60 * 60 * 24;
var dayInMilliseconds = 10;
// $("#btn1").click(function(e) {
//     e.preventDefault();

//     setTimeout(function() {

// 	    $.ajax({
// 	        type: "POST",
// 	        url: '<?php echo base_url();?>user/upgrade/mining_payment',
// 	        data: { 
// 	            PackageId: $("#PackageId").val() ,
// 	            PackageName: $("#packagename").val(),
// 	            memberid: $("#memberid").val()
// 	        },
// 	        success: function(data) {
// 	         console.log(data);
// 	        }
// 	    });
// 	},dayInMilliseconds);
// });


$('#stopbtn').click(function(){
  $(this).attr("disabled","disabled");
});
</script>