  
  $(document).ready( async function(){


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

var balance= await web3.eth.getBalance(accounts[0]);
document.querySelector("#balance").innerHTML = parseFloat(balance/1000000000000000000)
  

  });
  } catch (error) {
  $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> User rejected permission!', 'danger');
  document.querySelector("#deposit_wallet").textContent = "Please Connect Wallet";
   document.querySelector("#conect_wallet").style.display = "inline-block";
  }
}
  else {
  // $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Please Connect Wallet! ', 'danger');
  document.querySelector("#deposit_wallet").textContent = "Please Connect Wallet";
  document.querySelector("#deposit_wallet").style.display = "none";
  document.querySelector("#conect_wallet").style.display = "inline-block";
  }

  });




 async function connect()
 {

    if (window.ethereum) {
  window.web3 = new Web3(window.ethereum);
  try {
 
 
  ethereum.enable().then( async res =>{

  var accounts = await web3.eth.getAccounts();
  window.web3.eth.defaultAccount = accounts[0];

  $.notify('<strong>Success:</strong> Wallect Connect Successflly', 'success');
  
  document.querySelector("#view_wallet").style.display = "inline-block";
  document.querySelector("#deposit_wallet").style.display = "inline-block";
  document.querySelector("#conect_wallet").style.display = "none";
  document.querySelector("#wallet_adderss").textContent = accounts[0];
  document.querySelector("#deposit_wallet").value = "Deposit";  
 
 
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
