<?php //$starttime = microtime(true); ?>
<!-- BEGIN HEADER -->
<?php include 'inc/header.php'; ?>
<?php date_default_timezone_set('America/Chicago'); ?>

<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>

<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css">




<!-- styles -->
    <style>
        .explorer-frame .file-preview-html {
            display: flex;
            border: 1px solid #ddd;
            padding: 8px;
            overflow: none!important; 
        }
        .proj_img_chk{
            margin: 15px 5px 0 0!important;
            line-height: normal!important;
        }
        #kvFileinputModal img{
            width: 100%!important;
        }
        .theme-explorer-fas .file-actions-cell{
            width: 140px!important;
        }
        label{
            font-weight: bold;
        }
        .criticalDates a{
            background-color: #E26A6A !important;
        }
        .rushDates a{
            background-color: #ffd325!important;
        }
        .standardDates a{
            background-color: #36D7B7 !important;
        }
        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
            border: 1px solid #003eff!important;
            background: #007fff!important;
            font-weight: normal!important;
            color: #ffffff!important;
        }
        
    </style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container" id="project_details_container">
            <!-- BEGIN SIDEBAR -->
            <?php include 'inc/sidebar.php'; ?>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li> <a href="<?php echo base_url()?>">Home</a> <i class="fa fa-circle"></i> </li>
                            <li> <a href="<?php echo base_url('projects/all_projects')?>">Projects</a> <i class="fa fa-circle"></i> </li>
                            <li> <span>Projects Details</span> </li>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h1 class="page-title">
                        Project Details - J<?php echo $project->project_id ?> 
                        <?php if($project_details->is_api_injected == 1): ?>
                        <small  style="color: #1BBC9B; margin-left: 5px;">Api injected <i class="fas fa-cogs"></i></small>
                        <?php endif; ?>
                        <span class="font-green-meadow"><b><?php echo $project_details->estimated_approve == 1 ? 'Approved' : ''; ?></b></span>
                    </h1>
                    <!-- End PAGE TITLE-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">

                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold uppercase"><i class="icon-briefcase font-dark"></i> PO - <?= $project_details->po ?></span>
                                        <?php if(!in_array($designation_id, [9])): ?>
                                        <span class="caption-subject bold uppercase">
                                            Client - <?php 
                                                        if($project->asign_user != 0) {
                                                            $user = $this->db->get_where('user',['id' => $project->asign_user])->row();
                                                            if($user->designation_id != 7)
                                                                echo $user->name;
                                                            else
                                                                echo $user->company_name.' ('.$user->name.')';
                                                        }
                                                        ?>
                                                
                                        </span>
                                        <span class="caption-subject bold uppercase text-center">Added By - <?php echo $project->assign_by == 0 ? '' : $this->db->get_where('user', ['id' => $project->assign_by])->row()->name  ?></span>
                                        <?php if($project->asign_user != 0): ?>
                                        <?php $representative = $this->db->get_where('user', ['id' => $project->asign_user])->row()->representative; ?>
                                        <span class="caption-subject bold uppercase text-center">Sales Rep - <?php echo is_null($representative) ? '' : $this->db->get_where('user', ['id' => $representative])->row()->name  ?></span>
                                        <?php endif; ?>

                                        <?php endif; ?>
                                        <span class="caption-subject bold uppercase text-right">Status - <span  class="badge badge-secondary"><?php echo $project_details->type ?></span></span>
                                    </div>
                                    <div class="caption font-dark">
                                        
                                    </div>
                                </div>
                                        
                                
                                        
                                <div class="portlet-body">
                                   
                                    <div class="btn-toolbar margin-bottom-10">

                                        <div class="btn-group pull-right btn-group-devided">

                                            <?php 
                                            switch ($project_details->cad_progress) {
                                                case 'On Hold':
                                                    $cad_progress_color = 'red-sunglo';
                                                    # code...
                                                    break;
                                                case 'Ready':
                                                    $cad_progress_color = 'green-meadow';
                                                    break;
                                                case 'In Progress':
                                                    $cad_progress_color = 'blue-madison';
                                                    break;
                                                case '3D Printing Only':
                                                    $cad_progress_color = 'blue-madison';
                                                    break;
                                                case 'Waiting For Approval':
                                                    $cad_progress_color = 'yellow-crusta';
                                                    break;
                                                
                                            }
                                             ?>
                                            <!-- <?php if($client_approval): ?>
                                            <span class="btn btn-sm btn-circle <?php echo $cad_progress_color ?>">Cad Progression - <?php echo $project_details->cad_progress ?></span>
                                            <?php endif; ?> -->



                                            
                                            <?php if(in_array($designation_id, [1,6,9])): ?>
                                            <?php if(!$completed): ?>
                                            <div class="btn-group btn-group-devided">
                                                <button type="button" class="btn btn-circle  <?php echo $project_details->alert == 0 ? 'red-sunglo' : 'green-meadow' ?> btn-sm dropdown-toggle" data-close-others="true" data-toggle="dropdown">
                                                Customer alert <?php echo $project_details->alert == 0 ? 'off' : 'on' ?> <span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="<?php echo base_url('Project_controller/set_alert/'.$project->project_id.'/1')?>">Set for alert  <?php if($project_details->alert == 1):?><i class="fas fa-check pull-right"></i><?php endif; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url('Project_controller/set_alert/'.$project->project_id.'/0')?>">Clear alert <?php if($project_details->alert == 0):?><i class="fas fa-check pull-right"></i><?php endif; ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php endif; ?>
                                            <?php endif; ?>




                                            <?php if(in_array($designation_id, [1,6,9])): ?>
                                            <div class="btn-group btn-group-devided">

                                                <?php if(isset($cad_check)): ?>
                                                <button type="button" class="btn btn-circle <?php echo $cad_progress_color ?> btn-sm dropdown-toggle" data-close-others="true" data-toggle="dropdown" <?php echo $cad_check ? '' : 'disabled' ?> <?= $completed ? 'disabled' : '' ?>>
                                                Cad Progress <?php echo $project_details->cad_progress ?> <span class="caret"></span></button>
                                                <?php else: ?>
                                                <button type="button" class="btn btn-circle <?php echo $cad_progress_color ?> btn-sm dropdown-toggle" data-close-others="true" data-toggle="dropdown" <?= $completed ? 'disabled' : '' ?>>
                                                Cad Progress <?php echo $project_details->cad_progress ?> <span class="caret"></span></button>
                                                <?php endif; ?>

                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="<?php echo base_url('Project_controller/change_cad_progress/'.$project->project_id.'/hold')?>">On Hold</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url('Project_controller/change_cad_progress/'.$project->project_id.'/in_progress')?>">In Progress</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url('Project_controller/change_cad_progress/'.$project->project_id.'/3d_printing')?>">3D Printing Only</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url('Project_controller/change_cad_progress/'.$project->project_id.'/ready')?>">Ready</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url('Project_controller/change_cad_progress/'.$project->project_id.'/waiting_for_approval')?>">Waiting For Approval</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php endif; ?>




                                            <?php if(!in_array($designation_id, [5,7,9])): ?>
                                            <div class="btn-group btn-group-devided">
                                                <button type="button" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-close-others="true" data-toggle="dropdown">
                                                Options <span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a target="_blank" href="<?php echo base_url('Project_controller/print_job_label/'.$this->uri->segment(3))?>">Print Job Label</a>
                                                    </li>
                                                    <li>
                                                        <a href="#project_print" id="print_job_sheet">Print Job Sheet</a>
                                                    </li>
                                                    <li>
                                                        <a href="#project_vendor_envelope" id="pro_vndr_envlp_lnk">Vendor envelope</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php endif; ?>


                                            
                                            <?php if($client_approval): ?>
                                            <button type="button" class="btn  btn-circle grey-salsa btn-sm" data-toggle="modal" data-target="#myModal">Gallery</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- disposition -->
                                    <?php if(!in_array($designation_id, [9])): ?> <!-- cad team cannot see -->
                                    <div class="row step-line" id="project_disposition_steps">
                                        <div class="col-md-2">
                                            <span class="caption-subject bold font-dark">8 Steps Disposition</span>
                                            <!-- <div class="font-dark bold uppercase" style="display: inline;"></div>  -->
                                           <!--  <?php if($client_approval): ?>
                                            <button id="reset_all_disposition" value="<?php //echo $project->project_id ?>" class="btn btn-default" style="margin-left: 20px">Reset disposition</button>

                                            <?php endif; ?> -->
                                        </div>
                                        <?php if($client_approval): ?>
                                        <div class="col-md-4">
                                            <div class="btn-group btn-group-devided">
                                                <button id="reset_all_disposition" value="<?php echo $project->project_id ?>" class="btn btn-circle red-sunglo btn-sm" style="margin-left: 20px" <?= $completed ? 'disabled' : '' ?>>Reset disposition</button>


                                                <!-- 
                                                <?php if(in_array($designation_id, [1,6])): ?>
                                                <button class="btn btn-circle green-meadow btn-sm ready_to_ship_btn" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : '' ?>><?php echo $project_ship->is_shipped == 1 ? 'Shipped' : 'Ready to ship' ?></button>
                                                <?php endif; ?> -->


                                                <button class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" href="javascript:;" aria-expanded="true" <?= $completed ? 'disabled' : '' ?>> More
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="disposition_more" data-value='wax' href="javascript:;"> Wax Only </a>
                                                    </li>
                                                    <li>
                                                        <a class="disposition_more" data-value='casting' href="javascript:;"> Casting Only </a>
                                                    </li>
                                                    <li>
                                                        <a class="disposition_more" data-value='repairs' href="javascript:;"> Repairs </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-md-12">
                                            <div id="project_dispositions_main"><?php echo ($project_dispositions) ?></div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <!-- end disposition -->

                                    <!-- internal disposition -->
                                    <?php if ($client_approval) : ?>
                                    <?php if(!in_array($designation_id, [9])): ?> <!-- cad team cannot see -->
                                    <div class="row step-line">
                                        <div class="col-md-4">
                                            <span class="caption-subject bold font-dark">8 Steps Internal Disposition</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div  id="project_disposition_internal_steps"><?php echo $project_dispositions_internal ?></div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <!-- end internal disposition -->


                                    <form id="" class="form-horizontal" action="<?php echo base_url('Project_controller/update_project_action/'.$this->uri->segment(3))?>" method="POST" onkeydown="return event.key != 'Enter';">
                                        <!-- == -->
                                        <div class="form msg-frm">
                                            <!-- END TASK HEAD -->
                                            <!-- Created at -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Created At</label>
                                                    <input type="text" class="form-control todo-taskbody-tasktitle" value="<?= date_convert(date('d-m-Y H:i:s', strtotime($project_details->created_at)), 'd M, Y h:i A'); ?>" disabled>
                                                </div>
                                            </div>

                                            <!-- Type -->
                                            <?php if(!in_array($designation_id, [9])): ?>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Project Status</label>
                                                    <select name="project[type]" class="form-control" <?php echo !$client_approval ? 'disabled' : '' ?>>
                                                        <option value="proposal" <?= $project_details->type == 'proposal' ? 'selected' : '' ?>>Proposal</option>
                                                        <option value="live" <?= $project_details->type == 'live' ? 'selected' : '' ?>>Live</option>
                                                        <option value="completed" <?= $project_details->type == 'completed' ? 'selected' : '' ?>>Completed</option>
                                                        <option value="cancelled" <?= $project_details->type == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php endif; ?>


                                            <!-- Asignee -->
                                            <?php if($client_approval): ?>
                                            <?php if(!in_array($designation_id, [9])): ?>
                                            <?php $project_assignee = explode(',', $project_details->assignee); ?>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Project Assignee</label>
                                                    <select id="project_assignee" name="project[assignee][]" multiple="multiple" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                        <option value="">Set Assignee</option>
                                                        <?php foreach ($assignee as $key) : ?>
                                                        <option data-des="<?= $key->designation_id ?>" value="<?= $key->id ?>"
                                                            <?= in_array($key->id, $project_assignee) ? 'selected' : ''?>><?= $key->name.' - '. $this->db->get_where('designation', ['designation_id' => $key->designation_id])->row()->designation_name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="cad_slot_date_div">
                                                <?php if(!empty($project_cad_member)): ?>
                                                <?php foreach ($project_cad_member as $key): ?>
                                                <div class="form-group" id="cad_slot_date_single_div<?php echo $key ?>">

                                                    <!-- Cad slot -->
                                                    <?php $cad_date = $this->db->get_where('cad_slots', ['user_id' => $key, 'project_id' => $project->project_id])->row(); ?>
                                                    <div class="col-md-2"><span class="badge badge-primary"><?php echo $this->db->get_where('user', ['id' => $key])->row()->name ?></span></div>
                                                    <?php if(!empty($cad_date)): ?>
                                                    <div class="col-md-4">
                                                        <input type="text" value="<?php echo date('m/d/Y', strtotime($cad_date->date)) ?>" class="form-control slot-datepicker" data-user="<?php echo $key ?>" name="cad_slot_date[<?php echo $key ?>]" placeholder="Select cad date" autocomplete="off" <?= $completed ? 'disabled' : '' ?>>
                                                    </div>
                                                    <?php else: ?>
                                                    <div class="col-md-4">
                                                        <input type="text" value="" class="form-control slot-datepicker" data-user="<?php echo $key ?>" name="cad_slot_date[<?php echo $key ?>]" placeholder="Select cad date" autocomplete="off">
                                                    </div>
                                                    <?php endif; ?>
                                                    <div class="col-md-1">
                                                        <a class="btn btn-sm btn-circle btn-default cad_slots_modal_btn" target="_blank" href="<?php echo base_url('cad_slots/'.$key) ?>">Cad Slot</a>
                                                    </div> 



                                                    <!-- check that 3d print exist or not -->
                                                    <?php $cad_3d_print_date = $this->db->get_where('cad_3d_print_date', ['user_id' => $key, 'project_id' => $project->project_id])->row(); ?>
                                                    <?php if(!empty($cad_3d_print_date)): ?>
                                                    <div class="col-md-4">
                                                        <input type="text" value="<?php echo date('m/d/Y', strtotime($cad_3d_print_date->date)) ?>" class="form-control 3d-print-datepicker" data-user="<?php echo $key ?>" name="cad_3d_print_date[<?php echo $key ?>]" placeholder="Select 3d print date" autocomplete="off" <?= $completed ? 'disabled' : '' ?>>
                                                    </div>
                                                    <?php else: ?>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control 3d-print-datepicker" data-user="<?php echo $key ?>" name="cad_3d_print_date[<?php echo $key ?>]" placeholder="Select 3d print date" autocomplete="off" <?= $completed ? 'disabled' : '' ?>>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php endforeach;?>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                            <?php endif; ?>


                                            <?php if(!in_array($designation_id, [9])): ?>
                                            <?php if ($client_approval) : ?>
                                            <!-- disposition -->
                                            <hr style="border-top: 1px solid #bdbdbd;">
                                            <div class="form-group">
                                                <label class="col-md-12" for="disposition">Disposition</label><br>
                                                <div class="col-md-10">
                                                    <select name="project[disposition]" id="disposition" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                        <option value="0">No Disposition Assigned</option>
                                                        <?php foreach ($disposition as $key) : ?>
                                                        <option value="<?= $key->disposition_id ?>" <?= $project_details->disposition == $key->disposition_id ? 'selected' : ''?>><?= $key->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <?php if ($client_approval) : ?>
                                                <div class="col-md-2">
                                                    <button class="btn btn-default" type="button" id="Add" <?= $completed ? 'disabled' : '' ?>>Add Disposition</button>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                            <?php endif; ?>


                                            <?php if(!in_array($designation_id, [9])): ?>
                                            <?php if ($client_approval) : ?>
                                            <!-- disposition internal -->
                                            <div class="form-group">
                                                <label class="col-md-12" for="disposition">Internal Disposition</label><br>
                                                <div class="col-md-10">
                                                    <select name="project[disposition]" id="disposition_internal" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                        <option value="0">No Disposition Assigned</option>
                                                        <?php foreach ($disposition as $key) : ?>
                                                        <option value="<?= $key->disposition_id ?>" <?= $project_details->disposition == $key->disposition_id ? 'selected' : ''?>><?= $key->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <?php if ($client_approval) : ?>
                                                <div class="col-md-2">
                                                    <button class="btn btn-default" type="button" id="add_disposition_internal" <?= $completed ? 'disabled' : '' ?>>Add Disposition</button>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <hr style="border-top: 1px solid #bdbdbd;">
                                            <?php endif; ?>
                                            <?php endif; ?>

                                            <!-- Priority -->
                                            <?php if(!in_array($designation_id, [9])): ?>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Project Priority</label>
                                                    <select name="project[priority]" class="form-control" <?php echo !$client_approval ? 'disabled' : '' ?> <?= $completed ? 'disabled' : '' ?>>
                                                        <option value="standard"
                                                        <?= $project_details->priority == 'standard' ? 'selected' : '' ?>>Standard Priority</option>
                                                        <option value="high"
                                                        <?= $project_details->priority == 'high' ? 'selected' : '' ?>>High Priority</option>
                                                        <option value="critical"
                                                        <?= $project_details->priority == 'critical' ? 'selected' : '' ?>>Critical</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if(!in_array($designation_id, [9])): ?>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Project Deadline</label>
                                                    <input name="project[deadline]" class="form-control" type="text"  value="<?php echo !in_array($project_details->deadline, [NULL, '1970-01-01', '0000-00-00']) ? date('m/d/Y', strtotime($project_details->deadline)) : '' ?>" id="calendar" <?php echo !$client_approval ? 'disabled' : '' ?> placeholder="No deadline assigned" <?= $completed ? 'disabled' : '' ?>>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                             <!-- Internal Deadline -->
                                            <?php if($client_approval): ?>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Project Internal Deadline</label>
                                                    <input name="project[internal_deadline]" class="form-control" type="text"  value="<?php echo !in_array($project_details->internal_deadline, [NULL, '1970-01-01', '0000-00-00']) ? date('m/d/Y', strtotime($project_details->internal_deadline)) : '' ?>" id="internal_deadline_calendar" placeholder="No internal deadline assigned" <?= $completed ? 'disabled' : '' ?>>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Price -->
                                            <?php if($member_permission): ?>
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <label for="">Budget <span class="font-green-meadow"><?php echo $project_details->request_estimate == 1 ? '(Estimate requested)' : '' ?></span></label>
                                                    <input value="<?= $project_details->price ?>" name="project[price]" type="text" class="form-control" placeholder="Bugdet..."  <?php echo !$client_approval ? 'disabled' : '' ?> <?= $completed ? 'disabled' : '' ?> onkeypress="return isNumberKey(event)">
                                                </div>

                                                <!-- Estimated price -->
                                                <?php switch ($project_details->estimated_approve) {
                                                    case 1:
                                                        $estimated_approve = 'Aprroved';
                                                        $estimated_approve_class = 'success';
                                                        break;
                                                    case 2:
                                                        $estimated_approve = 'Revise';
                                                        $estimated_approve_class = 'warning';
                                                        break;
                                                    case 3:
                                                        $estimated_approve = 'Declined';
                                                        $estimated_approve_class = 'danger';
                                                        break;
                                                    case 0:
                                                        $estimated_approve = 'No action yet';
                                                        $estimated_approve_class = 'secondary';
                                                        break;
                                                } ?>
                                                <?php if($client_approval): ?>
                                                <div class="col-md-3">
                                                    <label for="">Estimate 
                                                        <span class="badge badge-<?php echo $estimated_approve_class ?>"><?php echo $estimated_approve ?></span> 
                                                        <span type="button" class="badge badge-primary send_quote" style="cursor: pointer;">Send quote</span> 
                                                        <!-- <button class="btn btn-sm btn-circle" type="button">Send Quote</button> -->
                                                    </label>
                                                    <input type="text" class="form-control" name="project[estimated_price]" value="<?= $project_details->estimated_price == 0 ? '' : $project_details->estimated_price ?>" placeholder="Estimated Price" <?= $completed ? 'disabled' : '' ?>>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if(!$client_approval): ?>
                                                <div class="col-md-3">
                                                    <label for="">Recieved Price 
                                                        <span class="badge badge-<?php echo $estimated_approve_class ?>"><?php echo $estimated_approve ?></span> 
                                                    </label>
                                                    <input type="text" class="form-control" name="project[estimated_price]" value="<?= $project_details->estimated_price == 0 ? '' : $project_details->estimated_price ?>" placeholder="Recieved Price" disabled>
                                                </div> 
                                                <?php endif; ?>

                                                <?php if ($client_approval) : ?>
                                                <div class="col-md-3">
                                                    <label for="">Project Price Type</label>
                                                    <select name="project[price_type]" class="form-control" <?php echo !$client_approval ? 'disabled' : '' ?> <?= $completed ? 'disabled' : '' ?>>
                                                        <option value="">Select price Type</option>
                                                        <option value="plus_tax" <?= $project_details->price_type == 'plus_tax' ? 'selected' : ''?>>Plus Tax</option>
                                                        <option value="include_tax" <?= $project_details->price_type == 'include_tax' ? 'selected' : ''?>>Include Tax</option>
                                                        <option value="tax_exempt" <?= $project_details->price_type == 'tax_exempt' ? 'selected' : ''?>>Tax Exempt</option>
                                                    </select>
                                                </div>
                                                <?php endif; ?>
                                                <div class="col-md-3">
                                                    <label for="">Estimateed price status</label>
                                                    <select name="project[estimated_approve]" class="form-control" <?= $project_details->estimated_price == 0 ? 'disabled' : '' ?> <?= $completed ? 'disabled' : '' ?>>
                                                        <option value="" selected="" disabled="">Change estimateed price status</option>
                                                        <option value="1">Approve</option>
                                                        <option value="2">Revise</option>
                                                        <option value="3">Decline</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php endif; ?>


                                            <div class="form-group">
                                                <!-- PO# -->
                                                <div class="col-md-6">
                                                    <label for="">Project Po</label>
                                                    <input value="<?= $project_details->po ?>" name="project[po]" type="text" class="form-control" placeholder="PO#" <?php echo !$client_approval ? 'disabled' : '' ?> <?= $completed ? 'disabled' : '' ?>>
                                                </div>

                                                <!-- Quantity -->
                                                <div class="col-md-6">
                                                    <label for="">Project Quantity</label>
                                                    <input value="<?= $project_details->quantity ?>" name="project[quantity]" type="number" class="form-control" placeholder="Quantity" <?= $completed ? 'disabled' : '' ?>>
                                                </div>
                                            </div>

                                            <!-- Tracking# -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Project Tracking</label>
                                                    <input value="<?php echo $project_details->tracking ?>" name="project[tracking]" type="text" class="form-control" placeholder="Tracking#"  <?php echo !$client_approval ? 'disabled' : '' ?> <?= $completed ? 'disabled' : '' ?>>
                                                </div>
                                            </div>
                                            
                                            <!-- Job title -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Project Title</label>
                                                    <input id="job_title" name="project[title]" type="text" value="<?= $project_details->title ?>" class="form-control" placeholder="Job title" maxlength="30" <?php echo !$client_approval ? 'disabled' : '' ?> <?= $completed ? 'disabled' : '' ?> <?= $completed ? 'disabled' : '' ?>>
                                                </div>
                                                <div class="col-md-12 text-right">
                                                    <span><span id="job_title_cn"></span>/30</span>
                                                    <a id="sample_editable_1_new" data-toggle="modal" data-target="#revision_history"><i class="fas fa-info-circle"></i></a>
                                                </div>
                                            </div>

                                            
                                            <!-- Job desc -->
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label for="">Project Description</label>
                                                    <textarea style="resize: vertical;" name="project[description]" class="form-control" rows="8" placeholder="Job Description..." <?= $completed ? 'disabled' : '' ?>><?= $project_details->description ?></textarea>
                                                   <!--  <?php if(!$client_approval && $project_details->desc_approval == 0): ?>
                                                    <span style="margin-top: 20px" class="label label-sm label-success">Waiting for approval</span>
                                                    <?php endif; ?> -->
                                                </div>
                                                <div class="col-md-6">
                                                    <h4 style="margin-top: 0">Description History</h4>
                                                    <div id="project_description_history">
                                                        <table class="table">
                                                            <tbody>
                                                                <?php foreach ($project_description_history as $key): ?>
                                                                <tr>
                                                                    <td><a href="<?php echo base_url('Project_controller/project_description/'.$key->project_description_history_id)?>"><?php echo word_limiter($key->description, 10) ?></a></td>
                                                                    <td>
                                                                    <?php echo time_elapsed_string(date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'Y-m-d H:i:s')) ?>
                                                                    </td>
                                                                    <?php if($client_approval && !in_array($designation_id, [9])): ?>
                                                                    <?php if($key->approve == 0): ?>
                                                                    <td><button class="btn btn-default btn-sm desc_approval_btn" value="<?php echo $key->project_description_history_id?>" type="button" <?= $completed ? 'disabled' : '' ?>>Approve</button></td>
                                                                    <?php else: ?>
                                                                    <td>Approved</td>
                                                                    <?php endif; ?>
                                                                    <?php else: ?>
                                                                    <td><?php echo $key->approve == 0 ? 'Waiting for approval' : 'Approved'  ?></td>
                                                                    <?php endif; ?>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php if($member_permission): ?>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-circle btn-md green">Save</button>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                        </div>
                                    </form>

                                    <!-- specification -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <button class="btn" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample2">Specification</button>
                                            <button style="float: right;" class="btn" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Add Specification</button>
                                        </div>
                                        
                                        <div class="collapse multi-collapse" id="multiCollapseExample2">
                                            <form id="" action="<?php echo base_url('Project_controller/update_project_specification_action/'.$project->project_id)?>" class="form-horizontal" method="POST" onkeydown="return event.key != 'Enter';">
                                                <div class="form msg-frm" style="padding: 20px !important">
                                                    <div class="form-group">
                                                        <!-- Finish -->
                                                        <div class="col-md-2">
                                                            <span>Finish</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[finish]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_finish as $key => $value) : ?>
                                                                <option value="<?= $value ?>"
                                                                    <?= $project_specification->finish == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Purity / Color / Metal -->
                                                        <div class="col-md-2">
                                                            <span>Purity / Color / Metal</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[purity]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_purity as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->purity == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <!-- Ring Size -->
                                                        <div class="col-md-2">
                                                            <span>Ring Size</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[ring_size]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_ring_size as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->ring_size == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <!-- Plating -->
                                                        <div class="col-md-2">
                                                            <span>Plating</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[plating]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_plating as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->plating == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input value="<?= $project_specification->custom ?>" name="project_specification[custom]" type="text" placeholder="Custom Specification" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                        </div>
                                                    </div>


                                                    <hr>


                                                    <div class="form-group">
                                                        <!-- Wax only -->
                                                        <div class="col-md-2">
                                                            <span>Wax Only</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[wax_only]" class="form-control" id="wax_only" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_wax_only as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->wax_only == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Wax Only Resin -->
                                                       <!--  <div id="wax_only_resin">
                                                        <div class="col-md-2">
                                                            <span>Wax Only Resin</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[wax_only_resin]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_wax_only_resin as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->wax_only_resin == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        </div> -->
                                                    </div>

                                                    <div class="form-group">
                                                        <!-- Casting Only -->
                                                        <div class="col-md-2">
                                                            <span>Casting Only</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[casting_only]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_casting_only as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->casting_only == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Mold -->
                                                        <div class="col-md-2">
                                                            <span>Mold</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[mold]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_mold as $key => $value) : ?>
                                                                <option value="<?= $value ?>"  <?= $project_specification->mold == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <!-- Supply Diamonds -->
                                                        <div class="col-md-2">
                                                            <span>Supply Diamonds</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[supply_diamonds]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_supply_diamonds as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->supply_diamonds == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Supply Center -->
                                                        <div class="col-md-2">
                                                            <span>Supply Center</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[supply_center]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_supply_center as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->supply_center == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <!-- Supply All Gems -->
                                                        <div class="col-md-2">
                                                            <span>Supply All Gems</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[supply_all_gems]" class="form-control" id="supply_all_gems" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_supply_all_gems as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->supply_all_gems == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Supply Center -->
                                                        <div id="supply_all_gems_yes">
                                                        <div class="col-md-2">
                                                            <span>Supply All Gems</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[supply_all_gems_yes]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_supply_all_gems_yes as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->supply_all_gems_yes == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <!-- Supply All Gems -->
                                                        <div class="col-md-2">
                                                            <span>Sending my own</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[sending_my_own]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_sending_my_own as $key => $value) : ?>
                                                                <option value="<?= $value ?>"  <?= $project_specification->sending_my_own == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    
                                                    

                                                    <?php if(!in_array($designation_id, [9])): ?>
                                                    <?php if($member_permission): ?>
                                                    <div class="form-actions right todo-form-actions">
                                                        <button type="submit" class="btn btn-circle btn-sm green" <?= $completed ? 'disabled' : '' ?>>Save Specification</button>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <div class="collapse multi-collapse in show" id="multiCollapseExample1">
                                            <div class="row" style="margin: 20px">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                  <li class="nav-item active">
                                                    <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Specification</a>
                                                  </li>
                                                  <li class="nav-item">
                                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Specification History</a>
                                                  </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active in" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                        <div class="col-md-6">
                                                            <ul>
                                                                <li>Ring Size : <span class="text-info"><?php echo $project_specification->ring_size ?></span></li>
                                                                <li>Purity / Color / Metal:  <span class="text-info"><?php echo $project_specification->purity ?></span></li>
                                                                <li>Plating:  <span class="text-info"><?php echo $project_specification->plating ?></span></li>
                                                                <li>Finish:  <span class="text-info"><?php echo $project_specification->finish ?></span></li>
                                                                <li>Custom:  <span class="text-info"><?php echo $project_specification->custom ?></span></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <ul>
                                                                <li>
                                                                    Wax Only : <span class="text-info"><?php echo $project_specification->wax_only ?></span> / 
                                                                    Casting Only:  <span class="text-info"><?php echo $project_specification->casting_only ?></span>
                                                                </li>
                                                                <li>Mold:  <span class="text-info"><?php echo $project_specification->mold ?></span></li>
                                                                <li>Supply Diamonds:  <span class="text-info"><?php echo $project_specification->supply_diamonds ?></span></li>
                                                                <li>Supply Center:  <span class="text-info"><?php echo $project_specification->supply_center ?></span></li>
                                                                <li>
                                                                    Supply All Gems:  <span class="text-info"><?php echo $project_specification->supply_all_gems ?> <?php echo $project_specification->supply_all_gems == 'Yes' ? 
                                                                    '/' : '' ?> <?php echo $project_specification->supply_all_gems_yes ?></span>
                                                                </li>
                                                                <li>Sending my own: <span class="text-info"> <?php echo $project_specification->sending_my_own ?></span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                        <table class="table">
                                                            <tbody>
                                                                <?php foreach ($project_specification_history as $key): ?>
                                                                <tr>
                                                                    <td><?php echo ucwords($key->type).' changed to '.$key->value ?></td>

                                                                    <?php if($client_approval && !in_array($designation_id, [9])): ?>
                                                                    <?php if($key->approve == 0): ?>
                                                                    <td><button class="btn btn-default btn-sm spec_approval_btn" value="<?php echo $key->project_specification_history_id?>" type="button" <?= $completed ? 'disabled' : '' ?>>Approve</button></td>
                                                                    <?php else: ?>
                                                                    <td>Approved</td>
                                                                    <?php endif; ?>
                                                                    <?php else: ?>
                                                                    <td><?php echo $key->approve == 0 ? 'Waiting for approval' : 'Approved'  ?></td>
                                                                    <?php endif; ?>
                                                                    <td>
                                                                        <?php echo time_elapsed_string(date("Y-m-d H:i:s", strtotime($key->created_at) + (5*60*60) + 30*60)) ?>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- end specification -->

                                    <!-- message -->
                                    <?php echo $project_details_message_section; ?>
                                    <!-- end message -->


                                     <!-- Note -->
                                    <?php if(in_array($designation_id, [1, 6, 8])): ?>
                                    <?php echo $project_details_note_section; ?>
                                    <?php endif; ?>
                                    <!-- end Note -->

                                    <!-- Upload Image -->
                                    <?php echo $project_details_upload_image_section; ?>
                                    <!-- end Upload Image -->


                                    <!-- Archive files -->
                                    <?php if(!in_array($designation_id, [5,7,9])): ?>
                                    <?php echo $project_details_archive_section; ?>
                                    <?php endif; ?>
                                    <!-- end Archive files -->


                                    <!-- Print Porject -->
                                    <?php //if($client_approval): ?>
                                    <?php if(in_array($designation_id, [1,6,8,10])): ?>
                                    <?php echo $project_details_print_section; ?>
                                    <?php endif; ?>
                                    <?php //endif; ?>
                                    <!-- end Print Porject -->


                                    <!-- Vendor Print Porject -->
                                    <?php if($client_approval): ?>
                                    <?php if(!in_array($designation_id, [9])): ?>
                                    <?php echo $project_details_vendor_section; ?>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <!-- end Vendor Print Porject -->


                                    <!-- Printing Ship Label -->
                                    <?php echo $project_details_ship; ?>
                                    <!-- end Printing Ship Label -->



                                    <!-- Activty Log Porject -->
                                    <?php if($client_approval): ?>
                                    <?php if(!in_array($designation_id, [9])): ?>
                                    <?php echo $project_details_activity_section; ?>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <!-- end activity log -->
                                </div>
                                        
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
                    <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include 'inc/footer.php'; ?>
        <!-- END FOOTER -->
    </div>

        

        <!-- disposition change modal -->
        <div class="modal fade" id="change_disposition_modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <form id="change_disposition_form" action="">
                            <div class="form-group">
                                <select name="project[disposition_id]" class="form-control" required="">
                                    <option value="">No Disposition Assigned</option>
                                    <?php foreach ($disposition as $key) : ?>
                                    <option value="<?= $key->disposition_id ?>" <?= $project_details->disposition == $key->disposition_id ? 'selected' : ''?>><?= $key->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="hidden" class="change_disposition_id" name="project[project_disposition_id]" value="">
                            <div class="form-group">
                                <button class="btn">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- end disposition change modal -->

        <!-- Image Gallery Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Project Image Gallery</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Cad</h4>
                                <?php foreach ($project_files as $key) : ?>
                                    <?php  if ($key->type == 'cad') : ?>
                                <a href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name ?>" data-fancybox="images" data-caption="Backpackers following a dirt trail">
                                    <img src="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name ?>" width="150" height="130"/>
                                </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Pic</h4>
                                <?php foreach ($project_files as $key) : ?>
                                    <?php  if ($key->type == 'pic') : ?>
                                <a href="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name ?>" data-fancybox="images" data-caption="Backpackers following a dirt trail">
                                    <img src="<?= 'https://dn95g1jn6e80y.cloudfront.net/'.$key->file_name ?>" width="150" height="130"/>
                                </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- internal disposition change modal -->
        <div class="modal fade" id="change_disposition_internal_modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change Internal Disposition</h4>
                    </div>
                    <div class="modal-body">
                        <form id="change_disposition_internal_form" action="">
                            <div class="form-group">
                                <select name="project[disposition_id]" class="form-control" required="">
                                    <option value="">No Disposition Assigned</option>
                                    <?php foreach ($disposition as $key) : ?>
                                    <option value="<?= $key->disposition_id ?>" <?= $project_details->disposition == $key->disposition_id ? 'selected' : ''?>><?= $key->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="hidden" class="change_disposition_internal_id" name="project[project_disposition_id]" value="">
                            <div class="form-group">
                                <button class="btn">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- end disposition change modal -->


        <!-- archive group modal -->
       
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/pages/scripts/form-fileupload.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

        <?php if ($this->session->flashdata('cad_progress')): ?>
        <script>
            swal('Project cad progression has changed');
        </script>
        <?php $this->session->unset_userdata('cad_progress'); endif;  ?>

        <script>
            $(document).ready(function(){
                $(document).on('change', '#wax_only', function(){
                    var wax_only = $(this).val();
                    if(wax_only == 'Resin'){
                        $('#wax_only_resin').show();
                    } else{
                        $("[name='project_specification[wax_only_resin]']").val('');
                        $('#wax_only_resin').hide();
                    }

                });

                $(document).on('change', '#supply_all_gems', function(){
                    var supply_all_gems = $(this).val();
                    if(supply_all_gems == 'Yes'){
                        $('#supply_all_gems_yes').show();
                    } else{
                        $("[name='project_specification[supply_all_gems_yes]']").val('');
                        $('#supply_all_gems_yes').hide();
                    }

                });

                var wax_only = $("[name='project_specification[wax_only]']").val();
                if(wax_only == 'Resin')
                    $('#wax_only_resin').show();
                else
                    $('#wax_only_resin').hide();

                var supply_all_gems = $("[name='project_specification[supply_all_gems]']").val();
                if(supply_all_gems == 'Yes')
                    $('#supply_all_gems_yes').show();
                else
                    $('#supply_all_gems_yes').hide();
            });
        </script>

        <!-- project title leng count -->
        <script>
            $(function(){
                var job_title_cn = $('#job_title').val();
                    $('#job_title_cn').html(job_title_cn.length);
                    $(document).on('keyup', '#job_title', function(){
                    var max_input = 30;
                    var job_title_cn = $('#job_title').val();
                    if(job_title_cn.length <= max_input)
                        $('#job_title_cn').html(job_title_cn.length);
                });
            });
        </script>

      

        <?php if ($this->session->flashdata('project_insert')) : ?>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            jQuery.noConflict();
            (function ($){
                // swal("Good job!", "One Job Added", "success");
                swal("Uploaded successfully")
                .then((value) => {
                  window.location.href = "<?php echo base_url() ?>";
                });

                swal({
                  text: "Uploaded successfully",
                  buttons: true,
                  buttons: ["Cancel", "Go to dashboard"],
                })
                .then((willDelete) => {
                  if (willDelete) {
                        window.location.href = "<?php echo base_url() ?>";
                  } else {
                  }
                });
            })(jQuery);
        </script>
        <?php endif; ?>

        <script>
            $(document).ready(function() {
                $('#Add').click(function() {
                    var disposition = $('#disposition').val();
                    var project_id = '<?= $this->uri->segment(3); ?>';
                    if (disposition != 0) {
                        $.ajax({
                            url: "<?= site_url('Project_controller/insert_disposition') ?>",
                            type: 'POST',
                            data: {
                                'project_id': project_id,
                                'disposition': disposition
                            },
                            success: function(data) {
                                if (data == 'false')
                                    swal("Disposition already added", {
                                        dangerMode: true,
                                    });
                                else {
                                    swal('Disposition Added');
                                    $('#project_disposition_steps #project_dispositions_main').html(data);
                                }
                            }
                        });
                    }
                });

                $(document).on('click', '.update_disposition', function() {
                    var project_disposition_id = $(this).val();
                    $.ajax({
                        url: "<?= site_url('Project_controller/update_disposition') ?>" + "/" + project_disposition_id,
                        success: function(data) {
                            swal('Disposition Updated');
                            $('#project_disposition_steps #project_dispositions_main').html(data);
                        }
                    });
                });
                $(document).on('click', '.change_disposition', function() {
                    var project_disposition_id = $(this).val();
                    $('.change_disposition_id').val(project_disposition_id);
                });
                $(document).on('click', '.delete_disposition', function() {
                    var project_disposition_id = $(this).val();
                    $.ajax({
                        url: "<?= site_url('Project_controller/delete_disposition') ?>" + "/" + project_disposition_id,
                        success: function(data) {
                            // alert(data);
                            swal('Disposition Updated');
                            $('#project_disposition_steps #project_dispositions_main').html(data);
                        }
                    });

                });
                $(document).on('submit', '#change_disposition_form', function(e) {
                    e.preventDefault();
                    var form = $(this).serialize();
                    $.ajax({
                        url: "<?= site_url('Project_controller/change_disposition') ?>",
                        data: form,
                        type: 'post',
                        success: function(data) {
                            // alert(data);
                            $('#change_disposition_modal').modal('hide');
                            swal('Disposition Updated');
                            $('#project_disposition_steps #project_dispositions_main').html(data);
                        }
                    });
                });
                $(document).on('click', '.revert', function() {
                    var project_disposition_id = $(this).val();
                    $.ajax({
                        url: "<?= site_url('Project_controller/revert_disposition') ?>" + "/" + project_disposition_id,
                        success: function(data) {
                            swal('Disposition Updated');
                            $('#project_disposition_steps #project_dispositions_main').html(data);
                        }
                    });

                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#add_disposition_internal').click(function() {
                    var disposition = $('#disposition_internal').val();
                    var project_id = '<?= $this->uri->segment(3); ?>';
                    if (disposition != 0) {
                        $.ajax({
                            url: "<?= site_url('Project_controller/insert_disposition_internal') ?>",
                            type: 'POST',
                            data: {
                                'project_id': project_id,
                                'disposition': disposition
                            },
                            success: function(data) {
                                if (data == 'false')
                                    swal("Disposition already added", {
                                        dangerMode: true,
                                    });
                                else {
                                    swal('Disposition Added');
                                    $('#project_disposition_internal_steps').html(data);
                                }
                            }
                        });
                    }
                });
                $(document).on('click', '.update_disposition_internal', function() {
                    var project_disposition_id = $(this).val();
                    $.ajax({
                        url: "<?= site_url('Project_controller/update_disposition_internal') ?>" + "/" + project_disposition_id,
                        success: function(data) {
                            swal('Disposition Updated');
                            $('#project_disposition_internal_steps').html(data);
                        }
                    });
                });
                $(document).on('click', '.change_disposition_internal', function() {
                    var project_disposition_id = $(this).val();
                    $('.change_disposition_internal_id').val(project_disposition_id);
                });
                $(document).on('click', '.delete_disposition_internal', function() {
                    var project_disposition_id = $(this).val();
                    $.ajax({
                        url: "<?= site_url('Project_controller/delete_disposition_internal') ?>" + "/" + project_disposition_id,
                        success: function(data) {
                            // alert(data);
                            swal('Disposition Updated');
                            $('#project_disposition_internal_steps').html(data);
                        }
                    });

                });
                $(document).on('submit', '#change_disposition_internal_form', function(e) {
                    e.preventDefault();
                    var form = $(this).serialize();
                    $.ajax({
                        url: "<?= site_url('Project_controller/change_disposition_internal') ?>",
                        data: form,
                        type: 'post',
                        success: function(data) {
                            // alert(data);
                            $('#change_disposition_internal_modal').modal('hide');
                            swal('Disposition Updated');
                            $('#project_disposition_steps #project_dispositions_main').html(data);
                        }
                    });
                });
                $(document).on('click', '.revert_internal', function() {
                    var project_disposition_id = $(this).val();
                    $.ajax({
                        url: "<?= site_url('Project_controller/revert_disposition_internal') ?>" + "/" + project_disposition_id,
                        success: function(data) {
                            swal('Disposition Updated');
                            $('#project_disposition_internal_steps').html(data);
                        }
                    });

                });
            });
        </script>
       

        <?php if(isset($_SERVER['HTTP_REFERER'])): ?>
        <?php if($_SERVER['HTTP_REFERER']  == base_url('Master_controllers/dashboard')): ?>
        <script>
            $('#messaging').collapse('show');
        </script>
        <?php endif; ?>
        <?php endif; ?>

        <script>
            $(document).on('click', '.desc_approval_btn', function(){
                var id = $(this).val();
                $.ajax({
                    url: "<?php echo base_url('Project_controller/desc_permission/')?>"+"/"+id,
                    success:function(data){
                        swal("Project description approved.")
                        .then((value) => {
                          location.reload();
                        });
                    }
                });
            });

            $(document).on('click', '.spec_approval_btn', function(){
                var id = $(this).val();
                $.ajax({
                    url: "<?php echo base_url('Project_controller/spec_permission/')?>"+"/"+id,
                    success:function(data){
                        swal("Project specification approved.")
                        .then((value) => {
                          location.reload();
                        });
                    }
                });
            });
        </script>

        <script>
            $(document).on('click', '#reset_all_disposition', function(){
                var id = $(this).val();
                swal({
                  title: "Are you sure?",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    $.ajax({
                        url: "<?= site_url('Project_controller/reset_all_disposition') ?>"+"/"+id,
                        success:function(data){
                            swal('Disposition reset');
                            $('#project_disposition_steps #project_dispositions_main').html(data);
                        }
                    });
                  }
                });

            });
        </script>
       

        

        <script>
            $(document).on('click', '.disposition_more', function(e){
                e.preventDefault();
                var val = $(this).data('value');
                swal({
                  title: "Are you sure?",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    $.ajax({
                        url: "<?php echo base_url('Project_controller/disposition_change_option/'.$project->project_id.'/') ?>"+"/"+val,
                        success:function(data){
                            $('#project_disposition_steps #project_dispositions_main').html(data);
                            swal("Disposition updated");
                        }
                    });
                  }
                });
            });
        </script>


        <!-- deadline calender scripts -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
        <script>
            jQuery.noConflict();
            
            (function($){
                // An array of dates
                var criticalDates = {};
                var rushDates = {};
                var standardDates = {};


                <?php 
                $critical_begin = new DateTime(date('m/d/Y',strtotime($project_details->created_at)));
                $critical_end   = new DateTime(date('m/d/Y',strtotime($project_details->created_at. ' +3 day')));

                for($i = $critical_begin; $i <= $critical_end; $i->modify('+1 day')): ?>
                criticalDates[ new Date( '<?php echo $i->format("m/d/Y") ?>' )] = new Date( '<?php echo $i->format("m/d/Y") ?>' );
                <?php endfor; ?>

                <?php 
                $rush_begin = new DateTime(date('m/d/Y',strtotime($project_details->created_at. ' +4 day')));
                $rush_end   = new DateTime(date('m/d/Y',strtotime($project_details->created_at. ' +7 day')));

                for($i = $rush_begin; $i <= $rush_end; $i->modify('+1 day')): ?>
                rushDates[ new Date( '<?php echo $i->format("m/d/Y") ?>' )] = new Date( '<?php echo $i->format("m/d/Y") ?>' );
                <?php endfor; ?>

                <?php 
                $standard_begin = new DateTime(date('m/d/Y',strtotime($project_details->created_at. ' +8 day')));
                $standard_end   = new DateTime(date('m/d/Y',strtotime($project_details->created_at. ' +12 day')));

                for($i = $standard_begin; $i < $standard_end; $i->modify('+1 day')): ?>
                standardDates[ new Date( '<?php echo $i->format("m/d/Y") ?>' )] = new Date( '<?php echo $i->format("m/d/Y") ?>' );
                <?php endfor; ?>

          
                
                // datepicker
                jQuery('#calendar').datepicker({
                    minDate: '<?php echo date('m/d/Y',strtotime($project_details->created_at)) ?>',
                    beforeShowDay: function( date ) {
                        var highlightCritical = criticalDates[date];
                        var highlightRush = rushDates[date];
                        var highlightStandard = standardDates[date];
                      if( highlightRush ) {
                             return [true, "rushDates", highlightRush];
                        } else if( highlightCritical ) {
                             return [true, "criticalDates", highlightCritical];
                        } else if( highlightStandard ) {
                             return [true, "standardDates", highlightStandard];
                        } else {
                             return [true, '', ''];
                        }
                       
                     }
                });
                jQuery('#print_calendar').datepicker({
                    minDate: '<?php echo date('m/d/Y',strtotime($project_details->created_at)) ?>',
                    beforeShowDay: function( date ) {
                        var highlightCritical = criticalDates[date];
                        var highlightRush = rushDates[date];
                        var highlightStandard = standardDates[date];
                      if( highlightRush ) {
                             return [true, "rushDates", highlightRush];
                        } else if( highlightCritical ) {
                             return [true, "criticalDates", highlightCritical];
                        } else if( highlightStandard ) {
                             return [true, "standardDates", highlightStandard];
                        } else {
                             return [true, '', ''];
                        }
                       
                     }
                });

                jQuery('#vendor_calendar').datepicker({
                    minDate: '<?php echo date('m/d/Y',strtotime($project_details->created_at)) ?>',
                    beforeShowDay: function( date ) {
                        var highlightCritical = criticalDates[date];
                        var highlightRush = rushDates[date];
                        var highlightStandard = standardDates[date];
                      if( highlightRush ) {
                             return [true, "rushDates", highlightRush];
                        } else if( highlightCritical ) {
                             return [true, "criticalDates", highlightCritical];
                        } else if( highlightStandard ) {
                             return [true, "standardDates", highlightStandard];
                        } else {
                             return [true, '', ''];
                        }
                       
                     }
                });

                jQuery('#internal_deadline_calendar').datepicker({
                    minDate: '<?php echo date('m/d/Y',strtotime($project_details->created_at)) ?>'
                });
            })(jQuery);
        </script>
        <!-- end deadline calender scripts -->
        
        <!-- slot datepicker scripts -->

        <script>
            jQuery(document).ready(function($) {
                $('.slot-datepicker').bind('keypress', function(e) {
                    e.preventDefault(); 
                });
                $('.slot-datepicker').bind('keydown', function(e) {
                    e.preventDefault(); 
                });
                $('.3d-print-datepicker').bind('keypress', function(e) {
                    e.preventDefault(); 
                });
                $('.3d-print-datepicker').bind('keydown', function(e) {
                    e.preventDefault(); 
                });
            });
        </script>

        <script>
            jQuery.noConflict();

            (function($){
                $(document).on('mouseenter', '.slot-datepicker', function(){
                    var slot_inp = $(this);
                    var user_id = $(this).data('user');
                    var criticalCadDates = {};
                    var rushCadDates = {};
                    var standardCadDates = {};

                    $.ajax({
                        url: "<?php echo base_url('User_controller/get_cad_slot_dates_by_status/') ?>"+user_id,
                        dataType: "json",
                        success:function(data) {
                            for (x in data.full_dates) {
                                criticalCadDates[ new Date( "'"+data.full_dates[x]+"'" )] = new Date( "'"+data.full_dates[x]+"'"  );
                            }
                            for (x in data.warning_dates) {
                                rushCadDates[ new Date( "'"+data.warning_dates[x]+"'" )] = new Date( "'"+data.warning_dates[x]+"'"  );
                            }
                            for (x in data.available_dates) {
                                standardCadDates[ new Date( "'"+data.available_dates[x]+"'" )] = new Date( "'"+data.available_dates[x]+"'"  );
                            }
                        }
                    });

                    $(this).datepicker({
                        minDate: '<?php echo date('m/d/Y',strtotime($project_details->created_at)) ?>',
                        onSelect: function(dateText, inst) {
                            var date = $(this).val();
                            var user_id = $(this).data('user');
                            $.ajax({
                                url: "<?php echo base_url('User_controller/check_slot_availability/') ?>"+user_id,
                                data: {'date': date},
                                type: "POST",
                                success:function(data){
                                    if(data == 'vacation'){
                                        swal("User have a vacation on this date please choose another.");
                                        $(slot_inp).val('');
                                    } else if(data <= 0){
                                        swal("No slot availible. Pick another date");
                                        $(slot_inp).val('');
                                    } else{
                                        var str = data+' slot availible on this date '+date;
                                        swal(str);
                                    }
                                }
                            });
                        },
                        beforeShowDay: function( date ) {
                            var highlightCritical = criticalCadDates[date];
                            var highlightRush = rushCadDates[date];
                            var highlightStandard = standardCadDates[date];

                            if( highlightRush ) {
                                 return [true, "rushDates", highlightRush];
                            } else if( highlightCritical ) {
                                 return [true, "criticalDates", highlightCritical];
                            } else if( highlightStandard ) {
                                 return [true, "standardDates", highlightStandard];
                            } else {
                                 return [true, '', ''];
                            }
                           
                         }
                    });
                });  
                $(document).on('focus', '.3d-print-datepicker', function(){
                    $(this).datepicker({
                        minDate: '<?php echo date('m/d/Y',strtotime($project_details->created_at)) ?>',
                    });
                });  
            })(jQuery);
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
        <script>
            jQuery.noConflict;

            (function($){
                $('#project_assignee').select2();
                $('#project_assignee').on('select2:select', function (e) {
                    var data = e.params.data;
                    console.log(data);
                    $.ajax({
                        url: "<?php echo base_url('User_controller/check_des/') ?>"+data.id,
                        success:function(res){
                            if(res == '1'){
                                $('#cad_slot_date_div').append('<div class="form-group" id="cad_slot_date_single_div'+data.id+'"><div class="col-md-2"><span class="badge badge-primary">'+data.text+'</span></div><div class="col-md-4"><input type="text" class="form-control slot-datepicker" data-user="'+data.id+'" name="cad_slot_date['+data.id+']" placeholder="Select cad date" autocomplete="off"></div><div class="col-md-1"><a class="btn btn-sm btn-circle btn-default cad_slots_modal_btn" target="_blank" href="<?php echo base_url('cad_slots/') ?>'+data.id+'">Cad Slot</a></div><div class="col-md-4"><input type="text" class="form-control 3d-print-datepicker" data-user="'+data.id+'" name="cad_3d_print_date['+data.id+']" placeholder="Select 3d print date" autocomplete="off"></div></div>');
                            }

                        }
                    });
                });
                $('#project_assignee').on('select2:unselect', function (e) {
                    var data = e.params.data;
                    $('#cad_slot_date_single_div'+data.id).remove();
                });
                $('#msg_user').select2();
                $('#archive_groups').select2({
                    placeholder: "Select Group"
                });
            })(jQuery);
        </script>

        <!-- end slot datepicker scripts -->
        
       
        <script>
            $(document).on('click', '.send_quote', function(){
                $.ajax({
                	url: "<?php echo base_url('Project_controller/send_estimate_email/'.$project->project_id) ?>",
                	success:function(data){
                		swal('Quote sent successfully');
                	}
                });
            });
        </script>
        
        <?php if(in_array($designation_id, [5, 7])): ?>
        <?php if($project_details->estimated_approve != 1 && $project_details->estimated_price != 0): ?>
        <?php if(!get_cookie("ignore")): ?>
        <script>
            swal("You have estimate status, Price = <?php echo $project_details->estimated_price?>", {
              buttons: {
                accept: {
                  text: "Accept",
                  value: "accept",
                },
                revise: {
                  text: "Revise",
                  value: "revise",
                }, 
                ignore: {
                  text: "Ignore for now",
                  value: "ignore",
                },
              },
            })
            .then((value) => {
              switch (value) {
                case "accept":
                  change_estimate_approve(1);
                  break;
                case "revise":
                  change_estimate_approve(2);
                  break;
                case "ignore":
                  change_estimate_approve(4);
                  break;
              }
            });

            function change_estimate_approve(type){
                $.ajax({
                    url: "<?php echo base_url('Project_controller/change_estimate_approve/'.$project_details->project_id) ?>",
                    data: {
                        'type': type
                    },
                    type: 'POST',
                    success:function(data){
                        location.reload();
                    }
                });
            }

        </script>
        <?php endif; ?>
        <?php endif; ?>
        <?php endif; ?>

        <script>
        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
        </script>
        
    </body>
    
</html>
<?php //$endtime = microtime(true); 
// printf("Page loaded in %f seconds", $endtime - $starttime );
?>
