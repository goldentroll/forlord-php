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
<aside class="chute chute-left chute290" data-chute-height="match"  >

<!--  Column Center  -->
<div class="chute chute-center"  style="height: 564px;margin-top: 82px;">
 
    <div class="mw1000 center-block">

        <!--  General Information  -->
        <div class="panel mb35">
        <form method="post" action="" id="allcp-form" enctype="multipart/form-data" autocomplete="off">

        <div class="panel-heading">
        <span class="panel-title">Global Bonus to Member Ewallet</span>
        </div>
            
        <div class="section row mbn">
        <?php if($this->session->flashdata('error_message')) { ?>    
        <div class="col-md-12 bg-danger pt10 pb10 mt10 mb20">
        <span class=""><?php echo $this->session->flashdata('error_message');?></span>
        </div>
        <?php unset($_SESSION['error_message']);} ?>

        <?php if($this->session->flashdata('success_message')) { ?>    
        <div class="col-md-12 bg-success pt10 pb10 mt10 mb20">
        <span class=""><?php echo $this->session->flashdata('success_message');?></span>
        </div>
        <?php unset($_SESSION['success_message']);} ?>
        </div>

        <div class="panel-body br-t">
        <div class="allcp-form theme-primary">

        <div class="section row mb10">

        <label for="earners"
        class="field-label col-sm-3 ph10 text-left">Select Level <sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

        <div class="col-sm-7 ph10">

        <label for="earners" class="field select">
        <select id="earners" name="earners">

        <?php 
        if($field)
        {
        foreach($field as $key)
        {
        if($key->Status==1)
        {
        ?>
        <option value="<?php echo $key->rank_id;?>"<?php if($row->earners==$key->rank_id){echo "selected";}?>><?php echo ucfirst($key->Rank);?></option>
        <?
        }
        }
        }
        ?>

        </select>
        <i class="arrow double"></i>
        </label>

        <label for="earners" class="field-icon">
        <i class="fa "></i>
        </label>
        <?php echo form_error('earners'); ?>
        </div>
        </div>



    <div class="section row mb10">
    <label for="earning_mode" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords('Earning mode'); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>
    <div class="col-sm-7 ph10">
    <label class="field select">
    <select id="earning_mode" name="earning_mode" class="gui-input select" >
<!--  <option value="5" <?php if($row->earning_mode=='5'){echo "selected";}?>>Daily</option> 
<option value="1" <?php if($row->earning_mode=='1'){echo "selected";}?>>Weekly</option>
<option value="2"<?php if($row->earning_mode=='2'){echo "selected";}?> >Monthly</option> -->
    <option value="3"<?php if($row->earning_mode=='3'){echo "selected";}?>>Quarterly</option>
<!--  <option value="4" <?php if($row->earning_mode=='4'){echo "selected";}?>>Yearly</option> -->
    </select>

    <i class="arrow double"></i>
    </label>

    </div>
    <?php echo form_error('earning_mode'); ?>
    </div>

    <div class="section row mb10">
    <label for="ewalletamount" class="field-label col-sm-3 ph10  text-left">Bonus Amount <?php echo currency(); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

    <div class="col-sm-7 ph10">
    <label for="ewalletamount" class="field prepend-icon">
    <input type="text" name="ewalletamount" id="ewalletamount" onclick="checkuser()" placeholder="Bonus Amount"
    class="gui-input" value="<?php echo $row->target_bonus;?>" >
    <label for="ewalletamount" class="field-icon">
    <i class="fa fa-money"></i>
    </label>
    </label>
    <?php echo form_error('ewalletamount'); ?>
    </div>
    </div>
 

    <div class="section row mb10">
    <label for="description" class="field-label col-sm-3 ph10  text-left"><?php echo  ucwords($this->lang->line('description')); ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

    <div class="col-sm-7 ph10">
    <label for="description" class="field prepend-icon">
    <textarea name="description" required="" class="form-control" aria-required="true"><?php echo $row->target_amount;?></textarea>
    <label for="description" class="field-icon">
    <i class="fa fa-list"></i>
    </label>
    </label>
    <?php echo form_error('description'); ?>
    </div>
    </div>





    <div class="panel-footer text-right">
    <button type="submit" class="btn btn-bordered btn-primary">Submit</button>
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

        $("#username").keyup(function(){
            
                var username = $(this).val();
                if(username)
                {
                $.ajax({
                    type    : 'post',
                    url     : '<?php echo base_url();?>admin/Ewallet/checkmember/'+username,
                    success : function(msg)
                    {
                        
                        $('#nameverify').val(msg);
                    }
                });
            }
            
            });

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
                username: {
                    required: true
                },
                nameverify: {
                    required: true
                },
                ewallettype: {
                    required: true
                },
                 ewalletamount: {
                    required: true,
                    number: true
                },
                 description: {
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
                username: {
                    required: '<?php echo ucwords($this->lang->line('require')); ?>'
                },
                nameverify: {
                    required: '<?php echo ucwords($this->lang->line('require')); ?>'
                },
                 ewallettype: {
                    required: '<?php echo ucwords($this->lang->line('require')); ?>'
                },
                 ewalletamount: {
                    required: '<?php echo ucwords($this->lang->line('require')); ?>',
                    number: '<?php echo ucwords($this->lang->line('errornumber')); ?>'
                },
                 description: {
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
