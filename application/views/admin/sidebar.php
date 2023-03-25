<!--  Sidebar   -->
<?php $mlsetting  = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting"); ?>

<?php 
if($mlsetting->Id=='2')
{
    $query = $this->db->query("update arm_backmenu_admin set mlm_status='1' where menu_id='76' ");
    $query = $this->db->query("update arm_backmenu_admin set mlm_status='2' where menu_id='74' ");
    $query = $this->db->query("update arm_backmenu_admin set mlm_status='2' where menu_id='75' ");
}
?>


<aside id="sidebar_left" class="nano nano-light affix">

    <!--  Sidebar Left Wrapper   -->
    <div class="sidebar-left-content nano-content">

        <!--  Sidebar Header  -->
        <header class="sidebar-header">

            <!--  Sidebar - Author  -->
    <div class="sidebar-widget author-widget">
    <div class="media">
    <a class="media-left" href="#">
    <?php $path= $this->common_model->GetCustomer($this->session->userdata('MemberID')); ?>

    <img alt="Image" src="<?php echo base_url().$path->ProfileImage;?>" class="img-responsive">
    </a>

    <div class="media-body">
    <div class="media-links">
   <a href="<?php echo base_url();?>admin/logout"> <span class="fa fa-power-off pr5"></span> Logout</a>
    </div>
     <!-- <a href="#" class="sidebar-menu-toggle">User Menu -</a>  -->
    <div class="media-author"><?php echo $this->session->userdata('full_name');?></div>
    </div>
    </div>
    </div>

        <!--  Sidebar - Author Menu   -->
    <div class="sidebar-widget menu-widget">
    <div class="row text-center mbn">
    <div class="col-xs-2 pln prn">
    <a href="<?php echo base_url();?>admin" class="text-primary" data-toggle="tooltip" data-placement="top"
    title="Dashboard">
    <span class="fa fa-dashboard"></span>
    </a>
    </div>
    <div class="col-xs-4 col-sm-2 pln prn">
    <a href="<?php echo base_url();?>admin/orders" class="text-system" data-toggle="tooltip"
    data-placement="top" title="Orders">
    <span class="fa fa-info-circle"></span>
    </a>
    </div>
    <div class="col-xs-4 col-sm-2 pln prn">
    <a href="<?php echo base_url();?>admin/income" class="text-warning" data-toggle="tooltip"
    data-placement="top" title="Invoices">
    <span class="fa fa-file"></span>
    </a>
    </div>
    <div class="col-xs-4 col-sm-2 pln prn">
    <a href="<?php echo base_url();?>admin/customers" class="text-alert" data-toggle="tooltip" data-placement="top"
    title="Users">
    <span class="fa fa-users"></span>
    </a>
    </div>
    <div class="col-xs-4 col-sm-2 pln prn">
    <a href="<?php echo base_url();?>admin/generalsetting" class="text-danger" data-toggle="tooltip"
    data-placement="top" title="Settings">
    <span class="fa fa-cogs"></span>
    </a>
    </div>
    </div>
    </div>

</header>
<!--  /Sidebar Header  -->


