<!doctype html>
<html lang="en">
<head>
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>


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
<h3 class="fw-normal2 text-white"> Myreferal</h3>
</div>
<div class="dash-btn"><span class="text-white text-grad " style="font-size:14px;">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span>  <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div></div>
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
<div class="bskt">
<?php if($this->session->flashdata('error_message')) { ?>  
<div class="alert alert-danger alert-dismissable">
<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
<?php echo $this->session->flashdata('error_message');?>
</div>  

<?php } ?>

<?php if($this->session->flashdata('success_message')) { ?>    
<div class="alert alert-success alert-dismissable">
<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
<?php echo $this->session->flashdata('success_message');?>
</div>
<?php } ?>
</div>
		<div class="row">
		<div class="col-md-12">
		<div class="box">

		<div class="box-body">
		<div class="row">
		<div class="prfle">

		<div class="col-md-12">

		<form method="post" action="" class="form" id="form-register" autocomplete="off">
		<div class="dshfrom"><br>


<div class="title"> 
	<span class="text-white"><?php echo  ucwords($this->lang->line('referrallink')); ?></span>
	<h4><?php $refurl = base_url().'user/register/?ref='.$member->ReferralName;?></h4>
</div>

<div class="col-md-12" style="overflow-x: auto;">


<h3><a class="btn btn-primary" id="copylink1" href="<?php echo base_url().'user/register/?ref='.$member->ReferralName;?>" ><?php echo base_url().'user/register/?ref='.$member->ReferralName;?></a></h3>

<br>
<input type="button" class="btn btn-primary" id="copylink" value="Copy link">

<br>

</div>	
		<div class="col-md-12 text-center">
		<div class="social share-buttons">
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $refurl;?>" target="_blank" title="Share on Facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='<?php echo $refurl;?>'&t=' + encodeURIComponent(document.URL)); return false;" class="rtte"><i class="fab fa-facebook-f"></i> </a> 

		<a href="https://plus.google.com/share?url=<?php echo $refurl;?>" target="_blank" title="Share on Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;" class="rtte"><i class="fa-brands fa-google-plus-g"></i></a>

		<a href="https://twitter.com/intent/tweet?source=<?php echo $refurl;?>&text=:%20" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20' + encodeURIComponent(document.URL)); return false;" class="rtte"><i class="fab fa-twitter"></i></a>

		<a href="http://pinterest.com/pin/create/button/?url=<?php echo $refurl;?>&description=" target="_blank" title="Pin it" onclick="window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(document.URL) + '&description=' +  encodeURIComponent(document.title)); return false;" class="rtte"><i class="fab fa-pinterest"></i></a>

		</div>
		</div>
		</div>
		<div class="col-md-6" style="display:none;">
		<h3><?php echo  ucwords($this->lang->line('referralname')); ?><sup><em class="text-danger">*</em></sup></h3>
		<input type="text" name="referralname" value="<?php echo set_value('referralname',isset($member->ReferralName)?$member->ReferralName : '');?>" id="referralname" placeholder="<?php echo  ucwords($this->lang->line('enter').$this->lang->line('referralname')); ?>"/>
		<h4><?php echo  form_error('referralname');?></h4>
		<h3></h3>
		</div>


		</form>

		</div>
		<div class="col-md-5 text-center">
		<!-- <img src="<?php echo base_url();?>assets/user/img/refer.jpg" width= "60%" > -->
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

		var copyCodeBtn = document.querySelector('#copylink');

		copyCodeBtn.addEventListener('click', function(event)
		{
		// Select the email link anchor text  
		var Link = document.querySelector('#copylink1');
		var range = document.createRange();
		range.selectNode(Link);
		window.getSelection().addRange(range);

		try
		{
		// Now that we've selected the anchor text, execute the copy command
		var successful = document.execCommand('copy');
		var msg = successful ? 'successful' : 'unsuccessful';
		console.log('Copy command was ' + msg);
		} 
		catch (err)
		{
		console.log('Oops, unable to copy');
		}

		// Remove the selections - NOTE: Should use
		// removeRange(range) when it is supported
		window.getSelection().removeAllRanges();
		});

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
