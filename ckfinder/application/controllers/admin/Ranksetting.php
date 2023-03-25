<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ranksetting extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->session->userdata('logged_in') && $this->session->userdata('admin_login')) {
		
			// Load database
			
			$this->load->model('admin/Ranksetting_model');
			$this->lang->load('rank');
		
		}  else {
	    	redirect('admin/login');
	    }  
	}

	public function index()
	{

		if($this->session->userdata('logged_in')) {

				$this->data['field'] = $this->Ranksetting_model->Getcareer();
				// print_r($this->data['field']);
				$this->load->view('admin/rank', $this->data['field']);
			
	    } else {
	    	redirect('admin/login');
	    	// $this->load->view('admin/login');
	    }
	}


	public function addfield()
	{
		

		if($this->session->userdata('logged_in')) 
		{
			
	$matrixsett = $this->db->query("select * from arm_matrixsetting where MatrixStatus='1'")->row();

	$id = $matrixsett->Id;

	$target_con = $this->input->post('targetcon');


	if($this->input->post('rank')!="")
	{
	$data = array();

	$data['target_rank'] = $target_con;
	$data['Rank'] = $this->input->post('rank');
	$data['status']  = $this->input->post('status');
	$data['rank_reward']  = $this->input->post('rank_reward');
	$data['min_pack_inves'] = $this->input->post('min_pack_inves');
	$data['current_lev'] = $this->input->post('current_lev');
	$data['elig_earn'] = $this->input->post('elig_earn');
	$data['bonus_amt'] = $this->input->post('bonus_amt');

	$data['bonus_type'] = $this->input->post('bonus_type');
	$data['non_cash'] = $this->input->post('non_cash');

	$levelcommission = $this->input->post('levelcommission');
	$data['level_commissions'] = implode(',',$levelcommission);


	$result = $this->common_model->SaveRecords($data,'arm_ranksetting');

	if($result)
	{
	$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
	redirect('admin/ranksetting');
	}
	else
	{
	$this->session->set_flashdata('error_message',"Error Added the Rank settings");
	redirect('admin/ranksetting');
	}
	}
	else
	{
	$this->load->view('admin/addrank');
	}

			
			
		}
		else
		{
			redirect('admin/login');
		}
 		

	}
	//function ends

	public function delete($id) 
	{
		$condition = "rank_id =" . "'" . $id . "'";
		$status = $this->common_model->DeleteRecord($condition, 'arm_ranksetting');
		if($status) {
			redirect('admin/ranksetting');
		}
		
	}


	public function editfield($id)
	{
		// echo $id;
		
		if($this->session->userdata('logged_in')) 
		{
			
			if($this->input->post())
			{

					$target_con = $this->input->post('targetcon');

					$data = array();

			$data['target_rank'] = $target_con;
			$data['Rank'] = $this->input->post('rank');
			$data['status']  = $this->input->post('status');
			$levelcommission = $this->input->post('levelcommission');
			$data['level_commissions'] = implode(',',$levelcommission);

			$data['min_pack_inves'] = $this->input->post('min_pack_inves');
			$data['current_lev'] = $this->input->post('current_lev');
			$data['elig_earn'] = $this->input->post('elig_earn');
			$data['bonus_amt'] = $this->input->post('bonus_amt');
			$data['rank_reward'] = $this->input->post('rank_reward');
			$data['bonus_type'] = $this->input->post('bonus_type');
			$data['non_cash'] = $this->input->post('non_cash');

			
					
					$condition= "rank_id='".$id."'";
					$result = $this->common_model->UpdateRecord($data,$condition,'arm_ranksetting');

					if($result)
					{
						$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
						redirect('admin/ranksetting');
					}
					else
					{
						$this->session->set_flashdata('error_message',"Error Updated the Rank settings");
						redirect('admin/ranksetting');
					}
									  
 				
				}							
				else
				{
					$this->data['fielddata']= $this->Ranksetting_model->Getcareerdata($id);
					
					$this->load->view('admin/editrank',$this->data);
				}

		} 
		else
		{
			redirect('admin/login');
		}

 		//header("Refresh:5;url=".base_url()."index.php/welcome");

	}


	public function enable($PackageId) {
		$condition = "PackageId =" . "'" . $PackageId . "'";

		$data = array(
			'Status' => '1'
		);

		$status = $this->common_model->UpdateRecord($data, $condition, 'arm_pv');
		if($status) {
			redirect('admin/pvsetting');
		}
	}

	public function disable($PackageId) {
		$condition = "PackageId =" . "'" . $PackageId . "'";

		$data = array(
			'Status' => '0'
		);

		$status = $this->common_model->UpdateRecord($data, $condition, 'arm_pv');
		if($status) {
			redirect('admin/pvsetting');
		}
	}


	public function active($rank_id) {
		$condition = "rank_id =" . "'" . $rank_id . "'";

		$data = array(
			'Status' => '1'
		);

		$status = $this->common_model->UpdateRecord($data, $condition, 'arm_ranksetting');
		if($status) {
			redirect('admin/ranksetting');
		}
	}

	public function inactive($rank_id) {
		$condition = "rank_id =" . "'" . $rank_id . "'";

		$data = array(
			'Status' => '0'
		);

		$status = $this->common_model->UpdateRecord($data, $condition, 'arm_ranksetting');
		if($status) {
			redirect('admin/ranksetting');
		}
	}


	

} //class ends


