
  <head>
  <?php
   ini_set('max_execution_time', 300);
   $this->load->view('user/meta');?>
  <?php $this->load->view('user/index_header');
  ?>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">

  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  </head>


  <link href="<?php echo base_url();?>assets/user/fonts/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/user/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>assets/user/css/feather.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/morris/morris.css">

  <link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset=UTF-8>
  <style type="text/css">
    #emojiPickerWrap {margin:10px 0 0 0;}
    .field { padding: 20px 0; }
    textarea { width: 400px; height: 200px; }
  </style>

<style type="text/css">
 label
 {
  color:white;
  margin-bottom: 10px;
  font-weight: 700;
 }
 .dataTables_info
 {
  color:white;
  margin-bottom: 10px;
  font-weight: 700;
 }
 .full-width {
  width: 100%;
  height: 100vh;
  display: flex;
}
.full-width .justify-content-center {
  display: flex;
  align-self: center;
  width: 100%;
}
.full-width .lead.emoji-picker-container {
  width: 300px;
  display: block;
}
.full-width .lead.emoji-picker-container input {
  width: 100%;
  height: 50px;
}
</style>

  <body class="">
  <div class="wrapper dash-bg">

  <?php $this->load->view('user/user_aside');?>

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
  <h3 class="fw-normal2 text-white"> Mydownlines</h3>
  </div>
  <div class="dash-btn"><span class="text-white text-grad " style="font-size:14px;">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span>  <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div>
  </div>
  </div>
  </div>
  </div>
  <div class="admin-middle">
  <div class="container-fluid">
  <div class="row">

  <div class="col-sm-12">
  <div class="title text-center">

  <?php

  $ucondition = "MemberId='".$recever_id."'";
  $userdetails = $this->common_model->GetRow($ucondition,"arm_members");

  if($userdetails->facebookurl==0 ||$userdetails->facebookurl=="")
  {
  ?>
  <h2 class="text-white fw-bold mb-3 text-uppercase pla"><?php echo ucfirst($userdetails->UserName);?>
 <span class="text-grad" style="font-size: 13px;">Last Seen <?php   echo relativeTime($userdetails->new_entry);?></span></h2>
  <?
  }
  else
  {
  ?>
  <h2 class="text-white fw-bold mb-3 text-uppercase pla"><?php echo ucfirst($userdetails->UserName);?> <span style="background-color: green;
  color: white;
  padding: 5px;
  font-size: 11px;">Online</span></h2>
  <?
  }
  ?>

  </div>
  </div>
  </div>


    <div class="row">
    <div class="col-lg-11">
    <div class="box form-back position-relative z-in1 bord-grad">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');
body{
  background:transparent;
  font-family: 'Roboto', sans-serif;
}
.emojiPicker section h1 {
    clear: both;
    margin: 0;
    padding: 2%;
    color: #444;
    font-size: 14px !important;
    text-transform: capitalize;
}
.emojiPickerIcon{
  height: 50px;
  width: 50px;
  background-color: #fea348 !important;
}
.card{
  width: 300px;
  border: none;
  border-radius: 15px;
}
.adiv{
  background: #04CB28;
  border-radius: 15px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
  font-size: 12px;
  height: 46px;
}
.chat{
  border: none;
  background: #E2FFE8;
  font-size: 10px;
  border-radius: 20px;
}
.bg-white{
  border: 1px solid #E7E7E9;
  font-size: 10px;
  border-radius: 20px;
}
.myvideo img{
  border-radius: 20px
}
.dot{
  font-weight: bold;
}
.form-control{
  border-radius: 12px;
  border: 1px solid #F0F0F0;
  font-size: 8px;
}
.form-control:focus{
  box-shadow: none;
  }
.form-control::placeholder{
  font-size: 8px;
  color: #C4C4C4;
}


#container  {
display: flex;
flex-direction: column;
justify-content: flex-start;
/*padding: 1rem;
height: 50vh;
background: #00000047;
border-radius: .6rem;
overflow: auto;*/
}

