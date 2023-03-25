    <?php
    ini_set('max_execution_time', 0);

    ?>
    <!DOCTYPE html>
    <html>

    <head>
    <!--  Meta and Title  -->
    <?php $this->load->view('admin/meta');  ?>

    <!--  Fonts  -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

    <!--  CSS - theme  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/skin/default_skin/css/theme.css">

    <!--  CSS - allcp forms  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/allcp/forms/css/forms.min.css">

    <!--  Plugins  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/plugins/c3charts/c3.min.css">

    </head>

    <body class="sales-stats-page">

    <!--  Customizer  -->
    <?php $this->load->view('admin/customizer');?>

    <!--  Body Wrap   -->
    <div id="main">

    <!--  Header   -->
    <?php $this->load->view('admin/topnav');?>

    <!--  Sidebar   -->
    <?php $this->load->view('admin/sidebar');?>

    <!--  Main Wrapper  -->
    <section id="content_wrapper">

    <!--  Topbar Menu Wrapper  -->
    <?php $this->load->view('admin/toper');?>

    <!--  Topbar Menu Wrapper  -->
    <?php $this->load->view('admin/topmenu');?>

<style type="text/css">
.card-img-absolute {
position: absolute;
top: 0;
right: 0;
height: 100%;
}
#content .panel
{
    box-shadow: 1px 1px 20px 3px rgba(163, 93, 255, 0.35) !important;
    border-radius: 20px;
}
#content .panel .panel-heading .panel-title {
    font: 700 20px/24px 'Lato';
    letter-spacing: 0;
    padding: 0;
    color: rgb(227,196,66);
    }
