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

<!-- 	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/css/feather.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/morris/morris.css"> -->

	<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
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
  @media only screen and (max-width: 991px) {
 .form-back 
 {
    width: 100% !important;
 }
}
 @media only screen and (max-width:767px) {
 .form-back
 {
    width: 100% !important;
 }
}
 @media only screen and (max-width:575px) {
 .form-back 
 {
    width: 100% !important;
 }
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

  table.dataTable th:nth-child(1) {
  width: 100px;
  max-width: 20px;
  word-break: break-all;
  white-space: pre-line;
  }

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
	<h3 class="fw-normal2 text-white"> Mydownlines</h3>
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
		<div class="col-lg-11">
		<div class="box form-back position-relative z-in1 bord-grad">
		<div class="box-header with-border">
		<h3 class="text-white"><?php echo  "My Group Downlines";?></h3>

		</div>
		<div class="box-body">
		<div class="table-responsive export_content">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<?php
		$matrixid = $this->common_model->GetRow("MatrixStatus='1'", 'arm_matrixsetting');


		?>
		<tr>
		<th><?php echo  ucwords($this->lang->line('label_sno'));?></th>
		<th><?php echo  ucwords($this->lang->line('label_username'));?></th>
		<th><?php echo  ucwords('user email id');?></th>
		<th><?php echo  ucwords($this->lang->line('label_date'));?></th>
		<th><?php echo  ucwords('member mode');?></th>
		<th>User Rank</th>
		<th><?php echo  ucwords('profit');?></th>
		<th><?php echo  ucwords($this->lang->line('label_sponsorname'));?></th>
		<!-- <th><?php echo  ucwords($this->lang->line('label_level'));?></th> -->
		<th><?php echo  ucwords($this->lang->line('label_email'));?></th>
		<th>Activity</th>
		<th>Chat</th>
		</tr>
		</thead>
		<tbody>
		<?php 	
		if($matrixid->Id==5)
		{
		if($mydowns) {
		$j=1;
		foreach($mydowns as $key => $value)
		{
		$val = trim($value,',');
		$explode = explode(',',$val);
		$count = count($explode);

		for($i=0;$i<$count;$i++)
		{

		$ucondition = "BoardMemberId ='".$explode[$i]."'";
		$userdetails = $this->common_model->GetRow($ucondition,"arm_boardmatrix");

		$scondition = "MemberId='".$userdetails->MemberId."'";

		$sponsordetail = $this->common_model->GetRowCount($scondition,"arm_boardmatrix");


		for($k=1; $k<=$sponsordetail; $k++) { 

		$checkpackname=$this->common_model->GetRow('PackageId='.$k.'',"arm_boardplan");
		$name=$checkpackname->PackageName;

		$sponsordetails = $this->common_model->GetRow($scondition,"arm_members");

		$directid=$sponsordetails->DirectId;

		$condition = "MemberId='".$sponsordetails->DirectId."'";

		$sponsor = $this->common_model->GetRow($condition,"arm_members");

		?>

		<tr>

		<td><?php echo  $j;?></td>

		<td><?php echo  $sponsordetails->UserName?></td>
	

		<td><?php echo  $sponsor->UserName?></td>


		<td><?php echo  "LEVEL".$key

		?></td>


		<td><?php echo $name;?></td>
		<td><?php echo  $sponsordetails->Email?></td>
		</tr>	




		<?php 
		}

		$j++;	
		}


		}
		} else {
		?>
		<tr><td colspan="6" class="text-center">No Downlines</td></tr>
		<?php
		}

		}
		else{

		if($mydowns) {
		$j=1;
		foreach($mydowns as $key => $value)
		{
		$val = trim($value,',');
		$explode = explode(',',$val);
		$count = count($explode);



		for($i=0;$i<$count;$i++)
		{
		$matrixid = $this->common_model->GetRow("MatrixStatus='1'", 'arm_matrixsetting');



		if ($matrixid->Id==3) {

		$ucondition = "MonoLineId='".$explode[$i]."'";
		$MonoLineId = $this->common_model->GetRow($ucondition,"arm_monolinematrix");

		$ucondition = "MemberId='".$MonoLineId->MemberId."'";
		$userdetails = $this->common_model->GetRow($ucondition,"arm_members");


		}else{

		$ucondition = "MemberId='".$explode[$i]."'";

		$userdetails = $this->common_model->GetRow($ucondition,"arm_members");



		}


		// echo $this->db->last_query();

		// print_r($ucondition);
		// $sponsor = $this->common_model->GetRow($ucondition,"arm_forcedmatrix");
		$scondition = "MemberId='".$userdetails->DirectId."'";

		$sponsordetails = $this->common_model->GetRow($scondition,"arm_members");

		if($userdetails->PackageIdU==1)
		{
		$member_mode = "Free";
		}
		else
		{
		$member_mode = "Premium";
		}

		?>

		<tr>

		<td><?php echo  $j;?></td>


	<td><?php echo  $userdetails->UserName?></td>
	<td><?php echo  $userdetails->Email?></td>
	<td><?php echo  date($userdetails->DateAdded); ?></td>
	<td><?php echo  $member_mode; ?></td>
    <td>
	<?php 

	$current_level = $this->db->query("SELECT * FROM `arm_ranksetting` where 
	rank_id ='".$userdetails->rank."'")->row(); 

if($userdetails->rank)
	{ 
	echo $current_level->Rank;
	}
	else
	{
	echo "--";
	} ?>
	
</td>
<?php
$profits = $this->db->query("SELECT sum(Credit) as total_earn  FROM `arm_history` where MemberId ='".$userdetails->MemberId."' and TypeId IN('20','4','21')")->row();

if($profits->total_earn>0)
{
	$profit = number_format($profits->total_earn,2);
}
else
{
	$profit = '0.00';
}
?>

	<td><?php echo  $profit;?> <?php echo currency(); ?> </td>
	<td><?php echo  $sponsordetails->UserName?></td>
	<td><?php echo  $sponsordetails->Email?></td>

<?php

if($userdetails->facebookurl==0 ||$userdetails->facebookurl=="")
{
?>
  <td><?php 	echo relativeTime($userdetails->new_entry);?></td>
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
<td><a class="btn btn-primary" href="<?php echo base_url();?>Chat/<?php echo $userdetails->MemberId; ?>">Send Message</td>
		</tr>	
		<?php $j++;	}
		}
		} else {
		?>
		<tr><td colspan="11" class="text-center">No Downlines</td></tr>
		<?php
		}  

		}  
		?>	

		</tbody>
		</table>
		</div>
		</div>
		</div>
		<?php
		if($mydowns)
		{?>
		<div class="box" style="display: none;">
		<div class="box-header with-border">
		<h3 class="box-title"><?php echo  "My Group Downlines";?></h3>
		<div class="box-tools pull-right">
		<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
		</div>
		<div class="box-body">
	<!-- 	<link rel="stylesheet" href="<?php echo base_url();?>assets/user/dist/css/bootstrap.min.css"> -->
		<link href="<?php echo base_url();?>assets/user/dist/css/file-tree.min.css" rel="stylesheet">
		<div id="fixed-tree" class="file-tree">

		</div>

		<?php
		$mlsetting=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

		if($mlsetting->Id==5)
		{
		$j=1;
		$Parent='';
		if($mydowns)
		{
		foreach($mydowns as $key => $value)
		{
		$val = trim($value,',');
		$explode = explode(',',$val);
		$count = count($explode);

		for($i=0;$i<$count;$i++) {

		$childs = $controller->child($explode[$i]);

		$ucondition = "BoardMemberId='".$explode[$i]."'";



		$userdetails = $this->common_model->GetRow($ucondition,"arm_boardmatrix");
		$scondition = "MemberId='".$userdetails->MemberId."'";

		$sponsordetails = $this->common_model->GetRow($scondition,"arm_members");


		$name = '<span style=color:#ED8A03;font-style:italic;>'.$sponsordetails->UserName.'</span> - <span style=color:#0094FF;font-style:italic;>'.date($sponsordetails->DateAdded).'</span>';
		$Parent.= "{id: 'dir-1',name: '<strong>".$name."</strong>',type: 'dir',children: [".$childs."] }".',';


		}

		$tree = trim($Parent,',');
		$umcondition = "MemberId='".$this->session->MemberID."'";
		$GetHeadUserdet = $this->common_model->GetRow($umcondition,"arm_members");
		$GetHeadUser = $GetHeadUserdet->UserName;
		}  
		}

		}
		else
		{
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
		else if($mlsetting->Id==9)
		{
		$table = "arm_binaryhyip";								

		}

		$j=1;
		$Parent='';
		foreach($mydowns as $key => $value)
		{
		$val = trim($value,',');
		$explode = explode(',',$val);
		$count = count($explode);

		for($i=0;$i<$count;$i++) {

		$childs = $controller->child($explode[$i]);

		if ($matrixid->Id==3) {

		$ucondition = "MonoLineId='".$explode[$i]."'";
		$MonoLineId = $this->common_model->GetRow($ucondition,"arm_monolinematrix");

		$ucondition = "MemberId='".$MonoLineId->MemberId."'";
		$userdetails = $this->common_model->GetRow($ucondition,"arm_members");

		}else{
		$ucondition = "MemberId='".$explode[$i]."'";
		$userdetails = $this->common_model->GetRow($ucondition,$table);
		}


		//print_r($userdetails);

		$scondition = "MemberId='".$userdetails->MemberId."'";

		$sponsordetails = $this->common_model->GetRow($scondition,"arm_members");
		// echo $this->db->last_query();



		$name = '<span style=color:#ED8A03;font-style:italic;>'.$sponsordetails->UserName.'</span> - <span style=color:#0094FF;font-style:italic;>'.date($sponsordetails->DateAdded).'</span>';
		$Parent.= "{id: 'dir-1',name: '<strong>".$name."</strong>',type: 'dir',children: [".$childs."] }".',';


		}

		$tree = trim($Parent,',');
		$umcondition = "MemberId='".$this->session->MemberID."'";
		$GetHeadUserdet = $this->common_model->GetRow($umcondition,"arm_members");
		$GetHeadUser = $GetHeadUserdet->UserName;
		}  
		}

		?>

		</div>
		</div>
		<?}
		?>

		</div>
		</div>
		</div>
	</div>
</div>
<?php $this->load->view('user/login_footer');?>
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
		<script src="<?php echo base_url();?>assets/user/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo base_url();?>assets/user/js/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/user/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="<?php echo base_url();?>assets/user/js/plugins/morris/morris.min.js"></script>
		<script src="<?php echo base_url();?>assets/user/dist/js/file-tree.min.js"></script>


		<script src="<?php echo base_url();?>assets/user/js/js/app.min.js"></script>
		<!--    <script src="js/js/demo.js"></script>-->
		<script src="<?php echo base_url();?>assets/user/js/justgage.js"></script>




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
</script>


		<script type="text/javascript">
		$(document).ready(function(){

		var data = [{
		id: 'dir-1',
		name: '<?php echo '<strong style=color:#0094FF>'.$GetHeadUser;'</strong>'?>',
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

		<script type="text/javascript">
		$(document).ready(function(){
		$('#example1').DataTable({

		order: [[ 4, 'asc' ]]
		});

		});

		$(function() {

		$("#btnExport").click(function(){

		// download('member.xls', $('.export_content').html());
		download('<?php echo  "my group downlines"."-".date("dMY");?>.xls', $( ".export_content .row:eq( 1 )" ).html());
		});

		});
		function download(filename, text) {

		var pom = document.createElement('a');
		pom.setAttribute('href', 'data:application/vnd-ms-excel;charset=utf-8,' + encodeURIComponent(text));
		pom.setAttribute('download', filename);

		if (document.createEvent) {
		var event = document.createEvent('MouseEvents');
		event.initEvent('click', true, true);
		pom.dispatchEvent(event);
		}
		else {
		pom.click();
		}
		}

		</script>

		</body>
		</html>
