<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upgrade extends CI_Controller {

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
		
		$this->load->helper('cookie');

		// Load database
		$this->load->model('common_model');
		$this->load->model('Memberboardprocess_model');
		$this->load->model('MemberCommission_model');

		$this->lang->load('user/upgrade',$this->session->userdata('language'));
		$this->lang->load('user/common',$this->session->userdata('language'));
		
		/*}  else {
	    	redirect('login');
	    }*/
	}

	

	public function index()
	{
		    $fmember = $this->common_model->getRow("MemberId='".$this->session->MemberID."'","arm_members");

			$ucondition = "MemberId='".$this->session->MemberID."'";
            $userdetails = $this->common_model->GetRow($ucondition,"arm_members");
		 	$sponsor = $this->common_model->GetRow($ucondition,"arm_unilevelmatrix");
		 	$scondition = "MemberId='".$sponsor->DirectId."'";
			$sponsordetails = $this->common_model->GetRow($scondition,"arm_members");

            $this->data['sponsor'] = $sponsor->DirectId;
			$this->data['upline_package'] = $sponsordetails->PackageId;
		
        
		if($this->input->post())
		{
			//print_r($this->input->post());
			
			$this->form_validation->set_rules('paythrough', 'pay through', 'trim|required');
			$this->form_validation->set_rules('package', 'select package', 'trim|required');
			
			if ($this->form_validation->run() == TRUE) 
			{ 	
			
				$condition = "PaymentId='".$this->input->post('paythrough')."'";
				$this->data['paymentdetails'] = $this->common_model->GetRow($condition,'arm_paymentsetting');
				$this->data['packages'] = $this->common_model->GetRow("Status='1' AND PackageId='".$this->input->post('package')."'","arm_package");
				
				$this->data['userdetails'] = $this->common_model->getRow("MemberId='".$this->session->MemberID."'","arm_members");
				//echo"<pre>";print_r($this->data); exit;
				$this->load->view('user/upgradepayment',$this->data);
			}
			else
			{
				
				$this->session->set_flashdata('error_message', $this->lang->line('withdrawdaywarning'));
				$condition = "PaymentStatus='1'";
				$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
				$this->data['packages'] = $this->common_model->GetResults("Status='1' AND PackageId>'".$fmember->PackageId."'","arm_package");
				$this->data['bwcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->MemberID."' AND AdminStatus='0' AND EntryFor='MTAU' and pay_mode='1'","arm_memberpayment");
				$this->data['btcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->MemberID."' AND AdminStatus='0' AND EntryFor='MTAU' and pay_mode='4'","arm_memberpayment");
				$this->data['ethcount'] = $this->common_model->GetRow("MemberId='".$this->session->MemberID."' AND AdminStatus='0' AND EntryFor='MTEU'","arm_memberpayment");

				$this->data['checount'] = $this->common_model->GetRow("MemberId='".$this->session->MemberID."' AND AdminStatus='0' AND EntryFor='MTEU' and pay_mode='7'","arm_memberpayment");
				$this->load->view('user/upgrade',$this->data);
			}
		}			
		else
		{
				$condition = "PaymentStatus='1'";
				$this->data['payments'] = $this->common_model->GetResults($condition,'arm_paymentsetting');
				$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				if($mlsetting->Id==4)
				{
					$ptableName ="arm_pv";
				}
				elseif($mlsetting->Id==5 || $mlsetting->Id==8)
				{
					$ptableName ="arm_boardplan";
				}
				else
				{				
					$ptableName ="arm_package";
				}
				$this->data['packages'] = $this->common_model->GetResults("Status='1'","$ptableName");
				$this->data['bwcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->MemberID."' AND AdminStatus='0' AND EntryFor='MTAU' and pay_mode='1'","arm_memberpayment");
				$this->data['ethcount'] = $this->common_model->GetRow("MemberId='".$this->session->MemberID."' AND AdminStatus='0' AND EntryFor='MTEU'","arm_memberpayment");
				

				$this->data['btcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->MemberID."' AND AdminStatus='0' AND EntryFor='MTAU' and pay_mode='4'","arm_memberpayment");

				$this->data['chcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->MemberID."' AND AdminStatus='0' AND EntryFor='MTAU' and pay_mode='7'","arm_memberpayment");
		
				$this->load->view('user/upgrade',$this->data);
		    }
			

		
	}

	public function start_mining()
	{
	
		$packageid =$_GET['packageid'];
		$ucondition = "MemberId='".$this->session->MemberID."'";
		$this->data['userdetails'] = $this->common_model->GetRow($ucondition,"arm_members");
		$this->data['packages'] = $this->common_model->GetResults("PackageId='".$packageid."'","arm_package");
		$packages_rewards=$data['packages'][0]->mining_reward;

		$accept_date = date("Y-m-d H:i:s");
		$date = $accept_date;
		$date = strtotime($date);
		$date = strtotime("+1 day" , $date);
		$mature_date = date('Y-m-d H:i:s', $date);

		
		$date = strtotime($accept_date);
		$date = strtotime("+ 1 day" , $date);
		$next_run_date = date('Y-m-d H:i:s', $date);
		
		$today_fe=$datas->DateAdded;
		$next_run=$datas->mechureddate;
		




		$rcondition = "memberid =" . "'" . $this->session->MemberID . "' AND PackageId='" . $packageid . "'  ";
		$datas_timout = $this->common_model->GetRows1($rcondition,"Mining_reward"); 

		$today_fe=$datas_timout->DateAdded;
		$next_run=$datas_timout->mechureddate;

		if($datas_timout->Status==1){
			

			if($accept_date==$next_run)
			{
				$Mining_data = array(
				'Status'=>2
				
				);
				
				$rcondition = "memberid =" . "'" . $this->session->MemberID . "' AND PackageId='" . $datas_timout->PackageId . "' ";
				$rtableName ="Mining_reward";
				$updaterequestdata = $this->common_model->UpdateRecord($Mining_data, $rcondition, $rtableName);


				$trnid = 'MINREW'.rand(1111111,9999999);
				// $date =date('y-m-d H:i:s');
				$bal=$this->common_model->Getcusomerbalance($this->session->MemberID);
				$mining_his= array(
				'MemberId'=>$this->session->MemberID,
				'Credit'=>$datas_timout->MiningReward,
				'Description'=>"Mining Reward  for this ".$datas_timout->PackageName." Package",
				'TransactionId'=>$trnid,
				'PackageId'=>$datas_timout->PackageId,
				'TypeId'=>'58',
				'Balance'=>$bal+$datas_timout->MiningReward,
				'DateAdded'=>$today_fe
				);
				
				$mining_his = $this->common_model->SaveRecords($mining_his,'arm_history');
				
				
				$this->mining_level($this->session->MemberID,$datas_timout->PackageId,0,$this->session->MemberID,$datas_timout->MiningReward);
				
			}
		}
		$this->load->view('user/mining_rew',$this->data);
	}

	public function mining_level($userid,$packid,$i,$memberid,$mining_rewards)
	{

		$indirect_level =  $this->db->query("SELECT * FROM arm_package where PackageId='".$packid."'")->row();
		$level = $indirect_level->mining_reward_upline;

		if($level)
		{
			$explode = explode(',', $level);
			$check_count =  count($explode);
			$memberdet = $this->db->query("select * from arm_members where MemberId='".$userid."'")->row();

			$get_level = $explode[$i];
			if($get_level>0)
			{
				$refer_id= $memberdet->DirectId;
				for($i=0;$i<count($explode);$i++)
				{

					$j = $i+1;					
					$memberde_upline = $this->db->query("select * from arm_members where MemberId='".$refer_id."'")->row();

					if(empty($memberde_upline)){
						break;
					}

					$lcommission = $mining_rewards * $explode[$i] / 100;
					$trnid = 'MINICOM'.rand(1111111,9999999);
					$userbal = $this->common_model->Getcusomerbalance($refer_id);
					$data1 = array(
						'MemberId'=>$refer_id,
						'Credit'=>$lcommission,
						'Balance'=>$userbal+$lcommission,
						'Description'=>' Mining Reward Level  '.$j.' Commission Earned from '.$memberde_upline->UserName,
						'TransactionId'=>$trnid,
						'DateAdded'=>date('Y-m-d'),
						'TypeId'=>'59'
					);

					$userdetails = $this->common_model->SaveRecords($data1,'arm_history');
					$refer_id=$memberde_upline->DirectId;
				}
			}

		}
	}
		
	public function mining_payment()
	{
		
		$ucondition = "MemberId='".$this->session->MemberID."'";
		$this->data['userdetails'] = $this->common_model->GetRow($ucondition,"arm_members");
		
		$accept_date = date("Y-m-d H:i:s");
		$date = $accept_date;
		$date = strtotime($date);
		$date = strtotime("+1 day" , $date);
		$mature_date = date('Y-m-d H:i:s', $date);

		
		$date = strtotime($accept_date);
		$date = strtotime("+ 1 day" , $date);

		$next_run_date = date('Y-m-d H:i:s', $date);
		$rcondition = "memberid =" . "'" . $this->session->MemberID . "' AND PackageId='" . $this->input->post('PackageId') . "' ";
		$datas = $this->common_model->GetRow($rcondition,"Mining_reward"); 
		$today_fe=$datas->DateAdded;
		$next_run=$datas->mechureddate;

		
		$Mining_data = array(
		'memberid'=>$this->session->MemberID,
		'PackageId'=>$this->input->post('PackageId'),
		'Status'=>1,
		'PackageName'=>$this->input->post('packagename'),
		'MiningReward'=>$this->input->post('mining_reward'),
		'DateAdded'=>date('Y-m-d H:i:s'),
		'next_run_date'=>date('Y-m-d H:i:s'),
		'mechureddate' =>$mature_date,
		);
		
		$result = $this->common_model->SaveRecords($Mining_data,"Mining_reward");
		if($result)
		{
		$this->session->set_flashdata('success_message',"Your Mining Reward Added Within oneday");
		redirect("user/upgrade");
		}
		else
		{
		$this->session->set_flashdata('error_message','Error,Again Retry Mining');
		redirect("user/upgrade");
		}
	}




	public function wallet_payment()
	{	


      $packageid = $this->input->post('packageid');
      $wallet_payment = $this->input->post('payment');

	$this->form_validation->set_rules('packageid', 'Package', 'trim|required');
	$this->form_validation->set_rules('payment', 'Payment', 'trim|required');
	
	// $this->form_validation->set_message('packageid', 'Please Select Package');
	// $this->form_validation->set_message('payment', 'Please Select Wallet');

		if ($this->form_validation->run() == TRUE) 
		{ 	

		if($packageid && $wallet_payment)
		{
		$this->data['packages'] = $this->common_model->GetResults("PackageId='".$packageid."'","arm_package");

		$this->data['wallet_type'] = $wallet_payment;

		$this->load->view('user/summary',$this->data);

		}
		else
		{
		$this->session->set_flashdata('error_message',"Please Check Error!!");
		redirect("user/upgrade");
		}

		}
		else
		{
		$this->session->set_flashdata('error_message',validation_errors());
		redirect("user/upgrade");
		}


	}







public function wallet_success()
{



if($this->input->post())
{

   $pack_id = $this->input->post('package');
   $wallet_amount = $this->input->post('amount');
   $payment = $this->input->post('pay_wallet');
   $trans_id = $this->input->post('trans_id');
   $id = $this->session->MemberID;


   if($payment==1)
   {
   	 $pay_wallet = "Meta Mask";
   }
   else
   {
   	 $pay_wallet = "Wallet Connect";
   }

	$date = date('y-m-d h:i:s');
	$Mdata = array(
	'SubscriptionsStatus'=>'Active',
	'MemberStatus'=>'Active',
	'PackageId'=>$pack_id,
	'ModifiedDate'=>$date,
	'PackageIdU'=>'2',
	);
	$result = $this->common_model->UpdateRecord($Mdata, "MemberId='".$id."'", 'arm_members');


	if($result)
	{
		$txnid = "UPG".rand(1111111,9999999);
		$bal = $this->common_model->Getcusomerbalance($id);

		$data1 = array(
		'MemberId'=>$id,
		'TransactionId'=>$trans_id,
		'DateAdded'=>$date,
		'PaymentReferenceId'=>$payment,
		'Description'=> "Package Upgrade using ".$pay_wallet." Hash id ".$trans_id,
		'Credit'=>$wallet_amount,
		'Debit'=>$wallet_amount,
		'Balance'=>$bal,
		'PackageId'=>$pack_id,
		'paymentsaddress'=>$trans_id,
		'TypeId'=>"19");

		$result1 = $this->common_model->SaveRecords($data1,'arm_history');
		$this->tokensetting($id,$pack_id);



	    $insert_id = $this->db->insert_id();

		$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

		$field = "MemberId";
		$MemberId = $id;
		if($mlsetting->Id==1)
		{
		$table = "arm_forcedmatrix";
		}
		else if($mlsetting->Id==2)
		{
		$table = "arm_unilevelmatrix";
		}

		$bb = $this->MemberCommission_model->process($MemberId,$table,$field);
		
	}



	echo "Package Upgrad Successfully..";

	$this->load->model('admin/Smtpsetting_model');

	$smtpstatus = $this->Smtpsetting_model->Getdata('smtpstatus');
	$smtpmail = $this->Smtpsetting_model->Getdata('smtpmail');
	$smtppassword = $this->Smtpsetting_model->Getdata('smtppassword');
	$smtpport = $this->Smtpsetting_model->Getdata('smtpport');
	$smtphost = $this->Smtpsetting_model->Getdata('smtphost');
	$maillimit = $this->Smtpsetting_model->Getdata('mail_limit');


	$config = array();
	$config['protocol'] 		= "sendmail";
	$config['useragent']        = "CodeIgniter";
	$config['mailpath']         = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
	$config['smtp_host']        = $smtphost;
	$config['smtp_port']        = $smtpport;
	$config['mailtype'] 		= 'html';
	$config['charset']  		= 'utf-8';
	$config['newline']  		= "\r\n";
	$config['wordwrap'] 		= TRUE;
	// $this->email->initialize($config);
	$this->email->clear(TRUE);
	$sitename = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitename'","arm_setting");
	$user = $this->common_model->GetRow("memberId='".$this->session->MemberID."' AND MemberStatus='Active'","arm_members");

	$upline_mail = $this->common_model->GetRow("MemberId='".$user->DirectId."'","arm_members");

	$this->email->from($smtpmail, $sitename->ContentValue);
	$this->email->to($smtpmail);
	$this->email->subject("Package Upgrade");

	$body1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset='.strtolower(config_item('charset')).'" />
	<title>Register Member Details</title>
	<style type="text/css">
	body {
	font-family: Arial, Verdana, Helvetica, sans-serif;
	font-size: 16px;
	}
	</style>
	</head>
	<body>
	'.strtoupper($user->UserName).' Package Upgrade using '.$pay_wallet.' ..
	</body>
	</html>';


	$datas = array(
	'MemberId'=>$this->session->MemberID,
	'DirectId'=>$user->DirectId,
	'type_id'=>'2',
	'status'=>'1',
	'date'=> date('Y-m-d'),
	'history_id'=>$insert_id
	);

	$arm_notification = $this->common_model->SaveRecords($datas,'arm_notification');

	$this->email->message($body1); 
	$this->email->set_mailtype("html");

	$Mail_status = $this->email->send();


	}
	else
	{
    
    echo "Package Upgrad Not Successfully..";
	//$this->tokensetting($MemberId,$table,$data1);
	}

}


public function tokensetting($memberId,$pack_id)
{
	
	$checkpackagedet=$this->common_model->GetRow("PackageId='".$pack_id."'",'arm_package');
	$total_token=$checkpackagedet->token_reward;

	$txnid = "TOK".rand(1111111,9999999);
	$bal = $this->common_model->Getcusomerbalance($memberId);
	$data1 = array(
	'MemberId'=>$memberId,
	'TransactionId'=>$txnid,
	'DateAdded'=>date('Y-m-d'),
	'Description'=> "Getting Token for Package Upgrade",
	'Credit'=>$total_token,
	'Balance'=>$bal+$total_token,
	'TypeId'=>"50");

	$result1 = $this->common_model->SaveRecords($data1,'arm_history');


	$this->token_level($memberId,$pack_id,0,$memberId);


}



public function token_level($userid,$packid,$i,$memberid)
{

$indirect_level =  $this->db->query("SELECT * FROM arm_package where PackageId='".$packid."'")->row();
$level = $indirect_level->token_reward_upline;

if($level)
{

$explode = explode(',', $level);
$check_count =  count($explode);


$memberdet = $this->db->query("select * from arm_members where MemberId='".$userid."'")->row();
$memberde_upline = $this->db->query("select * from arm_members where MemberId='".$memberid."'")->row();

$get_level = $explode[$i];


if($get_level>0 && $memberdet->DirectId>0)
{

$j = $i+1;
$trnid = 'TOKCOM'.rand(1111111,9999999);
$userbal = $this->common_model->Getcusomerbalance($memberdet->DirectId);
$data1 = array(
'MemberId'=>$memberdet->DirectId,
'Credit'=>$get_level,
'Balance'=>$userbal+$get_level,
'Description'=>' Token Reward Level  '.$j.' Commission Earned from '.$memberde_upline->UserName,
'TransactionId'=>$trnid,
'Rankname'=>$memberdet->rank,
'DateAdded'=>date('Y-m-d'),
'TypeId'=>'50'
);


$userdetails = $this->common_model->SaveRecords($data1,'arm_history');

if($get_level>0)
{
$i++;
$memberdet_upline = $this->db->query("select * from arm_members where MemberId='".$userid."'")->row();
$this->token_level($memberdet_upline->DirectId,$packid,$i,$memberid);
}

}


}


}
	
	public function checkbankwire($id='')
	{
		if($this->input->post('checkwire')=='check')
		{
			$mdetails = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'",'arm_members');
			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mtau_check');
			$this->form_validation->set_rules($_FILES['referfile'],'referfile', 'trim|required|callback_ext_check');
			$admin_img = 'uploads/mtmpay/no-photo.jpg';
			if($_FILES['referfile']['tmp_name']!='')
			{
				if($_FILES['referfile']['type']=='image/jpg' || $_FILES['referfile']['type']=='image/jpeg' || $_FILES['referfile']['type']=='image/png'|| $_FILES['referfile']['type']=='image/gif')
				{
				$ext = explode(".", $_FILES['referfile']['name']);
				$admin_img = "uploads/mtmpay/".$this->input->post('memberid')."-admin.".$ext[1];
				move_uploaded_file($_FILES['referfile']['tmp_name'], $admin_img);
				$fileflag=1;
				}
				else
				{
					$fileflag=0;

					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('error_message',$this->lang->line('errormtaufile'));
						redirect("user/upgrade");
					}
					else
					{
						header("Content-Type: application/json");
						$response["success"] = 0;
						$response["message"]="Pls upload valid files";
						echo json_encode($response);
						exit;
					}
					
				}

			}
			else
			{
				$fileflag=1;
			}
		

			if($this->form_validation->run() == true && $fileflag==1)	
 			{

				$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

				if($mlsetting->Id==8)
				{
					$paydet = $this->common_model->GetRow("UserName='".$this->input->post('payto')."'",'arm_members');
                  	$data1 = array(
							'AdminStatus'=>'0',
							'MemberStatus'=>'0',
							'ReceiveBy'=>$paydet->MemberId,
							'MPaymentReference'=>$this->input->post('transactionid'),
							'EntryFor'=>'MTAU',
							'PackageId'=>$id,
							'PaymentAmount'=>$this->input->post('paymentamount'),
							'MemberId'=>$this->input->post('memberid'),
							'APaymentAttachemt'=>$admin_img,
							'APaymentReference'=>$this->input->post('transactionid'),
							'DateAdded'=>date('y-m-d H:i:s')
					);

	                $mtmresult = $this->common_model->SaveRecords($data1,"arm_memberpayment");

					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('success_message',$this->lang->line('successmtaumsg'));
						
					}
					else
					{
						header("Content-Type: application/json");
						$response["success"] = 1;
						$response["message"]="Payment Requested .. Pls wait For admin confirmation";
						echo json_encode($response);
						exit;
					}

                    }
			
					else
					{
					$data = array(
							'AdminStatus'=>'0',
							'MemberStatus'=>'1',
							'ReceiveBy'=>'1',
							'EntryFor'=>'MTAU',
							'PackageId'=>$id,
							'PaymentAmount'=>$this->input->post('paymentamount'),
							'MemberId'=>$this->input->post('memberid'),
							'APaymentAttachemt'=>$admin_img,
							'APaymentReference'=>$this->input->post('transactionid'),
							'DateAdded'=>date('y-m-d H:i:s'));

				$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");

				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('success_message',$this->lang->line('successmtaumsg'));
					
				}
				else
				{
					header("Content-Type: application/json");
					$response["success"] = 1;
					$response["message"]="Payment Requested .. Pls wait For admin confirmation";
					echo json_encode($response);
					exit;
				}
				
				}
			}
			else
			{
				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('error_message',$this->lang->line('errormtaumsg'));		
				}
				else
				{

					header("Content-Type: application/json");
					$response["success"] = 0;
					$response["message"]=validation_errors();
					echo json_encode($response);
					exit;
				}

					
				
			}
			
				
			redirect('user/upgrade');
			exit;
		}
		else
		{

			if($this->input->post('web_mode')=='1')
			{
				redirect('user/upgrade');
			}
			else
			{
				$fileflag=0;
				header("Content-Type: application/json");
				$response["success"] = 0;
				$response["message"]="No Post Parameters Passed";
				echo json_encode($response);
				exit;
			}
		}
	}

	

	
	public function checkbitcoin($id='')
	{
		if($this->input->post('checkwire')=='check')
		{
			$mdetails = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'",'arm_members');
			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mtau_check');
			$this->form_validation->set_rules($_FILES['referfile'],'referfile', 'trim|required|callback_ext_check');
			$admin_img = 'uploads/mtmpay/no-photo.jpg';
			if($_FILES['referfile']['tmp_name']!='')
			{
				if($_FILES['referfile']['type']=='image/jpg' || $_FILES['referfile']['type']=='image/jpeg' || $_FILES['referfile']['type']=='image/png'|| $_FILES['referfile']['type']=='image/gif')
				{
					$ext = explode(".", $_FILES['referfile']['name']);
					$admin_img = "uploads/mtmpay/".$this->input->post('memberid')."-admin.".$ext[1];
					move_uploaded_file($_FILES['referfile']['tmp_name'], $admin_img);
					$fileflag=1;
				}
				else
				{
					$fileflag=0;

					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('error_message',$this->lang->line('errormtaufile'));
						redirect("user/upgrade");
					}
					else
					{
						header("Content-Type: application/json");
						$response["success"] = 0;
						$response["message"]="Pls upload valid files";
						echo json_encode($response);
						exit;
					}
				}

			}
			else
			{
				$fileflag=1;
			}
		

			if($this->form_validation->run() == true && $fileflag==1)	
 			{

				$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

				if($mlsetting->Id==8)
				{
					$paydet = $this->common_model->GetRow("UserName='".$this->input->post('payto')."'",'arm_members');
                  		$data1 = array(
							'AdminStatus'=>'0',
							'MemberStatus'=>'0',
							'ReceiveBy'=>$paydet->MemberId,
							'MPaymentReference'=>$this->input->post('transactionid'),
							'EntryFor'=>'MTAU',
							'PackageId'=>$id,
							'PaymentAmount'=>$this->input->post('paymentamount'),
							'MemberId'=>$this->input->post('memberid'),
							'APaymentAttachemt'=>$admin_img,
							'APaymentReference'=>$this->input->post('transactionid'),
							'DateAdded'=>date('y-m-d H:i:s'),
							'pay_mode' => '4'
					);

	                $mtmresult = $this->common_model->SaveRecords($data1,"arm_memberpayment");

					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('success_message',"Payment Requested Pls wait for admin confirmation");
		
					}
					else
					{
		               	header("Content-Type: application/json");
						$response["success"] = 1;
						$response["message"]="Payment Requested .. Pls wait For admin confirmation";
						echo json_encode($response);
						exit;
					}
					

                }
				else
				{
					$data = array(
							'AdminStatus'=>'0',
							'MemberStatus'=>'1',
							'ReceiveBy'=>'1',
							'EntryFor'=>'MTAU',
							'PackageId'=>$id,
							'PaymentAmount'=>$this->input->post('paymentamount'),
							'MemberId'=>$this->input->post('memberid'),
							'APaymentAttachemt'=>$admin_img,
							'APaymentReference'=>$this->input->post('transactionid'),
							'pay_mode' => '4',
							'DateAdded'=>date('y-m-d H:i:s'));
					$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('success_message',"Payment Requested Pls wait for admin confirmation");
		
					}
					else
					{
						header("Content-Type: application/json");
						$response["success"] = 1;
						$response["message"]="Payment Requested .. Pls wait For admin confirmation";
						echo json_encode($response);
						exit;
					}
				
				}
			}
			else
			{

				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('error_message',"Payment Request Failed.. pls try again");
					
				}
				else
				{
					header("Content-Type: application/json");
					$response["success"] = 0;
					$response["message"]=validation_errors();
					echo json_encode($response);
					exit;
				}
			}
			
				
			redirect('user/upgrade');
			exit;
		}
		else
		{

			$fileflag=0;
			header("Content-Type: application/json");
			$response["success"] = 0;
			$response["message"]="No Post Parameters Passed";
			echo json_encode($response);
			exit;

		}
			
			
			//redirect('user/upgrade');

	}


	public function checkcheque($id='')
	{
		if($this->input->post('checkwire')=='check')
		{
			$mdetails = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'",'arm_members');
			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mtau_check');
			$this->form_validation->set_rules($_FILES['referfile'],'referfile', 'trim|required|callback_ext_check');
				
			$admin_img = 'uploads/mtmpay/no-photo.jpg';
			if($_FILES['referfile']['tmp_name']!='')
			{
				if($_FILES['referfile']['type']=='image/jpg' || $_FILES['referfile']['type']=='image/jpeg' || $_FILES['referfile']['type']=='image/png'|| $_FILES['referfile']['type']=='image/gif')
				{
				$ext = explode(".", $_FILES['referfile']['name']);
				$admin_img = "uploads/mtmpay/".$this->input->post('memberid')."-admin.".$ext[1];
				move_uploaded_file($_FILES['referfile']['tmp_name'], $admin_img);
				$fileflag=1;
				}
				else
				{

					$fileflag=0;
					$this->session->set_flashdata('error_message',$this->lang->line('errormtaufile'));
					redirect("user/upgrade");
				}

			}
			else
			{
				$fileflag=1;
			}
		

			if($this->form_validation->run() == true && $fileflag==1)	
 			{

				$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

				if($mlsetting->Id==8)
				{
					$paydet = $this->common_model->GetRow("UserName='".$this->input->post('payto')."'",'arm_members');
                  
                    

                    	 $data1 = array(
							'AdminStatus'=>'0',
							'MemberStatus'=>'0',
							'ReceiveBy'=>$paydet->MemberId,
							'EntryFor'=>'MTAU',
							'PackageId'=>$id,
							'PaymentAmount'=>$this->input->post('paymentamount'),
							'MemberId'=>$this->input->post('memberid'),
							'APaymentAttachemt'=>$admin_img,
							'APaymentReference'=>$this->input->post('transactionid'),
							'DateAdded'=>date('y-m-d H:i:s')
					);

	                $mtmresult = $this->common_model->SaveRecords($data1,"arm_memberpayment");
					$this->session->set_flashdata('success_message',"Member Upgrade cheque Payment Details updated.. Pls wait for confirmations");

                }
				else
				{
					$data = array(
							'AdminStatus'=>'0',
							'MemberStatus'=>'1',
							'ReceiveBy'=>'1',
							'EntryFor'=>'MTAU',
							'PackageId'=>$id,
							'PaymentAmount'=>$this->input->post('paymentamount'),
							'MemberId'=>$this->input->post('memberid'),
							'APaymentAttachemt'=>$admin_img,
							'DateAdded'=>date('y-m-d H:i:s'),
							'pay_mode'=>'7',
							'cheque_date'=>$this->input->post('date'),
							'cheque_number'=>$this->input->post('checknumber'),
							'bank_name'=>$this->input->post('bankname'),
							'branch'=>$this->input->post('branchname')
						);
					$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('success_message',"Member Upgrade cheque Payment Details updated.. Pls wait for confirmations");
						
					}
					else
					{
						$fileflag=0;
						header("Content-Type: application/json");
						$response["success"] = 1;
						$response["message"]="Member Upgrade cheque Payment Details updated.. Pls wait for confirmations";
						echo json_encode($response);
						exit;
					}
				}
				
			}
			else
			{
				
				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('error_message',$this->lang->line('errormtaumsg'));
	
				}
				else
				{
					$fileflag=0;
					header("Content-Type: application/json");
					$response["success"] = 0;
					$response["message"]=validation_errors();
					echo json_encode($response);
					exit;
				}
			}
			
				
			redirect('user/upgrade');
			exit;
		}
		else
		{
			$fileflag=0;
			header("Content-Type: application/json");
			$response["success"] = 0;
			$response["message"]="No Post Parameters Passed";
			echo json_encode($response);
			exit;

		}
	}

	public function checkblockio($id='')
	{
		if($this->input->post('checkwire')=='check')
		{
			$mdetails = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'",'arm_members');
			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mtau_check');		
			$amount=$this->input->post('amount');
			$check_block_io=$this->common_model->GetRow("PaymentId='12'","arm_paymentsetting");
			$coinmode=$check_block_io->coinmode;
			$transactionid=$this->input->post('transactionid');
			$to_address=$this->input->post('to_address');
			$paymentamount=$amount;
			$this->db->query("update arm_address set amount='".$amount."' where address='".$this->input->post('to_address')."'");
			$data = array(
					'AdminStatus'=>'0',
					'MemberStatus'=>'1',
					'ReceiveBy'=>'1',
					'EntryFor'=>'MTAU',
					'pay_mode'=>12,
					'PaymentAmount'=>$paymentamount,
					'PackageId'=>$this->input->post('packageid'),
					'MemberId'=>$this->input->post('memberid'),
					'eth_address'=> $this->input->post('to_address'),
					'APaymentReference'=>$this->input->post('transactionid'),
					'DateAdded'=>date('y-m-d H:i:s')
				);
			   $mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
			   if($this->input->post('web_mode')=='1')
			   {
					$this->session->set_flashdata('success_message',"Payment Requested .. Pls wait For admin confirmation");
					redirect('user/upgrade');
					exit;

				}
				else
				{
					header("Content-Type: application/json");
					$response["success"] = 1;	
					$response["message"]="Payment Requested .. Pls wait For admin confirmation";
					echo json_encode($response);
					exit;
				}
		}
			
			
		redirect('user/upgrade');

	}


	public function checkmpesa($id='')
	{	
		if($this->input->post('checkwire')=='check')
		{
			
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$this->form_validation->set_rules('transactionid','transactionid','trim|required');
			$this->form_validation->set_rules('paynumber','paynumber','trim|required');
			// $this->form_validation->set_rules('codenumber','codenumber','trim|required');
			// $this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mta_check');
				
			if($this->form_validation->run() == true)	
 			{
 				
				 $mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");
				
		    	// $paymentamount=$checkpackagedet->PackageFee;

				 $mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				 if($mlsetting->Id==9)
				 {
				 	$paymentamount=$this->input->post('transactionamount');
				 }
				 else if($mlsetting->Id==4)
				 {
				 	$paymentamount=$this->input->post('amount');
				 }
				 else
				 {
				 	$paymentamount=$this->input->post('amount');
				 }

				 $transactionid=$this->input->post('transactionid');
			     $paynumber=$this->input->post('paynumber');
			     //  if($paynumber)
			     // {
			     // 	if(preg_match('/^254[1-9][0-9]{0,15}$/',$paynumber) || preg_match('/^255[1-9][0-9]{0,15}$/', $paynumber))
			     // 	{
			     // 		$flag=1;

			     // 	}
			     	
			     // 	else
			     // 	{

			     // 		$this->session->set_flashdata("error_message","Enter The Phone Number start with country code without the + sign eg. kenya 254720xxxxxx, tanzania 255720xxxxxx.");
			     // 		   redirect("user/register/checkmpesa/".$id."");
			     // 	}
			     // }

		        // $codenumber=$this->input->post('codenumber');
			     // if($flag==1)
			     // {


					 if($transactionid)
					 {

					 	  $checkexit=$this->common_model->GetRowCount("APaymentReference='".$transactionid."'","arm_memberpayment");
					 	  if($checkexit==0)
					 	  {
					 	  	   $checkmepsadet=$this->common_model->GetRow("PaymentName='Mpesa'","arm_paymentsetting");
					 	  	   $key=$checkmepsadet->PaymentMerchantApi;
					 	  	   $secret=$checkmepsadet->PaymentMerchantPassword;
						 	  	$api_key = $key;
								$api_secret = $secret;
								$locationid=$checkmepsadet->PaymentField1;
								$endpoint = 'http://sapamacash.com/api/get_transactions';
								//Data to send a query string
								$data = array(
								    'format' => 'json',
								    'api_key' => $api_key,
								    'api_secret' => $api_secret,
								     'phone'=>$paynumber,
								     'trans_id'=>$transactionid,
								     'location_id'=>$locationid
								);
								//Sort by keys in ascending order
								ksort($data);
								//Implode the string
								$string_to_hash = implode($data, '.');
								//Generate hash
								$hash = hash('sha256', $string_to_hash, false);
								//IMPORTANT: REMEMBER TO ADD THE GENERATED HASH TO TO THE DATA
								$data['hash'] = $hash;

								//IMPORTANT: REMEMBER TO REMOVE THE API SECRET FROM THE DATA HASHED
								unset($data['api_secret']);
								// var_dump($data);

								$fields_string = '';
								foreach ($data as $key => $value) {
								    $fields_string .= $key . '=' . $value . '&';
								}//E# foreach statement

								rtrim($fields_string, '&');

								// Get cURL resource
								$ch = curl_init();

								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_URL, $endpoint . '?' . $fields_string);

								$result = curl_exec($ch);

								curl_close($ch);

								$decoded_data = json_decode($result, true);
								
								if(isset($decoded_data)!="")
								{
								   if($decoded_data['httpStatusCode'] == 200 && array_key_exists('data', $decoded_data['data']))
								   {
									   if($decoded_data['data']['data'])
									   {
										    $index = 0;
										    foreach ($decoded_data['data']['data'] as $single_transaction)
										    {
										     	

										    	$trans_id=$single_transaction['trans_id'];
										  
										    	$trans_amount=$single_transaction['trans_amount'];
										    	$phone=$single_transaction['phone'];
										    	
										    	$memberdet=$this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");
										    	$packageid=$memberdet->PackageId;
										    	$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
										    	if($checkmatrix->Id==4)
										    	{
										    		$table="arm_pv";
										    	}
										    	elseif($checkmatrix->Id==9)
										    	{
										    		$table="arm_hyip";
										    	}
										    	elseif ($checkmatrix->Id==5) {
										    		$table="arm_boardplan";
										    	}
										    	else
										    	{
										    		$table="arm_package";
										    	}
										    	$checkpackagedet=$this->common_model->GetRow("PackageId='".$this->input->post('packageid')."'",$table);
										    	$amount=$checkpackagedet->PackageFee;
										    	if($transactionid==$trans_id && $amount==$trans_amount && $paynumber==$phone)
										    	{
											        $insertdata = array(
															'AdminStatus'=>'1',
															'MemberStatus'=>'1',
															'ReceiveBy'=>'1',
															'EntryFor'=>'MTAU',
															'PaymentAmount'=>$this->input->post('paymentamount'),
															'PackageId'=>$id,
															'MemberId'=>$this->input->post('memberid'),
															'APaymentReference'=>$this->input->post('transactionid'),
															'DateAdded'=>date('y-m-d H:i:s')
														);
											     	$insert=$this->common_model->SaveRecords($insertdata,"arm_memberpayment");
											     	$bal=$this->common_model->Getcusomerbalance($this->input->post('memberid'));
										    	 	$inserthis = array(
																	'MemberId'	=>	$this->input->post('memberid'),
																	'DateAdded'	=>	date('Y-m-d H:i:s'),
																	'TransactionId'	=>	$transactionid,
																	'Credit'	=>$paymentamount,
																	'Debit'	=>	$paymentamount,
																	'Balance'=>$bal,
																	'TypeId'	=>	"19",
																	'Description'=>"Member Upgrade using this id ".$transactionid,
																);
											   		$insertt=$this->common_model->SaveRecords($inserthis,"arm_history");

											    		
											    	$subscriptiontype=$this->common_model->GetRow("KeyValue='subscriptiontype' AND Page='usersetting'","arm_setting");
														if($subscriptiontype->ContentValue=='monthly')
														{
															$nxtperiod=30;
														}
														else
														{
															$nxtperiod=365;
														}
														$date = date("Y-m-d H:i:s ");
														$nxtdat = strtotime("+".$nxtperiod." day", strtotime($date));
														$nxtdate=date('Y-m-d H:i:s ', $nxtdat);
														
														$data = array(
															'SubscriptionsStatus'=>'Active',
															'PackageId'=>$id,
															// 'Mpesacode'=>$codenumber,
															'MemberStatus'=>'Active',
															'ModifiedDate'=>$date,
															'EndDate'=>$nxtdate
														);
											    		$con="MemberId='".$this->input->post('memberid')."'";
											    		$update=$this->common_model->UpdateRecord($data,$con,"arm_members");
											    		if($update)
											    		{
											    			$memberids=$this->input->post('memberid');
															$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
															$field = "MemberId";
															// $MemberId = $mladet->MemberId;
															
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
																$field = "MonoLineId";
																$monomdet = $this->common_model->GetRow("MemberId='". $memberids."' order by MonoLineId ASC LIMIT 0,1","arm_monolinematrix");

																$MemberId = $monomdet->MonoLineId;

															}
															else if($mlsetting->Id==4)
															{
																$table = "arm_binarymatrix";
																// $this->Memberboardprocess_model->Totaldowncount($table);

															}
															else if($mlsetting->Id==5)
															{
																$table = "arm_boardmatrix";
																$field = "MemberId";
																$brdmdet = $this->common_model->GetRow("MemberId='".$memberids."' order by BoardMemberId ASC LIMIT 0,1","arm_boardmatrix");
																
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
																// $this->Memberboardprocess_model->Totaldowncount($table);
																// $this->Memberboardprocess_model->binaryhyip($memberids,$table);
															}
															$bb = $this->MemberCommission_model->process($memberids,$table,$field);
												    		$this->session->set_flashdata('success_message',"You are Successfully Upgrade your Package");
												    	    redirect('user/upgrade');
											    		}
										          
										    	}
										    	else
										    	{
										    		$this->session->set_flashdata('error_message',"You have paid an incorrect amount. You must make another transaction using the EXACT AMOUNT INDICATED");
							            		    redirect('user/upgrade');
										    	}
										    	
										        $index++;


										    } //E# foreach statement
									    
									    } 
									    else
									    {
									      $this->session->set_flashdata('error_message',"Invalid Transaction Id");
							              redirect('user/upgrade');
									    }
								   }
								}
								
						
					 	  }
					 	  else
					 	  {
					 	  	$this->session->set_flashdata('error_message',"TransactionId Already Exist");
							redirect('user/upgrade');
					 	  }
				}
				
			}
			
			else
			{
				$this->session->set_flashdata('error_message',$this->lang->line('errormtamsg'));
			}
		
		
		}

	
		
	}

	/*public function checketh($id='')
	{
		if($this->input->post('checkwire')=='check')
		{
			
			
			$mdetails = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'",'arm_members');
	        
			$transactionid=$this->input->post('transactionid');
			$to_address=$this->input->post('to_address');
			$amount=$this->input->post('paymentamount');
			// $checkrow=$this->common_model->GetRowCount("blocknumber='".$this->input->post('blocknumber')."'","arm_memberpayment");
			// if($checkrow==0)
			// {
			$url3="http://api.etherscan.io/api?module=account&action=txlist&address=".$to_address;
	        $ch3 = curl_init();  
	        curl_setopt($ch3,CURLOPT_URL,$url3);
	        curl_setopt($ch3,CURLOPT_RETURNTRANSFER,true);
	        $getdata=curl_exec($ch3);
	        curl_close($ch3);
	        $hash_details = json_decode($getdata); 
	        // echo "<pre>"; print_r($hash_details); echo "</pre>";
	        $msg=$hash_details->message;
	        $status=$hash_details->status;

	        if($status!=0 && $msg=='OK')
	        {
	        	for ($i=0; $i <count($hash_details->result); $i++)
	        	{ 
	        		
		            $to_addr = $hash_details->result[$i]->to;
		            $from_addr=$hash_details->result[$i]->from;
		            $to_amt  = $hash_details->result[$i]->value;
		            $type = $eth_trans->typ;
		            $orignal_amt=$to_amt/1000000000000000000;
		            if($transactionid==$from_addr)
		            {
			            if($transactionid==$from_addr)
			            {
			              	$memberdet=$this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");
					    	$packageid=$memberdet->PackageId;
					    	$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
					    	if($checkmatrix->Id==4)
					    	{
					    		$table="arm_pv";
					    	}
					    	elseif($checkmatrix->Id==9)
					    	{
					    		$table="arm_hyip";
					    	}
					    	elseif ($checkmatrix->Id==5) 
					    	{
					    		$table="arm_boardplan";
					    	}
					    	else
					    	{
					    		$table="arm_package";
					    	}
					    	$checkpackagedet=$this->common_model->GetRow("PackageId='".$this->input->post('packageid')."'",$table);
					    	$amount=$checkpackagedet->PackageFee;
					    	
						        $insertdata = array(
										'AdminStatus'=>'1',
										'MemberStatus'=>'1',
										'ReceiveBy'=>'1',
										'EntryFor'=>'MTAU',
										'PaymentAmount'=>$this->input->post('paymentamount'),
										'PackageId'=>$id,
										'MemberId'=>$this->input->post('memberid'),
										'APaymentReference'=>$this->input->post('transactionid'),
										'blocknumber'=>$this->input->post('blocknumber'),
										'DateAdded'=>date('y-m-d H:i:s')
									);
						     	$insert=$this->common_model->SaveRecords($insertdata,"arm_memberpayment");
						     	$bal=$this->common_model->Getcusomerbalance($this->input->post('memberid'));
					    	 	$inserthis = array(
												'MemberId'	=>	$this->input->post('memberid'),
												'DateAdded'	=>	date('Y-m-d H:i:s'),
												'TransactionId'	=>	$transactionid,
												'Credit'	=>$paymentamount,
												'Debit'	=>	$paymentamount,
												'Balance'=>$bal,
												'TypeId'	=>	"19",
												'Description'=>"Member Upgrade using this id ".$transactionid,
											);
						   		$insertt=$this->common_model->SaveRecords($inserthis,"arm_history");

						    		
						    	$subscriptiontype=$this->common_model->GetRow("KeyValue='subscriptiontype' AND Page='usersetting'","arm_setting");
									if($subscriptiontype->ContentValue=='monthly')
									{
										$nxtperiod=30;
									}
									else
									{
										$nxtperiod=365;
									}
									$date = date("Y-m-d H:i:s ");
									$nxtdat = strtotime("+".$nxtperiod." day", strtotime($date));
									$nxtdate=date('Y-m-d H:i:s ', $nxtdat);
									
									$data = array(
										'SubscriptionsStatus'=>'Active',
										'PackageId'=>$id,
										// 'Mpesacode'=>$codenumber,
										'MemberStatus'=>'Active',
										'ModifiedDate'=>$date,
										'EndDate'=>$nxtdate
									);
						    		$con="MemberId='".$this->input->post('memberid')."'";
						    		$update=$this->common_model->UpdateRecord($data,$con,"arm_members");
						    		if($update)
						    		{
						    			$memberids=$this->input->post('memberid');
										$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
										$field = "MemberId";
										// $MemberId = $mladet->MemberId;
										
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
											$field = "MonoLineId";
											$monomdet = $this->common_model->GetRow("MemberId='". $memberids."' order by MonoLineId ASC LIMIT 0,1","arm_monolinematrix");

											$MemberId = $monomdet->MonoLineId;

										}
										else if($mlsetting->Id==4)
										{
											$table = "arm_binarymatrix";
											// $this->Memberboardprocess_model->Totaldowncount($table);

										}
										else if($mlsetting->Id==5)
										{
											$table = "arm_boardmatrix";
											$field = "MemberId";
											$brdmdet = $this->common_model->GetRow("MemberId='".$memberids."' order by BoardMemberId ASC LIMIT 0,1","arm_boardmatrix");
											
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
											// $this->Memberboardprocess_model->Totaldowncount($table);
											// $this->Memberboardprocess_model->binaryhyip($memberids,$table);
										}
										$bb = $this->MemberCommission_model->process($memberids,$table,$field);
										$this->session->set_flashdata("success_message","Upgrade Package is Successfully");
										$this->session->set_flashdata("error_message","");

										redirect("user/upgrade");
						            }
		                }
		                else
		                {
		                	$this->session->set_flashdata("error_message","Transactions Not Found");
		                }	
		            }
		            else
		            {
		            	$this->session->set_flashdata("error_message","Invalid Eth Address");
		            }

	            }

	          
	        }
	        else
	        {
	        	$this->session->set_flashdata("error_message",$hash_details->result);
	        }

	       // }
	       // else
	       // {
	       // 	$this->session->set_flashdata("error_message","Sorry you Cant Payment Bcz This Block Number Already Exist");
	       // }
			
		}
				
			redirect('user/upgrade');
			exit;
	

	}*/

	public function checketh($id='')
	{
		if($this->input->post('checkwire')=='check')
		{	
			$to_address=$this->input->post('to_address');
			if($to_address !='')
			{				
				$transactionid=$this->input->post('transactionid');
				$memberid=$this->input->post('memberid');
				$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			
	 				
				 $mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");

				 $mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				 if($mlsetting->Id==9)
				 {
				 	$paymentamount=$this->input->post('transactionamount');
				 }
				 else if($mlsetting->Id==4) 
				 {
				 	$paymentamount=$this->input->post('amount');
				 }
				 else
				 {
				 	$paymentamount=$this->input->post('amount');
				 }



				 $data = array(
						'AdminStatus'=>'0',
						'MemberStatus'=>'1',
						'ReceiveBy'=>'1',
						'EntryFor'=>'MTEU',
						'APaymentReference'=>'Ethereum',
						'PaymentAmount'=>$paymentamount,
						'equval_amount'=>$this->input->post('eqv_amt'),
						'PackageId'=>$id,
						'MemberId'=>$this->input->post('memberid'),
						'eth_address'=>$to_address,
						'DateAdded'=>date('y-m-d H:i:s')
					);
				
					$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
					$reference_id=$this->db->insert_id();
					

					$datass = array(
									"user_id"	=>	$this->input->post('memberid'),
									'PackageId'=>$id,
									"amount"    =>  $paymentamount,
									"reference_id"=>$reference_id,
									"item_name" =>'Upgrade',
									"equval_amt"=>  $this->input->post('eqv_amt'),
									"status"	=>	'1'
								     );
									
				    $con="address='".$to_address."' and payment = '1'";
		    		$update=$this->common_model->UpdateRecord($datass,$con,"arm_address");
		    		if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('success_message',"Your ETH Address Send Successfully Please wait Admin accept");
						redirect('user/upgrade');
						exit;		
					}
					else
					{
						header("Content-Type: application/json");
						$response["success"] = 1;
						$response["message"]="Your ETH Address Send Successfully Please wait Admin accept";
						echo json_encode($response);
						exit;
					}
				}
				else
				{
					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('error_message',"Sorry Payment Address not Available!");
					 	redirect('user/upgrade');
					 	exit;
					}
					else
					{
						header("Content-Type: application/json");
						$response["success"] = 0;
						$response["message"]="Sorry Payment Address not Available!";
						echo json_encode($response);
						exit;
					}
				}
			}
			else
			{

				if($this->input->post('web_mode')=='1')
				{
					$this->data['id'] = $id;
	    			$this->data['amount'] = $this->input->post('amount');
					$this->load->view('user/upgrade',$this->data);
					
				}
				else
				{
					header("Content-Type: application/json");
					$response["success"] = 0;
					$response["message"]="No Post Parameters Available";
					echo json_encode($response);
					exit;

				}

			}
		}



	public function checkepin($id='')
	{
		
		if($this->input->post('check')=='check')
		{
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$pckdetails = $this->common_model->GetRow("EpinTransactionId='".$this->input->post('epincode')."' AND EpinStatus='1' AND ExpiryDay>='".date('Y-m-d')."'",'arm_epin');
			if($pckdetails)
			{
				
				if($this->input->post('package')==$pckdetails->EpinPackageId)
				{

					$date = date('y-m-d h:i:s');
					$Mdata = array('SubscriptionsStatus'=>'Active',
							'MemberStatus'=>'Active',
							'PackageId'=>$pckdetails->EpinPackageId,
							'ModifiedDate'=>$date);
					$result = $this->common_model->UpdateRecord($Mdata, "MemberId='".$id."'", 'arm_members');
					// echo $this->db->last_query();
				
					if($result)
					{
						$edata = array('UsedBy'=>$id,
										'EpinStatus'=>'2',
										'ModifiedDate'=>$date);
						$epresult = $this->common_model->UpdateRecord($edata, "EpinRecordId='".$pckdetails->EpinRecordId."'", 'arm_epin');
				
						$txnid = "UPG".rand(1111111,9999999);
					
						$bal = $this->common_model->Getcusomerbalance($id);

						$data1 = array('MemberId'=>$id,
							'TransactionId'=>$txnid,
							'DateAdded'=>$date,
							'PaymentReferenceId'=>$this->input->post('epincode'),
							'Description'=> "Member Upgrade using epin id ".$this->input->post('epincode'),
							'Credit'=>$pckdetails->EpinAmount,
							'Debit'=>$pckdetails->EpinAmount,
							'Balance'=>$bal,
							'TypeId'=>"19");

					$result1 = $this->common_model->SaveRecords($data1,'arm_history');

					// echo $this->db->last_query();
					
					$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

							$field = "MemberId";
							$MemberId = $id;
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
								$field = "MonoLineId";
								$monomdet = $this->common_model->GetRow("MemberId='". $id."' order by MonoLineId ASC LIMIT 0,1","arm_monolinematrix");

								$MemberId = $monomdet->MonoLineId;
							}

							else if($mlsetting->Id==4)
							{
								$table = "arm_binarymatrix";
							}
							else if($mlsetting->Id==5)
							{
								$table = "arm_boardmatrix";
								$field = "BoardMemberId";
								$brdmdet = $this->common_model->GetRow("MemberId='". $id."' order by BoardMemberId ASC LIMIT 0,1","arm_monolinematrix");

								$MemberId = $brdmdet->MemberId;
							}
							else if($mlsetting->Id==6)
							{
								$table = "arm_xupmatrix";
							}
							else if($mlsetting->Id==7)
							{
								$table = "arm_oddevenmatrix";
							}
						$bb = $this->MemberCommission_model->process($MemberId,$table,$field);
					}
					
					$this->session->set_flashdata('success_message', $this->lang->line('successmessage'));
					redirect('user/upgrade');
					exit;



				}
				else
				{
				 $this->session->set_flashdata('error_message', $this->lang->line('errormessageepinmiss'));
				 redirect('user/upgrade');
				 exit;

				}
			}
			else
				{
				 $this->session->set_flashdata('error_message', $this->lang->line('errormessageepinavail'));
				 redirect('user/upgrade');
				 exit;
				
				}
			
			
		}
		
		// $this->load->view('user/upgrade');
	}

	public function checkbalance($id='')
	{

		if($this->input->post('checkwire')=='check')
		{
			
			$memberid=$this->input->post('memberid');

			$mdetails = $this->common_model->GetRow("MemberId='".$memberid."'",'arm_members');
			$balance=$this->input->post('current');
			$packageamt=$this->input->post('paymentamount');
			$package=$this->input->post('package');
			// echo $package;
			// exit;

			if($balance)
			{
				$this->form_validation->set_rules('current','current','trim|required|callback_bal_check');
			}
			if($this->form_validation->run()==true)
			{
					$date = date('y-m-d h:i:s');
					$Mdata = array('SubscriptionsStatus'=>'Active',
							'MemberStatus'=>'Active',
							'PackageId'=>$id,
							'ModifiedDate'=>$date);
					$result = $this->common_model->UpdateRecord($Mdata, "MemberId='".$memberid."'", 'arm_members');

					if($result)
					{
							$debitbalnce=$balance-$packageamt;
							$txnid = "UPG".rand(1111111,9999999);
							$data1 = array('MemberId'=>$memberid,
							'TransactionId'=>$txnid,
							'DateAdded'=>$date,
							'Description'=> "Member Upgrade using Account Balance",
							'Credit'=>$packageamt,
							'Debit'=>$packageamt,
							'Balance'=>$debitbalnce,
							'TypeId'=>"19");

						$result1 = $this->common_model->SaveRecords($data1,'arm_history');
						if($result1)
						{

							$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
							$field = "MemberId";
							$MemberId = $id;
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
								$field = "MonoLineId";
								$monomdet = $this->common_model->GetRow("MemberId='". $id."' order by MonoLineId ASC LIMIT 0,1","arm_monolinematrix");
								$MemberId = $monomdet->MonoLineId;
							}

							else if($mlsetting->Id==4)
							{
								$table = "arm_binarymatrix";
							}
							else if($mlsetting->Id==5)
							{
								$table = "arm_boardmatrix";
								$field = "BoardMemberId";
							}
							else if($mlsetting->Id==6)
							{
								$table = "arm_xupmatrix";
							}
							else if($mlsetting->Id==7)
							{
								$table = "arm_oddevenmatrix";
							}
							$bb = $this->MemberCommission_model->process($MemberId,$table,$field);
					  		/*$this->session->set_flashdata('success_message','Successfully Upgrade Your Package');
					  		$this->load->view('user/upgrade');*/
					  		header("Content-Type: application/json");
							$response["success"] = 1;
							$response["message"]='Successfully Upgrade Your Package';
							echo json_encode($response);
							exit;
						}
						else
						{
							//$this->session->set_flashdata('error_message','Sorry Your package Not Uppgrade');
			            	//$this->load->view('user/upgrade');
			            	header("Content-Type: application/json");
							$response["success"] = 0;
							$response["message"]='Sorry Your package Not Uppgrade';
							echo json_encode($response);
							exit;
						}

					}
				}
				else
				{	
					header("Content-Type: application/json");
					$response["success"] = 0;
					$response["message"]=validation_errors();
					echo json_encode($response);
					exit;
					//$this->session->set_flashdata('error_message','Sorry Your Are Not Upgrade Your package');
			 		//$this->load->view('user/upgrade');
				}
			}
			else
			{

				header("Content-Type: application/json");
				$response["success"] = 0;
				$response["message"]="No Post Parameters Passed";
				echo json_encode($response);
				exit;

			}
	}

	public function paymentsuccess()
	{
		
		if($this->input->post())
		{
			
		$checkdata = explode(",",$this->input->post('custom'));
		$memberdetails = $this->common_model->GetCustomer($checkdata[2]);

		$condition = "PackageId='".$this->input->post('item_number')."'";
		$packagedetails = $this->common_model->GetRow($condition,'arm_package');
		
		if(strtolower($checkdata[0])=='upgrade' && strtolower($checkdata[1])== 'paypal' && strtolower($checkdata[2])!='' )
		{

				if($this->input->post('mc_gross')>= $packagedetails->PackageFee)
				{
					$date = date('y-m-d h:i:s');
					$data = array('SubscriptionsStatus'=>'Active','MemberStatus'=>'Active','ModifiedDate'=>$date,'PackageId'=>$this->input->post('item_number'));
					$condition = "MemberId='".$checkdata[2]."'";
					$result = $this->common_model->UpdateRecord($data,$condition,'arm_members');
					if($result)
					{
						$bal = $this->common_model->Getcusomerbalance($checkdata[2]);
						$txnid = "UPG".rand(1111111,9999999);
						
						$data1 = array('MemberId'=>$checkdata[2],
							'TransactionId'=>$txnid,
							'DateAdded'=>$date,
							'PaymentReferenceId'=>$this->input->post('txn_id'),
							'Description'=> "Member Upgrade using paypal id ".$this->input->post('txn_id'),
							'Credit'=>$packagedetails->PackageFee,
							'Debit'=>$packagedetails->PackageFee,
							'Balance'=>$bal,
							'TypeId'=>"19");

					$result1 = $this->common_model->SaveRecords($data1,'arm_history');
					
					$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
							$field = "MemberId";
							$MemberId = $memberdetails->MemberId;
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
								$field = "MonoLineId";
								$monomdet = $this->common_model->GetRow("MemberId='". $memberdetails->MemberId."' order by MonoLineId ASC LIMIT 0,1","arm_monolinematrix");

								$MemberId = $monomdet->MonoLineId;
							}

							else if($mlsetting->Id==4)
							{
								$table = "arm_binarymatrix";
							}
							else if($mlsetting->Id==5)
							{
								$table = "arm_boardmatrix";
								$field = "BoardMemberId";
								$brdmdet = $this->common_model->GetRow("MemberId='". $memberdetails->MemberId."' order by BoardMemberId ASC LIMIT 0,1","arm_monolinematrix");

								$MemberId = $brdmdet->MemberId;
							}
							else if($mlsetting->Id==6)
							{
								$table = "arm_xupmatrix";
							}
							else if($mlsetting->Id==7)
							{
								$table = "arm_oddevenmatrix";
							}
						$bb = $this->MemberCommission_model->process($MemberId,$table,$field);

					}
					
					$this->session->set_flashdata('success_message', $this->lang->line('successmessage'));
				}
				else
				{
				$this->session->set_flashdata('error_message', $this->lang->line('errormessagepayment'));
				}
		}

		if(strtolower($checkdata[0])=='upgrade' && strtolower($checkdata[1])== 'bitcoin' && strtolower($checkdata[2])!='' )
		{

			echo "add soon ";

		}

		}
		
		
		redirect('user/upgrade');
	}
	public function GetBoardSpillover($Downids,$boardid,$table)
	{
		
		$array = $Downids;
		
		$Count = count($array)-1;
		
		for($i=0;$i<$Count;$i++) 
		{
			$downid = $array[$i];
			
			$spids = $this->common_model->GetResults("SpilloverId = '".$downid."' AND BoardId='".$boardid."'",$table);
			// print_r($spids);
			$Rows = $this->common_model->GetRowCount("SpilloverId = '".$downid."'AND BoardId='".$boardid."'",$table);
			
			if($Rows > 0)
			{
				
				
				for($j=0; $j<$Rows; $j++) 
				{
					if(!in_array($spids[$j]->BoardMemberId,$array))
					{
						$Count+=1; 
						array_push($array,$spids[$j]->BoardMemberId);
					}
					
				}
			}
		}
		
		return $array;
	}


	public function mtau_check()
	{
		$ckip = $this->common_model->GetRowCount("MemberId='".$this->input->post('memberid')."' AND AdminStatus='0' AND EntryFor='MTAU'","arm_memberpayment");
		
		if($ckip>0)
		{
			$this->form_validation->set_message('mtau_check',ucwords($this->lang->line('errormtaumsg')));
			return false;
		}
		else
		{
			return true;
		}
		exit;
	}

	public function bal_check($str)
	{
	  $packageamount=$this->input->post('paymentamount');

	  if($str >= $packageamount)
	  {
	  	return true;
	  }
	  else
	  {
	  	$this->form_validation->set_message('balance_check','Sorry Your Balance is Low Please Upgrade Package Other Payment Way');
	  	return false;
	  }
	}

	
	
}
