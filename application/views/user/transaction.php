<!doctype html>
<html lang="en">
<head>
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styl/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
<body class="">
<div class="wrapper dash-bg">
<?php $this->load->view('user/user_aside');?>
<div id="content">
    <div id="content">
    <div class="admin_main">
    <button type="button" id="sidebarCollapse" class="toggle">
    <div class="toggle_admin"> <img src="<?php echo base_url();?>assets/styl/images/toggle-ic.png" class="img-fluid" /> </div>
    </button>
    <div class="admin-top position-relative">
    <div class="row">
    <div class="col-sm-12">
    <div class="d-lg-flex justify-content-between">
    <div class="admin-head position-relative">
    <h3 class="fw-normal2 text-white"> History </h3>
    </div>
   <div class="dash-btn"><span class="text-white text-grad">Server Time: <? echo date('M d Y'); ?> <?php echo date("h:i:sa");?>   /  </span>  <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a></div>
    </div>
    </div>
    </div>
    </div>
    <div class="admin-middle">
    <div class="container-fluid">


<style type="text/css">
 label
 {
    color:white;
    margin-bottom: 10px;
    font-weight: 700;
 }
 .dataTables_info
 {
    color:white;
    margin-bottom: 10px;
    font-weight: 700;
 }

  @media only screen and (max-width: 991px) {
 .trans-table 
 {
    width: 100% !important;
 }
}
 @media only screen and (max-width:767px) {
 .trans-table 
 {
    width: 100% !important;
 }
}
 @media only screen and (max-width:575px) {
 .trans-table 
 {
    width: 100% !important;
 }
}

table {
  caption-side: bottom;
  border-collapse: collapse;
  width: 100% !important;
  text-align: center;
  white-space: nowrap;
  }

  .dataTables_length label
  {
  display: inline-flex !important;
  max-width: 100%;
  margin-bottom: 5px;
  font-weight: 700;
  }

  </style>

  <style>


  table.dataTable th:nth-child(1) {
  width: 100px;
  max-width: 20px;
  word-break: break-all;
  white-space: pre-line;
  }


  table.dataTable th:nth-child(2) {
  width: 100px;
  max-width: 20px;
  word-break: break-all;
  white-space: pre-line;
  }

 table.dataTable th:nth-child(3) {
  width: 100px;
  max-width: 20px;
  word-break: break-all;
  white-space: pre-line;
  }

   table.dataTable th:nth-child(4) {
  width: 100px;
  max-width: 20px;
  word-break: break-all;
  white-space: pre-line;
  }

  }
  </style>

    <div class="row">
    <div class="col-sm-12">
    <div class="title text-center"> <span class=" text-grad">History</span>
    <h2 class="text-white fw-bold mb-3 text-uppercase">Transaction history</h2>
    </div>
    </div>
    </div>


    <div class="row">
    <!--  Column search  -->
    <div class="col-md-12">
    <div class="panel panel-visible" id="spy6" style="min-height: 200px;">
    <div class="panel-heading">
    <div class="panel-title hidden-xs">
    <?php echo $this->lang->line('label_filter_title'); ?>
    </div>
    </div>
    <hr class="short">
    <div class="col-lg-11">
    <div class="trans-table bg-primary rounded-1">
    <form method="post" action="<?php echo base_url().'user/transaction/search';?>" name="search_form" style="padding: 24px;">
 <div class="row">


    <div class="col-lg-3 ph10">
    <h6 class="mb15"> <?php echo $this->lang->line('label_filter_bytype'); ?></h6>
    <label class="field select">
    <select id="filter-status" name="trans_type" class="form-select">
    <option value="" selected="selected">Transaction Type</option>
    <?php
    $types = $this->data['types'];

    foreach($types as $row) {  if($row->TypeId!=26 && $row->TypeId!=2) {?>

    <option value="<?php echo $row->TypeId;?>" <?php echo set_select('trans_type', $row->TypeId); ?>><?php echo $row->TransactionName;?></option>

    <?php } } ?>

    </select>
    <i class="arrow double"></i>
    </label>
    </div>


     <div class="col-lg-3 ph10">
    <h6 class="mb15"> <?php echo $this->lang->line('label_filter_fromdate'); ?></h6>
    <label for="datepicker1" class="field prepend-icon mb5">
    <input type="text" id="datepicker1" name="datepicker1" class="form-select"  placeholder="From" value="<?php echo set_value('datepicker1');?>">
 
    </label>
    </div>

     <div class="col-lg-3 ph10">
    <h6 class="mb15"> <?php echo $this->lang->line('label_filter_todate'); ?></h6>
    <label for="datepicker2" class="field prepend-icon">
    <input type="text" id="datepicker2" name="datepicker2" class="form-select" placeholder="To" value="<?php echo set_value('datepicker2');?>">
   
    </label>
    </div>

    <div class="col-md-3 ph10" style="margin-top:10px;">
    <button class="btn btn-primary" type="submit" name="search" >Search</button>
    </div>
    </div>


    </form>
    </div>
    </div>
    </div>
    </div>


    <!--  /Column Search  -->
    </div>
    <br>
    <div class="row">
    <div class="col-lg-11">
    <div class="trans-table bg-primary rounded-1">
    <div class="table-responsive">

