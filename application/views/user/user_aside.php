	<?php error_reporting(0);
	ini_set('max_execution_time', 0);
	?>

	<?php 

if($this->session->userdata('logged_in') && $this->session->userdata('user_login')) {

}
else
{
	redirect('login');
}

	$sitelogo = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'",'arm_setting');
	$width = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='width'",'arm_setting');
	$height = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='height'",'arm_setting'); 
	if($sitelogo) {
	$logo =$sitelogo->ContentValue;
	}
	else
	{
	$logo ='assets/user/img/logo.png';
	}
	?>

	<?php $mmdet = $this->db->query("SELECT * FROM arm_members WHERE MemberId='".$this->session->MemberID."'");

	$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

	if($mlsetting->Id==4) {
	$table = "arm_pv";
	}
	elseif($mlsetting->Id==9) {
	$table = "arm_hyip";
	} 

	elseif($mlsetting->Id==5) {
	$table = "arm_boardplan";
	} else {
	$table='arm_package';
	}


	$package_check=$mmdet->row()->PackageId;

	$condition="PackageId='".$package_check."'";
	$packagedetails = $this->common_model->GetRow($condition,$table);
	if($packagedetails) {
	$package_name = $packagedetails->PackageName;
	} else {
	$package_name = "";
	}


	$member_mode=$mmdet->row()->PackageIdU;

	?>

	<nav id="sidebar">
	<div class="logo-admin"> 
	<a href="<?php echo base_url();?>" class=""><img  style="width:<?php echo $width->ContentValue ; ?>px; height:<?php echo $height->ContentValue;?>px;" src="<?php echo base_url().$logo;?>" class="img-fluid"/></a>
	</div>


<style type="text/css">
	
.containers {
	position: relative;
	left: 112px;
	top: 29%;
	-webkit-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	width: 49px;
	height: 44px;
	border-radius: 30px !important;;
	background-color: #ffffff;
	display: flex;
	transform-origin: left;
	box-shadow: 0px 5px 15px 2px #ffa000;
	margin-top: 55px;
	margin-bottom: -21px;
}
.containers img {
height: 38px;
    width: 39px;
	position: absolute;
	left: 50%;
	top: 50%;
	transform: translate(-50%, -50%);
	fill: #1e88e5;
}
.containers .dots {
	display: flex;
	position: absolute;
	left: 50%;
	top: 52%;
	transform: translate(-50%, -50%);
}
.containers .dots .dot {
  width: 10px;
  height: 10px;
  background-color: white;
  border-radius: 1000px;
  margin-right: 6px;
}
.containers .dots .dot:last-child {
  margin-right: 0;
}
.containers .message {
     width: 56px;
    height: 30px;
    background-color: #f44336;
    overflow: hidden;
    position: absolute;
    right: -21px;
    top: -18px;
    border-radius: 50px;
    display: flex;
    padding: 5px 0;
    flex-wrap: nowrap;
    box-shadow: 0px 5px 15px 2px #d32f2f62;
}
.containers .message marquee {
  color: white;
}