/*.card
{
  width: 100%;
}
#container
{
  width: 100%;
}
#input-custom-size
{
  width: 100%;
}*/
.emojiPickerIconWrap
{
  width: 100% !important;
}
.emojiable-option
{
  width: 100% !important;
}
.container
{
  margin:0px !important;
  padding:0px !important;
}
</style>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

<div class="container d-flex justify-content-center">
  <div class="card mt-5" style="background:transparent !important;width: 100%;">

<div class="container" id="container" style="overflow-y:auto;height: 280px;width: 100%">
<div id="inside_chat">
  <?php  
if($get_chat_detailss)
{

$i=0;
  foreach ($get_chat_detailss as $key)
  {

  $i++;
?>
<?php 
if($key->sender_id==$sender_id && $key->recever_id==$recever_id)
{
  $member = $this->common_model->GetCustomer($key->sender_id);

    if($member->ProfileImage)
    {
    $image = base_url().$member->ProfileImage;
    }
    else
    { 
    $image = 'https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png';
    }

?>
      <div class="d-block p-3 "  data-from="<?php echo $member->UserName; ?>" data-id="<?php echo $i; ?>">
        <img src="<?php echo $image;?>" width="30" height="30" style="border-radius: 50%;display: none;"><small style="font-size: 14px; color:white;margin-left: 10px; display: none;"  > <?php echo $member->UserName;?></small>

        <div class="chat ml-2 p-3" style="width: 80%;font-size: 14px!important;margin-top: 12px;"><?php echo $key->messages;?></div>
      </div>

<?
}
?>

<?php 
if($key->sender_id == $recever_id && $key->recever_id == $sender_id)
{


    $member = $this->common_model->GetCustomer($key->sender_id);

    if($member->ProfileImage)
    {
    $image = base_url().$member->ProfileImage;
    }
    else
    {
    $image = 'https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png';
    }
?>
      <div class="d-block p-3" style="text-align: right;"  data-from="<?php echo $member->UserName; ?>" data-id="<?php echo $i; ?>">
        

       
        <small style="font-size: 14px; color:white;margin-left: 10px;margin-right: 11px;"><?php echo $member->UserName;?></small>
         <img src="<?php echo $image;?>" width="30" height="30" style="border-radius: 50%;margin-right: 111px;">

        <div class="bg-white mr-2 p-3 inside_chat" style="width: 80%;margin-top: 15px;"><span class="text-muted" style="font-size: 14px!important;"><?php echo  $key->messages;?></span></div>
      </div>

<?php
}
?>
<?
   }
}
?>

</div>
</div>

      <div class="form-group px-3" style="font-size: 16px;">
      </div>


<div class="col-lg-12">
    <div class="field">
      <input type="text" id="input-custom-size" id="message"  class="emojiable-option" placeholder="Send Message" style="width: 100%;height: 100px;">
    </div>
</div>

      <input type="button" id="send_message" value="Send" class="btn btn-primary">
  </div>
</div>

</div>
</div>
</div>
<div class="text-center">
<?php $this->load->view('user/login_footer');?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/styl/css/emoji/jquery.emojipicker.css">
 
  <!-- Emoji Data -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/styl/css/emoji/jquery.emojipicker.tw.css">
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.emojis.js"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.emojipicker.js"></script>


 <script type="text/javascript">
    $(document).ready(function(e) {


var div = $('#inside_chat'),
divHtml = div.html();
div.html(divHtml);
console.log("test");


$('#inside_chat')
.scrollTop($('#inside_chat')[0]
.scrollHeight - $(
'#inside_chat')[0].clientHeight);
const a = document.getElementById(
'inside_chat');
a.style.cursor = 'grab';
let p = {
top: 0,
left: 0,
x: 0,
y: 0
};


      $('#input-default').emojiPicker();

      $('#input-custom-size').emojiPicker({
        width: '300px',
        height: '200px'
      });

      $('#input-left-position').emojiPicker({
        position: 'left'
      });

      $('#create').click(function(e) {
        e.preventDefault();
        $('#text-custom-trigger').emojiPicker({
          width: '300px',
          height: '200px',
          button: false
        });
      });

      $('#toggle').click(function(e) {
        e.preventDefault();
        $('#text-custom-trigger').emojiPicker('toggle');
      });

      $('#destroy').click(function(e) {
        e.preventDefault();
        $('#text-custom-trigger').emojiPicker('destroy');
      })

      // keyup event is fired
      $(".emojiable-question, .emojiable-option").on("keyup", function () {
        //console.log("emoji added, input val() is: " + $(this).val());
      });

    });
  </script>

