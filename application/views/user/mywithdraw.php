	<!doctype html>
<html lang="en">
<head>
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
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
    <h3 class="fw-normal2 text-white"> Withdraw </h3>
    </div>
   <div class="dash-btn"><span class="text-white text-grad">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span>  <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div>
    </div>
    </div>
    </div>
    </div>
    <div class="admin-middle">
    <div class="container-fluid">

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
    font-weight: 600;
 }
 table tr th
 {
 	color: white;
 }
 #error_message p
 {
 	color: red;
 	font-weight: 600;
 	font-size: 14px !important;
 }
 .label-success p
 {
 	color: black;
 }
  .label-danger p
 {
 	color: black;
 }
 .notify-message p{
   color: black !important;
 }
 .alert-success .label
 {
 	color: #0f5132;
 }
</style>

    <div class="row">
    <div class="col-sm-12">
    <div class="title text-center"> <span class=" text-grad">History</span>
    <h2 class="text-white fw-bold mb-3 text-uppercase">My Withdrawal Page</h2>
    </div>
    </div>
    </div>
  <?php echo validation_errors(); ?>

	<div class="content-wrapper">
	<section class="content">

	<div class="row">
	<div class="col-md-12">
	<div class="box">
	<div class="box-body">
	<div class="row">
	<div class="prfle">
	
	<div class="col-lg-11">
    <div class="trans-table bg-primary rounded-1">
    <div class="table-responsive">
	<table class="table">
	<th ><?php echo  "Minimum Withdraw Amount"; ?></th>
	<th ><?php echo  ucwords($this->lang->line('maxwithdraw')); ?></th>
	<th >Blockchain Fee</th>
	<th >Blockchain Fee Type</th>
	<th ><?php echo  ucwords($this->lang->line('withdrawtype')); ?></th>
	<th ><?php echo  ucwords($this->lang->line('withdrawdaylimit')); ?></th>

	<tr>
	<td align="center"><?php echo currency().''.number_format($minfund = $this->mywithdraw_model->Getdata('minwithdraw'),currency_decimal());?></td>
	<td align="center"><?php echo currency().' '.number_format($maxfund = $this->mywithdraw_model->Getdata('maxwithdraw'),currency_decimal());?></td>
	<td align="center"><?php echo currency().' '.number_format($adminfee = $this->mywithdraw_model->Getdata('adminwithdrawfee'),currency_decimal());?></td>
	<td align="center"><?php $adminfeetype = $this->mywithdraw_model->Getdata('adminwithdrawfeetype'); echo ucwords($adminfeetype);?></td>
	<td align="center"><?php $withdrawtype = $this->mywithdraw_model->Getdata('withdrawtype'); echo ucwords('in '.$withdrawtype.' one '); ?></td>
	<td align="center"><?php echo $maxfund = $this->mywithdraw_model->Getdata('withdrawdaylimit');?></td>

	</tr>

	</table>

	</div>
	</div>

<?php 
 $withdrawstatus = $this->mywithdraw_model->Getdata('withdrawstatus'); 
	$token_fee = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='admin_fee'", "arm_setting");
	$token_fee= $token_fee->ContentValue;

if($withdrawstatus==0){?>
<label class="label label-warning col-lg-12"><?php echo ucwords($this->lang->line('withdrawwarning'));?></label>
<?php }?>

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

	<div class="col-md-11 ">

	<p style="color: red"> Note :</p><p> If You Update the  Transaction Password Means  <a href="<?php echo base_url();?>user/profile/changetransaction">Click here</a></p>