.credits {
  position: absolute;
  right: 0;
  bottom: 0;
  padding: 20px;
  color: #423d36;
  font-weight: 500;
}
.credits p a {
  font-weight: 600;
  text-decoration: none;
  color: #1f1d1a;
}
</style>

	<style type="text/css">
	.dot {
	height: 15px;
	width: 15px;
	background-color: red;
	border-radius: 50%;
	display: inline-block;
	}

	.sec{
	position: relative;
	right: -13px;
	top:-22px;
	}

	.counter.counter-lg {
	top: -24px !important;
	}



  @media only screen and (max-width: 991px) {
.modal-open
{
    padding-right:0px!important;
}
#exampleModals
{
    padding-right:0px!important;
}
}
 @media only screen and (max-width:767px) {
.modal-open
{
    padding-right:0px!important;
}
#exampleModals
{
    padding-right:0px!important;
}
}
 @media only screen and (max-width:575px) {
.modal-open
{
    padding-right:0px!important;
}
#exampleModals
{
    padding-right:0px!important;
}
}
.dash-btn .text-white
{
  display: none !important;
}
	</style>

	<div class="menu-block">
	<div class="user-info"> 

	<?php 
	if(isset($mmdet->row()->ProfileImage))
	$image = base_url().$mmdet->row()->ProfileImage;
	else 
	$image = base_url().'assets/styl/images/banner-cooler.png';
	?>
	<img src="<?php echo $image;?>" width="150" height="150" class="image-fluid">

	<br>
	<span>WELCOME BACK</span>
	<h5 class="text-grad">
	<?php echo $this->session->userdata('full_name')."<br>".$mmdet->row()->UserName."<br/>";?>

	<?php
	 $current_level = $this->db->query("SELECT * FROM `arm_ranksetting` where 
	rank_id ='".$mmdet->row()->rank."'")->row(); 

if($current_level!="")
{
	?>
    
     <span> Rank : <?php echo $current_level->Rank;?></span>

	<?php
}

	?>

	</h5>

	<a class="containers" data-bs-toggle="modal" data-bs-target="#exampleModals">

	<img src="<?php echo base_url();?>assets/img/notification.jpeg" width="150" height="150" style="border-radius:50%;" class="image-fluid">
	<div class="message">
	<marquee>
	<div class="messages">
	Empty
	</div>
	</marquee>
	</div>
	</a>

<?php

    $check_view = $this->db->query("select * from chat where recever_id ='".$this->session->MemberID."' and status='1' ")->row();

if($check_view)
{	
?>

<?php
}
?>

	</div>

	<ul class="menu_admin">

	<li> <a href="<?php echo base_url();?>user/dashboard" class="pla"><i class="fa-solid fa-gauge"></i> Dashboard </a> </li>

	<li> <a href="<?php echo base_url();?>user/upgrade" class="pla"><i class="fa-solid fa-coins"></i> Package Upgrade </a> 
	</li>

	<li class=""> 
	<a href="<?php echo base_url();?>user/mywithdraw" class="pla"><i class="fa-solid fa-money-check-dollar"></i> Withdraw </a>
	</li>

	<li class="sidebar-item  has-sub position-relative"> <a href="#" class="sidebar-link"><i class="fa-solid fa-clock-rotate-left"></i>History </a> 
	<ul class="submenu ps-0 list-unstyled">
	<li> <a href="<?php echo base_url();?>user/transaction">Transaction History</a> </li>
	</ul>
	</li>



	<li class="sidebar-item  has-sub position-relative"> <a href="#" class="sidebar-link"><i class="fa-solid fa-clock-rotate-left"></i> Genalogy </a> 
	<ul class="submenu ps-0 list-unstyled">
	<li>
	<a href="<?php echo base_url();?>user/genealogy" class="pla">View Genalogy</a>
	</li>
	<li>
	<a href="<?php echo base_url();?>user/mydownline" class="pla"> My Downlines</a>
	</li>
	<li>
	<a href="<?php echo base_url();?>user/myupline" class="pla"> My Upline</a>
	</li>
	</ul>
	</li>

<?php

$check_video_rewards = $this->db->query('SELECT * FROM reward_controls_main')->row();

$R_total_amount =$check_video_rewards->total_earnings;
$U_total_amount = $this->db->query("SELECT MemberId, sum(Credit) as earns FROM arm_history WHERE TypeId IN(20) AND MemberId='".$this->session->MemberID."'", FALSE)->row();

$U_pcakage = $this->db->query("SELECT * FROM `arm_history` WHERE TypeId ='19' and MemberId = '".$this->session->MemberID."'")->result();

$array_data = explode(",", $check_video_rewards->display_pacakge);


    $flag ='1';

foreach ($U_pcakage as $key) {

if(in_array($key->PackageId,$array_data))
{
	$flag = '0';
}

}

if(in_array('0',$array_data))
{
	$flag = '0';
}



if($U_total_amount->earns <= $R_total_amount)
{

if($flag=='0')
{

?>

	<li>
	<a href="<?php echo base_url();?>all_reward" class="pla"><i class="fa-solid fa-comment-dollar"></i> Video Rewards </a>
	</li>

<?php
}
}

$non_cash_check = $this->db->query("SELECT * FROM `arm_history` WHERE MemberId ='".$this->session->MemberID."' and TypeId='22' and Status='2' ORDER BY HistoryId DESC")->row();

// if($non_cash_check)
// {
	?>
	<li>
	<a href="<?php echo base_url();?>user/noncash" class="pla"><i class="fa-solid fa-money-check-dollar text-white"></i> Non Cashbonus </a>
	</li>
	<?
//}

?>

	<!-- 	<li>
	<a href="<?php echo base_url();?>user/dashboard" class="pla"><i class="fa-solid fa-reply-all"></i> Referral History </a>
	</li>
	-->
	<li>
	<a href="<?php echo base_url();?>user/tellus" class="pla"> <i class="fa-solid fa-share-nodes"></i>Tell a friend </a>
	</li>

<?php 
if($member_mode==2)
{
?>
<li> <a href="<?php echo base_url();?>user/mypage" class="pla"> <i class="fa-solid fa-retweet"></i>Referral </a> 
</li>
<?
}
?>



	<li>
	<a href="<?php echo base_url();?>user/ticket" class="pla"><i class="fa-solid fa-clipboard-list"></i> Tickets </a>
	</li>


	<li class="sidebar-item  has-sub position-relative"> <a href="#" class="sidebar-link"><i class="fa-solid fa-clock-rotate-left"></i> Profile </a> 
	<ul class="submenu ps-0 list-unstyled">
	<li>
	<a href="<?php echo base_url();?>user/profile/edit" class="pla"><i class="fa-solid fa-pen-to-square"></i> Edit Profile </a>
	</li>
	<li>
	<a href="<?php echo base_url();?>user/profile/change" class="pla"><i class="fa-solid fa-pen-to-square"></i> Change Password </a>
	</li>
	</ul>
	</li>


	<li>
	<a href="<?php echo base_url();?>login/logout" class="pla yellow"><i class="fa-solid fa-right-from-bracket"></i> Logout </a>
	</li>
	</ul>
	</div>
	</nav>

	<div class="modal fade" id="exampleModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered wallet-pop">
	<div class="modal-content grad-bg">
	<div class="modal-body">
	<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>

     <input type="hidden" id="new_msg">

	<h2 class="title fw-bold text-center text-white pb-3"><?php echo strtoupper('Notifications') ?></h2>

	<div class="wallet-block1 bg-white p-3">
	<div class="row">
<div class="col-lg-12">
<span id="message_list"> No Notifications Found</span>
</div>
	</div>
	</div>	


</div>
</div>
</div>
</div>


	<style type="text/css">
	.notify {
	position: fixed;
	top: 10px;
	left: 10px;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	width: 350px;
	font-size: 14px;
	text-align: center;
	}

	/* Positions
	========================================================================== */
	.notify-top-right,
	.notify-bottom-right {
	left: auto;
	right: 10px;
	}
	.notify-top-center,
	.notify-bottom-center {
	left: 50%;
	margin-left: -175px;
	}
	.notify-bottom-left,
	.notify-bottom-right,
	.notify-bottom-center {
	top: auto;
	bottom: 10px;
	}

	.notify button {
	-webkit-appearance: none;
	padding: 0;
	cursor: pointer;
	background: 0 0;
	border: 0;
	display: none;
	}

	/* Responsiveness
	========================================================================== */
	/* Phones portrait and smaller */
	@media (max-width: 479px) {
	/*
	* Fit in small screen
	*/
	.notify {
	left: 10px;
	right: 10px;
	width: auto;
	margin: 0;
	}
	}
	/* Sub-object: `notify-message`
	========================================================================== */
	.notify-message {
	position: relative;
	cursor: pointer;
	width: 100%;
	padding: 10px;
	line-height: 1.2;
	}

	.notify .alert-default {
	background: #fff;
	border: 1px solid #e5e5e5;
	}
	</style>

  <script type="text/javascript">

	setInterval(function() 
	{ 

	$.ajax({
	type: 'get',
	url:'<?php echo base_url();?>user/dashboard/get_chat/',
	success : function(mege)
	{
	var meg =  mege.trim();
	if(meg!='NULL')
	{
	$('#message_list').html(meg);
	$('.message').css('background','green');
	$('.messages').text('New Messages');
	}
	}
	});

	}, 
	8000);

</script>

<!--  /Scripts  -->