<!doctype html>
<html lang="en">
<head>
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<style type="text/css" href="http://vjs.zencdn.net/4.1.0/video-js.css"></style>

<body class="">
<div class="wrapper dash-bg">

<?php
$this->load->library('MyEncrypt');
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
  .video-player {
  width: 100%;
  position: relative;
  }
  #video
  {
     width: 100% !important;
  }
  video {
  width: 100% !important;
  height: 100%;
  background:black;
  }
/*  video::-webkit-media-controls-panel {
  background-color: #f00;
  }*/

   @media only screen and (max-width:575px) {
  .video-player {
  width: 100% !important;
  position: relative;
  }
}

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.0.0/video.min.js" integrity="sha512-LiILFcpZ9QKSH41UkK59Zag/7enHzqjr5lO2M0wGqGn8W19A/x2rV3iufAHkEtrln+Bt+Zv1U6NlLIp+lEqeWQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.0.0/video-js.min.css" integrity="sha512-zki7IiwYvLzVZouKA+V/vtIuW7cK8M2ug1kaRBItuBWG8TDvA6jrtjhKPOrz3RFGpt9OQC/xE7DUfsrHxoBXxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

      <style type="text/css">
      .publicform {
      }
      #confetti-canvas
      {
        position: absolute;
        top:0;
      }
      </style>

<link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />
<!--  <div class="container abt-cons">
    <div class="row">
      <div class="col-lg-12">
        <div class="abt-con text-center">
            <h1 class="text-white fw-bold"><?php echo $page_data->page_title;?></h1>
          </div>
      </div>
    </div>
  </div> -->
</section>


<section class="img-bg2 py-4" style="min-height: 60vh;" >
  <div class="container">
  <div class="icons">
  <div class="container">
  <div class="row">
  <div class="col-md-12" id="copleted" style="display:block;"  >
  <div class="rafiq-head">

  <div class="col-md-9 col-md-offset-2">
  <div class="row">

<?php
if($page_data) 
{
?>
 <h4 class="text-grad" style="margin-bottom: 20px;">Reward <span class="text-primary">Video </span> </h4>
 <div width="100%" style='border:none;' >

<!--  <iframe type="text/html" id="video"  width="640" height="390"
  src="<?php echo $page_data->reward_url;?>"
 frameborder="0" allowtransparency="true" allowfullscreen ></iframe>  -->
 <!-- src="http://www.youtube.com/embed/W7qWa52k-nE" -->
<!--   <iframe id="video"  
  width="560" src="<?php echo $page_data->reward_url;?>" height="315" frameborder="0" allowfullscreen></iframe>  -->
<!-- <video style="height:315px;" src="<?php echo $page_data->reward_url;?>" id="video" class="img-fluid rounded" controls="controls"></video> -->
<!-- 
  <div class="video-player">
    <video style="height:315px;border:none; min-width: 100%;"  controls="true" class="video-js vjs-default-skin" 
    controls
    preload="auto"
    poster="MY_VIDEO_POSTER.jpg"
    data-setup=''
    poster="" 
    id="video">
    <source  src="<?php echo $page_data->reward_url;?>#.mp4"></source>
    </video>
  </div>  
 -->
<!--  <video id="example_video_1" 
  class="video-js vjs-default-skin" 
  controls
  preload="auto" 
  width="640"
  height="264"
  poster="http://ec2-54-227-116-247.compute-1.amazonaws.com/models/site-templates/images/cover_img/ted_cover.jpg" 
  data-setup='{"techOrder":["youtube"], "src":"http://www.youtube.com/watch?v=xYemnKEKx0c"}'></video> -->

<div id="player"></div>

<!--   <div class="video-player">
  <video controls="true" id="video">
  <source src="<?php echo $page_data->reward_url;?>" type="video/mp4" />
  </video>
  </div>  -->
<!--  
 <video id="example_video_1" class="video-js vjs-default-skin" controls preload="auto" width="640" height="264">
</video> -->


<!-- 
<video id="example_video_1" 
  class="video-js vjs-default-skin" 
  controls
  preload="auto" 
  width="640"
  height="264"
  poster="http://ec2-54-227-116-247.compute-1.amazonaws.com/models/site-templates/images/cover_img/ted_cover.jpg" 
  data-setup='{"techOrder":["youtube"], "src":"http://www.youtube.com/watch?v=xYemnKEKx0c"}'></video> -->
<?php

$link = $page_data->reward_url;
$video_id = explode("?v=", $link);
$video_id = $video_id[1];

?>

  <div id="status" class="incomplete">
  <span class="text-white">Play status: </span>
  <span class="status complete ">COMPLETE</span>
  <span class="status incomplete">INCOMPLETE</span>
  <br />
  </div>
  <div>
  <span id="played" class="text-white">0</span> <span class="text-white"> seconds out of  </span>
  <span id="duration" class="text-white"></span> <span class="text-white" id="change_color"> seconds. </span> <span id="get_minutes" class="text-white">  </span> <span class="text-white">(only updates when the video Complete.)</span>
  </div>
</div>
<?
}
?>
<div class="container" style="margin-top: 20px;overflow: auto;">
<div class="about_area_left">
 <h4 class="text-grad" style="margin-bottom: 20px;">Reward <span class="text-primary"> Description </span></h4>
  <?php echo  $page_data->page_content;?>

  <input type="hidden" id="duration" value="<?php echo date('i:s',strtotime($page_data->reward_time)); ?>">