</style>

    <!--  Content  -->
    <section id="content" class="table-layout animated fadeIn">

    <!--  Column Center  -->
    <div class="chute chute-center">

    <div class="row">
    <div class="col-sm-6 col-md-4 ph10" style="">
    <div class="panel panel-tile">
    <div class="panel-body"style="background: linear-gradient(to right, #ffbf96, #fe7096) !important;color:white;">
    <div class="row pv10" > 
    <div class="col-xs-5 ph10"><img style="height: 117px;" src="<?php echo base_url();?>assets/img/avatars/stats-ic3.png"
    class="img-responsive mauto" alt=""/></div>
     <img src="https://www.bootstrapdash.com/demo/purple-admin-free/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
    <div class="col-xs-7 pl5">
    <h6 class="text-white"><?php echo strtoupper('Total Package activation');?></h6>
    <?php 
    $NewOrder = $this->common_model->GetTodayorder();
    $TOtal_activation = $this->db->query("SELECT MemberId, sum(Credit) as earns FROM arm_history WHERE TypeId IN(19) ")->row();

    ?>
    <h4 class="fs30 mt5 mbn text-white"><?php echo currency().number_format(($TOtal_activation->earns) ? $TOtal_activation->earns : '0',currency_decimal());?></h4>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="col-sm-6 col-md-4 ph10">
    <div class="panel panel-tile">
    <div class="panel-body" style="background: linear-gradient(to right, #90caf9, #047edf 99%) !important;">
    <div class="row pv10">
    <div class="col-xs-5 ph10"><img  style="height:117px" src="<?php echo base_url();?>assets/img/avatars/shell-1.png"
    class="img-responsive mauto" alt=""/></div>
     <img src="https://www.bootstrapdash.com/demo/purple-admin-free/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
    <div class="col-xs-7 pl5">
    <h6 class="text-white">TODAY COMMISSIONS</h6>
    <?php 
    $admin_commision = $this->common_model->GetTodayComm();
    ?>
    <h4 class="fs30 mt5 mbn text-white"><?php echo currency().number_format(($admin_commision) ? $admin_commision : '0', currency_decimal());?></h4>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="hidden-sm col-md-4 ph10">
    <div class="panel panel-tile">
    <div class="panel-body" style="background: linear-gradient(to right, #84d9d2, #07cdae) !important;">

    <img src="https://www.bootstrapdash.com/demo/purple-admin-free/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">

    <div class="row pv10">
    <div class="col-xs-5 ph10"><img style="height: 117px;" src="<?php echo base_url();?>assets/img/avatars/stats-ic6.png"
    class="img-responsive mauto" alt=""/></div>
    <div class="col-xs-7 pl5">
    <h6 class="text-white">TODAY SIGN-UPS</h6>
    <?php 
    $NewMember = $this->common_model->GetAllMembers();
    ?>
    <h2 class="fs30 mt5 mbn text-white"><span style="font-size:30px"><?php echo ($newmember) ? $newmember: '0';?></span></h2>
    </div>
    </div>
    </div>
    </div>
    </div>

     <div class="col-sm-6 col-md-4 ph10">
    <div class="panel panel-tile">
    <div class="panel-body" style="background: linear-gradient(to right, #90caf9, #047edf 99%) !important;">
    <div class="row pv10">
    <div class="col-xs-5 ph10"><img  style="height:117px" src="<?php echo base_url();?>assets/img/avatars/shell-1.png"
    class="img-responsive mauto" alt=""/></div>
     <img src="https://www.bootstrapdash.com/demo/purple-admin-free/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
    <div class="col-xs-7 pl5">
    <h6 class="text-white">TOTAL COMMISSIONS PAID</h6>
    <?php 
    $admin_commision = $this->common_model->GetTotalComm();
    ?>
    <h4 class="fs30 mt5 mbn text-white"><?php echo currency().number_format(($admin_commision) ? $admin_commision : '0', currency_decimal());?></h4>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

        <div class="row">
        <div class="col-xs-12">  
        <div class="panel">
        <div class="panel-heading">
        <span class="panel-title hidden-xs"> Members Statistics</span>
        </div>

        <div class="panel-body pn">
        <div id="container"></div>
        </div>

        </div>
        </div>
        </div>

 <br>

         <div class="row">
        <div class="col-xs-12">  
        <div class="panel">
        <div class="panel-heading">
        <span class="panel-title hidden-xs"> Earnings Statistics</span>
        </div>

        <div class="panel-body pn">
        <div id="container2"></div>
        </div>

        </div>
        </div>
        </div>

        <br>

    <div class="row">
    <div class="col-xs-12">
    <div class="panel">
    <div class="panel-heading">
    <span class="panel-title hidden-xs"> Top 10 Recruiters</span>
    </div>

    <div class="panel-body pn">
    <div class="table-responsive">
    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
    <thead>
    <tr class="bg-light">
    <th class="">Image</th>
    <th class="">User Name</th>
    <th class=""># Recruited</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($members) {
    arsort($members,true);
    $i = 1;
    foreach ($members as $key => $value) {
    if($i < 11) {
    $member = $this->common_model->GetCustomer($key);
    if($member) {
    ?>
    <tr>

    <?php 
    if($member->ProfileImage) 
    $profile_image = base_url().$member->ProfileImage;
    else 
    $profile_image = base_url().'assets/img/pages/clipart2.png';
    ?>
    <?php 
    if($member->MemberId == '1'){

    if($member->ProfileImage) {
    $profile_image = base_url().'uploads/UserProfileImage/'.$member->ProfileImage;
    }
    else {
    $profile_image = base_url().'assets/img/pages/clipart2.png';

    }
    } 
    ?>
    <td class=""><img class="img-circle" style="width:50px;" src="<?php echo $profile_image?>" alt="<?php echo $member->UserName;?>"/></td>
    <td class=""><?php echo $member->UserName;?></td>
    <td class=""><?php echo ($value) ? $value : '0';?></td>
    </tr>
    <?php
    }
    $i++;
    }
    }
    } else {   

    ?>
    <tr>
    <td class="text-center" colspan="8">No Records Found!</td>
    </tr>
    <?php } ?>
    </tbody>

    </table>
    </div>
    </div>
    </div>
    </div>
    <div class="col-xs-12">
    <div class="panel">
    <div class="panel-heading">
    <span class="panel-title hidden-xs"> Top 10 Earners</span>
    </div>

    <div class="panel-body pn">
    <div class="table-responsive">
    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
    <thead>
    <tr class="bg-light">
    <th class="">Image</th>
    <th class="">User Name</th>
    <th class=""># Earnings</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($earners) {

    foreach ($earners as $earn) {
    $customer1 = $this->common_model->GetCustomer($earn->MemberId);
    if($customer1) {

    ?>
    <tr>

    <?php 
    if($customer1->ProfileImage) 
    $profile_image = base_url().$customer1->ProfileImage;
    else 
    $profile_image = base_url().'uploads/UserProfileImage/profile_avatar.jpg';
    ?>

    <?php 
    if($customer1->MemberId == '1'){

    if($customer1->ProfileImage) {
    $profile_image = base_url().'uploads/UserProfileImage/'.$customer1->ProfileImage;
    }
    else {
    $profile_image = base_url().'uploads/UserProfileImage/profile_avatar.jpg';

    }
    } 
    ?>
    <td class=""><img class="img-circle" style="width:50px;" src="<?php echo $profile_image?>" alt="<?php echo $customer1->UserName;?>"/></td>
    <td class=""><?php echo $customer1->UserName;?></td>
    <td class=""><?php echo $CurrencySymbol." ".number_format($earn->earns,2);?></td>
    </tr>
    <?php 
    }
    }
    } else {   
    ?>
    <tr>
    <td class="text-center" colspan="8">No Records Found!</td>
    </tr>
    <?php } ?>
    </tbody>

    </table>
    <?php //echo $balance->Balance;?>
    </div>
    </div>
    </div>
    </div>
    <div class="col-xs-12">
    <div class="panel">
    <div class="panel-heading">
    <span class="panel-title hidden-xs">Top 10 Package activation</span>
    </div>

    <div class="panel-body pn">
    <div class="table-responsive">
    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
    <thead>
    <tr class="bg-light">
    <th class="">Image</th>
    <th class="">User Name</th>
    <th class=""># Package activation</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($purchased) {
    foreach ($purchased as $purchase) {
    if($purchase->MemberId) {
    $customer = $this->common_model->GetCustomer($purchase->MemberId);
    if($customer) {
    ?>
    <tr>

    <?php 
    if($customer->ProfileImage) 
    $profile_image = base_url().$customer->ProfileImage;
    else 
    $profile_image = base_url().'uploads/UserProfileImage/profile_avatar.jpg';
    ?>

    <?php 
    if($customer->MemberId == '1'){

    if($customer->ProfileImage) {
    $profile_image = base_url().'uploads/UserProfileImage/'.$customer->ProfileImage;
    }
    else {
    $profile_image = base_url().'uploads/UserProfileImage/profile_avatar.jpg';

    }
    } 
    ?>
    <td class=""><img class="img-circle" style="width:50px;" src="<?php echo $profile_image?>" alt="<?php echo $customer->UserName;?>"/></td>
    <td class=""><?php echo $customer->UserName;?></td>
    <td class=""><?php echo $CurrencySymbol." ".number_format($purchase->earns,2);?></td>
    </tr>
    <?php 
    }
    }
    }
    } else {   
    ?>
    <tr>
    <td class="text-center" colspan="8">No Records Found!</td>
    </tr>
    <?php } ?>
    </tbody>

    </table>
    </div>
    </div>
    </div>
    </div>
    </div>

    <div class="row" style="display: none;">
    <div class="col-md-12">
    <div class="panel" id="pchart6">
    <div class="panel-heading">
    <span class="panel-title text-info fw600"> <i class="fa fa-pencil hidden"></i> Credit and Debit chart</span>
    </div>
    <div class="panel-menu br3 mt20">
    <div class="chart-legend" data-chart-id="#high-line3">
    <a type="button" data-chart-id="0" class="legend-item btn btn-sm btn-warning">Income</a>
    <a type="button" data-chart-id="2" class="legend-item btn btn-info btn-sm">Sales</a>
    </div>
    </div>
    <div class="panel-body pn">
    <div id="high-line3" style="width: 100%; height: 410px; margin: 0 auto"></div>
    </div>
    </div>
    </div>
    </div>


    </div>
    <!--  /Column Center  -->

    </section>
    <!--  /Content  -->

    </section>




    </div>
    <!--  /Body Wrap   -->

    <!-- footer -->

    <script src="<?php echo base_url();?>assets/js/jquery/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/utility/utility.js"></script>
    <script src="<?php echo base_url();?>assets/js/demo/demo.js"></script>
    <script src="<?php echo base_url();?>assets/js/main.js"></script>


    <script src="<?php echo base_url();?>assets/js/demo/widgets_sidebar.js"></script>

    <!--  Page JS  -->

    <script type="text/javascript">
    jQuery(document).ready(function () {

    });

    </script>


