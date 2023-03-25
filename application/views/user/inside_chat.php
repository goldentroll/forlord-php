

<?php  
if($get_chat_detailss)
{

  foreach ($get_chat_detailss as $key)
  {

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
  <!-- 
  <div class="d-block p-3" style="text-align: right;">
  <small style="font-size: 14px; color:white;margin-left: 10px;margin-right: 11px;display: none;"><?php echo $member->UserName;?></small>
  <img src="<?php echo $image;?>" width="30" height="30" style="border-radius: 50%;margin-right: 111px;display: none;">
  <div class="bg-white mr-2 p-3 inside_chat" style="width: 80%;margin-top: 15px;"><span class="text-muted" style="font-size: 14px!important;"><?php echo  $key->messages;?></span></div>
  </div>
  -->

<?php
}
?>
<?
   }
}
?>



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