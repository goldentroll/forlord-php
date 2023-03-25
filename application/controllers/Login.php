	<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Login extends CI_Controller {


	public function __construct() {
	parent::__construct();
	// Load database
    $this->load->library('session');
	$this->lang->load('user/login',$this->session->userdata('language'));
	$this->lang->load('user/common',$this->session->userdata('language'));

	$this->load->model('admin/testimonial_model');
	$this->load->model('admin/Smtpsetting_model');
	$this->load->model('Dashboard_model');
	$this->load->helper('sms');
	$this->load->helper('subscription');
	$this->load->library('Google_authendicator');

	$banned = $this->common_model->CheckIP();
	if($banned) {
	$this->session->set_flashdata('error_message', $this->lang->line('errorbanned'));
	redirect('user');
	}

	$siteset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitestatus'", "arm_setting");
	if($siteset->ContentValue=="Off")
	{
	redirect("offsite"); exit;
	}

	$regset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='allowlogin'", "arm_setting");

	if($regset->ContentValue=="Off")
	{
	redirect("user");
	exit;
	}

	}



	public function index()
	{




	$siteset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitestatus'", "arm_setting");
	if($siteset->ContentValue=="Off")
	{
	redirect("offsite"); exit;
	}

	$subset = $this->common_model->GetRow("Page='usersetting' AND KeyValue='subscriptionstatus'", "arm_setting");
	if($subset->ContentValue==1)
	{
	//checksubscription();
	}


	$regset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='allowlogin'", "arm_setting");

	if($regset->ContentValue=="Off")
	{
	redirect("user");
	exit;
	}

	if($this->input->post())
	{


	$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check');
	$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_password_check');
	$captchaset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='usecaptcha'", "arm_setting");


	if($captchaset->ContentValue=="On") {
	$this->form_validation->set_rules('g-recaptcha-response', 'captcha', 'trim|required|xss_clean|callback_captcha_check');
	}



	if ($this->form_validation->run() == FALSE) {


	if($this->input->post('web_mode')=='1')
	{

	$error = str_replace('<p><em class="state-error1">','',validation_errors());
	$error = str_replace('</em></p>','<br/>',$error);
	$this->session->set_flashdata('error_message',$error);
	redirect('login');
	}
	else
	{
	header("Content-Type: application/json");
	$response["success"] = 0;
	$response["message"] = "Invalid UserName Password";
	$response["redirect"]="login";
	echo json_encode($response);
	exit;
	}

	} else {


	$data = array(
	'username' => $this->input->post('username'),
	'password' => SHA1(SHA1($this->input->post('password')))
	);

	$result = $this->common_model->login($data);				




	if($result)
	{

	// $check_rank = $this->Dashboard_model->check_rank($result->MemberId);

	$live_update =  $this->db->query("UPDATE arm_members SET new_entry = '".date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')))."' WHERE MemberId ='".$result->MemberId."' ");

	$live_status =  $this->db->query("UPDATE arm_members SET facebookurl ='1' WHERE MemberId ='".$result->MemberId."' ");

	$captchasets = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='google_verify'", "arm_setting");

	if($captchasets->ContentValue=="On" && $result->twofactor_status == '1'  ) 
	{
	if($this->input->post('web_mode')=='1')
	{
	redirect('login/authgoogle/'.$result->MemberId);
	}
	else
	{
	header("Content-Type: application/json");
	$response["success"] = 1;
	$response["message"] = "Login Details Valid...";
	$response["redirect"]="login/authgoogle/".$result->MemberId;
	echo json_encode($response);
	exit;
	}

	}



	if(strtolower($result->SubscriptionsStatus)=='free')
	{

	$unpaid = array(
	"free_mem_id" => $result->MemberId
	);
	$this->session->set_userdata($unpaid);

	$find_response=$this->db->query("select * from arm_members where MemberId='".$result->MemberId."'")->row();
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

	$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
	if($mlsetting->Id==4) {
	$ptableName ="arm_pv";
	} 
	elseif($mlsetting->Id==5 || $mlsetting->Id==8) {
	$ptableName ="arm_boardplan";
	} else {

	$ptableName ="arm_package";
	}
	$pcondition = " PackageId ='".$find_response->PackageId."'  order by PackageId ASC";
	$package_info = $this->common_model->GetRow($pcondition, $ptableName);

	$currency_condition = "Status='1'";
	$currency_settings= $this->common_model->GetRow($currency_condition,'arm_currency');
	$currency_code=$currency_settings->CurrencyCode;
	if($this->input->post('web_mode')=='1')
	{

	//redirect("user/register/payment/".$result->MemberId);
	//exit;
	}
	else
	{
	header("Content-Type: application/json");
	$response["success"] = 1;
	$response["userinfo"]=$data_user;
	$response['package']=array('PackageId' => $package_info->PackageId, 'Package Name' => $package_info->PackageName,'Package Amount' => number_format($package_info->PackageFee,currency_decimal()), "currency" => $currency_code);
	$ptableName='arm_paymentsetting';
	$pcondition = " PaymentStatus ='1'  order by PaymentId ASC";
	$payment_det= $this->common_model->GetResults($pcondition, $ptableName);
	$pay_count=0;
	if($payment_det)
	{
	foreach ($payment_det as $payments) 
	{
	$pay_count++;
	}
	}
	if($pay_count>0)
	$response['payment_info']=$payment_det;
	$ckip = $this->common_model->GetRowCount("MemberId='".$result->MemberId."'  AND AdminStatus='0'","arm_memberpayment");

	if($ckip>0)
	{
	$response['user_paid']='2';
	$bank_count= $this->common_model->GetRowCount("MemberId='".$result->MemberId."' AND EntryFor='MTA' AND AdminStatus='0' and pay_mode='1'","arm_memberpayment");
	if($bank_count >0)
	$response['user_msg']="Bankwire payment requested. Pls wait for confirmation";

	$chk_count= $this->common_model->GetRowCount("MemberId='".$result->MemberId."' AND EntryFor='MTA' AND AdminStatus='0' and pay_mode='7'","arm_memberpayment");
	if($chk_count >0)
	$response['user_msg']="cheque payment requested. Pls wait for confirmation";

	$eth_count= $this->common_model->GetRowCount("MemberId='".$result->MemberId."' AND EntryFor='MTE' AND AdminStatus='0' and pay_mode='1'","arm_memberpayment");
	if($eth_count >0)
	$response['user_msg']="Ethereum payment requested. Pls wait for confirmation";

	$btc_count= $this->common_model->GetRowCount("MemberId='".$result->MemberId."' AND EntryFor='MTA' AND AdminStatus='0' and pay_mode='4'","arm_memberpayment");

	if($btc_count >0)
	$response['user_msg']="Bitcoin payment requested. Pls wait for confirmation";	  

	$block_count= $this->common_model->GetRowCount("MemberId='".$result->MemberId."' AND EntryFor='MTA' AND AdminStatus='0' and pay_mode='12'","arm_memberpayment");

	if($block_count >0)
	$response['user_msg']="Block.io payment requested. Pls wait for confirmation";	                        	                      	

	}
	else
	{
	$response['user_paid']='0';	
	$response['user_msg']="No payment request";
	}

	$response['payment_list_count']=$pay_count;
	$response['return'] = base_url().'payment/paypal/success';
	$response['notify_url'] = base_url().'payment/paypal/ipn';
	$response['cancel_return'] = base_url().'payment/paypal/cancel';
	$response["message"] = "Register Payment";

	$response["redirect"]="user/register/payment/".$result->MemberId;
	echo json_encode($response);
	exit;
	}


	/*redirect("user/register/payment/".$result->MemberId);
	exit;*/

	}  else {

	if ($result->twofactor_status == '1') {

	$twofactor = array(
	"twofactor" => $result->MemberId
	);
	$this->session->set_userdata($twofactor);


	redirect('login/verify');


	}


	if($subset->ContentValue=="1") {

	if($result->MemberId!='2') {

	$substs=checkmembersubscription($result->MemberId);

	if($substs)
	{
	$unpaid = array(
	"sub_mem_id" => $result->MemberId
	);
	$this->session->set_userdata($unpaid);
	redirect("user/register/subscription/".$result->MemberId);
	exit;
	}
	}
	}

	if($result->LoggedIn=='0') {
	$this->session->set_userdata('first_login',TRUE);
	}
	}

	$userarray = array(
	"UserId" => $result->MemberId,
	"LoginDate" => date('Y-m-d H:i:s'),
	"LoggedIn" => '1',
	"admin_user"=>'0',
	"ip_address"=>$_SERVER['REMOTE_ADDR']
	);

	$array = array(
	"logged_in" => TRUE,
	"full_name" => $result->FirstName.' '.$result->MiddleName.''.$result->LastName,
	"MemberID" => $result->MemberId,
	"ReferralName"=>$result->ReferralName,
	"Email" => $result->Email
	);

	switch ($result->UserType) {
	case '1':
	if($result->MemberId=='0')
	{
	$array['admin_login'] = TRUE;
	$array['user_login'] = FALSE;
	}
	else
	{
	$array['admin_login'] = TRUE;
	$array['user_login'] = FALSE;
	}

	break;
	case '2':
	$array['subadmin_login'] = TRUE;
	break;
	case '3':
	$array['user_login'] = TRUE;
	$array['admin_login'] = FALSE;
	$this->db->insert('arm_member_activity', $userarray);

	break;
	case '4':
	$array['guest_login'] = TRUE;
	break;
	}

	$this->session->set_userdata($array);



// if (isset($_SESSION['username'])){
//     session_id();
// } else if (!isset($_SESSION)){
//    session_start();
// }


	if($this->session->userdata('logged_in') && $this->session->userdata('user_login')) {


	if($result->LoggedIn=='0') {
	$this->db->where("MemberId", $result->MemberId);
	$this->db->update('arm_members', array('LoggedIn' => '1'));
	$find_response=$this->db->query("select * from arm_members where MemberId='".$result->MemberId."'")->row();

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
	$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
	if($mlsetting->Id==4) {
	$ptableName ="arm_pv";
	} 
	elseif($mlsetting->Id==5 || $mlsetting->Id==8) {
	$ptableName ="arm_boardplan";
	} else {

	$ptableName ="arm_package";
	}
	$pcondition = " PackageId ='".$find_response->PackageId."'  order by PackageId ASC";
	$package_info = $this->common_model->GetResults($pcondition, $ptableName);

	if($this->input->post('web_mode')=='1')
	{
	redirect('user/dashboard');
	}
	else
	{
	header("Content-Type: application/json");
	$response["success"] = 1;
	$response["message"] = "Login Details Valid";
	$response['user_paid']='1';
	$response['userinfo']=$data_user;
	$response['package']=$package_info;

	$response["redirect"]="user/dashboard";
	echo json_encode($response);
	exit;
	}


	} 
	else
	{

	if($this->input->post('web_mode')=='1')
	{
	redirect('user/dashboard');	
	}
	else
	{
	header("Content-Type: application/json");
	$find_response=$this->db->query("select * from arm_members where MemberId='".$result->MemberId."'")->row();
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
	$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
	if($mlsetting->Id==4) {
	$ptableName ="arm_pv";
	} 
	elseif($mlsetting->Id==5 || $mlsetting->Id==8) {
	$ptableName ="arm_boardplan";
	} else {

	$ptableName ="arm_package";
	}
	$pcondition = " PackageId ='".$find_response->PackageId."'  order by PackageId ASC";
	$package_info = $this->common_model->GetResults($pcondition, $ptableName);
	$response["success"] = 1;
	$response['user_paid']='1';
	$response["message"] = "Login Details Valid";
	$response['package']=$package_info;
	$response["redirect"]="user/dashboard";
	$response['userinfo']=$data_user;
	echo json_encode($response);
	exit;
	}
	}
	} else {
	echo 'not login'; exit;
	redirect('user/login');
	}

	} 
	else 
	{

	if($this->input->post('web_mode')=='1')
	{
	$this->session->set_flashdata('error_message', 'Invalid User Details');
	$this->load->view('user/login');
	}
	else
	{

	header("Content-Type: application/json");
	$response["success"] = 0;
	$response["message"] = "Invalid User Details";
	$response["redirect"]="login";
	echo json_encode($response);
	exit;
	}

	}
	}
	}
	else {

	if($this->session->userdata('logged_in') && $this->session->userdata('user_login')) {
	$this->data['testimonial'] = $this->testimonial_model->GetTestimonialall();
	$this->load->view('user/dashboard',$this->data);
	} 
	else {
	$this->load->view('user/login');
	}

	}

	}
	public function verify(){



	if ($this->input->post()) {



	$this->form_validation->set_rules('twofactor','twofactor', 'trim|required|numeric');
	if($this->form_validation->run() == TRUE)
	{



	$query=$this->db->query("select * from arm_members where MemberId='".$this->session->userdata('twofactor')."'")->row();

	$authenticator = new Google_authendicator();
	$otp = $this->input->post('twofactor');
	$secret=$query->twofactor_secret_key;
	$tolerance = 2;
	$checkResult = $authenticator->verifyCode($secret,$otp,$tolerance);

	if ($checkResult) {


	$result=$this->db->query("select * from arm_members where MemberId='".$this->session->userdata('twofactor')."'")->row();

	$userarray = array(
	"UserId" => $result->MemberId,
	"LoginDate" => date('Y-m-d H:i:s'),
	"LoggedIn" => '1',
	"admin_user"=>'0',
	"ip_address"=>$_SERVER['REMOTE_ADDR']
	);

	$array = array(
	"logged_in" => TRUE,
	"full_name" => $result->FirstName.' '.$result->MiddleName.''.$result->LastName,
	"MemberID" => $result->MemberId,
	"ReferralName"=>$result->ReferralName,
	"Email" => $result->Email
	);
	$this->session->set_userdata($array);
	//$this->db->insert('arm_member_activity', $userarray);
	redirect('user/dashboard');	




	}else{

	$this->session->set_flashdata('error_message','Invalid Otp');

	}


	}

	}




	$this->load->view('user/verify');
	}



	// public function hii()
	// {
	// 	$user=6;
	//     $this->load->model('admin/Smtpsetting_model');

	// 	$smtpstatus = $this->Smtpsetting_model->Getdata('smtpstatus');
	// 	$smtpmail = $this->Smtpsetting_model->Getdata('smtpmail');
	// 	$smtppassword = $this->Smtpsetting_model->Getdata('smtppassword');
	// 	$smtpport = $this->Smtpsetting_model->Getdata('smtpport');
	// 	$smtphost = $this->Smtpsetting_model->Getdata('smtphost');
	// 	$maillimit = $this->Smtpsetting_model->Getdata('mail_limit');


	// 	$config = array();
	// 	$config['protocol'] 		= "sendmail";
	// 	$config['useragent']        = "CodeIgniter";
	// 	$config['mailpath']         = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
	// 	$config['smtp_host']        = $smtphost;
	// 	$config['smtp_port']        = $smtpport;
	// 	$config['mailtype'] 		= 'html';
	// 	$config['charset']  		= 'utf-8';
	// 	$config['newline']  		= "\r\n";
	// 	$config['wordwrap'] 		= TRUE;
	// 	// $this->email->initialize($config);
	// 	$this->email->clear(TRUE);

	// 	if($user)
	// 	{

	// 	$string = "ACDEFGHJKMNPQRTZXYW123456789";
	// 	$count = strlen($string);
	// 	$randomstring='';
	// 	for($x=1;$x<=7;$x++)
	// 	{ 
	// 	$pos = rand(0,$count);
	// 	$randomstring.= substr($string,$pos,1); 

	// 	}


	//     $message = $this->common_model->GetRow("Page='RankAchived'","arm_emailtemplate");
	//     $emailcont = urldecode($message->EmailContent);
	// 	$site = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'","arm_setting");
	// 	$sitename = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitename'","arm_setting");	


	// 	// echo "<br>1 time => <br>".$emailcont ;
	// 	$logo = '<img src="'.base_url().$site->ContentValue.'">';
	// 	$this->email->from($smtpmail, $sitename->ContentValue);
	// 	$this->email->to($user->Email);
	// 	$this->email->subject($message->EmailSubject);


	// 	$body =
	// 	'<!DOCTYPE html> <html>
	// 		<style>
	// .cursive {
	// font-family: "Pinyon Script", cursive;
	// }
	// .sans {
	// font-family: "Open Sans", sans-serif;
	// }
	// .bold {
	// font-weight: bold;
	// }
	// .block {
	// display: block;
	// }
	// .underline {
	// border-bottom: 1px solid #777;
	// padding: 5px;
	// margin-bottom: 15px;
	// }
	// .margin-0 {
	// margin: 0;
	// }
	// .padding-0 {
	// padding: 0;
	// }
	// .pm-empty-space {
	// height:13px;
	// width: 100%;
	// }
	// body {
	// padding: 20px 0;
	// background: #ccc;
	// }
	// .pm-certificate-container {
	// position: relative;
	// width: 800px;
	// height: 600px;
	// background-color: #618597;
	// padding: 2px;
	// color: #333;
	// box-shadow: 0 0 5px rgba(0, 0, 0, .5);
	// }
	// .pm-certificate-container .outer-border {
	// width: 794px;
	// height: 594px;
	// position: absolute;
	// left: 50%;
	// margin-left: -397px;
	// top: 50%;
	// margin-top:-297px;
	// border: 2px solid #fff;
	// }
	// .inner-border {
	// width: 730px;
	// height: 530px;
	// position: absolute;
	// left: 50%;
	// margin-left: -365px;
	// top: 50%;
	// margin-top:-265px;
	// border: 2px solid #fff;
	// }
	// .pm-certificate-border {
	// position: relative;
	// width: 720px !important;
	// height: 520px;
	// padding: 0;
	// border: 1px solid #E1E5F0;
	// background-color: rgba(255, 255, 255, 1);
	// background-image: none;
	// left: 50%;
	// margin-left: -360px;
	// top: 50%;
	// margin-top: -260px;
	// }
	// .pm-certificate-block {
	// width: 650px;
	// height: 200px;
	// position: relative;
	// left: 50%;
	// margin-left: -325px;
	// top: 70px;
	// margin-top: 0;
	// }
	// .pm-certificate-header {
	// margin-bottom: 10px;
	// }

	// .pm-certificate-container .pm-certificate-title {
	// position: relative;
	// top: 10px;
	// }
	// .pm-certificate-container .pm-certificate-title h2 {
	// font-size: 34px !important;
	// }

	// .pm-certificate-container .pm-certificate-body {
	// padding: 20px;
	// }
	// .pm-certificate-container .pm-certificate-body .pm-name-text {
	// font-size: 20px;
	// }

	// .pm-certificate-container .pm-earned {
	// margin: 15px 0 20px;
	// }
	// .pm-certificate-container .pm-earned  .pm-earned-text{
	// font-size: 20px;
	// }

	// .pm-certificate-container .pm-earned  .pm-credits-text {
	// font-size: 15px;
	// }


	// .pm-certificate-container .pm-earned  .pm-course-title .pm-earned-text {
	// font-size: 20px;
	// }
	// .pm-certificate-container .pm-earned  .pm-course-title .pm-earned-text .pm-credits-text {
	// font-size: 15px;
	// }

	// .pm-certificate-containe .pm-certified {
	// font-size: 12px;
	// }
	// .pm-certificate-containe .pm-certified .underline {
	// margin-bottom: 5px;
	// }
	// .pm-certificate-containe .pm-certificate-footer {
	// width: 650px;
	// height: 100px;
	// position: relative;
	// left: 50%;
	// margin-left: -325px;
	// bottom: -105px;
	// }
	// .col-xs-12
	// {
	// text-align: center;
	// }
	// </style>
	// <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	// <html xmlns="http://www.w3.org/1999/xhtml">
	// 	<body><div class="container pm-certificate-container"><div class="outer-border" style="width: 794px;
	//     height: 594px;
	//     position: absolute;
	//     left: 50%;
	//     margin-left: -397px;
	//     top: 50%;
	//     margin-top: -297px;
	//     border: 2px solid #fff;"></div><div class="inner-border" style="width: 730px;
	//     height: 530px;
	//     position: absolute;
	//     left: 50%;
	//     margin-left: -365px;
	//     top: 50%;
	//     margin-top: -265px;
	//     border: 2px solid #fff;"></div><div class="pm-certificate-border col-xs-12"style="position: relative;
	//     width: 720px;
	//     height: 520px;
	//     padding: 0;
	//     border: 1px solid #E1E5F0;
	//     background-color: #ffffff;
	//     background-image: none;
	//     left: 50%;
	//     margin-left: -360px;
	//     top: 50%;
	//     margin-top: -260px;"><div class="row pm-certificate-header" style=" margin-bottom: 10px;"><div class="pm-certificate-title cursive col-xs-12 text-center" style="position: relative;
	//     top: 10px;text-align:center"><img style="background:#618597;padding:10px;" src="'.base_url().$site->ContentValue.'">
	//     <h2 style="font-size: 26px !important;color:#d4af37">CERTIFICATE OF ACHIEVEMENT</h2></div></div><div class="row pm-certificate-body" style="padding: 0px;"><div class="pm-certificate-block" style="width: 650px;
	//     height: 200px;
	//     position: relative;
	//     left: 50%;
	//     margin-left: -325px;
	//     top: 25px;
	//     margin-top: 0;display: block"><div class="col-xs-12" style="width:100%;"><div class="row" style="margin-right: -15px;
	//     margin-left: -15px;"><div class="col-xs-2"><!-- LEAVE EMPTY --></div><div class="pm-certificate-name underline margin-0 col-xs-8 text-center" style="text-align: center;font-size: 20px;margin-bottom: 5px;"><span class="pm-name-text bold" >'.strtoupper($user->UserName).'</span></div><div class="col-xs-2"><!-- LEAVE EMPTY --></div></div></div><div class="col-xs-12" style="width:100%;"><div class="row"><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div><div class="pm-earned col-xs-8 text-center" style="margin: 15px 0 20px;width:100%;text-align:center"><span class="pm-earned-text padding-0 block cursive" style="font-size: 16px;text-align:center">has earned</span><span class="pm-credits-text block bold sans" style="font-size: 18px;display: block">'.$key->Rank.'</span></div><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div><div class="col-xs-12" style="width:100%;"></div></div></div><div class="col-xs-12" style="width:100%;margin-top: 40px;"><div class="row"><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div><div class="pm-course-title col-xs-8 text-center" style="text-align:center"><span class="pm-earned-text block cursive">while completing the '.$key->Rank .' entitled</span></div><div class="col-xs-2" style="width: 16.66666667%;display: block"><!-- LEAVE EMPTY --></div></div></div><div class="col-xs-12" style="width:100%;"><div class="row"><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div><div class="pm-course-title underline col-xs-8 text-center" style="text-align:center;    margin-bottom: 5px;"><span class="pm-credits-text block bold sans" style="display: block;font-size:15px;">'.$emailcont.'</span></div><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div></div></div></div><div class="col-xs-12" style="width:100%;"><div class="row" style="width: 75%;
	//     margin-left: -15px;
	//     margin-right: -15px;margin-top:50px;"><div class="pm-certificate-footer" style="width: 650px;
	//     height: 100px;
	//     position: relative;
	//     left: 50%;
	//     margin-left: -325px;
	//     bottom: -10px;
	//     display: inline-flex;"><div class="col-xs-4 pm-certified col-xs-4 text-center" style="text-align:center;width: 33.33333333%;flot:left;font-size: 12px;"><span class="pm-credits-text block sans" style="display: block">Approve By</span><span class="pm-empty-space block underline" style="display: block;    margin-bottom: 5px;height:20px;
	//     width: 100%;margin-top:10px;">'.$sitename->ContentValue.'</span></div><div class="col-xs-4" style="width: 33.33333333%;"></div><div class="col-xs-4 pm-certified col-xs-4 text-center" style="text-align:center;width: 33.33333333%;float:right;font-size: 12px;"><span class="pm-credits-text block sans" style="display: block">Date Completed</span><span class="pm-empty-space block underline" style="display: block;margin-bottom:5px;height:20px;
	//     width: 100%;margin-top:10px;">'.date('Y-m-d').'</span></div></div>
	//     </div></div></div></div></div>
	//     </body></html>';


	// 	$this->email->message($body); 

	// 	print_r($body);
	// 	exit();
	// 	$this->email->set_mailtype("html");


	// 	$Mail_status = $this->email->send();

	// }

	public function getpackage()
	{

	$mlsetting 	= $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
	if($mlsetting->Id==4) {
	$ptableName ="arm_pv";
	} 
	else if($mlsetting->Id==5 || $mlsetting->Id==8) 
	{
	$ptableName ="arm_boardplan";
	} 
	else 
	{
	$ptableName ="arm_package";
	}
	$pcondition = " Status ='1'  order by PackageId ASC";
	$package_det= $this->common_model->GetResults($pcondition, $ptableName);
	header("Content-Type: application/json");
	$response["package"] = $package_det;
	echo json_encode($response);
	exit;
	}

	public function getcountry()
	{

	$pcondition = "";
	$ptableName='arm_country';
	$package_det= $this->common_model->GetResults($pcondition, $ptableName);
	header("Content-Type: application/json");
	$response["country"] = $package_det;
	echo json_encode($response);
	exit;



	}



	public function authgoogle($memberid)
	{

	$this->load->library('google_authendicator');

	$google2fa = new Google_authendicator();

	// secret key
	$secret = $google2fa->createSecret();

	if($secret)
	{

	$get_code=$google2fa->getCode($secret);

	if($get_code)
	{
	// update the db for that user google authendicate code 

	$data = array('google_authendicatecode' =>  $get_code);                   

	$condition = "MemberId='".$memberid."'";
	$update = $this->common_model->UpdateRecord($data,$condition,'arm_members');

	if($update)
	{


	$fetch_members=$this->common_model->GetRow("MemberId='".$this->session->userdata('MemberID')."'","arm_members");
	$username=$fetch_members->UserName;

	$fetch_site = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitename'", "arm_setting");
	$site_name  =$fetch_site->ContentValue;


	$get_qrcode=$google2fa->getQRCodeGoogleUrl($username,$secret,$site_name);
	if($get_qrcode)
	{

	$this->data['qr_code']  = $get_qrcode;				

	}
	$this->data['memberid'] = $memberid;
	$this->data['codess']  = $get_code;
	$this->load->view('user/verifyauth',$this->data);
	}
	}
	}

	}
	public function success()
	{
	//$payment=$this->input->post('mobilePaymentData');
	$data = array(
	'payment' => 'gpay',
	'post_content' => json_encode($_POST),
	'datetime' => date('Y-m-d H:i:s')
	);
	$ipn=$this->db->insert('arm_ipn_process', $data);	

	$this->data['message'] = 'Thank you...Your order successfully Approved';
	$this->load->view('user/success', $this->data);
	}

	public function logout() {
	// $this->db->delete('arm_member_activity', array('UserId' => $this->session->userdata('MemberID')));
	$check = $this->db->query("select * from arm_members where MemberId='".$this->session->userdata('MemberID')."' ")->row();

	$live_update =  $this->db->query("UPDATE arm_members SET new_entry = '".date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')))."' WHERE MemberId ='".$this->session->userdata('MemberID')."' ");


	$live_status =  $this->db->query("UPDATE arm_members SET facebookurl ='0' WHERE MemberId ='".$this->session->userdata('MemberID')."' ");



	if($check->proof_verify=='2' )
	{
	$query = $this->db->query("update arm_members  set kyc_check='2'  where MemberId='".$this->session->userdata('MemberID')."'");

	}
	$this->session->sess_destroy();
	redirect('');
	}

	public function forgot()
	{
	if($this->input->post())
	{

	$this->form_validation->set_rules('usermail', 'usermail', 'trim|required|valid_email|callback_useremail_check');
	if ($this->form_validation->run() == FALSE) 
	{

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
	// $user = $this->common_model->GetRow("Email='".$this->input->post('useremail')."' AND MemberStatus='Active'","arm_members");

	$user = $this->common_model->GetRow("Email='".$this->input->post('useremail')."'","arm_members");

	if($user)
	{

	$string = "ACDEFGHJKMNPQRTZXYW123456789";
	$count = strlen($string);
	$randomstring='';
	for($x=1;$x<=7;$x++)
	{ 
	$pos = rand(0,$count);
	$randomstring.= substr($string,$pos,1); 


	}



	$data = array(
	'password' => SHA1(SHA1($randomstring))
	);
	$mupdate = $this->common_model->UpdateRecord($data,"MemberId='".$user->MemberId."'","arm_members");



	$message = $this->common_model->GetRow("Page='forgotpassword'","arm_emailtemplate");
	$site = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'","arm_setting");
	$sitename = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitename'","arm_setting");


	$emailcont = urldecode($message->EmailContent);
	// echo "<br>1 time => <br>".$emailcont ;
	$logo = '<img src="'.base_url().$site->ContentValue.'">';
	$emailcont = str_replace('[LOGO]', $logo, $emailcont);
	$emailcont = str_replace('[DATE]', date("d M Y H:i:s A"), $emailcont);
	$emailcont = str_replace('[FIRSTNAME]', $user->UserName, $emailcont);
	$emailcont = str_replace('[USERNAME]', $user->UserName, $emailcont);
	$emailcont = str_replace('[PASSWORD]', $randomstring, $emailcont);
	$emailcont = str_replace('[URL]', base_url(), $emailcont);     
	//$smtpmail="admin@referlife.com";
	$this->email->from($smtpmail, $sitename->ContentValue);
	$this->email->to($user->Email);
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

	$string = "Sentence Ã¢â‚¬Ëœnot-criticalÃ¢â‚¬â„¢ and \n sorting Ã¢â‚¬Ëœnot-criticalÃ¢â‚¬â„¢ or this \r and some Ã¢â‚¬Ëœnot-criticalÃ¢â‚¬â„¢ more. ' ! -.";
	$body = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $body);

	// echo "<br>2 nd time ==><br>".$body; exit;
	$this->email->message($body); 

	$this->email->set_mailtype("html");

	$Mail_status = $this->email->send();
	//send sms by bulksms
	// $smsresult = sendbulksms($user->Phone,$smsconts);
	if($Mail_status) {

		// echo "<br>mail sent";
		$from='admin@forlord.com';
		$headers = 'From: ' . $from . ' ' . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\b";
		$retval = mail($user->Email,$message->EmailSubject,$body,$headers);

	$this->session->set_flashdata('success_message', $this->lang->line('successforgot'));


	if($this->input->post('web_mode')=='1')
	{
	$this->session->set_flashdata('success_message', $this->lang->line('successforgot'));
	$this->load->view('user/forgotpassword');

	}
	else
	{
	header("Content-Type: application/json");
	$response["success"] = 1;
	$response["message"] = "Password Details Successfully send to Mail";
	$response["redirect"]="user/forgotpassword";
	echo json_encode($response);
	exit;
	}
	// redirect('admin/customers');
	} else {
	$error_mail = $this->email->print_debugger();

	if($this->input->post('web_mode')=='1')
	{
	$this->session->set_flashdata('error_message', $error_mail);
	$this->load->view('user/forgotpassword');
	}
	else
	{
	header("Content-Type: application/json");
	$response["success"] = 0;
	$response["message"] = "Reterive Failed. Pls check Mail configurations";
	$response["redirect"]="user/forgotpassword";
	echo json_encode($response);
	exit;
	}

	}
	}
	else{

	if($this->input->post('web_mode')=='1')
	{
	$this->session->set_flashdata('error_message', $this->lang->line('errorforgot'));
	$this->load->view('user/forgotpassword');
	}
	else
	{
	header("Content-Type: application/json");
	$response["success"] = 0;
	$response["message"] = "Only active members can use this forgot password. please contact administrator";
	$response["redirect"]="user/forgotpassword";
	echo json_encode($response);
	exit;
	}
	}
	}
	else
	{

	if($this->input->post('web_mode')=='1')
	{
	$this->session->set_flashdata('error_message', $this->lang->line('errorforgot'));
	$this->load->view('user/forgotpassword');
	}
	else
	{
	header("Content-Type: application/json");
	$response["success"] = 0;
	$response["message"] = "Only active members can use this forgot password. please contact administrator";
	$response["redirect"]="user/forgotpassword";
	echo json_encode($response);
	exit;
	}
	/*$this->session->set_flashdata('error_message', $this->lang->line('errorforgot'));
	$this->load->view('user/forgotpassword');*/
	}
	// exit;

	}
	else
	{
	$this->load->view('user/forgotpassword');

	}
	}

	 public function send_mail() { 
         $from_email = "palani@arminfotech.us"; 
         $to_email 	 = "palani@arminfotech.us"; 
   
         //Load email library 
         $this->load->library('email'); 
   
         $this->email->from($from_email, 'Your Name'); 
         $this->email->to($to_email);
         $this->email->subject('Email Test'); 
         $this->email->message('Testing the email class.'); 
   
         //Send mail 
         if($this->email->send()) 
         	echo "sent";
         else 
        	echo "error";
      }


	public function useremail_check($str)
	{

	$condition = "Email =" . "'" . $str . "' AND  MemberStatus='Active'";

	$this->db->select('*');
	$this->db->from('arm_members');
	$this->db->where($condition);

	$query = $this->db->get();

	if ($query->num_rows()>0) 
	return true;
	else{
	$this->form_validation->set_message('useremail_check', $this->lang->line('errorforgot'));
	return false;
	}

	}
	public function username_check($str)
	{
	if(valid_email($str))
	{
	//$condition = "Email =" . "'" . $str . "'";
	$condition = "UserName =" . "'" . $str . "'";
	}		
	else
	{
	$condition = "UserName =" . "'" . $str . "'";
	}

	$this->db->select('*');
	$this->db->from('arm_members');
	$this->db->where($condition);

	$query = $this->db->get();
	//echo $this->db->last_query();
	if ($query->num_rows()>0) 
	return true;
	else{

	/*if($str)
	{
	$condition = "FacebookId =" . "'" . $str . "'";

	$this->db->select('*');
	$this->db->from('arm_members');
	$this->db->where($condition);

	$query = $this->db->get();
	if ($query->num_rows()>0) 
	return true;
	}
	else
	{*/
	$this->form_validation->set_message('username_check', 'This invalid details of %s');
	return false;
	/*}*/
	}

	}
	public function password_check($str)
	{

	if(valid_email($str))
	{
	$condition = "Password='" .sha1(sha1($this->input->post('password'))). "'";
	}
	else
	{
	$condition = "Password='" .sha1(sha1($this->input->post('password'))). "'";
	}

	$this->db->select('*');
	$this->db->from('arm_members');
	$this->db->where($condition);

	$query = $this->db->get();
	//echo $this->db->last_query();
	if ($query->num_rows()>0) 
	return true;
	else{
	$this->form_validation->set_message('password_check', '<p><em class="text-danger">This invalid details of %s</em></p>');
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
	// if( strcmp(strtoupper($this->input->post('captcha')),strtoupper($this->session->captchaword))==0)
	// {
	// 	return true; 
	// }
	else
	{	
	$this->form_validation->set_message('captcha_check', ucwords($this->lang->line('errorcaptcha')));
	return false;
	}

	}


	}
