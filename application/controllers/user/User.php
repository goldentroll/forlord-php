<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();

		
		$this->load->model('admin/testimonial_model');
		$this->load->model('product_model');
		$this->load->model('page_model');
		$this->load->model('common_model');
		$this->load->model('admin/Smtpsetting_model');
		// Load database
		
		// change language

		// load language
		$this->lang->load('common',$this->session->userdata('language'));
		$this->lang->load('user/common',$this->session->userdata('language'));


	}

	public function index()
	{
			
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
		$this->data['userIndex_page'] = $userIndex;
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



		$this->load->view('user/user',$this->data);
	}




	public function chart(){
	$this->load->view('user/chart');
	}


	public function earningschart(){
	$this->load->view('user/earningschart');
	}

		public function all_earnings(){
	$this->load->view('user/all_earnings');
	}


	public function get_paydetails(){

 $payment_info = 
 $this->db->query("SELECT * FROM `arm_walletadderss` ORDER BY wallet_id DESC limit 0,1")->row();

	echo json_encode($payment_info);
	
	}

	public function subscribe() {

		if(valid_email($this->input->post('mailid'))) {
			$condition = "MailId='".$this->input->post('mailid')."'";
			$check_subscribe = $this->common_model->GetRow($condition, 'arm_subscribe_list');
			if(!$check_subscribe) {
				// check referal name

				if($this->input->post('ref')!='')
				$checkname = $this->common_model->getreferralname($this->input->post('ref'));

				if($checkname) {
					$memberdet = $this->common_model->GetRow("ReferralName='".$this->input->post('ref')."' ","arm_members");
					$RefereId = $memberdet->MemberId;
				} else {
					$RefereId = 1;
				}

				$data = array(
					'RefereId' => $RefereId,
					'MailId' => $this->input->post('mailid'),
					'Status' => '1',
					'DateAdded' => date('Y-m-d H:i:s')
				);

				$sub_status = $this->db->insert('arm_subscribe_list',$data);

				if($sub_status) {
					$json['success'] = 'Success! Your subscribe.';
				} else {
					$json['error'] = 'Fail! please try again.';
				}
			} else {
				$json['error'] = 'Fail! Already subscribe.';
			}

		} else {
			$json['error'] = 'Fail! Invalid Email.';
		}
		
		echo json_encode($json);
	}


	public function check_email()
	{

    $this->load->library('My_PHPMailer');

	// $smtpmail = 'info@forlord.com';
	// $smtppassword = 'BNZkZjMKh+DkHH31eZCwkCgRHEkU5VnAGfPXbkF1Ky12';
	// $smtpport = '587';
	// $smtphost = 'email-smtp.us-west-2.amazonaws.com';

	$mail = new PHPMailer();
	$mail->IsSMTP(); 

	$mail->SMTPDebug  = 1;  
	$mail->SMTPAuth   = TRUE; 
	$mail->SMTPSecure = 'tls';  
	$mail->Host       = 'email-smtp.us-east-1.amazonaws.com';      
	$mail->Port       =  587;                   
	$mail->Username   = 'AKIAQPHJV44NJB3SO72P';
	$mail->Password   = 'BCZXjC9DFLF97BJtG0vNWU+geNaZCoPOmuZ0Kwz7mWuT';   

	//'AKIAQPHJV44NAMSBS57J';  

	$mail->IsHTML(true);
	$mail->AddAddress("yanceyker89@gmail.com", "test");
	$mail->SetFrom("support@forlord.com", "forlord");
	$mail->AddReplyTo("loadingvjy@gmail.com", "reply-to-name");
	//$mail->AddCC("palani@arminfotech.us", "cc-recipient-name");
	$mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
	$content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";

	$mail->MsgHTML($content); 


	if(!$mail->Send()) {
	echo "Error while sending Email.";
	echo "<pre>";
	var_dump($mail);
	echo "<pre>";
	exit();
	} else {
	echo "Email sent successfully";
	}
	}


	public function check_email1()
{

       $this->load->library('My_PHPMailer');
 
	    $mail = new PHPMailer();
	    $mail->isMail();
		
		$mail->setFrom('palani@arminfotech.us', 'Your Name');
		$mail->addAddress('ashok@arminfotech.us', 'My Friend');
		$mail->Subject  = 'First PHPMailer Message';
		$mail->Body     = 'Hi! This is my first e-mail sent through PHPMailer.';
		if(!$mail->send()) {
		echo 'Message was not sent.';
		echo "<pre>";
		print_r('Mailer error: ' . $mail->ErrorInfo);
		echo "<pre>";
		} else {
		echo 'Message has been sent.';
        }

		$to = "ashok@arminfotech.us";
		$subject = "This is subject";
		$from="palani@arminfotech.us";
		$body = "Hi! This is my first e-mail sent through PHPMailer.";


		$headers = 'From: ' . $from . ' ' . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\b";
		$retval = mail($to,$subject,$body,$headers);
		if(isset($retval))//change
		{

			print_r($retval->ErrorInfo);
		echo "Message sent successfully...";
		}
		else
		{
			print_r($retval->ErrorInfo);
		echo "Message could not be sent...";
		}

	// echo "<br>mail sent";
	// $from='admin@forlord.com';
	// $headers = 'From: palani@arminfotech.us '. "\r\n";
	// $headers .= "MIME-Version: 1.0" . "\r\n";
	// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\b";
	// $retval = mail('ashok@arminfotech.us','First PHPMailer Message','Hi! This is my first e-mail sent through PHPMailer.',$headers);

}


