<!doctype html>
<html lang="en">
<head>
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>


<div class="wrapper dash-bg">
<body class="">

<?php $this->load->view('user/user_aside');?>

<style type="text/css">
 label
 {
    color:white;
    margin-bottom: 10px;
    font-weight: 700;
 }
 .dataTables_info
 {
    color:white;
    margin-bottom: 10px;
    font-weight: 700;
 }
 .highcharts-button text {
    fill: rgb(51, 51, 51) !important;
}
.highcharts-label-box
{
    color:black !important;
  fill: rgb(51, 51, 51) !important;
}

.swiper-slide {
    &:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: black;
        opacity: .4;
    }
}


.swiper-slide
{
margin: 10px !important;
background-color: rgb(43, 212, 248);
width: 23%;
background: #fff;
background-color: rgb(255, 255, 255);
padding: 18px 10px;
border-radius: 4px;
}
.swiper-slide img {
float: left;
background: #eee;
background-color: rgb(238, 238, 238);
padding: 5px;
border-radius: 50%;
margin-right: 15px;
max-width: 100% !important;
max-height: 60px !important;
}
.swiper-slide h5 {
font-size: 30px;
font-weight: 400;
color: #f33040;
font-size: 16px;
font-weight: bold;
text-transform: uppercase;
text-align: left;
line-height: 30px;
}
.swiper-slide  span {
line-height: 30px;
}
.ad_not p
{
 color: black!important;
}

  table {
  caption-side: bottom;
  border-collapse: collapse;
  width: 100% !important;
  text-align: center;
  white-space: nowrap;
  }

  .dataTables_length label
  {
  display: inline-flex !important;
  max-width: 100%;
  margin-bottom: 5px;
  font-weight: 700;
  }

  </style>

  <style>

  }
  </style>
    <!--  Plugins  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/plugins/c3charts/c3.min.css">

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
<h3 class="fw-normal2 text-white"> Dashboard </h3>
</div>


<div class="dash-btn"
>
<span class="text-white text-grad">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span> <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div>
</div>
</div>
</div>
</div>
<div class="admin-middle">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="title text-center"> <span class="text-grad">Quick Stats</span>
<h2 class="text-white fw-bold mb-3 text-uppercase pla">Account Details</h2>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-10 offset-sm-1">

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

<ul class="list-unstyled quick-list owl-carousel">
<li>
<div class="quick-bg text-center rounded-1 bord-grad">
<div class="quick-ico rounded-circle bg-gradient box"> <img src="<?php echo base_url();?>assets/styl/images/quick-ico1.png" class="img-fluid"> </div>
<div class="quick-con">
<h3 class="text-white fw-normal03 mb-0"> <?php echo currency(); ?> <?php echo number_format($total_upgrade->upgrade,6);?></h3>
<span class="text-white">Total Deposit</span> </div>
</div>
</li>
<li>
<div class="quick-bg text-center rounded-1 bord-grad">
<div class="quick-ico rounded-circle bg-gradient box"> <img src="<?php echo base_url();?>assets/styl/images/quick-ico2.png" class="img-fluid"> </div>
<div class="quick-con">
<h3 class="text-white fw-normal03 mb-0"><?php echo currency(); ?> <?php echo number_format($total_earngings->total_earn,6); ?></h3>
<span class="text-white">Total Income</span> </div>
</div>
</li>

<li>
<div class="quick-bg text-center rounded-1 bord-grad">
<div class="quick-ico rounded-circle bg-gradient box"> <img src="<?php echo base_url();?>assets/styl/images/quick-ico2.png" class="img-fluid"> </div>
<div class="quick-con">
<h3 class="text-white fw-normal03 mb-0"><?php echo currency(); ?> <?php echo number_format($total_token->total_token,6); ?></h3>
<span class="text-white">Total Token</span> </div>
</div>
</li>


<li>
<div class="quick-bg text-center rounded-1 bord-grad">
<div class="quick-ico rounded-circle bg-gradient box"> <img src="<?php echo base_url();?>assets/styl/images/quick-ico3.png" class="img-fluid"> </div>
<div class="quick-con">
<h3 class="text-white fw-normal03 mb-0"> <?php echo currency(); ?>

