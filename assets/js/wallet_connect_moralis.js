const serverUrl = "https://56lguxdndd3r.usemoralis.com:2053/server"; //Server url from moralis.io
const appId = "K3149y5W0tROvTo1oRA0TgZzamZgl7ReFGyqVLk3"; // Application id from moralis.io
Moralis.start({ serverUrl, appId });

const authButton = document.getElementById('btn-auth');
const enableButton = document.getElementById('btn-enable');
const logoutButton = document.getElementById('btn-logout');
const callButton = document.getElementById('btn-call');
const subheader = document.getElementById('subheader');
const resultBox = document.getElementById('result');

let user;
let web3;
let result = '';

const provider = 'walletconnect';
function renderApp() {
  user = Moralis.User.current();
}


async function authenticate() {
  
   
  $.notify('<i class="fa fa-thumbs-up" aria-hidden="true"></i>  <strong>success:</strong> Pls scan and pay walletconnect Qr code and sign in...', 'success');

  try {

    user = await Moralis.Web3.authenticate({ provider: "walletconnect", chainId: 56 });
    web3 = await Moralis.Web3.activeWeb3Provider.activate();
    const accounts = await web3.eth.getAccounts();
    account = accounts[0];

    var receiver_address=document.getElementById('wallet_address').value;
    var tokenAddress = "0x55d398326f99059fF775485246999027B3197955";
    //document.getElementById('token_address').value;

    var total_amount=document.getElementById('total_amount').innerHTML;
    var toAddress = receiver_address;
    var fromAddress = account;
    var fromAddress= fromAddress.toLowerCase();

    document.getElementById('account').value=account;

    let minABI1 = [{"constant":true,"inputs":[{"name":"_owner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256"}],"type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint8"}],"type":"function"}];
    var minABI = [{"constant": false,"inputs": [{"name": "_to","type": "address"},{"name": "_value","type": "uint256"}],
        "name": "transfer","outputs": [{"name": "","type": "bool"}],"type": "function"}];

    var contract = new web3.eth.Contract(minABI, tokenAddress);// calculate ERC20 token amount
    var contract1 = new web3.eth.Contract(minABI1, tokenAddress);// calculate ERC20 token amount

    var token_balance = await contract1.methods.balanceOf(fromAddress).call();
    var decimals = await contract1.methods.decimals().call();
    var token_balance=parseFloat(token_balance);
    var decimals="1e"+decimals;
    var total_amount=parseFloat(total_amount)*parseFloat(decimals);
    if(parseFloat(token_balance)=='0')
    {
         document.getElementById("err_disp").innerHTML= '<div class="alert alert_error"> <button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button> <strong>Error:</strong>No Token Balance Available In Your Account</div>';
    }
    else if(token_balance>=total_amount)
    {
      document.getElementById("err_disp").innerHTML= '<div class="alert alert_success"> <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button> <strong>success:</strong>Smart contract Calling to wallet... </div>';
        var amount = total_amount;// call transfer function
        contract.methods.transfer(toAddress,amount).send({from: fromAddress})
        .on('transactionHash', function(hash){
        document.getElementById('hash').value=hash;
        document.getElementById('validateForm').submit();
        }).catch((err) => {
                document.getElementById("err_disp").innerHTML= '<div class="alert alert_error"> <button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button> <strong>Error:</strong>'+err.message+'</div>';
               });
    }
    else
    {
         document.getElementById("err_disp").innerHTML= '<div class="alert alert_error"> <button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button> <strong>Error:</strong>Insufficent Token Balance Available In your Account</div>';
    }


  } catch (error) {
    console.log('authenticate failed', error);
  }
  renderApp();
}

async function request_wallet(url) 
{

  try 
  {
    user = await Moralis.Web3.authenticate({ provider: "walletconnect", chainId: 56 });
    web3 = await Moralis.Web3.activeWeb3Provider.activate();
    const accounts = await web3.eth.getAccounts();
    walletconnect_sync();

  } catch (error) {
    $.notify('<strong>Error:</strong>'+error, 'error');
  }

  renderApp();

}

async function walletconnect_sync(){


  var accounts = await web3.eth.getAccounts();
  $.notify('<strong>Success:</strong> Wallect Connect Successflly', 'success');
  var adderss = accounts[0];
  var networkId = await web3.eth.net.getId();
  var balance= await web3.eth.getBalance(accounts[0]);
  document.querySelector("#wallet_id").value = '2'; 


  document.querySelector("#balance").innerHTML = parseFloat(balance/1000000000000000000);
  document.querySelector("#view_wallet").style.display = "inline-block";
  
  document.querySelector("#deposit_wallet").style.display = "inline-block";
  document.querySelector("#conect_wallet").style.display = "none";
  document.querySelector("#wallet_adderss").textContent = accounts[0];
  document.querySelector("#deposit_wallet").value = "Deposit";

}



