<?php //print_r($projects);die; ?>
            <!-- BEGIN HEADER -->
            <?php include 'inc/header.php'; ?>
<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>

            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <?php include 'inc/sidebar.php'; ?>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->
                        <div class="theme-panel hidden-xs hidden-sm">
                        </div>
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo base_url()?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <a href="#">Projects</a>
                                </li>
                               
                            </ul>
                            <div class="page-toolbar">
                               
                            </div>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2))); ?>
                            <small>managed datatable samples</small>
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase"> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2))); ?> Table</span>
                                        </div>
                                       <!--  <div class="actions">
                                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                    <input type="radio" name="options" class="toggle" id="option1">My Clients</label>
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm  active">
                                                    <input type="radio" name="options" class="toggle" id="option2">All</label>
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                    <input type="radio" name="options" class="toggle" id="option2">My Jobs</label>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-toolbar">
                                            <?php if(!in_array($designation_id, [9])): ?>
                                            <div class="row">
                                                <?php if($this->uri->segment(2) != 'cancel_projects'): ?>
                                                <div class="col-md-6">
                                                    <div class="btn-group">
                                                        <a href="<?= site_url('projects/add_project') ?>" id="sample_editable_1_new" class="btn btn-circle sbold green"> Add Job
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <table class="table table-condensed table-bordered table-hover table-checkable order-column" id="example">
                                            <thead>
                                                <tr>
                                                   <!--  <th>
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                            <span></span>
                                                        </label>
                                                    </th> -->
                                                    <th>#</th>
                                                    <th> Job </th>
                                                    <th> Po </th>
                                                    <?php if(!in_array($designation_id, [9])): ?>
                                                    <th> Client </th>
                                                    <th> Added By </th>
                                                    <?php endif; ?>
                                                    <th> Assignee </th>
                                                    <?php if(in_array($designation_id, [1,6,8,9])): ?>
                                                    <th style="text-align: center;"> Cad Status </th>
                                                    <?php endif; ?>
                                                    <th> Disposition </th>
                                                    <th> ETA </th>
                                                    <th> Deadline </th>
                                                    <!-- <th> Created at </th> -->
                                                    <th style="text-align: center;"> Type </th>
                                                    <th> Queue </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $odd = 'odd';
                                                $cnt = 1;
                                                $total_rows = count($projects);
                                                $num_of_digit = (int) strlen((string)$total_rows);
                                                foreach ($projects as $key) :
                                                    $odd = $odd == 'odd' ? 'even' : 'odd';
                                                 ?>
                                                 <?php 
                                                switch ($key->cad_progress) {
                                                    case 'On Hold':
                                                        $cad_progress_color = '';
                                                        # code...
                                                        break;
                                                    case 'Ready':
                                                        $cad_progress_color = 'badge-success';
                                                        break;
                                                    case 'In Progress':
                                                        $cad_progress_color = 'badge-primary';
                                                        break;
                                                    case '3D Printing Only':
                                                        $cad_progress_color = 'badge-primary';
                                                        break;
                                                    
                                                }
                                                ?>
                                                <tr class="<?= $odd ?> gradeX" onclick="window.location='<?= site_url('projects/project_details/'.$key->project_id)?>';" style='cursor:pointer'>
                                                   <!--  <td>
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="checkboxes" value="1" />
                                                            <span></span>
                                                        </label>
                                                    </td> -->
                                                    <td>
                                                        <?php 
                                                        // $num_of_digit_cnt = (int) strlen((string)$cnt);
                                                        if($num_of_digit > (int) strlen((string)$cnt))
                                                            echo str_repeat("0", $num_of_digit - (int) strlen((string)$cnt)).$cnt;
                                                        else
                                                            echo $cnt
                                                         ?>
                                                    </td>
                                                    <td>
                                                        <?= $key->title ?>
                                                        <?php if($key->is_api_injected == 1): ?>
                                                        <i style="color: #1BBC9B;font-weight: bold; margin-left: 5px;" class="fas fa-cogs"></i>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $key->po ?></td>
                                                    <?php if(!in_array($designation_id, [9])): ?>
                                                    <td>
                                                        <?php
                                                        if($key->asign_user == 0) 
                                                            echo '';
                                                        else{
                                                             $client = $this->db->get_where('user',['id' => $key->asign_user])->row();  
                                                             if($client->designation_id == 7)
                                                                 echo $client->company_name.' ('.$client->name.')';
                                                             else
                                                                 echo $client->name;
                                                             // if($client->designation_id == 7)
                                                             //    echo ' - '.$client->company_name;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?= $key->assign_by == 0 ? '' : $this->db->get_where('user',['id' => $key->assign_by])->row()->name  ?>
                                                    </td>
                                                    <?php endif; ?>

                                                    <?php if($key->assignee == ''): ?>
                                                    <td></td>
                                                    <?php else: ?>
                                                    <td><?php 
                                                    $assignees = explode(',', $key->assignee);
                                                    $i = 1;
                                                    foreach ($assignees as $key_one => $value) {
                                                        // echo $value;
                                                        $assignees[$key_one] = $this->db->get_where('user',['id' => $value])->row()->name;
                                                        if(in_array($designation_id, [5,7])){
                                                            $assignee_des = $this->db->get_where('user',['id' => $value])->row()->designation_id;
                                                            if($assignee_des == 9){
                                                                $assignees[$key_one] = 'Cad Team '.$i;
                                                                $i++;
                                                            }
                                                        }
                                                    }
                                                    // print_r($assignees);
                                                    echo implode(', ', $assignees);
                                                     ?></td>
                                                    <?php endif; ?>

                                                    <?php if(in_array($designation_id, [1,6,8,9])): ?>
                                                    <td style="text-align: center"><span class="badge <?php echo $cad_progress_color ?>"><?php echo $key->cad_progress ?></span></td>
                                                    <?php endif; ?>


                                                    <td>
                                                        <?php $disposition = $this->db->query("SELECT * FROM `project_disposition` WHERE project_id = $key->project_id AND flag = 1 ORDER by project_disposition_id DESC")->row();  ?>
                                                        <?php 
                                                        if(count($disposition) == 0){
                                                            $disposition = $this->db->query("SELECT * FROM `project_disposition` WHERE project_id = $key->project_id ORDER by project_disposition_id ASC")->row();
                                                        }

                                                         ?>
                                                        <?php $disposition_id = count($disposition) == 0 ? '' : $disposition->disposition_id ?>
                                                        <?php echo $disposition_id == '' ? '' : $this->db->get_where('disposition',['disposition_id' => $disposition_id])->row()->name ?>
                                                    </td>

                                                    <!-- <td><?= ($key->deadline == '0000-00-00' || $key->deadline > date('Y-m-d')) ? 'NA' : time_elapsed_string($key->deadline) ?></td> -->
                                                    <td><?php
                                                     if($key->deadline != '0000-00-00'){
                                                        if($key->deadline > date('Y-m-d'))
                                                            echo '+ '.timespan(time(),strtotime($key->deadline), 1);
                                                        else
                                                            echo '- '.timespan(strtotime($key->deadline), time(), 1);
                                                     }
                                                     ?></td>

                                                    <td><?= $key->deadline == '0000-00-00' ? 'No deadline' : $key->deadline  ?></td>
                                                    

                                                    <!-- <td><?php echo date('m-d-Y H:i:s',strtotime($key->created_at)) ?></td> -->
                                                    <?php 
                                                    switch ($key->type) {
                                                        case 'live':
                                                            $state = 'info';
                                                            break;
                                                        case 'cancelled':
                                                            $state = 'danger';
                                                            break;
                                                        case 'proposal':
                                                            $state = 'secondary';
                                                            break;
                                                        case 'completed':
                                                            $state = 'success';
                                                            break;
                                                    }
                                                     ?>
                                                    <td style="text-align: center;"><span class="badge badge-<?php echo $state ?>"><?= ucwords($key->type) ?></span></td>

                                                    <td class="text-center"><a class="badge badge-success" href="<?= site_url('projects/project_details/'.$key->project_id)?>">J<?= $key->project_id?></a> </td>
                                                </tr>
                                                <?php $cnt++; endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                       

                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
          
            <!-- END FOOTER -->
        </div>
            </div>
        </div>
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>/assets/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>/assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url();?>/assets/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>/assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });

                $(document).ready(function() {
                    $('#example').DataTable();
                } );
            })
        </script>
    </body>

</html>