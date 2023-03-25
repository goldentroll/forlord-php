<?php

/*@session_start();*/

//include 'include/connect.php';
/*echo "ggg";
exit();*/
//include 'Google_authendicator.php';


//$this->load->view('user/Google_authendicator');


 class Verify_auth 
{
//echo "kkkk";
//exit();
 public function __construct()
    {

	$this->load->library('Google_authendicator');

 }
  
public function index()
{
$google2fa = new GoogleAuthenticator();

// secret key
$secret = $google2fa->createSecret();

// echo "<pre>"; print_r($secret); echo "</pre>";

if($secret)
{
	$get_code=$google2fa->getCode($secret);
	// echo "<pre>"; print_r($get_code); echo "</pre>";
	if($get_code)
	{
		// update the db for that user google authendicate code 
		$update=$this->db->query("update arm_members set google_authendicatecode='".$get_code."' where MemberId='".$this->session->userdata('MemberID')."'");
		if($update)
		{
			$fetch_members=$this->db->query("select * from arm_members where MemberId='".$this->session->userdata('MemberID')."'");
			$username=$fetch_members->row()->UserName;
			/*$fetch_site=mysql_fetch_array(mysql_query("select * from admin_settings where admin_settings_id='1'"));
			$site_name=$fetch_site['site_name'];*/
			$fetch_site = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitename'", "arm_setting");
			$site_name  =$fetch_site->ContentValue;
			$get_qrcode=$google2fa->getQRCodeGoogleUrl($username,$secret,$site_name);
			if($get_qrcode)
			{
				$qr_code=$get_qrcode;
				// echo $qr_code;
			}
			//include('verifyauth.php');
			$this->load->view('user/verifyauth');
			//$this->load->view('user/verifyauth');
		}
	}
}

}
}
?>