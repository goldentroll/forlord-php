  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!------ Include the above in your HEAD tag ---------->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset=UTF-8>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


  <?php
   ini_set('max_execution_time', 0);
   $this->load->view('user/meta');?>
  <?php $this->load->view('user/index_header');
  ?>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">

  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">


  <link href="<?php echo base_url();?>assets/user/fonts/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/user/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>assets/user/css/feather.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/morris/morris.css">

  <link rel="stylesheet" href="<?php echo base_url();?>assets/user/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>


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
.emojiPicker section h1 {
    clear: both;
    margin: 0;
    padding: 2%;
    color: #444;
    font-size: 14px !important;
    text-transform: capitalize;
}
.emojiPickerIcon{
  background-color: #fea348 !important;
  height: 33px !important;
  width: 33px !important;
  background-color: rgb(238, 238, 238);
  position: absolute;
  left: -35px;
  border-radius: 50%;
  top: 10px !important;
}
.emojiPicker
{
  width: 300px;
  height: 200px;
  z-index: 10000;
  top: 681px;
  left: 200px !important;
  display: block;
}

 @media only screen and (max-width:767px) {

.emojiPicker
{
  width: 300px;
  height: 200px;
  z-index: 10000;
  top: 681px;
  left: 0px !important;
  display: block;
}


.emojiPickerIcon
{
  background-color: #fea348 !important;
    height: 38px !important;
    width: 39px !important;
    background-color: rgb(238, 238, 238);
    position: absolute;
    left: -5px;
    border-radius: 50%;
    top: -37px !important;

}


}

#inside_chat
{
  background-image:url("<?php echo base_url();?>assets/styl/images/whats_image.jpeg") !important;
}

.tox-tinymce--toolbar-bottom
{
  width: 90% !important;
  height: 53px !important;
}

.tox .tox-editor-container {
    display: inline-flex;
    flex: 1 1 auto;
    flex-direction: row-reverse !important;
    overflow: hidden;
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

<?php $this->load->view('user/chat_style');?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
  <!--Coded With Love By Mutiullah Samim-->
    <div class="container-fluid h-100">
      <div class="row justify-content-center h-100">

        <div class="col-md-8 col-xl-12 chat">
          <div class="card" style="background: linear-gradient(135deg, #5937ea 0%,#ef5caf 48%,#fea348 100%);;min-height: 55pc;">
            <div class="card-header msg_head">
              <div class="d-flex bd-highlight">

<?php


  $ucondition = "MemberId='".$recever_id."'";
  $userdetails = $this->common_model->GetRow($ucondition,"arm_members");

  if($userdetails->ProfileImage)
  {
  $image = base_url().$userdetails->ProfileImage;
  }
  else
  {
  $image = 'https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg';
  }
?>
                <div class="img_cont">
                  <img src="<?php echo $image; ?>" class="rounded-circle user_img">
                  <span class="online_icon"></span>
                </div>

                <div class="user_info">
                  <span>Chat with <?php echo ucfirst($userdetails->UserName);?></span>

<?php
if($userdetails->facebookurl==0 ||$userdetails->facebookurl=="")
{
?>
<p style="display: flex">Last Seen <?php   echo relativeTime($userdetails->new_entry);?></p>
<?php
}
else
{
?>   
<p style="display: flex">Active</p>
<?php 
}
?>               
            </div>
               
              </div>
              <span id="action_menu_btn" style="display: none;"><i class="fas fa-ellipsis-v"></i></span>
              <div class="action_menu" style="display: none;">
                <ul>
                  <li><i class="fas fa-user-circle"></i> View profile</li>
                  <li><i class="fas fa-users"></i> Add to close friends</li>
                  <li><i class="fas fa-plus"></i> Add to group</li>
                  <li><i class="fas fa-ban"></i> Block</li>
                </ul>
              </div>
            </div>


            <div class="card-body msg_card_body" id="inside_chat">

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
              <div class="d-flex justify-content-end mb-4">
                <div class="msg_cotainer_send">
                  <?php echo strip_tags($key->messages);?>
                  <span class="msg_time"></span>
                </div>
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
              <div class="d-flex justify-content-start mb-4">
                <div class="msg_cotainer">
                 <?php echo  strip_tags($key->messages);?>
                  <span class="msg_time_send"></span>
                </div>
              </div>

<?php
}
?>
<?
   }
}
?>

            </div>
            <div class="card-footer">
              <div class="input-group">
                <div class="input-group-append">
                
                </div>

              <textarea name="" class="form-control type_msg emojiable-option"  id="input-custom-size"  placeholder="Type your message..."></textarea> 




                <div class="input-group-append">
                  <span class="input-group-text send_btn"  id="send_message"  ><i class="fas fa-location-arrow"></i></span>
                </div>
              </div>
            </div>
          </div>
        </div>
              
      </div>
    </div>
  </body>