<script type="text/javascript">

   // $("#container").animate({ scrollTop: $('#inside_chat').prop("scrollHeight")}, 1000);

  $('#send_message').on('click',function(){
   var send_messages = $('#input-custom-size').val();

   var sender_id =  '<?php echo $sender_id;?>';
   var recever_id =  '<?php echo $recever_id;?>';
   if(send_messages!="")
   {

  $.ajax({
  type: 'post',
  url:'<?php echo base_url();?>user/Chat/message_insert/',
  data:{sender_id:sender_id,recever_id:recever_id,send_messages:send_messages},
  success : function()
  {
  $('#input-custom-size').val("");

  $.ajax({
  type: 'post',
  url:'<?php echo base_url();?>user/Chat/view_message/'+recever_id,
  data:{sender_id:sender_id,recever_id:recever_id},
  success : function(meg)
  {
   $('#inside_chat').html(meg);
   $('#new_msg').val('1');
  $("#container").animate({ scrollTop: $('#inside_chat').prop("scrollHeight")}, 1000);
  messages = document.getElementById('container');
  console.log(messages);
  }
  });

  }
  });

   }

  });

const messages = document.getElementById('container');

function appendMessage() {
  const message = document.getElementById('inside_chat')[0];
  const newMessage = message.cloneNode(true);
  messages.appendChild(newMessage);
}

function getMessages() {
  // Prior to getting your messages.
  shouldScroll = messages.scrollTop + messages.clientHeight === messages.scrollHeight;
  /*
   * Get your messages, we'll just simulate it by appending a new one syncronously.
   */
  appendMessage();
  // After getting your messages.
  if (!shouldScroll) {
    scrollToBottom();
  }
}

function scrollToBottom() {
     $("#container").animate({ scrollTop: $('#inside_chat').prop("scrollHeight")}, 3000);
  //messages.scrollTop = messages.scrollHeight;
}


  setInterval(function() 
  { 
  
  var new_mesg =  $('#new_msg').val();
  var sender_id =  '<?php echo $sender_id;?>';
  var recever_id =  '<?php echo $recever_id;?>';

  $.ajax({
  type: 'post',
  url:'<?php echo base_url();?>user/Chat/get_count/'+recever_id,
  data:{sender_id:sender_id,recever_id:recever_id},
  success : function(megs)
  {
     if(megs>0)
     {
        scrollToBottom();
  $.ajax({
  type: 'post',
  url:'<?php echo base_url();?>user/Chat/message_off/'+recever_id,
  data:{sender_id:sender_id,recever_id:recever_id},
  success : function(megs)
  {
  }
  });

     }
  }
  });


  $.ajax({
  type: 'post',
  url:'<?php echo base_url();?>user/Chat/view_message/'+recever_id,
  data:{sender_id:sender_id,recever_id:recever_id},
  success : function(meg)
  {
  $('#inside_chat').html(meg);
  var elem = $('.bg-white');
  }
  });

  // alert(new_mesg);

if(parseFloat(new_mesg)==1)
{
     // alert(new_mesg);
     scrollToBottom();
     $('#new_msg').val(0);
}

  }, 
  6000);


$( document ).ready(function() {
setTimeout(scrollToBottom, 7000);

});

// var objDiv = document.getElementById("container");
// objDiv.scrollTop = objDiv.scrollHeight;
</script>