<ul class="nav sidebar-menu">
    <li class="sidebar-label pt30">Menu</li>

    <?php 

    $userid = $this->session->userdata('MemberID');
    $userlevel = $this->session->userdata('UserLevel');

    $access_list_data = $this->common_model->Subadminaccess($userid,$userlevel);

    $pages = json_decode($access_list_data->access_list);

    $menus=implode("','", (array)$pages);  

    $back_menus=$this->db->query("select * from arm_backmenu_admin where menu_id IN ('".$menus."') and status='on' order by sort_id asc")->result();
    // echo $this->db->last_query();

    foreach ($back_menus as $back_menus) 
    {
        if($back_menus->sub_id==0)
        {
            $mainmenus_ids.=$back_menus->menu_id.','; 
        }
        else
        {
            $mainmenus_ids.=$back_menus->sub_id.','; 
        }
        $submenus_ids.= $back_menus->menu_id.',';

    }
    $mainmenusids=rtrim($mainmenus_ids,',');
    $submenusids=rtrim($submenus_ids,',');

    if($access_list_data!='')
    {
        $check_admin_backmenu = $this->db->query("select * from arm_backmenu_admin where menu_type='main' and menu_id IN (".$mainmenusids.") and status='on' order by sort_id asc")->result();
    }
    else
    {
        $check_admin_backmenu = $this->db->query("select * from arm_backmenu_admin where menu_type='main' and status='on' order by sort_id asc")->result();
    }

                // echo $this->db->last_query();
    foreach($check_admin_backmenu as $row)
    { 

        if($access_list_data!='')
        {
            $sub_row_check = $this->db->query("select * from arm_backmenu_admin where menu_type='sub' and sub_id='".$row->menu_id."' and menu_id IN (".$submenusids.") ");
            $row_check = $sub_row_check->num_rows();
            $sub_row_check1 = $this->db->query("select * from arm_backmenu_admin where menu_type='sub' and sub_id='".$row->menu_id."' and status='on' and menu_id IN (".$submenusids.") and mlm_status!='2' order by sub_sort_id asc ")->result();    
        }
        else
        {
            $sub_row_check = $this->db->query("select * from arm_backmenu_admin where menu_type='sub' and sub_id='".$row->menu_id."' ");
            $row_check = $sub_row_check->num_rows();
            $sub_row_check1 = $this->db->query("select * from arm_backmenu_admin where menu_type='sub' and sub_id='".$row->menu_id."' and status='on' and mlm_status!='2' order by sub_sort_id asc ")->result();
        }


        if($row->menu_id=='1')
        {
            $class1 = 'fa fa-dashboard';
        }
        elseif($row->menu_id=='2')
        {
            $class1 = 'glyphicon glyphicon-user';
        }
        elseif($row->menu_id=='3')
        {
            $class1 = 'glyphicon glyphicon-star-empty';
        }
        elseif($row->menu_id=='4')
        {
            $class1 = 'glyphicon glyphicon-euro';
        }
        elseif($row->menu_id=='5')
        {
            $class1 = 'glyphicon glyphicon-euro';
        }
        elseif($row->menu_id=='6')
        {
            $class1 = 'glyphicon glyphicon-random';
        }
        elseif($row->menu_id=='7')
        {
            $class1 = 'glyphicon glyphicon-level-up';
        }
        elseif($row->menu_id=='8')
        {
            $class1 = 'glyphicon glyphicon-education';
        }
        elseif($row->menu_id=='9')
        {
            $class1 = 'glyphicon glyphicon-bookmark';
        }
        elseif($row->menu_id=='10')
        {
            $class1 = 'glyphicon glyphicon-bookmark';
        }
        elseif($row->menu_id=='11')
        {
            $class1 = 'glyphicon glyphicon-lock';
        }
        elseif($row->menu_id=='12')
        {
            $class1 = 'glyphicon glyphicon-indent-right';
        }
        elseif($row->menu_id=='13')
        {
            $class1 = 'glyphicon glyphicon-cog';
        }
        elseif($row->menu_id=='14')
        {
            $class1 = 'glyphicon glyphicon-th';
        }
        elseif($row->menu_id=='15')
        {
            $class1 = 'glyphicon glyphicon-list-alt';
        }
        elseif($row->menu_id=='16')
        {
            $class1 = 'glyphicon glyphicon-tags';
        } 
        elseif($row->menu_id=='106'){
            $class1='   glyphicon glyphicon-briefcase';
        }
        elseif($row->menu_id=='17')
        {
            $class1 = 'glyphicon glyphicon-tags';
        }
        elseif($row->menu_id=='18')
        {
            $class1 = 'glyphicon glyphicon-scissors';
        }
        if($row_check == 0)
        {
                        //$href = "$row->path ";
            $href = base_url()."$row->path ";
        }
        else
        {
            $href = "#";
            $class = "accordion-toggle";
        }
        ?>

            <li>
            <a class="<?php echo $class; ?>" href="<?php echo $href ?>" >
            <span class="<?php echo $class1; ?>"></span>
            <span class="sidebar-title"><?php echo ucwords($row->menu_name); ?></span>
            <?php 
            if($row_check == 0)
            {?>
            </a>
            <?}
            ?>

            <?php
            if($row_check !=0 )
            {?>
            <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
            <?php 
            foreach($sub_row_check1 as $row1)
            {
            ?>
            <li><a href="<?php echo base_url();?><?php echo $row1->path ?>"> 
            <span class="fa fa-file-text-o"></span> <?php echo ucwords($row1->menu_name); ?> </a>
            </li>
            <?}
            ?>
            </ul>           

            <?}?> 
            </li> 

                    <?}?>
                </ul>
                <?php  ?>
                <!--  /Sidebar Menu   -->

                <!--  Sidebar Hide Button  -->
                <div class="sidebar-toggler">
                    <a href="#">
                        <span class="fa fa-arrow-circle-o-left"></span>
                    </a>
                </div>
                <!--  /Sidebar Hide Button  -->

            </div>
            <!--  /Sidebar Left Wrapper   -->

        </aside>