</div>
</div>
</div>
<div class="text-center">
<?php $this->load->view('user/login_footer');?>
</div>

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


 <!--  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/styl/css/emoji/jquery.emojipicker.css"> -->

  <!-- Emoji Data -->
  <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/styl/css/emoji/jquery.emojipicker.tw.css">
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.emojis.js"></script>
 -->

 <!--  <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.emojipicker.js"></script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdn.tiny.cloud/1/j59jylozzepqtpjx6zyg4zm1db1xdc83ydtig3pasn9p96i9/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<!-- 
<script type="text/javascript" src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/6/tinymce.min.js"></script> -->

<script >
  $(document).ready(function(){
$('#action_menu_btn').click(function(){
$('.action_menu').toggle();
});
});

tinymce.init({
  selector: "#input-custom-size",
  plugins: "emoticons autoresize",
  toolbar: "emoticons",
  toolbar_location: "bottom",
  menubar: false,
  statusbar: false
});


</script>


 <script type="text/javascript">


  $(document).ready(function() {
  
  // $('#input-default').emojiPicker();

  // $('#input-custom-size').emojiPicker({
  // width: '300px',
  // height: '200px'
  // });

  // $('#input-left-position').emojiPicker({
  // position: 'left'
  // });

  // $('#create').click(function(e) {
  // e.preventDefault();
  // $('#text-custom-trigger').emojiPicker({
  // width: '300px',
  // height: '200px',
  // button: false
  // });
  // });

  // $('#toggle').click(function(e) {
  // e.preventDefault();
  // $('#text-custom-trigger').emojiPicker('toggle');
  // });

  // $('#destroy').click(function(e) {
  // e.preventDefault();
  // $('#text-custom-trigger').emojiPicker('destroy');
  // })

  // // keyup event is fired
  // $(".emojiable-question, .emojiable-option").on("keyup", function () {
  // //console.log("emoji added, input val() is: " + $(this).val());
  // });

});


    $(document).ready(function(e) {



var div = $('#inside_chat'),
divHtml = div.html();
div.html(divHtml);


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





    });
  </script>

<script type="text/javascript">

   // $("#container").animate({ scrollTop: $('#inside_chat').prop("scrollHeight")}, 1000);

  $('#send_message').on('click',function(){

    tinymce.triggerSave();

   var send_messages = $('#input-custom-size').val();

   var sender_id =  '<?php echo $sender_id;?>';
   var recever_id =  '<?php echo $recever_id;?>';
   if(send_messages!="")
   {

    tinymce.get('input-custom-size').setContent(''); 

  $.ajax({
  type: 'post',
  url:'<?php echo base_url();?>user/Chat/message_insert/',
  data:{sender_id:sender_id,recever_id:recever_id,send_messages:send_messages},
  success : function()
  {

  $(".msg_card_body").animate({
  scrollTop: $(
  '.msg_card_body').get(0).scrollHeight
  }, 500);

   
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
$(".msg_card_body").animate({
scrollTop: $(
'.msg_card_body').get(0).scrollHeight
}, 1000);
   //  $("#container").animate({ scrollTop: $('#inside_chat').prop("scrollHeight")}, 3000);
  //messages.scrollTop = messages.scrollHeight;
}


  setInterval(function() 
  { 
  
  var new_mesg =  $('#new_msg').val();

  var sender_id =  '<?php echo $sender_id;?>';
  var recever_id =  '<?php echo $recever_id;?>';


 $.ajax({
  type: 'post',
  url:'<?php echo base_url();?>user/Chat/get_count_1/'+recever_id,
  data:{sender_id:sender_id,recever_id:recever_id},
  success : function(megs)
  {

  if(megs>0)
  {
  scrollToBottom();
  }
  }
});

  $.ajax({
  type: 'post',
  url:'<?php echo base_url();?>user/Chat/get_count/'+recever_id,
  data:{sender_id:sender_id,recever_id:recever_id},
  success : function(megs)
  {
  if(megs>0)
  {
        //scrollToBottom();
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


