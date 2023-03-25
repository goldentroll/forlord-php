<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitesetting extends CI_Controller {


	public function __construct() {
		parent::__construct();
		if($this->session->userdata('logged_in') && $this->session->userdata('admin_login')) {
		
		// Load database
		$this->load->model('admin/Generalsetting_model');
		$this->lang->load('generalsetting');
		
		}  else {
	    	redirect('admin/login');
	    }

	} //function ends

	public function index()
	{
			
				$this->data['sitename']= $this->Generalsetting_model->Getsite('sitename');
				$this->data['siteurl']= $this->Generalsetting_model->Getsite('siteurl');
				$this->data['adminmailid']= $this->Generalsetting_model->Getsite('adminmailid');
				$this->data['sitemetatitle']= $this->Generalsetting_model->Getsite('sitemetatitle');
				$this->data['sitemetakeyword']= $this->Generalsetting_model->Getsite('sitemetakeyword');
				$this->data['sitemetadescription']= $this->Generalsetting_model->Getsite('sitemetadescription');
				$this->data['admin_fee']= $this->Generalsetting_model->Getsite('admin_fee');
				
				$this->data['sitestatus']= $this->Generalsetting_model->Getsite('sitestatus');
				$this->data['sitegooglecode']= $this->Generalsetting_model->Getsite('sitegooglecode');
				$this->data['sitelogo']= $this->Generalsetting_model->Getsite('sitelogo');
				$this->data['sitefav']= $this->Generalsetting_model->Getsite('sitefav');
				$this->data['sitelogin']= $this->Generalsetting_model->Getsite('sitelogin');
				$this->data['allowpicture']= $this->Generalsetting_model->Getsite('allowpicture');
				$this->data['emailapproval']= $this->Generalsetting_model->Getsite('emailapproval');
				$this->data['mobileapproval']= $this->Generalsetting_model->Getsite('mobileapproval');
				$this->data['usecaptcha']= $this->Generalsetting_model->Getsite('usecaptcha');
				$this->data['google_verify']= $this->Generalsetting_model->Getsite('google_verify');

				$this->data['allowregistration']= $this->Generalsetting_model->Getsite('allowregistration');
				$this->data['allowlogin']= $this->Generalsetting_model->Getsite('allowlogin');
				$this->data['uniqueip']= $this->Generalsetting_model->Getsite('uniqueip');
				$this->data['uniquemobile']= $this->Generalsetting_model->Getsite('uniquemobile');
				$this->data['uniqueemail']= $this->Generalsetting_model->Getsite('uniqueemail');
				$this->data['allowusers']= $this->Generalsetting_model->Getsite('allowusers');
				$this->data['another_login']= $this->Generalsetting_model->Getsite('another_login');
				$this->data['defaultsponsors']= $this->Generalsetting_model->Getsite('defaultsponsors');
				$this->data['sponsorslist']= $this->Generalsetting_model->Getsponsormember();
				$this->data['footercontent']= $this->Generalsetting_model->Getsite('footercontent');
				$this->data['google_client_id']= $this->Generalsetting_model->Getsite('google_client_id');
				$this->data['google_client_secret']= $this->Generalsetting_model->Getsite('google_client_secret');
				$this->data['fb_client_id']= $this->Generalsetting_model->Getsite('fb_client_id');
				$this->data['fb_client_secret']= $this->Generalsetting_model->Getsite('fb_client_secret');
				$this->data['address']= $this->Generalsetting_model->Getsite('address');
				$this->data['referrallink']= $this->Generalsetting_model->Getsite('referrallink');
				$this->data['multivendor']= $this->Generalsetting_model->Getsite('multivendor');
				$this->data['kyc']= $this->Generalsetting_model->Getsite('kyc');
				$this->data['themecolor']= $this->Generalsetting_model->Getsite('themecolor');
				$this->data['width']= $this->Generalsetting_model->Getsite('width');
				$this->data['height']= $this->Generalsetting_model->Getsite('height');
				$this->data['contactustitle']= $this->Generalsetting_model->Getsite('contactustitle');
				$this->data['contactuscontent']= $this->Generalsetting_model->Getsite('contactuscontent');
				$this->data['contactusnote']= $this->Generalsetting_model->Getsite('contactusnote');
				$this->data['noreferral']= $this->Generalsetting_model->Getsite('noreferral');
				$this->data['onereferral']= $this->Generalsetting_model->Getsite('onereferral');
				$this->data['tworeferral']= $this->Generalsetting_model->Getsite('tworeferral');

				$this->data['facebook']= $this->Generalsetting_model->Getsite('facebook');
				$this->data['twitter']= $this->Generalsetting_model->Getsite('twitter');
				$this->data['pinterest']= $this->Generalsetting_model->Getsite('pinterest');
				$this->data['whatsapp']= $this->Generalsetting_model->Getsite('whatsapp');
				$this->data['youtube']= $this->Generalsetting_model->Getsite('youtube');
				$this->data['instagram']= $this->Generalsetting_model->Getsite('instagram');
				$this->data['telegram']= $this->Generalsetting_model->Getsite('telegram');
				$this->data['Ticktok']= $this->Generalsetting_model->Getsite('Ticktok');


				



			
				$this->load->view('admin/generalsetting',$this->data);
 		

	}//function ends

	public function tokensetting(){		
				$admin_login=$this->session->userdata('admin_login');
				$data['tokendata'] = $this->db->query("SELECT * FROM arm_tokens where id='".$admin_login."'")->result();	
				
				$this->load->view('admin/tokensetting',$this->data);
 		
	}
	public function tokenset()
	{
		$admin_login=$this->session->userdata('admin_login');
		if($this->input->post())
			{
				$this->form_validation->set_rules('token_name', 'token_name', 'trim|required');
				$this->form_validation->set_rules('token_symbol', 'token_symbol', 'trim|required');
				$this->form_validation->set_rules('total_token', 'total_token', 'trim|required');
				$this->form_validation->set_rules('earn_token','earn_token','trim|required');
				if($this->form_validation->run() == true)	
 				{	
 					$tok_name=$this->input->post('token_name');
 					$data_input = array(
						'token_name'=>$this->input->post('token_name'),
						'token_symbol'=>$this->input->post('token_symbol'),
						'total_token'=>$this->input->post('total_token'),
						'total_earntoken'=>$this->input->post('earn_token')
						
					);
					
					
					$query = $this->db->query("SELECT * FROM arm_tokens where id='".$admin_login."'")->result();					
					$id=$query[0]->id;
					if($_FILES['token_logo']['tmp_name']!='')
					{ 
						$config['upload_path'] = 'uploads/admin/site/';
						$config['allowed_types'] = '*';
						$config['encrypt_name'] = TRUE;

						$this->load->library('upload', $config);

						if ( ! $this->upload->do_upload('token_logo')) {
							$upload_files = 0;
							$this->session->set_flashdata('error_message', ' image extension invalid. '.$this->upload->display_errors());
							
						} else {
							$data_input = array('token_logo'=> 'uploads/admin/site/'.$this->upload->data('file_name'));
							$upload_files = 1;
						}
						
					}
					
					if($id==$admin_login)
					{
					$condition2 = "id =" . "'" . $admin_login . "'";
					$status1 = $this->common_model->UpdateRecord($data_input, $condition2, 'arm_tokens');
					//$status2 = $this->common_model->UpdateRecord($data_implode, $condition2, 'arm_tokens');
						if($status1)
						{
						   $this->session->set_flashdata('success_message',"Token Update Successfully");
							redirect('admin/Sitesetting/tokensetting');

						}
						else
						{
							$this->session->set_flashdata('error_message',"Error! Token not Updated");
							redirect('admin/Sitesetting/tokensetting');
						}

					}
 				}
 			}else{
 				$this->session->set_flashdata('error_message',"Error! Fill it");
 				redirect('admin/Sitesetting/tokensetting');
 			}

	}


	public function minlimit_check()
	{

		//echo $str,'<'.$max;
		if($this->input->post('minuserpasswordlength') <= $this->input->post('maxuserpasswordlength')) 
			{
				return true; 
			}
		else{
				
			$this->form_validation->set_message('minlimit_check', '<p><em class="state-error1">The given '.ucwords($this->lang->line('minuserpasswordlength')).' field values less than or equal to  '.ucwords($this->lang->line('maxuserpasswordlength')).'</em></p>');
			return false;
		}
	}

	public function settings(){
		if($this->input->post())
			{
				
				$this->form_validation->set_rules('sitename', 'sitename', 'trim|required|alpha_numeric');
				$this->form_validation->set_rules('siteurl', 'siteurl', 'trim|required');
				$this->form_validation->set_rules('adminmailid', 'adminmailid', 'trim|required|valid_email');
				$this->form_validation->set_rules('multivendor','multivendor','trim|required');
				
				$this->form_validation->set_rules('admin_fee', 'admin_fee', 'trim|required|callback_minlimit_check');
		
					
 				if($this->form_validation->run() == true)	
 				{


					$data = array(
						'sitename'=>$this->input->post('sitename'),
						'siteurl'=>$this->input->post('siteurl'),
						'adminmailid'=>$this->input->post('adminmailid'),
						'sitemetatitle'=>$this->input->post('sitemetatitle'),
						'sitemetakeyword'=>$this->input->post('sitemetakeyword'),
						'sitemetadescription'=>$this->input->post('sitemetadescription'),
						'sitestatus'=>$this->input->post('sitestatus'),
						'admin_fee'=>$this->input->post('admin_fee'),

						'sitegooglecode'=>$this->input->post('sitegooglecode'),
						'allowpicture'=>($this->input->post('allowpicture')),
						'emailapproval'=>($this->input->post('emailapproval')),
						'mobileapproval'=>($this->input->post('mobileapproval')),
						'usecaptcha'=>($this->input->post('usecaptcha')),
						'google_verify'=>($this->input->post('google_verify')),
						'allowregistration'=>($this->input->post('allowregistration')),
						'allowlogin'=>($this->input->post('allowlogin')),
						'uniqueip'=>($this->input->post('uniqueip')),
						'uniquemobile'=>($this->input->post('uniquemobile')),
						'uniqueemail'=>($this->input->post('uniqueemail')),
						'allowusers'=>($this->input->post('allowusers')),
						'another_login'=>($this->input->post('another_login')),
						'footercontent'=>($this->input->post('footercontent')),
						'google_client_id'=>($this->input->post('google_client_id')),
						'google_client_secret'=>($this->input->post('google_client_secret')),
						'fb_client_id'=>($this->input->post('fb_client_id')),
						'fb_client_secret'=>($this->input->post('fb_client_secret')),
						'address'=>($this->input->post('address')),
						'multivendor'=>$this->input->post('multivendor'),
						'defaultsponsors'=>($this->input->post('defaultsponsors')),
						'referrallink'=>($this->input->post('referrallink')),
						'kyc'=>($this->input->post('kyc')),
						'themecolor'=>($this->input->post('themecolor')),
						'advertise_cost'=>($this->input->post('advertise_cost')),
						'width'=>$this->input->post('width'),
						'height'=>$this->input->post('height'),
						'contactustitle'=>$this->input->post('contactustitle'),
						'contactuscontent'=>$this->input->post('contactuscontent'),
						'contactusnote'=>$this->input->post('contactusnote'),
						'noreferral'=>$this->input->post('noreferral'),
						'onereferral'=>$this->input->post('onereferral'),
						'tworeferral'=>$this->input->post('tworeferral'),
						'facebook'=>$this->input->post('facebook'),
						'twitter'=>$this->input->post('twitter'),
						'pinterest'=>$this->input->post('pinterest'),
						'whatsapp'=>$this->input->post('whatsapp'),
						'youtube'=>$this->input->post('youtube'),
						'instagram'=>$this->input->post('instagram'),
						'telegram'=>$this->input->post('telegram'),
						'Ticktok'=>$this->input->post('Ticktok')
						// 'sitelogo'=>$sitelogo
						// 'sitelogo'=>$config['upload_path'].$upload_files1
					);

					if(isset($_FILES['sitelogo']['name'])!='')
					{
						$config['upload_path'] = 'uploads/admin/site/';
						$config['allowed_types'] = '*';
						$config['encrypt_name'] = TRUE;

						$this->load->library('upload', $config);

						if ( ! $this->upload->do_upload('sitelogo')) {
							
							//$this->session->set_flashdata('error_message', $this->upload->display_errors());
						$data['sitelogo']=$this->Generalsetting_model->Getsite('sitelogo');

							
						} else {
						
						$upload_files1 = $this->upload->data('file_name');
						$data['sitelogo'] = 'uploads/admin/site/'.$upload_files1;

							
						}
				
					}

					if(isset($_FILES['sitefav']['name'])!='')
					{
						$config['upload_path'] = 'uploads/admin/site/';
						$config['allowed_types'] = '*';
						$config['encrypt_name'] = TRUE;
						$this->load->library('upload', $config);
						if( ! $this->upload->do_upload('sitefav')) 
						{
							$data['sitefav']=$this->Generalsetting_model->Getsite('sitefav');
						} 
						else 
						{
							$upload_files1 = $this->upload->data('file_name');
							$data['sitefav'] = 'uploads/admin/site/'.$upload_files1;
						}
				
					}


					if(isset($_FILES['sitelogin']['name'])!='')
					{
						$config['upload_path'] = 'uploads/admin/site/';
						$config['allowed_types'] = '*';
						$config['encrypt_name'] = TRUE;
						$this->load->library('upload', $config);
						if( ! $this->upload->do_upload('sitelogin')) 
						{
							$data['sitelogin']=$this->Generalsetting_model->Getsite('sitelogin');
						} 
						else 
						{
							$upload_files1 = $this->upload->data('file_name');
							$data['sitelogin'] = 'uploads/admin/site/'.$upload_files1;
						}
				
					}
					$result = $this->Generalsetting_model->sitechange($data);
					// exit;
				}

				else
				{
					$result =0;
				}

				if($result)
				{
					$this->session->set_flashdata('success_message',$this->lang->line('successmessage'));
					redirect('admin/Sitesetting');

				}
				else
				{
					$this->session->set_flashdata('error_message',$this->lang->line('errormessage'));
					redirect('admin/Sitesetting');
				}
				
			
			}
			// redirect('admin/Sitesetting');
	// }
		}

} 
//class ends


