    <!DOCTYPE html>
    <html>

    <head>
    <!--  Meta and Title  -->
    <?php $this->load->view('admin/meta');?>

    <!--  Fonts  -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

    <!--  CSS - allcp forms  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/allcp/forms/css/forms.css">

    <!--  CSS - theme  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/skin/default_skin/css/theme.css">

    <style type="text/css">
    p
    {
    color: red;
    }
    em
    {
    color: #de888a !important;
    }
    </style>

    </head>

    <body class="sales-stats-page">

    <!--  Customizer  -->
    <?php $this->load->view('admin/customizer');?>
    <!--  /Customizer  -->

    <!--  Body Wrap   -->
    <div id="main">


    <!--  Header   -->
    <?php $this->load->view('admin/topnav');?>
    <!--  /Header   -->

    <!--  Sidebar   -->
    <?php $this->load->view('admin/sidebar');?>

    <!--  Main Wrapper  -->
    <section id="content_wrapper">

    <!--  Topbar Menu Wrapper  -->
    <?php $this->load->view('admin/toper'); ?>
    <!--  Content  -->
    <section id="content" class="table-layout animated fadeIn">



    <!--  Column Center  -->
    <div class="chute chute-center">

    <div class="mw1000 center-block">

    <!--  General Information  -->
    <div class="panel mb35">
    <form method="post" action="" id="allcp-form" enctype="multipart/form-data">
    <div class="panel-heading">
    <span class="panel-title">Add Rank Setting</span>

    <span class="allcp-form"><a class="btn btn-primary pull-right" title="" data-toggle="tooltip" href="<?php echo base_url();?>admin/ranksetting" data-original-title="Back"><i class="fa fa-close"></i></a></span>
    </div>

    <div class="section row mbn">
    <?php if($this->session->flashdata('error_message')) { ?>    
    <div class="col-md-12 bg-danger pt10 pb10 mt10 mb20">
    <span class=""><?php echo $this->session->flashdata('error_message');?></span>
    </div>
    <?php unset($_SESSION['error_message']); } ?>

    <?php if($this->session->flashdata('success_message')) { ?>    
    <div class="col-md-12 bg-success pt10 pb10 mt10 mb20">
    <span class=""><?php echo $this->session->flashdata('success_message');?></span>
    </div>
    <?php unset($_SESSION['success_message']); } ?>

    </div>

    <div class="panel-body br-t">

    <div class="allcp-form theme-primary">

    <div class="section row mb10" style="display: none;">
    <label for="rewardrank" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords("Target For Reach Rank"); ?></label>

    <div class="col-sm-7 ph10">
    <label for="rewardrank" class="field select">
    <select name="targetcon" id="targetcon" onchange="getcon(this.value);"> 
    <option value="">Select Condition</option>
    <option value="1"><?php echo "Target Downline Count";?></option>
    <option value="2"><?php echo "Target ReferalMember Count";?></option>
    <option value="3"><?php echo "Target balance Amount";?></option>
    <?php
    $matrixsettings = $this->db->query("select * from arm_matrixsetting where MatrixStatus='1'")->row();

    $id = $matrixsettings->Id;

    if($id=="2")
    {?>

    <option value="4"><?php echo "Target total Pv & Gv count";?></option>

    <?}
    if($id=="4")
    {?>

    <option value="5"><?php echo "Target total Left and right down count";?></option>
    <option value="6"><?php echo "Target total Left and right Package Fees";?></option>

    <?}?>

    </select>
    <i class="arrow double"></i>

    </label>


    </div>
    </div>


    <div class="section row mb10"  id="rankcount">
    <label for="Rank" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords($this->lang->line('rank')); ?> <small class="text-danger">*</small></label>

    <div class="col-sm-7 ph10">
    <label for="Rank" class="field prepend-icon">
    <input type="text" name="rank" id="Rank" placeholder="<?php echo  ucwords($this->lang->line('rank')); ?>"
    class="gui-input" value="<?php echo set_value('Rank', isset($this->data['fielddata']->Rank) ? $this->data['fielddata']->Rank : '');?>" >
    <label for="Rank" class="field-icon">
    <i class="fa fa-info"></i>
    </label>
    </label>
     <?php echo form_error('rank');?>
    </div>
    </div>

    <div class="section row mb10" id="min_pack_inves">
    <label for="min_pack_inves" class="field-label col-sm-3 ph10  text-left">Min package investment <small class="text-danger">*</small></label>

    <div class="col-sm-7 ph10">
    <label for="min_pack_inves" class="field prepend-icon">
    <input type="text" name="min_pack_inves" id="min_pack_inves" placeholder="<?php echo  ucwords("Min package investment"); ?>"
    class="gui-input" value="<?php echo set_value('min_pack_inves', isset($this->data['fielddata']->min_pack_inves) ? $this->data['fielddata']->min_pack_inves : '');?>" >
    <label for="min_pack_inves" class="field-icon">
    <i class="fa fa-info"></i>
    </label>
    </label>
    <?php echo form_error('min_pack_inves');?>
    </div>
    </div>

    <div class="section row mb10" id="min_pack_inves">
    <label for="min_pack_inves" class="field-label col-sm-3 ph10  text-left">Current Level</label>

    <div class="col-sm-7 ph10">
    <label for="rewardrank" class="field select">
    <select name="current_lev" id="current_lev"> 
    <option value="0">Select Level</option>
    <?php
    $get_all_ran = $this->db->query("select * from arm_ranksetting where Status='1'")->result();
    if($get_all_ran)
    {
    foreach ($get_all_ran as $key) {
    ?>
    <option value="<?php echo $key->rank_id; ?>"><?php echo $key->Rank; ?></option>
    <?
    }
    }
    ?>
    </select>
    </label>
    </div>

    </div>

     <div class="section row mb10" id="min_pack_inves">
    <label for="min_pack_inves" class="field-label col-sm-3 ph10  text-left">Eligible for earnings <small class="text-danger">*</small></label>

    <div class="col-sm-7 ph10">
    <label for="elig_earn" class="field prepend-icon">
    <input type="text" name="elig_earn" id="elig_earn" placeholder="Eligible for earnings"
    class="gui-input" value="<?php echo set_value('elig_earn', isset($this->data['fielddata']->elig_earn) ? $this->data['fielddata']->elig_earn : '');?>" >
    <label for="elig_earn" class="field-icon">
    <i class="fa fa-info"></i>
    </label>
    </label>
    <?php echo form_error('elig_earn');?>
    </div>
    
    </div>




    <div class="section row mb10" id="min_pack_inves">
    <label for="min_pack_inves" class="field-label col-sm-3 ph10  text-left">Bonus Type<small class="text-danger">*</small></label>

    <div class="col-sm-7 ph10">
    <select name="bonus_type" id="bonus_type" class="form-control" required="">
    <option value="">--Select--</option>
    <option value="1" selected="">Cash</option>
    <option value="2">Non Cash</option>
    </select>
    <?php echo form_error('bonus_type');?>
    </div>

    </div>


    <div class="section row mb10" id="textarea" style="display: none;">
    <label for="min_pack_inves" class="field-label col-sm-3 ph10  text-left">Non Cash<small class="text-danger">*</small></label>

    <div class="col-sm-7 ph10">
    <textarea name="non_cash" class="form-control">
    </textarea>
    <?php echo form_error('non_cash');?>
    </div>

    </div>


