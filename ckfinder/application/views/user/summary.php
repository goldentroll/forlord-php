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
	.publicform {
	margin:10px;
	}
	#confetti-canvas
	{
	position: absolute;
	top:0;
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
	<div class="title text-center">
	<h2 class="text-white fw-bold mb-3 text-uppercase pla">BUSINESS PLAN Summary</h2>
	</div>
	</div>
	</div>

	<div class="col-lg-12">

	<div class="row">

	<div class="col-lg-2">

	</div>

	<?php


	$i=0;
	foreach($packages as $prows) { 
	$i++;
	?>
	<div class="col-lg-6">
	<div class="calc-block">
	<div class="calc-block--title pla">Plan details</div>
	<div class="calc-block--percent">
	<div class="number text-grad pla"><?php echo number_format($prows->DirectCommission)." ".currency();?> </div>

	<div class="calc-label">Referal Commission</div>
	</div>
	<div class="row">

	<div class="col-md-6 col-xl-6">

	<div class="calc-info"> Package Name : <strong id="min"><?php echo ucfirst($prows->PackageName);?> </strong> </div>
	<div class="calc-info"> Package Fee : <strong id="max"> <?php echo $prows->PackageFee." ".currency();?></strong> </div>
	</div>

	</div>
	<input type="hidden" id="wallet_id" value="0">
	<span id="err_disp"></span>

	<div class="col-md-12 col-xl-12">
	<div class="invest-btn">



	<?php
	if($wallet_type==1)
	{
	?>
	<input type="submit" id="deposit_wallet" style="margin-top: 10px;" value="Deposit" class="btn btn-primary" onclick="invest()" style="display: none;">

	<input type="submit" id="conect_wallet" value="Connect Wallet" class="btn btn-primary" onclick="load_modal()" >
	<?php
	}
	else
	{
	?>
<input type="submit" id="conect_wallet" value="Connect Wallet" class="btn btn-primary" onclick="load_modal();">

	<input type="submit" id="deposit_wallet"  value="Deposit" class="btn btn-primary" onclick="invest()" style="display: none;margin-top: 10px;">
	<?
	}
	?>

	<a class="btn btn-primary" id="view_wallet" style="float: left;margin-top:10px;display: none;" data-bs-toggle="modal" data-bs-target="#exampleModal" >View Wallet</a>
	</div>
	</div>
	</div>
	</div>

	<?php
	}
	?>

	</div>
	</div>

	<div class="row justify-content-center py-2">


	</div>
	</div>


	<div class="col-lg-11" style="overflow: hidden;">
	<div class="publicform form-back position-relative z-in1 bord-grad"  style="display: none;">
	<div class="container">
	<div class="row">
	<div class="col-lg-11" style="overflow: hidden;">
	<div class="text-center" id="messages">
	<div class="col-lg-11">
	<p class="text-white"><?php 
	echo "Congratulations! Your Package Upgrade  Successfuly...";
	?></p>
	<div class="row">
	<div class="col-lg-12">
	<button class=
	"submitId btn btn-primary text-center font-weight-bold mt-5" id="popup_close" >
	Close
	</button>
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
	</div>
	</div>
	</div>


	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered wallet-pop">
	<div class="modal-content grad-bg">
	<div class="modal-body">
	<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>

	<h2 class="title fw-bold text-center text-white pb-3">Your Wallet Info</h2>

	<div class="wallet-block1 bg-white p-3">
	<div class="row">

	<div class="col-sm-6" style="margin-bottom: 10px;">
	Wallet Adderss
	</div>
	<div class="col-sm-6" style="margin-bottom: 10px;">
	<span id="wallet_adderss"></span>
	</div>

	<div class="col-sm-6" style="margin-bottom: 10px;">
	Balance
	</div>
	<div class="col-sm-6" style="margin-bottom: 10px;">
	<span id="balance"></span>
	</div>

	</div>
	</div>

	</div>

	</div>
	</div>
	</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://github.com/WalletConnect/walletconnect-monorepo/releases/download/1.4.1/web3-provider.min.js"></script>

		<script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js" integrity="sha256-nWBTbvxhJgjslRyuAKJHK+XcZPlCnmIAAMixz6EefVk=" crossorigin="anonymous"></script>
		<script src="<?php echo base_url();?>/assets/js/web3.js"></script>
		<script src="<?php echo base_url();?>/assets/js/ethereumjs-tx.js"></script>
		<script src="<?php echo base_url();?>assets/sytl/js/admin.js"></script> 
		<script src="https://unpkg.com/moralis@0.0.184/dist/moralis.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@portis/web3@4.0.7/umd/index.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/walletconnect-web3-provider@0.7.28/dist/walletconnect-web3-provider.min.js"></script>

		<script type="text/javascript" src="https://unpkg.com/web3modal"></script>


		 <script type="text/javascript" >

/**
 * Example JavaScript code that interacts with the page and Web3 wallets
 */

 // Unpkg imports
const Web3Modal = window.Web3Modal.default;
const WalletConnectProvider = window.WalletConnectProvider.default;
const EvmChains = window.EvmChains;
const Fortmatic = window.Fortmatic;

// Web3modal instance
let web3Modal

// Chosen wallet provider given by the dialog window
let provider;


// Address of the selected account
let selectedAccount;


/**
 * Setup the orchestra
 */
function init() {

  console.log("Initializing example");
  console.log("WalletConnectProvider is", WalletConnectProvider);
  console.log("Fortmatic is", Fortmatic);

  // Tell Web3modal what providers we have available.
  // Built-in web browser provider (only one can exist as a time)
  // like MetaMask, Brave or Opera is added automatically by Web3modal
  const providerOptions = {
    walletconnect: {
      package: WalletConnectProvider,
      options: {
        // Mikko's test key - don't copy as your mileage may vary
        infuraId: "8043bb2cf99347b1bfadfb233c5325c0",
      }
    },

    fortmatic: {
      package: Fortmatic,
      options: {
        // Mikko's TESTNET api key
        key: "pk_test_391E26A3B43A3350"
      }
    }
  };

  web3Modal = new Web3Modal({
    cacheProvider: false, // optional
    providerOptions, // required
  });

}

/**
 * Connect wallet button pressed.
 */
async function onConnect() {

  console.log("Opening a dialog", web3Modal);
  try {
    provider = await web3Modal.connect();
  } catch(e) {
    console.log("Could not get a wallet connection", e);
    return;
  }

  // Subscribe to accounts change
  provider.on("accountsChanged", (accounts) => {
    fetchAccountData();
  });

  // Subscribe to chainId change
  provider.on("chainChanged", (chainId) => {
    fetchAccountData();
  });

  // Subscribe to networkId change
  provider.on("networkChanged", (networkId) => {
    fetchAccountData();
  });

  await refreshAccountData();
}

/**
 * Disconnect wallet button pressed.
 */
/**
 * Main entry point.
 */
window.addEventListener('load', async () => {
  init();
  document.querySelector("#deposit_wallet").addEventListener("click", onConnect);
  document.querySelector("#btn-disconnect").addEventListener("click", onDisconnect);
});

    </script>

		<script type="text/javascript">
		$(document).ready(async function(){

		async function connectWallet(){
		  if (window.ethereum) { //check if Metamask is installed
		        try {
		            const address = await window.ethereum.enable(); //connect Metamask
		            const obj = {
		                    connectedStatus: true,
		                    status: "",
		                    address: address
		                }
		                return obj;
		             
		        } catch (error) {
		            return {
		                connectedStatus: false,
		                status: "🦊 Connect to Metamask using the button on the top right."
		            }
		        }
		        
		  } else {
		        return {
		            connectedStatus: false,
		            status: "🦊 You must install Metamask into your browser: https://metamask.io/download.html"
		        }
		      } 
		};

		var a =await connectWallet();
		console.log(a);

		});


		// var web3 = new Web3(new Web3.providers.HttpProvider('https://mainnet.infura.io/v3/eceb8c3b31314d9698b508a914b33513'));
		// console.log("isConnected=");
		// web3.eth.net.isListening().then(console.log);

		</script>


<script type="text/javascript">

var isMobile = {
Android: function() {
return navigator.userAgent.match(/Android/i);
},
BlackBerry: function() {
return navigator.userAgent.match(/BlackBerry/i);
},
iOS: function() {
return navigator.userAgent.match(/iPhone|iPad|iPod/i);
},
Opera: function() {
return navigator.userAgent.match(/Opera Mini/i);
},
Windows: function() {
return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
},
any: function() {
return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
}
};

</script>



	<?php
	if($wallet_type==1)
	{
	?>
	<script src="https://cdn.jsdelivr.net/npm/@metamask/detect-provider@1.2.0/dist/index.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/metamask_connect.js"></script>
	<script src="https://unpkg.com/@metamask/detect-provider/dist/detect-provider.min.js"></script>

	<script type="text/javascript">

	$(document).ready( async function(){
	});

	</script>

	<script type="text/javascript">

	function load_modal(){

	if( isMobile.any() )
	{

	var url = "<?php echo base_url();?>/assets/js/wallet_connect_moralis.js";
	$.getScript( url, function() {
	request_wallet('<?php echo base_url();?>');

	});

	}
	else
	{
	connect();
	}

	}

	</script>

	<?php
	}
	else
	{
	?>
    <script src="<?php echo base_url();?>assets/js/metamask_connect.js"></script>
		<script type="text/javascript">


	function load_modal(){


	if( isMobile.any() )
	{

	var url = "<?php echo base_url();?>/assets/js/wallet_connect_moralis.js";
	$.getScript( url, function() {
	request_wallet('<?php echo base_url();?>');
	});

 // document.write('<script src="https://unpkg.com/moralis@0.0.184/dist/moralis.js"><\/script>');
 // document.write('<script src="<?php echo base_url();?>/assets/js/wallet_connect_moralis.js"><\/script> ');

	}
	else
	{
	connect1();
	}

	}

	</script>
  
	<?
	}
	?>



	<script type="text/javascript" src="<?php echo base_url();?>/assets/js/notify.js"></script>


	</body>
	</html>

	<?php
	$admin_wallet = 
	$this->db->query("SELECT * FROM `arm_walletadderss` ORDER BY wallet_id DESC limit 0,1")->row();
	?>

	<script src="<?php echo base_url();?>assets/js/confetti.js"></script>

	<script type="text/javascript">



 async function connect1()
 {
 	console.log('connect1');
    if (window.ethereum) {
  window.web3 = new Web3(window.ethereum);
  try {

  ethereum.enable().then( async res =>{
  var accounts = await web3.eth.getAccounts();
  window.web3.eth.defaultAccount = accounts[0];

  $.notify('<strong>Success:</strong> Wallect Connect Successflly', 'success');
  document.querySelector("#wallet_id").value = '1'; 
  document.querySelector("#view_wallet").style.display = "inline-block";
  document.querySelector("#deposit_wallet").style.display = "inline-block";
  document.querySelector("#conect_wallet").style.display = "none";
  document.querySelector("#wallet_adderss").textContent = accounts[0];
  document.querySelector("#deposit_wallet").value = "Deposit";  
	var balance= await web3.eth.getBalance(account);
	document.querySelector("#balance").innerHTML = parseFloat(balance/1000000000000000000)
 
  });
  } catch (error) {

  $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> User rejected permission!', 'danger');
   document.querySelector("#deposit_wallet").textContent = "Please Connect Wallet";
   document.querySelector("#deposit_wallet").style.display = "none";
   document.querySelector("#conect_wallet").style.display = "inline-block";
   document.querySelector("#conect_wallet").textContent = "Install Metamask";

  }
  }
  else
  {

     $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Metamask Not installed! ', 'danger');
  }


 }



	// if (window.site.isMobile) {
	// }


	$('#popup_close').on('click',function(){
	window.location.href="<?php echo base_url();?>user/upgrade";
	});


	function invest()
	{
	const invest_amount = '<?php echo $packages[0]->PackageFee; ?>';
	var package_id      = '<?php echo $packages[0]->PackageId ?>';
	var url = '<?php echo base_url(); ?>';
	var account='0x55d398326f99059fF775485246999027B3197955';
	var wallet_id = $('#wallet_id').val();



// $.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait ... ', 'success');
// window.setTimeout(function(){
// deposit_success(account,'Testhash',1,1,invest_amount,package_id);
// }
// ,5000);

	if(parseFloat(wallet_id)>0)
	{
	if(invest_amount=='')
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Pls Enter Amount', 'danger');
	}
	else if(parseFloat(invest_amount<0))
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Pls Enter In Min And Max Amount', 'danger');
	}
	else
	{
	if(wallet_id=='1')
	{


	metamask(invest_amount,package_id);
	}
	if(wallet_id=='2')
	{
	authenticate1(url,invest_amount,package_id);
	}
	}
	}
	else
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Pls Connect Wallet', 'danger');
	}
	}



 // async function connect1()
 // {

 // if (window.web3) 
 //  {
 //  window.web3 = new Web3(window.web3.currentProvider);
 //  var account=0;
 //  web3.eth.getAccounts(async function(err, accounts) 
 //  {

 //  if (accounts.length == 0) 
 //  {
 //  $.notify('<strong>Error:</strong>  No account found! Make sure the Trust Wallet is configured properly.! ', 'error');
 //  $("html, body").animate({ scrollTop: 0 }, "slow");
 //  return;
 //  }
 //  else
 //  {
 //  var d_flag=0;
 //  var account=accounts[0];
 //  $.notify('<strong>Success:</strong> Wallect Connect Successflly', 'success');
 //  document.querySelector("#wallet_id").value = '1'; 
 //  document.querySelector("#wallet_adderss").textContent = accounts[0];
 //  document.querySelector("#deposit_wallet").value = "Deposit";
 //  document.querySelector("#deposit_wallet").style.display = "inline-block";
 //  document.querySelector("#conect_wallet").style.display = "none";
 //  document.querySelector("#view_wallet").style.display = "inline-block";
 //  var balance= await web3.eth.getBalance(account);
 //  document.querySelector("#balance").innerHTML = parseFloat(balance/1000000000000000000)
 //  }

 //  });


 //  }
 //  else
 //  {

 //     $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Metamask Not installed! ', 'danger');
 //  }


 // }




	function metamask(invest_amount,package_id)
	{
	var mode=1;
	var receiver_address='<?php echo $admin_wallet->wallet_adderss; ?>';
	var contract='<?php echo $admin_wallet->wallet_adderss; ?>';
	var owner='<?php echo $admin_wallet->wallet_adderss; ?>';
	var owner_key='<?php echo $admin_wallet->wallet_private_key; ?>';
	var url = '1';

	if(receiver_address=='')
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>  No payment receiver Informations Provided. Pls contact Administrator', 'danger');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	}
	else if(contract=='')
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>  No contract Address Informations Provided. Pls contact Administrator', 'danger');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	}
	else if(owner=='')
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> No Distributor Address Informations Provided. Pls contact Administrator', 'danger');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	}
	else if(owner_key=='')
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>  No Distributor Key Informations Provided. Pls contact Administrator', 'danger');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	}
	else 
	{
	if (window.ethereum) 
	{
	window.web3 = new Web3(window.ethereum)
	try 
	{
	ethereum.enable()
	} catch (error) 
	{

	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>  User rejected permission! ', 'danger');
	$("html, body").animate({ scrollTop: 0 }, "slow");

	}
	}
	else if (window.web3) 
	{
	window.web3 = new Web3(window.web3.currentProvider)
	}
	else 
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>   Non-Ethereum browser detected. You should consider trying MetaMask!', 'danger');

	$("html, body").animate({ scrollTop: 0 }, "slow");
	}
	var account=0;
	web3.eth.getAccounts(function(err, accounts) 
	{
	if (err != null) 
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>  Error retrieving accounts. Pls once check!', 'danger');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	return;
	}
	if (accounts.length == 0) 
	{
	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>  No account found! Make sure the Ethereum Binance is configured properly.! ', 'danger');
	$("html, body").animate({ scrollTop: 0 }, "slow");
	return;
	}
	else
	{
	var account=accounts[0];

	if(mode=="2")
	{
	pay_mode='2';
	}
	else
	{
	pay_mode='1';
	}
	setinfo(account,pay_mode,receiver_address,'1',invest_amount,package_id);
	}
	});
	}
	}


	async function setinfo(account,mode,receiver,pay_mode,invest_amount,package_id)
	{

	//const accounts = await web3.eth.getAccounts();
	var receiver_address=receiver;
	//var tokenAddress = "0xdac17f958d2ee523a2206206994597c13d831ec7";
	//var tokenAddress = "0x7ef95a0FEE0Dd31b22626fA2e10Ee6A223F8a684";
	var tokenAddress = "0x55d398326f99059fF775485246999027B3197955";
	var total_amount= invest_amount;
	var toAddress = receiver_address;
	var fromAddress =account;
	var fromAddress= fromAddress.toLowerCase();
	var tokenAddress= tokenAddress.toLowerCase();
	var networkId = await web3.eth.net.getId();


	if(networkId!=56)
	{

	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Pls Change Network Mode to Smart Chain Mode In Metamask And then Proceed Again', 'danger');

	}
	else
	{

	let minABI1 = [{"constant":true,"inputs":[{"name":"_owner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256"}],"type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint8"}],"type":"function"}];
	var minABI = [{"constant": false,"inputs": [{"name": "_to","type": "address"},{"name": "_value","type": "uint256"}],
	"name": "transfer","outputs": [{"name": "","type": "bool"}],"type": "function"}];


	var contract = new web3.eth.Contract(minABI, tokenAddress);// calculate ERC20 token amount
	var contract1 = new web3.eth.Contract(minABI1, tokenAddress);// calculate ERC20 token amount
	var token_balance = await contract1.methods.balanceOf(fromAddress).call();
	var decimals = await contract1.methods.decimals().call();
	var token_balance=parseFloat(token_balance/1000000000000000000);
	var decimals="1e"+decimals;
	var total_amount=parseFloat(total_amount);
	console.log("Rec ADD",receiver_address);
	console.log("To add",toAddress);
	console.log("from dd",fromAddress);
	console.log("netwo id",networkId);
	console.log("tot amount",total_amount);
	if(parseFloat(token_balance)=='0')
	{
		
		$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>   No Token Balance Available In Your Account!', 'danger');

		// $.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait ... ', 'success');
		window.setTimeout(function(){
		deposit_success(account,'Testhash',pay_mode,mode,invest_amount,package_id);
		}
		,5000);
	// 	$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait Payment Requesting... ', 'success');

	// 	var amount = parseFloat(total_amount)*parseFloat(decimals);// call transfer function
	// 	contract.methods.transfer(toAddress,amount).send({from: fromAddress})
	// 	.on('transactionHash', function(hash){
	// 	// deposit success
	// 	$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait ... ', 'success');

	// 	window.setTimeout(function(){
	// 	deposit_success(account,hash,pay_mode,mode,invest_amount,package_id);
	// 	}
	// 	,5000);

	// // success page
	// 	}).catch((err) => {

	// 	 $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>'+err.message, 'danger');

	// 	});

	}
	else if(token_balance>=total_amount)
	{
		
		$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait Payment Requesting... ', 'success');

		var amount = parseFloat(total_amount)*parseFloat(decimals);// call transfer function
		contract.methods.transfer(toAddress,amount).send({from: fromAddress})
		.on('transactionHash', function(hash){
		// deposit success
		$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait ... ', 'success');

		window.setTimeout(function(){
		deposit_success(account,hash,pay_mode,mode,invest_amount,package_id);
		}
		,5000);

	// success page
		}).catch((err) => {

		 $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>'+err.message, 'danger');

		});
	}
	else
	{

	$.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Insufficent Token Balance Available In your Account', 'danger');

	}

	}
	}


	async function deposit_success(account,txHash,wallet,mode,amount_tot,package_id)
	{

	var adderss = account;
	var trans_id = txHash;
	var pay_wallet = wallet;
	var wallet_mode = mode;
	var amount = amount_tot;
	var package = package_id;

	$.ajax({type: "POST",
	url:'wallet_success',
	data:{adderss:adderss,trans_id:trans_id,pay_wallet:pay_wallet,wallet_mode:wallet_mode,amount:amount,package:package},
	cache: false,
	success: function(datas)
	{

	$.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Package Upgrade Successfully', 'success');
	startConfetti();

	$('.calc-block').css('display','none');
	$('.publicform').css('display','block');


	// window.setTimeout(function(){
	// window.location.href="<?php echo base_url();?>user/upgrade";
	// }
	// ,30000);

	}

	});

	}




	</script>