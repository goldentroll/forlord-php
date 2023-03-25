<!DOCTYPE html>
<html>

<head>
    <!--  Meta and Title  -->
    <?php $this->load->view('admin/meta');?>

    <!--  Fonts  -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    

    <!--  CSS - theme  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/skin/default_skin/css/theme.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/allcp/forms/css/forms.min.css">
    <!--  Favicon  -->
    <!-- <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.ico"> -->

    <link href="<?php echo BASE_uRL(); ?>assets/admin/css/pages/dashboard.css" rel="stylesheet">

    
    <style>
    input, select {
        width: 120px;
    }
    </style>
</head>

<body class="tables-datatables" data-spy="scroll" data-target="#nav-spy" data-offset="300">

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
        <?php $this->load->view('admin/toper');?>
        <!--  /Topbar Menu Wrapper  -->

        <!--  Topbar  -->
        <?php $this->load->view('admin/topmenu');?>
        <!--  /Topbar  -->

        <!--  Content  -->
        <section id="content" class="table-layout animated fadeIn">
        <div class="row">
        <div class="col-xs-12">
        <div role="tabpanel" id="" class="allcp-form theme-primary tab-pane">
        <div class="panel">
        <div class="panel-heading"> 
        <div class="section row mb20">
        <?php if($this->session->flashdata('error_message')) { ?>    
        <div class="col-md-12 bg-danger pt10 pb10 ">
        <span class=""><?php echo $this->session->flashdata('error_message');?></span>
        </div>
        <?php } ?>

        <?php if($this->session->flashdata('success_message')) { ?>    
        <div class="col-md-12 bg-success pt10 pb10 ">
        <span class=""><?php echo $this->session->flashdata('success_message');?></span>
        </div>
        <?php } ?>
        </div>
        </div>
        <div class="panel-body pn">
        <form id="contentForm" class="cms" method="post" action="">


        <div class="section mb10">
        <p><?php echo $this->lang->line('label_page_title');?>Reward Title<sup class="state-error1">*</sup></p>
        <label class="field prepend-icon" for="reward_title">
        <input type="text" value="<?php echo set_value('page_title',isset($page_data[0]->page_title) ? $page_data[0]->page_title : ''); ?>" placeholder="Page title" class="gui-input" id="reward_title" name="reward_title">
        <label class="field-icon" for="reward_title">
        <i class="fa fa-user"></i>
        </label>
        </label>
        <?php echo form_error('reward_title');?>
        </div>


        <div class="section mb10">
        <div class="panel-body pn of-h" id="summer-demo">
        <label class="mb10">Reward Content</label>
        <textarea id="summernote_text" name="reward_content" onkeyup="htmlEntities()" class=" gui-input" style="display: none;"><?php 
        echo urldecode(set_value('page_content',isset($page_data[0]->page_content) ? $page_data[0]->page_content : '')); ?></textarea>
        </div>
        <?php echo form_error('reward_content'); ?>
        </div>

        <div class="section mb10">
        <p><?php echo $this->lang->line('label_nav_title');?>Reward Url <sup class="state-error1">*</sup></p>
        <label class="field prepend-icon" for="reward_url">
        <input type="text" value="<?php echo set_value('reward_url',isset($page_data[0]->reward_url) ? $page_data[0]->reward_url : ''); ?>" placeholder="Menu Name" class="gui-input" id="reward_url" name="reward_url">
        <label class="field-icon" for="reward_url">
        <i class="ad ad-lines"></i>
        </label>
        </label>
        <?php echo form_error('reward_url');?>
        </div>

 <br>

<div class="section mb10">
<p><?php echo $this->lang->line('label_nav_title');?>Reward Date <sup class="state-error1">*</sup></p>
<label class="field prepend-icon" for="reward_date">

<input type="date" name="reward_date" class="form-control" placeholder="<?php echo $this->lang->line('reward_date'); ?>" class="gui-input"  value="<?php if($page_data[0]){ echo date('Y-m-d', strtotime($page_data[0]->reward_date));} ?>">

<label class="field-icon" for="reward_url">
<i class="ad ad-lines"></i>
</label>
</label>
<?php echo form_error('reward_date');?>
</div>

 <br>

<div class="section mb10">
<p><?php echo $this->lang->line('label_nav_title');?>Reward Time <sup class="state-error1">*</sup></p>
<label class="field prepend-icon" for="reward_time">

 <input type="time" id='time' name="reward_time" class="form-control" placeholder="" value="<?php echo date('H:i:s',strtotime($page_data[0]->reward_time)); ?>" step='1' min="00:00:00" >

<label class="field-icon" for="reward_time">
<i class="ad ad-lines"></i>
</label>
</label>
<?php echo form_error('reward_time');?>
</div>

 <br>


















