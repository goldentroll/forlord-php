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
        <form method="post" action="" id="allcp-form" enctype="multipart/form-data">
        <div class="panel-heading">
        <span class="panel-title"><?php echo  ucwords($this->lang->line('pagetitle_packageadd')); ?></span>
        <span class="allcp-form"><a class="btn btn-primary pull-right" title="" data-toggle="tooltip" href="<?php echo base_url();?>admin/packagesetting" data-original-title="Back"><i class="fa fa-close"></i></a></span>

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

        <div class="panel-body br-t">

        <div class="allcp-form theme-primary">


        <div class="section row mb10">
        <label for="packagename" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords($this->lang->line('packagename')); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-7 ph10">
        <label for="packagename" class="field prepend-icon">
        <input type="text" name="packagename" id="packagename" placeholder="<?php echo  ucwords($this->lang->line('packagename')); ?>"
        class="gui-input" value="<?php echo set_value('packagename', isset($this->data['packagename']) ? $this->data['packagename'] : '');?>" >
        <label for="packagename" class="field-icon">
        <i class="fa fa-info"></i>
        </label>
        </label>
        <?php echo form_error('packagename');?>
        </div>
        </div>

        <div class="section row mb10">
        <label for="packagefee" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords($this->lang->line('packagefee')); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-7 ph10">
        <label for="packagefee" class="field prepend-icon">
        <input type="text" name="packagefee" id="packagefee" placeholder="<?php echo  ucwords($this->lang->line('packagefee')); ?>"
        class="gui-input" value="<?php echo set_value('packagefee', isset($this->data['packagefee']) ? $this->data['packagefee'] : '');?>" >
        <label for="packagefee" class="field-icon">
        <i class="fa fa-money"></i>
        </label>
        </label>
        <?php echo form_error('packagefee');?>
        </div>
        </div>


        <div class="section row mb10">
        <label for="directcommission" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords($this->lang->line('directcommission')); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-7 ph10">
        <label for="directcommission" class="field prepend-icon">
        <input type="text" name="directcommission" id="directcommission" placeholder="<?php echo  ucwords($this->lang->line('directcommission')); ?>"
        class="gui-input" value="<?php echo set_value('directcommission', isset($this->data['fielddata']->DirectCommission) ? $this->data['fielddata']->DirectCommission : '');?>" >
        <label for="directcommission" class="field-icon">
        <i class="fa fa-money"></i>
        </label>
        </label>
        <?php echo form_error('directcommission');?>
        </div>
        </div>
     

       



        <div class="section row mb10">
        <label for="indirectcommission" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords('indirectcommission'); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>
        <div class="col-sm-7 ph10">
        <label for="directcommission" class="field prepend-icon">
        <input type="text" name="indirectcommission" id="indirectcommission" placeholder="InDirectCommission"
        class="gui-input" value="<?php echo set_value('indirectcommission', isset($this->data['fielddata']->InDirectCommission) ? $this->data['fielddata']->InDirectCommission : '');?>" >
        <label for="indirectcommission" class="field-icon">
        <i class="fa fa-money"></i>
        </label>
        </label>
        <?php echo form_error('indirectcommission');?>
        </div>
        </div>


         <div class="section row mb10">
        <label for="indirectcommission" class="field-label col-sm-3 ph10  text-left">Mining Reward<sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>
        <div class="col-sm-7 ph10">
        <label for="directcommission" class="field prepend-icon">
        <input type="text" name="mining_reward" id="mining_reward" placeholder="Mining Reward"
        class="gui-input" value="<?php echo set_value('mining_reward', isset($this->data['fielddata']->mining_reward) ? $this->data['fielddata']->mining_reward : '');?>" >
        <label for="indirectcommission" class="field-icon">
        <i class="fa fa-money"></i>
        </label>
        </label>
        <?php echo form_error('mining_reward');?>
        </div>
        </div>



        <div id="commission">
                <div class="section row mb10" id="levelcommissiondivp">
                <label for="levelcommission" class="field-label col-sm-4 ph10  text-left">Mining-Reward Upline<sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>
                <div class="col-sm-3 ph10">
                <input type='button' value='+' id='addlvlButton2'  class="btn btn-bordered btn-primary"  />
                <input type='button' value='-' id='removelvlButton2' class="btn btn-bordered btn-primary" />
                </div>  
                <?php echo form_error('levelcommission1');?>
                </div>

                <div class="section row mb10" id="levelcommissiondivp2">
                <label for="levelcommission" class="field-label col-sm-3 ph10 md10"></label>
                <div class="col-sm-7 ph10 md10 " >
                <input type="text" name="levelcommission2[]" id="levelcommission2[]" placeholder="<?php echo  " Mining Reward Upline";echo" 1 ".  ucwords($this->lang->line('comamount')); ?>"
                class="gui-input" value="" >
                </div>
                </div>

                <div class="section row mb10" id="levelcommissiondiv2">
                <div class="col-sm-7 ph10"></div>
                <label for="levelcommission" class="field prepend-icon col-sm-5 ">
                </label>
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
                <label for="levelcommission" class="field-label col-sm-3 ph10 md10"></label>
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


        <div class="section row mb10">
        <label for="indirectcommission" class="field-label col-sm-3 ph10  text-left">Coil -Rewards <sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>
        <div class="col-sm-7 ph10">
        <label for="directcommission" class="field prepend-icon">
        <input type="text" name="token_reward" id="token_reward" placeholder="Coil-Reward"
        class="gui-input" value="<?php echo set_value('token_reward', isset($this->data['fielddata']->token_reward) ? $this->data['fielddata']->token_reward : '');?>" >
        <label for="indirectcommission" class="field-icon">
        <i class="fa fa-money"></i>
        </label>
        </label>
        <?php echo form_error('token_reward');?>
        </div>
        </div>



         <div id="commission">
                <div class="section row mb10" id="levelcommissiondivp">
                <label for="levelcommission" class="field-label col-sm-4 ph10  text-left">Coil-Reward Upline<sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>
                <div class="col-sm-3 ph10">
                <input type='button' value='+' id='addlvlButton1'  class="btn btn-bordered btn-primary"  />
                <input type='button' value='-' id='removelvlButton1' class="btn btn-bordered btn-primary" />
                </div>  
                <?php echo form_error('levelcommission1');?>
                </div>

                <div class="section row mb10" id="levelcommissiondivp1">
                <label for="levelcommission" class="field-label col-sm-3 ph10 md10"></label>
                <div class="col-sm-7 ph10 md10 " >
                <input type="text" name="levelcommission1[]" id="levelcommission1[]" placeholder="<?php echo  "Reward Upline";echo" 1 ".  ucwords($this->lang->line('comamount')); ?>"
                class="gui-input" value="" >
                </div>
                </div>

                <div class="section row mb10" id="levelcommissiondiv1">
                <div class="col-sm-7 ph10"></div>
                <label for="levelcommission" class="field prepend-icon col-sm-5 ">
                </label>
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


        </script>
                        <script type="text/javascript">

                        $(document).ready(function(){

                        var counter = 2;

                        $("#addlvlButton1").click(function () {

                        if(counter>15){
                        alert("Only 15 textboxes allow");
                        return false;
                        }   

                        var levelcommissiondiv1 = $(document.createElement('div'))
                        .attr("id", 'levelcommission1' + counter).attr("class", 'section row mb10');

                        levelcommissiondiv1.after().html('<label class="col-sm-3 ph10 "></label><div class="col-sm-7 ph10 mb10"><input type="text" name="levelcommission1[]" placeholder="Reward upline'+ counter+' Commission Amount" id="levelcommission1'+ counter+'" value="" class="gui-input" ></div>');

                        levelcommissiondiv1.appendTo("#levelcommissiondiv1");


                        counter++;
                        });

                        $("#removelvlButton1").click(function () {
                        if(counter==2){
                        alert("No more textbox to remove");
                        return false;
                        }   

                        counter--;

                        $("#levelcommission1" + counter).remove();

                        });

                        $("#getButtonValue").click(function () {

                        var msg = '';
                        for(i=1; i<counter; i++){
                        msg += "\n levelcommissiondiv1 #" + i + $('#levelcommissiondiv11' + i).val();
                        }
                        alert(msg);
                        });
                        });


                        </script>




                          <script type="text/javascript">

                        $(document).ready(function(){

                        var counter = 2;

                        $("#addlvlButton2").click(function () {

                        if(counter>15){
                        alert("Only 15 textboxes allow");
                        return false;
                        }   

                        var levelcommissiondiv2 = $(document.createElement('div'))
                        .attr("id", 'levelcommission2' + counter).attr("class", 'section row mb10');

                        levelcommissiondiv2.after().html('<label class="col-sm-3 ph10 "></label><div class="col-sm-7 ph10 mb10"><input type="text" name="levelcommission2[]" placeholder="Mining Reward upline'+ counter+' Commission Amount" id="levelcommission2'+ counter+'" value="" class="gui-input" ></div>');

                        levelcommissiondiv2.appendTo("#levelcommissiondiv2");


                        counter++;
                        });

                        $("#removelvlButton2").click(function () {
                        if(counter==2){
                        alert("No more textbox to remove");
                        return false;
                        }   

                        counter--;

                        $("#levelcommission2" + counter).remove();

                        });

                        $("#getButtonValue").click(function () {

                        var msg = '';
                        for(i=1; i<counter; i++){
                        msg += "\n levelcommissiondiv2 #" + i + $('#levelcommissiondiv2' + i).val();
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
        packagename: {
        required: true
        },
        packagefee: {
        required: true,
        number:true
        },

        mining_reward: {
        required: true,
        number:true
        },

        token_reward: {
        required: true,
        number: true
        },
        directcommission:{
        required:true,
        number:true
        }

        },

        // error message
        messages: {
        packagename: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>'
        },
        admin_fee: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>',
        number: '<?php echo ucwords($this->lang->line('errornumber')); ?>'
        },
        
        mining_reward: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>',
        number: '<?php echo ucwords($this->lang->line('errornumber')); ?>'
        },
        packagefee: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>',
        number:'<?php echo ucwords($this->lang->line('errornumber')); ?>'
        },
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
