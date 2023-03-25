<!doctype html>
<html lang="en">
<head>
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>


<body class="">
<div class="wrapper dash-bg">

<?php

   ini_set('display_startup_errors', 1);
   ini_set('display_errors', 1);      
   error_reporting(-1);

 // $this->load->library('MyEncrypt');
 $this->load->view('user/user_aside');?>

<div id="content">
<div class="admin_main">
<button type="button" id="sidebarCollapse" class="toggle">
<div class="toggle_admin"> <img src="<?php echo base_url();?>assets/styl/images/toggle-ic.png" class="img-fluid" /> </div>
</button>
<div class="admin-top position-relative">
<div class="row">
<div class="col-sm-12">
<div class="d-lg-flex justify-content-between">
<div class="admin-head position-relative">
<h3 class="fw-normal2 text-white"> Video Reward </h3>
</div>

<div class="dash-btn"><span class="text-white text-grad">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span>  <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div>
</div>
</div>
</div>
</div>
<div class="admin-middle">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="title text-center"> <span class="text-grad">Quick Stats</span>
<h2 class="text-white fw-bold mb-3 text-uppercase pla">Video Reward</h2>
</div>
</div>
</div>
<style type="text/css">
  body
  {
     font-size: 16px;
  }
  #status span.status {
  display: none;
  font-weight: bold;
  }
  span.status.complete {
  color: green;
  }
  span.status.incomplete {
  color: red;
  }
  #status.complete span.status.complete {
  display: inline;
  }
  #status.incomplete span.status.incomplete {
  display: inline;
  }
    .main_card {
  color: #fff;
  width: auto;
min-height: 200px;
  display: block;
  background: #00C9FF; 
  background: -webkit-linear-gradient(to right, #92FE9D, #00C9FF);
  background: -webkit-gradient(linear, left top, right top, from(#92FE9D), to(#00C9FF));
  background: -webkit-linear-gradient(left, #92FE9D, #00C9FF);
  background: -o-linear-gradient(left, #92FE9D, #00C9FF);
  background: linear-gradient(to right, #92FE9D, #00C9FF); 
  -webkit-box-shadow: 0 0 40px rgba(0,0,0,0.3); 
          box-shadow: 0 0 40px rgba(0,0,0,0.3);
}

.main_card .card_left {
  width: 60%;
}

.main_card .card_datails {
  width: 100%;
  padding: 20px;
  margin-top: -25px;
  background: linear-gradient(to right, #92FE9D, #00C9FF) !important;
  color: white;
}
.main_card .card_datails  h1 {
  font-size: 20px;
  padding: 10px;
}
.main_card .card_right img {
  height: 390px;
  border-radius: 2px;
}
.main_card .card_right {
  border-radius: 2px;
}

.main_card .card_cat {
  width: 100%;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
      -ms-flex-pack: justify;
          justify-content: space-between;
}

.main_card .PG, .year, .genre, .time {
  color: fff;
  padding: 10px;
  font-weight: bold;
  border-radius: 15px;
}

.main_card .PG {
  background: #92FE9D;
  -webkit-box-shadow: 0 0 50px rgba(0,0,0,0.1);
          box-shadow: 0 0 50px rgba(0,0,0,0.1);
  -webkit-transition: 300ms ease-in-out;
}

.main_card .disc {
  font-weight: 100;
  line-height: 27px;
}
.main_card a {
  display: block;
  text-decoration: none;
}
.social-btn {
  margin-left: -10px;
}
.main_card button {
  color: #fff;
  border: none;
  padding: 20px;
  outline: none;
  font-size: 12px;
  margin-top: 30px;
  margin-left: 10px;
  background: #92FE9D;
  border-radius: 12px;
  -webkit-box-shadow: 0 0 20px rgba(0,0,0,0.2);
          box-shadow: 0 0 20px rgba(0,0,0,0.2);
  -webkit-transition: 300ms ease-in-out;
  -o-transition: 200ms ease-in-out;
  transition: 200ms ease-in-out;
}

.main_card button:hover {
  -webkit-transform: scale(1.1);
      -ms-transform: scale(1.1);
          transform: scale(1.1);
}
.play_btn {
    margin: auto;
    position: absolute;
    text-align: center;
    box-shadow: 0 0 50px rgba(0,0,0,0.2);
    margin-top: -86px;
    margin-left: 102px;
}
 .fa-play-circle {
  color: #255;
  font-size: 60px;
  margin-top: -138px;
  -webkit-animation: bounce 1.0s -0.4s infinite;
          animation: bounce 1.0s -0.4s infinite;
}
 .fa-play-circle:hover {
  color: aqua;
  animation: bounce 0.4s infinite;
}
@-webkit-keyframes bounce {
  8% {
    transform: scale(0.3);
    -webkit-transform: scale(0.8);
    opacity: 1;
  }
  10% {
    transform: scale(1.8);
    -webkit-transform: scale2);
    opacity: 0;
    }
}

@keyframes bounce {
  8% {
    transform: scale(0.3);
    -webkit-transform: scale(0.8);
    opacity: 1;
  }
  20% {
    transform: scale(1.8);
    -webkit-transform: scale2);
    opacity: 0;
    }
}

  @keyframes floating {
  from { transform: translateY(0px); }
  65%  { transform: translateY(15px); }
  to   { transform: translateY(-0px); }
  }


  .astronaut{
  position: relative;
  left: 10vmin;
  height: 30vmin;
  animation: floating 3s infinite ease-in-out;
  top: 34px;
  left: -13px;
  }

  #whtched
  {
  position: absolute;
  left: 115px;
  top: -114px;
  font-size: 14px !important;
  font-weight: 800;
  background: red;
  padding: 8px;
  color: white;
  }

</style>

  <div class="container">

  <div class="col-lg-11">
  <div class="row">
  <?php
  if($active_video)
  {
  $userid = $this->session->MemberID;
  $i="0";
  foreach ($active_video as $key_video) {
  ?>


<?php
$video_history = $this->db->query("SELECT * FROM arm_history where MemberId = '".$userid."' and TypeId='20' and video_id ='".$key_video->page_id."'  ")->row();


if(!$video_history)
{
  $i++;
?>


  <div class="col-lg-4 mb-3">
  <div class="other-bal  bor-rig">
  <iframe src="<?php echo getYoutubeEmbedUrl($key_video->reward_url);?>" class="img-fluid rounded"></iframe>
    <div class="play_btn">


<?php
$video_history = $this->db->query("SELECT * FROM arm_history where MemberId = '".$userid."' and TypeId='20' and video_id ='".$key_video->page_id."'  ")->row();

if($video_history)
{
?>
<span id="whtched"><small>Watched</small></span>
<?
}
?>

 <a href="<?php echo base_url();?>rewards/<?php echo $key_video->page_id;?>">  <i class="fas fa-play-circle"></i></a>
  </div>
<br>

  <div class="other-con">
  <span class="text-white" style="font-size: 13px;"><?php echo date("d M Y", strtotime($key_video->reward_date));?></span>
  <h6 class="text-secondary"><?=$key_video->page_title;?></h6>
  <p class="text-white"><?= ucfirst(substr($key_video->page_content, 0, 90))?></p>
    <a href="<?php echo base_url();?>rewards/<?php  echo $key_video->page_id;?>" class="btn btn-primary">Read More</a> 
  </div>

  </div>

  </div>
  <?php
  }
  }
  }
  ?>
<?php

if($i==0)
{
  ?>
  <div class="col-lg-12">
<div class="box bg-white rounded-1 farm-token">
<div class="d-flex justify-content-between align-items-center">

<div class="active-ico bg-white box2" style="width: 100%;background-image: url('https://assets.codepen.io/1538474/star.svg'),linear-gradient(to bottom, #05007A, #4D007D);">
<div class="d-flex align-items-center" style="min-height: 100px;justify-content: center;">
<img src="https://assets.codepen.io/1538474/astronaut.svg" class="astronaut">

<h4 class="theme-color" style="margin-top: 20%;margin-right:20%;color: black"><a style="margin-top: 20%; color: white;text-align:center">No Video Availabel</a><small class="text-gray fw-3"></small></h4>

</div>
</div>

</div>
</div>
</div>
  <?
}

?>




  </div>
  </div>
  </div>
</div>
<?php $this->load->view('user/login_footer');?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>

<?php

function getYoutubeEmbedUrl($url)
{
$shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
$longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

if (preg_match($longUrlRegex, $url, $matches)) {
$youtube_id = $matches[count($matches) - 1];
}

if (preg_match($shortUrlRegex, $url, $matches)) {
$youtube_id = $matches[count($matches) - 1];
}
return 'https://www.youtube.com/embed/' . $youtube_id ;
}

?>


 <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.2/vanilla-tilt.min.js" integrity="sha512-K9tDZvc8nQXR1DMuT97sct9f40dilGp97vx7EXjswJA+/mKqJZ8vcZLifZDP+9t08osMLuiIjd4jZ0SM011Q+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">

</script>

        
  