public function check_email2()
{

		$this->load->library('My_PHPMailer');
		// require_once('PHPMailer/src/Exception.php');
		// Replace sender@example.com with your "From" address.
		// This address must be verified with Amazon SES.
		$sender = 'palani@arminfotech.us';
		$senderName = 'Sender Name';

		// Replace recipient@example.com with a "To" address. If your account
		// is still in the sandbox, this address must be verified.
		$recipient = 'ashok@arminfotech.us';

		// Replace smtp_username with your Amazon SES SMTP user name.
		$usernameSmtp = 'Forlord';

		// Replace smtp_password with your Amazon SES SMTP password.
		$passwordSmtp = '@ccA2810696';

		// Specify a configuration set. If you do not want to use a configuration
		// set, comment or remove the next line.
		//$configurationSet = 'ConfigSet';

		// If you're using Amazon SES in a region other than US West (Oregon),
		// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
		// endpoint in the appropriate region.
		$host = 'email-smtp.us-west-2.amazonaws.com';
		$port = 587;

		// The subject line of the email
		$subject = 'Amazon SES test (SMTP interface accessed using PHP)';

		// The plain-text body of the email
		$bodyText =  "Email Test\r\nThis email was sent through the
		Amazon SES SMTP interface using the PHPMailer class.";

		// The HTML-formatted body of the email
		$bodyHtml = '<h1>Email Test</h1>
		<p>This email was sent through the
		<a href="https://aws.amazon.com/ses">Amazon SES</a> SMTP
		interface using the <a href="https://github.com/PHPMailer/PHPMailer">
		PHPMailer</a> class.</p>';

		$mail = new PHPMailer();

		try {
		// Specify the SMTP settings.
		$mail->isSMTP();
		$mail->setFrom($sender, $senderName);
		$mail->Username   = $usernameSmtp;
		$mail->Password   = $passwordSmtp;
		$mail->Host       = $host;
		$mail->Port       = $port;
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = 'tls';
		$mail->addCustomHeader('X-SES-CONFIGURATION-SET');

		// Specify the message recipients.
		$mail->addAddress($recipient);
		// You can also add CC, BCC, and additional To recipients here.

		// Specify the content of the message.
		$mail->isHTML(true);
		$mail->Subject    = $subject;
		$mail->Body       = $bodyHtml;
		$mail->AltBody    = $bodyText;
		$mail->Send();

        echo "<pre>";
        print_r($mail->ErrorInfo);
        echo "<pre>";

		echo "Email sent!" , PHP_EOL;
		} catch (phpmailerException $e) {
		echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
		} catch (Exception $e) {
		echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
		}

}


public function check_mail3()
{
		
		$this->load->config('email');
		$this->load->library('email');
   
     
        $from = $this->config->item('smtp_user');
        $to = 'palani@arminfotech.us';
        $subject = 'Amazon SES test (SMTP interface accessed using PHP)';
        $message = 'Email Test';

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
        } else {
        	echo "<pre>";
            show_error($this->email->print_debugger());
            echo "<pre>";
        }
 

}



public function check_email3()
{
	// require_once ('class.phpmailer.php' ); // Add the path as appropriate
	//$this->load->library('My_PHPMailer');

	//require_once(APPPATH.'libraries/PHPMailer/class.phpmailer.php');

	require_once(APPPATH.'libraries/PHPMailer-master/src/PHPMailer.php');
	require_once(APPPATH.'libraries/PHPMailer-master/src/SMTP.php');
	require_once(APPPATH.'libraries/PHPMailer-master/src/Exception.php');
	
    $Mail = new PHPMailer\PHPMailer\PHPMailer();
    $Mail->IsSMTP(); // enable SMTP

	// $Mail = new PHPMailer();

	$Mail->IsSMTP(); // Use SMTP
	$Mail->Host        = "email-smtp.us-west-2.amazonaws.com"; // Sets SMTP server
	$Mail->SMTPDebug   = 1; // 2 to enable SMTP debug information
	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
	$Mail->SMTPSecure  = "ssl"; //Secure conection
	$Mail->Port        = 465; // set the SMTP port
	$Mail->Username    = 'AKIAQPHJV44NAMSBS57J'; // SMTP account username
	$Mail->Password    = 'BNZkZjMKh+DkHH31eZCwkCgRHEkU5VnAGfPXbkF1Ky12'; // SMTP account password
	$Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
	$Mail->CharSet     = 'UTF-8';
	$Mail->Encoding    = '8bit';
	$Mail->Subject     = 'Test Email Using Gmail';
	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
	$Mail->From        = 'info@forlord.com';
	$Mail->FromName    = 'GMail Test';
	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line

    $ToEmail =  "palani@arminfotech.us";
	$Mail->AddAddress($ToEmail,'test'); // To:
	$Mail->isHTML( TRUE );
	$Mail->Body    = "Test Email Using Gmail";
	$Mail->AltBody = "Test Email Using Gmail";

// echo "<pre>";
// print_r($Mail);
// echo "<pre>";
// exit();

	$Mail->Send();




	$Mail->SmtpClose();

	if ( $Mail->IsError() ) { 

echo "<pre>";
print_r($Mail->IsError);
echo "<pre>";

	echo "ERROR<br /><br />";
	}
	else {

echo "<pre>";
print_r($Mail->IsError);
echo "<pre>";


	echo "OK<br /><br />";
	}
}

}
?>