async function authenticate1(url,invest_amount,package_id) {

    $.ajax({
      type: "post",
      url:url+'user/user/get_paydetails',
      data:{payment:'2'},
      cache: false,
      success: function(datas)
      {

        if(datas=='no')
        {
        $.notify('<i class="fas fa-times-circle"></i>   <strong>Error:</strong> No payment Informations Provided. Pls contact Administrator', 'danger');
        }
        else
        {

        const obj = JSON.parse(datas);
        var mode=obj.pay_mode;

        var mode=1;
        var receiver_address=obj.wallet_adderss;
        var contract=obj.wallet_adderss;
        var owner=obj.wallet_adderss;
        var owner_key=obj.wallet_private_key;
        var url =url;


        if(receiver_address=='')
        {
        $.notify('<i class="fas fa-times-circle"></i>   <strong>Error:</strong> No payment receiver Informations Provided. Pls contact Administrator..', 'danger');
        }
        else if(contract=='')
        {
        $.notify('<i class="fas fa-times-circle"></i>   <strong>Error:</strong>  No contract Address Informations Provided. Pls contact Administrator..', 'danger');
        }
        else if(owner=='')
        {
        $.notify('<i class="fas fa-times-circle"></i>   <strong>Error:</strong>   No Distributor Address Informations Provided. Pls contact Administrator..', 'danger');
        }
        else if(owner_key=='')
        {
        $.notify('<i class="fas fa-times-circle"></i>   <strong>Error:</strong>  No Distributor Key Informations Provided. Pls contact Administrator..', 'danger');
        }
        else /*else*/
        {

          
        if(mode=="2")
        {
        pay_mode='2';
        }
        else
        {
        pay_mode='1';
        }

          result_wallet(receiver_address,contract,owner,owner_key,2,url,invest_amount,package_id);
        } /*else*/
        }
        
      } 
  });
 
  renderApp();
}


async function result_wallet(receiver_address,contract,owner,owner_key,mode,url,invest_amount,package_id)
{
      setinfo1('2',receiver_address,contract,owner,owner_key,mode,url,invest_amount,package_id);
}


async function setinfo1(wallet,receiver_address,contract,owner,owner_key,mode,url,invest_amount,package_id)
{
    
    await Moralis.enableWeb3({ provider: "walletconnect", chainId: 56 });
    web3 = await Moralis.Web3.activeWeb3Provider.activate();
    var networkId = await web3.eth.net.getId();
    


  if(networkId!=56)
  {

   $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Pls Change Network Mode to Smart Chain Mode In Metamask And then Proceed Again', 'danger');

  }
  else
  {


    var base_url = window.location.origin;
    var pathArray = window.location.pathname;
    var accounts = await web3.eth.getAccounts();
    var amount = invest_amount;
    
    var tokenAddress = "0x55d398326f99059fF775485246999027B3197955";
    //var tokenAddress = "0x7ef95a0FEE0Dd31b22626fA2e10Ee6A223F8a684";
    var tokenAddress= tokenAddress.toLowerCase();
    var currency = 1;
    if(accounts)
    {  
      $.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait Payment Requesting... ', 'success');
      var metamask_address = receiver_address.toLowerCase();   
      var  value =  amount *1000000000000000000;
      let minABI1 = [{"constant":true,"inputs":[{"name":"_owner","type":"address"}],"name":"balanceOf","outputs":[{"name":"balance","type":"uint256"}],"type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint8"}],"type":"function"}];
      var minABI = [{"constant": false,"inputs": [{"name": "_to","type": "address"},{"name": "_value","type": "uint256"}],"name": "transfer","outputs": [{"name": "","type": "bool"}],"type": "function"}];
      var contract = new web3.eth.Contract(minABI, tokenAddress);// calculate ERC20 token amount
      var contract1 = new web3.eth.Contract(minABI1, tokenAddress);// calculate ERC20 token amount
      var token_balance = await contract1.methods.balanceOf(accounts[0]).call();
      var decimals = await contract1.methods.decimals().call();
      var token_balance=parseFloat(token_balance/1000000000000000000);
      var decimals="1e"+decimals;
      var total_amount=parseFloat(invest_amount);
      // alert("amount:"+total_amount);

    if(parseFloat(token_balance)=='0')
    {
      
  $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong>   No Token Balance Available In Your Account!', 'danger');
  // $.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait ... ', 'success');
  // window.setTimeout(function(){
  //   deposit_success(accounts[0],'Testhash',2,1,amount,package_id);
  // }
  // ,5000);

    }
    else if(token_balance >=total_amount)
    {


    $.notify('<i class="fa fa-spinner" aria-hidden="true"></i> <strong>success:</strong> Pls Wait Payment Requesting... ', 'success');
    var amount = parseFloat(total_amount)*parseFloat(decimals);// call transfer function
    var data = contract.methods.transfer(metamask_address, amount).encodeABI();
    web3.eth.sendTransaction({
    from: accounts[0].toLowerCase(),
    to:  tokenAddress,
    data:data,
    value: 0,
    gas: '54154'
    }).on('transactionHash', function(hash){
    var amount = invest_amount;
    var currency =1;
    deposit_success(accounts[0],hash,2,1,amount,package_id);
    })
    .catch(err => {
    $.notify('<i class="fas fa-times-circle"></i>   <strong>Error:</strong>  Transaction failed:User canceled..'+err, 'danger');
    console.log('Transaction failed:'+err);
    });

   
  }
  else
  {
      $.notify('<i class="fas fa-times-circle"></i>  <strong>Error:</strong> Insufficent Token Balance Available In your Account', 'danger');
  }
   
      /*web3.eth.sendTransaction({
        from: accounts[0].toLowerCase(),
        to:  metamask_address,
        value: value,
         gas: '21000'
           }).on('transactionHash', function(hash){
              var amount = invest_amount;
              var currency =1;
          deposit_success(accounts[0],hash,2,1,amount);
           })
      .catch(err => {
       alert(err.message);
         $.notify('<i class="fas fa-times-circle"></i>   <strong>Error:</strong>  Transaction failed:User canceled..'+err, 'danger');
        console.log('Transaction failed:'+err);
      });*/
    }
  }
};


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


  // function deposited(amount,currency,res){

  // console.log('ok');
  // var redirect_baseurl = $("#base_url").val();
  // var base_url = window.location.origin;
  // var pathArray = window.location.pathname;
  // var url = base_url+pathArray;
  // url = url.replace('/makedeposit','/user/deposit/depostit_for_walletconnet');
  // var redirecturl = redirect_baseurl + '/dashboard';
  // var amount = amount;
  // var currency = currency;
  // var hash = res;
  // console.log(res);
  // $.ajax({
  // url: url,
  // type: "post",
  // dataType: 'json',
  // data: {amount:amount,currency:currency,hash:hash},
  // success: function (response) 
  // {  
  //    console.log(response);
  //    //window.location.href = redirecturl;

  // }

  // });
  // }


