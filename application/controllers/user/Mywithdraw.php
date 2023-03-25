	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Mywithdraw extends CI_Controller {

	/**
	* Index Page for this controller.
	*
	* Maps to the following URL
	* 		http://example.com/index.php/welcome
	*	- or -
	* 		http://example.com/index.php/welcome/index
	*	- or -
	* Since this controller is set as the default controller in
	* config/routes.php, it's displayed at http://example.com/
	*
	* So any other public methods not prefixed with an underscore will
	* map to /index.php/welcome/<method_name>
	* @see https://codeigniter.com/user_guide/general/urls.html
	*/
	public function __construct() {
	parent::__construct();
	/*if($this->session->userdata('logged_in') && $this->session->userdata('user_login')) {*/
	// $this->load->helper('url');
	// // Load form helper library
	// $this->load->helper('form');

	// // Load form validation library
	// $this->load->library('form_validation');

	// // Load session library
	// $this->load->library('session');

	$this->load->helper('cookie');

	// Load database

	$this->load->model('user/mywithdraw_model');
	$this->lang->load('user/mywithdraw',$this->session->userdata('language'));
	$this->lang->load('user/common',$this->session->userdata('language'));
	/*}  else {
	redirect('login');
	}*/
	}

	public function password_check()
	{
	//$condition = "MemberId =" . "'" . $this->session->userdata('MemberID'). "' AND TransactionPassword =" . "'" . sha1(sha1($this->input->post('password'))). "' AND UserType='3'";

	$condition = "MemberId =" . "'" . $this->input->post('memberid'). "' AND TransactionPassword =" . "'" . sha1(sha1($this->input->post('password'))). "' AND UserType='3'";

	$this->db->select('*');
	$this->db->from('arm_members');
	$this->db->where($condition);
	$query = $this->db->get();

	if ($query->num_rows()>0) {
	return true; 
	} else {
	$this->form_validation->set_message('password_check', '<p><em class="state-error1">'.ucwords($this->lang->line('errorpassword')).'</em></p>');
	return false;
	}

	}

	public function index()
	{

	$condition ="MemberId='".$this->session->MemberID."' AND TypeId='7'";
	$this->data['wlimit'] = $this->common_model->getRowCount($condition,"arm_history");
	$this->data['withdrawdaylimit'] = $this->mywithdraw_model->Getdata('withdrawdaylimit');
	$this->data['withType'] =$this->mywithdraw_model->Getdata('withdrawtype');

	if($this->data['withType']=="weekly")
	{
		 $this->data['withdrawdate'] = $this->mywithdraw_model->Getdata('withdrawdate');
		 $this->data['date_count'] = date('w');

		if($this->data['withdrawdate']==$this->data['date_count'])
		{

$this->data['check_day_count'] = $this->db->query("SELECT  * from arm_history where  DATE(DateAdded) =DATE('".date('Y-m-d 21:00:00')."') and TypeId='8' AND MemberId='".$this->session->MemberID."'  ")->num_rows();
	
	if($this->data['check_day_count'] >= $this->data['withdrawdaylimit'])
	{
	$this->data['check_with_date'] = '0';
	}
	else
	{
	$this->data['check_with_date'] = '1';
	}

		}
		else
		{
				if($this->data['withdrawdate']==1)
				{
				 $days = "Monday";
				}
				if($this->data['withdrawdate']==2)
				{
				 $days = "Tuesday";
				}
				if($this->data['withdrawdate']==3)
				{
				 $days = "Wednesday";
				}
				if($this->data['withdrawdate']==4)
				{
				 $days = "Thursday";
				}
				if($this->data['withdrawdate']==5)
				{
				 $days = "Friday";
				}
				if($this->data['withdrawdate']==6)
				{
				 $days = "Saturday";
				}
				if($this->data['withdrawdate']==7)
				{
				 $days = "Sunday";
				}

		   $this->data['error_info'] = "Withdraw is only allow ".$days;	
		}

	}
	else
	{

	$this->data['check_day_count'] = $this->db->query("SELECT  * from arm_history where  DATE(DateAdded) =DATE('".date('Y-m-d 21:00:00')."') and TypeId='8' AND MemberId='".$this->session->MemberID."'  ")->num_rows();

		if($this->data['check_day_count'] >= $this->data['withdrawdaylimit'])
		{
		   $this->data['check_with_date'] = '0';
		}
		else
		{
		   $this->data['check_with_date'] = '1';
		}

	}

	if($this->input->post())
	{

	$withdrawstatus = $this->mywithdraw_model->Getdata('withdrawstatus');
	$withdrawdaylimit = $this->mywithdraw_model->Getdata('withdrawdaylimit');
	$condition ="MemberId='".$this->session->MemberID."' AND TypeId='7'";
	$wlimit = $this->common_model->getRowCount($condition,"arm_history");

    $withdrawdaylimit = 100;
	if($withdrawstatus==1)
	{

	if($withdrawdaylimit)
	{

	$this->form_validation->set_rules('dedutedamount', 'dedutedamount', 'trim|required|numeric|callback_balance_check');
	$this->form_validation->set_rules('description', 'description', 'trim|required');


	$paythrough=$this->input->post('paythrough');
	$paythrough1=$this->input->post('paythrough1');
	$offlinepaymode=$this->input->post('offlinepaymode');

	if ($offlinepaymode==1) {
	$this->form_validation->set_rules('paythrough', 'paythrough', 'trim|required');
	}
	if ($offlinepaymode==2) {
	$this->form_validation->set_rules('paythrough1', 'paythrough', 'trim|required');
	$this->form_validation->set_rules('paymentsaddress', 'paymentsaddress', 'trim|required');
	}

	$this->form_validation->set_rules('withdrawamount', 'withdrawamount', 'trim|required|numeric|callback_balance_check');	

	if($paythrough=='12')
	{
	$this->form_validation->set_rules('paynumber','paynumber','trim|required');
	}


	$withstaus = $this->common_model->GetRow("Page='usersetting' AND KeyValue='withdrawpassordstatus'", "arm_setting");
	if($withstaus->ContentValue == 1) 
	$this->form_validation->set_rules('password', 'password', 'trim|required|callback_password_check');


	if ($this->form_validation->run() == TRUE) 
	{ 


$paythrough1 = '1';
	// check the paymethod yes or no

	$memberid=$this->input->post('memberid');
	$memdt 	= $this->common_model->GetRow("MemberId='".$memberid."'","arm_members");

	$cusdet = json_decode($memdt->CustomFields);	

	$gets = $this->db->query("select * from arm_paymentsetting where PaymentId='".$paythrough."'")->row();

	$payment_name = $gets->PaymentName;




	$paymentdet = $this->db->query("select * from arm_members where MemberId='".$memberid."'")->row();

	// echo $this->db->last_query();
	// print_r($paymentdet);
	// exit();


	$paymentdetails =  $paymentdet->CustomFields;



	$decodes =  json_decode($paymentdetails);



	$payments = "";




	foreach ($decodes as $key => $value) 
	{



	if(strtolower($payment_name)==strtolower($key))
	{


	$payments.=$value;


	}
	}




	if($payments!="")
	{


	if($paythrough=='5')
	{
			$bitcoin=$decodes->$paymentdetails;
			if($bitcoin!="")
			{
				$paynumber=$this->input->post('paynumber');
				$address=$this->input->post('address');

				$data=array('withdrawMpesaNumber'=>$paynumber);
				$memberid=$this->session->MemberID;
				$cond="MemberId='".$memberid."'";
				$updatemembers=$this->common_model->UpdateRecord($data,$cond,"arm_members");

				$date =date('y-m-d h:i:s');

				$senmemberbal 	= $this->common_model->Getcusomerbalance($memberid);
				$memdetail = $this->common_model->GetRow("MemberId='".$memberid."'","arm_members");
				$memdt 	= $this->common_model->GetRow("MemberId='".$memberid."'","arm_members");
				$adminfee=$this->input->post('fee');

				$cusdet = json_decode($memdt->CustomFields);

				$tnxid = "Bankwire : ".$cusdet->bankwirename."<br> Bankwire Ac no : ".$cusdet->bankwireacno;

				$Wtranid = "WTH".rand(111111,9999999);
				$Atranid = "ADM".rand(111111,9999999);

				$sdata =array(
				'MemberId'=>$memberid,
				'Debit'=>$this->input->post('withdrawamount'),
				'Balance'=>$senmemberbal-$this->input->post('withdrawamount'),
				'TypeId'=>7,
				
				'Description'=>$this->input->post('description'),
				'DateAdded'=>$date,
				'paythrough'=>$this->input->post('paythrough'),
				'TransactionId'=>$Wtranid
				);
				//withdraw token
				$desc="Withdraw Token Rewards";
				$Wtranid1 = "TOKWTH".rand(111111,9999999);

				$sdata1 =array(
				'MemberId'=>$memberid,
				'Debit'=>$this->input->post('withdrawamount'),
				'Balance'=>$senmemberbal-$this->input->post('withdrawamount'),
				'TypeId'=>54,
				'Credit'=>$this->input->post('total_tokenfee'),
				'Description'=>$desc,
				'DateAdded'=>$date,
				'TransactionId'=>$Wtranid1
				);

				if($paythrough==12)
				{
					$sdata['WithdrawMpesanumber']=$paynumber;
					$sdata1['WithdrawMpesanumber']=$paynumber;
				}
				if($paythrough==14)
				{
					$sdata['address']=$address;
					$sdata1['address']=$address;
				}

				$sresult = $this->common_model->SaveRecords($sdata,'arm_history');
				$sresult1 = $this->common_model->SaveRecords($sdata1,'arm_history');


				// after admin accept admin fee calculates in admin side not here 
				$Atranid1 = "TOKWITHADM".rand(111111,9999999);
				$desc1="Admin Accept Withdraw Token Rewards";
				$adata =array(
				'TypeId'=>10,
				'Description'=>ucwords($this->lang->line('adminfeedes')),
				'DateAdded'=>$date,
				'TransactionId'=>$Atranid
				);
				//token for admin accept withdraw
				$adata1 =array(
				'TypeId'=>55,
				'Description'=>$desc1,
				'DateAdded'=>$date,
				'TransactionId'=>$Atranid1
				);

				$senmemberbal1		= $this->common_model->Getcusomerbalance($memberid);
				$adata['MemberId'] 	= $memberid;
				$adata['Debit'] 	= $this->input->post('adminfee');
				$adata['Balance']	= $senmemberbal1-$this->input->post('adminfee');

				$adata1['MemberId'] 	= $memberid;
				$adata1['Debit'] 	= $this->input->post('adminfee');
				$adata1['Balance']	= $senmemberbal1-$this->input->post('adminfee');
				$adata1['Credit'] 	= $this->input->post('total_tokenfee');


				$aresult = $this->common_model->SaveRecords($adata,'arm_history');
				$aresult1 = $this->common_model->SaveRecords($adata1,'arm_history');



				if($sresult)// && $aresult
				{
					if($this->input->post('web_mode')=='1')
					{
					$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
					}
					else
					{
					header("Content-Type: application/json");
					$response['success']='1';
					$response['message']=$this->lang->line('successmessage');
					$response['redirect']='user/mywithdraw';
					echo json_encode($response);
					}

				}	
				else
				{
					if($this->input->post('web_mode')=='1')
					{
					$this->session->set_flashdata('error_message', $this->lang->line('errormessage'));
					}
					else
					{
					header("Content-Type: application/json");
					$response['success']='0';
					$response['message']=$this->lang->line('errormessage');
					$response['redirect']='user/mywithdraw';
					echo json_encode($response);
					}


				}
				/*$condition = "PaymentStatus='1'";
				$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
				$this->load->view('user/mywithdraw',$this->data);*/
			}
			else
			{
				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata("error_message","Please Update the Bitcoin address");
					redirect("user/mywithdraw");

				}
				else
				{
					header("Content-Type: application/json");
					$response['success']='0';
					$response['message']="Please Update the Bitcoin address";
					$response['redirect']='user/mywithdraw';
					echo json_encode($response);
					exit;
				}
			}
	}
	elseif ($paythrough==13)
	{
		$eth=$decodes->$paymentdetails;
		if($eth!="")
		{
			$paynumber=$this->input->post('paynumber');
			$data=array('withdrawMpesaNumber'=>$paynumber);
			$memberid=$this->session->MemberID;
			$cond="MemberId='".$memberid."'";
			$updatemembers=$this->common_model->UpdateRecord($data,$cond,"arm_members");

			$date =date('y-m-d h:i:s');

			$senmemberbal 	= $this->common_model->Getcusomerbalance($memberid);
			$memdetail = $this->common_model->GetRow("MemberId='".$memberid."'","arm_members");
			$memdt 	= $this->common_model->GetRow("MemberId='".$memberid."'","arm_members");
			$adminfee=$this->input->post('adminfee');

			$cusdet = json_decode($memdt->CustomFields);

			$tnxid = "Bankwire : ".$cusdet->bankwirename."<br> Bankwire Ac no : ".$cusdet->bankwireacno;

			$Wtranid = "WTH".rand(111111,9999999);
			$Atranid = "ADM".rand(111111,9999999);

			$Wtranid1 = "TOCWTH".rand(111111,9999999);
			$Atranid1 = "WITHPADM".rand(111111,9999999);

			$sdata =array(
			'MemberId'=>$memberid,
			'Debit'=>$this->input->post('withdrawamount'),
			'Balance'=>$senmemberbal-$this->input->post('withdrawamount'),
			'TypeId'=>7,
			// 'TransactionId'=>$tnxid,
			'Description'=>$this->input->post('description'),
			'DateAdded'=>$date,
			'paythrough'=>$this->input->post('paythrough'),
			'TransactionId'=>$Wtranid
			);

			//payumoney insert withdrawtoken
			$descp="Withdraw Token  Rewardsp";

			$sdata1 =array(
			'MemberId'=>$memberid,
			'Debit'=>$this->input->post('withdrawamount'),
			'Balance'=>$senmemberbal-$this->input->post('withdrawamount'),
			'TypeId'=>54,
			'Credit'=>$this->input->post('total_tokenfee'),
			'Description'=>$descp,
			'DateAdded'=>$date,
			'paythrough'=>$this->input->post('paythrough'),
			'TransactionId'=>$Wtranid1
			);

			if($paythrough==12)
			{
				$sdata['WithdrawMpesanumber']=$paynumber;
				$sdata1['WithdrawMpesanumber']=$paynumber;
			}

			$sresult = $this->common_model->SaveRecords($sdata,'arm_history');
			$sresult1 = $this->common_model->SaveRecords($sdata1,'arm_history');


			// after admin accept admin fee calculates in admin side not here 
			$desc1="Admin Accept Withdraw Token Rewardsp";
			$adata =array(
			'TypeId'=>10,
			'Description'=>ucwords($this->lang->line('adminfeedes')),
			'DateAdded'=>$date,
			'TransactionId'=>$Atranid
			);

			$adata1 =array(
			'TypeId'=>55,
			'Description'=>$desc1,
			'DateAdded'=>$date,
			'TransactionId'=>$Atranid1
			);


			$senmemberbal1		= $this->common_model->Getcusomerbalance($memberid);
			$adata['MemberId'] 	= $this->session->MemberID;
			$adata['Debit'] 	= $this->input->post('adminfee');
			$adata['Balance']	= $senmemberbal1-$this->input->post('adminfee');

			$adata1['MemberId'] 	= $this->session->MemberID;
			$adata1['Debit'] 	= $this->input->post('adminfee');
			$adata1['Credit'] 	= $this->input->post('total_tokenfee');
			$adata1['Balance']	= $senmemberbal1-$this->input->post('adminfee');


			$aresult = $this->common_model->SaveRecords($adata,'arm_history');
			$aresult1 = $this->common_model->SaveRecords($adata1,'arm_history');



			if($sresult)// && $aresult
			{
				if($this->input->post('web_mode')=='1')
				{
				$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
				}
				else
				{									
				header("Content-Type: application/json");
				$response['success']='1';
				$response['message']=$this->lang->line('successmessage');
				$response['redirect']='user/mywithdraw';
				echo json_encode($response);
				exit;
				}
			//$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
			}	
			else
			{
				if($this->input->post('web_mode')=='1')
				{
				}
			header("Content-Type: application/json");
			$response['success']='0';
			$response['message']=$this->lang->line('errormessage');
			$response['redirect']='user/mywithdraw';
			echo json_encode($response);

			//$this->session->set_flashdata('error_message', $this->lang->line('errormessage'));
			}
			/*$condition = "PaymentStatus='1'";
			$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
			$this->load->view('user/mywithdraw',$this->data);*/
		}
		else
		{
			if($this->input->post('web_mode')=='1')
			{

			}
			header("Content-Type: application/json");
			$response['success']='0';
			$response['message']="Please Update the ethereumaddress";
			$response['redirect']='user/mywithdraw';
			echo json_encode($response);

			/*$this->session->set_flashdata("error_message","Please Update the ethereumaddress");
			redirect("user/mywithdraw");*/
		}
	}
	else
	{

			$address=$this->input->post('address');
			$paynumber=$this->input->post('paynumber');
			$data=array('withdrawMpesaNumber'=>$paynumber);
			$memberid=$memberid;
			$cond="MemberId='".$memberid."'";
			$updatemembers=$this->common_model->UpdateRecord($data,$cond,"arm_members");

			$date =date('y-m-d h:i:s');

			$senmemberbal 	= $this->common_model->Getcusomerbalance($memberid);
			$memdetail = $this->common_model->GetRow("MemberId='".$memberid."'","arm_members");
			$memdt 	= $this->common_model->GetRow("MemberId='".$memberid."'","arm_members");
			$adminfee=$this->input->post('fee');

			$cusdet = json_decode($memdt->CustomFields);

			$tnxid = "Bankwire : ".$cusdet->bankwirename."<br> Bankwire Ac no : ".$cusdet->bankwireacno;

			$Wtranid = "WTH".rand(111111,9999999);
			$Atranid = "ADM".rand(111111,9999999);

			$Wtranid1 = "TOCWTH".rand(111111,9999999);
			$Atranid1 = "TOCWITHADM".rand(111111,9999999);

			$sdata =array(
			'MemberId'=>$memberid,
			'Debit'=>$this->input->post('withdrawamount'),
			'Balance'=>$senmemberbal-$this->input->post('withdrawamount'),
			'TypeId'=>7,
			// 'TransactionId'=>$tnxid,
			'Description'=>$this->input->post('description'),
			'DateAdded'=>$date,
			'paythrough'=>$this->input->post('paythrough'),
			'TransactionId'=>$Wtranid
			);

			//insert another payment through

			$sdata1 =array(
			'MemberId'=>$memberid,
			'Debit'=>$this->input->post('withdrawamount'),
			'Balance'=>$senmemberbal-$this->input->post('withdrawamount'),
			'TypeId'=>54,
			'Credit'=>$this->input->post('total_tokenfee'),
			'Description'=>"Withdraw Token Rewards",
			'DateAdded'=>$date,
			'paythrough'=>$this->input->post('paythrough'),
			'TransactionId'=>$Wtranid1
			);

			if($paythrough==12)
			{
			$sdata['WithdrawMpesanumber']=$paynumber;
			$sdata1['WithdrawMpesanumber']=$paynumber;
			}

			if($paythrough==14)
			{
			$sdata['address']=$address;
			$sdata1['address']=$address;
			}

			$sresult = $this->common_model->SaveRecords($sdata,'arm_history');
			$sresult1 = $this->common_model->SaveRecords($sdata1,'arm_history');


			// after admin accept admin fee calculates in admin side not here 

			$adata =array(
			'TypeId'=>10,
			'Description'=>ucwords($this->lang->line('adminfeedes')),
			'DateAdded'=>$date,
			'TransactionId'=>$Atranid
			);

			$adata1 =array(
			'TypeId'=>55,
			'Description'=>"Admin Accept Withdraw Tokenan",
			'DateAdded'=>$date,
			'TransactionId'=>$Atranid1
			);

			$senmemberbal1		= $this->common_model->Getcusomerbalance($memberid);
			$adata['MemberId'] 	= $memberid;
			$adata['Debit'] 	= $this->input->post('adminfee');
			$adata['Balance']	= $senmemberbal1-$this->input->post('adminfee');

			$adata1['MemberId'] 	= $memberid;
			$adata1['Debit'] 	= $this->input->post('adminfee');
			$adata1['Balance']	= $senmemberbal1-$this->input->post('adminfee');
			$adata1['Credit'] 	= $this->input->post('total_tokenfee');


			$aresult = $this->common_model->SaveRecords($adata,'arm_history');
			$aresult1 = $this->common_model->SaveRecords($adata1,'arm_history');



			if($sresult)// && $aresult
			{


				if($this->input->post('web_mode')=='1')
				{
				$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
				$condition = "PaymentStatus='1'";
				$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
				$condition = "status='1'";
				$this->data['payments1'] = $this->common_model->GetResults($condition,'arm_manualpay');
				$this->load->view('user/mywithdraw',$this->data);

				}
				else
				{
				header("Content-Type: application/json");
				$response['success']='1';
				$response['message']=$this->lang->line('successmessage');
				$response['redirect']='user/mywithdraw';
				echo json_encode($response);
				exit;
				}


			}	
			else
			{

				if($this->input->post('web_mode')=='1')
				{

				$this->session->set_flashdata('error_message', $this->lang->line('errormessage'));


				}
				else
				{
				header("Content-Type: application/json");
				$response['success']='0';
				$response['message']=$this->lang->line('errormessage');
				$response['redirect']='user/mywithdraw';
				echo json_encode($response);
				exit;
				}

				$condition = "PaymentStatus='1'";
				$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
				$this->load->view('user/mywithdraw',$this->data);

			}

	}

	}
	elseif ($paythrough1) 
	{
		$currencyconver= $this->input->post('withdrawamount') * $query->currencyrate;


		$memberid=$this->session->MemberID;
		$Wtranid = "WTH".rand(111111,9999999);
		$Wtranid1 = "TOCWTHB".rand(111111,9999999);

		$adminfee=$this->input->post('adminfee');		
		$date =date('y-m-d h:i:s');
		$senmemberbal 	= $this->common_model->Getcusomerbalance($memberid);
		$sdata =array(
		'MemberId'=>$memberid,
		'Debit'=>$this->input->post('withdrawamount'),
		'Balance'=>$senmemberbal-$this->input->post('withdrawamount'),
		'TypeId'=>8,
		// 'TransactionId'=>$tnxid,
		'Description'=>$this->input->post('description'),
		'DateAdded'=>$date,
		'paythrough'=>'30',
		'TransactionId'=>$Wtranid,
		'offlinegateway'=>1,
		'paymentsaddress'=>$this->input->post('paymentsaddress'),
		'currencyconver'=>$currencyconver
		);

		$sdata1 =array(
		'MemberId'=>$memberid,
		'Debit'=>$this->input->post('withdrawamount'),
		'Balance'=>$senmemberbal-$this->input->post('withdrawamount'),
		'TypeId'=>56,
		'Credit'=>$this->input->post('total_tokenfee'),
		'Description'=>"Withdraw Token Rewards",
		'DateAdded'=>$date,
		'paythrough'=>'30',
		'TransactionId'=>$Wtranid1,		
		'paymentsaddress'=>$this->input->post('paymentsaddress')		
		);

		$offresult = $this->common_model->SaveRecords($sdata,'arm_history');
		$offresult1 = $this->common_model->SaveRecords($sdata1,'arm_history');
		$Atranid = "ADM".rand(111111,9999999);
		$Atranid1 = "TOCWITHADM".rand(111111,9999999);
		$adata =array(
		'TypeId'=>10,
		'Description'=>ucwords($this->lang->line('adminfeedes')),
		'DateAdded'=>$date,
		'TransactionId'=>$Atranid
		);

		$adata1 =array(
		'TypeId'=>57,
		'Description'=>"Admin Accept Withdraw Tocken Rewards",
		'DateAdded'=>$date,
		'TransactionId'=>$Atranid1
		);

		$senmemberbal1		= $this->common_model->Getcusomerbalance($memberid);
		$adata['MemberId'] 	= $this->session->MemberID;
		$adata['Debit'] 	= $this->input->post('adminfee');
		$adata['Balance']	= $senmemberbal1-$this->input->post('adminfee');

		$adata1['MemberId'] 	= $this->session->MemberID;
		$adata1['Debit'] 	= $this->input->post('adminfee');
		$adata1['Credit'] 	= $this->input->post('total_tokenfee');
		$adata1['Balance']	= $senmemberbal1-$this->input->post('adminfee');

		$aresult = $this->common_model->SaveRecords($adata,'arm_history');
		$aresult1 = $this->common_model->SaveRecords($adata1,'arm_history');

		header("Content-Type: application/json");
		$response['success']='1';
		$response['message']='ok';
		echo json_encode($response);


		if($offresult)// && $aresult
		{
			if($this->input->post('web_mode')=='1')
			{
				$this->session->set_flashdata('success_message','Payment has been added successfully to your crypto wallet. <strong>Thank You </strong>');
				$condition = "PaymentStatus='1'";
				$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
				$condition = "status='1'";
				$this->data['payments1'] = $this->common_model->GetResults($condition,'arm_manualpay');
				//$this->load->view('user/mywithdraw',$this->data);

			}
			else
			{
				header("Content-Type: application/json");
				$response['success']='1';
				$response['message']=$this->lang->line('successmessage');
				$response['redirect']='user/mywithdraw';
				echo json_encode($response);
				exit;
			}


		}
		else
		{

			if($this->input->post('web_mode')=='1')
			{

				$this->session->set_flashdata('error_message', $this->lang->line('errormessage'));


			}
			else
			{
				header("Content-Type: application/json");
				$response['success']='0';
				$response['message']=$this->lang->line('errormessage');
				$response['redirect']='user/mywithdraw';
				echo json_encode($response);
				exit;
			}

		}
	}
	else
	{

		if($this->input->post('web_mode')=='1')
		{

			$this->session->set_flashdata('error_message',"Update the Account Details in Your Profile Page");
			$condition = "PaymentStatus='1'";
			$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
			$condition = "status='1'";
			$this->data['payments1'] = $this->common_model->GetResults($condition,'arm_manualpay');

			$this->load->view('user/mywithdraw',$this->data);

		}
		else
		{
			header("Content-Type: application/json");
			$response['success']='0';
			$response['message']="Update the Account Details in Your Profile Page";
			$response['redirect']='user/mywithdraw';
			echo json_encode($response);
			exit;
		}


	}

	} 
	else 
	{




	if($this->input->post('web_mode')=='1')
	{
	$this->session->set_flashdata('error_message', $this->lang->line('errormessage'));
	$condition = "PaymentStatus='1'";

	$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
	$condition = "status='1'";
	$this->data['payments1'] = $this->common_model->GetResults($condition,'arm_manualpay');

	header("Content-Type: application/json");
	$response['success']='0';
	$response['message']=validation_errors();
	$response['redirect']='user/mywithdraw';
	echo json_encode($response);
	exit;


	// $this->load->view('user/mywithdraw',$this->data);

	}
	else
	{
	header("Content-Type: application/json");
	$response['success']='0';
	$response['message']=validation_errors();
	$response['redirect']='user/mywithdraw';
	echo json_encode($response);
	exit;
	}

	}

	} else {


	if($this->input->post('web_mode')=='1')
	{
	$this->session->set_flashdata('error_message', $this->lang->line('withdrawdaywarning'));
	$condition = "PaymentStatus='1'";
	$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
	$condition = "status='1'";
	$this->data['payments1'] = $this->common_model->GetResults($condition,'arm_manualpay');

	$this->load->view('user/mywithdraw',$this->data);
	}
	else
	{
	header("Content-Type: application/json");
	$response['success']='0';
	$response['message']=$this->lang->line('withdrawdaywarning');
	$response['redirect']='user/mywithdraw';
	echo json_encode($response);
	exit;
	}

	}

	} else {



	if($this->input->post('web_mode')=='1')
	{
	$this->session->set_flashdata('error_message', $this->lang->line('withdrawwarning'));
	$condition = "PaymentStatus='1'";
	$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
	$condition = "status='1'";
	$this->data['payments1'] = $this->common_model->GetResults($condition,'arm_manualpay');
	$this->load->view('user/mywithdraw',$this->data);
	}
	else
	{
	header("Content-Type: application/json");
	$response['success']='0';
	$response['message']=$this->lang->line('withdrawwarning');
	$response['redirect']='user/mywithdraw';
	echo json_encode($response);
	exit;
	}


	}

	} else {


	$condition = "PaymentStatus='1'";
	$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');

	$condition = "status='1'";
	$this->data['payments1'] = $this->common_model->GetResults($condition,'arm_manualpay');

	// print_r($this->data['payments']);
	// exit();

	$this->load->view('user/mywithdraw',$this->data);	

	}

	}



	public function balance_check($amount)
	{
	$memberid=$this->input->post('memberid');
	$balance 	= $this->common_model->Getcusomerbalance($memberid);
	$adminfee 	= $this->mywithdraw_model->Getdata('adminfee');
	$minfund 	= $this->mywithdraw_model->Getdata('minwithdraw');
	$maxfund	= $this->mywithdraw_model->Getdata('maxwithdraw');
	$adminfeetype	= $this->mywithdraw_model->Getdata('adminfeetype');

	if(strtolower($adminfeetype)=='flat')
	{
	$cadminfee = $adminfee;
	}
	else
	{
	$cadminfee =  $amount * $adminfee / 100 ;
	}


	$camount= $amount + $cadminfee;



	if($camount <= $balance)
	{

	if(floatval($camount) < floatval($minfund) || floatval($camount) > floatval($maxfund))
	{

	$this->form_validation->set_message('balance_check',ucwords($this->lang->line('errorlimit')));
	return false;
	}
	else
	{

	return true;
	}
	}
	else
	{
	$this->form_validation->set_message('balance_check',ucwords($this->lang->line('errorbalance').' '.$balance));
	return false;
	}
	}


	public function userbankwire_check()
	{

	$memberid=$this->input->post('memberid');
	$memdt 	= $this->common_model->GetRow("MemberId='".$memberid."'","arm_members");

	$cusdet = json_decode($memdt->CustomFields);

	if(isset($cusdet))
	{
	if($cusdet->bankwireacno!='' && $cusdet->bankwirename!='')
	{
	return true;
	}
	else
	{
	$this->form_validation->set_message('userbankwire_check',ucwords($this->lang->line('errorbankwire').' '.$balance));
	return false;
	}
	}

	}



	public function steps($value)
	{
	if($value!="")
	{
	$checkpayment=$this->common_model->GetRow("PaymentId='".$value."'","arm_paymentsetting");
	$this->data['steps']=$checkpayment->PaymentStep;
	$this->load->view('user/steps',$this->data);
	}
	}
	public function checkpaymode(){



	$mode=$this->input->post('id');

	$query =$this->db->query("select * from arm_manualpay where id='".$mode."'")->row();

	$offmodefee = $query->transaction;



	echo $offmodefee;

	// print_r($query->transaction);
	// exit();

	}
	}
