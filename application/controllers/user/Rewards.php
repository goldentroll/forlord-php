<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rewards extends CI_Controller {

	public function __construct() {
	parent::__construct();
	$this->load->library('MyEncrypt');
	$myencrypt = new MyEncrypt;
	}

	
	public function index()
	{
		$languageid = ($this->session->userdata('user_langid')) ? $this->session->userdata('user_langid'): '1';
		$faq_condition = "faq_status = '1' AND language_id = '".$languageid."'";

		$id=$this->uri->segment('2');
		//$myencrypt = new MyEncrypt;

			if($id)
			{

			$page_url = $id;
			$userid = $this->session->MemberID;

	$this->data['page_data'] = $this->common_model->GetRewardinfo($page_url,$languageid);
	$this->data['page_url'] = $page_url;
    $video_id=$this->data['page_data']->page_id;

   $video_history = $this->db->query("SELECT * FROM arm_history where MemberId = '".$userid."' and TypeId='20' and video_id ='".$video_id."'  ")->row();
		
		if($video_history)
		{
           $this->data['already_watch'] = "1";
		}
		else
		{
           $this->data['already_watch'] = "0";
		}

			$this->load->view('user/user_reward',$this->data);
			}
			
	}


		public function airdrop_index()
		{

		$languageid = ($this->session->userdata('user_langid')) ? $this->session->userdata('user_langid'): '1';
		$faq_condition = "faq_status = '1' AND language_id = '".$languageid."'";
		$this->data['action'] =  base_url().'user/myico';
		$myencrypt = new MyEncrypt;
		$id=$this->uri->segment(2);
		$payment_id = $myencrypt->decode($id);

		$condition="ico_id = '".$payment_id."'";
		$coins = $this->common_model->GetResults('airdrop_controls',$condition);

		$this->data['lendingdetails'] = $coins;
		$this->load->view('user/user_airdroplist',$this->data);
		}


	public function all_reward()
	{
		$languageid = ($this->session->userdata('user_langid')) ? $this->session->userdata('user_langid'): '1';
      
      $userid = $this->session->MemberID;

	 $this->data['active_video'] = $this->db->query("SELECT * FROM rewards_controls where reward_date <= '".date('Y-m-d')."' and page_status ='1' ")->result();

	 $this->data['active_video_num'] = $this->db->query("SELECT * FROM rewards_controls where reward_date <= '".date('Y-m-d')."' and page_status ='1' ")->num_rows();


		$this->load->view('user/all_airdrop',$this->data);
	}


	public function all_history()
	{
    
      $this->data['all_history'] = $this->db->query("SELECT * FROM history where uusersid='".$this->session->userdata('uusersid')."'")->result();
     $this->load->view('user/all_history',$this->data);

	}

	public function earnings()
	{
		$amount =  $this->input->post('amount');
		$video_id =  $this->input->post('video_id');
		$title =  $this->input->post('video_title');
		$titles = "Videos Reward Added Successfully for watch ".$title;
		$userid = $this->session->MemberID;

		$video_history = $this->db->query("SELECT * FROM arm_history where MemberId = '".$userid."' and TypeId='20' and video_id ='".$video_id."'  ")->row();

		//getting video _reward token		
		$token_video = $this->common_model->GetRow("page_id='".$video_id."' ","rewards_controls");

		$bal=$this->common_model->Getcusomerbalance($this->session->MemberID);
		$trnid = 'REW'.rand(1111111,9999999);
		if(!$video_history)
		{
			$reward_data = array(
			"MemberId" => $this->session->MemberID,
			"Credit"	=>	$this->input->post('amount'),
			"video_id" => $video_id,
			"Balance" => $bal+$this->input->post('amount'),
			"description"=> $titles,
			'TransactionId'=>$trnid,
			"TypeId"		=> '20',
			"Status"   =>  'active',
			"DateAdded"     => date('Y-m-d'),
			);
			$titles1 = "Getting For Video Reward Added Successfully ";
			$trnid1 = 'TOKVID'.rand(1111111,9999999);
			//insert video reward token
			$reward_data1 = array(
			"MemberId" => $this->session->MemberID,
			"Credit"	=>	$token_video->video_reward,
			"video_id" => $video_id,
			"description"=> $titles1,
			'TransactionId'=>$trnid1,
			"TypeId"		=> '51',			
			"DateAdded"     => date('Y-m-d'),
			);

			$user = $this->common_model->GetRow("memberId='".$this->session->MemberID."' AND MemberStatus='Active'","arm_members");


			$insert_data = $this->db->insert('arm_history',$reward_data);
			$insert_data1 = $this->db->insert('arm_history',$reward_data1);
			$insert_id = $this->db->insert_id();

			$datas = array(
			'MemberId'=>$this->session->MemberID,
			'DirectId'=>$user->DirectId,
			'type_id'=>'5',
			'status'=>'1',
			'date'=> date('Y-m-d'),
			'history_id'=>$insert_id
			);

			$arm_notification = $this->common_model->SaveRecords($datas,'arm_notification');



		}
		if($insert_data)
		{
			echo "success";
		}
		else
		{
			echo "already_watch";
		}
	}



	public function edit()
	{
		  $this->load->library('form_validation');
    	$myencrypt = new MyEncrypt;

		if($this->input->post())
		{


		$id=$this->input->post('icoid');
		$payment_id = $myencrypt->decode($id);

        $get_ids = $this->input->post('iocids');
		$ids = $myencrypt->encode($get_ids);

		$this->form_validation->set_rules('event_name','Please Enter Event Name', 'required');

		$this->form_validation->set_rules('even_reward','Please Enter Event Reward Name', 'required');

		if ($this->form_validation->run() == TRUE) {

		$userdata = array(
		"event_name"    =>$this->input->post('event_name'),
		"even_reward"   =>$this->input->post('even_reward'),
		"event_link"    =>$this->input->post('event_link'),
		"event_about"	=>$this->input->post('event_about'),
		"start_date"    => date('Y-m-d',strtotime($this->input->post('start_date'))),
		"end_date"	    => date('Y-m-d',strtotime($this->input->post('end_date'))),
		"uusersid"	    => $this->session->userdata('uusersid')
		);

        $this->db->where('id',$payment_id);
		$query_status = $this->db->update('airdrop_controls',$userdata);
		$this->session->set_flashdata('success_message', "Airdrop  Added successfully");
		redirect('user_airdrop/'.$ids);
		}
		}
		else
		{
			$id=$this->uri->segment(3);
			$payment_id = $myencrypt->decode($id);
			$condition="id = ".$payment_id;
		 	$coins = $this->common_model->GetResults('airdrop_controls',$condition);
		    $this->data['event'] = $coins;
			$this->load->view('user/edit_airdrop',$this->data);
		}
		
	}

	public function delete()
	{
         $myencrypt = new MyEncrypt;
		$id=$this->uri->segment(3);
		$payment_id = $myencrypt->decode($id);
		$condition="id = ".$payment_id;
		$this->db->where('id',$payment_id);
		$query_status = $this->db->delete('airdrop_controls');
		$this->session->set_flashdata('success_message', "Airdrop  Deleted successfully");
		redirect('myico/');

	}



	public function add()
	{
         $this->load->library('form_validation');
		if($this->input->post())
		{

		$myencrypt = new MyEncrypt;
		$id=$this->input->post('icoid');
		$payment_id = $myencrypt->decode($id);

		$this->form_validation->set_rules('event_name','Please Enter Event Name', 'required');

		$this->form_validation->set_rules('even_reward','Please Enter Event Reward Name', 'required');

		if ($this->form_validation->run() == TRUE) {

		$userdata = array(

		"ico_id"		=>$payment_id,
		"event_name"    =>$this->input->post('event_name'),
		"even_reward"   =>$this->input->post('even_reward'),
		"event_link"    =>$this->input->post('event_link'),
		"event_about"	=>$this->input->post('event_about'),
		"start_date"    => date('Y-m-d',strtotime($this->input->post('start_date'))),
		"end_date"	    => date('Y-m-d',strtotime($this->input->post('end_date'))),
		"uusersid"	    => $this->session->userdata('uusersid')

		);

		$query_status = $this->db->insert('airdrop_controls',$userdata);
		$this->session->set_flashdata('success_message', "Airdrop  Added successfully");
		redirect('user_airdrop/'.$id);
		}
		}
       

		$this->load->view('user/add_airdrop');
	}
       

	public function all_airdrop()
	{

		$languageid = ($this->session->userdata('user_langid')) ? $this->session->userdata('user_langid'): '1';
        $userid = $this->session->userdata('uusersid');

	    $condition="start_date <='".date('Y-m-d 00:00:00')."'  and  end_date >='".date('Y-m-d 00:00:00')."' ";
		$coins = $this->common_model->GetResults('airdrop_controls',$condition);
		$this->data['active_airdrop'] = $coins;


        $condition="start_date >'".date('Y-m-d 00:00:00')."'";
		$coins = $this->common_model->GetResults('airdrop_controls',$condition);
		$this->data['upcoming_airdrop'] = $coins;


	    $condition="end_date < '".date('Y-m-d')."'";
		$coins = $this->common_model->GetResults('airdrop_controls',$condition);
		$this->data['ended_airdrop'] = $coins;

		$this->load->view('user/all_airdrop_list',$this->data);
	}

}