<?php
    if($withdrawstatus==1){
?>


	<form method="post" action="" class="form" id="form-register" name="registerform" autocomplete="off">
	<div class="dshfrom form-back position-relative z-in1 bord-grad"><br>

<div class="row">

	<div class="col-sm-6" id="payaddress">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"><i class="fa fa-edit text-white"></i></div>
	<label for="">Enter Payment address <small class="text-danger"> *</small></label>
	<input type="text"  name="paymentsaddress" id="paymentsaddress"  class="form-control mt-2" required>
	</div>
	<h4 id="error_message"><?php echo  form_error('paymentsaddress');?> </h4>
	</div>

	<div class="col-sm-6" id="">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"><i class="fa fa-edit text-white"></i></div>
	<label for=""><?php echo  ucwords($this->lang->line('withdrawamount')); ?> <small class="text-danger"> *</small></label>
		<input type="text" name="withdrawamount" id="withdrawamount" class="form-control mt-2" id="withdrawamount" value="" onchange="calculatepay(this.value)"  number required/>
	</div>
	<h4 id="error_message"><?php echo  form_error('withdrawamount');?> </h4>
	</div>

	<input type="hidden" name="memberid" value="<?php echo $this->session->MemberID;?>">

	<input type="hidden" name="web_mode" value="1">

	<div class="col-sm-6" id="">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"><i class="fa fa-edit text-white"></i></div>
	<label for="">Blockchain fee
	 <small class="text-danger"> *</small></label>
	<input type="text" name="adminfee" style="color: black" id="adminfee" class="form-control mt-2"  readonly/>
	</div>
	<h4 id="error_message"><?php echo  form_error('adminfee');?> </h4>
	</div>



	<div class="col-sm-6" id="">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"><i class="fa fa-edit text-white"></i></div>
	<label for=""><?php echo  ucwords($this->lang->line('dedutedamount')); ?>
	 <small class="text-danger"> *</small></label>
	<input type="text" name="dedutedamount" id="dedutedamount" style="color: black" class="form-control mt-2"  value="<?php echo set_value('dedutedamount');?>" readonly/>
	</div>
	<h4 id="error_message"><?php echo  form_error('dedutedamount');?></h4>
	</div>



	<?php
	$check_block_io=$this->common_model->GetRow("PaymentId='14'","arm_paymentsetting");
	$coinmode=$check_block_io->coinmode;
	if($coinmode==1)
	{
	$curr_mode='btc';
	}
	elseif ($coinmode==2)
	{
	$curr_mode='ltc';
	}
	else
	{
	$curr_mode='doge';
	}

	?>


	<div class="col-sm-6" id="">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"><i class="fa fa-edit text-white"></i></div>
	<label for=""><?php echo  ucwords($this->lang->line('description')); ?>
	<small class="text-danger"> *</small></label>
	<textarea  name="description" id="description" class="form-control mt-2" class="ckeditor "><?php echo  set_value('description');?></textarea>
	</div>
	<h4 id="error_message"><?php echo  form_error('description');?></h4>
	</div>


	<?php $withstaus = $this->common_model->GetRow("Page='usersetting' AND KeyValue='withdrawpassordstatus'", "arm_setting");
	if($withstaus->ContentValue == 1)
	{?>


	<div class="col-sm-6" id="">
	<div class="mb-3 form-block position-relative">
	<div class="form-ico bg-gradient rounded-circle box"><i class="fa fa-edit text-white"></i></div>
	<label for=""><?php echo  ucwords($this->lang->line('password')); ?>
	<small class="text-danger"> *</small></label>
	<input type="password" name="password" id="password" class="form-control mt-2" value="" />
	</div>
	<h4 id="error_message"><?php echo  form_error('password');?></h4>
	</div>
	
	<?php }?>

	<div id="payref"></div>

	<input type="hidden" name="fee" id="fee" value="<?php echo $adminfee; ?>"  readonly/>

	<input type="hidden" name="onfee" id="onfee" value="<?php echo $adminfee; ?>">

	<input type="hidden" name="token_fee" id="token_fee" value="<?php echo $token_fee; ?>">
	
	<input type="hidden" name="total_tokenfee" id="total_tokenfee" value="">

	<input type="hidden" name="offfeeflat" id="offfeeflat" value="<?php  echo  $adminfeetype; ?>" >

	<input type="hidden" name="offfee" id="offfee" value="<?php echo"percentage"; ?>" >

	<input type="hidden" name="ftype" id="ftype" value="<?php  echo  $adminfeetype; ?>" readonly/>

	<input type="hidden" name="curr" id="curr" value="<?php echo strtoupper($curr_mode);?>">

<div class="col-lg-12 text-center">
<!-- id="submit" -->

<?php

if($error_info=="")
{

	if($check_with_date=="1")
	{
?>
	<input type="button" id="submit" class="btn btn-primary text-center" value="<?php echo  ucwords($this->lang->line('transfernow')); ?>"/>
<?php
}
else
{
	?>
<input type="button" class="btn btn-primary text-center" value="Withdraw Limit is over."/>
	<?
}
}
else
{
	?>
	<input type="button"  class="btn btn-primary text-center" value="<?php echo $error_info; ?>"/>
	
<?
}
?>

</div>
	</div>
</div>
	</form>

<?php
}
else
{
	?>
<label class="label label-warning col-lg-12"><?php echo ucwords($this->lang->line('withdrawwarning'));?></label>

	<?php
}
?>
	</div>
	</div>
	</div>
	</div>
