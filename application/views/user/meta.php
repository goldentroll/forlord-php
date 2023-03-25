<?php
    $site_datas = site_info();
    $site_fav=$this->db->query("select * from arm_setting where page='sitesetting' and KeyValue='sitefav'")->row();

    $site_name=$this->db->query("select * from arm_setting where page='sitesetting' and KeyValue='sitename'")->row();
    $site_des=$this->db->query("select * from arm_setting where page='sitesetting' and KeyValue='sitemetadescription'")->row();
	$site_key=$this->db->query("select * from arm_setting where page='sitesetting' and KeyValue='sitemetakeyword'")->row();
    $sitefav=$site_fav->ContentValue;
	
	if($sitefav)
    	$imgfav=$sitefav;
    else
    	$imgfav="assets/img/favicon.ico";

	$site_login=$this->db->query("select * from arm_setting where page='sitesetting' and KeyValue='sitelogin'")->row();
	$sitelogin=$site_login->ContentValue;

	if($sitelogin)
    	$imglogin=$sitelogin;
    else
    	$imglogin="assets/user/img/login.png";

   
	
?>

 <meta charset="utf-8">
    <title><?php echo  $site_name->ContentValue;?></title>
    <meta name="keywords" content="<?php echo  $site_des->ContentValue;?>"/>
    <meta name="description" content="<?php echo  $site_key->ContentValue;?>">
    <meta name="author" content="ARMMLM">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,  user-scalable=no">
    <link rel="shortcut icon" href="<?php echo base_url().''.$imgfav;?>">

<style type="text/css">
@media only screen and (max-width: 991px)
{
.footnav {
display: inline-grid !important;
}
}
</style>
     