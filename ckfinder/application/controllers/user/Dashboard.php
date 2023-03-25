<?php
ini_set("display_errors",0);
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
			// $this->load->model('common_model');
			$this->load->model('ticket_model');
			$this->load->model('dashboard_model');
			$this->load->model('order_model');
			$this->load->model('admin/Leadcapture_model');
			//$this->load->model('user/fund_model');
			$this->lang->load('dashboard',$this->session->userdata('language'));
				
			$this->lang->load('user/common',$this->session->userdata('language'));
			// $this->load->helper('cms_helper');

			

		/*}  else {
	    	redirect('login');
	    }*/
	}


	public function index()
	{
		

		//if($this->session->userdata('logged_in')) 
		//{


			$userid = $this->session->MemberID;




			$this->data['leadpage'] = $this->Leadcapture_model->Getfields();
			$this->data['member'] = $this->common_model->GetCustomer($userid);

			$condition1 = "MemberId='".$userid."' AND Status!='paid' order by OrderId desc";
			$this->data['latestorders'] = $this->dashboard_model->DashResults($condition1,'arm_order','7','0');
			//$this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
			// $condition2 = "MemberId='".$this->session->MemberID."' AND Status='paid'";
			// $this->data['purchased'] = $this->common_model->GetResults($condition2,'arm_order','*');
			$condition2 = "o.MemberId =" . "'" . $userid . "' AND Status='paid'";
			$this->data['purchased'] = $this->order_model->GetOrders($condition2);
			// $this->data['purchased'] = $this->common_model->GetCustomer($this->session->MemberID);

			// list spilliover
			$ucondition = "SpilloverId = '".$userid."'";
			$membermatsts = $this->common_model->GetRow("MatrixStatus='1'",'arm_matrixsetting');
			
			if($membermatsts->Id==2)
			{
				$table = "arm_unilevelmatrix";
				$ptableName ="arm_package";
			}
			else if($membermatsts->Id==3)
			{
				$table = "arm_monolinematrix";
				$mndet = $this->common_model->GetRow("MemberId='".$userid."' order by MonoLineId asc limit 0,1", 'arm_monolinematrix');
				if($mndet)
				{
					$ucondition = "SpilloverId = '".$mndet->MonoLineId."'";

				}
				$ptableName ="arm_package";
			
			}
			else if($membermatsts->Id==4)
			{
				$table = "arm_binarymatrix";
				$ptableName ="arm_pv"; 
			}

			else if($membermatsts->Id==5)
			{
				$ptableName ="arm_boardplan";
				$table = "arm_boardmatrix";
				$brddet = $this->common_model->GetRow("MemberId='".$userid."' order by BoardMemberId asc limit 0,1", 'arm_boardmatrix');
				if($brddet)
				{
					$ucondition = "SpilloverId = '".$brddet->BoardMemberId."'";

				}
			}
			else if($membermatsts->Id==6)
			{
				$table = "arm_xupmatrix";
				$ptableName ="arm_package";
			}
			else
			{	
				$ptableName ="arm_package";
				$table = "arm_forcedmatrix";
			}


			if($this->data['member']->PackageIdU=='0')
				$this->data['package']=$this->common_model->GetRow("PackageId='".$this->data['member']->PackageId."'",$ptableName);
			else
				$this->data['package']=$this->common_model->GetRow("PackageId='".$this->data['member']->PackageIdU."'",$ptableName);
			
			$this->data['total_spillover'] = $this->common_model->GetRowCount($ucondition,$table);
			$this->data['spillovers'] = $this->dashboard_model->DashResults($ucondition,$table, '8', '0');
			
			$condition3 = "Status='1'";
			$this->data['news'] = $this->dashboard_model->DashResults($condition3,"arm_news", '5', '0');
			// echo $this->db->last_query();
			// exit();



			$this->data['tickets'] = $this->ticket_model->GetfromTickets($userid, '4', '0');
			
			$comm_condition = "MemberId='".$userid."' AND DATE(DateAdded)='".date('Y-m-d')."'";
			$this->data['comm'] = $this->dashboard_model->GetSums($comm_condition, 'arm_history','Debit');

			$order_condition = "isDelete='0' AND DATE(DateAdded)='".date('Y-m-d')."'";
			$this->data['orders'] = $this->dashboard_model->GetSums($order_condition, 'arm_order','OrderTotal');
			
			$member_condition = "isDelete =" . "'0' AND DATE(DateAdded)='".date('Y-m-d')."'";
			$this->data['newmember'] = $this->dashboard_model->GetNewMembersTotal($member_condition);

			$bal_condition = "MemberId='".$userid."'";
			$this->data['balance'] = $this->dashboard_model->GetBalance($bal_condition, 'arm_history','Balance');

			$income_query = $this->db->query("SELECT MONTH(DateAdded) as mon, sum(Credit) as credit FROM arm_history WHERE MemberId='".$userid."' AND TypeId IN('4','5','15','18') GROUP BY MONTH(DateAdded)");
			$this->data['income_data'] = $income_query->result();
			



			for($i=1;$i<=12;$i++) {
				$dummy_data[$i] = "0.00";
			}
			
			
			$credit_data = '';
			foreach ($this->data['income_data'] as $row) {

				if($row->mon) {
					$credit_data = ($row->credit) ? $row->credit : "0.00";
					$ins_data[$row->mon] = $credit_data;
				}
				
			}



			if(isset($ins_data)) {
				$ins_data1 = array_replace($dummy_data, $ins_data);
				$this->data['income_chart_data'] = implode(',', $ins_data1);
			} else {
				$this->data['income_chart_data'] = implode(',', $dummy_data);
			}
			
			$outcome_query = $this->db->query("SELECT MONTH(DateAdded) as mon, sum(Debit) as debit FROM arm_history WHERE MemberId='".$userid."' AND TypeId NOT IN('4','5','15','18') GROUP BY MONTH(DateAdded)");
			$this->data['outcome_data'] = $outcome_query->result();
			
			


			$debit_data = '';
			foreach ($this->data['outcome_data'] as $row) {

				if($row->mon) {
					$debit_data = ($row->debit) ? $row->debit : "0.00";
					$out_data[$row->mon] = $debit_data;
				}

			}



			if(isset($out_data)) {
				$out_data1 = array_replace($dummy_data, $out_data);
				$this->data['outcome_chart_data'] = implode(',', $out_data1);
			} else {
				$this->data['outcome_chart_data'] = implode(',', $dummy_data);
			}
			
			$this->date['userid']=$this->session->MemberID;


$this->data['user'] = $this->db->query("SELECT * FROM `arm_members` where memberId='".$userid."'")->row();










$this->data['total_upgrade'] = $this->db->query("SELECT sum(Debit) as upgrade  FROM `arm_history` where TypeId='19' and MemberId ='".$userid."'")->row();

$this->data['total_token'] = $this->db->query("SELECT sum(credit) as total_token  FROM `arm_history` where TypeId='50' and MemberId ='".$userid."'")->row();

$this->data['user_earn'] = $this->db->query("SELECT sum(Credit) as userEran  FROM `arm_history` where TypeId='21' and MemberId ='".$userid."'")->row();


$this->data['total_earngings'] = $this->db->query("SELECT sum(Credit) as total_earn  FROM `arm_history` where MemberId ='".$userid."' and TypeId IN('4','11','20','21','27','24','25')")->row();


$this->data['active_dep'] = $this->db->query("SELECT  * FROM `arm_history` where MemberId ='".$userid."' and TypeId ='19' order by HistoryId DESC ")->row();

$this->data['user_balance'] = $this->db->query("SELECT  * FROM `arm_history` where MemberId ='".$userid."'  order by HistoryId DESC")->row();


$this->data['reward_earnings'] = $this->db->query("SELECT sum(Credit) as total_earn  FROM `arm_history` where MemberId ='".$userid."' and TypeId IN (5,20,25)")->row();


$this->data['user_withdraw'] = $this->db->query("SELECT sum(Debit) as total_with  FROM `arm_history` where MemberId ='".$userid."' and TypeId='7'")->row();



$this->data['all_rank'] = $this->db->query("SELECT * FROM `arm_ranksetting` where Status='1' ORDER BY rank_id ASC ")->result();

$check_rank = $this->db->query("SELECT * FROM `arm_history` where MemberId ='".$userid."' and TypeId ='19' order by HistoryId ASC ")->result();


    $this->data['receved_rank'] = array();

	foreach ($check_rank as $key ) {
	$this->data['receved_rank'][] = $key->PackageId;
	}


$target_achives = $this->db->query("SELECT * FROM arm_target_setting where status='1'")->result();


if($target_achives)
{

foreach ($target_achives as $target_achive) {


$last_achive = $this->db->query("SELECT * FROM arm_history where MemberID='".$userid."' and TypeId='25' and Rankname='".$target_achive->id."'  ")->row();


if($last_achive!="")
{
	$get_dates = date('Y-m-d 21:00:00',strtotime($last_achive->DateAdded));
	$get_date=date('Y-m-d 21:00:00');
}
else
{
	$get_dates = "";
	$get_date=date('Y-m-d 21:00:00');
}


if($target_achive->earning_mode=='1')
{
    $tomorrow = date('Y-m-d 21:00:00',strtotime($get_date . "-7 days"));

    $check_last_entry = $this->db->query("select * from arm_history where MemberId='".$userid."' and TypeId='25' and address='".$target_achive->id."' and week(DateAdded)=week(now())")->row();

}
if($target_achive->earning_mode=='2')
{
	$tomorrow = date('Y-m-d 21:00:00',strtotime($get_date . "-30 days"));
	$check_last_entry = $this->db->query("select * from arm_history where MemberId='".$userid."' and TypeId='25' and address='".$target_achive->id."' and month(DateAdded)=month(now())")->row();
}
if($target_achive->earning_mode=='3')
{
	$tomorrow = date('Y-m-d 21:00:00',strtotime($get_date . "-180 days"));
	$check_last_entry = $this->db->query("select * from arm_history where MemberId='".$userid."' and TypeId='25' and address='".$target_achive->id."' and month(DateAdded)=month(now())")->row();
	
}
if($target_achive->earning_mode=='4')
{
	$tomorrow = date('Y-m-d 21:00:00',strtotime($get_date . "-364 days"));
	$check_last_entry = $this->db->query("select * from arm_history where MemberId='".$userid."' and TypeId='25' and address='".$target_achive->id."' and year(DateAdded)=year(now())")->row();

}
if($target_achive->earning_mode=='5')
{
	$days = $target_achive->duration;
	$tomorrow = date('Y-m-d 21:00:00',strtotime($get_date ."- ".$days." days"));

$check_last_entry = $this->db->query("SELECT * FROM `arm_history`  where  TypeId='25' and address='".$target_achive->id."' AND DateAdded  BETWEEN CURDATE()-".$days." AND CURDATE()")->row();

if($check_last_entry=="")
{

	if($get_dates==$get_date)
{
      $check_last_entry=1;
}

}
}



if($check_last_entry=="")
{

if($tomorrow)
{

$check_targets = $this->db->query("SELECT SUM(Credit) as target FROM arm_history WHERE DateAdded BETWEEN  '" . $tomorrow . "' AND  '" . $get_date . "' AND MemberId='".$this->session->MemberID."' and TypeId!='25' and TypeId!='19'
ORDER by HistoryId DESC")->row(); 
}



if($check_targets->target >= $target_achive->target_amount)
{

	$bal = $this->common_model->Getcusomerbalance($userid);
	$txnid = "TARGET".rand(1111111,9999999);
	$data1 = array(
	'MemberId'=>$userid,
	'TransactionId'=>$txnid,
	'DateAdded'=>date('Y-m-d'),
	'Description'=>"Target Bonus Achieved",
	'Credit'=>$target_achive->target_bonus,
	'Balance'=>$bal+$target_achive->target_bonus,
	'TypeId'=>"25",
	'address'=>$target_achive->id
	);

	$user = $this->common_model->GetRow("memberId='".$this->session->MemberID."' AND MemberStatus='Active'","arm_members");


	 $result1 = $this->common_model->SaveRecords($data1,'arm_history');
     $insert_id = $this->db->insert_id();

     //Token Target Bonus Achived
     $earning_mode=$target_achive->earning_mode;
     $target_tokengetter= $this->common_model->GetRow("earning_mode ='".$earning_mode."' ","arm_target_setting");
	 $token_targetrewards=$target_tokengetter->target_rewards;
	 $txnid1 = "TOCKENGET".rand(1111111,9999999);

	$data13 = array(
	'MemberId'=>$userid,
	'TransactionId'=>$txnid1,
	'DateAdded'=>date('Y-m-d'),
	'Description'=>" Tocken Target Bonus Achieved",
	'Credit'=>$target_achive->target_rewards,
	'Balance'=>$bal+$target_achive->target_bonus,
	'TypeId'=>"52"
	);

	$result1 = $this->common_model->SaveRecords($data13,'arm_history');



	$datas = array(
	'MemberId'=>$userid,
	'DirectId'=>$user->DirectId,
	'type_id'=>'6',
	'status'=>'1',
	'date'=> date('Y-m-d'),
	'history_id'=>$insert_id
	);
	$arm_notification = $this->common_model->SaveRecords($datas,'arm_notification');

}

}
}

}



$global_target = $this->db->query("SELECT * FROM global_target")->result();
$member = $this->common_model->GetCustomer($userid);

if($global_target)
{

$get_date = date('Y-m-d');

foreach ($global_target as $get_global) {


$check_last_entry = $this->db->query("SELECT * FROM `arm_history` where Description like '%Gloabal Bonus Achieved%' AND  DateAdded > DATE_SUB(now(), INTERVAL 6 MONTH)")->row();

 
if($check_last_entry=="")
{
if($member->rank >= $get_global->earners)
{

	$bal = $this->common_model->Getcusomerbalance($userid);
	$txnid = "TARGET".rand(1111111,9999999);
	$data1 = array(
	'MemberId'=>$userid,
	'TransactionId'=>$txnid,
	'DateAdded'=>date('Y-m-d'),
	'Description'=>"Gloabal Bonus Achieved",
	'Credit'=>$get_global->target_bonus,
	'Balance'=>$bal+$get_global->target_bonus,
	'TypeId'=>"5",
	'paythrough'=>"Ewallet",
	'address'=>$get_global->id,
	);


	 $result1 = $this->common_model->SaveRecords($data1,'arm_history');
     $insert_id = $this->db->insert_id();


$user = $this->common_model->GetRow("memberId='".$this->session->MemberID."' AND MemberStatus='Active'","arm_members");

		$datas = array(
		'MemberId'=>$userid,
		'DirectId'=>$user->DirectId,
		'type_id'=>'6',
		'status'=>'1',
		'date'=> date('Y-m-d'),
		'history_id'=>$insert_id
		);
		$arm_notification = $this->common_model->SaveRecords($datas,'arm_notification');

}
}
}
}

	 $this->load->view('user/dashboard', $this->data);
		
	}


	public function news()
	{
		$condition = "Status='1'";
		$this->data['news'] = $this->common_model->GetResults($condition,'arm_news');
		$this->load->view('user/news',$this->data);
	}


public function Noticed($id='')
{
   $notify_id=$this->uri->segment('2');
   $history_id=$this->uri->segment('3');

   $noticed =  $this->db->query("UPDATE arm_notification SET status ='0' , history_id ='".$history_id."' WHERE id ='".$notify_id."' ");

   echo "success";

}



  public function get_chat()
  {


  $this->data['check_view'] = $this->db->query("select * from chat where recever_id ='".$this->session->MemberID."'  and status='1'  GROUP BY sender_id ORDER BY `id`  DESC")->result();

  $this->data['reward_notify'] = $this->db->query("SELECT * from arm_notification where type_id ='5' and DirectId ='".$this->session->MemberID."' and status ='1' ")->result();


  $this->data['level_notify'] = $this->db->query("SELECT * from arm_notification where type_id ='3' and DirectId ='".$this->session->MemberID."' and status ='1' ")->result();


   $this->data['deposit_notify'] = $this->db->query("SELECT * from arm_notification where type_id ='2' and DirectId ='".$this->session->MemberID."' and status ='1' ")->result();

   $this->data['rewards_notify'] = $this->db->query("SELECT * from arm_notification where type_id ='6' and DirectId ='".$this->session->MemberID."' and status ='1' ")->result();


// check count 

$check_view = $this->db->query("select * from chat where recever_id ='".$this->session->MemberID."'  and status='1'  GROUP BY sender_id ORDER BY `id`  DESC")->num_rows();

$reward_notify = $this->db->query("SELECT * from arm_notification where type_id ='5' and DirectId ='".$this->session->MemberID."' and status ='1' ")->num_rows();

$level_notify = $this->db->query("SELECT * from arm_notification where type_id ='3' and DirectId ='".$this->session->MemberID."' and status ='1' ")->num_rows();

$deposit_notify = $this->db->query("SELECT * from arm_notification where type_id ='2' and DirectId ='".$this->session->MemberID."' and status ='1' ")->num_rows();

$rewards_notify = $this->db->query("SELECT * from arm_notification where type_id ='6' and DirectId ='".$this->session->MemberID."' and status ='1' ")->num_rows();



if($check_view > 0 || $reward_notify > 0 || $level_notify > 0 || $deposit_notify > 0 || $rewards_notify > 0 )
{
    
     $this->load->view('user/messages_list',$this->data);
}
else
{
	echo 'NULL';
}

}


	public function invoice()
	{

		$this->load->view('user/inovice');
	}

		public function doc()
	{

		$this->load->view('user/doc');
	}


	public function invoice1()
	{

		$this->load->view('user/Invoice1');
	}

	public function kyc()
	{
		if($this->session->userdata('logged_in'))  {
			
			// $condition = '';
			// $tableName = 'arm_history';
			

        $this->data['kyc_users_list'] = $this->db->query("select * from arm_members where MemberId='".$this->session->MemberID."' and proof_verify>0 ")->result();
			
			
			$this->load->view('user/kyc',$this->data);
	    } else {
	    	redirect('admin/login');

	    }}

	   public function reg_invoice()
	{
		if($this->session->userdata('logged_in'))  {
			
			// $condition = '';
			// $tableName = 'arm_history';
			

        $this->data['user'] = $this->db->query("select * from arm_members where MemberId='".$this->session->MemberID."'  ")->row();
			
			
			$this->load->view('user/reg_invoice',$this->data);
	    } else {
	    	redirect('admin/login');

	    }}

	   public function update_invoice()
	{
		if($this->session->userdata('logged_in'))  {
			
			

        $this->data['user'] = $this->db->query("select * from arm_members where MemberId='".$this->session->MemberID."'  ")->row();
			
			
			$this->load->view('user/update_invoice',$this->data);
	    } else {
	    	redirect('admin/login');

	    }}
	public function newsadd() {
		if($this->input->post()) {
				
			$this->form_validation->set_rules('subject', 'subject', 'trim|required|min_length[5]|xss_clean');
			$this->form_validation->set_rules('message', 'message', 'trim|required|min_length[15]|xss_clean');

			if ($this->form_validation->run() == TRUE) {

				$field_name = "image"; 

				if($_FILES[$field_name]['name']) {
					
					$config['upload_path'] = './uploads/news/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['encrypt_name'] = TRUE;

					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload($field_name)) {
						
						//$this->session->set_flashdata('error_message', $this->upload->display_errors());
						
					} else {
						$upload_files = $this->upload->data('file_name');
					}
				}

					$data = array(
						'MemberId' => $this->input->post('category_name'),
						'Image' => ($upload_files) ? $upload_files : '',
						'Subject' => $this->input->post('ParentId'),
						'Message' => $this->input->post('SortOrder'),
						'Status' => '0',
						'StartDate' =>  date('Y-m-d h:i:s')
					);
					$status = $this->common_model->SaveRecords($data, 'arm_news');
			} else {
				redirect('user/dashboard');
			}
		} else {
			redirect('user/dashboard');
		}
	}

	public function reports()
	{

		// echo "['income', 2150, 1180, 1190, 1000, 1070, 1800, 1150, 1180, 1190, 1000, 1070, 1800],
  //                   ['expenses', 910, 3020, 760, 1080, 850, 940, 910, 1020, 760, 1080, 850, 940]";
	      
		$userid = $this->session->MemberID;
		$in_condition = "MemberId='".$userid."' AND TypeId IN('4','5','15','18')";
		$this->data['income'] = $this->dashboard_model->DashResults($in_condition, 'arm_history','10', '0');
		// $this->data['income'] = $this->dashboard_model->GetSums($in_condition, 'arm_history','Debit');

		$out_condition = "MemberId='".$userid."' AND TypeId NOT IN('4','5','15','18')";
		$this->data['outgoes'] = $this->dashboard_model->DashResults($in_condition, 'arm_history','10', '0');
		// $this->data['outgoes'] = $this->dashboard_model->GetSums($out_condition, 'arm_history','Credit');
		$data1 = array();

		//{y: '2011 Q3', item1: 523.0000, item2: 54.0000},

		$i = 1;
		$income_total = 0;
		foreach ($this->data['income'] as $income) {
			$income_total = $income_total + $income->Credit;
			$years = date('Y',strtotime($income->DateAdded))." Q".$i++;
			$data1[] = "{y: '".$years."', item1: ".$income->Credit.", item2: ".$income->Debit."}";
			// $data1['Y'] = date('Y',strtotime($income->DateAdded))." Q".$i++;
			// $data1['item1'] = $income->Credit;
			// $data1['item2'] = $income->Debit;
			
		}

		// $i = 1;
		// $expens_total = 0;
		// foreach ($this->data['outgoes'] as $expens) {
		// 	$expens_total = $expens_total + $expens->Debit;
		// 	$data1['Y'] = date('Y',strtotime($expens->DateAdded))." Q".$i++;
		// 	$data1['item1'] = $expens->Credit;
		// 	$data1['item2'] = $expens->Debit;
			
		// }
		// $doun = '{label: "Income", value: '.$income_total.'},';
		// $doun .= '{label: "Expense", value: '.$expens_total.'}';
		// echo $doun;
		// echo json_encode($data1);
		echo $jsondata = str_replace('"','',json_encode($data1));

		// $item1 = $this->data['income']

	}
	

	
}
