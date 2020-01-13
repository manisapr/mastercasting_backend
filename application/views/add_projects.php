        <!-- BEGIN HEADER -->
        <?php include 'inc/header.php'; ?>
        <style>
            .list-group-item{
                border: 1px solid rgba(0,0,0,.125) !important;
            }
        </style>

        <style>
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
                   
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li> <a href="<?php echo base_url()?>">Home</a> <i class="fa fa-circle"></i> </li>
                            <li> <a href="<?php echo base_url('projects/all_projects')?>">projects</a> <i class="fa fa-circle"></i> </li>
                            <li> <span>Add projects</span> </li>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h1 class="page-title">Add Project
                    </h1>
                    <!-- END PAGE TITLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-dark"> 
                                        <i class="icon-briefcase font-dark"></i> 
                                        <span class="caption-subject bold uppercase">New project form</span> 
                                    </div>
                                    <!-- <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                            <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                            <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                                        </div>
                                    </div> -->
                                    
                                    
                                    
                                    <!-- <div class="pro_btn">
                                        <div class="btn_grp"> <a href="">All</a> </div>
                                        <div class="btn_grp"> <a href="">Designer</a> </div>
                                        <div class="btn_grp"> <a href="">Casting & Cad</a> </div>
                                        <div class="btn_grp"> <a href="">Polish</a> </div>
                                    </div>
                                     -->
                                    
                                    
                                </div>
                                <div class="portlet-body">
                                    <form id="add_project_frm" action="<?= site_url('projects/add_project_action')?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                        <input type="hidden" name="is_file_uploaded" value="0">
                                        <!-- == -->
                                        <div class="form msg-frm">
                                            <input type="hidden" name="project[dynamic_id]" value="<?php echo $dynamic_id ?>">
                                            <!-- END TASK HEAD -->
                                            <!-- Created at -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control todo-taskbody-tasktitle" value="<?= date('D, F d, Y') ?>" disabled> 
                                                </div>
                                            </div>
                                            <!-- type -->
                                            <!-- <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project_details[type]" class="form-control">
                                                        <option value="proposal" selected="">Proposal</option>
                                                        <?php if ($client_approval) : ?>
                                                        <option value="live">Live</option>
                                                        <?php endif; ?>
                                                        <option value="completed">Completed</option>
                                                        <option value="cancelled">Cancelled</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <!-- Manager -->
                                            <!-- <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project[manager_category]" class="form-control">
                                                        <option value="">Set Manager</option>
                                                        <?php foreach ($manager as $key): ?>
                                                        <option value="<?= $key->id ?>"><?= $key->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <!-- Client -->
                                            <?php if ($client_approval) : ?>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select id="all_clients" name="project[asign_user]" class="form-control">
                                                        <option value="">Set Client</option>
                                                        <?php foreach ($client as $key): ?>
                                                        <?php if($key->designation_id == 7): ?>
                                                        <option <?php echo $is_user_id_set !== FALSE && $is_user_id_set == $key->id ? 'selected' : '' ?> value="<?= $key->id ?>"><?= $key->company_name.' - ('.$key->name.')' ?></option>
                                                        <?php else: ?>
                                                        <option <?php echo $is_user_id_set !== FALSE && $is_user_id_set == $key->id ? 'selected' : '' ?> value="<?= $key->id ?>"><?= $key->name ?></option>
                                                        <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                               <!--  <?php if ($client_approval) : ?>
                                                <div  class="col-md-2">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#add_client_modal">Add Client</button>
                                                </div>
                                                <?php endif; ?> -->
                                            </div>
                                            <?php endif; ?>
                                            <!-- Asignee -->
                                            <!-- <?php if ($client_approval) : ?>
                                            <div class="form-group">
                                                <div class="col-md-<?= $client_approval ? '4' : '6'?>">
                                                    <select id="all_assignee" name="project_details[assignee][]" class="form-control all_assignee" required>
                                                        <option selected="" disabled="">Set Assignee</option>
                                                        <?php foreach ($assignee as $key): ?>
                                                        <option value="<?= $key->id ?>"><?= $key->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div  class="col-md-2">
                                                    <button class="btn btn-default set_permission_btn" type="button" value="" data-toggle="modal" data-target="#set_permission_modal">Set Permission</button>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control permissions_id" name="permissions[permission_id][]">
                                                        <option value="">Choose Permission Key</option>
                                                        <?php foreach ($permissions as $key) : ?>
                                                        <option value="<?= $key->permission_id?>"><?= $key->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control permissions_level" name="permissions[level][]">
                                                        <option value="">Set Permission</option>
                                                        <option value="1">Allow</option>
                                                        <option value="0">Disallow</option>
                                                    </select>
                                                </div>
                                                
                                                <?php if ($client_approval) : ?>
                                                <div  class="col-md-2">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#add_member_modal">Add Member</button>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                            <div class="add_assignee_field"></div>

                                            <?php if ($client_approval) : ?>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <button id="add_another_assignee" class="btn" type="button"><i class="fa fa-plus"></i> Add Another Assignee</button>
                                                </div>
                                            </div>
                                            <?php endif; ?> -->
                                            <!-- disposition -->
                                            <!-- <?php if ($client_approval) : ?>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project_details[disposition]" class="form-control">
                                                        <option value="0">No Disposition Assigned</option>
                                                        <?php foreach ($disposition as $key) : ?>
                                                        <option value="<?= $key->disposition_id ?>"><?= $key->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php endif; ?> -->
                                            <!-- Priority -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project_details[priority]" class="form-control">
                                                        <option value="standard">Standard Priority</option>
                                                        <option value="high">High Priority</option>
                                                        <option value="critical">Critical</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Deadline -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input name="project_details[deadline]" class="form-control" type="text" id="calendar" placeholder="Deadline" value="<?php echo date('m/d/Y', strtotime(date('m/d/Y'). ' +10 day')) ?>" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <!-- Price -->
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input name="project_details[price]" type="number" class="form-control" placeholder="Bugdet...">
                                                </div>
                                                <?php if($client_approval): ?>
                                                <div class="col-md-4">
                                                    <select name="project_details[price_type]" class="form-control">
                                                        <option value="plus_tax">Plus Tax</option>
                                                        <option value="include_tax">Include Tax</option>
                                                        <option value="tax_exempt">Tax Exempt</option>
                                                    </select>
                                                </div>
                                                <?php endif; ?>
                                                <?php if(!$client_approval): ?>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                      <label><input type="checkbox" name="project_details[request_estimate]" value="1">Request Estimate</label>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <!-- PO# -->
                                            <?php //if ($client_approval) : ?>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <input name="project_details[po]" type="text" class="form-control" placeholder="PO#">
                                                </div>
                                                <div class="col-md-6">
                                                    <input name="project_details[quantity]" type="number" class="form-control" placeholder="Quantity">
                                                </div>
                                            </div>
                                            <?php //endif; ?>
                                            <!-- Tracking# -->
                                           <!--  <?php if ($client_approval) : ?>
                                           <div class="form-group">
                                               <div class="col-md-12">
                                                   <input name="project_details[tracking]" type="text" class="form-control" placeholder="Tracking#">
                                               </div>
                                           </div>
                                           <?php endif; ?> -->
                                            <!-- TASK DESC -->
                                            <!-- <div class="form-group">
                                                <div class="col-md-12">
                                                    <textarea class="form-control todo-taskbody-taskdesc" rows="8" placeholder="Task Description..."></textarea>
                                                </div>
                                            </div> -->
                                            <!-- END TASK DESC -->

                                            <!-- Job title -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input id="job_title" name="project_details[title]" type="text" class="form-control" placeholder="Job title" maxlength="30" required="">
                                                </div>
                                                <div class="col-md-12 text-right">
                                                    <span><span id="job_title_cn"></span>/30</span>
                                                    <a id="sample_editable_1_new" data-toggle="modal" data-target="#revision_history"><i class="fas fa-info-circle"></i></a>
                                                </div>
                                            </div>

                                            <!-- Job desc -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <textarea name="project_details[description]" class="form-control" rows="8" placeholder="Job Description..."></textarea>
                                                </div>
                                                <div class="col-md-12 text-right">
                                                    <a id="sample_editable_1_new" data-toggle="modal" data-target="#revision_history"><i class="fas fa-info-circle"></i></a>
                                                </div>
                                            </div>                                            
                                            
                                        </div>
                                        <!-- specification -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <button class="btn" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample2">Specification</button>
                                                <button style="float: right;" class="btn" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Add Specification</button>
                                            </div>
                                            
                                            <div class="collapse multi-collapse" id="multiCollapseExample2">
                                                <div class="form msg-frm" style="padding: 20px !important">
                                                    <div class="form-group">
                                                        <!-- Finish -->
                                                        <div class="col-md-2">
                                                            <span>Finish</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[finish]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_finish as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Purity / Color / Metal -->
                                                        <div class="col-md-2">
                                                            <span>Purity / Color / Metal</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[purity]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_purity as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
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
                                                            <select name="project_specification[ring_size]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_ring_size as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <!-- Plating -->
                                                        <div class="col-md-2">
                                                            <span>Plating</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[plating]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_plating as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input name="project_specification[custom]" type="text" placeholder="Custom Specification" class="form-control"> 
                                                        </div>
                                                    </div>


                                                    <hr>


                                                    <div class="form-group">
                                                        <!-- Wax only -->
                                                        <div class="col-md-2">
                                                            <span>Wax Only</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[wax_only]" class="form-control" id="wax_only">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_wax_only as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Wax Only Resin -->
                                                        <!-- <div id="wax_only_resin">
                                                        <div class="col-md-2">
                                                            <span>Wax Only Resin</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[wax_only_resin]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_wax_only_resin as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
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
                                                            <select name="project_specification[casting_only]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_casting_only as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Mold -->
                                                        <div class="col-md-2">
                                                            <span>Mold</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[mold]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_mold as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
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
                                                            <select name="project_specification[supply_diamonds]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_supply_diamonds as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Supply Center -->
                                                        <div class="col-md-2">
                                                            <span>Supply Center</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[supply_center]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_supply_center as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
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
                                                            <select name="project_specification[supply_all_gems]" class="form-control" id="supply_all_gems">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_supply_all_gems as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <!-- Supply Center -->
                                                        <div id="supply_all_gems_yes">
                                                        <div class="col-md-2">
                                                            <span>Supply All Gems If Yes</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="project_specification[supply_all_gems_yes]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_supply_all_gems_yes as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
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
                                                            <select name="project_specification[sending_my_own]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_sending_my_own as $key => $value) : ?>
                                                                <option value="<?= $value ?>"><?= $value ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                    
                                                    <!-- <div class="form-actions right todo-form-actions">
                                                        <button type="submit" class="btn btn-circle btn-sm green">Save Specification</button>
                                                        <button class="btn btn-circle btn-sm btn-default">Cancel</button>
                                                    </div> -->
                                                    
                                                </div>
                                            </div>
                                        
                                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                                <ul>
                                                    <li>Example: Ring Size 5.25</li>
                                                    <li>Example: Metal Purity 18k</li>
                                                    <li>Example: Center Stone 1.5ct H VS1</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- end specification -->

                                       

                                        <!-- message -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <button class="btn" type="button" data-toggle="collapse" data-target="#messaging" aria-expanded="false" aria-controls="multiCollapseExample2">Project Files</button>
                                            </div>
                                        
                                            <div class="collapse multi-collapse" id="messaging">
                                                <div class="form msg-frm" style="padding: 20px !important">
                                                    <div class="form-group">
                                                        <div class="col-md-12" id="krajee_file">
                                                            <label for="file-1">Cad</label>
                                                            <input id="file-1" type="file" multiple class="file" name="file[]">
                                                        </div>
                                                        <!-- <div class="col-md-12">
                                                            <label for="">Cad</label>
                                                            <input type="file" name="cad[]" class="form-control" multiple="">
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group">
                                                        <!-- <div class="col-md-12">
                                                            <label for="">Pic</label>
                                                            <input type="file" name="pic[]" class="form-control" multiple="">
                                                        </div> -->
                                                        <div class="col-md-12" id="krajee_file">
                                                            <label for="file-2">Pic</label>
                                                            <input id="file-2" type="file" multiple class="file" name="file[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end message -->

                                        <div class="form msg-frm" style="padding: 20px !important">
                                            <div class="form-actions right todo-form-actions">
                                                <button type="submit" class="btn btn-circle btn-sm green">Submit</button>
                                                <button type="reset" class="btn btn-circle btn-sm btn-default">Reset</button>
                                            </div>
                                        </div>
                                        <!-- end project gem spec -->
                                    </form>

                                    
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

    <!-- modal -->
    <div class="modal fade signup_pop" id="revision_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body text-center">
                    <h4>Revision History</h4>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="email">Currently:</label>
                            <input style="text-align: center" type="text" class="form-control" id="project_title" value="<?= $project_title->value ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Historically:</label>
                            <input class="form-control" type="text" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- add client modal -->
    <div class="modal fade signup_pop" id="add_client_modal" tabindex="-1" role="dialog" aria-labelledby="add_client_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <h4>Add Member</h4>
                    <form id="insert_user_modal" method="post" action="<?php echo site_url('Master_controllers/insert_user_modal');?>" >
                    
                        <?php $rand_pass = substr(base64_encode(mt_rand()), 0, 10); //Rand password Code Gen ?>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label>
                            <input class="form-control" type="text" placeholder="Name" id="name" name="user_name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input class="form-control" type="email" placeholder="Email Id" id="email"  name="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Phone</label>
                            <input class="form-control" type="phone" placeholder="Phone No." id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Designation</label>
                            <select class="form-control" name="sample_1_length" aria-controls="sample_1" class="form-control input-sm input-xsmall input-inline">
                                <option>Select Designation</option>
                                <!-- <option value="1">Admin</option> -->
                                <!-- <option value="2">Designing</option> -->
                                <!-- <option value="3">Casting</option> -->
                                <!-- <option value="4">Packing</option> -->
                                <option value="5">Client</option>
                                <!-- <option value="6">Manager</option> -->
                            </select>
                        </div>
                        <div class="inv_ppl">
                            <input type="hidden" placeholder="Password" name="password" value="<?php echo $rand_pass;?>">
                        </div>
                        <div class="tabgroup">
                            <div class="pop_btn">
                                <input type="submit" class="btn blue" value="Submit"  onclick='Javascript:validedData();'>
                                <input class="btn default" type="Reset" value="Cancel">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end add client modal -->

    <!-- add Member modal -->
    <div class="modal fade signup_pop" id="add_member_modal" tabindex="-1" role="dialog" aria-labelledby="add_member_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <h4>Add Member</h4>
                    <form id="insert_member_user_modal" method="post" action="<?php echo site_url('Master_controllers/insert_member_user_modal');?>" >
                    
                        <?php $rand_pass = substr(base64_encode(mt_rand()), 0, 10); //Rand password Code Gen ?>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label>
                            <input class="form-control" type="text" placeholder="Name" id="name" name="user_name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input class="form-control" type="email" placeholder="Email Id" id="email"  name="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Phone</label>
                            <input class="form-control" type="phone" placeholder="Phone No." id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Designation</label>
                            <select class="form-control" name="sample_1_length" aria-controls="sample_1" class="form-control input-sm input-xsmall input-inline">
                                <option>Select Designation</option>
                                <!-- <option value="1">Admin</option> -->
                                <option value="2">Designing</option>
                                <option value="3">Casting</option>
                                <option value="4">Packing</option>
                                <!-- <option value="5">Client</option> -->
                                <option value="6">Manager</option>
                            </select>
                        </div>
                        <div class="inv_ppl">
                            <input type="hidden" placeholder="Password" name="password" value="<?php echo $rand_pass;?>">
                        </div>
                        <div class="tabgroup">
                            <div class="pop_btn">
                                <input type="submit" class="btn blue" value="Submit"  onclick='Javascript:validedData();'>
                                <input class="btn default" type="Reset" value="Cancel">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end add Member modal -->


     <!-- add Member modal -->
    <div class="modal fade signup_pop" id="set_permission_modal" tabindex="-1" role="dialog" aria-labelledby="set_permission_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption font-dark"> 
                                <span class="caption-subject bold uppercase">Set Permissions</span> 
                            </div>
                        </div>
                        <form id="add_permission" >
                        <div class="portlet-body" style="height: 200px; overflow-y: scroll;">
                            <?php foreach ($permissions as $key) : ?>
                            <div class="col-md-12">
                                <!-- <div class="form-group">
                                    <input type="checkbox" class="form-control">
                                    <select class="form-control" name="permission[permission_id]" id="" required>
                                        <option value="">Choose Permission Key</option>
                                        <option value="<?= $key->permission_id?>"><?= $key->name ?></option>
                                    </select>
                                </div> -->
                                <div class="col-sm-6" id="one">
                                    <div class="checkbox">
                                        <label><input class="permission_id" type="checkbox" name="permission[permission_id][]" value="<?= $key->permission_id?>"><?= $key->name ?></label>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control form-control-sm" name="permission[level][<?= $key->permission_id?>]" id="">
                                            <option value="">Set Permission</option>
                                            <option value="1">Allow</option>
                                            <option value="0">Disallow</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <input type="hidden" name="permission[user_id]" id="permission_user_id">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>

                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption font-dark"> 
                                <span class="caption-subject bold uppercase">Permissions</span> 
                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="list-group permission_list">
                                <!-- <li class="list-group-item list-group-item-primary">This is a primary list group item</li> -->
                                <!-- <?php foreach ($user_permissions as $key) : ?>
                                <li class="list-group-item <?= $key->level == '1' ? 'list-group-item-success' : 'list-group-item-danger' ?>"><?= $key->name ?> <span class="badge <?= $key->level == '1' ? 'badge-success' : 'badge-danger' ?> badge-pill"><?= $key->level == '1' ? 'Allowed' : 'Disallowed' ?></span></li>
                                <?php endforeach; ?> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end add Member modal -->

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
        <!-- <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script> -->
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

        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
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

        <!-- specification form submit -->
        <!-- <script>
            $(function(){
                $(document).on('submit','#specification_form',function(e){
                    e.preventDefault();
                    $("input")
                });
            });
        </script> -->

        <!-- wax only hide and show -->
        <script>
            $('#wax_only_resin').hide();
            $(document).on('change', '#wax_only', function(){
                var wax_only = $(this).val();
                if(wax_only == 'Resin'){
                    $('#wax_only_resin').show();
                } else{
                    $('#wax_only_resin').hide();
                }

            });
            $('#supply_all_gems_yes').hide();
            $(document).on('change', '#supply_all_gems', function(){
                var supply_all_gems = $(this).val();
                if(supply_all_gems == 'Yes'){
                    $('#supply_all_gems_yes').show();
                } else{
                    $('#supply_all_gems_yes').hide();
                }

            });
        </script>
        <script>
            $(document).on('submit', '#insert_user_modal', function(e){
                e.preventDefault();
                var form = $("#insert_user_modal").serialize();
                $.ajax({
                    url: "<?php echo site_url('Master_controllers/insert_user_modal');?>",
                    data: form,
                    type: "post",
                    success:function(data){
                        $("#all_clients").html(data);
                        $('#add_client_modal').modal('hide');

                    }
                });
            });

            $(document).on('submit', '#insert_member_user_modal', function(e){
                e.preventDefault();
                var form = $("#insert_member_user_modal").serialize();
                $.ajax({
                    url: "<?php echo site_url('Master_controllers/insert_member_user_modal');?>",
                    data: form,
                    type: "post",
                    success:function(data){
                        $("#all_assignee").html(data);
                        $('#add_member_modal').modal('hide');

                    }
                });
            });

            $(document).on('click', '#add_another_assignee', function(){
                $.ajax({
                    url: "<?= site_url( 'Master_controllers/add_set_assignee_field' )?>",
                    success:function(data){
                        $('.add_assignee_field').before(data);
                    }
                });
            });

            $(document).on('change', '.all_assignee', function(){
                // $('.set_permission_btn').show();
                $(this).parent().next().children().val($(this).val());
                // alert($(this).val());
                // $(this).parent().next().children('.permissions_id').prop('required',true);
                // $(this).parent().next().next().children('.permissions_level').prop('required',true);
            });

            $(document).on('click', '.set_permission_btn', function(){
                var user_id = $(this).val() == '' ? 0 : $(this).val();
                
                $('#permission_user_id').val(user_id);
                $.ajax({
                    url: "<?= site_url('Master_controllers/member_permissions/') ?>"+user_id,
                    success:function(data){
                        $('.permission_list').html(data);
                        // $('.permission_list').html(data);
                        // $("#msg_tbody").html(data);
                        // $("input[name='msg']").val('');
                        // $("[name='msg_to']").val('');
                    }
                });
            });


            
        </script>

        <script>
            $(function(){
                $(document).on('submit','#add_permission',function(e){
                    e.preventDefault();
                    var form = $(this).serialize();

                    $.ajax({
                        url: "<?= site_url('Master_controllers/add_multiple_permission') ?>",
                        data: form,
                        type: 'post',
                        success:function(data){
                            // alert('Permission is set');
                            $('.permission_list').html(data);
                            // $('.permission_list').html(data);
                            // $("#msg_tbody").html(data);
                            // $("input[name='msg']").val('');
                            // $("[name='msg_to']").val('');
                        }
                    });
                });

                $('.permission_id').change(function() {
                    var attr = $(this).parent().parent().parent().next().children().children().is('[required]');
                    if (!attr) {
                        $(this).parent().parent().parent().next().children().children().prop('required', true);      
                    }
                    else{
                        $(this).parent().parent().parent().next().children().children().prop('required', false);      
                    }
                });

                $(document).on('click', '.delete_permission', function(e){
                    e.preventDefault();
                    var url = $(this).attr("href");
                    $.ajax({
                        url: url,
                        success:function(data){
                            $('.permission_list').html(data);
                        }
                    });

                });
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/piexif.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/sortable.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/file_input/fileinput.js')?>" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/fas/theme.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/explorer-fas/theme.min.js" type="text/javascript"></script>
        <script>
            jQuery.noConflict();

            (function($){
                $("#file-1").fileinput({
                    theme: 'explorer-fas',
                    uploadUrl:  "<?php echo base_url('Project_controller/krajee_cad_upload/'.$dynamic_id)?>",
                    uploadAsync: true,
                    overwriteInitial: false,
                    fileActionSettings: {
                        showDrag: false,
                    },
                    minFileCount: 1,
                    maxFileCount: 5,
                    // showPreview :false,
                    initialPreviewShowDelete: false,
                    initialPreviewAsData: true, // identify if you are sending preview data only and not the markup
                    previewFileIcon: '<i class="fas fa-file"></i>',
                    allowedPreviewTypes: null,
                });
                $("#file-2").fileinput({
                    theme: 'explorer-fas',
                    uploadUrl:  "<?php echo base_url('Project_controller/krajee_pic_upload/'.$dynamic_id)?>",
                    uploadAsync: true,
                    overwriteInitial: false,
                    fileActionSettings: {
                        showDrag: false,
                    },
                    minFileCount: 1,
                    maxFileCount: 5,
                    initialPreviewShowDelete: false,
                    initialPreviewAsData: true, // identify if you are sending preview data only and not the markup
                });

                $('#file-1').on('filebatchselected', function(event, numFiles, label) {
                    setTimeout(function(){
                    swal('Please click the upload button to upload');
                    }, 1000);
                });

                $('#file-2').on('filebatchselected', function(event, numFiles, label) {
                    setTimeout(function(){
                    swal('Please click the upload button to upload');
                    }, 1000);
                });

                $('#file-1').on('filebatchuploadcomplete', function(event, files, extra) {
                    $('input[name=is_file_uploaded]').val(1);
                });
                $('#file-2').on('filebatchuploadcomplete', function(event, files, extra) {
                    $('input[name=is_file_uploaded]').val(1);
                });
            })(jQuery);
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
        <script>
            jQuery.noConflict;

            (function($){
                $('#all_clients').select2();
            })(jQuery);
        </script>

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
                $critical_begin = new DateTime(date('m/d/Y',strtotime(date('m/d/Y'))));
                $critical_end   = new DateTime(date('m/d/Y',strtotime(date('m/d/Y'). ' +3 day')));

                for($i = $critical_begin; $i <= $critical_end; $i->modify('+1 day')): ?>
                criticalDates[ new Date( '<?php echo $i->format("m/d/Y") ?>' )] = new Date( '<?php echo $i->format("m/d/Y") ?>' );
                <?php endfor; ?>

                <?php 
                $rush_begin = new DateTime(date('m/d/Y',strtotime(date('m/d/Y'). ' +4 day')));
                $rush_end   = new DateTime(date('m/d/Y',strtotime(date('m/d/Y'). ' +7 day')));

                for($i = $rush_begin; $i <= $rush_end; $i->modify('+1 day')): ?>
                rushDates[ new Date( '<?php echo $i->format("m/d/Y") ?>' )] = new Date( '<?php echo $i->format("m/d/Y") ?>' );
                <?php endfor; ?>

                <?php 
                $standard_begin = new DateTime(date('m/d/Y',strtotime(date('m/d/Y'). ' +8 day')));
                $standard_end   = new DateTime(date('m/d/Y',strtotime(date('m/d/Y'). ' +12 day')));

                for($i = $standard_begin; $i < $standard_end; $i->modify('+1 day')): ?>
                standardDates[ new Date( '<?php echo $i->format("m/d/Y") ?>' )] = new Date( '<?php echo $i->format("m/d/Y") ?>' );
                <?php endfor; ?>

          
                
                // datepicker
                jQuery('#calendar').datepicker({
                    minDate: 0,
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

               $('#calendar').change(function(){
                    var deadline = new Date($(this).val());
                    var critical_begin = new Date('<?php echo date('m/d/Y',strtotime(date('m/d/Y'))) ?>');
                    var critical_end = new Date('<?php echo date('m/d/Y',strtotime(date('m/d/Y'). ' +3 day')) ?>');
                    if(deadline >= critical_begin && deadline <= critical_end){
                        swal('Rush fee may apply on some projects');
                    }
                    var rush_begin = new Date('<?php echo date('m/d/Y',strtotime(date('m/d/Y'). ' +4 day')) ?>');
                    var rush_end = new Date('<?php echo date('m/d/Y',strtotime(date('m/d/Y'). ' +7 day')) ?>');
                    if(deadline >= rush_begin && deadline <= rush_end){
                        swal('Rush fee may apply on some projects');
                    }
               });
            })(jQuery);
        </script>

        <script>
            $(document).on('submit', '#add_project_frm', function(){
                var is_file_uploaded= $('input[name=is_file_uploaded]').val();
                var result = true;
                if(is_file_uploaded == 1){
                    return result;
                }
                else{
                    // swal({
                    //   title: "Are you sure?",
                    //   text: "Are you sure want to add project without any files?",
                    //   buttons: true,
                    //   dangerMode: true,
                    // })
                    // .then((willDelete) => {
                    //   if (willDelete) {
                    //     $('input[name=is_file_uploaded]').val(1);
                    //     result = false;
                    //   } else {
                    //     result = true;
                    //   }
                    // });
                    var r = confirm("Are you sure want to add project without any files?");
                    if (r == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
            });
        </script>
</body>

</html>