<!doctype html>
<html lang="en">
<?php $this->load->view('user/meta');?>
<?php $this->load->view('user/index_header');?>
<body>
<style type="text/css">
  .investors-item--data
  {
  margin:20px;
  }
  .percent {
  font-size: 30px;
  line-height: 36px;
  font-weight: bold;
  font-family: var(--bs-font-sans-serifm);
  margin-top: 40px;
  }
  .active .investors-item--wraper
  {
  background: linear-gradient(to right, #4633F0 0%, #FC6296 26%, #FEA345 100%) !important; 
  }
  .unapprove .investors-item{
     cursor: not-allowed !important;
  }
  .unapprove 
  {

   pointer-events: none;  
  }
  .label-danger p
  {
    color: red;
    font-weight: 600;
    font-size: 14px;
  }
  input[type=radio]
  {
    display: none;
  }
  .banner-cont .btn-primary
  {
    margin-left: 150px;
  }
  .level-grad-block {
    padding: 10px 5px 15px 5px;
    border-radius: 20px 0 0 20px;
    min-width: auto !important;
    max-width: 107px;
  }
.faq-left ul {
  
    padding: 10px !important;
    margin-top: 0px !important;
}
}
</style>
<?php
$sitelogo = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'",'arm_setting');
$width = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='width'",'arm_setting');
$height = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='height'",'arm_setting');
?>
<section class="banner-bg position-relative bann-af">
  <div class="position-relative z-in1">
    <header>
      <div class="container">
        <div class="row">
          <div class="col-lg-12 order-xl-1 order-3">
            <div class="position-relative z-in1">
              <div class="navigation-rotate">
                <nav class="navbar navbar-expand-lg navbar-light">
                  <div class="nav-head">
                    <h4 class="main-menu text-secondary">Main Menu </h4>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainnavigation" aria-controls="mainnavigation" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                  </div>
                  <div class="collapse navbar-collapse" id="mainnavigation">
                    <ul class="text-center list-unstyled head-nav-link">
                      <li class="nav-item"> <a href="<?php echo base_url();?>" class=""> Home </a> </li>
                      <li class="nav-item"> <a href="<?php echo base_url();?>user/cms/Aboutus" class=""> About Us </a> </li>
                      <li class="nav-item"> <a href="<?php echo base_url();?>user/faq" class=""> FAQ </a> </li>
                      <li class="nav-item"> <a href="<?php echo base_url();?>#inves" class=""> Business plans </a> </li>
                      <li class="nav-item"> <a href="<?php echo base_url();?>user/latestnews" class=""> News </a> </li>
                    </ul>
                  </div>
                </nav>
              </div>
            </div>
          </div>
          <div class="col-lg-3 order-xl-2 order-1">
            <div class="logo">
              <?php 
    $sitelogo = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'",'arm_setting'); 
    if($sitelogo) {
    ?>
              <a href="<?php echo base_url();?>">
              <!--     <img style="height:49px;" src="<?php echo base_url().$sitelogo->ContentValue;?>" class="image-fluid" />  -->
              <img style="width:<?php echo $width->ContentValue ; ?>px; height:<?php echo $height->ContentValue;?>px;"  src="<?php echo base_url(). $sitelogo->ContentValue;?>" class="image-fluid" alt="Logo"/></a>
              <?php } else { ?>
              <a href="<?php echo base_url();?>"> <img style="height:49px;" src="<?php echo base_url();?>assets/user/img/logo.png" class="image-fluid" /></a>
              <?php	
    }
    ?>
            </div>
          </div>
          <div class="col-xl-6 col-lg-9 order-xl-3 order-2">
            <div class="d-sm-flex align-items-center justify-content-around"> <?php print_r($topbar_content);?> </div>
          </div>
          <div class="col-xl-3 order-xl-4 order-4">
            <div class="head-btn">
              <?php 
    if($this->session->userdata('logged_in') && $this->session->userdata('user_login') && $this->session->userdata('MemberID')) 
    {
    ?>
              <a href="<?php echo base_url(); ?>user/dashboard" class="btn btn-primary">My Account</a> <a href="<?php echo base_url(); ?>login/logout" class="btn btn-secondary">Logout</a>
              <?php
    }
    else{
    ?>
              <a href="<?php echo base_url(); ?>user/register" class="btn btn-primary">Sign up</a> <a href="<?php echo base_url(); ?>login" class="btn btn-secondary">login</a>
              <?php
    }
    ?>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="banner-sec">
      <div class="container">
        <div class="row">
          <div class="col-xl-4">
            <div class="banner-img"> <img src="<?php echo base_url()?>assets/styl/images/banner-img.png" class="image-fluid"></div>
          </div>
          
           <div class="col-xl-8">
          <?php
    print($index_content);
    ?>
    </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="how-sec position-relative how-af">
  <div class="position-relative z-in1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="title text-center position-relative tit-af">
            <div class="position-relative z-in1"> <span class="text-grad" style="display: none;">works</span><br>
              <h2 class="text-white pla fw-bold"><?php print_r($howitswork_title);?></h2>
            </div>
          </div>
        </div>
        </div>
        
         <div class="row"> 
          <div class="col-lg-12">
        
        <?php
    print($howits_content);
    ?>
    
    </div></div>
      
    </div>
  </div>
