<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packagesetting extends CI_Controller {



	public function __construct() {
		parent::__construct();
		if($this->session->userdata('logged_in') && $this->session->userdata('admin_login')) {
		
		// Load database
		
		$this->load->model('admin/Packagesetting_model');
		$this->lang->load('packagesetting');
		$this->lang->load('usersetting');
		
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
						redirect('admin/packagelist');
					}
				}
			} else {
				$this->data['field'] = $this->Packagesetting_model->Getfields();
				$this->load->view('admin/packagelist', $this->data['field']);
			}
	    } else {
	    	redirect('admin/login');
	    	// $this->load->view('admin/login');
	    }
 		
	}


	public function addfield()
	{
		

		if($this->session->userdata('logged_in')) 
		{
			
			if($this->input->post())
			{
				
				
				  $lvlcommissions = implode(",", (array) $this->input->post('levelcommission'));
				  
				  
				  $lvlcommissions1 = implode(",", (array)$this->input->post('levelcommission1'));
				  $prtlvlcommissions = implode("','",(array) $this->input->post('productlevelcommission'));

				 	$lvlchecks = str_replace(",", "", $lvlcommissions);
				 	$lvlchecks1 = str_replace(",", "", $lvlcommissions1);
				 	$prtlvlchecks = str_replace(",", "", $prtlvlcommissions);
				 
				
				$this->form_validation->set_rules('packagename', 'packagename', 'trim|required');
				$this->form_validation->set_rules('packagefee', 'packagefee', 'trim|required|xss_clean');


 				if($this->form_validation->run() == true )
 				{

$scondition = "ProductName='".$this->input->post('product')."'";

$productdetail  =$this->common_model->GetRow($scondition,'arm_product', 'ProductId');


$level_commisions = implode(",",(array) $this->input->post('levelcommission'));
$level_commisions1 = implode(",",(array) $this->input->post('levelcommission1'));
$level_commisions2 = implode(",",(array) $this->input->post('levelcommission2'));


				$data = array(
					'PackageName'=>$this->input->post('packagename'),
					'PackageFee'=>$this->input->post('packagefee'),
					'DirectCommission'=>$this->input->post('directcommission'),
					'LevelCommissions'=>$this->input->post('indirectcommission'),
					'token_reward'=>$this->input->post('token_reward'),
					'token_reward'=>$this->input->post('mining_reward'),
					'ProductLevelCommissions'=>$level_commisions,
					'token_reward_upline'=>$level_commisions1,
					'mining_reward'=>$this->input->post('mining_reward'),
					'mining_reward_upline'=>$level_commisions2
				);

				$result = $this->common_model->SaveRecords($data,'arm_package');
					
					$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
					redirect('admin/packagesetting');
 				}

				else
				{

					$this->session->set_flashdata('error_message',$this->lang->line('errormessage'));
					$this->data['register']= $this->Packagesetting_model->getregister();
					$this->data['productdetail']= $this->Packagesetting_model->Getproductdetail();

					$this->load->view('admin/addpackagefield');
				}

				
			}
			else
			{
				$this->data['register']= $this->Packagesetting_model->getregister();
				$this->data['productdetail']= $this->Packagesetting_model->Getproductdetail();
				$this->load->view('admin/addpackagefield',$this->data);
			} 
		}
		else
		{
			redirect('admin/login');

					
		}


		}//function ends



public function delete($id) 
{
		$condition = "PackageId =" . "'" . $id . "'";
		$status = $this->common_model->DeleteRecord($condition, 'arm_package');
		if($status) {
			redirect('admin/packagesetting');
		}
		
	}


	public function editfield($id)
	{
		
		
		if($this->session->userdata('logged_in')) 
		{
			
			if($this->input->post())
			{
				
				$this->form_validation->set_rules('packagename', 'packagename', 'trim|required');
				$this->form_validation->set_rules('packagefee', 'packagefee', 'trim|required|xss_clean');
		
				if($this->form_validation->run() == true)
 				{	

$scondition = "ProductName='".$this->input->post('product')."'";
$productdetail  =$this->common_model->GetRow($scondition,'arm_product', 'ProductId');




$level_commisions = implode(",",(array) $this->input->post('levelcommission'));
$level_commisions1 = implode(",",(array) $this->input->post('levelcommission1'));
$levelcommission2 = implode(",",(array) $this->input->post('levelcommission2'));




	$data = array(
	'PackageName'=>$this->input->post('packagename'),
	'PackageFee'=>$this->input->post('packagefee'),
	'DirectCommission'=>$this->input->post('directcommission'),
	'LevelCommissions'=>$this->input->post('indirectcommission'),
	'ProductLevelCommissions'=>$level_commisions,
	'token_reward'=>$this->input->post('token_reward'),
	'mining_reward'=>$this->input->post('mining_reward'),
	'token_reward_upline'=>$level_commisions1,
	'mining_reward_upline'=>$levelcommission2
	);

$condition= "packageId='".$id."'";
$result = $this->common_model->UpdateRecord($data,$condition,'arm_package');
$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
redirect('admin/packagesetting');

	}
	else
	{

$this->session->set_flashdata('error_message',$this->lang->line('errormessage'));
$this->data['productdetail']= $this->Packagesetting_model->Getproductdetail();
$this->data['fielddata']= $this->Packagesetting_model->Getfielddata($id);
$this->load->view('admin/editpackagefield',$this->data);

	}

				
				
			}
			else
			{
				
				$this->data['fielddata']= $this->Packagesetting_model->Getfielddata($id);
				$this->data['productdetail']= $this->Packagesetting_model->Getproductdetail();
				$this->load->view('admin/editpackagefield',$this->data);
			}

		} 
		else
		{
			redirect('admin/login');

					
		}


		}


public function enable($PackageId) {
		$condition = "PackageId =" . "'" . $PackageId . "'";

		$data = array(
			'Status' => '1'
		);

		$status = $this->common_model->UpdateRecord($data, $condition, 'arm_package');
		if($status) {
			redirect('admin/packagesetting');
		}
	}

	public function disable($PackageId) {
		$condition = "PackageId =" . "'" . $PackageId . "'";

		$data = array(
			'Status' => '0'
		);

		$status = $this->common_model->UpdateRecord($data, $condition, 'arm_package');
		if($status) {
			redirect('admin/packagesetting');
		}
	}


	public function lvlcommission_check($str,$numbers)
	{
		
		$flag=0;
		
		
			if(!is_numeric($numbers))
			{
				$flag=1;
			}
			

		if ($flag==0) 
			{
			
				return true; 
				}
		else{
			
			$this->form_validation->set_message('lvlcommission_check', '<p><em class="state-error1">The given levelcommission field values are only in numbers</em></p>');
			return false;
		}
		
	}

	
	public function prtlvlcommission_check($str,$productlevelcommission)
	{
		
		$flag=0;
			if(!is_numeric($productlevelcommission))
			{
				$flag=1;
			}

		if ($flag==0) 
			{
				return true; 
				}
		else{
			
			$this->form_validation->set_message('prtlvlcommission_check', '<p><em class="state-error1">The given productlevelcommission field values are  only in numbers</em></p>');
			return false;
		}
		
	}

	} //class ends


