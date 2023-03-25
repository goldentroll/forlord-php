<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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

		
		$this->load->model('admin/testimonial_model');
		$this->load->model('product_model');
		$this->load->model('page_model');
		$this->load->model('common_model');
	    $this->load->model('admin/Generalsetting_model');
		
		// Load database
		
		// change language
		

		// load language
		

		$this->lang->load('common',$this->session->userdata('language'));
		$this->lang->load('user/common',$this->session->userdata('language'));



	}

	public function index()
	{
		
		// print_r($this->session->userdata('language'));
		// exit();

		$siteset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitestatus'", "arm_setting");
		if($siteset->ContentValue=="Off")
		{
			redirect("offsite");
		}

		//set referral details
		if($this->input->get('ref'))
		{
			$membercheckdet = $this->common_model->GetRow("ReferralName='".$this->input->get('ref')."'","arm_members");
			if($membercheckdet)
			{
				$this->session->unset_userdata('referral_name');
				$this->session->unset_userdata('referral_id');
				$this->session->set_userdata("referral_name",$this->input->get('ref'));
				$this->session->set_userdata("referral_id",$membercheckdet->MemberId);
			}	
		}	

		$this->lang->load('user/common');
		$this->load->model('admin/testimonial_model');
		$this->load->model('product_model');
		$this->load->model('page_model');
		$this->load->model('common_model');


		$pageID = 'membershipwithbenefits';
		$contents = '';
		

		// print_r($this->session->userdata('language'));
		// exit();


		if($this->session->userdata('language')){

        	$contents = $this->page_model->GetpageContent($pageID,$this->session->userdata('language'));
        	
		} else {

			
			if($contents==''){
	        	$contents = $this->page_model->GetpageContent($pageID,$this->config->item('language'));
	    	}

    	}

    	$page1ID = 'aboutcompany';
		$content1 = '';
		
		if($this->session->userdata('language')){

			

        	$content1 = $this->page_model->GetpageContent($page1ID,$this->session->userdata('language'));
        	// echo $this->db->last_query();
        	// exit();

		} else {
		

			if($content1==''){
	        	$content1 = $this->page_model->GetpageContent($page1ID,$this->config->item('language'));
	    	}

    	}
    	

    	$belowaboutcomp_page = 'membershipwithbenefits';
		$belowaboutcomp_pagecontent = '';
		
		if($this->session->userdata('language')){

        	$belowaboutcomp_pagecontent = $this->page_model->GetpageContent($belowaboutcomp_page,$this->session->userdata('language'));

		} else {

			if($belowaboutcomp_pagecontent==''){
	        	$belowaboutcomp_pagecontent = $this->page_model->GetpageContent($belowaboutcomp_page,$this->config->item('language'));
	    	}

    	}


 $this->data['faq']= $this->db->query("SELECT * FROM `arm_faq` where `Status` = '1'")->result();



// index content
  $userindex=$this->db->query("select * from arm_cms_page where navTitle='UserIndex'")->row();
  $userindex_content=urldecode($userindex->pageContentHTML);

//how its work
  $userhowitswork=$this->db->query("select * from arm_cms_page where navTitle='HowitsWork'")->row();
  $howitswork_content=urldecode($userhowitswork->pageContentHTML);
  $howitswork_title =urldecode($userhowitswork->pageTitle); 
  

//about us
  $userAboutus=$this->db->query("select * from arm_cms_page where navTitle='AboutUs'")->row();
  $aboutus_content=urldecode($userAboutus->pageContentHTML);

//FaqContent
  $userfaq=$this->db->query("select * from arm_cms_page where navTitle='FaqContent'")->row();
  $faq_content=urldecode($userfaq->pageContentHTML);


//footer content
$userfooter=$this->db->query("select * from arm_cms_page where navTitle='footerContent'")->row();
$footer_content=urldecode($userfooter->pageContentHTML);

//social media
$socialmedia=$this->db->query("select * from arm_cms_page where navTitle='socialMedia'")->row();
$socialmedia_content=urldecode($socialmedia->pageContentHTML);


//topbar
$userTopbar=$this->db->query("select * from arm_cms_page where navTitle='TopBar'")->row();
$topbar_content=urldecode($userTopbar->pageContentHTML);

//indexReferal
$indexReferal=$this->db->query("select * from arm_cms_page where navTitle='indexReferal'")->row();
$indexReferal_content=urldecode($indexReferal->pageContentHTML);

		
		$this->data['testimonial'] = $this->testimonial_model->GetTestimonialall();
		$this->data['latest_product'] = $this->product_model->GetLatestProduct();
		$this->data['contents'] = $contents;
		$this->data['content1'] = $content1;
		$this->data['index_content'] = $userindex_content;
		$this->data['howits_content'] = $howitswork_content;
		$this->data['howitswork_title'] = $howitswork_title; 
		$this->data['userAboutus'] = $aboutus_content;
		$this->data['faq_content'] = $faq_content;
		$this->data['userfooter'] = $footer_content; 
		$this->data['socialmedia'] = $socialmedia_content;
		$this->data['topbar_content'] = $topbar_content;
		$this->data['indexReferal_content'] = $indexReferal_content;
		$this->data['belowaboutcomp_pagecontent'] = $belowaboutcomp_pagecontent;


$this->data['last_deposit'] = $this->db->query("SELECT * FROM `arm_history` WHERE TypeId='19' ORDER BY HistoryId DESC LIMIT 0,3")->result();
$this->data['last_withdraw'] = $this->db->query("SELECT * FROM `arm_history` WHERE TypeId='7' ORDER BY HistoryId DESC LIMIT 0,3")->result();

	
$query = $this->db->query("SELECT MemberId, sum(Credit) as earns FROM arm_history WHERE TypeId IN(4,5,21) GROUP BY MemberId ORDER BY MemberId DESC LIMIT 0, 10", FALSE);
$this->data['earners'] = $query->result();

$query = $this->db->query("SELECT MemberId, sum(Debit) as earns FROM arm_history WHERE TypeId IN(21) GROUP BY MemberId ORDER BY MemberId DESC LIMIT 0, 5", FALSE);
// $query = $this->db->get('arm_order');
$this->data['purchased'] = $query->result();

		$this->load->view('user/user',$this->data);

	}
	public function signup() {

		$this->load->model('common_model');
		

		if($this->input->post()) {
			$from_error = array();
			if($this->input->post('firstname')=='' || strlen($this->input->post('firstname')) < 3)
				$from_error['firstname'] = 'First name is required and more then 3 characters';
				
			if($this->input->post('lastname')=='' || strlen($this->input->post('lastname')) < 0)
				$from_error['lastname'] = 'Last name is required';
				
			if($this->input->post('email')=='' || strlen($this->input->post('email')) < 0)
				$from_error['email'] = 'Email is required';
			else if(!valid_email($this->input->post('email')))
				$from_error['email'] = 'This is invalid email!';
				

			if($this->input->post('phone')=='' || strlen($this->input->post('phone')) < 10)
				$from_error['phone'] = 'Phone number is required and minimum 10 digit.';
				


			$this->form_validation->set_rules('firstname', 'firstname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lastname', 'lastname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Email', 'email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Phone', 'phone', 'trim|required|xss_clean|min_length[10]|max_length[13]');
			
			if ($this->form_validation->run() == FALSE) 
			{

				$condition = "ReferralName =" . "'" . $this->input->post('ReferralName') . "' AND MemberStatus ='Active'";
				$Member = $this->common_model->GetRow($condition, 'arm_members');
				if($Member) {
					$RefId = $Member->MemberId;
				} else {
					$RefId = '1';
				}

				$data = array(
					'RefId' =>	$RefId,
					'FirstName' => $this->input->post('firstname'),
					'LastName' => $this->input->post('lastname'),
					'Email' => $this->input->post('email'),
					'Phone' => $this->input->post('phone'),
					'Status' => '0',
					'StartDate' => date('Y-m-d H:i:s'),
					'Ip' => $this->input->ip_address()
					
				);
				
				$status = $this->common_model->SaveRecords($data, 'arm_lead_member');

				if($status){
					$this->session->set_flashdata('success_message', 'Success! User details Updated');
					redirect('user/Lead');

				} 
			} else {
				redirect($this->input->post('url'));
			}
		}
	}


	public function test()
	{
	  //echo "hai";

	  $pageID = 'membershipwithbenefits';
		$contents = '';
		
		if($this->session->userdata('language')){

        	$contents = $this->page_model->GetpageContent($pageID,$this->session->userdata('language'));

		} else {

			if($contents==''){
	        	$contents = $this->page_model->GetpageContent($pageID,$this->config->item('language'));
	    	}

    	}

    	$page1ID = 'aboutcompany';
		$content1 = '';
		
		if($this->session->userdata('language')){

        	$content1 = $this->page_model->GetpageContent($page1ID,$this->session->userdata('language'));

		} else {

			if($content1==''){
	        	$content1 = $this->page_model->GetpageContent($page1ID,$this->config->item('language'));
	    	}

    	}

    	$belowaboutcomp_page = 'belowaboutcompany';
		$belowaboutcomp_pagecontent = '';
		
		if($this->session->userdata('language')){

        	$belowaboutcomp_pagecontent = $this->page_model->GetpageContent($belowaboutcomp_page,$this->session->userdata('language'));

		} else {

			if($belowaboutcomp_pagecontent==''){
	        	$belowaboutcomp_pagecontent = $this->page_model->GetpageContent($belowaboutcomp_page,$this->config->item('language'));
	    	}

    	}
	
		$this->data['latest_product'] = $this->product_model->GetLatestProduct();
		$this->data['testimonial'] = $this->testimonial_model->GetTestimonialall();
		$this->data['contents'] = $contents;
		$this->data['content1'] = $content1;
		$this->data['belowaboutcomp_pagecontent'] = $belowaboutcomp_pagecontent;

		//set referral details
		if($this->input->get('ref'))
		{
			$membercheckdet = $this->common_model->GetRow("ReferralName='".$this->input->get('ref')."'","arm_members");
			if($membercheckdet)
			{
				$this->session->unset_userdata('referral_name');
				$this->session->unset_userdata('referral_id');
				$this->session->set_userdata("referral_name",$this->input->get('ref'));
				$this->session->set_userdata("referral_id",$membercheckdet->MemberId);
			}	
		}	

		$this->load->view('user/user', $this->data);
		// echo "hai";
	}

	public function dummy()
	{
	   $this->load->view('user/dummy');
	}

	public function ipn()
	{
		$this->load->view('ipn');
	}

}