<Script>
   document.addEventListener(
  'DOMContentLoaded',
  function()
  {

    $('#container')
    .scrollTop($('#container')[0]
    .scrollHeight - $(
    '#container')[0].clientHeight);
    const a = document.getElementById(
    'container');
    a.style.cursor = 'grab';
    let p = {
    top: 0,
    left: 0,
    x: 0,
    y: 0
    };
    const mouseDownHandler = function(
      e)
    {
      a.style.cursor = 'grabbing';
      a.style.userSelect = 'none';
      p = {
        left: a.scrollLeft,
        top: a.scrollTop,
        x: e.clientX,
        y: e.clientY,
      };
      document.addEventListener(
        'mousemove',
        mouseMoveHandler);
      document.addEventListener(
        'mouseup', mouseUpHandler);
    };
    const mouseMoveHandler = function(
      e)
    {
      const dx = e.clientX - p.x;
      const dy = e.clientY - p.y;
      a.scrollTop = p.top - dy;
      a.scrollLeft = p.left - dx;
    };
    const mouseUpHandler = function()
    {
      a.style.cursor = 'grab';
      a.style.removeProperty(
        'user-select');
      document.removeEventListener(
        'mousemove',
        mouseMoveHandler);
      document.removeEventListener(
        'mouseup', mouseUpHandler);
    };
    a.addEventListener('mousedown',
      mouseDownHandler);
  });
   </Script>

   <?
function relativeTime($times, $short = false){

  $SECOND = 1;
  $MINUTE = 60 * $SECOND;
  $HOUR = 60 * $MINUTE;
  $DAY = 24 * $HOUR;
  $MONTH = 30 * $DAY;
  $time = strtotime($times); 
  $before = time() - $time;


  if ($before < 0)
  {
  return "not yet";
  }

  if ($times == "")
  {
  return "not yet";
  }

  if ($short){
  if ($before < 1 * $MINUTE)
  {
  return ($before <5) ? "just now" : $before . " ago";
  }

  if ($before < 2 * $MINUTE)
  {
  return "1m ago";
  }

  if ($before < 45 * $MINUTE)
  {
  return floor($before / 60) . "m ago";
  }

  if ($before < 90 * $MINUTE)
  {
  return "1h ago";
  }

  if ($before < 24 * $HOUR)
  {

  return floor($before / 60 / 60). "h ago";
  }

  if ($before < 48 * $HOUR)
  {
  return "1d ago";
  }

  if ($before < 30 * $DAY)
  {
  return floor($before / 60 / 60 / 24) . "d ago";
  }


  if ($before < 12 * $MONTH)
  {
  $months = floor($before / 60 / 60 / 24 / 30);
  return $months <= 1 ? "1mo ago" : $months . "mo ago";
  }
  else
  {
  $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
  return $years <= 1 ? "1y ago" : $years."y ago";
  }
  }

  if ($before < 1 * $MINUTE)
  {
  return ($before <= 1) ? "just now" : $before . " seconds ago";
  }

  if ($before < 2 * $MINUTE)
  {
  return "a minute ago";
  }

  if ($before < 45 * $MINUTE)
  {
  return floor($before / 60) . " minutes ago";
  }

  if ($before < 90 * $MINUTE)
  {
  return "an hour ago";
  }

  if ($before < 24 * $HOUR)
  {

  return (floor($before / 60 / 60) == 1 ? 'about an hour' : floor($before / 60 / 60).' hours'). " ago";
  }

  if ($before < 48 * $HOUR)
  {
  return "yesterday";
  }

  if ($before < 30 * $DAY)
  {
  return floor($before / 60 / 60 / 24) . " days ago";
  }

  if ($before < 12 * $MONTH)
  {

  $months = floor($before / 60 / 60 / 24 / 30);
  return $months <= 1 ? "one month ago" : $months . " months ago";
  }
  else
  {
  $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
  return $years <= 1 ? "one year ago" : $years." years ago";
  }

  return "$time";
  }


   ?>