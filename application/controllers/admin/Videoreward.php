<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videoreward extends CI_Controller {

	/**
	 * 
	 * Start 
	 * Create Date: 29 Jun, 2016
	 * This controller to manage CMS page.
	 * Created karthiga.
	 * @see http://ihyip.com/admin/sitesettings/
	 * Last Updated: 1 Jun, 2016
	 * End
	 * 
	 */


	public function __construct() {
	parent::__construct();
	if($this->session->userdata('logged_in') && $this->session->userdata('admin_login')) {

	// Load database

	$this->load->model('admin/Marketingtool_model');
	$this->lang->load('marketingtool');

	// custom encryption
	$this->load->library('MyEncrypt');
	$myencrypt = new MyEncrypt;

	}  else {
	redirect('admin/login');
	}

	} //function ends


	public function index()
	{


	if($this->session->userdata('logged_in')) {
	if($this->input->post('inputname')) {
	if($this->input->post('active'))
	{
	print_r($this->input->post());
	exit;
	} else {
	foreach ($this->input->post('inputname') as $customer_id) {
	print_r($this->input->post());
	//$status = $this->Packagesetting_model->DeletePackage($package_id);
	}

	if($status) {
	redirect('admin/marketinglist');
	}
	}
	} else {
	 $this->data['field'] = $this->common_model->GetRewards();
	$this->load->view('admin/video_rewards', $this->data);
	}
	} else {
	redirect('admin/login');
	}


	}


	public function edit($id=''){

    $id = $this->uri->segment(4);

    if($id)
    {
		$page_url = $id;
		$this->data['page_data'] = $this->common_model->GetRewardspage($page_url);
		$this->data['page_url'] = $page_url;
    }

		$this->data['module_name'] = 'settings';
		$this->data['action'] =  base_url().'admin/Videoreward/edit';

		if($this->input->post()) {
			
	// $post_data = $this->input->post();
	$this->form_validation->set_rules('reward_title','reward_title', 'trim|required');
		//$this->form_validation->set_rules('video_reward','video_reward', 'trim|required');
	$this->form_validation->set_rules('reward_content','reward_content', 'trim|required|min_length[10]');

     $page_url = $this->input->post('page_url');
			// check form validate
			if ($this->form_validation->run() == TRUE) {



if($page_url !="")
{

	$page_title = $this->input->post('page_title');
			

					$lang_id = 1;
					$myencrypt = new MyEncrypt;

				    $page_url = $this->input->post('page_url');
						
					$pagedata = array(
						"page_title"	=>	($this->input->post('reward_title')),
						"page_content"	=>	$this->input->post('reward_content'),
						"reward_url"	=>	$this->input->post('reward_url'),
						"reward_date"	=>	$this->input->post('reward_date'),
						"reward_time"	=>	$this->input->post('reward_time'),
						"reward_amount"	=>	$this->input->post('reward_amount'),
						"video_reward"	=>	$this->input->post('video_reward')
					);
					
					$this->db->where('page_id',$page_url);
					$query_status = $this->db->update('rewards_controls',$pagedata);

}
else
{

					$pagedata = array(
					"page_title"	=>	$this->input->post('reward_title'),
					"page_content"	=>	$this->input->post('reward_content'),
					"reward_url"	=>	$this->input->post('reward_url'),
					"reward_date"	=>	$this->input->post('reward_date'),
					"reward_time"	=>	$this->input->post('reward_time'),
					"reward_amount"	=>	$this->input->post('reward_amount'),
					"page_status"        => '0',
					"video_reward"	=>	$this->input->post('video_reward')
					);
					
				$query_status = $this->db->insert('rewards_controls',$pagedata);
}
				

				if($query_status) {
					$this->session->set_flashdata('success_message', 'Rewad Content Update Successfully..');
					redirect('admin/Videoreward');
				} else {
					$this->session->set_flashdata('error_message', 'Rewad Content Update Faild..');
					redirect('admin/Videoreward');
				}
				
			} else {

                    $this->session->set_flashdata('error_message', 'Please Check Errors');
					redirect('admin/Videoreward');
			}
			
		}
		else
		{
		   $this->load->view('admin/editrewadspage',$this->data);	
		}


	}



	public function settings() {
        

if($this->input->post())
{
   
      $allowed_package = $this->input->post('earners');
      $array_pacage = implode($allowed_package,',');
      $allow_rewards = $this->input->post('total_earnings');

	$pagedata = array(
	"total_earnings"	=>	$this->input->post('total_earnings'),
	"display_pacakge"	=>	$array_pacage,
	);

	$this->db->where('id','1');
	$query_status = $this->db->update('reward_controls_main',$pagedata);

	if($query_status) {
	$this->session->set_flashdata('success_message', 'Reward Controls Update Successfully..');
	redirect('admin/Videoreward/settings');
	} else {
	$this->session->set_flashdata('error_message', 'Reward Controls Update Faild..');
	redirect('admin/Videoreward/settings');
	}

}
else
{
	$this->data['field'] = $this->db->query('SELECT * FROM reward_controls_main')->row();
    
	$this->data['page_data'] = $this->db->query("SELECT * FROM arm_package where status='1'")->result();

	$this->data['array_data'] = explode(",", $this->data['field']->display_pacakge);
     $array = array_values($this->data['array_data']);


    $newArray = array();

    foreach($array as $key => $value) {
       $newArray .= $value;
    }


	$this->load->view('admin/reward_controls', $this->data);
}

	
	}


	public function delete($id) {

		$page_url = $id;
		if($page_url)
		{
			$this->db->where('page_id',$page_url);
			$delete_status = $this->db->delete('rewards_controls');
			if($delete_status) {
				$this->session->set_flashdata('success_message','Delete Rewards Successfully');
				redirect('admin/Videoreward');
			} else {
				$this->session->set_flashdata('error_message', 'Delete Rewards Faild');
				redirect('admin/Videoreward');
			}
		}
		

    }


	public function enable($MarketingId) {

	$condition1 = "page_id =" . "'" . $MarketingId . "'";

	$data1 = array(
	'page_status' => '1'
	);

	$status = $this->common_model->UpdateRecord($data1, $condition1, 'rewards_controls');

	if($status) {
	redirect('admin/Videoreward');
	}
	}

	public function disable($MarketingId) {

	$condition = "page_id =" . "'" . $MarketingId . "'";

	$data = array(
	'page_status' => '0'
	);

	$status = $this->common_model->UpdateRecord($data, $condition, 'rewards_controls');
	if($status) {
	redirect('admin/Videoreward');
	}
	}


	public function viewcontents($id) {

		$myencrypt = new MyEncrypt;
		$page_title = $myencrypt->decode($id);
		
		$page_data = $this->common_model->GetRewardspage($page_title);
		
		foreach ($page_data as $row) {
			echo "<h5>".ucfirst($row->language_name)."</h5>";
			echo "<div class='col-lg-12 bg-primary'><h5>".$this->lang->line('cms_page_titlename').': '.$row->page_title."</h5></div>";
			echo "<br/>".$row->page_content;
			echo "<br/>";
		}

	}

	

}