<?php 

// echo number_format($active_dep->Credit,6);

  $Tot_deposit = $total_upgrade->upgrade;
  $Tot_income  = $total_earngings->total_earn;
  $tot_profit  = $Tot_income-$Tot_deposit;
  echo number_format($tot_profit,6);

?> 
</h3>
<span class="text-white">Total Profit</span> </div>
</div>
</li>

<li>
<div class="quick-bg text-center rounded-1 bord-grad">
<div class="quick-ico rounded-circle bg-gradient box"> <img src="<?php echo base_url();?>assets/styl/images/quick-ico5.png" class="img-fluid"> </div>
<div class="quick-con">
<h3 class="text-white fw-normal03 mb-0"><?php echo currency(); ?><?php echo number_format($user_withdraw->total_with,6);?> </h3>
<span class="text-white">Total Withdraw</span> </div>
</div>
</li>
</ul>

</div>
</div>


<div class="row">
<div class="col-sm-12">
<div class="title text-center"> <span class="text-grad ">Earnings</span>
<h2 class="text-white fw-bold mb-3 text-uppercase pla">Overall Earnings</h2>
</div>
</div>
</div>


<div class="row">
<div class="col-sm-10 offset-sm-1">
<div class="other-bal  d-flex justify-content-around bor-rig" style="overflow-x: auto;">


<div class="panel-body pn">
<div id="container2"></div>
<div id="container3" style="color: white;">NO RECORDS AVAILABLE</div>
</div>

</div>
</div>
</div>



<div class="row">
<div class="col-sm-12">
<div class="title text-center"> <span class="text-grad ">Other Balance</span>
<h2 class="text-white fw-bold mb-3 text-uppercase pla">Overall stats</h2>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-10 offset-sm-1">
<div class="row pt-3">

<div class="col-sm-6">
<div class="other-bal  d-flex justify-content-around bor-rig">
<div class="other-ico box rounded-circle bg-gradient"><img src="<?php echo base_url();?>assets/styl/images/other-ico1.png" class="img-fluid"></div>
<div class="other-con">
<h4 class="text-secondary">Main Balance</h4>
<h3 class="text-secondary fw-normal3"><?php echo currency(); ?> <?php echo number_format($user_balance->Balance,6);?> Tether USDT</h3>
</div>


</div>
</div>

<div class="col-sm-6">
<div class="other-bal  d-flex justify-content-around bor-rig">
<div class="other-ico box rounded-circle bg-gradient"><img src="<?php echo base_url();?>assets/styl/images/other-ico2.png" class="img-fluid"></div>
<div class="other-con">
<h4 class="text-secondary">Rewards Earning</h4>
<h3 class="fw-normal3 text-secondary"><?php echo currency(); ?> <?php echo number_format($reward_earnings->total_earn,6);?> Tether USDT</h3>
</div>


</div>
</div>




</div>
</div>
</div>

<br>
<br>

<div class="row">
<div class="col-sm-10 offset-sm-1" style="padding: 20px;">
<div class="row pt-3">

<div class="grad-bg sale text-center col-lg-11" style="overflow: hidden;min-height: 201px">
<h4 class="text-white" style="margin-top: 10px;">New Targets </h4>

<br>
  <div class="swiper-container">

  <div class="swiper-wrapper">

<?php
$target_achives = $this->db->query("SELECT * FROM arm_target_setting where status='1'")->result();
if($target_achives)
{
foreach($target_achives as $row)
{

if($row->earning_mode==1)
{
 $modes =  "Weekly";
}
if($row->earning_mode==2)
{
 $modes =  "Monthly";
}
if($row->earning_mode==3)
{
 $modes =  "Quarterly";
}
if($row->earning_mode==4)
{
 $modes =  "Yearly";
}
if($row->earning_mode==5)
{
 $modes =  "Daily";
}

?>
<?php
if($row)
{
?>
<li style="display: inline-flex;margin: 10px!important" class="swiper-slide">
<div class="col-lg-12">
<div class="row">
<div class="col-md-4" style="text-align: center;">
<h5> <?php echo $modes ;?> Target </h5>
</div>
<div class="col-md-7" style="text-align: initial;">
<h6>Target Amount :
<?php
echo number_format($row->target_amount,6);
?>  <?php echo currency(); ?>
</h6>
<h6>
Target Bonus
<?php 
echo number_format($row->target_bonus,6);
?>  <?php echo currency(); ?>
</h6>
<div class="col-md-6">
</div>
</div>
</li>
<?php
}
}
}
?>

  </div>

  </div>

