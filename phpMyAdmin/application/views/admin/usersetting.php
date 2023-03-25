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

        <!--  Favicon  -->
        <!-- <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.ico"> -->

        <!--  IE8 HTML5 support   -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

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

        <!--  Column Left  -->
        <aside class="chute chute-left chute290" data-chute-height="match">

        <!--  Menu Block  -->
        <!--       <div class="allcp-form theme-primary">

        <h6 class="mb15">Store Name</h6>

        <div class="section mb15">
        <label for="store-name" class="field prepend-icon">
        <input type="text" name="store-name" id="store-name" class="gui-input"
        value="My Store">
        <label for="store-name" class="field-icon">
        <i class="fa fa-shopping-cart"></i>
        </label>
        </label>
        </div>

        <h6 class="mb15">Store URL</h6>

        <div class="section mb15">
        <label for="store-url" class="field prepend-icon">
        <input type="text" name="store-url" id="store-url" class="gui-input"
        value="http://yoursite.com/shop">
        <label for="store-url" class="field-icon">
        <i class="fa fa-link"></i>
        </label>
        </label>
        </div>

        <h6 class="mb15">Store Image</h6>

        <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-preview thumbnail mb20">
        <img data-src="holder.js/100%x100" alt="holder">
        </div>
        <span class="btn btn-primary light btn-file btn-block ph5">
        <span class="fileupload-new">Upload image</span>
        <span class="fileupload-exists">Upload image</span>
        <input type="file">
        </span>
        </div>
        </div> 

        </aside>-->
        <!--  /Column Left  -->

        <!--  Column Center  -->
        <div class="chute chute-center">

        <div class="mw1000 center-block">

        <!--  General Information  -->
        <div class="panel mb35">
        <form method="post" action="" id="allcp-form" enctype="multipart/form-data">
        <div class="panel-heading">
        <span class="panel-title"><?php echo  "Membership Settings"; ?></span>
        </div>

        <div class="section row mbn">
        <?php if($this->session->flashdata('error_message')) { ?>    
        <div class="col-md-12 bg-danger pt10 pb10 mt10">
        <span class=""><?php echo $this->session->flashdata('error_message');?></span>
        </div>
        <?php unset($_SESSION['error_message']); } ?>

        <?php if($this->session->flashdata('success_message')) { ?>    
        <div class="col-md-12 bg-success pt10 pb10 mt10">
        <span class=""><?php echo $this->session->flashdata('success_message');?></span>
        </div>
        <?php unset($_SESSION['success_message']); } ?>
        </div>
        <div class="panel-body br-t">

        <div class="allcp-form theme-primary">


        <div class="section row mb15">
        <label for="minuserpasswordlength" class="field-label col-sm-4 ph10  text-left"><?php echo  ucwords($this->lang->line('minuserpasswordlength')); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-5 ph10">
        <label for="minuserpasswordlength" class="field prepend-icon">
        <input type="text" name="minuserpasswordlength" id="minuserpasswordlength" placeholder="<?php echo  ucwords($this->lang->line('minuserpasswordlength')); ?>"
        class="gui-input" value="<?php echo set_value('minuserpasswordlength', isset($this->data['minuserpasswordlength']) ? $this->data['minuserpasswordlength'] : '');?>" >
        <label for="minuserpasswordlength" class="field-icon">
        <i class="fa fa-list"></i>
        </label>
        </label>
        <?php echo form_error('minuserpasswordlength'); ?>
        </div>
        </div>

        <div class="section row mb15">
        <label for="maxuserpasswordlength" class="field-label col-sm-4 ph10  text-left"><?php echo  ucwords($this->lang->line('maxuserpasswordlength')); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-5 ph10">
        <label for="minuserpasswordlength" class="field prepend-icon">
        <input type="text" name="maxuserpasswordlength" id="maxuserpasswordlength" placeholder="<?php echo  ucwords($this->lang->line('maxuserpasswordlength')); ?>"
        class="gui-input" value="<?php echo set_value('maxuserpasswordlength', isset($this->data['maxuserpasswordlength']) ? $this->data['maxuserpasswordlength'] : '');?>" >
        <label for="maxuserpasswordlength" class="field-icon">
        <i class="fa fa-list"></i>
        </label>
        </label>
        <?php echo form_error('maxuserpasswordlength'); ?>
        </div>
        </div>

        <!-- <div class="section row mb10">
        <label for="twofactorauthstatus"
        class="field-label col-sm-4 ph10 text-left"><?php echo  ucwords($this->lang->line('twofactorauthstatus')); ?></label>

        <div class="col-sm-5 ph10">

        <div class="option-group field">
        <label class="col-md-3 block mt15 option option-primary">

        <input type="radio" <?php if(isset($this->data['twofactorauthstatus'])=='1'){ echo "checked='checked'";}else {echo'';}?> value='1' name="twofactorauthstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('on'))?>
        </label>

        <label class="col-md-3 block mt15 option option-primary">
        <input type="radio" <?php if($this->data['twofactorauthstatus']=='0') { echo "checked='checked'"; } else {echo'';}?> value='0' name="twofactorauthstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('off'))?>
        </label>
        </div>
        <label for="twofactorauthstatus" class="field-icon">

        </label>
        <?php echo form_error('twofactorauthstatus'); ?>

        </div>
        </div>
        -->

        <div class="section row mb10">
        <label for="withdrawpassordstatus"
        class="field-label col-sm-4 ph10 text-left"><?php echo  ucwords($this->lang->line('withdrawpassordstatus')); ?></label>

        <div class="col-sm-5 ph10">

        <div class="option-group field">
        <label class="col-md-4 block mt15 option option-primary">

        <input type="radio" <?php if(isset($this->data['withdrawpassordstatus'])=='1'){ echo "checked='checked'";}else {echo'';}?> value='1' name="withdrawpassordstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('on'))?>
        </label>

        <label class="col-md-4 block mt15 option option-primary">
        <input type="radio" <?php if($this->data['withdrawpassordstatus']=='0') { echo "checked='checked'"; } else {echo'';}?> value='0' name="withdrawpassordstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('off'))?>
        </label>
        </div>
        <label for="withdrawpassordstatus" class="field-icon">

        </label>
        <?php echo form_error('withdrawpassordstatus'); ?>
        </div>
        </div>



        <div class="section row mb10">
        <label for="profilepassordstatus"
        class="field-label col-sm-4 ph10 text-left"><?php echo  ucwords($this->lang->line('profilepassordstatus')); ?></label>

        <div class="col-sm-5 ph10">



        <div class="option-group field">
        <label class="col-md-4 block mt10 option option-primary">

        <input type="radio" <?php if(isset($this->data['profilepassordstatus'])=='1'){ echo "checked='checked'";}else {echo'';}?> value='1' name="profilepassordstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('on'))?>
        </label>

        <label class="col-md-4 block mt15 option option-primary">
        <input type="radio" <?php if($this->data['profilepassordstatus']=='0') { echo "checked='checked'"; } else {echo'';}?> value='0' name="profilepassordstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('off'))?>
        </label>
        </div>
        <label for="profilepassordstatus" class="field-icon">

        </label>
        <?php echo form_error('profilepassordstatus'); ?>
        </div>
        </div>

        <!-- <div class="section row mb10">
        <label for="accountconfirmationstatus"
        class="field-label col-sm-4 ph10 text-left"><?php echo  ucwords($this->lang->line('accountconfirmationstatus')); ?></label>

        <div class="col-sm-5 ph10">



        <div class="option-group field">
        <label class="col-md-4 block mt15 option option-primary">

        <input type="radio" <?php if(isset($this->data['accountconfirmationstatus'])=='1'){ echo "checked='checked'";}else {echo'';}?> value='1' name="accountconfirmationstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('on'))?>
        </label>

        <label class="col-md-4 block mt15 option option-primary">
        <input type="radio" <?php if($this->data['accountconfirmationstatus']=='0') { echo "checked='checked'"; } else {echo'';}?> value='0' name="accountconfirmationstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('off'))?>
        </label>
        </div>
        <label for="accountconfirmationstatus" class="field-icon">

        </label>
        <?php echo form_error('accountconfirmationstatus'); ?>
        </div>
        </div> -->

        <div class="section row mb10">
        <label for="useremailchangestatus"
        class="field-label col-sm-4 ph10 text-left"><?php echo  ucwords($this->lang->line('useremailchangestatus')); ?></label>

        <div class="col-sm-5 ph10">



        <div class="option-group field">
        <label class="col-md-4 block mt15 option option-primary">

        <input type="radio" <?php if(isset($this->data['useremailchangestatus'])=='1'){ echo "checked='checked'";}else {echo'';}?> value='1' name="useremailchangestatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('on'))?>
        </label>

        <label class="col-md-4 block mt15 option option-primary">
        <input type="radio" <?php if($this->data['useremailchangestatus']=='0') { echo "checked='checked'"; } else {echo'';}?> value='0' name="useremailchangestatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('off'))?>
        </label>
        </div>
        <label for="useremailchangestatus" class="field-icon">

        </label>
        <?php echo form_error('useremailchangestatus'); ?>
        </div>
        </div>

        <!-- <div class="section row mb10">
        <label for="userprofilenotifystatus"
        class="field-label col-sm-4 ph10 text-left"><?php echo  ucwords($this->lang->line('userprofilenotifystatus')); ?></label>

        <div class="col-sm-5 ph10">



        <div class="option-group field">
        <label class="col-md-4 block mt15 option option-primary">

        <input type="radio" <?php if(isset($this->data['userprofilenotifystatus'])=='1'){ echo "checked='checked'";}else {echo'';}?> value='1' name="userprofilenotifystatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('on'))?>
        </label>

        <label class="col-md-4 block mt15 option option-primary">
        <input type="radio" <?php if($this->data['userprofilenotifystatus']=='0') { echo "checked='checked'"; } else {echo'';}?> value='0' name="userprofilenotifystatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('off'))?>
        </label>
        </div>
        <label for="userprofilenotifystatus" class="field-icon">

        </label>
        <?php echo form_error('userprofilenotifystatus'); ?>
        </div>
        </div> -->

        <div class="section row mb10 br-t" style="display: none;">
        <label for="subscriptionstatus"
        class="field-label col-sm-4 ph10 text-left"><?php echo  ucwords($this->lang->line('subscriptionstatus')); ?></label>

        <div class="col-sm-5 ph10">

        <div class="option-group field">
        <label class="col-md-4 block mt15 option option-primary">

        <input type="radio" <?php if(isset($this->data['subscriptionstatus'])=='1'){ echo "checked='checked'";}else {echo'';}?> value='1' name="subscriptionstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('on'))?>
        </label>

        <label class="col-md-4 block mt15 option option-primary">
        <input type="radio" <?php if($this->data['subscriptionstatus']=='0') { echo "checked='checked'"; } else {echo'';}?> value='0' name="subscriptionstatus">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('off'))?>
        </label>
        </div>
        <label for="subscriptionstatus" class="field-icon">

        </label>
        <?php echo form_error('subscriptionstatus'); ?>

        </div>
        </div>

        <div class="section row mb10" style="display: none;" >
        <label for="subscriptiontype"
        class="field-label col-sm-4 ph10 text-left"><?php echo  ucwords($this->lang->line('subscriptiontype')); ?></label>

        <div class="col-sm-5 ph10">

        <div class="option-group field">
        <label class="col-md-4 block mt15 option option-primary">

        <input type="radio" <?php if(isset($this->data['subscriptiontype'])=='monthly'){ echo "checked='checked'";}else {echo'';}?> value='monthly' name="subscriptiontype">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('monthly'))?>
        </label>

        <label class="col-md-4 block mt15 option option-primary">
        <input type="radio" <?php if($this->data['subscriptiontype']=='yearly') { echo "checked='checked'"; } else {echo'';}?> value='yearly' name="subscriptiontype">
        <span class="radio"></span>
        <?php echo  ucwords($this->lang->line('yearly'))?>
        </label>
        </div>
        <label for="subscriptiontype" class="field-icon">

        </label>
        <?php echo form_error('subscriptiontype'); ?>

        </div>
        </div>

        <div class="section row mb15" style="display: none;">
        <label for="subscriptiongraceperiod" class="field-label col-sm-4 ph10  text-left"><?php echo  ucwords($this->lang->line('subscriptiongraceperiod').$this->lang->line('inday')); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-5 ph10">
        <label for="subscriptiongraceperiod" class="field prepend-icon">
        <input type="text" name="subscriptiongraceperiod" id="subscriptiongraceperiod" placeholder="<?php echo  ucwords($this->lang->line('subscriptiongraceperiod')); ?>"
        class="gui-input" value="<?php echo set_value('subscriptiongraceperiod', isset($this->data['subscriptiongraceperiod']) ? $this->data['subscriptiongraceperiod'] : '');?>" >
        <label for="subscriptiongraceperiod" class="field-icon">
        <i class="fa fa-calendar"></i>
        </label>
        </label>
        <?php echo form_error('subscriptiongraceperiod'); ?>
        </div>
        </div>


        <div class="panel-footer text-right br-t">
        <button type="submit" class="btn btn-bordered btn-primary"><?php echo  ucwords($this->lang->line('submit')); ?></button>
        <!--                                 <button type="reset" class="btn btn-bordered mb5"><?php echo  ucwords($this->lang->line('cancel')); ?></button>
        -->                            </div>


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
        <aside id="sidebar_right" class="nano affix">

        <!--  Sidebar Right Content  -->
        <div class="sidebar-right-wrapper nano-content">

        <div class="sidebar-block br-n p15">

        <h6 class="title-divider text-muted mb20"> Visitors Stats
        <span class="pull-right"> 2015
        <i class="fa fa-caret-down ml5"></i>
        </span>
        </h6>

        <div class="progress mh5">
        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="34"
        aria-valuemin="0"
        aria-valuemax="100" style="width: 34%">
        <span class="fs11">New visitors</span>
        </div>
        </div>
        <div class="progress mh5">
        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="66"
        aria-valuemin="0"
        aria-valuemax="100" style="width: 66%">
        <span class="fs11 text-left">Returnig visitors</span>
        </div>
        </div>
        <div class="progress mh5">
        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45"
        aria-valuemin="0"
        aria-valuemax="100" style="width: 45%">
        <span class="fs11 text-left">Orders</span>
        </div>
        </div>

        <h6 class="title-divider text-muted mt30 mb10">New visitors</h6>

        <div class="row">
        <div class="col-xs-5">
        <h3 class="text-primary mn pl5">350</h3>
        </div>
        <div class="col-xs-7 text-right">
        <h3 class="text-warning mn">
        <i class="fa fa-caret-down"></i> 15.7% </h3>
        </div>
        </div>

        <h6 class="title-divider text-muted mt25 mb10">Returnig visitors</h6>

        <div class="row">
        <div class="col-xs-5">
        <h3 class="text-primary mn pl5">660</h3>
        </div>
        <div class="col-xs-7 text-right">
        <h3 class="text-success-dark mn">
        <i class="fa fa-caret-up"></i> 20.2% </h3>
        </div>
        </div>

        <h6 class="title-divider text-muted mt25 mb10">Orders</h6>

        <div class="row">
        <div class="col-xs-5">
        <h3 class="text-primary mn pl5">153</h3>
        </div>
        <div class="col-xs-7 text-right">
        <h3 class="text-success mn">
        <i class="fa fa-caret-up"></i> 5.3% </h3>
        </div>
        </div>

        <h6 class="title-divider text-muted mt40 mb20"> Site Statistics
        <span class="pull-right text-primary fw600">Today</span>
        </h6>
        </div>
        </div>
        </aside>
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
        (function($) {

        $(document).ready(function() {

        // "use strict";
        // // Init Theme Core
        // Core.init();

        // // Init Demo JS
        // Demo.init();

        // $.validator.methods.smartCaptcha = function(value, element, param) {
        //     return value == param;
        // };

        $("#allcp-form").validate({

        // States


        errorClass: "state-error",
        validClass: "state-success",
        errorElement: "em",

        // Rules

        rules: {
        minuserpasswordlength: {
        required: true,
        number: true
        },
        maxuserpasswordlength: {
        required: true,
        number: true
        },
        twofactorauthstatus: {
        required: true
        },
        withdrawpassordstatus: {
        required: true  
        },
        profilepassordstatus: {
        required: true
        },
        accountconfirmationstatus: {
        required: true
        },
        useremailchangestatus: {
        required: true
        },
        userprofilenotifystatus: {
        required: true
        }

        /* sitebanner: {
        extension: "jpg|png|gif|jpeg"
        }

        password: {
        required: true,
        minlength: 6,
        maxlength: 16
        }*/
        },

        // error message
        messages: {
        twofactorauthstatus: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>'
        },
        minuserpasswordlength: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>',
        number: '<?php echo ucwords($this->lang->line('errornumber')); ?>'
        },
        maxuserpasswordlength: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>',
        number: '<?php echo ucwords($this->lang->line('errornumber')); ?>'
        },
        withdrawpassordstatus: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>'
        },
        profilepassordstatus: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>'
        },
        accountconfirmationstatus: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>'
        },
        useremailchangestatus: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>'
        },
        userprofilenotifystatus: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>'
        },
        adminfeetype: {
        required: '<?php echo ucwords($this->lang->line('require')); ?>'
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