</section>
<section class="inves position-relative inves-af" id="inves">
  <div class="position-relative z-in1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="title text-center position-relative tit-af">
            <div class="position-relative z-in1"> <span class="text-grad" style="display: none;">Plans</span><br>
              <h2 class="text-white pla fw-bold">Business plans</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="row pt-4">
        <div class="col-lg-12">

          <div class="row">
          <?php

  $packages = $this->common_model->GetResults("Status='1'","arm_package");

  $packages_tot = $this->db->query("SELECT * FROM arm_package where Status='1'")->num_rows();

if($packages_tot <= 1)
{
  $width = "100%";
}
else
{
   $width = "";
}

  $i=0;

  foreach($packages as $prows) { 
  $i++;
  ?>
          <div class="col-lg-4" style="margin-bottom: 10px;">
            <div class="res selection <?php echo $class; ?>">
              <input id="packageid<?php echo $i;?>"  name="packageid" type="radio" value="<?php echo $prows->PackageId;?>">
              <label for="packageid<?php echo $i;?>" style="width: <?php echo $width; ?>;" >
              <div class="investors-item" style="display: flex!important">
                <div class="level-grad-block grad-bg" style="background:<?php echo $clr; ?>;width: 227px;" >
                  <div class="percent" style="font-size: 22px;"> <?php echo number_format($prows->DirectCommission,2)." ".currency();?>
                    <sapn style="font-size: 14px; margin-right: 3px;margin-left: 3px;"> To </sapn>
                    <sapn style="font-size: 28px;"> &#8734; </sapn>
                  </div>
                  <div class="label">Profit</div>
                </div>
                <div class="investors-item--wraper" style="display: block;">
                  <div class="investors-item--data">
                    <div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-01.png" class="img-fluid"></div>
                    <div class="text-wrap">
                      <div>Plan Name</div>
                      <div class="colored-value"><?php echo ucfirst($prows->PackageName);?></div>
                    </div>
                  </div>
                  <div class="investors-item--data">
                    <div class="icon min"><img src="<?php echo base_url();?>assets/styl/images/invest-ico-02.png" class="img-fluid"></div>
                    <div class="text-wrap">
                      <div>Startup Cost</div>
                      <div class="colored-value"><?php echo $prows->PackageFee." ".currency();?></div>
                    </div>
                  </div>
                </div>
              </div>
              </label>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
      </div>
    </div>
  </div>
</section>
<section class="ref-bg bord-grad">
  <div class="container">
    <?php 
  print_r($indexReferal_content);
    ?>
  </div>
</section>
<section class="img-bg1">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="position-relative ab-af">
          <div class="about box position-relative z-in1">
            <?php
    print($userAboutus);
    ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row pt-5">
      <div class="col-lg-12">
       
          <div class="title text-center position-relative tit-af">
            <div class="position-relative z-in1"> <span class="text-grad" style="display: none;">Plans</span><br>
              <h2 class="text-white pla fw-bold" style="font-size: 41px;">frequently asked questions</h2>
            </div>
          </div>
           </div> </div>
         
        <!--  <div class="title position-relative mt-sm-2 mt-5">
    <div class="position-relative z-in1">
    <span class="text-grad" style="display: none;">Faq</span><br>
    </div>
    
    
    </div> -->
    
    
     <div class="row pt-5">
      <div class="col-lg-12">
      
        <div class="faq-left text-center">
          <!--   <img src="<?php echo base_url()?>assets/styl/images/banner-cooler.png" class="image-fluid"/> -->
          <div class="position-relative faq-af">
            <ul class="list-unstyled bg-primary text-center box position-relative z-in1">
              <?php
  print($faq_content);
  ?>
              <!-- <div class="col-lg-12">

<div class="row">

<div class="col-lg-6">
<li class="bord-grad"><img class="image-fluid" src="http://demo.myslworld.com/mlmscript/assets/styl/images/fea1.png" />
<h3 class="text-white pla fw-bold">Establish Goals</h3>

<p>Consectetur adipiscing elit. Mauris faucibus, nisi non pellentesque iaculis, mi augue feugiat ipsum.</p>
</li>
</div>

<div class="col-lg-6">

<li class="bord-grad"><img class="image-fluid" src="http://demo.myslworld.com/mlmscript/assets/styl/images/fea2.png" />
<h3 class="text-white pla fw-bold">Conversion Rate</h3>

<p>Consectetur adipiscing elit. Mauris faucibus, nisi non pellentesque iaculis, mi augue feugiat ipsum.</p>
</li>

</div>

</div>
</div> -->
            </ul>
          </div>
        </div>
        <div class="accordion" id="accordionPanelsStayOpenExample">
          <?php
  if($faq) { 
  $i = 0;
  foreach ($faq as $row) {
  ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
              <button class="pla accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $i;?>" aria-expanded="true" aria-controls="panelsStayOpen-collapse<?php echo $i;?>"> <?php echo  urldecode($row->FaqQuestion);?> </button>
            </h2>
            <div id="panelsStayOpen-collapse<?php echo $i;?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
              <div class="accordion-body text-white">
                <p><?php echo urldecode($row->FaqAnswer);?></p>
              </div>
            </div>
          </div>
          <?php 
  $i++;
  } }?>
        </div>
      </div>
    </div>
    <div class="row pt-sm-5 pt-3">
      <div class="col-sm-12">
        <div class="title text-center position-relative">
          <div class="position-relative z-in1"> <span class="text-grad" style="display: none;">History</span><br>
            <h2 class="text-white pla fw-bold">Transactions</h2>
          </div>
        </div>
      </div>
      <div class="col-lg-10 offset-lg-1">
        <div class="transactio-af position-relative">
          <div class="position-relative z-in1">
            <div class="row">
              <div class="col-lg-6">
                <div class="transac-title position-relative tran-af1">
                  <h2 class="text-white pla position-relative z-in1">Last <br>
                    Deposit</h2>
                </div>
                <ul class="transaction list-unstyled tras1 owl-carousel">
                  <?php

if($last_deposit)
{
    foreach ($last_deposit as $key) {
    $memdetail = $this->common_model->GetRow("MemberId='".$key->MemberId."'","arm_members");
?>
                  <li>
                    <div class="transac-block grad-bg position-relative">
                    <ul class="list-unstyled">
                      <li>
                        <h3 class="fw-bold pla text-white"><?php echo $memdetail->UserName;?></h3>
                      </li>
                      <li>
                        <div class="d-flex justify-content-between align-items-center money"> <img src="<?php echo base_url()?>assets/styl/images/tra1.png" class="image-fluid"/> <span class="text-white"><?php echo number_format($key->Credit,2);?> <?php echo currency(); ?></span> <img src="<?php echo base_url()?>assets/styl/images/tra4.png" class="image-fluid"/> </div>
                      </li>
                    </ul>
                    <?
}
}
else
{
?>
                  <li>
                    <div class="transac-block grad-bg position-relative">
                      <ul class="list-unstyled">
                        <li>
                          <h3 class="fw-bold pla text-white">Alex1236</h3>
                        </li>
                        <li>
                          <div class="d-flex justify-content-between align-items-center money"> <img src="<?php echo base_url()?>assets/styl/images/tra1.png" class="image-fluid"/> <span class="text-white">50.00 <?php echo currency(); ?></span> <img src="<?php echo base_url()?>assets/styl/images/tra4.png" class="image-fluid"/> </div>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <?
}
?>
                </ul>
              </div>
              <div class="col-lg-6">
                <div class="transac-title position-relative tran-af2">
                  <h2 class="text-white pla position-relative z-in1">Last <br>
                    Withdrawal</h2>
                </div>
                <ul class="transaction list-unstyled tras1 owl-carousel">
                  <?php

if($last_withdraw)
{
    foreach ($last_withdraw as $key) {
    $memdetail = $this->common_model->GetRow("MemberId='".$key->MemberId."'","arm_members");
?>
                  <li>
                    <div class="transac-block grad-bg position-relative">
                    <ul class="list-unstyled">
                      <li>
                        <h3 class="fw-bold pla text-white"><?php echo $memdetail->UserName;?></h3>
                      </li>
                      <li>
                        <div class="d-flex justify-content-between align-items-center money"> <img src="<?php echo base_url()?>assets/styl/images/tra1.png" class="image-fluid"/> <span class="text-white"><?php echo number_format($key->Debit,2);?> <?php echo currency(); ?></span> <img src="<?php echo base_url()?>assets/styl/images/tra4.png" class="image-fluid"/> </div>
                      </li>
                    </ul>
                    <?
}
}
else
{
?>
                  <li>
                    <div class="transac-block grad-bg position-relative">
                      <ul class="list-unstyled">
                        <li>
                          <h3 class="fw-bold pla text-white">Alex1236</h3>
                        </li>
                        <li>
                          <div class="d-flex justify-content-between align-items-center money"> <img src="<?php echo base_url()?>assets/styl/images/tra1.png" class="image-fluid"/> <span class="text-white">11.00 <?php echo currency(); ?></span> <img src="<?php echo base_url()?>assets/styl/images/tra4.png" class="image-fluid"/> </div>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <?
}
?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-10 offset-lg-1">
        <div class="transactio-af position-relative">
          <div class="position-relative z-in1">
            <div class="row">
              <div class="col-sm-6">
                <div class="transac-title position-relative tran-af1">
                  <h2 class="text-white pla position-relative z-in1">Level <br>
                    Completers</h2>
                </div>
                <ul class="transaction list-unstyled tras1 owl-carousel">
                  <?php

if($purchased)
{
    foreach ($purchased as $key) {
    $memdetail = $this->common_model->GetRow("MemberId='".$key->MemberId."'","arm_members");
    $rank = $this->db->query("SELECT * FROM  arm_ranksetting where rank_id='".$memdetail->rank."'")->row();
?>
                  <li>
                    <div class="transac-block grad-bg position-relative">
                    <ul class="list-unstyled">
                      <li>
                        <h3 class="fw-bold pla text-white"><?php echo $memdetail->UserName;?></h3>
                      </li>
                      <li>
                        <div class="d-flex justify-content-between align-items-center money"> <img src="<?php echo base_url()?>assets/styl/images/tra1.png" class="image-fluid"/> <span class="text-white"><?php echo $rank->Rank;?> </span> <img src="<?php echo base_url()?>assets/styl/images/tra4.png" class="image-fluid"/> </div>
                      </li>
                    </ul>
                    <?
}
}
else
{
?>
                  <li>
                    <div class="transac-block grad-bg position-relative">
                      <ul class="list-unstyled">
                        <li>
                          <h3 class="fw-bold pla text-white">Alex</h3>
                        </li>
                        <li>
                          <div class="d-flex justify-content-between align-items-center money"> <img src="<?php echo base_url()?>assets/styl/images/tra1.png" class="image-fluid"/> <span class="text-white">Level 1</span> <img src="<?php echo base_url()?>assets/styl/images/tra4.png" class="image-fluid"/> </div>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <?
}
?>
                </ul>
              </div>
              <div class="col-lg-6">
                <div class="transac-title position-relative tran-af2">
                  <h2 class="text-white pla position-relative z-in1">Highest <br>
                    Earners</h2>
                </div>
                <ul class="transaction list-unstyled tras1 owl-carousel">
                  <?php

if($earners)
{
    foreach ($earners as $key) {
    $memdetail = $this->common_model->GetRow("MemberId='".$key->MemberId."'","arm_members");
?>
                  <li>
                    <div class="transac-block grad-bg position-relative">
                    <ul class="list-unstyled">
                      <li>
                        <h3 class="fw-bold pla text-white"><?php echo $memdetail->UserName;?></h3>
                      </li>
                      <li>
                        <div class="d-flex justify-content-between align-items-center money"> <img src="<?php echo base_url()?>assets/styl/images/tra1.png" class="image-fluid"/> <span class="text-white"><?php echo number_format($key->earns,2);?> <?php echo currency(); ?></span> <img src="<?php echo base_url()?>assets/styl/images/tra4.png" class="image-fluid"/> </div>
                      </li>
                    </ul>
                    <?
}
}
else
{
?>
                  <li>
                    <div class="transac-block grad-bg position-relative">
                      <ul class="list-unstyled">
                        <li>
                          <h3 class="fw-bold pla text-white">Alex1236</h3>
                        </li>
                        <li>
                          <div class="d-flex justify-content-between align-items-center money"> <img src="<?php echo base_url()?>assets/styl/images/tra1.png" class="image-fluid"/> <span class="text-white">10.00 <?php echo currency(); ?></span> <img src="<?php echo base_url()?>assets/styl/images/tra4.png" class="image-fluid"/> </div>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <?
}
?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $this->load->view('user/index_footer');?>
<!-- Modal -->
<div class="modal fade  modal-fullscreen" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button"    class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="float: right;"></button>
        <div class="embed-responsive embed-responsive-16by9">
          <iframe  class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade  modal-fullscreen" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-center">
        <button type="button"    class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="float: right;"></button>
        <div class="embed-responsive embed-responsive-16by9"> <img src="<?php echo base_url()?>assets/styl/images/cetificate.jpg" class="image-fluid"> </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url()?>assets/styl/js/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/styl/js/bootstrap.bundle.js"></script>
<script src="<?php echo base_url()?>assets/styl/js/script.js"></script>
<script src="<?php echo base_url()?>assets/styl/js/owl.carousel.min.js"></script>
</body>
</html>
<script src="<?php echo base_url();?>assets/js/metamask_connect.js"></script>
<script src="https://github.com/WalletConnect/walletconnect-monorepo/releases/download/1.4.1/web3-provider.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js" integrity="sha256-nWBTbvxhJgjslRyuAKJHK+XcZPlCnmIAAMixz6EefVk=" crossorigin="anonymous"></script>
<script src="<?php echo base_url();?>/assets/js/web3.js"></script>
<script src="<?php echo base_url();?>assets/sytl/js/admin.js"></script>