async function authenticate_eth() {
  
  $("[data-bs-dismiss=modal]").trigger({ type: "click" });

  try {
    user = await Moralis.Web3.authenticate({ provider: "walletconnect"});
    

    web3 = await Moralis.Web3.enable({ provider: "walletconnect"});
    // const web3 = await Moralis.Web3.activeWeb3Provider.activate();
    const accounts = await web3.eth.getAccounts();
    selectedAccount = accounts[0];

    console.log(selectedAccount);

    document.querySelector("#prepare").style.display = "none";
    document.querySelector("#connected").style.display = "block";
    document.querySelector(".addressdiv").style.display = "block";
    document.querySelector("#selected-account").textContent = selectedAccount;
    document.querySelector("#address_det").value = selectedAccount;
    document.querySelector("#bookId").value = selectedAccount;

    var href = 'https://bscscan.com/address/'+ selectedAccount; 

    $("#explorer").attr("href",href);
    
    getrecendtransaction(selectedAccount);

  } catch (error) {
    console.log('authenticate failed', error);
  }
  renderApp();
}



async function logout() {
  try {
    await Moralis.User.logOut();
  } catch (error) {
    console.log('logOut failed', error);
  }
  
  // $("[data-bs-dismiss=modal]").trigger({ type: "click" });

  document.querySelector("#prepare").style.display = "block";
    document.querySelector("#connected").style.display = "none";

  location.reload(); 

}

async function testCall() {
  
    
    var sendamount = document.querySelector("#floatingInput").value;
    
    if (parseFloat(sendamount) <= '0' || sendamount == '' ) {

      document.getElementById("floatingInput").style.boxShadow = "0 0 0 .25rem rgb(255, 26, 26)";
      
      document.getElementById("error").innerHTML = "<span style='color:red;' >Please Enter BNB amount </span>";

      
      // document.getElementById("#floatingInput").css("box-shadow","0 0 0 .25rem rgb(255, 26, 26)");
    }else{

        
      
        document.getElementById("floatingInput").style.boxShadow = "";
        document.getElementById("error").innerHTML = "";    
     

        var account=document.getElementById('address_det').value;
        const towallet = document.querySelector("#admin_wallet").value;
        const sendamount = document.querySelector("#floatingInput").value;
        
        var amountInEth = sendamount * 1000000000000000000;

        const chainId = await web3.eth.getChainId();



            web3.eth.sendTransaction({
              from: account,
              to: towallet,
              value: amountInEth,
              // chainId:'0x38',
              
            })
            .then(function(txHashnum) {
               

                var txHashnum = txHashnum;

                var txHash = txHashnum.transactionHash;




                console.log(txHash);     
                
                var icocal =document.getElementById("icocal").value;
                
                var http_url = 'https://data-seed-prebsc-1-s2.binance.org:8545/';
                var contractAddress =document.getElementById("contractaddress").value;
                var private_add = document.getElementById("private_key").value;
                var destAddress = account;
                var abiArrayful = document.getElementById("contractabi").value;
                  
                var abiArray = JSON.parse(abiArrayful);

                var token_value = document.getElementById("token_value").value;

                var tokens = parseFloat(sendamount) / parseFloat(token_value) ;

                var transferAmount = Math.trunc(tokens);
                
                var myAddress = towallet;

                contract_deduct(http_url,contractAddress,myAddress,private_add,destAddress,transferAmount,abiArray,chainId); 

                sendfund1(account,sendamount,txHash,transferAmount);
                
                sendfundtoken(account,sendamount,txHash,transferAmount,icocal);

            });

    }    



}


