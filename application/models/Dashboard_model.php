	<?php

	Class Dashboard_model extends CI_Model {

	// get tables


	public function __construct() {
	parent::__construct();

	$this->load->model('MemberCommission_model');

	}

	public function GetActiveMember() {

	$condition = "isDelete='0' AND MemberStatus='Active'";
	$this->db->select('*');
	$this->db->from('arm_members');
	$this->db->where($condition);

	$query = $this->db->get();

	if ($query->num_rows()>0) {
	return $query->result();
	} else {
	return false;
	}
	}


	public function DashResults($condition='', $tableName, $limit, $start) {

	$this->db->limit($limit, $start);
	$this->db->select('*');
	$this->db->from($tableName);

	if($condition)
	$this->db->where($condition);

	$query = $this->db->get();

	if ($query->num_rows()>0) {
	$row = $query->result();
	return $row;
	} else {
	return false;
	}
	}

	public function DashRow($condition='', $tableName, $limit, $start) {

	$this->db->limit($limit, $start);
	$this->db->select('*');
	$this->db->from($tableName);

	if($condition)
	$this->db->where($condition);

	$query = $this->db->get();

	if ($query->num_rows()>0) {
	return $query->row();
	} else {
	return false;
	}
	}

	public function DashCount($condition='', $tableName) {

	$this->db->select('*');
	$this->db->from($tableName);

	if($condition)
	$this->db->where($condition);

	$query = $this->db->get();

	if ($query->num_rows()>0) {
	$row = $query->result();
	return $query->num_rows();
	} else {
	return false;
	}
	}

	public function GetfromTicketsCount($memberId) {
	$this->db->select('*');
	$this->db->from('arm_ticket t');
	$this->db->join('arm_ticket_list tl', 'tl.TicketId = t.TicketId');
	// $this->db->join('arm_members m', 'm.MemberId = t.MemberId');
	$this->db->group_by('tl.TicketId');

	$this->db->where('tl.MemberId',$memberId);

	$query = $this->db->get();

	if ($query->num_rows()>0) {
	return $query->num_rows();
	} else {
	return false;
	}
	}

	Public function GetNewMembersTotal($condition){

	$this->db->select('*');
	$this->db->from('arm_members');
	$this->db->where($condition);
	$query = $this->db->get();

	if ($query->num_rows()>0) {
	return $query->num_rows();
	} else {
	return 0;
	}	
	}

	Public function GetSums($condition, $table, $column){
	$this->db->select_sum($column);
	// $this->db->select('*');
	$this->db->from($table);
	$this->db->where($condition);
	$query = $this->db->get();

	if ($query->num_rows()>0) {
	return $query->row();
	} else {
	return 0;
	}	
	}

	Public function GetBalance($condition, $table, $column){
	$this->db->select_sum($column);
	// $this->db->select('*');
	$this->db->from($table);
	$this->db->where($condition);
	$this->db->order_by('HistoryId', 'DESC');
	$this->db->limit(1);
	$query = $this->db->get();

	if ($query->num_rows()>0) {
	return $query->row();
	} else {
	return 0;
	}	
	}

	public function check_rank($userid)
	{


	$gflag ='0';

	$all_rank = $this->db->query("SELECT * FROM `arm_ranksetting` where Status='1' ORDER BY rank_id ASC ")->result();

	$user = $this->db->query("SELECT * FROM `arm_members` where memberId='".$userid."'")->row();

	$total_upgrade = $this->db->query("SELECT sum(Credit) as upgrade  FROM `arm_history` where TypeId='19' and MemberId ='".$user->DirectId."'")->row();

	$users = $this->common_model->GetRow("memberId='".$userid."' AND MemberStatus='Active'","arm_members");
	$user = $this->common_model->GetRow("MemberId='".$user->DirectId."'","arm_members");


	if($user->rank!="")
	{
	$urank = $user->rank;
	}
	else
	{
	$urank = '0';
	}

	foreach ($all_rank as $key ) {

	$package_check = $key->min_pack_inves;
	$current_level = $key->current_lev;

	if($current_level=="")
	{
	$current_levels = "";
	}
	else
	{
	$current_levels = $current_level;
	}


	if($key->rank_id!=$user->rank)
	{


	if($total_upgrade->upgrade >= $package_check)
	{


	if($current_levels==$urank) 
	{

	if($current_levels=="0")
	{
	$user_earn = $this->db->query("SELECT sum(Credit) as userEran  FROM `arm_history` where TypeId='4' and `Description` LIKE '%Indirect%' and MemberId ='".$userid."'")->row();
	}
	else
	{
	$user_earn = $this->db->query("SELECT sum(Credit) as userEran  FROM `arm_history` where TypeId='27' and MemberId ='".$userid."' and Rankname ='".$urank."'")->row();
	}



	if($user_earn->userEran!="")
	{
	$uearn = $user_earn->userEran;
	}
	else
	{
	$uearn = 0;
	}


	if($uearn >= $key->elig_earn && $key->rank_id!=$user->rank)
	{


	$user_indirect_delete = $this->db->query("DELETE FROM `arm_history` WHERE TypeId='30'  and MemberId ='".$userid."'");

	$gflag ='1';


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


	$message = $this->common_model->GetRow("Page='RankAchived'","arm_emailtemplate");
	$emailcont = urldecode($message->EmailContent);
	$site = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'","arm_setting");
	$sitename = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitename'","arm_setting");	

	// echo "<br>1 time => <br>".$emailcont ;
	$logo = '<img src="'.base_url().$site->ContentValue.'">';
	$this->email->from($smtpmail, $sitename->ContentValue);
	$this->email->to($user->Email);
	$this->email->subject($message->EmailSubject);


	$body =
	'<!DOCTYPE html> <html>
	<style>
	.cursive {
	font-family: "Pinyon Script", cursive;
	}
	.sans {
	font-family: "Open Sans", sans-serif;
	}
	.bold {
	font-weight: bold;
	}
	.block {
	display: block;
	}
	.underline {
	border-bottom: 1px solid #777;
	padding: 5px;
	margin-bottom: 15px;
	}
	.margin-0 {
	margin: 0;
	}
	.padding-0 {
	padding: 0;
	}
	.pm-empty-space {
	height:13px;
	width: 100%;
	}
	body {
	padding: 20px 0;
	background: #ccc;
	}
	.pm-certificate-container {
	position: relative;
	width: 800px;
	height: 600px;
	background-color: #618597;
	padding: 2px;
	color: #333;
	box-shadow: 0 0 5px rgba(0, 0, 0, .5);
	}
	.pm-certificate-container .outer-border {
	width: 794px;
	height: 594px;
	position: absolute;
	left: 50%;
	margin-left: -397px;
	top: 50%;
	margin-top:-297px;
	border: 2px solid #fff;
	}
	.inner-border {
	width: 730px;
	height: 530px;
	position: absolute;
	left: 50%;
	margin-left: -365px;
	top: 50%;
	margin-top:-265px;
	border: 2px solid #fff;
	}
	.pm-certificate-border {
	position: relative;
	width: 720px !important;
	height: 520px;
	padding: 0;
	border: 1px solid #E1E5F0;
	background-color: rgba(255, 255, 255, 1);
	background-image: none;
	left: 50%;
	margin-left: -360px;
	top: 50%;
	margin-top: -260px;
	}
	.pm-certificate-block {
	width: 650px;
	height: 200px;
	position: relative;
	left: 50%;
	margin-left: -325px;
	top: 70px;
	margin-top: 0;
	}
	.pm-certificate-header {
	margin-bottom: 10px;
	}

	.pm-certificate-container .pm-certificate-title {
	position: relative;
	top: 10px;
	}
	.pm-certificate-container .pm-certificate-title h2 {
	font-size: 34px !important;
	}

	.pm-certificate-container .pm-certificate-body {
	padding: 20px;
	}
	.pm-certificate-container .pm-certificate-body .pm-name-text {
	font-size: 20px;
	}

	.pm-certificate-container .pm-earned {
	margin: 15px 0 20px;
	}
	.pm-certificate-container .pm-earned  .pm-earned-text{
	font-size: 20px;
	}

	.pm-certificate-container .pm-earned  .pm-credits-text {
	font-size: 15px;
	}


	.pm-certificate-container .pm-earned  .pm-course-title .pm-earned-text {
	font-size: 20px;
	}
	.pm-certificate-container .pm-earned  .pm-course-title .pm-earned-text .pm-credits-text {
	font-size: 15px;
	}

	.pm-certificate-containe .pm-certified {
	font-size: 12px;
	}
	.pm-certificate-containe .pm-certified .underline {
	margin-bottom: 5px;
	}
	.pm-certificate-containe .pm-certificate-footer {
	width: 650px;
	height: 100px;
	position: relative;
	left: 50%;
	margin-left: -325px;
	bottom: -105px;
	}
	.col-xs-12
	{
	text-align: center;
	}
	</style>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<body><div class="container pm-certificate-container"><div class="outer-border" style="width: 794px;
	height: 594px;
	position: absolute;
	left: 50%;
	margin-left: -397px;
	top: 50%;
	margin-top: -297px;
	border: 2px solid #fff;"></div><div class="inner-border" style="width: 730px;
	height: 530px;
	position: absolute;
	left: 50%;
	margin-left: -365px;
	top: 50%;
	margin-top: -265px;
	border: 2px solid #fff;"></div><div class="pm-certificate-border col-xs-12"style="position: relative;
	width: 720px;
	height: 520px;
	padding: 0;
	border: 1px solid #E1E5F0;
	background-color: #ffffff;
	background-image: none;
	left: 50%;
	margin-left: -360px;
	top: 50%;
	margin-top: -260px;"><div class="row pm-certificate-header" style=" margin-bottom: 10px;"><div class="pm-certificate-title cursive col-xs-12 text-center" style="position: relative;
	top: 10px;text-align:center"><img style="background:#618597;padding:10px;" src="'.base_url().$site->ContentValue.'">
	<h2 style="font-size: 26px !important;color:#d4af37">CERTIFICATE OF ACHIEVEMENT</h2></div></div><div class="row pm-certificate-body" style="padding: 0px;"><div class="pm-certificate-block" style="width: 650px;
	height: 200px;
	position: relative;
	left: 50%;
	margin-left: -325px;
	top: 25px;
	margin-top: 0;display: block"><div class="col-xs-12" style="width:100%;"><div class="row" style="margin-right: -15px;
	margin-left: -15px;"><div class="col-xs-2"><!-- LEAVE EMPTY --></div><div class="pm-certificate-name underline margin-0 col-xs-8 text-center" style="text-align: center;font-size: 20px;margin-bottom: 5px;"><span class="pm-name-text bold" >'.strtoupper($user->UserName).'</span></div><div class="col-xs-2"><!-- LEAVE EMPTY --></div></div></div><div class="col-xs-12" style="width:100%;"><div class="row"><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div><div class="pm-earned col-xs-8 text-center" style="margin: 15px 0 20px;width:100%;text-align:center"><span class="pm-earned-text padding-0 block cursive" style="font-size: 16px;text-align:center">has earned</span><span class="pm-credits-text block bold sans" style="font-size: 18px;display: block">'.$key->Rank.'</span></div><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div><div class="col-xs-12" style="width:100%;"></div></div></div><div class="col-xs-12" style="width:100%;margin-top: 40px;"><div class="row"><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div><div class="pm-course-title col-xs-8 text-center" style="text-align:center"><span class="pm-earned-text block cursive">while completing the '.$key->Rank .' entitled</span></div><div class="col-xs-2" style="width: 16.66666667%;display: block"><!-- LEAVE EMPTY --></div></div></div><div class="col-xs-12" style="width:100%;"><div class="row"><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div><div class="pm-course-title underline col-xs-8 text-center" style="text-align:center;    margin-bottom: 5px;"><span class="pm-credits-text block bold sans" style="display: block;font-size:15px;">'.$emailcont.'</span></div><div class="col-xs-2" style="width: 16.66666667%;"><!-- LEAVE EMPTY --></div></div></div></div><div class="col-xs-12" style="width:100%;"><div class="row" style="width: 75%;
	margin-left: -15px;
	margin-right: -15px;margin-top:50px;"><div class="pm-certificate-footer" style="width: 650px;
	height: 100px;
	position: relative;
	left: 50%;
	margin-left: -325px;
	bottom: -10px;
	display: inline-flex;"><div class="col-xs-4 pm-certified col-xs-4 text-center" style="text-align:center;width: 33.33333333%;flot:left;font-size: 12px;"><span class="pm-credits-text block sans" style="display: block">Approve By</span><span class="pm-empty-space block underline" style="display: block;    margin-bottom: 5px;height:20px;
	width: 100%;margin-top:10px;">'.$sitename->ContentValue.'</span></div><div class="col-xs-4" style="width: 33.33333333%;"></div><div class="col-xs-4 pm-certified col-xs-4 text-center" style="text-align:center;width: 33.33333333%;float:right;font-size: 12px;"><span class="pm-credits-text block sans" style="display: block">Date Completed</span><span class="pm-empty-space block underline" style="display: block;margin-bottom:5px;height:20px;
	width: 100%;margin-top:10px;">'.date('Y-m-d').'</span></div></div>
	</div></div></div></div></div>
	</body></html>';

	$this->email->message($body); 
	$this->email->set_mailtype("html");

	$Mail_status = $this->email->send();
	if($Mail_status) {
	} else {
	$error_mail = $this->email->print_debugger();

	}

	}



	if($key->bonus_type=='2')
	{
	$date = date('y-m-d h:i:s');

	$Mdata = array(
	'rank'=>$key->rank_id,
	);

	$result = $this->common_model->UpdateRecord($Mdata, "MemberId='".$user->MemberId."'", 'arm_members');

	$txnid = "RAK".rand(1111111,9999999);
	$bal = $this->common_model->Getcusomerbalance($user->MemberId);

	$data1 = array(
	'MemberId'=>$user->MemberId,
	'TransactionId'=>$txnid,
	'DateAdded'=>$date,
	'Status' =>2,
	'Rankname'=>$key->rank_id,
	'Balance'=>$bal,
	'Description'=>"Level Non Cash Bonus Achieved",
	'TypeId'=>"22"
	);
	}
	else
	{

	$date = date('y-m-d h:i:s');
	$Mdata = array(
	'rank'=>$key->rank_id,
	);
	$result = $this->common_model->UpdateRecord($Mdata, "MemberId='".$user->MemberId."'", 'arm_members');

	$txnid = "RAK".rand(1111111,9999999);
	$bal = $this->common_model->Getcusomerbalance($user->MemberId);

	$data1 = array(
	'MemberId'=>$user->MemberId,
	'TransactionId'=>$txnid,
	'DateAdded'=>$date,
	'Description'=>"Level Cash Bonus Achieved",
	'Credit'=>$key->bonus_amt,
	'Balance'=>$bal+$key->bonus_amt,
	'TypeId'=>"21"
	);
	}

	$result1 = $this->common_model->SaveRecords($data1,'arm_history');
	$insert_id = $this->db->insert_id();

	$datas = array(
	'MemberId'=>$user->MemberId,
	'DirectId'=>$user->DirectId,
	'type_id'=>'3',
	'status'=>'1',
	'date'=> date('Y-m-d'),
	'history_id'=>$insert_id
	);
	$arm_notification = $this->common_model->SaveRecords($datas,'arm_notification');
	$this->common_model->level_commision($user->MemberId,$key->rank_id,'0');
	}
	}
	}
	}
	}

	if($gflag == 0)
	{
	$this->MemberCommission_model->rank_commision($user->MemberId,0,$userid,0);
	}

	}


	}

	?>