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

        </head>
        <style type="text/css">
        p
        {
        color:red;
        }
        </style>

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

        <!--  Column Left  -->
        <aside class="chute chute-left chute290" data-chute-height="match">

        <div class="chute chute-center">

        <div class="mw1000 center-block">

        <!--  General Information  -->
        <div class="panel mb35">
        <form method="post" id="allcp-form" action="<?php echo base_url();?>admin/targetsetting/edit_rank" enctype="multipart/form-data">

        <div class="panel-heading">
        <span class="panel-title"><?php echo  ucwords("Target Settings"); ?></span>
        <span class="allcp-form"><a class="btn btn-primary pull-right" title="" data-toggle="tooltip" href="<?php echo base_url();?>admin/targetsetting" data-original-title="Back"><i class="fa fa-close"></i></a></span>
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
        <?php //print_r(form_error());?>

        </div>

        <?php 



          ?>

        <div class="panel-body br-t">
        <div class="allcp-form theme-primary">

        <div class="section row mb10">

       <label for="earning_mode" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords('Earning mode'); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>
    <div class="col-sm-7 ph10">
          <label class="field select">
    <select id="earning_mode" name="earning_mode" class="gui-input select" >
     

  
    <option value="5" <?php if($row->earning_mode=='5'){echo "selected";}?>>Daily</option> 
    <option value="1" <?php if($row->earning_mode=='1'){echo "selected";}?>>Weekly</option>
    <option value="2"<?php if($row->earning_mode=='2'){echo "selected";}?> >Monthly</option>
    <option value="3"<?php if($row->earning_mode=='3'){echo "selected";}?>>Quarterly</option>
    <option value="4" <?php if($row->earning_mode=='4'){echo "selected";}?>>Yearly</option>

        </select>

       <i class="arrow double"></i>
        </label>
      
        
</div>
<?php echo form_error('earning_mode'); ?>
</div>

        <div class="section row mb10">
        <label for="duration" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords('duration'); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-7 ph10">
        <label for="duration" class="field prepend-icon">
        <input type="text" name="duration" id="duration" placeholder="<?php echo  ucwords('Duration'); ?>"
        class="gui-input" value="<?php echo set_value('duration', isset($row->duration) ? $row->duration: '');?>" >
        <label for="duration" class="field-icon">
        <i class="fa fa-money"></i>
        </label>
        </label>
        <?php echo form_error('duration');?>
        </div>
        </div>


        <div class="section row mb10">
        <label for="directcommission" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords('target amount'); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-7 ph10">
        <label for="target_amount" class="field prepend-icon">
        <input type="text" name="target_amount" id="target_amount" placeholder="<?php echo  ucwords('target amount'); ?>"
        class="gui-input" value="<?php echo set_value('target_amount', isset($row->target_amount) ? $row->target_amount : '');?>" >
        <label for="target_amount" class="field-icon">
        <i class="fa fa-money"></i>
        </label>
        </label>
        <?php echo form_error('target_amount');?>
        </div>
        </div>

         <div class="section row mb10">
        <label for="target_bonus" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords('target bonus'); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-7 ph10">
        <label for="target_bonus" class="field prepend-icon">
        <input type="text" name="target_bonus" id="indirectcommission" placeholder="<?php echo  ucwords('target bonus'); ?>"
        class="gui-input" value="<?php echo set_value('target_bonus', isset($row->target_bonus) ? $row->target_bonus : '');?>" >
        <label for="target_bonus" class="field-icon">
        <i class="fa fa-money"></i>
        </label>
        </label>
        <?php echo form_error('target_bonus');?>
        </div>
        </div>




         <div class="section row mb10">
        <label for="target_rewards" class="field-label col-sm-3 ph10  text-left"><?php echo  " Coil Rewards"; ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-7 ph10">
        <label for="target_rewards" class="field prepend-icon">
        <input type="text" name="target_rewards" id="target_rewards" placeholder="<?php echo  "Coil-Rewared"; ?>"
        class="gui-input" value="<?php echo set_value('target_rewards', isset($row->target_rewards) ? $row->target_rewards : '');?>" >
        <label for="target_rewards" class="field-icon">
        <i class="fa fa-money"></i>
        </label>
        </label>
        <?php echo form_error('target_rewards');?>
        </div>
        </div>

        <?php

if($row!="")
{
    ?>
<input type="hidden" value="<?php echo $row->id;?>" name="target_id">
    <?
}

        ?>
     



        <div class="panel-footer text-right">

        <button type="submit" class="btn btn-bordered btn-primary"><?php echo 'Submit'; ?></button>
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
        <script src="<?php echo base_url();?>assets/js/plugins/ckeditor/ckeditor.js"></script>


        <script type="text/javascript">

        $(document).ready(function(){

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


        $(document).ready(function(){

        var counter = 2;

        $("#addprtButton").click(function () {

        if(counter>15){
        alert("Only 15 textboxes allow");
        return false;
        }   

        var levelcommissiondiv = $(document.createElement('div'))
        .attr("id", 'productlevelcommission' + counter).attr("class", 'section row mb10');

        levelcommissiondiv.after().html('<label class="col-sm-3 ph10 "></label><div class="col-sm-7 ph10 mb10"><input type="text" name="productlevelcommission[]" placeholder="productLevel'+ counter+' Commission Amount" id="productlevelcommission'+ counter+'" value="" class="gui-input" ></div>');

        levelcommissiondiv.appendTo("#productlevelcommissiondiv");


        counter++;
        });

        $("#removeprtButton").click(function () {
        if(counter==2){
        alert("No more textbox to remove");
        return false;
        }   

        counter--;

        $("#productlevelcommission" + counter).remove();

        });

        $("#getButtonValue").click(function () {

        var msg = '';
        for(i=1; i<counter; i++){
        msg += "\n productlevelcommissiondiv #" + i + $('#productlevelcommissiondiv' + i).val();
        }
        alert(msg);
        });
        });

        </script>

          <script type="text/javascript">
        (function($) {

        $(document).ready(function() {


        $("#allcp-form").validate({


        errorClass: "state-error",
        validClass: "state-success",
        errorElement: "em",

        // Rules

        rules: {
        target_rewards: {
        required: true,
        number:true
        }
        },

        // error message
        messages: {
        
        target_rewards: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>',
        number:'<?php echo ucwords($this->lang->line('errornumber')); ?>'
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
        </script>             
        </body>

        </html>