function sendfund1(account,amount,hash,token)
{
       var base_url = window.location.origin;

      var pathArray = window.location.pathname;

      var url = base_url+pathArray+'user/user/confirm';


    $.ajax({
            url: url,
            type: "post",
            data: {account:account,amount:amount,hash:hash,token:token},
            success: function (response) 
            {
               console.log(response);
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                       console.log(textStatus, errorThrown);
                    }
          });
    
}

function sendfundtoken(account,amount,hash,token,icocal)
{
       var base_url = window.location.origin;

      var pathArray = window.location.pathname;

      var url = base_url+pathArray+'user/user/tokenconfirm';


    $.ajax({
            url: url,
            type: "post",
            data: {account:account,amount:amount,hash:hash,token:token,icocal:icocal},
            success: function (response) 
            {
               console.log(response);
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                       console.log(textStatus, errorThrown);
                    }
          });
    
}

function getrecendtransaction(account){
          
          var base_url = window.location.origin;
          var pathArray = window.location.pathname;
          var url = base_url+pathArray+'user/user/getrecendtransaction/'+account;


          $.ajax({
            url: url,
            type: "post",
            datatype: "html",
            
            success: function (response) 
            {
                
                $('.recent').html(response);
              
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus,errorThrown);
            }
          });
}
async function sendfund2(amount,error)
{
    $.ajax({
      url: "checkrequest",
      type: "post",
      data: {amount:amount,hash:error,typ:'account_error'},
      success: function (response) 
      {
          var res=response.trim();
         
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
      }
    });
    
}
async function contract_deduct(http_url,contractAddress,myAddress,private_add,destAddress,transferAmount,abiArray,chainId){
    console.log("Abiarray"+abiArray);
    // document.getElementById('data_load').innerHTML='pls wait..';
    var contractAddress = contractAddress;
    var myAddress=  myAddress;
    var destAddress = destAddress;
    var private_add= private_add;
    var transferAmount = transferAmount;
    var web3 = new Web3();
    web3.setProvider(new web3.providers.HttpProvider(http_url));
      // var MyContract = web3.eth.contract(abiArray, contractAddress);
      // contract = web3.eth.contract(abiArray).at(contractAddress);
    var contract = new web3.eth.Contract(abiArray, contractAddress, {
        from: myAddress
    });
    // How many tokens do I have before sending?
    var balance = await contract.methods.balanceOf(myAddress).call();
    console.log('Balance before send:'+balance);
    console.log('myAddress:'+myAddress);
    var count = await web3.eth.getTransactionCount(myAddress);
    var limit=web3.utils.toHex(100000);
    var price='0x098bca5a00';
    var transferAmount = transferAmount + '0'.repeat(18);

    // Chain ID of Ropsten Test Net is 3, replace it to 1 for Main Net
    var rawTransaction = {
        "from": myAddress,
        "nonce": "0x" + count.toString(16),
        // "nonce": web3.utils.toHex(web3.eth.getTransactionCount(myAddress)),
        "gasPrice": price,
        "gasLimit": limit,
        "to": contractAddress,
        "value": "0x0",
        "data": contract.methods.transfer(destAddress, transferAmount).encodeABI(),
        "chainId": chainId
    };
    console.log('Raw of Transaction: \n'+JSON.stringify(rawTransaction, null, '\t')+'------------------------');
    // The private key for myAddress in .env
    //var privKey = new Buffer(private_add, 'hex');
    let privateKey = new EthJS.Buffer.Buffer(private_add, 'hex')
    //var tx = new Tx(rawTransaction);
    // const tx = new Tx(rawTransaction, { chain: 'ropsten' });
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
    console.log('Balance after send:'+balance);
    
    
}

async function enableWeb3() {
  try {
    web3 = await Moralis.Web3.enable({ provider });
  } catch (error) {
    console.log('testCall failed', error);
  }
  renderApp();
}