</div>
</div>
</div>
</div>

<br>
<br>

<div class="row">
<div class="col-sm-10 offset-sm-1" style="padding: 20px;">
<div class="row pt-3">

<div class="grad-bg sale text-center col-lg-11" style="overflow: hidden;min-height: 201px">
<h4 class="text-white" style="margin-top: 10px;">Recent Top Earners Rewards</h4>

<br>
  <div class="swiper-container">

  <div class="swiper-wrapper">

<?php
$target_achives = $this->db->query("SELECT * FROM arm_history where TypeId='5' and `TransactionId` LIKE '%TOPBON%' ORDER BY `HistoryId` DESC ")->result();

if($target_achives)
{
foreach($target_achives as $row)
{
    $usrenames = $this->db->query("SELECT * FROM arm_members WHERE MemberId='".$row->MemberId."'")->row();

?>
<?php
if($row)
{
?>
<li style="display: inline-flex;margin: 10px!important" class="swiper-slide">
<div class="col-lg-12">
<div class="row">
<div class="col-md-4" style="text-align: center;">
<h5><?php echo number_format($row->Credit,6); ?> <?php echo currency(); ?> Rewards Credit  </h5>
</div>
<div class="col-md-7" style="text-align: initial;">
<h6>User Name :
<?php
echo $usrenames->UserName;
?>  
</h6>
<div class="col-md-6">
</div>
</div>
</li>
<?php
}
}
}
?>

  </div>

  </div>

</div>
</div>
</div>
</div>

<br>
<br>

<div class="row">
<div class="col-sm-10 offset-sm-1" style="padding: 20px;">
<div class="row pt-3">

<div class="grad-bg sale text-center col-lg-11" style="overflow: hidden;min-height: 201px">
<h4 class="text-white" style="margin-top: 10px;">Recent Admin Messages</h4>

<br>
  <div class="swiper-container">

  <div class="swiper-wrapper">

<?php
$target_achives = $this->db->query("SELECT * FROM arm_messages where Status='1' ")->result();

if($target_achives)
{
foreach($target_achives as $row)
{
?>
<?php
if($row)
{
?>
<li style="display: inline-flex;margin: 10px!important" class="swiper-slide">
<div class="col-lg-12">
<div class="row">
<div class="col-md-4" style="text-align: center;">
<h5 style="font-size: 14px !important;"><?php echo date('d M Y', strtotime($row->DateAdded));?> :  <?php echo  urldecode($row->NewsHeader);?></h5>
</div>
<div class="col-md-7" style="text-align: initial;">
<h6 style="color: black;" class="ad_not">
<?php echo  urldecode($row->NewsDescription);?>
</h6>
<div class="col-md-6">
</div>
</div>
</li>
<?php
}
}
}
?>

  </div>

  </div>

</div>
</div>
</div>
</div>
<div class="row" style="margin-top: 20px;">
<div class="col-sm-12">
<div class="title text-center"> <span class="text-grad ">Ranks List</span>
<h2 class="text-white fw-bold mb-3 text-uppercase pla">Overall Ranks</h2>
</div>
</div>
</div>

<div class="container">
<div class="col-lg-12">
<div class="row pt-3">
<div class="col-lg-11">
<div class="trans-table bg-primary rounded-1">
<div class="table-responsive" style="overflow-x: scroll;">

<table id="example1" >
<thead>
	<tr>
	<th>S/no</th>
	<th>Ranks Name</th>
	<th>Minimum Investment</th>
	<th>Minimum Level</th>
	<th>Eligibel For Earn</th>
	<th>Bonus Amount</th>
	<th>Status</th>
    <th>Total earnings</th>
	</tr>
