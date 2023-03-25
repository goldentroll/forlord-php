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

	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/css/feather.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/morris/morris.css">

	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>


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
	<h3 class="fw-normal2 text-white"> Myupline</h3>
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


		<div class="row">
		<div class="col-lg-11" style="overflow: auto;">
		<div class="box form-back position-relative z-in1 bord-grad" style="overflow:auto;">
		<div class="box-body">
		<div class="table-responsive">
		<table id="example1" class="table table-striped">
		<thead>
		<tr>

		<th colspan="8"  align="center"><?php echo  ucwords($this->lang->line('label_upline'));?></th>
		</tr>

		<tr>
<!-- 
		<th><?php echo  ucwords($this->lang->line('label_susername'));?></th>
		<th><?php echo  ucwords($this->lang->line('label_sfullname'));?></th>
		<th><?php echo  ucwords($this->lang->line('label_sreferralname'));?></th> -->

		<th><?php echo  ucwords($this->lang->line('label_username'));?></th>
		<th><?php echo  ucwords($this->lang->line('label_fullname'));?></th>
		<th><?php echo  ucwords($this->lang->line('label_referralname'));?></th>
		<th>Activity</th>
		<th>Chat</th>

		</tr>
		</thead>
		<tbody>
		<?php	
		$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
		if($mlsetting->Id==1)
		{
		$table = "arm_forcedmatrix";
		}
		else if($mlsetting->Id==2)
		{
		$table = "arm_unilevelmatrix";
		}
		else if($mlsetting->Id==3)
		{
		$table = "arm_monolinematrix";
		}
		else if($mlsetting->Id==4)
		{
		$table = "arm_binarymatrix";
		}
		else if($mlsetting->Id==5)
		{
		$table = "arm_boardmatrix";
		}
		else if($mlsetting->Id==6)
		{
		$table = "arm_xupmatrix";
		}
		else if($mlsetting->Id==7)
		{
		$table = "arm_oddevenmatrix";
		}
		else if($mlsetting->Id==8)
		{
		$table = "arm_boardmatrix1";
		}	
		else if($mlsetting->Id==9)
		{
		$table = "arm_binaryhyip";
		}	
		$ucondition = "MemberId='".$this->session->MemberID."'";
		$userdetails = $this->common_model->GetRow($ucondition,"arm_members");
		$sponsor = $this->common_model->GetRow($ucondition,$table);
		$scondition = "MemberId='".$sponsor->DirectId."'";

		$sponsordetails = $this->common_model->GetRow($scondition,"arm_members");

		$ucondition = "MemberId='".$sponsor->SpilloverId."'";

		$uponsordetails = $this->common_model->GetRow($ucondition,"arm_members");

		?>
		<tr>
<!-- 
		<td><?php echo  $sponsordetails->UserName?></td>
		<td><?php echo  ucwords($sponsordetails->FirstName."   ".$sponsordetails->LastName)?></td>
		<td><?php echo  $sponsordetails->ReferralName?></td>
 -->
		<td><?php echo  $uponsordetails->UserName?></td>
		<td><?php echo  ucwords($uponsordetails->FirstName."   ".$sponsordetails->LastName)?></td>
		<td><?php echo  $uponsordetails->ReferralName?></td>


<?php
if($sponsordetails->facebookurl==0 ||$sponsordetails->facebookurl=="")
{
?>
  <td><?php 	echo relativeTime($sponsordetails->new_entry);?></td>
<?
}
else
{
	?>
	<td><span style="background-color: green;
    color: white;
    padding: 5px;
    font-size: 11px;">Online</span></td>
    <?
}
?>
<td>
<?php
if($sponsordetails)
{
?>
<a class="btn btn-primary" href="<?php echo base_url();?>Chat/<?php echo $sponsordetails->MemberId; ?>">Send Message</td>
<?
}
?>

		</tr>

		</tbody>

		</table>
		</div>
		</div>
		</div>


		</div>
		</div>
		</section>
		</div>
	</div>
	<?php $this->load->view('user/login_footer');?>
