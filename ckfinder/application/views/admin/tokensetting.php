    <?php 
    $admin_login=$this->session->userdata('admin_login');
    $data = $this->db->query("SELECT * FROM arm_tokens where id='".$admin_login."'")->result();    

    $token_name=$data[0]->token_name;
    $token_symbol=$data[0]->token_symbol;
    $total_token=$data[0]->total_token;
    $total_earntoken=$data[0]->total_earntoken;
    $logo=$data[0]->token_logo;
    ?>
    <!DOCTYPE html>
    <html>

    <head>
    <!--  Meta and Title  -->
    <?php $this->load->view('admin/meta'); ?>

    <!--  Fonts  -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

    <!--  CSS - allcp forms  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/allcp/forms/css/forms.css">

    <!--  CSS - theme  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/skin/default_skin/css/theme.css">

    <!--  Favicon  -->
    <!-- <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.ico"> -->


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

    <!--  /Column Left  -->

    <!--  Column Center  -->
    <div class="chute chute-center">

    <div class="mw1000 center-block">

    <!--  General Information  -->
    <div class="panel mb35">
    <form method="post" action="<?php echo base_url(); ?>admin/Sitesetting/tokenset" id="allcp-form" enctype="multipart/form-data">

    <div class="panel-heading">
    <span class="panel-title"><?php echo  "Coil Setting"; ?></span>
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



    <div class="section row mb10">
    <label for="sitename" class="field-label col-sm-4 ph10  text-left"><?php echo  "Coil Name" ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>


    <div class="col-sm-8 ph10">
    <label for="sitename" class="field prepend-icon">
    <input type="text" name="token_name" id="token_name" placeholder="<?php echo "Coil Name"; ?>"
    class="gui-input" value="
    <?php 
    if($token_name){
        echo $token_name;
    }else{
        echo "";
    }
    ?>
    " >
    <label for="sitename" class="field-icon">
    <i class="fa fa-shopping-cart"></i>
    </label>
    </label>
    <?php echo ucwords(form_error('token_name')); ?>
    </div>
    </div>



    <div class="section row mb10">
    <label for="siteurl"
    class="field-label col-sm-4 ph10 text-left"> <?php echo  "Coil Symbol"; ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

    <div class="col-sm-8 ph10">
    <label for="siteurl" class="field prepend-icon">
    <input type="text" name="token_symbol" id="token_symbol"
    class="gui-input"  placeholder="<?php echo  "$"; ?>"
    value="
    <?php 
    if($token_symbol){
        echo $token_symbol;
    }else{
        echo "";
    }
    ?>">
    <label for="siteurl" class="field-icon">
    <i class="fa fa-link"></i>
    </label>
    </label>
    <?php echo ucwords(form_error('token_symbol')); ?>
    </div>
    </div>



    <div class="section row mb10">
    <label for="store-email"
    class="field-label col-sm-4 ph10 text-left"><?php echo  "Total Coil Available For website User"; ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

    <div class="col-sm-8 ph10">
    <label for="adminmailid" class="field prepend-icon">
    <input type="text" name="total_token" id="total_token"
    class="gui-input" placeholder="<?php echo  "Total Coil"; ?>"
    value="
    <?php 
    if($total_token){
        echo $total_token;
    }else{
        echo "";
    }
    ?>">
    <label for="adminmailid" class="field-icon">
    <i class="fa fa-envelope-o"></i>
    </label>
    </label>
    <?php echo ucwords(form_error('total_token')); ?>
    </div>
    </div>



    <div class="section row mb10">
    <label for="sitemetatitle"
    class="field-label col-sm-4 ph10 text-left"><?php echo  "Total Earned Token By User"; ?><sup><em class="state-error"><?php echo  ucwords($this->lang->line('star')); ?></em></sup></label>

    <div class="col-sm-8 ph10">
    <label for="sitemetatitle" class="field prepend-icon">
    <input type="text" name="earn_token" id="earn_token"
    class="gui-input" placeholder="Earned Tokenn"
    value="
     <?php 
    if($total_earntoken){
        echo $total_earntoken;
    }else{
        echo "";
    }
    ?>">
    <label for="sitemetatitle" class="field-icon">
    <i class="fa fa-envelope-o"></i>
    </label>
    </label>
    <?php echo ucwords(form_error('earn_token')); ?>
    </div>
    </div>
  




    <hr class="short alt">


    <h6 class="mb15"><?php echo  "Logo"; ?></h6>

    <div class="fileupload fileupload-new" data-provides="fileupload">
    <div class="fileupload-preview thumbnail mb20">
    <img src="../<?php if(isset($logo)){echo $data;}?>" alt="holder">
    </div>
    <span class="btn btn-primary light btn-file btn-block ph5">
    <span class="fileupload-new"><?php echo  ucwords($this->lang->line('uploadimage')); ?></span>
    <span class="fileupload-exists"><?php echo  ucwords($this->lang->line('uploadimage')); ?></span>
    <input type="file"  name="token_logo" required value="if(isset($this->data['token_logo'])){echo $this->data['token_logo'];}?>">
    </span>

    <?php echo ucwords(form_error('token_logo')); ?>
    </div>

    


    <div class="panel-footer text-right mt10">
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
    sitename: {
    required: true
    },
    siteurl: {
    required: true,
    url:true
    },
    adminmailid: {
    required: true,
    email: true
    },
    sitemetatitle: {
    required: true
    },
    sitemetakeyword: {
    required: true
    },
    sitemetadescription: {
    required: true
    },
    sitestatus: {
    required: true
    },
    sitegooglecode: {
    required: true
    },
    terms: {
    required: true
    },
    allowpicture: {
    required: true
    },
    emailapproval: {
    required: true
    },
    mobileapproval: {
    required: true
    },
    usecaptcha: {
    required: true
    },
    allowlogin: {
    required: true
    },
    uniqueip: {
    required: true
    },
    uniqueemailid: {
    required: true
    },
    uniquemobile: {
    required: true
    },
    allowusers: {
    required: true
    },
    defaultsponsors: {
    required: true
    },
    referrallink: {
    required: true
    },
    token_logo: {
    extension: 'jpg|png|gif|jpeg'
    },
    advertise_cost:{
    required: true,
    number: true
    }

    },

    // error message
    messages: {
    sitename: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    siteurl: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>',
    url: '<?php echo ucwords($this->lang->line('errorurl')); ?>'
    },
    adminmailid: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>',
    email: '<?php echo ucwords($this->lang->line('erroremail')); ?>'
    },
    sitemetatitle: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    sitemetatitle: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    sitemetadescription: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    sitestatus: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    sitegooglecode: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    terms: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    token_logo: {
    extension: '<?php echo ucwords($this->lang->line('errorextension')); ?>'
    },
    allowpicture: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    emailapproval: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    mobileapproval: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    usecaptcha: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    allowlogin: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    uniqueip: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    uniqueemailid: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    uniquemobile: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    allowusers: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    defaultsponsors: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    referrallink: {
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
    },
    advertise_cost:{
    required: '<?php echo ucwords($this->lang->line('require')); ?>'
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
    </script>                                                                                                                                                                                                                       <!--  /Scripts  -->

    </body>

    </html>