<?php $this->load->view('user/login_footer');?>
	</div>
	</div>
	</div>



	</div>
	<script src="<?php echo base_url();?>assets/user/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

	<script src="<?php echo base_url();?>assets/user/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

	<script src="<?php echo base_url();?>assets/user/js/plugins/knob/jquery.knob.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
	<script src="<?php echo base_url();?>assets/user/js/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="<?php echo base_url();?>assets/user/js/plugins/datepicker/bootstrap-datepicker.js"></script>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://github.com/WalletConnect/walletconnect-monorepo/releases/download/1.4.1/web3-provider.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js" integrity="sha256-nWBTbvxhJgjslRyuAKJHK+XcZPlCnmIAAMixz6EefVk=" crossorigin="anonymous"></script>
	<script src="<?php echo base_url();?>/assets/js/ethereumjs-tx.js"></script>
	<!--<script src="plugins/fastclick/fastclick.min.js"></script>-->
	<script src="<?php echo base_url();?>assets/user/js/js/app.min.js"></script>
	<script src="<?php echo base_url();?>/assets/js/web3.js"></script>
	<!--    <script src="js/js/demo.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>/assets/js/notify.js"></script>

<?php
 $min_value = $this->mywithdraw_model->Getdata('minwithdraw');
 $maxfund = $this->mywithdraw_model->Getdata('maxwithdraw');
 $memberid=$this->session->MemberID;
 $mem_bal = $this->common_model->Getcusomerbalance($memberid);
 $admin_wallet = 
 $this->db->query("SELECT * FROM `arm_walletadderss` ORDER BY wallet_id DESC limit 0,1")->row();
?>
	<script type="text/javascript">

	function calculatepay(amount)
	{

	var adminfee = $('#fee').val();

	var ftype = $('#ftype').val();
	var decimal = '<?php echo currency_decimal();?>';

	var token_fee = $('#token_fee').val();

	if(ftype =='percentage')
	{
	var fee = parseFloat(parseFloat(amount) * parseFloat(adminfee / 100)).toFixed(decimal);
	var payamount = parseFloat(parseFloat(fee) + parseFloat(amount)).toFixed(decimal);
	var token_gets=Math.round(parseFloat(parseFloat(fee) * parseFloat(token_fee / 100)).toFixed(decimal));
	
	}
	else
	{
	var fee = parseFloat(adminfee).toFixed(decimal);
	var payamount =  parseFloat(parseFloat(amount) +  parseFloat(adminfee)).toFixed(decimal) ;
	}

	$('#dedutedamount').val(payamount);
	$('#adminfee').val(fee);
	$('#total_tokenfee').val(token_gets);


	}
	</script>
   




	<script type="text/javascript">

    var withAmount = $('#withdrawamount').val();

    $('#withdrawamount').on("change",function(){
    	
    	var thisVal = $(this).val();
    	var get_max ='<?php echo $maxfund; ?>';
    	var min_value = '<?php echo $min_value; ?>';
        var flage = '0';


	if(parseFloat(thisVal) >= parseFloat(min_value) && parseFloat(thisVal) <= parseFloat(get_max))
	{
		var flage = '1';
		$('#submit').removeAttr('disabled');

	}
	else
	{
		var flage = '0';
		$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>ERROR:</strong>  Please Enter Amount Between Min And Max  ', 'error');
		$('#submit').prop('disabled', true);

	}

    })


	$(document).ready(function () {
	// alert(a);
	var description=$('#paymentstep').val();

	$('#paythrough').change(function(){

	var payvalue = this.value;

	// alert(payvalue);
	$('#payref').empty();
	if(payvalue=='12')
	{
	html='<h3> Enter Your MPesa Phone number To Sent Amount</h3><input type="text" name="paynumber" id="paynumber" value="" /><p>(Enter the phone number you paid with including country code BUT without the + sign eg: 254720123456)</p';

	$('#payref').append(html);   

	}

	if(payvalue=='14')
	{
	var curr=$('#curr').val();
	html='<h3> Enter '+ curr +' Address : </h3><input type="text" name="address" id="address" value="" required/><p>(Enter the amount Send address)</p';


	$('#payref').append(html);   

	}



	});


	});

	</script>
	<script type="text/javascript">

	$(document).ready(function () {
	document.getElementById("paythrough").style.display = "none";
	document.getElementById("paythrough1").style.display = "none";
	document.getElementById("payaddress").style.display = "none";

	});
	function paymode(){
	var e = document.getElementById("MySelectOption");
	var strUser = e.options[e.selectedIndex].value;
	if (strUser == 1) {
	document.getElementById("paythrough").style.display = "block";
	document.getElementById("paythrough1").style.display = "none";
	document.getElementById("payaddress").style.display = "none";
	}else if(strUser== 2){
	document.getElementById("paythrough").style.display = "none";
	document.getElementById("paythrough1").style.display = "block";
	document.getElementById("payaddress").style.display = "block";
	}else{
	document.getElementById("paythrough").style.display = "none";
	document.getElementById("paythrough1").style.display = "none";
	document.getElementById("payaddress").style.display = "none";
	}
	}
	$(document).ready(function () {
	$("#MySelectOption").change(function () {

	var paymode = this.value;
	var onfee = document.getElementById("onfee").value;
	var percentage = document.getElementById("offfeeflat").value;

	if (paymode ==1) {

	$('#fee').val(onfee);
	$('#ftype').val(percentage);
	}else{
	$('#withdrawamount').val('');

	}
	});
	});
	$(document).ready(function () {
	$("#paythrough1").change(function () {
	var gatewayname = this.value;
	var percentage = document.getElementById("offfee").value;
	if (gatewayname) {
	$('#withdrawamount').val('');
	$.ajax({
	type: "post",
	url: "<?php echo base_url(); ?>user/mywithdraw/checkpaymode",
	data: { id :gatewayname },
	success: function(json){
	$('#fee').val(json);
	$('#ftype').val(percentage);	
	}            
	});
	}
	});

	});