</thead>
<tbody>
<?php $i=1; foreach($all_rank as  $rank) { 

$user_earn = $this->db->query("SELECT sum(Credit) as userEran  FROM `arm_history` where TypeId='27' and MemberId ='".$this->session->MemberID."' and Rankname ='".$rank->rank_id."'")->row();

$user_earns = $user_earn->userEran;
$elig_earns = $rank->elig_earn;

if($user_earns <= $elig_earns)
{
$percenteage = ($user_earns % $elig_earns) * 100;
}
else
{
$percenteage = 100;  
}

    ?>

<?php $current_level = $this->db->query("SELECT * FROM `arm_ranksetting` where 
rank_id ='".$rank->current_lev."'")->row(); ?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $rank->Rank; ?></td>
<td><?php echo currency(); ?> <?php echo number_format($rank->min_pack_inves,'6'); ?></td>
<td><?php if($current_level->Rank==""){echo "----";}else{ echo $current_level->Rank;} ?></td>
<td><?php echo currency(); ?> <?php echo number_format($rank->elig_earn,'2'); ?></td>
<td><?php echo currency(); ?> <?php echo number_format($rank->bonus_amt,'2'); ?></td>

<?php  if ($user->rank>=$rank->rank_id) { ?>

<td style="color: green"> <i class="fa fa-check" aria-hidden="true"></i> Achived</td>

<?php } else { ?>

<td>Non Achived</td>

<?php } ?>

<td><?php echo currency(); ?> <?php echo number_format($user_earn->userEran,'2'); ?> (<?php echo $percenteage; ?>) %</td>

</tr>

<?php $i++; } ?>

</tbody>

</table>
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

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/hollowcandlestick.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script src="<?php echo base_url();?>assets/user/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/user/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/user/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url();?>assets/user/js/plugins/morris/morris.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.2.4/swiper-bundle.min.js" integrity="sha512-Hvn3pvXhhG39kmZ8ue3K8hw8obT4rfLXHE5n+IWNCMkR6oV3cfkQNUQqVvX3fNJO/JtFeo/MfLmqp5bqAT+8qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.2.4/swiper-bundle.css" integrity="sha512-303pOWiYlJMbneUN488MYlBISx7PqX8Lo/lllysH56eKO8nWIMEMGRHvkZzfXYrHj4j4j5NtBuWmgPnkLlzFCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.js"></script>
    <script src="script.js"></script>


<!-- <script src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.8/js/dataTables.bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.8/css/dataTables.bootstrap.min.css" rel="stylesheet" />
 -->
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" /> -->
<link href="//cdn.datatables.net/1.10.8/css/dataTables.dataTables.min.css" rel="stylesheet"/> 
<link href="//cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css" rel="stylesheet"/>
<script src="//cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>


    <script>
    $(function () {



// "paging": true,
// "lengthChange": false,
// "searching": false,
// "ordering": true,
// "info": true,
// "autoWidth": false

$('#example1').DataTable({
autoWidth:true,
searching:true,
lengthChange:true,
ordering:true,
paging:true,
info:true,
responsive: true
});

    });

  $(window).resize(function () {
  $("#example1").resize();
  });
    </script>




<script type="text/javascript">
    
    $.getJSON('<?php echo base_url();?>all_earnings', function (data) {

if(data!="")
{
    $('#container3').css('display','none');
    Highcharts.stockChart('container2', {
        rangeSelector: {
            selected: 2
        },
        navigator: {
            series: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        series: [{
            type: 'column',
            name: 'Member Earnings  &#8366',
            data: data
        }]
    });
   
}
else
{
  $('#container3').css('display','block');
}
    });


    var swiper = new Swiper(".swiper-container", {
        effect: "coverflow",
         loop: true,
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
          rotate: 50,
          stretch: 0,
          depth: 100,
          modifier: 1,
          slideShadows: true,
        },
        pagination: {
          el: ".swiper-pagination",
        },
      });

</script>

</body>
</html>
