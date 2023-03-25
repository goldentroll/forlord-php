
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
	    $regset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='allowregistration'", "arm_setting");
			
		if($regset->ContentValue=="Off")
		{
			redirect("user");
			exit;
		}

	    $this->load->model('admin/Smtpsetting_model');
		$this->lang->load('register');
		$this->load->model('MemberCommission_model');
		$this->load->model('Memberboardprocess_model');
		$this->load->helper('sms');
		$this->load->library('Email');
		$this->lang->load('common',$this->session->userdata('language'));
	}



	public function index($name='')
	{
		$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
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
	    $config['protocol']         = "smtp";
	    $config['smtp_host']        = $smtphost;
	    $config['smtp_port']        = $smtpport;
	    $config['mailtype'] 		= 'html';
	    $config['charset']  		= 'utf-8';
	    $config['newline']  		= "\r\n";
	    $config['wordwrap'] 		= TRUE;
		$this->email->clear(TRUE);
		   	   
		if($this->input->get('ref'))
		{
			$name = $this->input->get('ref');
			$uplineid = $this->input->get('ref');
			$check_user =$this->db->query("SELECT * FROM arm_members where UserName='".$name."'")->row();
	
			if($check_user->PackageIdU!=2)
			{
				$this->session->set_flashdata('error_message',"The user is not active Premium Pacakge!..");
				redirect('user/register');
			}
			else
			{
				if($this->input->get('P') == 'L'){
					$position = 'Left';
				}
				else{
					$position = 'Right';
				}
			}
	
		}
		
		if($name=='') {

			$defuser = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='defaultsponsors'", "arm_setting");
			$rcondition = " MemberId='".$defuser->ContentValue."'";
			$rdetails = $this->common_model->GetRow($rcondition,"arm_members");	
			$name = $rdetails->ReferralName;
			$uplineid = "";
			$position = '';
		}

		
		if($this->input->post('reg')!='')
		{

			$rcondition = " ReuireFieldStatus ='1' AND FieldEnableStatus ='1'  order by FieldPosition ASC";
			$rtableName = 'arm_requirefields';

			$rccondition = " ReuireFieldStatus ='1' AND FieldEnableStatus ='1' AND ReuireFieldName NOT IN ('UserName','Password','Phone','Email')";

			$requirefields = $this->common_model->GetResults($rccondition, $rtableName);
			

			foreach ($requirefields as $reqrows) {
				
			 	$this->form_validation->set_rules($reqrows->ReuireFieldName, $reqrows->ReuireFieldName, 'trim|required');

				if($reqrows->ReuireFieldName=='FirstName' || $reqrows->ReuireFieldName=='LastName' || $reqrows->ReuireFieldName =='MiddleName' )  {
					$this->form_validation->set_rules($reqrows->ReuireFieldName, $reqrows->ReuireFieldName, 'trim|required|callback_alphaspace');
				} 
			} 

	 		$minst = $this->common_model->GetRow("Page='usersetting' AND KeyValue='minuserpasswordlength'","arm_setting");
	 		$maxst = $this->common_model->GetRow("Page='usersetting' AND KeyValue='maxuserpasswordlength'","arm_setting");

		 	$this->form_validation->set_rules('UserName', 'UserName', 'trim|required|xss_clean|min_length[4]|callback_username_check');

		 	$this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email|callback_email_check');

		 	$this->form_validation->set_rules('Password', 'Password', 'trim|required|xss_clean|min_length['.$minst->ContentValue.']|max_length['.$maxst->ContentValue.']|callback_password_check');
		 
		 	$phset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='uniquemobile'", "arm_setting");
		 	$mailset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='uniqueemail'", "arm_setting");


		 	$this->form_validation->set_rules('RepeatPassword', 'RepeatPassword', 'trim|required|xss_clean|min_length['.$minst->ContentValue.']|max_length['.$maxst->ContentValue.']');
		 	
		 	
		 	$this->form_validation->set_rules('terms', 'terms & conditions', 'trim|required');

		 	$captchaset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='usecaptcha'", "arm_setting");
		 	if($captchaset->ContentValue=="On"){
		 		$this->form_validation->set_rules('g-recaptcha-response', 'g-recaptcha-response', 'required|callback_captcha_check');
		 	}

			$ipset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='uniqueip'", "arm_setting");
			if($ipset->ContentValue=="On")
				$this->form_validation->set_rules('IP', 'Ip address', 'callback_ip_check');
				//binary matrix position check if on 

		 	if($mlsetting->Id==4 &&  $mlsetting->Position==1 && $mlsetting->MatrixUpline==1) {
		 		$this->form_validation->set_rules('uplineid', 'uplineid', 'trim|required|callback_uplineid_checkk');
		 		$spliover = $this->input->post('uplineid');
		 		$this->form_validation->set_rules('position', 'Select Position', 'trim|required|callback_position_check['.$spliover.']');
		 	} else {
		 		if($mlsetting->Id==4 && $mlsetting->Position==1) {
		 			$this->form_validation->set_rules('position', 'Select Position', 'trim|required|callback_position_checks');
		 		}
		 	}
			


			if($this->form_validation->run() == TRUE)
			{	


				$memberfields = $this->db->list_fields('arm_members');

				$ccondition = " Page ='register' AND Status='1'";
				$ctableName = 'arm_customfields';
				$cfields = 'CustomName';
				$customfields = $this->common_model->GetResults($ccondition, $ctableName,$cfields);	
				$directids = $this->common_model->getreferralname($this->input->post('SponsorName'));

				if($directids=="")
				{
					$directid = 0;
				}
				else
				{
					$directid = $directids;
			    }
							
				if ($directid == 1) {
					
					$directid = $this->common_model->getreferralname('adminuser');
				}
							

				$SpilloverId = $this->common_model->getreferralname($this->input->post('uplineid'));
				$mlmdata= array('DirectId' => $directid);
				$data = array('SubscriptionsStatus' => 'Free','DirectId' => $directid);
				$condition1 = "UserName =" . "'" . $this->input->post('uplineid') . "'";
				$spillover_details = $this->common_model->GetSponsor($this->input->post('uplineid'), $condition1);	
				$data1 = array();

				$fields = $this->input->post();

				foreach ($fields as $key => $value) {
					
					if(in_array($key, $memberfields)) {
						if($key=='Password') {
							$data[$key]=SHA1(SHA1($value));
						} else {
							$data[$key]=$value;
						}
					}
					if($customfields) {
						for($i=0; $i<count($customfields); $i++) {
							
							if($key == $customfields[$i]->CustomName) {
								$data1[$key]=$value;
							}

						}
					}
				}

				if($spillover_details){
				$data['SpilloverId'] = $spillover_details->MemberId;

				}else{
				$data['SpilloverId'] = '0';

				}
						
				$data['CustomFields']= json_encode($data1);

				$data['ReferralName']= $this->input->post('UserName');
				$data['MemberStatus']= "Active";
				$data['OrderStatus']='1';
				$data['DateAdded']= date('y-m-d H:i:s');
				$data['PackageIdU']= '1';
				$data['PackageId']= 0;


				$subscriptiontype=$this->common_model->GetRow("KeyValue='subscriptiontype' AND Page='usersetting'","arm_setting");
				if($subscriptiontype->ContentValue=='monthly')
				{
					$period=30;
				}
				else
				{
					$period=365;
				}

				$endate = strtotime("+".$period." day", strtotime($data['DateAdded']));	
				$data['EndDate']=date('Y-m-d H:i:s ', $endate);
				$data['StartDate'] = date('Y-m-d H:i:s');

				if($this->input->post('TransactionPassword'))
				{
					$data['TransactionPassword']=SHA1(SHA1($this->input->post('TransactionPassword')));
				}
				else
				{
					$data['TransactionPassword']=SHA1(SHA1($this->input->post('Password')));
				}

				$data['Ip']	= $_SERVER['REMOTE_ADDR'];
				$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				

				if($mlsetting->Id==4 && $mlsetting->Position==1)
					$data['Position']=	$this->input->post('position');				

				$result = $this->common_model->SaveRecords($data,'arm_members');

				if($result) 
				{
					$userid = $this->db->insert_id();	
					if($userid)
					{			
					  // this is sent rank for directuser
					  $checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
								
					  if($checkmatrix->RankStatus==1)
					  {
					  	$checkdirectuser=$this->common_model->GetRowCount("DirectId='".$directid."'","arm_members");
					  	

					  	$cond="ReferalCount='".$checkdirectuser."' AND Status='1'";
					  	$checkrank=$this->common_model->GetRow($cond,"arm_ranksetting");
						// $directcountrank=$checkrank->ReferalCount;
							if($checkrank!="")
							{
								$rank=$checkrank->Rank;
								
								$userbal = $this->common_model->Getcusomerbalance($directid);
								$trnid = 'RAN'.rand(1111111,9999999);
								$date = date('y-m-d h:i:s');
								$datas = array(
									'MemberId'=>$directid,
									'Balance'=>$userbal,
									'Description'=>'Promoted'.'To target for achieve ReferalCount'.' '.$rank,
									'TransactionId'=>$trnid,
									'TypeId'=>'21',
									'Rankname'=>$checkrank->rank_id,

									'DateAdded'=>$date
								);

								$userdetails = $this->common_model->SaveRecords($datas,'arm_history');
								if($userdetails)
								{
								  $update_rank = $this->db->query("update arm_members set rank='".$checkrank->rank_id."' where MemberId='".$directid."'");
								}
																
							}
						}
					}
								
					$mlmdata['MemberId'] = $userid;		
					$message = $this->common_model->GetRow("Page='register'","arm_emailtemplate");
					$site = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'","arm_setting");   	
				   	$emailcont = urldecode($message->EmailContent);					   	
				   	$logo = '<img src="'.base_url().$site->ContentValue.'" style="height: 100px; width: 150px;">';
						$emailcont = str_replace('[LOGO]', $logo, $emailcont);
				   	$emailcont = str_replace('[FIRSTNAME]', $this->input->post('UserName'), $emailcont);
				   	$emailcont = str_replace('[USERNAME]', $this->input->post('UserName'), $emailcont);
				   	$emailcont = str_replace('[PASSWORD]', $this->input->post('Password'), $emailcont);
				   	$emailcont = str_replace('[URL]', base_url().'index.php?'.$this->input->post('UserName'), $emailcont);
				   	$emailcont = str_replace('[URL]', base_url(), $emailcont);


				   	
					$sitename = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitename'","arm_setting");				   	
				  	$adminid = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='adminmailid'","arm_setting");
					$this->email->from($smtpmail, $sitename->ContentValue);
				   	//$this->email->to($this->input->post('Email'));
				   	$this->email->to('palani@arminfotech.us');
					$this->email->subject($message->EmailSubject);
					$body =
							'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
							'.$emailcont.'
							</body>
							</html>';
					
			    	$this->email->message($body);    
					$this->email->set_mailtype("html");
				
			    	$Mail_status = $this->email->send();   
					
					$upline_mail = $this->common_model->GetRow("MemberId='".$directid."'","arm_members");

					if($upline_mail)
					{

						$this->email->from($smtpmail, $sitename->ContentValue);
						// $this->email->to($upline_mail->Email);
						$this->email->to('palani@arminfotech.us');
						$this->email->subject('New Member Register');
						$body1 =
								'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<title>Register Member Details</title>
								<style type="text/css">
								body {
								font-family: Arial, Verdana, Helvetica, sans-serif;
								font-size: 16px;
								}
								</style>
								</head>
								<body>
								'.$this->input->post('UserName').' New Downline Member Register Successfully..
								</body>
								</html>';
								
						$this->email->message($body1);    
						$this->email->set_mailtype("html");
						
						$Mail_status = $this->email->send();
					

					   $register_notification =  $this->db->query("UPDATE arm_members SET instagramurl = 1 WHERE MemberId ='".$upline_mail->MemberId."' ");


						$user = $this->common_model->GetRow("memberId='".$this->session->MemberID."' AND MemberStatus='Active'","arm_members");

						$datas = array(
						'MemberId'=>$userid,
						'DirectId'=>$upline_mail->DirectId,
						'type_id'=>'1',
						'status'=>'1',
						'date'=> date('Y-m-d'),
						);
						$arm_notification = $this->common_model->SaveRecords($datas,'arm_notification');


						if($Mail_status) {
							
							header("Content-Type: application/json");
							$response["success"] = 1;
							$response["message"] = "Register Successfully send to Mail";
							echo json_encode($response);
						} 
						else {
							
							$error_mail = $this->email->print_debugger();

							header("Content-Type: application/json");
							$response["success"] = 0;
							$response["message"] = "Reterive Failed. Pls check Mail configurations";
							echo json_encode($response);
						}

					}

				}




				$rcondition = " Page ='register'  order by FieldPosition ASC";
				$rtableName = 'arm_requirefields';
				$this->data['requirefields'] = $this->common_model->GetResults($rcondition, $rtableName);
				$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				if($mlsetting->Id==4) {
					$ptableName ="arm_pv";
				} 	
				elseif($mlsetting->Id==5 || $mlsetting->Id==8) {
					$ptableName ="arm_boardplan";
				} else {
					$ptableName ="arm_package";
				}
							
				$pcondition = " Status ='1'  order by PackageId ASC";
				$this->data['package'] = $this->common_model->GetResults($pcondition, $ptableName);
				$this->data['SponsorName']=$name;
				$this->data['uplineid']=$uplineid;
				$this->data['position']=$position;
				$this->data['country'] = $this->common_model->GetCountry();

				$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
				$memberpaysts = $this->common_model->GetRow("MatrixStatus='1'", 'arm_matrixsetting');


				if($memberpaysts->FreeMember==1) 
				{
					$data = array(
						'SubscriptionsStatus'=>"Active",
						'StartDate' => "0000-00-00 00:00:00"
					);


					if($memberpaysts->Id==6 && $memberpaysts->MTMPayStatus=='1') 
					{

						$mmdata = $this->common_model->GetRow("MemberId='".$userid."'","arm_members");
						$xmdata = $this->common_model->GetRow("MemberId='".$mmdata->DirectId."'","arm_xupmatrix");
						if($xmdata->XupCount< $memberpaysts->Position) {
							$data['SpilloverId'] = $xmdata->SpilloverId;
							// $xddata = $this->common_model->UpdateRecord("SpilloverId='".$xmdata->SpilloverId."'","MemberId='".$userid."'","arm_members");
						}
						else
						{
							$data['SpilloverId'] = $mmdata->DirectId;

						}
					}

					$memup=$this->common_model->UpdateRecord($data,"MemberId='".$userid."'","arm_members");

					if($memup)
					{
						$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
							
						$field = "MemberId";
						$memberid =$userid;
																
						if($mlsetting->Id==1)
						{
							$table = "arm_forcedmatrix";
							$this->Memberboardprocess_model->setforcematrix($memberid,$table);

						}
						else if($mlsetting->Id==2)
						{
							$table = "arm_unilevelmatrix";
							$this->Memberboardprocess_model->setunilevelmatrix($memberid,$table);
						}
						else if($mlsetting->Id==3)
						{
							$table = "arm_monolinematrix";
							$field = "MonoLineId";
							$this->Memberboardprocess_model->setmonolinematrix($memberid,$table);
						}
						else if($mlsetting->Id==4)
						{
							$table = "arm_binarymatrix";
							$this->Memberboardprocess_model->binarymatrix($memberid,$table);
							//$this->Memberboardprocess_model->Totaldowncount	();
						}
						else if($mlsetting->Id==5)
						{
							$table = "arm_boardmatrix";
							$this->Memberboardprocess_model->setboardmatrix($memberid,$table);
						}
						else if($mlsetting->Id==6)
						{
							$table = "arm_xupmatrix";
							$this->Memberboardprocess_model->setxupmatrix($memberid,$table);
						
							exit();
						}
						else if($mlsetting->Id==7)
						{
							$table = "arm_oddevenmatrix";
							$this->Memberboardprocess_model->setoddevenmatrix($memberid,$table);
						}
						
						//$this->MemberCommission_model->process($memberid,$table,$field);
					}


					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('success_message',"Registered Successfully");
						redirect('login');
					    exit();

					}
					else
					{

						$find_response=$this->db->query("select * from arm_members where MemberId='".$memberid."'")->row();
						$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
						if($mlsetting->Id==4)
							$table = "arm_pv";
						elseif($mlsetting->Id==9)
							$table = "arm_hyip";
						elseif($mlsetting->Id==5 || $mlsetting->Id==8) 
							$table = "arm_boardplan";
						else
							$table='arm_package';
						$package=$find_response->PackageId;
						$condition="PackageId='".$package."'";
						$package_det=$this->common_model->GetRow($condition,$table);
						$currency_condition = "Status='1'";
						$currency_settings= $this->common_model->GetRow($currency_condition,'arm_currency');
						$currency_code=$currency_settings->CurrencyCode;
						
						header("Content-Type: application/json");
						$response["success"] = 1;
						$response['package']=array('PackageId' => $package_det->PackageId, 'Package Name' => $package_det->PackageName,'Package Amount' => number_format($package_det->PackageFee,currency_decimal()), "currency" => $currency_code);
			    		$response["message"] = "Registered Successfully";
			    		$response["redirect"]="login";
						echo json_encode($response);
						exit;
					}
				} 

				else 
				{
					$this->common_model->UpdateRecord($data,"MemberId='".$userid."'","arm_members");
					$unpaid = array(
						"free_mem_id" => $userid
					);
					$this->session->set_userdata($unpaid);				
					$find_response=$this->db->query("select * from arm_members where MemberId='".$userid."'")->row();
					$data_user=array();
					foreach ($find_response as $key => $value) 
					{
						if($key!='CustomFields' && $key!='Payments')
						{
							$data_user[$key]=$value;
						}
						else
						{
							$data_user[$key]=json_decode($value,true);
						}
					}
								
					$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
					if($mlsetting->Id==4)
						$table = "arm_pv";
					elseif($mlsetting->Id==9)
						$table = "arm_hyip";
					elseif($mlsetting->Id==5 || $mlsetting->Id==8) 
						$table = "arm_boardplan";
					else
						$table='arm_package';

					$package=$find_response->PackageId;
					$condition="PackageId='".$package."'";
					$package_det=$this->common_model->GetRow($condition,$table);
					$currency_condition = "Status='1'";
					$currency_settings= $this->common_model->GetRow($currency_condition,'arm_currency');
					$currency_code=$currency_settings->CurrencyCode;

					if($this->input->post('web_mode')=='1')
					{
						redirect('user/register/payment/'.$userid);
					}
					else
					{
						header("Content-Type: application/json");
						$response["success"] = 1;
						$response["userinfo"]=$data_user;
						//$response["package"]=$package_det;
						$response['package']=array('PackageId' => $package_det->PackageId, 'Package Name' => $package_det->PackageName,'Package Amount' => number_format($package_det->PackageFee,currency_decimal()), "currency" => $currency_code);

			    		$response["message"] = "Register Payment";
			    		$response["redirect"]="user/register/payment/".$userid;
						echo json_encode($response);
						exit;
					}		
				}

			} 
			else 
			{

				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('error_message',$this->lang->line('errormessage'));
					$rcondition = " Page ='register'  order by FieldPosition ASC";
					$rtableName = 'arm_requirefields';

					$this->data['requirefields'] = $this->common_model->GetResults($rcondition, $rtableName);
					$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

					if($mlsetting->Id==4) {
						$ptableName ="arm_pv"; 
					}				
					elseif($mlsetting->Id==5 || $mlsetting->Id==8) {
						$ptableName ="arm_boardplan";

					} else {
						$ptableName ="arm_package";
					}
					// echo $ptableName;

					$pcondition = "Status ='1'  order by PackageId ASC";
				
					$this->data['package'] = $this->common_model->GetResults($pcondition,$ptableName);
					
					$this->data['SponsorName'] = $name;
					$this->data['uplineid'] = $uplineid;
					$this->data['position'] = $position;
					$this->data['country'] = $this->common_model->GetCountry();
					$this->load->view('user/register',$this->data);
				}
				else
				{

					header("Content-Type: application/json");
					$response["success"] = 0;
					$response["message"] = validation_errors();
					$response["redirect"]="login";
					echo json_encode($response);
					exit;
				}
			}

		}
		else
		{

			$Randomword =rand('111111','999999');
			$this->session->unset_userdata('captchaword');
			$this->session->set_userdata('captchaword', $Randomword);
			$vals = array(
				'word' => $Randomword,
		        'img_path' => './captcha/',
		        'img_url' => base_url().'captcha/',
		        'img_width' => '120',
		    	'img_height' => '40',
		    	'expiration' => 7200
	        );

			$captcha = create_captcha($vals);
			$this->data['captcha'] = $captcha;

			$rcondition = " Page ='register'  order by FieldPosition ASC";
			$rtableName = 'arm_requirefields';
			$this->data['requirefields'] = $this->common_model->GetResults($rcondition, $rtableName);

			$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
			

			if($mlsetting->Id=='4') {
				$ptableName="arm_pv"; 
			}
			elseif($mlsetting->Id=='5' || $mlsetting->Id=='8') {
				$ptableName="arm_boardplan";
			} else {
				$ptableName="arm_package";
			}


			$pcondition = "Status ='1'  order by PackageId ASC";
			$this->data['package'] = $this->common_model->GetResults($pcondition, $ptableName);
	
			
			if($name)
			{
				$rcondition = " UserName='".$name."'";
				$rdetails = $this->common_model->GetRow($rcondition,"arm_members");	

				if($rdetails->MemberId==2)
				{
					$name ="";
				}
				else
				{
					$name = $name;
				}

			}

			$this->data['SponsorName'] = $name;
			$this->data['uplineid'] = $uplineid;
			$this->data['position'] = $position;
			$this->data['country'] = $this->common_model->GetCountry();	
			$this->load->view('user/register',$this->data);
			
		}

	}

	public function create()
	{

		if($this->input->post('reg')!='') 
		{

			$rcondition = " ReuireFieldStatus ='1' AND FieldEnableStatus ='1'  order by FieldPosition ASC";
			$rtableName = 'arm_requirefields';
			$rccondition = " ReuireFieldStatus ='1' AND FieldEnableStatus ='1' AND ReuireFieldName NOT IN ('UserName','Password','Phone','Email')";
			$requirefields = $this->common_model->GetResults($rccondition, $rtableName);
			foreach ($requirefields as $reqrows) 
			{
				$this->form_validation->set_rules($reqrows->ReuireFieldName, $reqrows->ReuireFieldName, 'trim|required');

				if($reqrows->ReuireFieldName=='FirstName' || $reqrows->ReuireFieldName=='LastName' || $reqrows->ReuireFieldName =='MiddleName' )  
				{
					$this->form_validation->set_rules($reqrows->ReuireFieldName, $reqrows->ReuireFieldName, 'trim|required|callback_alphaspace');
				} 
				else if($reqrows->ReuireFieldName =='Zip' || $reqrows->ReuireFieldName =='Phone'  || $reqrows->ReuireFieldName == 'Fax') 
				{
			 			$this->form_validation->set_rules($reqrows->ReuireFieldName, $reqrows->ReuireFieldName, 'trim|required|integer');
				} 
				else if($reqrows->ReuireFieldName =='Gender') 
				{
					$this->form_validation->set_rules($reqrows->ReuireFieldName, $reqrows->ReuireFieldName, 'trim|required');
				} 
				else if($reqrows->ReuireFieldName=='City' || $reqrows->ReuireFieldName =='bankwirename' ) 
				{
					$this->form_validation->set_rules($reqrows->ReuireFieldName, $reqrows->ReuireFieldName, 'trim|required|callback_customAlpha');
				}
			} 

	 		$minst = $this->common_model->GetRow("Page='usersetting' AND KeyValue='minuserpasswordlength'","arm_setting");
	 		$maxst = $this->common_model->GetRow("Page='usersetting' AND KeyValue='maxuserpasswordlength'","arm_setting");
			$this->form_validation->set_rules('UserName', 'UserName', 'trim|required|xss_clean|min_length[4]|callback_regusername_check');
		 	$this->form_validation->set_rules('Password', 'Password', 'trim|required|xss_clean|min_length['.$minst->ContentValue.']|max_length['.$maxst->ContentValue.']|callback_password_check');
		 	$this->form_validation->set_rules('Phone', 'Phone', 'trim|required|integer|xss_clean|min_length[10]|max_length[13]');
		 	$phset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='uniquemobile'", "arm_setting");
		 	$mailset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='uniqueemail'", "arm_setting");
			if($phset->ContentValue=="On")
		 		$this->form_validation->set_rules('Phone', 'Phone', 'trim|required|integer|xss_clean|min_length[10]|max_length[13]|callback_phone_check');

		 	$this->form_validation->set_rules('RepeatPassword', 'RepeatPassword', 'trim|required|xss_clean|min_length['.$minst->ContentValue.']|max_length['.$maxst->ContentValue.']');
		 	
		 	$this->form_validation->set_rules('SponsorName', 'SponsorName', 'trim|required|xss_clean|callback_sponsorname_check');

		 	
		 	$this->form_validation->set_rules('terms', 'terms & conditions', 'trim|required');

		 	$captchaset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='usecaptcha'", "arm_setting");
		 	if($captchaset->ContentValue=="On"){
		 		$this->form_validation->set_rules('g-recaptcha-response', 'g-recaptcha-response', 'required|callback_captcha_check');
		 	}
		 	$ipset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='uniqueip'", "arm_setting");
			if($ipset->ContentValue=="On")
				$this->form_validation->set_rules('IP', 'Ip address', 'callback_ip_check');
			if($mlsetting->Id==4 &&  $mlsetting->Position==1 && $mlsetting->MatrixUpline==1) {
		 		$this->form_validation->set_rules('uplineid', 'uplineid', 'trim|required|callback_uplineid_checkk');
		 		$spliover = $this->input->post('uplineid');
		 		$this->form_validation->set_rules('position', 'Select Position', 'trim|required|callback_position_check['.$spliover.']');
		 	} else {
		 		if($mlsetting->Id==4 && $mlsetting->Position==1) {
		 			$this->form_validation->set_rules('position', 'Select Position', 'trim|required|callback_position_checks');
		 		}
		 	}


		 	if($this->form_validation->run() == TRUE)
			{	

				$memberfields = $this->db->list_fields('arm_members');
				$ccondition = " Page ='register' AND Status='1'";
				$ctableName = 'arm_customfields';
				$cfields = 'CustomName';
				$customfields = $this->common_model->GetResults($ccondition, $ctableName,$cfields);	
				$directid = $this->common_model->getreferralname($this->input->post('SponsorName'));
				$SpilloverId = $this->common_model->getreferralname($this->input->post('uplineid'));
				$mlmdata= array('DirectId' => $directid);
				$data = array('SubscriptionsStatus' => 'Free','DirectId' => $directid);
				$condition1 = "UserName =" . "'" . $this->input->post('uplineid') . "'";
				$spillover_details = $this->common_model->GetSponsor($this->input->post('uplineid'), $condition1);
				$data1 = array();
				$fields = $this->input->post();
				foreach ($fields as $key => $value) 
				{
					if(in_array($key, $memberfields)) 
					{
						if($key=='Password') {
							$data[$key]=SHA1(SHA1($value));
						} else {
							$data[$key]=$value;
						}
					}
					if($customfields) {
						for($i=0; $i<count($customfields); $i++) {
							
							if($key == $customfields[$i]->CustomName) {
								$data1[$key]=$value;
							}

						}
					}
				}
				if($spillover_details){
				$data['SpilloverId'] = $spillover_details->MemberId;

				}else{
				$data['SpilloverId'] = '0';

				}
			
				$data['CustomFields']= json_encode($data1);

				$data['ReferralName']= $this->input->post('UserName');
				$data['MemberStatus']= "Active";
				$data['OrderStatus']='1';
				$data['DateAdded']= date('y-m-d H:i:s');
				$data['PackageIdU']=1;

				$subscriptiontype=$this->common_model->GetRow("KeyValue='subscriptiontype' AND Page='usersetting'","arm_setting");
				if($subscriptiontype->ContentValue=='monthly')
				{
					$period=30;
				}
				else
				{
					$period=365;
				}
				$endate = strtotime("+".$period." day", strtotime($data['DateAdded']));
				$data['EndDate']=date('Y-m-d H:i:s ', $endate);
				$data['StartDate'] = date('Y-m-d H:i:s');

				if($this->input->post('TransactionPassword'))
				{
					$data['TransactionPassword']=SHA1(SHA1($this->input->post('TransactionPassword')));
				}
				else
				{
					$data['TransactionPassword']=SHA1(SHA1($this->input->post('Password')));
				}

				$data['Ip']	= $_SERVER['REMOTE_ADDR'];
				$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				if($mlsetting->Id==4 && $mlsetting->Position==1)
					$data['Position']=	$this->input->post('position');
				
				$result = $this->common_model->SaveRecords($data,'arm_members');

				if($result) 
				{
					$userid = $this->db->insert_id();
					if($userid)
					{
						$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
						if($checkmatrix->RankStatus==1)
					    {
						  	$checkdirectuser=$this->common_model->GetRowCount("DirectId='".$directid."'","arm_members");
						  	$cond="ReferalCount='".$checkdirectuser."' AND Status='1'";
						  	$checkrank=$this->common_model->GetRow($cond,"arm_ranksetting");
							if($checkrank!="")
							{
								$rank=$checkrank->Rank;
								$userbal = $this->common_model->Getcusomerbalance($directid);
								$trnid = 'RAN'.rand(1111111,9999999);
								$date = date('y-m-d h:i:s');
								$datas = array(
								'MemberId'=>$directid,
								'Balance'=>$userbal,
								'Description'=>'Promoted'.'To target for achieve ReferalCount'.' '.$rank,
								'TransactionId'=>$trnid,
								'TypeId'=>'21',
								'Rankname'=>$checkrank->rank_id,

								'DateAdded'=>$date
							);

							$userdetails = $this->common_model->SaveRecords($datas,'arm_history');

							if($userdetails)
							{
							  $update_rank = $this->db->query("update arm_members set rank='".$checkrank->rank_id."' where MemberId='".$directid."'");
							}
													
						}
					  }
					}
					
					$mlmdata['MemberId'] = $userid;
					
					$message = $this->common_model->GetRow("Page='register'","arm_emailtemplate");
					$site = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'","arm_setting");
			   	
				   	$emailcont = urldecode($message->EmailContent);
				   	
				   	$logo = '<img src="'.base_url().$site->ContentValue.'" style="height: 100px; width: 150px;">';
		   			$emailcont = str_replace('[LOGO]', $logo, $emailcont);
				   	$emailcont = str_replace('[FIRSTNAME]', $this->input->post('UserName'), $emailcont);
				   	$emailcont = str_replace('[USERNAME]', $this->input->post('UserName'), $emailcont);
				   	$emailcont = str_replace('[PASSWORD]', $this->input->post('Password'), $emailcont);
				   	$emailcont = str_replace('[URL]', base_url().'index.php?'.$this->input->post('UserName'), $emailcont);
				   	$emailcont = str_replace('[URL]', base_url(), $emailcont);
					$sitename = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitename'","arm_setting");				   	
				  	$adminid = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='adminmailid'","arm_setting");
					$this->email->from($smtpmail, $sitename->ContentValue);
				   	//$this->email->to($this->input->post('Email'));
				   $this->email->to('palani@arminfotech.us');
					$this->email->subject($message->EmailSubject);
					$body =
							'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
							'.$emailcont.'
							</body>
							</html>';
			    	$this->email->message($body);    
					$this->email->set_mailtype("html");
				
			    	$Mail_status = $this->email->send();    	 
				}

				$rcondition = " Page ='register'  order by FieldPosition ASC";
				$rtableName = 'arm_requirefields';
				$this->data['requirefields'] = $this->common_model->GetResults($rcondition, $rtableName);
				$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				if($mlsetting->Id==4) {

					$ptableName ="arm_pv";

				} 
				
				elseif($mlsetting->Id==5 || $mlsetting->Id==8) {

					$ptableName ="arm_boardplan";

				} else {

					$ptableName ="arm_package";
				}
				
				$pcondition = " Status ='1'  order by PackageId ASC";
				$this->data['package'] = $this->common_model->GetResults($pcondition, $ptableName);

				
				$this->data['SponsorName']=$name;
				$this->data['uplineid']=$uplineid;
				$this->data['position']=$position;
				$this->data['country'] = $this->common_model->GetCountry();

				$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
				$memberpaysts = $this->common_model->GetRow("MatrixStatus='1'", 'arm_matrixsetting');
				if($memberpaysts->FreeMember==1) 
				{
					$data = array(
						'SubscriptionsStatus'=>"Active",
						'StartDate' => "0000-00-00 00:00:00"

					);
					if($memberpaysts->Id==6 && $memberpaysts->MTMPayStatus=='1') {

						$mmdata = $this->common_model->GetRow("MemberId='".$userid."'","arm_members");
						$xmdata = $this->common_model->GetRow("MemberId='".$mmdata->DirectId."'","arm_xupmatrix");
						if($xmdata->XupCount< $memberpaysts->Position) {
							$data['SpilloverId'] = $xmdata->SpilloverId;
						}
						else
						{
							$data['SpilloverId'] = $mmdata->DirectId;

						}
					}
					$memup=$this->common_model->UpdateRecord($data,"MemberId='".$userid."'","arm_members");

					if($memup)
					{
						$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
						

						$field = "MemberId";
						$memberid =$userid;
													
						if($mlsetting->Id==1)
						{
							$table = "arm_forcedmatrix";
							$this->Memberboardprocess_model->setforcematrix($memberid,$table);
						}
						else if($mlsetting->Id==2)
						{
							$table = "arm_unilevelmatrix";
							$this->Memberboardprocess_model->setunilevelmatrix($memberid,$table);

							


						}
						else if($mlsetting->Id==3)
						{
							$table = "arm_monolinematrix";
							$field = "MonoLineId";
							$this->Memberboardprocess_model->setmonolinematrix($memberid,$table);
						}
						else if($mlsetting->Id==4)
						{
							$table = "arm_binarymatrix";
							$this->Memberboardprocess_model->binarymatrix($memberid,$table);
							//$this->Memberboardprocess_model->Totaldowncount();
						}
						else if($mlsetting->Id==5)
						{
							$table = "arm_boardmatrix";
							$this->Memberboardprocess_model->setboardmatrix($memberid,$table);
						}
						else if($mlsetting->Id==6)
						{
							$table = "arm_xupmatrix";
							$this->Memberboardprocess_model->setxupmatrix($memberid,$table);
						}
						else if($mlsetting->Id==7)
						{
							$table = "arm_oddevenmatrix";
							$this->Memberboardprocess_model->setoddevenmatrix($memberid,$table);
						}
						$this->MemberCommission_model->process($memberid,$table,$field);
					}

					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('success_message',"Registered Successfully");
						redirect('login');
					

					}
					else
					{
						$find_response=$this->db->query("select * from arm_members where MemberId='".$memberid."'")->row();
						$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
						if($mlsetting->Id==4)
							$table = "arm_pv";
						elseif($mlsetting->Id==9)
							$table = "arm_hyip";
						elseif($mlsetting->Id==5 || $mlsetting->Id==8) 
							$table = "arm_boardplan";
						else
							$table='arm_package';
						$package=$find_response->PackageId;
						$condition="PackageId='".$package."'";
						$package_det=$this->common_model->GetRow($condition,$table);
						$currency_condition = "Status='1'";
						$currency_settings= $this->common_model->GetRow($currency_condition,'arm_currency');
						$currency_code=$currency_settings->CurrencyCode;
						header("Content-Type: application/json");
						$response["success"] = 1;
		        		$response["message"] = "Registered Successfully";
		        		$response['package']=array('PackageId' => $package_det->PackageId, 'Package Name' => $package_det->PackageName,'Package Amount' => number_format($package_det->PackageFee,currency_decimal()), "currency" => $currency_code);
		        		$response["redirect"]="login";
						echo json_encode($response);
						exit;
					}


					
				} 
				else 
				{
					$this->common_model->UpdateRecord($data,"MemberId='".$userid."'","arm_members");
					$unpaid = array(
						"free_mem_id" => $userid
					);
					$this->session->set_userdata($unpaid);
				

					$find_response=$this->db->query("select * from arm_members where MemberId='".$userid."'")->row();
					$data_user=array();
					foreach ($find_response as $key => $value) 
					{
						if($key!='CustomFields' && $key!='Payments')
						{
							$data_user[$key]=$value;
						}
						else
						{
							$data_user[$key]=json_decode($value,true);
						}
					}
					
					$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
					if($mlsetting->Id==4)
						$table = "arm_pv";
					elseif($mlsetting->Id==9)
						$table = "arm_hyip";
					elseif($mlsetting->Id==5 || $mlsetting->Id==8) 
						$table = "arm_boardplan";
					else
						$table='arm_package';
					$package=$find_response->PackageId;
					$condition="PackageId='".$package."'";
					$package_det=$this->common_model->GetRow($condition,$table);
					if($this->input->post('web_mode')=='1')
					{
						redirect('user/register/payment/'.$userid);
					}
					else
					{
						header("Content-Type: application/json");
						$response["success"] = 1;
						$response["userinfo"]=$data_user;
						$currency_condition = "Status='1'";
						$currency_settings= $this->common_model->GetRow($currency_condition,'arm_currency');
						$currency_code=$currency_settings->CurrencyCode;
						//$response["package"]=$package_det;
						$response['package']=array('PackageId' => $package_det->PackageId, 'Package Name' => $package_det->PackageName,'Package Amount' => number_format($package_det->PackageFee,currency_decimal()), "currency" => $currency_code);
						$response["message"] = "Register Payment";
		        		$response["redirect"]="user/register/payment/".$userid;
						echo json_encode($response);
						exit;
					}
				}
			}
			else
			{
				header("Content-Type: application/json");
				$response["success"] = 0;
	    		$response["message"] =validation_errors();
	    		$response["redirect"]="user/register";
				echo json_encode($response);
				exit;

			}
		}
		else
		{
			header("Content-Type: application/json");
			$response["success"] = 0;
    		$response["message"] ="No Post Parameters Passed";
    		$response["redirect"]="user/register";
			echo json_encode($response);
			exit;

		}


	}


	public function username_check($str)
	{
		$username=$this->input->post('UserName');

		$check=$this->db->query("select * from arm_members where UserName='".$username."'")->row();	
		if($check)
		{
			$this->form_validation->set_message('username_check',ucwords($this->lang->line('errorusername')));
			return false;
		}
		else
		{
			return true;
		}
	}


	public function update_info()
	{
		$this->db->query("update arm_members set TransactionPassword=Password");

	}


	public function regusername_check($str)
	{
		$condition = "UserName =" . "'" . $str . "'";
		$this->db->select('*');
		$this->db->from('arm_members');
		$this->db->where($condition);
		$query = $this->db->get();

		if (!$query->num_rows()>0) {
			return true; 
		} else {
			$this->form_validation->set_message('regusername_check',ucwords($this->lang->line('errorusername')));
			return false;
		}
		
	}

	public function phone_check($str)
	{
		
		$condition = "Phone =" . "'" . $str . "'";
			
		// $UserName = $str;
		$this->db->select('*');
		$this->db->from('arm_members');
		$this->db->where($condition);
		$query = $this->db->get();

		if (!$query->num_rows()>0) {
			return true; 
		} else {
			$this->form_validation->set_message('phone_check',ucwords($this->lang->line('errorphone')));
			return false;
		}
		
	}


	public function email_check($str)
	{
		
		$condition = "Email =" . "'" . $str . "'";
			
		// $UserName = $str;
		$this->db->select('*');
		$this->db->from('arm_members');
		$this->db->where($condition);
		$query = $this->db->get();

		if (!$query->num_rows()>0) {
			return true; 
		} else{
			$this->form_validation->set_message('email_check',ucwords($this->lang->line('erroremailid')));
			return false;
		}
		
	}



	public function sponsorname_check($str)
	{
		
		$condition = "ReferralName =" . "'" . $str . "' AND SubscriptionsStatus='Active'";
		
			
		// $UserName = $str;
		$this->db->select('*');
		$this->db->from('arm_members');
		$this->db->where($condition);
		$query = $this->db->get();

		if ($query->num_rows()>0) {
			return true; 

		} else {
			$this->form_validation->set_message('sponsorname_check', ucwords($this->lang->line('errorsponsorname')));
			return false;
		}
		
	}

	public function captcha_check($str)
	{
		$this->load->library('recaptcha');
		$response = $this->recaptcha->verifyResponse($str);
		if (isset($response['success']) and $response['success'] === true) {
			return true;  
		}
		else
		{	
			$this->form_validation->set_message('captcha_check', ucwords($this->lang->line('errorcaptcha')));
			return false;
		}

	}

	public function password_check()
	{
		
		if( strcmp($this->input->post('Password'),$this->input->post('RepeatPassword'))==0)
		{
			return true; 
		}
		else
		{	
			$this->form_validation->set_message('password_check',ucwords($this->lang->line('errorpassword')));
			return false;
		}

	}

	public function payment($id='') {
		
		if($this->session->userdata('free_mem_id') OR $this->session->userdata('free_mem_id') OR $this->session->userdata('user_login')) {

			
			$this->data['userdetails'] = $this->common_model->GetCustomer($id);
			$this->load->model('admin/paymentsetting_model');
			$this->data['paymentdetails'] = $this->paymentsetting_model->Getpaymentdetails();
			
			$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
												
			if($mlsetting->Id==4) {
				$table = "arm_pv";

			}
			 elseif($mlsetting->Id==5 || $mlsetting->Id==8) {
				$table = "arm_boardplan";

			} else {
				$table='arm_package';
			}
			
			$condition="PackageId='".$this->data['userdetails']->PackageId."'";
			$this->data['packagedetails'] = $this->common_model->GetRow($condition,$table);

			$this->data['id'] =$id;
			$cdetail=$this->common_model->GetRow("Status='1'",'arm_currency');
			$this->data['CurrencySymbol'] =$cdetail->CurrencySymbol;

			if($this->data['userdetails'] && $this->data['paymentdetails'] && $this->data['packagedetails'] && $mlsetting->MTMPayStatus=='0')
			{
				$this->data['bwcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->userdata('free_mem_id')."' AND EntryFor='MTA' AND AdminStatus='0' and pay_mode='1'","arm_memberpayment");
				$this->data['chcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->userdata('free_mem_id')."' AND EntryFor='MTA' AND AdminStatus='0' and pay_mode='7'","arm_memberpayment");

				$this->data['ethcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->userdata('free_mem_id')."' AND EntryFor='MTE' AND AdminStatus='0' and pay_mode='1'","arm_memberpayment");



				$this->data['btccount'] = $this->common_model->GetRowCount("MemberId='".$this->session->userdata('free_mem_id')."' AND EntryFor='MTA' AND AdminStatus='0' and pay_mode='4'","arm_memberpayment");
				$this->data['blockcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->userdata('free_mem_id')."' AND EntryFor='MTA' AND AdminStatus='0' and pay_mode='12'","arm_memberpayment");

				
				$this->load->view('user/regpayment',$this->data);
			}
			else if($this->data['userdetails'] && $this->data['paymentdetails'] && $this->data['packagedetails'] && $mlsetting->MTMPayStatus=='1')
			{
				$this->load->view('user/mtmpayment',$this->data);
			}
			else
			{
				redirect('login');
			}

		} 
		else 
		{
			redirect('login');
		}
	}

	public function subscription($id='')
	{
		
		if($id) {
			$this->data['userdetails'] = $this->common_model->GetCustomer($id);
			
		} else {
			$id = $this->session->userdata('sub_mem_id');
			$this->data['userdetails'] = $this->common_model->GetCustomer($id);
		}
		
		$this->load->model('admin/paymentsetting_model');
		$this->data['paymentdetails'] = $this->paymentsetting_model->Getpaymentdetails();
		
		$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
											
		if($mlsetting->Id==4)
		{
			$table = "arm_pv";
		}
		elseif($mlsetting->Id==5 || $mlsetting->Id==8)
		{
			$table = "arm_boardplan";
		}
		else
		{
			$table='arm_package';
		}

		$condition="PackageId='".$this->data['userdetails']->PackageId."'";
		$this->data['packagedetails'] = $this->common_model->GetRow($condition,$table);

		$this->data['id'] =$id;
		$cdetail=$this->common_model->GetRow("Status='1'",'arm_currency');
		$this->data['CurrencySymbol'] =$cdetail->CurrencySymbol;

		if($this->data['userdetails'] && $this->data['paymentdetails'] && $this->data['packagedetails'] && $mlsetting->MTMPayStatus=='0')
		{
			$this->data['bwcount'] = $this->common_model->GetRowCount("MemberId='".$this->session->userdata('sub_mem_id')."' AND EntryFor='MTAS' AND AdminStatus='0'","arm_memberpayment");
			$this->load->view('user/subpayment',$this->data);
		}
		else if($this->data['userdetails'] && $this->data['paymentdetails'] && $this->data['packagedetails'] && $mlsetting->MTMPayStatus=='1')
		{
			$this->load->view('user/mtmpayment',$this->data);
		}
		else
		{
			redirect('login');
		}
	}

	public function paymentsuccess()
	{
		
		if($this->input->post())
		{
			//print_r($this->input->post());
			$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

			$checkdata = explode(",",$this->input->post('custom'));
			$memberdetails = $this->common_model->GetCustomer($checkdata[2]);

			$condition = "PackageId='".$memberdetails->PackageId."'";
			$packagedetails = $this->common_model->GetRow($condition,'arm_package');

			//print_r($packagedetails);

			if(strtolower($checkdata[0])=='register' && strtolower($checkdata[1])== 'paypal' && strtolower($checkdata[2])!='' && $mlsetting->MTMPayStatus=='0' )
			{

				if($this->input->post('mc_gross')>= $packagedetails->PackageFee)
				{
					$data = array('SubscriptionsStatus'=>'Active','MemberStatus'=>'Active');
					$condition = "MemberId='".$checkdata[2]."'";
					$result = $this->common_model->UpdateRecord($data,$condition,'arm_members');
					if($result)
					{
						$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
							
						$field = "MemberId";
						$memberid =$memberdetails->MemberId;
													
						if($mlsetting->Id==1)
						{
							$table = "arm_forcedmatrix";
							$this->Memberboardprocess_model->setforcematrix($memberid,$table);
						}
						else if($mlsetting->Id==2)
						{
							$table = "arm_unilevelmatrix";
							$this->Memberboardprocess_model->setunilevelmatrix($memberid,$table);
						}
						else if($mlsetting->Id==3)
						{
							$table = "arm_monolinematrix";
							$field = "MonoLineId";
							$this->Memberboardprocess_model->setmonolinematrix($memberid,$table);
						}
						else if($mlsetting->Id==4)
						{
							$table = "arm_binarymatrix";
							$this->Memberboardprocess_model->binarymatrix($memberid,$table);
							$this->Memberboardprocess_model->Totaldowncount();
						}
						else if($mlsetting->Id==5)
						{
							$table = "arm_boardmatrix";
							$this->Memberboardprocess_model->setboardmatrix($memberid,$table);
						}
						else if($mlsetting->Id==6)
						{
							$table = "arm_xupmatrix";
							$this->Memberboardprocess_model->setxupmatrix($memberid,$table);
						}
						else if($mlsetting->Id==7)
						{
							$table = "arm_oddevenmatrix";
							$this->Memberboardprocess_model->setoddevenmatrix($memberid,$table);
						}
						
	                    
						// $this->Memberboardprocess_model->process($memberid);
						$this->MemberCommission_model->process($memberid,$table,$field);
						
						$this->session->set_flashdata('success_message', $this->lang->line('successmessage'));
						$url = 'login'; echo'<script> window.location.href = "'.base_url().'index.php?/'.$url.'"; </script> ';
					    exit();
					}
					
					$this->session->set_flashdata('success_message', $this->lang->line('successmessage'));
				}
				else
				{
					$this->session->set_flashdata('error_message', $this->lang->line('errormessagepayment'));
				}
				
				redirect('login');
			}


			if(strtolower($checkdata[0])=='register' && strtolower($checkdata[1])== 'epin' && strtolower($checkdata[2])!='' )
			{

			}

		}
		
		redirect('login');
	}

	public function checkepin($id='')
	{
		if($this->input->post('check')=='check')
		{			
			
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$pckdetails = $this->common_model->GetRow("EpinTransactionId='".$this->input->post('epincode')."' AND EpinStatus='1' AND ExpiryDay>='".date('Y-m-d')."' ",'arm_epin');
			
			if($mdetails->SubscriptionsStatus=="Free")
			{
				
				if($pckdetails)
				{
					if($mdetails->PackageId==$pckdetails->EpinPackageId)
					{
					
						$date = date('y-m-d h:i:s');
						$Mdata = array(
							'SubscriptionsStatus'=>'Active',
							'MemberStatus'=>'Active',
							'ModifiedDate'=>$date
						);
						$result = $this->common_model->UpdateRecord($Mdata, "MemberId='".$id."'", 'arm_members');
						if($result)
						{
			
							$edata = array(
								'UsedBy'=>$id,
								'EpinStatus'=>'2',
								'ModifiedDate'=>$date
							);
							$epresult = $this->common_model->UpdateRecord($edata, "EpinRecordId='".$pckdetails->EpinRecordId."'", 'arm_epin');
						

							$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
							$field = "MemberId";
							$memberid = $id;
							if($mlsetting->Id==1)
							{
								$table = "arm_forcedmatrix";
								$this->Memberboardprocess_model->setforcematrix($memberid,$table);
							}
							else if($mlsetting->Id==2)
							{
								$table = "arm_unilevelmatrix";
								$this->Memberboardprocess_model->setunilevelmatrix($memberid,$table);
							}
							else if($mlsetting->Id==3)
							{
								$table = "arm_monolinematrix";
								$field = "MonoLineId";
								$this->Memberboardprocess_model->setmonolinematrix($memberid,$table);
							}
							else if($mlsetting->Id==4)
							{
								$table = "arm_binarymatrix";
								$this->Memberboardprocess_model->binarymatrix($memberid,$table);
							}
							else if($mlsetting->Id==5)
							{
								$table = "arm_boardmatrix";
								$this->Memberboardprocess_model->setboardmatrix($memberid,$table);
							}
							else if($mlsetting->Id==6)
							{
								$table = "arm_xupmatrix";
								$this->Memberboardprocess_model->setxupmatrix($memberid,$table);
							}
							else if($mlsetting->Id==7)
							{
								$table = "arm_oddevenmatrix";
								$this->Memberboardprocess_model->setoddevenmatrix($memberid,$table);
							}
							
							// $this->Memberboardprocess_model->process($memberid);
							$this->MemberCommission_model->process($memberid,$table,$field);
							
							$this->session->set_flashdata('success_message', $this->lang->line('successmessage'));
							$url = 'login';
						    echo'<script> window.location.href = "'.base_url().'index.php?/'.$url.'"; </script> ';
						   	exit();
						}
					}
				}
				else
				{
					$this->session->set_flashdata('error_message', $this->lang->line('errormessageepin'));
				}
				
			}
			else
			{
				$this->session->set_flashdata('success_message', $this->lang->line('successmessageactive'));
				$url = 'login';
				echo'<script> window.location.href = "'.base_url().'index.php?/'.$url.'"; </script> ';
				exit();
			}
			
			redirect('user/register/checkepin/'.$id);
			exit;
		}
		
		$this->load->view('user/checkepin');
	}
	

	public function subepin($id='')
	{
		if($this->input->post('check')=='check')
		{			
			
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$pckdetails = $this->common_model->GetRow("EpinTransactionId='".$this->input->post('epincode')."' AND EpinStatus='1' AND ExpiryDay>='".date('Y-m-d')."' ",'arm_epin');
							
			if($pckdetails)
			{
				if($mdetails->PackageId==$pckdetails->EpinPackageId)
				{
					
					$date = date('y-m-d h:i:s');
					$Mdata = array(
						'SubscriptionsStatus'=>'Active',
						'MemberStatus'=>'Active',
						'ModifiedDate'=>$date
					);
					$result = $this->common_model->UpdateRecord($Mdata, "MemberId='".$id."'", 'arm_members');
					if($result)
					{
			
						$edata = array(
							'UsedBy'=>$id,
							'EpinStatus'=>'2',
							'ModifiedDate'=>$date
						);
						$epresult = $this->common_model->UpdateRecord($edata, "EpinRecordId='".$pckdetails->EpinRecordId."'", 'arm_epin');

						$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
						$field = "MemberId";
						$memberid = $id;
						if($mlsetting->Id==1)
						{
							$table = "arm_forcedmatrix";
							$this->Memberboardprocess_model->setforcematrix($memberid,$table);
						}
						else if($mlsetting->Id==2)
						{
							$table = "arm_unilevelmatrix";
							$this->Memberboardprocess_model->setunilevelmatrix($memberid,$table);
						}
						else if($mlsetting->Id==3)
						{
							$table = "arm_monolinematrix";
							$field = "MonoLineId";
							$this->Memberboardprocess_model->setmonolinematrix($memberid,$table);
						}
						else if($mlsetting->Id==4)
						{
							$table = "arm_binarymatrix";
							$this->Memberboardprocess_model->binarymatrix($memberid,$table);
						}
						else if($mlsetting->Id==5)
						{
							$table = "arm_boardmatrix";
							$this->Memberboardprocess_model->setboardmatrix($memberid,$table);
						}
						else if($mlsetting->Id==6)
						{
							$table = "arm_xupmatrix";
							$this->Memberboardprocess_model->setxupmatrix($memberid,$table);
						}
						else if($mlsetting->Id==7)
						{
							$table = "arm_oddevenmatrix";
							$this->Memberboardprocess_model->setoddevenmatrix($memberid,$table);
						}
						

						// $this->Memberboardprocess_model->process($memberid);
						$this->MemberCommission_model->process($memberid,$table,$field);
							
						$this->session->set_flashdata('success_message', $this->lang->line('successmessage'));
						$url = 'login';
					    echo'<script> window.location.href = "'.base_url().'index.php?/'.$url.'"; </script> ';
						
					}

				}
				else
				{
					$this->session->set_flashdata('error_message', $this->lang->line('errormessageepin'));
					redirect('user/register/subepin/'.$id);
				}
			}
			
			redirect('user/login');
			exit;
		}
		
		$this->load->view('user/subepin');
	}
	
	public function checkbankwire($id='')
	{	
		if($this->input->post('checkwire')=='check')
		{
			
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mta_check');
		
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

					if($this->input->post('web_mode')=='1')
					{
						$this->session->set_flashdata('error_message',$this->lang->line('errormtafile'));
						redirect("user/register/checkbankwire/".$id);
					}
					else
					{
						$fileflag=0;
						header("Content-Type: application/json");
						$response["success"] = 0;
						$response["message"]="Pls upload valid referrence file";
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
 				
			$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
												
			if($mlsetting->Id==4)
				$table = "arm_pv";
			elseif($mlsetting->Id==9)
				$table = "arm_hyip";
			elseif($mlsetting->Id==5 || $mlsetting->Id==8) 
				$table = "arm_boardplan";
			else
				$table='arm_package';




				 $mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");
				 $package = $mempack->PackageId;

				 $condition="PackageId='".$package."'";

				 $packagedetails = $this->common_model->GetRow($condition,$table);
				 

				

				 $mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				 if($mlsetting->Id==4)
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
					'EntryFor'=>'MTA',
					'PaymentAmount'=>$paymentamount,
					'PackageId'=>$mempack->PackageId,
					'MemberId'=>$this->input->post('memberid'),
					'APaymentAttachemt'=>$admin_img,
					'APaymentReference'=>$this->input->post('transactionid'),
					'DateAdded'=>date('y-m-d H:i:s'),
					'subscriptiontype'=> $packagedetails->subscriptiontype,
					'subscriptiongraceperiod'=> $packagedetails->subscriptiongraceperiod
				);

				$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");

				$memdata=array(
					'packagedate'=>date('y-m-d H:i:s'),
					'subscriptiontype' =>$packagedetails->subscriptiontype,
					'subscriptiongraceperiod'=>$packagedetails->subscriptiongraceperiod
				);	
				$memupdate=$this->common_model->UpdateRecord($memdata,'MemberId ="'.$this->input->post('memberid').'"','arm_members' );


				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('success_message',$this->lang->line('successmtamsg'));
					redirect('login');
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
			else
			{
				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('error_message',$this->lang->line('errormtamsg'));
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
		}
		
		$this->data['id'] = $id;
		$this->data['amount'] = $this->input->post('amount');
		
		$this->load->view('user/checkbankwire',$this->data);
	}

	public function checkblockio($id='')
	{	
		
		if($this->input->post('checkwire')=='check')
		{
			
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mta_check');
			if($this->form_validation->run() == TRUE)
			{
			   $mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");
			   $mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
			   if($mlsetting->Id==4)
			   {
					$paymentamount=$this->input->post('amount');
			   }
			   else
			   {
				 	$paymentamount=$this->input->post('amount');
			   }
				$this->db->query("update arm_address set amount='".$paymentamount."' where address='".$this->input->post('to_address')."'");
			   $data = array(
					'AdminStatus'=>'0',
					'MemberStatus'=>'1',
					'ReceiveBy'=>'1',
					'EntryFor'=>'MTA',
					'pay_mode'=>12,
					'PaymentAmount'=>$paymentamount,
					'PackageId'=>$mempack->PackageId,
					'MemberId'=>$this->input->post('memberid'),
					'eth_address'=> $this->input->post('to_address'),
					'APaymentReference'=>$this->input->post('transactionid'),
					'DateAdded'=>date('y-m-d H:i:s')
				);
			   $mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
			   if($this->input->post('web_mode')=='1')
			   {
					$this->session->set_flashdata('success_message',"Payment Requested .. Pls wait For admin confirmation");
					redirect('login');
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
			
    	}
		else
		{

			$this->data['id'] = $id;
			$this->data['amount'] = $this->input->post('amount');
			$this->data['convertamount']=$this->input->post('eqv_amt');
			$block_iodet=$this->common_model->GetRow("PaymentId='12'","arm_paymentsetting");
		    $apikey=$block_iodet->PaymentMerchantKey;
		    $secrtkey=$block_iodet->PaymentMerchantPassword;
		    $coinmode=$block_iodet->coinmode;
			$cons="amount='0' and currency='".$coinmode."' and payment='0'";
			$check_address=$this->common_model->GetRow($cons,"arm_address");
			$check_username=$this->common_model->GetRow("MemberId='".$id."'","arm_members");
		    $label=$check_username->UserName.'-'.$unique;
			if($check_address)
			{
				$address=$check_address->address;
			}
			else
			{
				$block_iodet=$this->common_model->GetRow("PaymentId='12'","arm_paymentsetting");
			    $apikey=$block_iodet->PaymentMerchantKey;
			    $secrtkey=$block_iodet->PaymentMerchantPassword;
			    $coinmode=$block_iodet->coinmode;
			    $json_url = "https://block.io/api/v2/get_new_address/?api_key=$apikey";
			    $ch = curl_init($json_url);            
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
			    curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
		        $json_data=curl_exec($ch);
		        if($json_data)
		        {
		        	$output=json_decode($json_data);

		        	if($output->data)
	        		{
		        		$paid=$output->data;
						foreach ($paid as $row => $value)
	        	    	{
	        				if($row=='address')
	                    	{   
		                       $getaddress = $value;
		                       $data=array(
		                       	'address'=>$getaddress,
		                       	'label'=>$label,
		                       	'amount'=>'0',
		                       	'currency'=>$coinmode,
		                       	'status'=>'0',
		                       	'payment' =>'0'
		                       	);
		                       $insert_data=$this->common_model->SaveRecords($data,"arm_address");
		                       $address=$getaddress;
		                    }
	                 	}
	                }
	                else
	                {
	                	if($row=='error_message')  
	                    {
							if($this->input->post('web_mode')=='1')
	        				{

		                       $error = $value;
		                       $this->data['error']=$error;
		                    }
		                    else
		                    {
		                    	$error = $value;
		                        header("Content-Type: application/json");
								$response['success']=0;
								$response['message']=$error;
			     			 	echo json_encode($response);
				 				exit;

		                    }
	                       
	                    } 
					}

		        }
		        else
		        {
		        	if($this->input->post('web_mode')=='1')
	        		{
						$this->data['error']="Invalid API Requested. Pls contact Administrator";
					}
					else
					{
						header("Content-Type: application/json");
						$response['success']=0;
						$response['message']=$output;
	     			 	echo json_encode($response);
		 				exit;
		 			}

		        }
			}

			if($this->input->post('web_mode')=='1')
	        {
	        	$this->data['getaddress']=$address;
	        	$this->load->view('user/checkblockio',$this->data);  
	        }

		}  
	}

	public function wallet_address($apikey,$secrtkey,$coinmode)
	{
	    $apikey=$apikey;
	    $secrtkey=$secrtkey;
	    $coinmode=$coinmode;
        $json_url = "https://block.io/api/v2/get_new_address/?api_key=$wallet_api";
        $ch = curl_init();            
        curl_setopt($ch,CURLOPT_URL,$json_url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $json_data=curl_exec($ch);
        curl_close($ch);
        if($json_data)
        {
        	$output=json_decode($json_data);
        	if($output->data)
        	{
        		$paid=$output->data;
        		foreach ($paid as $row => $value) {
        			if($row=='address')
                    {   
                       $getaddress = $value;
                       $data=array(
                       	'address'=>$getaddress,
                       	'amount'=>'0',
                       	'status'=>'0'
                       	);
                       $insert_data=$this->common_model->SaveRecords($data,"arm_address");
                      
                    }
                    if($row=='error_message')  
                    {
                       $error = $value;
                       echo "<b style='color:red;'>".$error."</b><br>";
                       
                    }     
        		}
        	}
        }


	}

	public function checketh($id='')
	{
		if($this->input->post('checkwire')=='check')
		{	
			$to_address=$this->input->post('to_address');

			if($to_address !='')
			{	
				 $transactionid=$this->input->post('transactionid');
				 $mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
				
				 $mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");

				 $mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				 if($mlsetting->Id==4) 
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
						'EntryFor'=>'MTE',
						'PaymentAmount'=>$paymentamount,
						'equval_amount'=>$this->input->post('eqv_amt'),
						'APaymentReference'=>'Ethereum',
						'PackageId'=>$mempack->PackageId,
						'MemberId'=>$this->input->post('memberid'),
						'eth_address'=>$to_address,
						'DateAdded'=>date('y-m-d H:i:s')
					);
				
					$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
					$reference_id=$this->db->insert_id();
					

					$datass = array(
									"user_id"	=>	$this->input->post('memberid'),
									'PackageId'=>$mempack->PackageId,
									"amount"    =>  $paymentamount,
									"reference_id"=>$reference_id,
									"item_name" =>'Register',

									"equval_amt"=>  $this->input->post('eqv_amt'),
									"paid_amount" =>$paymentamount,
									"status"	=>	'1'
								     );
									
				    $con="address='".$to_address."' and payment = '1'";
		    		$update=$this->common_model->UpdateRecord($datass,$con,"arm_address");

		    		if($this->input->post('web_mode')=='1')
		    		{
						$this->session->set_flashdata('success_message',"Your ETH Address Send Successfully Please wait Admin accept");
						redirect('login');
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
			
		$this->data['id'] = $id;
	    $this->data['amount'] = $this->input->post('amount');
        $paydetail = $this->common_model->GetRow("status='0' and payment='1'","arm_address");
        if($paydetail!="")
        {
     	   $this->data['paydetail'] = $paydetail;

        }
        else
        {
        	$this->data['error'] = "Address Not Available Contact Administrator";
        }

			
	   $this->load->view('user/checketh',$this->data);
	}

	public function checkmpesa($id='')
	{	
		if($this->input->post('checkwire')=='check')
		{

			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$this->form_validation->set_rules('transactionid','transactionid','trim|required');
			$this->form_validation->set_rules('paynumber','paynumber','trim|required');
				
			if($this->form_validation->run() == true)	
 			{
 				
				 $mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");
				
		    	// $paymentamount=$checkpackagedet->PackageFee;

				 $mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				 if($mlsetting->Id==4)
				 {
				 	$paymentamount=$this->input->post('amount');
				 }
				 else
				 {
				 	$paymentamount=$this->input->post('amount');
				 }

				 $transactionid=$this->input->post('transactionid');
			     $paynumber=$this->input->post('paynumber');

			     // if($paynumber)
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
								     // 'phone'=>'254722906835' - Optional //INCLUDE 254 without the +
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
										    	
										    	elseif ($checkmatrix->Id==5) {
										    		$table="arm_boardplan";
										    	}
										    	else
										    	{
										    		$table="arm_package";
										    	}
										    	$checkpackagedet=$this->common_model->GetRow("PackageId='".$packageid."'",$table);
										    	$amount=$checkpackagedet->PackageFee;
										    	
										    	if($transactionid==$trans_id && $amount==$trans_amount && $paynumber==$phone)
										    	{
										    		$insertdata = array(
														'AdminStatus'=>'1',
														'MemberStatus'=>'1',
														'ReceiveBy'=>'1',
														'EntryFor'=>'MTA',
														'PaymentAmount'=>$paymentamount,
														'PackageId'=>$mempack->PackageId,
														'MemberId'=>$this->input->post('memberid'),
														'APaymentReference'=>$this->input->post('transactionid'),
														'DateAdded'=>date('y-m-d H:i:s')
													);
										   		  	$insert=$this->common_model->SaveRecords($insertdata,"arm_memberpayment");

										   			$inserthis = array(
																'MemberId'	=>	$this->input->post('memberid'),
																'DateAdded'	=>	date('Y-m-d H:i:s'),
																'TransactionId'	=>	$transactionid,
																'Credit'	=>$paymentamount,
																'Debit'	=>	$paymentamount,
																
																'TypeId'	=>	"19",
																'Description'=>"Member Register using this id ".$transactionid,
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
									    				$this->Memberboardprocess_model->process($memberids);
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
															$this->Memberboardprocess_model->Totaldowncount($table);

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
														
														$bb = $this->MemberCommission_model->process($memberids,$table,$field);
											    		$this->session->set_flashdata('success_message',"Welcome Buddy. Transaction Successful Login Your Account");
											    	    redirect('login');
										    		}
										          
										    	}
										    	else
										    	{
										    		$this->session->set_flashdata("error_message","You have paid an incorrect amount. You must make another transaction using the EXACT AMOUNT INDICATED.");
										    		 redirect('user/register/checkmpesa/'.$this->input->post('memberid').'');
										    	}
										    	
										        $index++;

										    }  //E# foreach statement

									    }
									    else
									    {
								    		$this->session->set_flashdata('error_message',"Invalid Mpesa Confirmation Code");
											redirect('user/register/checkmpesa/'.$this->input->post('memberid').'');
									    }
								   }
								   else
								   {
								   	 $this->session->set_flashdata('error_message',"Pay Pill Number is Invalid");
									redirect('user/register/checkmpesa/'.$this->input->post('memberid').'');
								   }
								}
								
					 	  }
					 	  else
					 	  {
					 	  	$this->session->set_flashdata('error_message',"TransactionId Already Exist");
							redirect('user/register/checkmpesa/'.$this->input->post('memberid').'');
					 	  }

					 	  
						
					 }
			     // }
				
			}
			
			else
			{
				$this->session->set_flashdata('error_message',$this->lang->line('errormtamsg'));
			}
		
		
		}

		$this->data['id'] = $id;
		$this->data['amount'] = $this->input->post('amount');		
		$this->load->view('user/checkmpesa',$this->data);
		
	}


	public function checkbitcoin($id='')
	{

		
	
		if($this->input->post('checkwire')=='check')
		{
			
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mta_check');
			$this->form_validation->set_rules($_FILES['referfile'],'referfile', 'trim|required|callback_ext_check');
			
			$admin_img = '';
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
						$this->session->set_flashdata('error_message',$this->lang->line('errormtafile'));
						redirect("user/register/checkbitcoin/".$id);
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
				$fileflag=0;
			}



			if($this->form_validation->run() == true && $fileflag==1)	
 			{
 				
				$mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");


				$data = array(
					'AdminStatus'=>'0',
					'MemberStatus'=>'1',
					'ReceiveBy'=>'1',
					'EntryFor'=>'MTA',
					'PaymentAmount'=>$this->input->post('amount'),
					'PackageId'=>$mempack->PackageId,
					'MemberId'=>$this->input->post('memberid'),
					'APaymentAttachemt'=>$admin_img,
					'APaymentReference'=>$this->input->post('transactionid'),
					'DateAdded'=>date('y-m-d H:i:s'),
					'pay_mode' =>'4'
				);
				$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('success_message',$this->lang->line('successmsg'));
					redirect("user/register/checkbitcoin/".$id);
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
				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('error_message',$this->lang->line('errormsg'));
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

			
				
		}
		
		$this->data['id'] = $id;
		$this->data['amount'] = $this->input->post('amount');
		$this->data['action'] = base_url().'user/register/checkbitcoin/'.$id;
		$this->load->view('user/checkbitcoin',$this->data);
	
	}



	public function checkcheque($id='')
	{	
		

		if($this->input->post('checkwire')=='check')
		{
		    
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mta_check');
		
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
						$this->session->set_flashdata('error_message',$this->lang->line('errormtafile'));
						redirect("user/register/checkcheque/".$id);
					}
					else
					{
						header("Content-Type: application/json");
						$response["success"] = 0;
						$response["message"]="Pls upload vaild files..";
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
 			    
 			     $userid = $id;
                 $mempack = $this->common_model->GetRow("MemberId='".$userid."'","arm_members");
				$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				 if($mlsetting->Id==4)
				 {
				 	$paymentamount=$this->input->post('amount');
				 }
				 else
				 {
				 	$paymentamount=$this->input->post('amount');
				 }
				

				 $mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
												
				if($mlsetting->Id==4)
					$table = "arm_pv";
				elseif($mlsetting->Id==9)
					$table = "arm_hyip";
				elseif($mlsetting->Id==5 || $mlsetting->Id==8) 
					$table = "arm_boardplan";
				else
					$table='arm_package';





				 $mempack = $this->common_model->GetRow("MemberId='".$userid."'","arm_members");
				 


				 $package = $mempack->PackageId;




				 $condition="PackageId='".$package."'";

				 $packagedetails = $this->common_model->GetRow($condition,$table);

				


				$data = array(
					'AdminStatus'=>'0',
					'MemberStatus'=>'1',
					'ReceiveBy'=>'1',
					'EntryFor'=>'MTA',
					'PaymentAmount'=>$paymentamount,
					'PackageId'=>$mempack->PackageId,
					'MemberId'=>$mempack->MemberId,
					'APaymentAttachemt'=>$admin_img,
					'DateAdded'=>date('y-m-d H:i:s'),
					'pay_mode'=>'7',
					'cheque_date'=>$this->input->post('date'),
					'cheque_number'=>$this->input->post('checknumber'),
					'bank_name'=>$this->input->post('bankname'),
					'branch'=>$this->input->post('branchname'),
					'subscriptiontype'=> $packagedetails->subscriptiontype,
					'subscriptiongraceperiod'=> $packagedetails->subscriptiongraceperiod
				);
			
				$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('success_message',"Your cheque Payment Requested.");
					redirect('login');
					exit;
				}
				else
				{
					header("Content-Type: application/json");
					$response["success"] = 1;
					$response["message"]="Cheque Payment Requested. Pls wait for confirmation";
					echo json_encode($response);
				
				}
			}
			
			else
			{
				if($this->input->post('web_mode')=='1')
				{
					$this->session->set_flashdata('error_message',$this->lang->line('errormtamsg'));	
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
				
			$this->data['id'] = $id;
			$this->load->view('user/checkcheque',$this->data);
			
		}
		
		$this->data['id'] = $id;
		$this->data['amount'] = $this->input->post('amount');
		
		$this->load->view('user/checkcheque',$this->data);
	}

	public function subbankwire($id='')
	{	
	
		if($this->input->post('checkwire')=='check')
		{
			
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');
			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mta_check');
		
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
					$this->session->set_flashdata('error_message',$this->lang->line('errormtafile'));
					redirect("user/register/subbankwire/".$id);
				}

			}
			else
			{
				$fileflag=1;
			}

			if($this->form_validation->run() == true && $fileflag==1)	
 			{
 				
				$mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");

				$data = array(
					'AdminStatus'=>'0',
					'MemberStatus'=>'1',
					'ReceiveBy'=>'1',
					'EntryFor'=>'MTAS',
					'PaymentAmount'=>$this->input->post('amount'),
					'PackageId'=>$mempack->PackageId,
					'MemberId'=>$this->input->post('memberid'),
					'APaymentAttachemt'=>$admin_img,
					'APaymentReference'=>$this->input->post('transactionid'),
					'DateAdded'=>date('y-m-d H:i:s')
				);
				$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
				$this->session->set_flashdata('success_message',$this->lang->line('successmtamsg'));
				redirect('login');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message',$this->lang->line('errormtamsg'));
			}
				
			$this->data['id'] = $id;
			$this->load->view('user/subbankwire',$this->data);
			exit;
		}
		
		$this->data['id'] = $id;
		$this->data['amount'] = $this->input->post('amount');
		$this->load->view('user/subbankwire',$this->data);
	
	}

	public function subeth($id='')
	{	
	
		if($this->input->post('checkwire')=='check')
		{
			$to_address=$this->input->post('to_address');	
			$transactionid=$this->input->post('transactionid');
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');

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

			 //  $blocknumber=$this->input->post('blocknumber');
			 // $this->form_validation->set_rules('blocknumber','blocknumber','trim|required|callback_number_check');
			 // if($this->form_validation->run() == TRUE)
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
			        	for ($i=0; $i<count($hash_details->result); $i++)
			        	{ 
			        		
				       	
				            $to_addr = $hash_details->result[$i]->to;
				            $from_addr=$hash_details->result[$i]->from;
				            $to_amt  = $hash_details->result[$i]->value;
				            $type = $eth_trans->typ;
				            $orignal_amt=$to_amt/1000000000000000000;

				            if($transactionid==$from_addr && $orignal_amt==$paymentamount)
				            {

			                  // commission
				    			$insertdata = array(
								'AdminStatus'=>'1',
								'MemberStatus'=>'1',
								'ReceiveBy'=>'1',
								'EntryFor'=>'MTAS',
								'PaymentAmount'=>$paymentamount,
								'PackageId'=>$mempack->PackageId,
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
												'Description'=>"Member Subscription using this id ".$transactionid,
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
								$detmember=$this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");
								$nxtdat = strtotime("+".$nxtperiod." day", strtotime($detmember->EndDate));
								$nxtdate=date('Y-m-d H:i:s ', $nxtdat);

								$umdata = array('SubscriptionsStatus'=>'Active',
												'MemberStatus'=>'Active',
												'EndDate'=>$nxtdate
												);
					    		$con="MemberId='".$this->input->post('memberid')."'";
					    		$update=$this->common_model->UpdateRecord($umdata,$con,"arm_members");
					    		if($update)
					    		{

									$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
									$mdata=array("Status"=>"1");
									$mresult = $this->common_model->UpdateRecord($mdata,"MemberId='".$this->input->post('memberid')."'",$mlsetting->TableName);
										$field = "MemberId";
										$MemberId = $this->input->post('memberid');
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
											$monomdet = $this->common_model->GetRow("MemberId='". $mladet->MemberId."' order by MonoLineId ASC LIMIT 0,1","arm_monolinematrix");

											$MemberId = $monomdet->MonoLineId;
										}
										else if($mlsetting->Id==4)
										{
											$table = "arm_binarymatrix";
										}
										else if($mlsetting->Id==5)
										{
											$table = "arm_boardmatrix";
											$field = "MemberId";
											$brdmdet = $this->common_model->GetRow("MemberId='". $mladet->MemberId."' order by BoardMemberId ASC LIMIT 0,1","arm_monolinematrix");

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
										else if($mlsetting->Id==8)
										{
											$table = "arm_boardmatrix1";
										}
											// echo "mmm =>".$mladet->MemberId." table =>".$table." field =>".$field; exit;
										// $this->Memberboardprocess_model->Totaldowncount($table);
										
										$bb = $this->MemberCommission_model->process($MemberId,$table,$field);
										if($bb)
										{

											$this->session->set_flashdata('success_message',$this->lang->line('successmtamsg'));
											$this->session->set_flashdata('error_message','');
											redirect('login');
											exit;
						
										}

				                }

				            }
				            else
					        {
					        	$this->session->set_flashdata("error_message","Transactions Not Found");
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
			 // 	$this->session->set_flashdata("error_message","Sorry You did not Paid Because the Block Number is Already exist");
			 // }

					
			$this->data['id'] = $id;
			$this->load->view('user/subeth',$this->data);
			exit;
		}
		
		$this->data['id'] = $id;
		$this->data['amount'] = $this->input->post('amount');
		$this->load->view('user/subeth',$this->data);
	
	}

	public function subblock($id='')
	{
	    if($this->input->post('checkwire')=='check')
		{
			$to_address=$this->input->post('to_address');	
			$transactionid=$this->input->post('transactionid');


			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');

			 $mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
			 if($mlsetting->Id==4)
			 {
			 	$paymentamount=$this->input->post('amount');
			 }
			 else
			 {
			 	$paymentamount=$this->input->post('amount');
			 }

			 	// block io transactions
				 // check the amount for that member in members payment table
				 $check_mem_det=$this->common_model->GetRow("Payid ='".$this->input->post('paymentid')."'","arm_memberpayment");
				  $amount=$check_mem_det->equval_amount;
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

				 $transactionid=$this->input->post('transactionid');
			 	$to_address=$this->input->post('to_address');
			 	// $to_a="12iVTz5rj1TpxXvaWrWFAxNwGKiXznYvsU";

			 	$ch = curl_init('https://chain.so/api/v2/address/'.$curr_mode.'/'.$to_address); 
			 	// $ch= curl_init('https://chain.so/api/v2/address/btc/'.$to_a);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
                curl_setopt($ch, CURLOPT_TIMEOUT, 3); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json')); 
                $cnf_data1 = curl_exec($ch); 
               
                if($cnf_data1)
                {
                	$out_data=json_decode($cnf_data1);		
                	
                	if($out_data->data)
                	{
                		
                		$paid=$out_data->data->txs;	

                	
                		foreach ($paid as $row) 
                		{
                			if($row->incoming)
                			{
                				 if($row->txid==$transactionid && $row->value==$amount)
                				{
                					// echo $row->txid;
                					if($row->confirmations >0)
                					{
                						$memberdet=$this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");
								    	$packageid=$memberdet->PackageId;
								    	$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
								    	if($checkmatrix->Id==4)
								    	{
								    		$table="arm_pv";
								    	}
								    	
								    	elseif ($checkmatrix->Id==5) {
								    		$table="arm_boardplan";
								    	}
								    	else
								    	{
								    		$table="arm_package";
								    	}
								    	$checkpackagedet=$this->common_model->GetRow("PackageId='".$packageid."'",$table);
								    	$amount=$checkpackagedet->PackageFee;
								    	
								    	
								    		$update_data = array(
												'AdminStatus'=>'1',
												'MemberStatus'=>'1',
												'APaymentReference'=>$this->input->post('transactionid'),
																								
											);
											$con_update="Payid='".$this->input->post('paymentid')."'";
								   		  	$update=$this->common_model->UpdateRecord($update_data,$con_update,"arm_memberpayment");

								   			$inserthis = array(
														'MemberId'	=>	$this->input->post('memberid'),
														'DateAdded'	=>	date('Y-m-d H:i:s'),
														'TransactionId'	=>	$transactionid,
														'Credit'	=>$paymentamount,
														'Debit'	=>	$paymentamount,										
														'TypeId'	=>	"19",
														'Description'=>"Member Subscription using this id ".$transactionid,
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
												// 'Mpesacode'=>$codenumber,
												'MemberStatus'=>'Active',
												'ModifiedDate'=>$date,
												'EndDate'=>$nxtdate,
											);
								    		$con="MemberId='".$this->input->post('memberid')."'";
								    		$update=$this->common_model->UpdateRecord($data,$con,"arm_members");
								    		if($update)
								    		{
								    			$memberids=$this->input->post('memberid');
							    				// $this->Memberboardprocess_model->process($memberids);
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
												
											    $bb = $this->MemberCommission_model->process($memberids,$table,$field);
											    $datas=array('amount'=>$amount);
											    $cins="address='".$to_address."'";
											    $updates=$this->common_model->UpdateRecord($cins,$datas,"arm_address");
											   
											    	$this->session->set_flashdata("success_message","Successfully payment Please Login our Account");
							                		redirect('login');
							                	    exit;
											    

		                    			    }
                					}
                				}
                			}
                		}

                		
                			
                		
                	}
                	else
                	{
                		// echo "aaa";
                	   $this->session->set_flashdata("error_message",$out_data->message);
                	   redirect('user/register/subblock/'.$id);
                	   exit;
                		
                	}
                }
                else
                {
					$this->session->set_flashdata('error_message',$this->lang->line('errormtamsg'));
					redirect('user/register/subblock/'.$id);
					exit;
                }

					
			$this->data['id'] = $id;
			$this->load->view('user/subblock',$this->data);
			exit;
		}
		
		$this->data['id'] = $id;
		$this->data['amount'] = $this->input->post('amount');
		$this->data['convertamount']=$this->input->post('eqv_amt');

		$block_iodet=$this->common_model->GetRow("PaymentId='14'","arm_paymentsetting");
	    $apikey=$block_iodet->PaymentMerchantKey;
	    $secrtkey=$block_iodet->PaymentMerchantPassword;
	    $coinmode=$block_iodet->coinmode;
		$cons="amount='0' and currency='".$coinmode."' and payment='0'";

		$check_address=$this->common_model->GetRow($cons,"arm_address");

		if($check_address!="")
		{
			$getaddress=$check_address->address;
			$this->data['getaddress']=$getaddress;		 
			// insert the member payments table
			if($this->input->post('amount') && $this->input->post('eqv_amt'))
			{
				$con="MemberId='".$id."' and EntryFor='MTAS' and APaymentReference=''";

				$insertdata = array(
							'AdminStatus'=>'1',
							'MemberStatus'=>'1',
							'ReceiveBy'=>'1',
							'EntryFor'=>'MTAS',
							'PaymentAmount'=>$this->input->post('amount'),
							'equval_amount'=>$this->input->post('eqv_amt'),
							'PackageId'=>$this->input->post('packageid'),
							'MemberId'=>$this->input->post('memberid'),
							'DateAdded'=>date('y-m-d H:i:s')
						);
				$check_member=$this->common_model->GetRowCount($con,"arm_memberpayment");
				// echo $this->db->last_query();
				if($check_member==0)
				{
					$insert=$this->common_model->SaveRecords($insertdata,"arm_memberpayment");
					$this->data['paymentid']=$this->db->insert_id();					
				}
				else
				{

					$update=$this->common_model->UpdateRecord($insertdata,$con,"arm_memberpayment");
					$check_row=$this->common_model->GetRow($con,"arm_memberpayment");
					// echo $this->db->last_query();
					$this->data['paymentid']=$check_row->Payid;
				}
			  // $this->load->view('user/checkblockio',$this->data);
			}
			
	
			   
		}
		else
		{
			// check the block io details in database
		    $block_iodet=$this->common_model->GetRow("PaymentId='14'","arm_paymentsetting");
		    $apikey=$block_iodet->PaymentMerchantKey;
		    $secrtkey=$block_iodet->PaymentMerchantPassword;
		    $coinmode=$block_iodet->coinmode;

		    
		    // Get wallet address 
		    // $waletaddress=$this->wallet_address($apikey,$secrtkey,$coinmode);
		    $check_username=$this->common_model->GetRow("MemberId='".$id."'","arm_members");
		    $unique=rand(00,99);
		    // create label for identifying the address in block io
		    $label=$check_username->UserName.'-'.$unique;
			$json_url = "https://block.io/api/v2/get_new_address/?api_key=$apikey&label=$label";
	        $ch = curl_init($json_url); 
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
		    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
		    curl_setopt($ch, CURLOPT_TIMEOUT, 3); 
		    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json')); 
		    $json_data = curl_exec($ch); 
	        if($json_data)
	        {
	        	$output=json_decode($json_data);
	        	if($output->data)
	        	{
	        		$paid=$output->data;
	        		foreach ($paid as $row => $value)
	        	    {
	        			if($row=='address')
	                    {   
	                       $getaddress = $value;
	                       $data=array(
	                       	'address'=>$getaddress,
	                       	'label'=>$label,
	                       	'amount'=>'0',
	                       	'currency'=>$coinmode,
	                       	'status'=>'0',
	                       	'payment'=>'0'
	                       	);
	                       $insert_data=$this->common_model->SaveRecords($data,"arm_address");
	                       $this->data['getaddress']=$getaddress;
	                       if($this->input->post('eqv_amt') && $this->input->post('amount'))
	                       {
								$con="MemberId='".$id."' and EntryFor='MTAS' and APaymentReference=''";

		                       	 $insertdata = array(
								'AdminStatus'=>'1',
								'MemberStatus'=>'1',
								'ReceiveBy'=>'1',
								'EntryFor'=>'MTAS',
								'PaymentAmount'=>$this->input->post('amount'),
								'equval_amount'=>$this->input->post('eqv_amt'),
								'PackageId'=>$this->input->post('packageid'),
								'MemberId'=>$this->input->post('memberid'),
								'DateAdded'=>date('y-m-d H:i:s')
							);
							 $check_member=$this->common_model->GetRowCount($con,"arm_memberpayment");
							 if($check_member==0)
							 {

								$insert=$this->common_model->SaveRecords($insertdata,"arm_memberpayment");
								$this->data['paymentid']=$this->db->insert_id();
							 }
							 else
							 {
							 	$update=$this->common_model->UpdateRecord($insertdata,$con,"arm_memberpayment");
								$check_row=$this->common_model->GetRow($con,"arm_memberpayment");
								// echo $this->db->last_query();
								$this->data['paymentid']=$check_row->Payid;
							 }

	                       }
	 

	                    }
	                    if($row=='error_message')  
	                    {
	                       $error = $value;
	                       // echo "<b style='color:red;'>".$error."</b><br>";
	                       $this->data['error']=$error;
	                       
	                    }     
	        		}
	        	}
	        	else
	        	{
	        		$this->data['error'] = $output;
	        	}
	        }	
		}

		$this->load->view('user/subblock',$this->data);
	}

	public function submpesa($id='')
	{	
	
		if($this->input->post('checkwire')=='check')
		{
			
			$mdetails = $this->common_model->GetRow("MemberId='".$id."'",'arm_members');

			$this->form_validation->set_rules('transactionid','transactionid','trim|required');
			$this->form_validation->set_rules('paynumber','paynumber','trim|required');
			// $this->form_validation->set_rules('codenumber','codenumber','trim|required');
		
			
			if($this->form_validation->run() == true)	
 			{

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
			     // if($paynumber)
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
			     // if($flag==1)
			     // {

				 if($transactionid)
				 {
					  $mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");

				 	  $checkexit=$this->common_model->GetRowCount("APaymentReference='".$transactionid."'","arm_memberpayment");
				 	  if($checkexit==0)
				 	  {
				 	  	   $checkmepsadet=$this->common_model->GetRow("PaymentName='Mpesa'","arm_paymentsetting");
				 	  	   $key=$checkmepsadet->PaymentMerchantApi;
				 	  	   $secret=$checkmepsadet->PaymentMerchantPassword;
				 	  	   $locationid=$checkmepsadet->PaymentField1;
					 	  	$api_key = $key;
							$api_secret = $secret;
							$endpoint = 'http://sapamacash.com/api/get_transactions';
							//Data to send a query string
							$data = array(
							    'format' => 'json',
							    'api_key' => $api_key,
							    'api_secret' => $api_secret,
							     // 'phone'=>'254722906835' - Optional //INCLUDE 254 without the +
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
									    	$checkpackagedet=$this->common_model->GetRow("PackageId='".$packageid."'",$table);
									    	$amount=$checkpackagedet->PackageFee;
									    	if($transactionid==$trans_id && $amount==$trans_amount && $paynumber==$phone)
									    	{
									    		
									    			$insertdata = array(
													'AdminStatus'=>'1',
													'MemberStatus'=>'1',
													'ReceiveBy'=>'1',
													'EntryFor'=>'MTAS',
													'PaymentAmount'=>$paymentamount,
													'PackageId'=>$mempack->PackageId,
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
																'Description'=>"Member Subscription using this id ".$transactionid,
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
												$detmember=$this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");
												$nxtdat = strtotime("+".$nxtperiod." day", strtotime($detmember->EndDate));
												$nxtdate=date('Y-m-d H:i:s ', $nxtdat);

												$umdata = array('SubscriptionsStatus'=>'Active',
																'MemberStatus'=>'Active',
																'EndDate'=>$nxtdate
																);
									    		$con="MemberId='".$this->input->post('memberid')."'";
									    		$update=$this->common_model->UpdateRecord($umdata,$con,"arm_members");
									    		if($update)
									    		{

													$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
													$mdata=array("Status"=>"1");
													$mresult = $this->common_model->UpdateRecord($mdata,"MemberId='".$this->input->post('memberid')."'",$mlsetting->TableName);
														$field = "MemberId";
														$MemberId = $this->input->post('memberid');
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
															$monomdet = $this->common_model->GetRow("MemberId='". $mladet->MemberId."' order by MonoLineId ASC LIMIT 0,1","arm_monolinematrix");

															$MemberId = $monomdet->MonoLineId;
														}
														else if($mlsetting->Id==4)
														{
															$table = "arm_binarymatrix";
														}
														else if($mlsetting->Id==5)
														{
															$table = "arm_boardmatrix";
															$field = "MemberId";
															$brdmdet = $this->common_model->GetRow("MemberId='". $mladet->MemberId."' order by BoardMemberId ASC LIMIT 0,1","arm_monolinematrix");

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
												
									    			$this->session->set_flashdata('success_message',"Welcome Buddy. Transaction Successful Login Your Account");
										    	    redirect('login');
									    		}
									    	
									    	else
									    	{
									    		$this->session->set_flashdata('error_message',"You have paid an incorrect amount. You must make another transaction using the EXACT AMOUNT INDICATED");
												redirect('user/register/submpesa/'.$this->input->post('memberid').'');
									    	}
									    		
									          
									    	}
									    	
									        $index++;


									    }  //E# foreach statement
								    }
								    else
								    {
							    		$this->session->set_flashdata('error_message',"Invalid Transaction Id");
										redirect('user/register/submpesa/'.$this->input->post('memberid').'');
								    }
							   }
							  
							}
							
				 	  }
				 	  else
				 	  {
				 	  	$this->session->set_flashdata('error_message',"TransactionId Already Exist");
						redirect('user/register/submpesa/'.$this->input->post('memberid').'');
				 	  }

				 	  
					
				 }

				// }

 				
			}
			else
			{
				$this->session->set_flashdata('error_message',$this->lang->line('errormtamsg'));
			}
				
			$this->data['id'] = $id;
			$this->load->view('user/submpesa',$this->data);
			exit;
		}
		
		$this->data['id'] = $id;
		$this->data['amount'] = $this->input->post('amount');
		$this->load->view('user/submpesa',$this->data);
	
	}


	public function mtmpay()
	{
		echo "ksahdkjsahd";
		//exit;
		if($this->input->post())
		{

			$this->form_validation->set_rules('memberid', 'memberid', 'trim|required|callback_mtm_check');
			
			$rec_img = $admin_img = 'uploads/mtmpay/no-photo.jpg';

			if($_FILES['memberfile']['tmp_name']!='')
			{
				if($_FILES['memberfile']['type']=='image/jpg' || $_FILES['memberfile']['type']=='image/jpeg' || $_FILES['memberfile']['type']=='image/png'|| $_FILES['memberfile']['type']=='image/gif')
				{
					$mftype = explode(".", $_FILES['memberfile']['name']);
					$rec_img = "uploads/mtmpay/".$this->input->post('memberid')."-member.".$mftype[1];
					move_uploaded_file($_FILES['memberfile']['tmp_name'], $rec_img);
					$recflag=1;
				}
				else
				{
					$recflag=0;
					$this->session->set_flashdata('error_message',$this->lang->line('errormtmfile'));
					redirect("user/register/payment/".$this->input->post('memberid'));
				}
			}
			else
			{
				$recflag=1;
			}

			if(isset($_FILES['adminfile']['tmp_name'])){

				if($_FILES['adminfile']['tmp_name']!='')
				{
					if($_FILES['adminfile']['type']=='image/jpg' || $_FILES['adminfile']['type']=='image/jpeg' || $_FILES['adminfile']['type']=='image/png'|| $_FILES['adminfile']['type']=='image/gif')
					{
						$aftype = explode(".", $_FILES['adminfile']['name']);
						$admin_img = "uploads/mtmpay/".$this->input->post('memberid')."-admin.".$aftype[1];
						move_uploaded_file($_FILES['adminfile']['tmp_name'], $admin_img);
						$adminflag=1;
					}
					else
					{
						$adminflag=0;
						$this->session->set_flashdata('error_message',$this->lang->line('errormtmfile'));
						redirect("user/register/payment/".$this->input->post('memberid'));
					}
				}
				else
				{
					$adminflag=1;
				}
		    }
		    else
		    {
		    	$adminflag=1;
		    }

		    echo $adminflag;
		    echo "<br>";
		    echo $recflag;
		    echo "<br>";

			if($adminflag==1 && $recflag==1) {
				$adminsts=0;
				$mempack = $this->common_model->GetRow("MemberId='".$this->input->post('memberid')."'","arm_members");

				$data = array(
					'AdminStatus'=>$adminsts,
					'MemberStatus'=>'0',
					'EntryFor'=>'MTM',
					'PackageId'=>$mempack->PackageId,
					"PaymentAmount"=>$this->input->post('packagefee'),
					'MemberId'=>$this->input->post('memberid'),
					'ReceiveBy'=>$this->input->post('receiveid'),
					'MPaymentAttachemt'=>$rec_img,
					'MPaymentReference'=>$this->input->post('memberpayid'),
					'APaymentAttachemt'=>$admin_img,
					'APaymentReference'=>$this->input->post('memberpayid'),
					'DateAdded'=>date('y-m-d H:i:s')
				);
				$mtmresult = $this->common_model->SaveRecords($data,"arm_memberpayment");
				echo $this->db->last_query();

				$this->session->set_flashdata('success_message',$this->lang->line('successmtmsg'));
				redirect("login");
				exit();
			}
			else
			{
				$this->session->set_flashdata('error_message',$this->lang->line('errormtmsg'));
			}
			exit;
			redirect("user/register/payment/".$this->input->post('memberid'));
		}
		else
		{
			redirect("user");
		}

	}

	public function setspillover($id)
	{
		$query = $this->db->query("SELECT * FROM arm_setting WHERE Page = 'mlmsetting' AND  KeyValue = 'matrixwidth'");
				
		$width = $query->row()->ContentValue;
		$mcondition = "MemberId='".$id."'";
		$mdetails = $this->common_model->GetRow($mcondition,'arm_members');
		$dcondition = "MemberId='".$mdetails->DirectId."'";
		$ddetails = $this->common_model->GetRow($dcondition,'arm_forcedmatrix');
		$dmcount =$ddetails->MemberCount;
		$date = date('y-m-d h:i:s');
		$mecondition = "MemberId='".$id."'";
		$mecount = $this->common_model->GetRowCount($mecondition,'arm_forcedmatrix');
		
		if(!empty($dmcount))
		{
			if($dmcount<$width)
			{
				$Mdata = array(
					'SpilloverId'=>$mdetails->DirectId,
					'DirectId'=>$mdetails->DirectId,
					'MemberId'=>$id,
					'DateAdded'=>$date
				);
				if(!$mecount)
				{
					$Mresult = $this->common_model->SaveRecords($Mdata,"arm_forcedmatrix");
				
					if($Mresult)
					{
						$Ddata=array('MemberCount'=>$dmcount+1);
						$Dresult = $this->common_model->UpdateRecord($Ddata,$dcondition,"arm_forcedmatrix");
					}
				}
			}
			else
			{
				$query = $this->db->query("SELECT * FROM arm_forcedmatrix WHERE SpilloverId = '".$mdetails->DirectId."' AND MemberCount < '".$width."' order by MemberId asc limit 0,1 ");
				$spillid = $query->row()->MemberId;

				$Mdata = array(
					'SpilloverId'=>$spillid,
					'DirectId'=>$mdetails->DirectId,
					'MemberId'=>$id,
					'DateAdded'=>$date
				);
				if(!$mecount)
				{
					$Mresult = $this->common_model->SaveRecords($Mdata,"arm_forcedmatrix");
						
					if($Mresult)
					{
						$spcondition = "MemberId='".$spillid."'";
						$spdetails = $this->common_model->GetRow($spcondition,'arm_forcedmatrix');
						$smcount =$spdetails->MemberCount;
						$Ddata=array('MemberCount'=>$smcount+1);
						$Scondition = "MemberId='".$spillid."'";
						$Dresult = $this->common_model->UpdateRecord($Ddata,$Scondition,"arm_forcedmatrix");
					}
				}

			}
		}
		else
		{
			$Mdata = array(
				'SpilloverId'=>$mdetails->DirectId,
				'DirectId'=>$mdetails->DirectId,
				'MemberId'=>$id,
				'DateAdded'=>$date
			);
			if(!$mecount)
			{
				$Mresult = $this->common_model->SaveRecords($Mdata,"arm_forcedmatrix");
						
				if($Mresult)
				{
					$Ddata=array('MemberCount'=>$dmcount+1);
					$Dresult = $this->common_model->UpdateRecord($Ddata,$dcondition,"arm_forcedmatrix");

				}
			}
		}
	}

	public function mtm_check()
	{
		$ckip = $this->common_model->GetRowCount("MemberId='".$this->input->post('memberid')."' AND AdminStatus NOT IN ('2','1') AND EntryFor='MTM'","arm_memberpayment");
		
		if($ckip>0)
		{
			$this->form_validation->set_message('mtm_check',ucwords($this->lang->line('errormtm')));
			$this->form_validation->set_message('mtm_check',ucwords($this->lang->line('errormta')));
			return false;
		}
		else
		{
			return true;
		}
		exit;

	}

	public function mta_check()
	{
		$ckip = $this->common_model->GetRowCount("MemberId='".$this->input->post('memberid')."' AND AdminStatus NOT IN ('2','1') AND EntryFor='MTA'","arm_memberpayment");
		
		if($ckip>0)
		{
			$this->form_validation->set_message('mta_check',ucwords($this->lang->line('errormta')));
			return false;
		}
		else
		{
			return true;
		}
		exit;
	}

	public function ip_check()
	{
		$ckip = $this->common_model->GetRowCount("Ip='".$_SERVER['REMOTE_ADDR']."'","arm_members");
		
		if($ckip>0)
		{
			$this->form_validation->set_message('ip_check',ucwords($this->lang->line('errorip')));
			return false;
		}
		else
		{
			return true;
		}
		exit;
	}

	public function position_check($position, $Spillover)
	{
		$directid = $this->common_model->getreferralname($Spillover);
		$checkdownline = $this->common_model->GetRow("".$position."Id!='0' AND MemberId='".$directid."'","arm_binarymatrix");
		$pos_id = $position.'Id';
		if($checkdownline) {
			if($checkdownline->$pos_id) {
				$this->form_validation->set_message('position_check',ucwords($this->lang->line('errorposition')));
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

		public function positions_check($position, $Spillover)
	{
		$directid = $this->common_model->getreferralname($Spillover);
		$checkdownline = $this->common_model->GetRow("".$position."Id!='0' AND MemberId='".$directid."'","arm_binaryhyip");
		$pos_id = $position.'Id';
		if($checkdownline) {
			if($checkdownline->$pos_id) {
				$this->form_validation->set_message('positions_check',ucwords($this->lang->line('errorposition')));
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}


	public function position_checks()
	{
		$directid = $this->common_model->getreferralname($this->input->post('SponsorName'));
		$ckip = $this->common_model->GetRowCount("".$this->input->post('position')."Id!='0' AND MemberId='".$directid."'","arm_binarymatrix");
		


		if($ckip>0)
		{
			$this->form_validation->set_message('position_checks',ucwords($this->lang->line('errorposition')));
			
			return false;
		}
		else
		{
			
			return true;
		}
		

	}


	public function uplineid_checkk()
	{
				
		$member_check =$this->common_model->GetRowCount("UserName ='".$this->input->post('uplineid')."'","arm_members");

		if($member_check>0)
		{
							
			return true;
			
		}
		else
		{
			$this->form_validation->set_message('uplineid_checkk',ucwords($this->lang->line('errorupline')));
				
			return false;

		}
	}


	public function ext_check()
	{
		
		if($_FILES['referfile']=='gif' || $_FILES['referfile']=='png' || $_FILES['referfile']=='jpg' || $_FILES['referfile']=='jpeg')
		{
			return true; 
		}
		else
		{
			$this->form_validation->set_message('ext_check',ucwords($this->lang->line('errorextension')));
			return false;
		}
		exit;
	}

	public function customAlpha($str) 
	{
	    if ( !preg_match('/^[a-z \-]+$/i',$str) )
	    {
	    	$this->form_validation->set_message('customAlpha','Error! This field %s only support for characters.');
	        return false;
	    }
	}
	public function alphaspace($str){
		if ( !preg_match('/^[a-zA-Z ]*$/i',$str) )
	    {
	    	$this->form_validation->set_message('alphaspace','Error! This field  %s only support for characters and space.');
	        return false;
	    }
	}

	public function number_check($str)
	{
		$check_row=$this->common_model->GetRowCount("blocknumber='".$str."'","arm_memberpayment");
		if($check_row==0)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('number_check',"<p style='color:red;'>Error! This Block Number is Already Exist</p>");
			return false;
		}
	}

	public function test() {
		$field = "MemberId";
		$boardpackage = $this->common_model->GetRow("PackageId='1'","arm_boardplan");
		$usermlmdetail = $this->common_model->GetRow("".$field."='265'",'arm_boardmatrix1');
		$dcondition = "MemberId='".$usermlmdetail->DirectId."' order by BoardMemberId limit 0,1";
		$ddetails = $this->common_model->GetRow($dcondition,'arm_boardmatrix1');

		$chec_spill = $ddetails->SpilloverId;
	
		if(!$SpilloverId){
			$level++;
		}
	}

	public function testing() {
		phpinfo();
	}

	public function GetSpillover($Downids,$table)
	{
		
		$array = $Downids;
		$count = 0;
		foreach ($Downids as $downid) {

			$spill_res = $this->common_model->GetResults("SpilloverId = '".$downid."' ","arm_binarymatrix");
				
			if($spill_res){
				foreach ($spill_res as $spil) {
					// array_push($array,$spil->MemberId);
					$count +=  $spil->LeftCount;
					$count +=  $spil->RightCount;
				}
				$count = $count+1;
			}
		}
		// return array_unique($array);
		return $count;
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

public function ranks()
{
	$this->load->helper('rank_helper');
	$memner=referalcount();

}

public function sample()
{
	$this->load->view('samples');
}

public function updates()
{
	$this->load->helper('mpesa_helper');
	$update=updatewithdraw();
}


public function sendmail($useremail, $fullname, $subject, $message) 
{

		$this->load->library('My_PHPMailer');
		$condition = "settings_name = 'email'";
		$email_setting_data = $this->common_model->GetSettingall_lang($condition);

		foreach ($email_setting_data as $row) {
			$mail_data[$row->site_key] = $row->site_value;
		}

		if($mail_data['email_throw']=='php')
		{
			$mail = new PHPMailer();
	        $mail->isMail();

		} else {

			$mail = new PHPMailer();
	        $mail->IsSMTP(); 
	        $mail->SMTPAuth   = TRUE; 
	        $mail->SMTPSecure = $mail_data['smtp_type'];  
	        $mail->Host       = $mail_data['smtp_hostname'];      
	        $mail->Port       = $mail_data['smtp_portno'];                   
	        $mail->Username   = $mail_data['smtp_username'];  
	        $mail->Password   = $mail_data['smtp_password'];   
		}
		         
        $mail->SetFrom($mail_data['admin_email'], site_info_lang('site_name',$this->session->userdata('langid')));  
        $mail->AddReplyTo($mail_data['admin_email'],site_info_lang('site_name',$this->session->userdata('langid')));

        $message  = str_replace('#adminemail', $mail_data['admin_email'], $message);

        $mail->Subject    = $subject;
        $mail->msgHTML($message);
        
        $mail->AddAddress($useremail, $fullname);
        if(!$mail->Send()) {
        	
        	return true;
        } else {
        	
            return true;
        }

}






}

?>