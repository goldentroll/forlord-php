<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

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
		/*} else {
			redirect('user');
		}		*/

			$this->lang->load('common',$this->session->userdata('language'));
	}

	public function index() {

		

 $this->data['faq']= $this->db->query("SELECT * FROM `arm_faq` where `Status` = '1' ")->result();



		$this->load->view('user/viewfaq',$this->data);
        }

	

	

}


?>