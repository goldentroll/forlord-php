<!DOCTYPE html>
<?php
ini_set('max_execution_time', 0);
?>


<html>

<style type="text/css">
    

    .field-icon {
  float: right;
  margin-right: 8px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
  cursor:pointer;
  color:#67d3e0;
}
.state-error
{
    display: block !important;
    margin-top: 6px;
    padding: 0 3px;
    font-family: Arial, Helvetica, sans-serif;
    font-style: normal;
    line-height: normal;
    font-size: 0.85em;
    color: #DE888A !important;
}


.panel{

  background: rgb(227,196,66);
background: linear-gradient(52deg, rgba(227,196,66,1) 0%, rgba(97,194,160,1) 0%, rgba(91,194,164,1) 0%, rgba(0,192,231,1) 100%);
border:0px;
border-radius: 20px;
}
.panel:before {
    transition: all 0.3s ease;
    -webkit-filter: blur(4px);
    filter: blur(4px);
  -webkit-filter: blur(0);
  filter: blur(0);
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Login Header -->
<?php $this->load->view('admin/login_header');?>


<style type="text/css">
  .state-error1
{
    display: block !important;
    margin-top: 6px;
    padding: 0 3px;
    font-family: Arial, Helvetica, sans-serif;
    font-style: normal;
    line-height: normal;
    font-size: 14px !important;
    color: red !important;
}
</style>

<body class="utility-page sb-l-c sb-r-c">

<!--  Body Wrap   -->
<div id="main" class="animated fadeIn">

    <!--  Main Wrapper  -->
    <section id="content_wrapper" class="">

       <!--  <div id="canvas-wrapper">
            <canvas id="demo-canvas"></canvas>
        </div> -->

        <!--  Content  -->
        <section id="content">

        <?php
            $sitelogo = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'",'arm_setting');
            $width = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='width'",'arm_setting');
            $height = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='height'",'arm_setting');
        ?>

            <!--  Login Form  -->
            <div class="allcp-form theme-primary mw350" id="login">
          
                <div class="panel mw350" >

      <div class="text-center mb20">
                    <center>
                    <img style="width:<?php echo $width->ContentValue ; ?>px; height:<?php echo $height->ContentValue;?>px;"  src="<?php echo base_url(). $sitelogo->ContentValue;?>" class="img-responsive" alt="Logo"/>
                    </center>
                </div> 

                    <div class="section row mbn">
                        <?php if($this->session->flashdata('error_message')) { ?>    
                            <div class="col-md-12 bg-danger pt10 pb10 ">
                                <span class=""><?php echo $this->session->flashdata('error_message');?></span>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <form method="post" action="" id="allcp-form">
                        <div class="panel-body pn mv10">


<!-- <div class="input-group">
<span class="input-group-addon" id="sizing-addon1">@</span>
<input type="text" class="form-control" placeholder="Username">
</div> -->
                            <div class="section">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user-circle-o text-info" aria-hidden="true"></i></span>
                                <input type="text" name="username" id="username" class="gui-input" placeholder="Username" value="<?php echo set_value('username');?>">
                                <?php echo form_error('username'); ?>
                                </div>
                            </div>
                            <!--  /section  -->

                           

                            <div class="section" >

                                   <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-key text-info" aria-hidden="true"></i></span>
                                    <input type="password" name="password" id="password" class="gui-input" placeholder="Password" value="<?php echo set_value('password');?>">
                                    
                                    <label for="password" class="field-icon">
                                    <span toggle="#password" class="fa fa-lg fa-eye field-icon toggle-password" style="color:#67d3e0;cursor:pointer;"></span> 
                                    </label>
                                 
                                <?php echo form_error('password'); ?>
                            </div>
                            </div>
                         
                            <div class="section">
                            <?php   
                                $captchaset = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='usecaptcha'", "arm_setting");
                                if($captchaset->ContentValue=="On") {
                                    $sitekey = $this->common_model->GetRow("Page='reCaptcha' AND KeyValue='siteKey'", "arm_setting");
                            ?>
                                    <div class="g-recaptcha" data-sitekey="<?php echo $sitekey->ContentValue;?>"></div>
                                    
                           <?php 
                                } 
                           ?>
                           </div>
                           <?php echo form_error('g-recaptcha-response'); ?>
                            <div class="section" style="margin-bottom: 20px;">
                                <div class="bs-component pull-left pt5">
                                    <div class="radio-custom radio-primary mb5 lh25">
                                        <input type="radio" id="remember" name="remember">
                                        <label for="remember">Remember me</label>
                                    </div>
                                </div>

                                <!-- <button type="submit" class="btn btn-bordered btn-primary pull-right">Log in</button> -->
                            </div>


                <br>
                <br>
                <br>
                            <div class="col-lg-12">
                                 <input type="submit" style="width: 100%" class="btn btn-bordered btn-info" value="Log in"/>
                             </div>
                            <!--  /section  -->

                        </div>
                        <!--  /Form  -->
                    </form>
                </div>
                <!--  /Panel  -->
            </div>
            <!--  /Spec Form  -->

        </section>
        <!--  /Content  -->

    </section>
    <!--  /Main Wrapper  -->

</div>
<!--  /Body Wrap   -->

<!--  Login Footer   -->
<?php $this->load->view('admin/login_footer');?>
<?php //$this->load->view('admin/activemenu');?>


<script src="<?php echo base_url();?>assets/allcp/forms/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/allcp/forms/js/additional-methods.min.js"></script>
<script type="text/javascript">
(function($) {

    $(document).ready(function() {

        "use strict";
        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        $.validator.methods.smartCaptcha = function(value, element, param) {
            return value == param;
        };

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
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 16
                }
            },

            // error message
            messages: {
                username: {
                    required: 'Please enter username'
                },
                password: {
                    required: 'Please enter password'
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


        $(".toggle-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

    });

})(jQuery);
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>

</html>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vanta/0.5.21/vanta.cells.min.js" integrity="sha512-2ploASHVKSlsWjfgEz+9NRtgI87KDvspC2RUvS77LpV3Jyuny9Kmzx0+sxcy6Uw45ZXWhZS1CDEdMPtIiTvkLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vanta/0.5.21/vanta.waves.min.js" integrity="sha512-OctlSjhUW90StGtQUwB1125p1fNP4wKyCxJsNA4VNhlXEyP8ks0KAp2Cmesl53AWpo7rQQeWhnxa4v9ehQjetw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
  VANTA.WAVES({
  el: "#main",
  mouseControls: true,
  touchControls: true,
  gyroControls: false,
  minHeight: 200.00,
  minWidth: 200.00,
  scale: 1.00,
  color: 0x7ca5f7,
  scaleMobile: 1.00
  })
  </script>