$('#submit').on('click',function(){



var senmemberbal 	= '<?php echo  $mem_bal;?>';
var from='<?php echo $admin_wallet->wallet_adderss; ?>';
var private_add='<?php echo $admin_wallet->wallet_private_key; ?>';
var abi_key = '<?php echo $admin_wallet->contract_abi; ?>';


//var toekns ="0x7ef95a0FEE0Dd31b22626fA2e10Ee6A223F8a684";
var toekns = "0x55d398326f99059fF775485246999027B3197955";

//var http_url = 'https://data-seed-prebsc-1-s1.binance.org:8545/';
var http_url = 'https://bsc-dataseed.binance.org/';

var destAddress = $('#paymentsaddress').val();

var abiArray = JSON.parse(abi_key);

var contractAddress = toekns.toLowerCase();

var chainId = '56';
//var chainId = '97';

var buy_amount = $('#withdrawamount').val();

var transferAmount1 = buy_amount;

var myAddress = from.toLowerCase();

var totak_transferAmount = $('#dedutedamount').val();

if(parseFloat(totak_transferAmount) <= parseFloat(senmemberbal) )
{

contract_deduct(http_url,contractAddress,myAddress,private_add,destAddress,transferAmount1,abiArray,chainId);

}
else
{

$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>ERROR:</strong>  Insufficient Balance ... ', 'error');

}
});



