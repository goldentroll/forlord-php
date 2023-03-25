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

.form-ico{
	position: absolute !important;

top: 34px !important;

margin: auto !important;
width: 37px !important;
height: 37px !important;
padding: 9px 12px !important;
left: 8px !important;
text-align: center !important;
bottom:inherit !important;

}
</style>

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
 .trans-table 
 {
    width: 100% !important;
 }
}
 @media only screen and (max-width:767px) {
 .trans-table 
 {
    width: 100% !important;
 }
}
 @media only screen and (max-width:575px) {
 .trans-table 
 {
    width: 100% !important;
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
    <h3 class="fw-normal2 text-white">Non Cash Request </h3>
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
</div>

	<div class="row">
	<div class="col-sm-12">
	<div class="title text-center"> 
	<h2 class="text-white fw-bold mb-3 text-uppercase"><?php echo  ucwords($this->lang->line('noncash_request'));?> </h2>
	</div>
	</div>
	</div>

  <div class="row">
    <div class="col-lg-11">
    <div class="trans-table bg-primary rounded-1">
    <div class="table-responsive">

<table id="example1">
        <thead>
        <tr>
        <th><?php echo  ucwords($this->lang->line('label_sno'));?></th>
        <th><?php echo  ucwords($this->lang->line('label_type'));?></th>
        <th><?php echo  ucwords($this->lang->line('label_id'));?></th>
        <th><?php echo  ucwords($this->lang->line('label_date'));?></th>
        <th><?php echo  ucwords($this->lang->line('label_description'));?></th>
        <th>Non Cash Price </th>
        <th>Price Value</th>
        </tr>
        </thead>
        <tbody>
        <?  if($this->data['transaction']){
        $i=1;
        for($j=0; $j< count($this->data['transaction']);$j++ ){


        $typedetail = $this->db->query("SELECT * FROM arm_transaction_type WHERE TypeId ='".$this->data['transaction'][$j]->TypeId."'");
        if($typedetail)
        {

        if(isset($typedetail->row()->TransactionName))
        {
        $type=$typedetail->row()->TransactionName;
        }
        else
        {
        $type="---";
        }
        }
        else
        {
        $type="---";
        }


        if($this->data['transaction'][$j]->Debit<0)
        {
            $debits = 0;
        }
        else
        {
            $debits=$this->data['transaction'][$j]->Debit;
        }

            if($this->data['transaction'][$j]->Credit=="")
            {
               $Credit = 0;
            }
            else
            {
              $Credit=$this->data['transaction'][$j]->Credit;
            }


        if($this->data['transaction'][$j]->TypeId==22 || $this->data['transaction'][$j]->Description=="Non Cash Bonus Exchange Successfully")
        {


if($this->data['transaction'][$j]->Rankname)
{
$price_details = $this->db->query("SELECT * FROM arm_ranksetting WHERE rank_id='".$this->data['transaction'][$j]->Rankname."'")->row();
}
        ?>
        <tr>
        <td><?php echo  $i++;?></td>
        <td><?php echo  $type;?></td>
        <td><?php if($this->data['transaction'][$j]->TransactionId!=''){echo $this->data['transaction'][$j]->TransactionId;}else{echo"--";}?></td>
        <td><?php echo  date(' M-d-Y  - h:i:s ',strtotime($this->data['transaction'][$j]->DateAdded));?></td>
        <td><?php echo  $this->data['transaction'][$j]->Description;?></td>
        <td><?php echo $price_details->non_cash;?> </td>
        <td><?php echo number_format($price_details->bonus_amt,2);?> <?php echo currency(); ?> </td>
        </tr>

        <?php
          }
     }} ?>   
        </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>

	<div class="col-lg-11">

	

	<form method="post" action="<?php echo base_url();?>user/noncash" class="form" id="form-register" autocomplete="off" enctype="multipart/form-data">

  <div class="form-back position-relative z-in1 bord-grad">
  <div class="row">

  <?php

$price_lists = $this->db->query("SELECT * FROM `arm_history` WHERE MemberId ='".$this->session->MemberID."' and TypeId='22' and Status='2' ORDER BY HistoryId DESC")->row();


$price_details = $this->db->query("SELECT * FROM arm_ranksetting WHERE rank_id='".$price_lists->Rankname."'")->row();
  ?>



<div class="col-md-11">
	

	<div class="mb-3 form-block position-relative">
	<label for="" class="mb-3"><?php echo ucwords("Select Incentive"); ?><small class="text-danger"> *</small></label>
	<select id="request" name="request" class="form-select" required>
	<option value="" selected="selected">-- Select --</option>
	<?php if($price_lists->Rankname)
	{?>
	<option value='<?php echo $price_lists->Rankname;?>'> Send Cash Request</option>
	<?php
	}
	?>
	</select>
	<div><?php echo form_error('request'); ?></div>
	</div>
	</div>
	
	<input type="hidden" value="<?php echo $price_lists->HistoryId;?>" name="his_id">
	
	<div class="col-sm-12 text-center">
	<div class="checkbox mb-3 position-relative">
	<label class="text-white">
	<input type="submit" name="reg" class="btn btn-primary" value="<?php echo ucwords('request'); ?>"/> 
	</label>
	</div>
	</div>


	
	</form>

<div class="col-sm-6" id="price_details" style="display: none;">

<div class="row" style="margin-top: 20px">

<div class="col-lg-6 mt-4">
<label class="text-primary" style="font-size:16px;font-size: bold">Price Details : </label>
</div>
<div class="col-lg-6 mt-4">
<label class="text-white" style="font-size:16px;font-size: bold"><?php echo $price_details->non_cash;?>  </label>
</div>


<div class="col-lg-6 mt-4">
<label class="text-primary" style="font-size:16px;font-size: bold">Price Value : </label>
</div>
<div class="col-lg-6 mt-4">
<label class="text-white" style="font-size:16px;font-size: bold"><?php echo currency(); ?> <?php echo $price_details->bonus_amt;?>  </label>
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

	$(document).ready(function() {

$('#request').on('change',function(){

$('#price_details').css('display','block');

})

});
	</script>
  <script src="<?php echo base_url();?>assets/user/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script>
    $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="<?php echo base_url();?>assets/user/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/user/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/user/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
    $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false
    });
    });
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