</div>
</div>
</div>
</body>
</html>
<?php

	

	function relativeTime($times, $short = false){
	$SECOND = 1;
	$MINUTE = 60 * $SECOND;
	$HOUR = 60 * $MINUTE;
	$DAY = 24 * $HOUR;
	$MONTH = 30 * $DAY;
	$time = strtotime($times); 
	$before = time() - $time;


	if ($before < 0)
	{
	return "not yet";
	}

	if ($times == "")
	{
	return "not yet";
	}

	if ($short){
	if ($before < 1 * $MINUTE)
	{
	return ($before <5) ? "just now" : $before . " ago";
	}

	if ($before < 2 * $MINUTE)
	{
	return "1m ago";
	}

	if ($before < 45 * $MINUTE)
	{
	return floor($before / 60) . "m ago";
	}

	if ($before < 90 * $MINUTE)
	{
	return "1h ago";
	}

	if ($before < 24 * $HOUR)
	{

	return floor($before / 60 / 60). "h ago";
	}

	if ($before < 48 * $HOUR)
	{
	return "1d ago";
	}

	if ($before < 30 * $DAY)
	{
	return floor($before / 60 / 60 / 24) . "d ago";
	}


	if ($before < 12 * $MONTH)
	{
	$months = floor($before / 60 / 60 / 24 / 30);
	return $months <= 1 ? "1mo ago" : $months . "mo ago";
	}
	else
	{
	$years = floor  ($before / 60 / 60 / 24 / 30 / 12);
	return $years <= 1 ? "1y ago" : $years."y ago";
	}
	}

	if ($before < 1 * $MINUTE)
	{
	return ($before <= 1) ? "just now" : $before . " seconds ago";
	}

	if ($before < 2 * $MINUTE)
	{
	return "a minute ago";
	}

	if ($before < 45 * $MINUTE)
	{
	return floor($before / 60) . " minutes ago";
	}

	if ($before < 90 * $MINUTE)
	{
	return "an hour ago";
	}

	if ($before < 24 * $HOUR)
	{

	return (floor($before / 60 / 60) == 1 ? 'about an hour' : floor($before / 60 / 60).' hours'). " ago";
	}

	if ($before < 48 * $HOUR)
	{
	return "yesterday";
	}

	if ($before < 30 * $DAY)
	{
	return floor($before / 60 / 60 / 24) . " days ago";
	}

	if ($before < 12 * $MONTH)
	{

	$months = floor($before / 60 / 60 / 24 / 30);
	return $months <= 1 ? "one month ago" : $months . " months ago";
	}
	else
	{
	$years = floor  ($before / 60 / 60 / 24 / 30 / 12);
	return $years <= 1 ? "one year ago" : $years." years ago";
	}

	return "$time";
	}

?>


		<script src="<?php echo base_url();?>assets/user/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<script>
		$.widget.bridge('uibutton', $.ui.button);
		</script>
<!-- 		<script src="<?php echo base_url();?>assets/user/bootstrap/js/bootstrap.js"></script> -->
		<script src="<?php echo base_url();?>assets/user/js/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/user/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="<?php echo base_url();?>assets/user/js/plugins/morris/morris.min.js"></script>
		<script src="<?php echo base_url();?>assets/user/dist/js/file-tree.min.js"></script>


		<script src="<?php echo base_url();?>assets/user/js/js/app.min.js"></script>
		<!--    <script src="js/js/demo.js"></script>-->
		<script src="<?php echo base_url();?>assets/user/js/justgage.js"></script>


		<script type="text/javascript">
		$(document).ready(function(){
		var data = [{
		id: 'dir-1',
		name: '<?php echo '<strong style=color:#0094FF>'.$GetHeadUser->UserName.'</strong>';?>',
		type: 'dir',
		children: 
		[  
		<?php echo $tree;?>
		]
		}];

		$('#fixed-tree').fileTree({
		data: data
		});




		});
		</script>
		<script type="text/javascript" language="javascript" src="js/demo/dataTables.responsive.min.js"></script>

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
		</body>
		</html>