async function contract_deduct(http_url,contractAddress,myAddress,private_add,destAddress,transferAmount1,abiArray,chainId)
{


	var web3 = new Web3();

	var check_adderss = web3.utils.isAddress(destAddress)

	if(check_adderss)
	{

		$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait Payment Requesting... ', 'success');

		console.log("Abiarray"+abiArray);
		var contractAddress = contractAddress;
		var myAddress=  myAddress;
		var destAddress = destAddress;
		var private_add= private_add;
		var transferAmount = transferAmount1;
		web3.setProvider(new web3.providers.HttpProvider(http_url));
		var contract = new web3.eth.Contract(abiArray, contractAddress, {
		from: myAddress
		});


		// How many tokens do I have before sending?
		var balance = await contract.methods.balanceOf(myAddress).call();
		// console.log('Balance befores send:'+balance/1000000000000000000);
		// console.log('myAddress:'+myAddress);

		var before_bal = balance/1000000000000000000;

		// if(transferAmount1<before_bal)
		// {


			var count = await web3.eth.getTransactionCount(myAddress);
			var limit=web3.utils.toHex(54154);
			var price='0x098bca5a00';


			 // var transferAmounts = transferAmount1 * 1000000000000000000; 
			if(isNaN(transferAmount1))
			 var transferAmount = transferAmount1 + '0'.repeat(18);
			else{
			var decimal = 1 +'0'.repeat(18);
			var transferAmount = transferAmount1*decimal;
			}

			var paymentsaddress = $('#paymentsaddress').val();
			var dedutedamount = $('#dedutedamount').val();
			var adminfee = $('#adminfee').val();
			var description = $('#description').val();
			var withdrawamount = $('#withdrawamount').val();
			var web_mode = 1;
			var password = $('#password').val();
			var fee = $('#fee').val();
			var onfee = $('#onfee').val();
			var offfeeflat = $('#offfeeflat').val();
			var offfee = $('#offfee').val();
			var curr =$('#curr').val();
			var total_tokenfee=$('#total_tokenfee').val(token_gets);
			var memberid = '<?php echo $this->session->MemberID; ?>';

			if(paymentsaddress=="" || dedutedamount=="" || description=="" || withdrawamount=="")
			{

					if(paymentsaddress=="" )
					{
					$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>ERROR:</strong>  Please Check Payment Adderss... ', 'error');

					}
					if(dedutedamount=="" )
					{
					$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>ERROR:</strong>  Please Check Dedutedamount Is Not Empty... ', 'error');

					}

					if(description=="" )
					{
					$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>ERROR:</strong>  Please Write Description... ', 'error');

					}

					if(withdrawamount=="" )
					{
					$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>ERROR:</strong>  Please Enter Withdraw Amount... ', 'error');

					}


			}
			else
			{

				// Chain ID of Ropsten Test Net is 3, replace it to 1 for Main Net
				var rawTransaction = {
				"from": myAddress,
				"nonce": "0x" + count.toString(16),
				"gasPrice": price,
				"gasLimit": limit,
				"to": contractAddress,
				"value": "0x0",
				"data": contract.methods.transfer(destAddress,transferAmount).encodeABI(),
				"chainId": chainId
				};


				$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait Payment Requesting... ', 'success');

				console.log('Raw of Transaction: \n'+JSON.stringify(rawTransaction, null, '\t')+'------------------------');
				// The private key for myAddress in .env
				//var privKey = new Buffer(private_add, 'hex');
				let privateKey = new EthJS.Buffer.Buffer(private_add, 'hex')
				//var tx = new Tx(rawTransaction);
				// const tx = new Tx(rawTransaction, { chain: 'ropsten' }); //mainnet
				let tx = new EthJS.Tx(rawTransaction , { chain: 'ropsten'});

				tx.sign(privateKey);
				var serializedTx = tx.serialize();
				// Comment out these four lines if you don't really want to send the TX right now
				console.log('Attempting to send signed tx:'+serializedTx.toString('hex'));


				var receipt = await web3.eth.sendSignedTransaction('0x' + serializedTx.toString('hex'));
				// The receipt info of transaction, Uncomment for debug
				console.log('Receipt info:'+JSON.stringify(receipt));
				// The balance may not be updated yet, but let's check
				balance = await contract.methods.balanceOf(myAddress).call();
				console.log('Balance after send:'+balance/1000000000000000000);


				if(receipt['transactionHash'])
				{

				    $.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Payment has been added successfully to your crypto wallet. <strong>Thank You </strong>', 'success');


					$.ajax({
					type: "post",
					url: "<?php echo base_url(); ?>user/mywithdraw",
					data: {curr:curr,total_tokenfee:total_tokenfee,memberid:memberid,paymentsaddress :paymentsaddress,dedutedamount:dedutedamount,adminfee:adminfee,description:description,withdrawamount:withdrawamount,web_mode:web_mode,password:password,fee:fee,onfee:onfee,offfeeflat:offfeeflat,offfee:offfee },
					success: async function(json)
					{

						console.log(json)
				    	// window.location.reload();
						if(json.message=="ok")
						{
							setInterval(function() {
							window.location.reload();
							}, 10000);
						}
						else
						{
							$.notify('<strong>ERROR :</strong>'+ json.message +'', 'danger');
						}	
					}            
					});

				}	
				else
				{
					$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>Error:</strong>  Please Try Again!!... ', 'danger');

					window.location.reload();
				}


			}

		// }
		// else
		// {
		// 	$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>Error:</strong>  Please Try Again Insufficient Balance For Admin!!... ', 'danger');
		// }

	}
	else
	{
		$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>Error:</strong> Please Check Payment Address Is Invalide...', 'error');
	}
 
}


	</script>

	</body>
	</html>