<div class="section mb10">
<p><?php echo $this->lang->line('reward_amount');?>Reward Amount (USDT)<sup class="state-error1">*</sup></p>
<label class="field prepend-icon" for="reward_time">

<input type="text" name="reward_amount" class="form-control" placeholder="" value="<?php echo $page_data[0]->reward_amount; ?>">

<label class="field-icon" for="reward_time">
<i class="ad ad-lines"></i>
</label>
</label>
<?php echo form_error('reward_amount');?>
</div>


 <?php 
if($page_data)
{
?>
<input type="hidden" name="page_url" class="form-control" value="<?php echo $page_data[0]->page_id; ?>">
<?php
}
?>      


   <br>

<div class="section">
<div class="pull-right">
<button class="btn btn-bordered btn-primary" type="submit"> Save</button>
</div>
        </div>
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>

        </section>
        <!--  /Content  -->

    </section>

    <!--  Sidebar Right  -->
    <?php $this->load->view('admin/sidebar_right');?>
    <!--  /Sidebar Right  -->

</div>
<!--  /Body Wrap   -->




<!--  jQuery  -->
<?php $this->load->view('admin/footer');?>
<script src="<?php echo base_url();?>assets/js/plugins/tagsinput/tagsinput.min.js"></script>
<!--<script src="<?php echo BASE_uRL(); ?>assets/admin/js/trevor/underscore.js"></script>
<script src="<?php echo BASE_uRL(); ?>assets/admin/js/trevor/eventable.js"></script>
<script src="<?php echo BASE_uRL(); ?>assets/admin/js/trevor/sortable.min.js"></script>
<script src="<?php echo BASE_uRL(); ?>assets/admin/js/trevor/sir-trevor.js"></script>
<script src="<?php echo BASE_uRL(); ?>assets/admin/js/trevor/sir-trevor-bootstrap.js"></script>

<script src="<?php echo BASE_uRL(); ?>assets/js/pages/user-forms-editors.js"></script>-->
<script src="<?php echo BASE_uRL(); ?>assets/js/plugins/ckeditornew/ckeditor.js"></script>
<!-- <script src="//cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script> -->
<script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace('summernote_text');
</script>

<script type="text/javascript">
// function formSubmit(){
//     SirTrevor.onBeforeSubmit();
//     document.getElementById("contentForm").submit();
// }
</script>
<script src="<?php echo base_url();?>assets/js/plugins/fileupload/fileupload.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/holder/holder.min.js"></script>

<script src="<?php echo base_url();?>assets/allcp/forms/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/allcp/forms/js/additional-methods.min.js"></script>

<script src="<?php echo base_url();?>assets/js/plugins/tagsinput/tagsinput.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    function htmlEntities() {
        var str = document.getElementById('#summernote_text');

        return String(str).
        replace(/&/g, '&amp;').
        replace(/</g, '&lt;').
        replace(/>/g, '&gt;').
        replace(/"/g, '&quot;').
        replace(/'/g,'&apos');
}

  $('.cms').formValidation({
                framework: 'bootstrap',
                excluded: [':disabled'],
                icon: {
                    validating: 'glyphicon glyphicon-refresh'
                },
                row: {
                    invalid: 'has-error'
                },

                fields: {
                    reward_title: {
                        message: '',
                        validators: {
                            notEmpty: {
                                message: 'Reward title is required and can\'t be empty'
                            },
                            stringLength: {
                                min: 4,
                                message: 'Reward title is Minimum above 4 characters'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9 ]+$/i,
                                message: '<?php echo $this->lang->line("site_name_must");?>'
                            }
                        }
                    },
                    reward_url: {
                        validators: {
                            notEmpty: {
                                message: 'Reward url is required and can\'t be empty'
                            },
                            refexp: {
                                regexp: /^[`~,.<>;':"\/\[\]\|{}()=_+-]/,
                                message: 'The reward url is not a valid URL'
                            },
                            uri: {
                                message: 'The reward url is invalid'
                            },

                        }
                    },
                     reward_date: {
                        validators: {
                            notEmpty: {
                                message: 'Reward date is required and can\'t be empty'
                            },
                        }
                    }
                     reward_time: {
                        validators: {
                            notEmpty: {
                                message: 'Reward time is required and can\'t be empty'
                            },
                        }
                    },
                    reward_amount: {
                        validators: {
                            notEmpty: {
                                message: 'Reward amount is required and can\'t be empty'
                            },
                            regexp: {
                            regexp: /^[0-9.]+$/,
                            message: 'Please Enter Valide Amount'
                            }
                        },

                    },
                    
                }
            })

</script>
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

        $("#contentForm").validate({

            // States


            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            // Rules

            rules: {
                packagename: {
                    required: true
                }

                
            },

            // error message
            messages: {
                packagename: {
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