<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/hollowcandlestick.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">

 var base_url = '<?php echo base_url();?>assets/js/chart.js';


    $.getJSON('<?php echo base_url();?>chart', function (data) {

    Highcharts.stockChart('container', {
        rangeSelector: {
            selected: 1
        },
        navigator: {
            series: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        series: [{
            type: 'column',
            name: 'Member count',
            data: data
        }]
    });
   

    });




    $.getJSON('<?php echo base_url();?>earningschart', function (data) {

    Highcharts.stockChart('container2', {
        rangeSelector: {
            selected: 2
        },
        navigator: {
            series: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        series: [{
            type: 'column',
            name: 'Member Earnings  &#8366',
            data: data
        }]
    });
   

    });

    


    </script>



    <script type="text/javascript">
    jQuery(document).ready(function () {

    "use strict";

    // Init Theme Core
    Core.init();

    // Init Demo JS
    Demo.init();

    // ChighCharts JS
    demoHighCharts.init();
    /* Hichcharts functions */


    });

    var demoHighCharts = function () {

    // Hichcharts colors
    var highColors = [bgWarning, bgPrimary, bgInfo, bgAlert,
    bgDanger, bgSuccess, bgSystem, bgDark
    ];

    // Spark colors
    var sparkColors = {
    "primary": [bgPrimary, bgPrimaryLr, bgPrimaryDr],
    "info": [bgInfo, bgInfoLr, bgInfoDr],
    "warning": [bgWarning, bgWarningLr, bgWarningDr],
    "success": [bgSuccess, bgSuccessLr, bgSuccessDr],
    "alert": [bgAlert, bgAlertLr, bgAlertDr]
    };

    // High Charts Demo
    var demoHighCharts = function () {


    var demoHighLines = function () {


    var line3 = $('#high-line3');

    if (line3.length) {

    // High Line 3
    $('#high-line3').highcharts({
    credits: false,
    colors: highColors,
    chart: {
    backgroundColor: '#f4f7f9',
    className: 'br-r',
    type: 'line',
    zoomType: 'x',
    panning: true,
    panKey: 'shift',
    marginTop: 25,
    marginRight: 1
    },
    title: {
    text: null
    },
    xAxis: {
    gridLineColor: '#e5eaee',
    lineColor: '#e5eaee',
    tickColor: '#e5eaee',
    categories: ['Jan', 'Feb', 'Mar', 'Apr',
    'May', 'Jun', 'Jul', 'Aug',
    'Sep', 'Oct', 'Nov', 'Dec'
    ]
    },
    yAxis: {
    min: 0,
    tickInterval: 10,
    gridLineColor: '#e5eaee',
    title: {
    text: null
    }
    },
    plotOptions: {
    spline: {
    lineWidth: 3
    },
    area: {
    fillOpacity: 0.2
    }
    },
    legend: {
    enabled: false
    },
    series: [{
    name: 'income',
    data: [0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00]
    }, {
    name: 'Expense',
    data: [0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00]
    }]
    });

    }

    }; // End High Line Charts Demo

    // Init Chart Types

    demoHighLines();


    }; // End High Charts Demo

    return {
    init: function () {
    // Init Demo Charts
    demoHighCharts();
    }
    }
    }();
    </script>

    </body>

    </html>