</div>
</div>

<?php 
if($already_watch!=1)
{?>

<div class="container" style="margin-top: 20px;">
<div class="about_area_left">
 <h4 class="text-grad" style="margin-bottom: 20px;">Video <span class="text-primary"> Reward </span></h4>
  <span class="text-white"> Get Rewards when Complete Watch Video : <?php echo  number_format($page_data->reward_amount,2);?> (USDT)</span><p id="demo"></p>

  <input type="hidden" id="duration" value="<?php echo date('h:i:s',strtotime($page_data->reward_time)); ?>">
</div>
</div>

<?php
}
?>
</div>
</div>
</div>
</div>
</div>


<div class="col-lg-11" style="overflow: hidden;">
<div class="publicform form-back position-relative z-in1 bord-grad"  style="display: none;">
<div class="container">
<div class="row">
<div class="col-lg-11" style="overflow: hidden;">
<div class="text-center" id="messages">
<div class="col-lg-11">
<p class="text-white"><?php 
echo "Successfuly You Have Received : ".number_format($page_data->reward_amount,2) .'(USDT)';
?></p>
<div class="row">
<div class="col-lg-12">
<button class=
"submitId btn btn-primary text-center font-weight-bold mt-5" id="popup_close" >
Close
</button>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $this->load->view('user/login_footer');?>
</div>
</div>   
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js" integrity="sha512-z4OUqw38qNLpn1libAN9BsoDx6nbNFio5lA6CuTp9NlK83b89hgyCVq+N5FdBJptINztxn1Z3SaKSKUS5UP60Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url();?>assets/js/confetti.js"></script>

<script src="<?php echo base_url();?>assets/js/confetti.js"></script>

  <script>
  // 2. This code loads the IFrame Player API code asynchronously.
  var tag = document.createElement('script');

  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);



  var duration_get = convert('<?php echo date('H:i:s',strtotime($page_data->reward_time)); ?>');
  var get_minutes = Math.floor(duration_get / 60);

  if(duration_get>60)
  {
  $('#get_minutes').html("( "+get_minutes+" Minutes )");
  }

  var timeStarted = -1;
  var timePlayed = 0;
  var duration = 0;

  var timer = null;
  var interval = 1000;
  var value = -1;




  function convert(input) {
  var parts = input.split(':'),
  hours  =  +parts[0],
  minutes = +parts[1],
  seconds = +parts[2];
  return ( hours * 3600 + minutes * 60 + seconds).toFixed(3);
  }



  var player;
  function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
  height: '390',
  width: '640',
  videoId: '<?php echo $video_id;?>',
  events: {
  'onReady': onPlayerReady,
  'onStateChange': onPlayerStateChange
  }
  });
  }
  
