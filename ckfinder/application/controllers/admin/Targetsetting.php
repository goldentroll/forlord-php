<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Targetsetting extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//$this->load->helper('url');

		// Load form helper library
		//$this->load->helper('form');
		
		// Load database
		
		$this->load->model('admin/sales_model');
		$this->load->model('common_model');

		
		
		// change language
		//$this->config->set_item('language', 'spanish');

		// load language
		$this->lang->load('sales');


	}

	public function index()
	{
 		if($this->session->userdata('logged_in') && $this->session->userdata('admin_login')) 
 		{



 			if($this->input->post())
 			{

 				$this->form_validation->set_rules('earning_mode', 'Earning mode', 'trim|required');
 				$this->form_validation->set_rules('duration', 'Duration', 'trim|required|is_numeric');
 				$this->form_validation->set_rules('target_amount', 'Target amount', 'trim|required|is_numeric');
 				$this->form_validation->set_rules('target_bonus', 'Target bonus', 'trim|required|is_numeric');
 				
 			if ($this->form_validation->run() == TRUE) {

 					
 					$data=array(
 						'earning_mode'=>$this->input->post('earning_mode'),
 						'duration'=>$this->input->post('duration'),
 						'target_amount'=>$this->input->post('target_amount'),
 						'target_bonus'=>$this->input->post('target_bonus')
 					);
                    

                    //print_r($data);
                    //exit();
                    $condition="id='1'";
 					$result = $this->common_model->UpdateRecord($data,$condition,'arm_target_setting');
 					if($result){
					
					$this->session->set_flashdata('success_message',$this->lang->line('success_message'));
					redirect('admin/Targetsetting');
				}else
				{
					$this->session->set_flashdata('error_message',$this->lang->line('error_message'));
					redirect('admin/Targetsetting');

				}

 				}
 			}
 			$condition="id='1'";
 			$this->data['fielddata']=$this->common_model->GetResults($condition,'arm_target_setting','*');
			
			$this->load->view('admin/target_list',$this->data);
	    }
	     else {
	    	redirect('admin/login');

	    }	
	}


	public function edit_rank($id='')
	{

		if($this->input->post())
		{


			$this->form_validation->set_rules('earning_mode', 'Earning mode', 'trim|required');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required|is_numeric');
			$this->form_validation->set_rules('target_amount', 'Target amount', 'trim|required|is_numeric');
			$this->form_validation->set_rules('target_bonus', 'Target bonus', 'trim|required|is_numeric');

			if ($this->form_validation->run() == TRUE) {


         if($this->input->post('target_id'))
         {

         	$target_id=$this->input->post('target_id');

			$data=array(
			'earning_mode'=>$this->input->post('earning_mode'),
			'duration'=>$this->input->post('duration'),
			'target_amount'=>$this->input->post('target_amount'),
			'target_rewards'=>$this->input->post('target_rewards'),
			'target_bonus'=>$this->input->post('target_bonus')
			);


			$condition="id='".$target_id."'";
			$result = $this->common_model->UpdateRecord($data,$condition,'arm_target_setting');

}
else
{

			$data=array(
			'earning_mode'=>$this->input->post('earning_mode'),
			'duration'=>$this->input->post('duration'),
			'target_amount'=>$this->input->post('target_amount'),
			'target_bonus'=>$this->input->post('target_bonus'),
			'target_rewards'=>$this->input->post('target_rewards'),
			);

           $result = $this->common_model->SaveRecords($data,'arm_target_setting');

}
			if($result){

			$this->session->set_flashdata('success_message',"Target Settings Updated Successfully");
			redirect('admin/Targetsetting');
			}else
			{
			$this->session->set_flashdata('error_message',"Target Settings Updated Faild!!");
			redirect('admin/Targetsetting');

			}



		}
		}
		else
		{

		$id=$this->uri->segment(4);

		if($id)
		{
			
		$condition="id='".$id."'";
		$this->data['row']=$this->db->query("SELECT * FROM arm_target_setting WHERE id='".$id."' ")->row();
		}
		else
		{
		$this->data['row'] = "";
		}


		$this->load->view('admin/target_setting',$this->data);
		}



	}


	
	public function delete($couponId) {
		$condition = "id =" . "'" . $couponId . "'";
		$status = $this->common_model->DeleteRecord($condition, 'arm_target_setting');

		if($status) {
			$this->session->set_flashdata('success_message', 'Success! Target List Removed');
			redirect('admin/Targetsetting');
		} else {
			$this->session->set_flashdata('error_message', 'Failed! Target List Not Removed');
			redirect('admin/Targetsetting');
		}
		
	}

	public function active($couponId) {
		$condition = "id =" . "'" . $couponId . "'";

		$data = array(
			'status' => '1'
		);

		$status = $this->common_model->UpdateRecord($data, $condition, 'arm_target_setting');
		if($status) {
			redirect('admin/Targetsetting');
		}
	}

	public function inactive($couponId) {
		$condition = "id =" . "'" . $couponId . "'";

		$data = array(
			'status' => '0'
		);

		$status = $this->common_model->UpdateRecord($data, $condition, 'arm_target_setting');
		if($status) {
			redirect('admin/Targetsetting');
		}
	}

	
	
	


}