<table id="example1">
        <thead>
        <tr>
        <th><?php echo  ucwords($this->lang->line('label_sno'));?></th>
        <th><?php echo  ucwords($this->lang->line('label_type'));?></th>
        <th><?php echo  ucwords($this->lang->line('label_id'));?></th>
        <th><?php echo  ucwords($this->lang->line('label_date'));?></th>
        <th><?php echo  ucwords($this->lang->line('label_description'));?></th>
        <th><?php echo  '[ '.$this->lang->line('plus').' ] '.ucwords($this->lang->line('label_credit'));?></th>
        <th><?php echo  '[ '.$this->lang->line('minus').' ] '.ucwords($this->lang->line('label_debit'));?></th>
        <th><?php echo  ucwords($this->lang->line('label_balance'));?></th>



        </tr>
        </thead>
        <tbody>
        <?  if($this->data['transaction']){
        $i=1;
        for($j=0; $j< count($this->data['transaction']);$j++ ){


        $typedetail = $this->db->query("SELECT * FROM arm_transaction_type WHERE TypeId ='".$this->data['transaction'][$j]->TypeId."'");
        if($typedetail)
        {


        if(isset($typedetail->row()->TransactionName))
        {
        $type=$typedetail->row()->TransactionName;
        }
        else
        {
        $type="---";
        }
        }
        else
        {
        $type="---";
        }


        if($this->data['transaction'][$j]->Debit<0)
        {
            $debits = 0;
        }
        else
        {
            $debits=$this->data['transaction'][$j]->Debit;
        }

            if($this->data['transaction'][$j]->Credit=="")
            {
               $Credit = 0;
            }
            else
            {
              $Credit=$this->data['transaction'][$j]->Credit;
            }


        if($this->data['transaction'][$j]->TypeId!=30 && $this->data['transaction'][$j]->TypeId!=31)
        {
        ?>
        <tr>
        <td><?php echo  $i++;?></td>
        <td><?php echo  $type;?></td>
        <td><?php if($this->data['transaction'][$j]->TransactionId!=''){echo $this->data['transaction'][$j]->TransactionId;}else{echo"--";}?></td>
        <td><?php echo  date(' M-d-Y  - h:i:s ',strtotime($this->data['transaction'][$j]->DateAdded));?></td>
        <td><?php echo  $this->data['transaction'][$j]->Description;?></td>
        <td><?php echo  $CurrencySymbol." ".number_format($Credit,currency_decimal());?></td>
        <td><?php echo  $CurrencySymbol." ".number_format($debits,currency_decimal());?></td>
        <td><?php echo  $CurrencySymbol." ".number_format($this->data['transaction'][$j]->Balance,currency_decimal());?></td>

        </tr>

        <?php  } }} ?>   
        </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
    <?php $this->load->view('user/login_footer');?>
    </div>
    </div>


</div>
</div>
</div>
</body>
</html>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker1" ).datepicker();
    $( "#datepicker2" ).datepicker();
  } );
  </script>

    <script src="<?php echo base_url();?>assets/user/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script>
    $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="<?php echo base_url();?>assets/user/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/user/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/user/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url();?>assets/user/js/plugins/morris/morris.min.js"></script>
<!--     <script>
    $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false
    });
    });
    </script> -->

    <link href="//cdn.datatables.net/1.10.8/css/dataTables.dataTables.min.css" rel="stylesheet"/> 
<link href="//cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css" rel="stylesheet"/>
<script src="//cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>


    <script>
    $(function () {



// "paging": true,
// "lengthChange": false,
// "searching": false,
// "ordering": true,
// "info": true,
// "autoWidth": false

$('#example1').DataTable({
autoWidth:true,
searching:true,
lengthChange:true,
ordering:true,
paging:true,
info:true,
responsive: true
});

    });

  $(window).resize(function () {
  $("#example1").resize();
  });
    </script>
    <script src="<?php echo base_url();?>assets/user/js/js/app.min.js"></script>
    <script src="<?php echo base_url();?>assets/user/js/js/pages/dashboard.js"></script>
    <!--    <script src="js/js/demo.js"></script>-->
    <script src="<?php echo base_url();?>assets/user/js/justgage.js"></script>
    <script>
    var g1, g2, g3;

    document.addEventListener("DOMContentLoaded", function(event) {
    g1 = new JustGage({
    id: "g1",
    value: getRandomInt(350, 980),
    min: 350,
    max: 980,
    /*title: "Lone Ranger",*/
    label: "miles traveled"
    });

    g2 = new JustGage({
    id: "g2",
    value: 32,
    min: 50,
    max: 100,
    title: "Empty Tank",
    label: ""
    });

    g3 = new JustGage({
    id: "g3",
    value: 120,
    min: 50,
    max: 100,
    title: "Meltdown",
    label: ""
    });
    var g5 = new JustGage({
    id: "g5",
    value: getRandomInt(0, 100),
    min: 0,
    max: 100,
    /*title: "Animation Type",*/
    label: "",
    startAnimationTime: 2000,
    startAnimationType: ">",
    refreshAnimationTime: 1000,
    refreshAnimationType: "bounce"
    });
    setInterval(function() {
    g1.refresh(getRandomInt(350, 980));
    g2.refresh(getRandomInt(0, 49));
    g3.refresh(getRandomInt(101, 200));
    g6.refresh(getRandomInt(0, 100));
    }, 2500);
    });
    </script>
    <script>
    $(function() {

    $("#btnExport").click(function(){
    // download('member.xls', $('.export_content').html());
    download('<?php echo  $this->lang->line("page_title")."-".date("dMY");?>.pdf', $( ".export_content .row:eq( 1 )" ).html());
    });

    });
    function download(filename, text) {

    var pom = document.createElement('a');
    pom.setAttribute('href', 'data:application/vnd-ms-excel;charset=utf-8,' + encodeURIComponent(text));
    pom.setAttribute('download', filename);

    if (document.createEvent) {
    var event = document.createEvent('MouseEvents');
    event.initEvent('click', true, true);
    pom.dispatchEvent(event);
    }
    else {
    pom.click();
    }
    }
    </script>
    </body>
    </html>