<div class="section row mb10"  id="rankcount">
<label for="Rank" class="field-label col-sm-3 ph10  text-left"><?php echo  "Rank Reward as Coin"; ?> <small class="text-danger">*</small></label>

<div class="col-sm-7 ph10">
<label for="Rank" class="field prepend-icon">
<input type="text" name="rank_reward" id="rank_reward" placeholder="<?php echo  "Rank-Reward"; ?>"
class="gui-input" value="<?php echo set_value('rank_reward', isset($this->data['fielddata']->rank_reward) ? $this->data['fielddata']->rank_reward : '');?>" >
<label for="Rank" class="field-icon">
<i class="fa fa-info"></i>
</label>
</label>
<?php echo form_error('rank_reward');?>
</div>
</div>





    <div class="section row mb10" id="min_pack_inves">
    <label for="min_pack_inves" class="field-label col-sm-3 ph10  text-left">Bonus amount <small class="text-danger">*</small></label>

    <div class="col-sm-7 ph10">
    <label for="bonus_amt" class="field prepend-icon">
    <input type="text" name="bonus_amt" id="bonus_amt" placeholder="Bonus amount"
    class="gui-input" value="<?php echo set_value('bonus_amt', isset($this->data['fielddata']->bonus_amt) ? $this->data['fielddata']->bonus_amt : '');?>" >
    <label for="bonus_amt" class="field-icon">
    <i class="fa fa-info"></i>
    </label>
    </label>
    <?php echo form_error('bonus_amt');?>
    </div>
    </div>



    <div class="section row mb10" style="display: none;" id="downcount">
    <label for="rewardrank" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords($this->lang->line('downlinecount')); ?></label>

    <div class="col-sm-7 ph10">
    <label for="rewardrank" class="field prepend-icon">
    <input type="text" name="downlinemembercount" id="rewardrank" placeholder="<?php echo  ucwords($this->lang->line('downlinecount')); ?>"
    class="gui-input" value="<?php echo set_value('rewardrank', isset($this->data['fielddata']->Membercount) ? $this->data['fielddata']->Membercount : '');?>" >
    <label for="rewardrank" class="field-icon">
    <i class="fa fa-info"></i>
    </label>
    </label>
    <?php echo form_error('downlinemembercount');?>


    </div>
    </div>

    <div class="section row mb10" style="display: none;" id="refcount">
    <label for="referalcount" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords($this->lang->line('referalcount')); ?></label>

    <div class="col-sm-7 ph10">
    <label for="rewardpoint" class="field prepend-icon">
    <input type="text" name="referalcount" id="rewardpoint" placeholder="<?php echo  ucwords($this->lang->line('referalcount')); ?>"
    class="gui-input" value="<?php echo set_value('rewardpoint', isset($this->data['fielddata']->points) ? $this->data['fielddata']->points : '');?>" >
    <label for="rewardpoint" class="field-icon">
    <i class="fa fa-info"></i>
    </label>
    </label>
    <?php echo form_error('referalCount');?> 


    </div>
    </div>

    <div class="section row mb10" style="display: none;" id="balcount">
    <label for="rewardpoint" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords($this->lang->line('balanceamount')); ?></label>

    <div class="col-sm-7 ph10">
    <label for="rewardpoint" class="field prepend-icon">
    <input type="text" name="targetbalance" id="balanceamount" placeholder="<?php echo  ucwords($this->lang->line('balanceamount')); ?>"
    class="gui-input" value="<?php echo set_value('rewardpoint', isset($this->data['fielddata']->points) ? $this->data['fielddata']->points : '');?>" >
    <label for="rewardpoint" class="field-icon">
    <i class="fa fa-money"></i>
    </label>
    </label>
    <?php echo form_error('targetBalance');?> 


    </div>
    </div>

    <?php

    $matrixsettings = $this->db->query("select * from arm_matrixsetting where MatrixStatus='1'")->row();

    $id = $matrixsettings->Id;

    if($id=="2")
    {?>

    <div class="section row mb10" style="display: none;" id="pvcount">
    <label for="rewardpoint" class="field-label col-sm-3 ph10  text-left">Target PV  & GV  Value</label>

    <div class="col-sm-7 ph10">
    <label for="rewardpoint" class="field prepend-icon">
    <input type="text" name="targetpv" id="targetpv" placeholder="<?php echo  "Target PV  & GV  Value"; ?>"
    class="gui-input" value="<?php echo set_value('rewardpoint', isset($this->data['fielddata']->target_point) ? $this->data['fielddata']->target_point : '');?>" >
    <p style="color: red">Put the total Target point for pv & gv eg: pv = 3 and gv = 3 means put 6</p>
    <label for="rewardpoint" class="field-icon">
    <i class="fa fa-money"></i>
    </label>
    </label>
    <?php echo form_error('targetpv');?> 


    </div>
    </div>


    <div id="commission">
    <div class="section row mb10" id="levelcommissiondivp">
    <label for="levelcommission" class="field-label col-sm-4 ph10  text-left"><?php echo  ucwords($this->lang->line('levelcommission')); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>
    <div class="col-sm-3 ph10">

    <input type='button' value='+' id='addlvlButton'  class="btn btn-bordered btn-primary"  />
    <input type='button' value='-' id='removelvlButton' class="btn btn-bordered btn-primary" />
    </div>  
    <?php echo form_error('levelcommission');?>
    </div>

    <div class="section row mb10" id="levelcommissiondivp">


    <label for="levelcommission" class="field-label col-sm-3 ph10 md10">

    </label>
    <div class="col-sm-7 ph10 md10 " >

    <input type="text" name="levelcommission[]" id="levelcommission[]" placeholder="<?php echo  ucwords($this->lang->line('level'));echo" 1 ".  ucwords($this->lang->line('comamount')); ?>"
    class="gui-input" value="" >

    </div>

    </div>

    <div class="section row mb10" id="levelcommissiondiv">
    <div class="col-sm-7 ph10"></div>
    <label for="levelcommission" class="field prepend-icon col-sm-5 ">

    </label>

    </div>
    </div>

    <?}?>

    <?php

    if($id=="4")
    {?>
    <div class="section row mb10" style="display: none;" id="leftcount">
    <label for="rewardpoint" class="field-label col-sm-3 ph10  text-left">Target Total Left Down member count</label>

    <div class="col-sm-7 ph10">
    <label for="rewardpoint" class="field prepend-icon">
    <input type="text" name="targetcount" id="targetcount" placeholder="<?php echo  "Target Total Left And Right count"; ?>"
    class="gui-input" value="<?php echo set_value('rewardpoint', isset($this->data['fielddata']->target_count) ? $this->data['fielddata']->target_count : '');?>" >
    <p style="color: red">Put the Total Left count value</p>
    <label for="rewardpoint" class="field-icon">
    <i class="fa fa-money"></i>
    </label>
    </label>
    <!-- <?php echo form_error('targetpv');?>  -->


    </div>
    </div>

    <div class="section row mb10" style="display: none;" id="rightcount">
    <label for="rewardpoint" class="field-label col-sm-3 ph10  text-left">Target Total Right Down member count</label>

    <div class="col-sm-7 ph10">
    <label for="rewardpoint" class="field prepend-icon">
    <input type="text" name="rightcounts" id="rightcounts" placeholder="<?php echo  "Target Total Left And Right count"; ?>"
    class="gui-input" value="<?php echo set_value('rewardpoint', isset($this->data['fielddata']->rightcount) ? $this->data['fielddata']->rightcount : '');?>" >
    <p style="color: red">Put the Total right count value</p>
    <label for="rewardpoint" class="field-icon">
    <i class="fa fa-money"></i>
    </label>
    </label>
    <!-- <?php echo form_error('targetpv');?>  -->


    </div>
    </div>

    <div class="section row mb10" style="display: none;" id="totalpackage">
    <label for="rewardpoint" class="field-label col-sm-3 ph10  text-left">Target Total Left and right Package fee</label>

    <div class="col-sm-7 ph10">
    <label for="rewardpoint" class="field prepend-icon">
    <input type="text" name="target_packagefee" id="target_packagefees" placeholder="<?php echo  "Target Total Left And Right Package Fees"; ?>"
    class="gui-input" value="<?php echo set_value('rewardpoint', isset($this->data['fielddata']->target_packagefee) ? $this->data['fielddata']->target_packagefee : '');?>" >
    <p style="color: red">Put the Total Left and right Package Fees</p>
    <label for="rewardpoint" class="field-icon">
    <i class="fa fa-money"></i>
    </label>
    </label>
    <!-- <?php echo form_error('targetpv');?>  -->


    </div>
    </div>

    <?}

    ?>



    <div class="section row mb10" style="display: none;" id="statuscount">
    <label for="sitestatus"
    class="field-label col-sm-3 ph10 text-left"><?php echo  ucwords($this->lang->line('status')); ?></label>

    <div class="col-sm-8 ph10">


    <div class="option-group field">
    <label class="col-md-3 block mt15 option option-primary">

    <input type="radio" <?php if(isset($this->data['fielddata']->Status)==1){echo "checked='checked'";}else{echo "";}?> value='1' name="status">
    <span class="radio"></span>
    <?php echo  ucwords($this->lang->line('on'))?>
    </label>

    <label class="col-md-3 block mt15 option option-primary">
    <input type="radio" <?php if(isset($this->data['fielddata']->Status)==0){echo "checked='checked'";}else{echo "";}?> value='0' name="status">
    <span class="radio"></span>
    <?php echo  ucwords($this->lang->line('off'))?>
    </label>
    </div>
    <label for="sitestatus" class="field-icon">

    </label>
    <!--  <?php echo ucwords(form_error('sitestatus')); ?> -->
    </div>
    </div>

    <div class="panel-footer text-right">

    <button type="submit" class="btn btn-bordered btn-primary"><?php echo  ucwords($this->lang->line('submit')); ?></button>
    </div>

    </div>
    </div>
    </form>
    </div> <!-- panel md35 ends-->
    </div>
    </div>
    <!--  /Column Center  -->

    </section>
    <!--  /Content  -->

    </section>

    <!--  Sidebar Right  -->
    <?php $this->load->view('admin/sidebar_right');?>
    <!--  /Sidebar Right  -->

    </div>
    <!--  /Body Wrap   -->

    <!--  Scripts  -->
    <?php $this->load->view('admin/footer');?>


    <!--  FileUpload JS  -->
    <script src="<?php echo base_url();?>assets/js/plugins/fileupload/fileupload.js"></script>
    <script src="<?php echo base_url();?>assets/js/plugins/holder/holder.min.js"></script>

    <script src="<?php echo base_url();?>assets/allcp/forms/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url();?>assets/allcp/forms/js/additional-methods.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/plugins/tagsinput/tagsinput.min.js"></script>

    <script type="text/javascript">

    function getcon(str) 
    {
    var cond = str;

    if(cond == "1")
    {
    $('#downcount').css("display","block");
    $('#rankcount').css("display","block");
    $('#statuscount').css("display","block");
    $('#pvcount').css("display","none");
    $('#refcount').css("display","none");
    $('#balcount').css("display","none");
    $('#commission').css("display","none");
    $('#rightcount').css("display","none");
    $('#leftcount').css("display","none");
    $('#totalpackage').css("display","none");

    }
    else if(cond=="2")
    {
    $('#refcount').css("display","block");
    $('#rankcount').css("display","block");
    $('#statuscount').css("display","block");
    $('#downcount').css("display","none");
    $('#pvcount').css("display","none");
    $('#balcount').css("display","none");
    $('#commission').css("display","none");
    $('#rightcount').css("display","none");
    $('#leftcount').css("display","none");
    $('#totalpackage').css("display","none");




    }
    else if(cond == "3")
    {
    $('#balcount').css("display","block");
    $('#rankcount').css("display","block");
    $('#statuscount').css("display","block");
    $('#downcount').css("display","none");
    $('#pvcount').css("display","none");
    $('#refcount').css("display","none");
    $('#commission').css("display","none");
    $('#rightcount').css("display","none");
    $('#leftcount').css("display","none");
    $('#totalpackage').css("display","none");



    }
    else if(cond == "4")
    {
    $('#pvcount').css("display","block");
    $('#rankcount').css("display","block");
    $('#statuscount').css("display","block");
    $('#downcount').css("display","none");
    $('#refcount').css("display","none");
    $('#balcount').css("display","none");
    $('#commission').css("display","block");
    $('#rightcount').css("display","none");
    $('#leftcount').css("display","none");
    $('#totalpackage').css("display","none");





    }

    else if(cond == "5")
    {
    $('#leftcount').css("display","block");
    $('#rightcount').css("display","block");
    $('#rankcount').css("display","block");
    $('#statuscount').css("display","block");
    $('#downcount').css("display","none");
    $('#refcount').css("display","none");
    $('#balcount').css("display","none");
    $('#commission').css("display","none");
    $('#totalpackage').css("display","none");



    }
    else if(cond == "6")
    {
    $('#totalpackage').css("display","block");
    $('#rankcount').css("display","block");
    $('#statuscount').css("display","block");
    $('#downcount').css("display","none");
    $('#refcount').css("display","none");
    $('#balcount').css("display","none");
    $('#commission').css("display","none");
    $('#leftcount').css("display","none");
    $('#rightcount').css("display","none");




    }
    }

    $(document).ready(function(){


    $('#bonus_type').on('change',function(){
        var a =  $(this).val();

        if(a=='2')
        {
            $('#textarea').css('display','block');
        }
        else
        {
            $('#textarea').css('display','none');
        }

    })

    var counter = 2;

    $("#addlvlButton").click(function () {

    if(counter>15){
    alert("Only 15 textboxes allow");
    return false;
    }   

    var levelcommissiondiv = $(document.createElement('div'))
    .attr("id", 'levelcommission' + counter).attr("class", 'section row mb10');

    levelcommissiondiv.after().html('<label class="col-sm-3 ph10 "></label><div class="col-sm-7 ph10 mb10"><input type="text" name="levelcommission[]" placeholder="Level'+ counter+' Commission Amount" id="levelcommission'+ counter+'" value="" class="gui-input" ></div>');

    levelcommissiondiv.appendTo("#levelcommissiondiv");


    counter++;
    });

    $("#removelvlButton").click(function () {
    if(counter==2){
    alert("No more textbox to remove");
    return false;
    }   

    counter--;

    $("#levelcommission" + counter).remove();

    });

    $("#getButtonValue").click(function () {

    var msg = '';
    for(i=1; i<counter; i++){
    msg += "\n levelcommissiondiv #" + i + $('#levelcommissiondiv' + i).val();
    }
    alert(msg);
    });
    });

    </script>

    <script type="text/javascript">
    (function($) {

    $(document).ready(function() {


    $("#allcp-form").validate({

    // States


    errorClass: "state-error",
    validClass: "state-success",
    errorElement: "em",

    // Rules

    rules: {
    targetcon: {
    required: true
    },
     min_pack_inves:
    {
    required:true,
    number:true
    },
     bonus_amt:
    {
    required:true,
    number:true
    },
     elig_earn:
    {
    required:true,
    number:true
    },
    downlinemembercount:
    {
    required:true,
    number:true,
    },
    rank_reward:
    {
    required:true,
    number:true,
    },

    referalcount:
    {
    required:true,
    number:true
    },
    targetbalance:
    {
    required:true,
    number:true
    },
    targetpv:
    {
    required:true,
    number:true
    },
    'levelcommission[]':
    {
    required:true,
    number:true
    },
    targetcount:
    {
    required:true,
    number:true
    },
    rightcounts:
    {
    required:true,
    number:true
    },
    target_packagefee:
    {
    required:true,
    number:true
    },
    rank:
    {
    required:true
    }



    },

    // error message
    messages: {
    targetcon: {
    required: '<?php echo 'Select the Rank condition is required'; ?>'
    },
    downlinemembercount:
    {
    required:'<?php echo "Downline Count is required";?>',
    number:'<?php echo "Downline count is invalid";?>'
    },
    referalcount:
    {
    required:'<?php echo "Referal count is required";?>',
    number:'<?php echo "Referal count is invalid";?>'
    },
    
    rank_reward:
    {
    required:'<?php echo "Rank-Reward required";?>',
    number:'<?php echo "Rank-Reward is Only invalid Number";?>'
    },
    targetbalance:
    {
    required:'<?php echo "Target balance is required";?>',
    number:'<?php echo "Target balance is invalid"?>'
    },
    targetpv:
    {
    required:'<?php echo "Target Pv and Gv is required";?>',
    number:'<?php echo "Target pv and gv is invalid";?>'
    },
    'levelcommission[]':
    {
    required:'<?php echo 'Level commission is required';?>',
    number:'<?php echo 'Level commission is invalid';?>'
    },
    targetcount:
    {
    required:'<?php echo 'Target left count is required';?>',
    number:'<?php echo "Target Count is invalid";?>'
    },
    rightcounts:
    {
    required:'<?php echo 'Target Right count is required';?>',
    number:'<?php echo "Target Right Count is invalid";?>'
    },
    target_packagefee:
    {
    required:'<?php echo 'Target Package Fees is required';?>',
    number:'<?php echo "Target Package Fees is invalid";?>'
    },
    rank:
    {
    required:'<?php echo "Rank is required";?>'
    }

    },

    /* @validation highlighting + error placement
    ---------------------------------------------------- */

    highlight: function(element, errorClass, validClass) {
    $(element).closest('.field').addClass(errorClass).removeClass(validClass);
    },
    unhighlight: function(element, errorClass, validClass) {
    $(element).closest('.field').removeClass(errorClass).addClass(validClass);
    },
    errorPlacement: function(error, element) {
    if (element.is(":radio") || element.is(":checkbox")) {
    element.closest('.option-group').after(error);
    } else {
    error.insertAfter(element.parent());
    }
    }
    });

    });

    })(jQuery);
    </script>                                                                                                                                                                                                                       <!--  /Scripts  -->

    </body>

    </html>