function getDuration() {
  duration = duration_get; //video.duration
  document.getElementById("duration").appendChild(new Text(Math.round(duration)+""));
  console.log("Duration: ", duration);
}


  // Play the video
  function onPlayerReady(event) {
  player.playVideo();
  getDuration();
  myPlayerState = event.data;
  console.log(player.getCurrentTime());
  }


  function onPlayerStateChange(event){

  console.log(player.getCurrentTime());

   //playing
    var label = event.target.ulabel;
    if (event["data"] == YT.PlayerState.PLAYING) {

    timeStarted = new Date().getTime()/1000;

    if (timer !== null) return;
    timer = setInterval(function() {

    if(value>=duration)
    {
    $('#duration').css('color','green');
    $('#change_color').css('color','green');
    }

    $("#played").html(++value);
    }, interval);

    }

  if (event["data"] == YT.PlayerState.PAUSED) {

  if(timeStarted>0) {
  var playedFor = new Date().getTime()/1000 - timeStarted;
  timeStarted = 1;
  // add the new number of seconds played
  timePlayed+=playedFor;

  clearInterval(timer);
  timer = null

  }
  document.getElementById("played").innerHTML = Math.round(timePlayed)+"";


  if(timePlayed>=duration && event.type=="ended" ) {

  var amount ='<?php echo $page_data->reward_amount;?>';
  var video_id ='<?php echo $page_data->page_id;  ?>';
  var video_title ='<?php echo $page_data->page_title;  ?>';

  $.ajax({ 
  type:'post',
  url:'<?php echo base_url();?>user/Rewards/earnings',
  data:{'amount':amount,'video_id':video_id,'video_title':video_title},
  success: function(data)
  {

  if(data=="already_watch")
  {

  }
  if(data=="success")
  {
  $('#copleted').css('display','none');
  $('.publicform').css('display','block');
  startConfetti();
  confetti.maxCount = 200;

  //foraimation
  anime({
  targets: '#messages',
  translateX: ['-100%','0%'],
  delay:1000,
  });
  }
  }
  });

  document.getElementById("status").className="complete";

  }
  else
  {
  if(event.type=="ended")
  {
  alert('Not Completed Dont Skip Videos Try Agin!');
  window.location.reload();
  }
  }


  }

    //stopimg
    if(event.data === 0) {          
  

  if(timePlayed>=duration && event.data===0) {

  var amount ='<?php echo $page_data->reward_amount;?>';
  var video_id ='<?php echo $page_data->page_id;  ?>';
  var video_title ='<?php echo $page_data->page_title;  ?>';

  $.ajax({ 
  type:'post',
  url:'<?php echo base_url();?>user/Rewards/earnings',
  data:{'amount':amount,'video_id':video_id,'video_title':video_title},
  success: function(data)
  {

  if(data=="already_watch")
  {

  }
  if(data=="success")
  {
  $('#copleted').css('display','none');
  $('.publicform').css('display','block');
  startConfetti();
  confetti.maxCount = 200;

  //foraimation
  anime({
  targets: '#messages',
  translateX: ['-100%','0%'],
  delay:1000,
  });
  }
  }
  });

  document.getElementById("status").className="complete";

  }
  else
  {
  if(event.type=="ended")
  {
  alert('Not Completed Dont Skip Videos Try Agin!');
  window.location.reload();
  }
  }

  }


  }


  function stopVideo() {
  console.log(player.getCurrentTime());
  console.log("vidoe time is end");
  player.stopVideo();
  }

  </script>