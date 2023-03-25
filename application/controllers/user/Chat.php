<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function __construct() {

		parent::__construct();

		// if($this->session->userdata('logged_in') && $this->session->userdata('user_login')) {
		
			// Load database

			$this->load->model('common_model');
			$this->load->model('page_model');

			// load language
			
			$this->lang->load('cms');
			$this->load->library('pagination');

			// load language

			$this->lang->load('user/faq',$this->session->userdata('language'));
			$this->lang->load('user/common',$this->session->userdata('language'));

			/*} 
			else {
			redirect('user');
			}*/

			$this->lang->load('common',$this->session->userdata('language'));
	}

	public function index() {


			$this->data['recever_id']=$this->uri->segment(2);
			$this->data['sender_id']=$this->session->userdata('MemberID');

			$sender_id = $this->session->userdata('MemberID');
			$recever_id = $this->uri->segment(2);

			if($sender_id!="" && $recever_id!="")
{

			$this->data['get_chat_details'] = $this->db->query("SELECT * FROM `chat` where (sender_id = '".$sender_id."' and recever_id='".$recever_id."') OR (sender_id = '".$recever_id."' and recever_id='".$sender_id."')")->result();


			$this->data['get_chat_detailss'] =$this->db->query("SELECT * FROM `chat` where (sender_id = '".$sender_id."' and recever_id='".$recever_id."') OR (sender_id = '".$recever_id."' and recever_id='".$sender_id."')")->result();
			

}
			$this->load->view('user/view_chat',$this->data);

        }


	public function message_insert()
	{
		$sender_id = $this->input->post('sender_id');
		$recever_id = $this->input->post('recever_id');
		$message = $this->input->post('send_messages');

		$data1 = array(
		'sender_id'=>$sender_id,
		'recever_id'=>$recever_id,
		'messages'=>strip_tags($message),
		'status' =>1
		);

		if($message!="")
		{
		$result1 = $this->common_model->SaveRecords($data1,'chat');
		}

	}


    public function get_count()
    {


		$this->data['recever_id']=$this->input->post('recever_id');
		$this->data['sender_id']=$this->session->userdata('MemberID');


		$sender_id = $this->input->post('sender_id');
		$recever_id = $this->input->post('recever_id');

		if($sender_id!="" && $recever_id!="")
		{

		$this->data['get_chat_detailss'] = $this->db->query("SELECT * FROM `chat` where (sender_id = '".$sender_id."' and recever_id='".$recever_id."') OR (sender_id = '".$recever_id."' and recever_id='".$sender_id."')")->result();


		$check_view = $this->db->query("select * from chat where recever_id ='".$sender_id."' and sender_id='".$recever_id."' and status='1' ")->row();

		$this->data['get_count'] = $this->db->query("SELECT * FROM `chat` where status=1 AND (sender_id = '".$sender_id."' and recever_id='".$recever_id."') OR (sender_id = '".$recever_id."' and recever_id='".$sender_id."')  AND status=1")->num_rows();

		$this->session->set_userdata('messgae_count',$this->data['get_count']);


		 $this->data['check_view'] = $this->db->query("select * from chat where recever_id ='".$this->session->MemberID."' and status='1'  GROUP BY sender_id ORDER BY `id`  DESC")->num_rows();

		  echo $this->data['check_view'];
      }

    }


    public function get_count_1()
    {
		$sender_id = $this->input->post('sender_id');
		$recever_id = $this->input->post('recever_id');

		if($sender_id!="" && $recever_id!="")
		{

		$this->data['get_chat_detailss'] = $this->db->query("SELECT * FROM `chat` where (sender_id = '".$sender_id."' and recever_id='".$recever_id."') OR (sender_id = '".$recever_id."' and recever_id='".$sender_id."')")->result();


		$this->data['get_count'] = $this->db->query("SELECT * FROM `chat` where status=1 AND  (sender_id = '".$recever_id."' and recever_id='".$sender_id."')  AND status=1")->num_rows();

		print_r($this->data['get_count'] );
        
        }

    }


		public function message_off()
		{

			$this->data['recever_id']=$this->input->post('recever_id');
			$this->data['sender_id']=$this->session->userdata('MemberID');

			$sender_id = $this->input->post('sender_id');
			$recever_id = $this->input->post('recever_id');

if($sender_id!="" && $recever_id!="")
{

			$check_view = $this->db->query("select * from chat where recever_id ='".$sender_id."' and sender_id='".$recever_id."' and status='1' ")->row();

			if($check_view->sender_id==$recever_id)
			{
			$data1 = array(
			'status' =>0,
			);
			$memup=$this->common_model->UpdateRecord($data1,"sender_id='".$recever_id."'","chat");

			echo $this->db->last_query();
			}
}

		}


		public function view_message()
		{

		$this->data['recever_id']=$this->input->post('recever_id');
		$this->data['sender_id']=$this->session->userdata('MemberID');


		$sender_id = $this->input->post('sender_id');
		$recever_id = $this->input->post('recever_id');

if($sender_id!="" && $recever_id!="")
{

		$this->data['get_chat_detailss'] = $this->db->query("SELECT * FROM `chat` where (sender_id = '".$sender_id."' and recever_id='".$recever_id."') OR (sender_id = '".$recever_id."' and recever_id='".$sender_id."')")->result();

		// $check_view = $this->db->query("select * from chat where recever_id ='".$sender_id."' and sender_id='".$recever_id."' and status='1' ")->row();

		// if($check_view->sender_id==$recever_id)
		// {
		// $data1 = array(
		// 'status' =>0,
		// );
		// $memup=$this->common_model->UpdateRecord($data1,"sender_id='".$recever_id."'","chat");
		// }

	$this->data['get_count'] = $this->db->query("SELECT * FROM `chat` where (sender_id = '".$sender_id."' and recever_id='".$recever_id."') OR (sender_id = '".$recever_id."' and recever_id='".$sender_id."')")->num_rows();

	$this->session->set_userdata('messgae_count',$this->data['get_count']);

		$this->load->view('user/inside_chat',$this->data);

	}

}

}





?>