        <!-- BEGIN HEADER -->
        <?php include 'inc/header.php'; ?>
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
                            <li> <a href="index.html">Home</a> <i class="fa fa-circle"></i> </li>
                            <li> <a href="#">projects</a> <i class="fa fa-circle"></i> </li>
                            <li> <span>Update projects</span> </li>
                        </ul>
                        <div class="page-toolbar">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Actions
                                <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a href="#"> <i class="icon-bell"></i> Action</a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="icon-shield"></i> Another action</a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="icon-user"></i> Something else here</a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="#"> <i class="icon-bag"></i> Separated link</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h1 class="page-title">Update Project </h1>
                    <!-- End PAGE TITLE-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-dark"> 
                                        <i class="icon-briefcase font-dark"></i> 
                                        <span class="caption-subject bold uppercase"><?= $project_details->title ?></span> 
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
                                    <form id="" action="<?= site_url('projects/add_project_action')?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                        <!-- == -->
                                        <div class="form msg-frm">
                                            <!-- END TASK HEAD -->
                                            <!-- Created at -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control todo-taskbody-tasktitle" value="<?= date('D, F d, Y') ?>" disabled> 
                                                </div>
                                            </div>
                                            <!-- Type -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project[type]" class="form-control">
                                                        <option value="proposal" <?= $project_details->type == 'proposal' ? 'selected' : '' ?>>Proposal</option>
                                                        <option value="live" <?= $project_details->type == 'live' ? 'selected' : '' ?>>Live</option>
                                                        <option value="completed" <?= $project_details->type == 'completed' ? 'selected' : '' ?>>Completed</option>
                                                        <option value="cancelled" <?= $project_details->type == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Manager -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project[assignee]" class="form-control">
                                                        <option value="">Set Manager</option>
                                                        <?php foreach ($manager as $key): ?>
                                                        <option value="<?= $key->id ?>" 
                                                            <?= $project->manager_category == $key->id ? 'selected' : ''?>>
                                                            <?= $key->name ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Client -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project[assignee]" class="form-control">
                                                        <option value="">Set Client</option>
                                                        <?php foreach ($client as $key): ?>
                                                        <option value="<?= $key->id ?>"
                                                        <?= $project->asign_user == $key->id ? 'selected' : ''?>>
                                                            <?= $key->name ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Asignee -->
                                            <?php foreach (explode(',', $project_details->assignee) as $key_one) : ?>
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <select name="project[assignee]" class="form-control">
                                                        <option value="">Set Assignee</option>
                                                        <?php foreach ($assignee as $key): ?>
                                                        <option value="<?= $key->id ?>" 
                                                            <?= $key_one == $key->id ? 'selected' : ''?>><?= $key->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                               <!--  <div class="col-md-4">
                                                    <select class="form-control" name="" id="">
                                                        <option value="">Select Profile</option>
                                                        <option value="">Select Profile</option>
                                                        <option value="">Select Profile</option>
                                                    </select>
                                                </div> -->
                                            </div>
                                            <?php endforeach; ?>
                                            <!-- disposition -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project[disposition]" class="form-control">
                                                        <option value="0">No Disposition Assigned</option>
                                                        <?php foreach ($disposition as $key) : ?>
                                                        <option value="<?= $key->disposition_id ?>" <?= $project_details->disposition == $key->disposition_id ? 'selected' : ''?>><?= $key->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Priority -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project[priority]" class="form-control">
                                                        <option value="standard" 
                                                        <?= $project_details->priority == 'standard' ? 'selected' : '' ?>>Standard Priority</option>
                                                        <option value="high" 
                                                        <?= $project_details->priority == 'high' ? 'selected' : '' ?>>High Priority</option>
                                                        <option value="critical" 
                                                        <?= $project_details->priority == 'critical' ? 'selected' : '' ?>>Critical</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Deadline -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select name="project[deadline]" class="form-control">
                                                        <option value="">No Deadline</option>
                                                        <?php for ($i = 1 ; $i > -90; $i--) { ?>
                                                            <option value="<?= $deadline = date('Y-m-d', strtotime("-$i days")); ?>"
                                                             <?= $project_details->deadline == $deadline ? 'selected' : '' ?>>
                                                                <?= date('D, F d, Y', strtotime("-$i days")); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Price -->
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input value="<?= $project_details->price ?>" name="project[price]" type="number" class="form-control" placeholder="Price...">
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="project[price_type]" class="form-control">
                                                        <option value="plus_tax" <?= $project_details->price_type == 'plus_tax' ? 'selected' : ''?>>Plus Tax</option>
                                                        <option value="include_tax" <?= $project_details->price_type == 'include_tax' ? 'selected' : ''?>>Include Tax</option>
                                                        <option value="tax_exempt" <?= $project_details->price_type == 'tax_exempt' ? 'selected' : ''?>>Tax Exempt</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- PO# -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input value="<?= $project_details->po ?>" name="project[po]" type="text" class="form-control" placeholder="PO#">
                                                </div>
                                            </div>
                                            <!-- Tracking# -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input value="<?= $project_details->tracking ?>" name="project[tracking]" type="text" class="form-control" placeholder="Tracking#">
                                                </div>
                                            </div>
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
                                                    <input id="job_title" name="project[title]" type="text" value="<?= $project_details->title ?>" class="form-control" placeholder="Job title" maxlength="30">
                                                </div>
                                                <div class="col-md-12 text-right">
                                                    <span><span id="job_title_cn"></span>/30</span>
                                                    <a id="sample_editable_1_new" data-toggle="modal" data-target="#revision_history"><i class="fas fa-info-circle"></i></a>
                                                </div>
                                            </div>

                                            <!-- Job desc -->
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <textarea name="project[description]" class="form-control" rows="8" placeholder="Job Description..."><?= $project_details->description ?></textarea>
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
                                                            <select name="project_specification[purity]" class="form-control">
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
                                                            <select name="project_specification[ring_size]" class="form-control">
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
                                                            <select name="project_specification[plating]" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($specification_plating as $key => $value) : ?>
                                                                <option value="<?= $value ?>" <?= $project_specification->plating == $value ? 'selected' : ''?>><?= $value ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input value="<?= $project_specification->custom ?>" name="project_specification[custom]" type="text" placeholder="Custom Specification" class="form-control"> 
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

                                        <!-- message -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <button class="btn" type="button" data-toggle="collapse" data-target="#messaging" aria-expanded="false" aria-controls="multiCollapseExample2">Messaging</button>
                                                <button style="float: right;" class="btn" type="button" data-toggle="collapse" data-target="#create_msg" aria-expanded="false" aria-controls="create_msg">Create Message</button>
                                            </div>
                                            
                                            <div class="collapse multi-collapse" id="messaging">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td>Msg By</td>
                                                            <td>Msg To</td>
                                                            <td>Msg</td>
                                                            <td>Messaged At</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($project_msg as $key) : ?>
                                                        <tr>
                                                            <td><?= $key->msg_by == '' ? '' : $this->db->get_where('user',['id' => $key->msg_by])->row()->name  ?></td>
                                                            <td><?= $key->msg_to == 0 ? '' : $this->db->get_where('user',['id' => $key->msg_to])->row()->name  ?></td>
                                                            <td><?= $key->msg ?></td>
                                                            <td><?= $key->created_at ?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- end message -->
                                        
                                        <div class="form msg-frm" style="padding: 20px !important">
                                            <div class="form-actions right todo-form-actions">
                                                <button type="submit" class="btn btn-circle btn-sm green">Submit</button>
                                                <button type="reset" class="btn btn-circle btn-sm btn-default">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- end specification -->
                                        
                                    </form>

                                    <!-- <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <button class="btn" type="button" data-toggle="collapse" data-target="#gems" aria-expanded="false" aria-controls="multiCollapseExample2">Gems</button>
                                            <button style="float: right;" class="btn" type="button" data-toggle="collapse" data-target="#add_gems" aria-expanded="false" aria-controls="add_gems">Add Gems</button>
                                        </div>
                                        
                                        <div class="collapse multi-collapse" id="add_gems">
                                            <form id="fileupload" action="http://localhost/mastercasting/assets/assets/global/plugins/jquery-file-upload/server/php/" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                                ==
                                                <div class="form msg-frm" style="padding: 20px !important">
                                                    <div class="form-group">
                                                        Stone
                                                        <div class="col-md-2">
                                                            <span>Stone</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-control" name="isDiamond">
                                                                <option value="1">Diamond</option>
                                                                <option value="0">Other (See Notes)</option>
                                                            </select>
                                                        </div>
                                                        Shape
                                                        <div class="col-md-2">
                                                            <span>Shape</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="shape" class="form-control">
                                                                <option value="">Choose Value</option>
                                                                <?php foreach ($gems_shape as $key => $value) { ?>
                                                                    <option value="<?= $value ?>"><?= $value ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        Ring Size
                                                        <div class="col-md-2">
                                                             <span>Quantity</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="checkbox"> Matched
                                                        </div>
                                                        Plating
                                                        <div class="col-md-2">
                                                            <span>Cert</span>
                                                        </div>
                                    
                                                        <div class="col-md-4">
                                                            <select class="form-control">
                                                                <option value="">No Cert</option>
                                                                <option value="GIA">GIA Cert</option>
                                                                <option value="ANY">Any Cert</option>
                                                                <option value="OTHER">See Notes</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        Ring Size
                                                        <div class="col-md-2">
                                                            <span>Carats</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control">
                                                        </div>
                                    
                                                        Plating
                                                        <div class="col-md-2">
                                                            <span>Cut</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="0">NA</option>
                                                                <option value="5">EX</option>
                                                                <option value="4">VG</option>
                                                                <option value="3">G</option>
                                                                <option value="2">F</option>
                                                                <option value="1">P</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="0">NA</option>
                                                                <option value="5">EX</option>
                                                                <option value="4">VG</option>
                                                                <option value="3">G</option>
                                                                <option value="2">F</option>
                                                                <option value="1">P</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        
                                                        Plating
                                                        <div class="col-md-2">
                                                            <span>Polish</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="">Choose Value</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="">Choose Value</option>
                                                            </select>
                                                        </div>
                                                        Plating
                                                        <div class="col-md-2">
                                                            <span>Symmetry</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="">Choose Value</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="">Choose Value</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="form-group">
                                                        
                                                        Clarity
                                                        <div class="col-md-2">
                                                            <span>Clarity</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="">Choose Value</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="">Choose Value</option>
                                                            </select>
                                                        </div>
                                                        Color
                                                        <div class="col-md-2">
                                                            <span>Color</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="">Choose Value</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control">
                                                                <option value="">Choose Value</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="form-group">
                                                        
                                                        Length
                                                        <div class="col-md-2">
                                                            <span>Length</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        Width
                                                        <div class="col-md-2">
                                                            <span>Width</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                    
                                                    <div class="form-group">
                                                        
                                                        Length
                                                        <div class="col-md-2">
                                                            <span>Depth</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        Width
                                                        <div class="col-md-2">
                                                            <span>Notes</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                    
                                                    <div class="form-actions right todo-form-actions">
                                                        <button type="submit" class="btn btn-circle btn-sm green">Submit</button>
                                                        <button class="btn btn-circle btn-sm btn-default">Cancel</button>
                                                    </div>
                                                    
                                                </div>
                                            </form>
                                        </div>
                                    
                                        <div class="collapse multi-collapse" id="gems">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td>ADDED</td>
                                                        <td>SHAPE / STONE</td>
                                                        <td>QUANTITY</td>
                                                        <td>CERT</td>
                                                        <td>CARATS</td>
                                                        <td>COLOR</td>
                                                        <td>CUT</td>
                                                        <td>POLISH</td>
                                                        <td>SYM</td>
                                                        <td>CLARITY</td>
                                                        <td>MM LONG</td>
                                                        <td>MM WIDE</td>
                                                        <td>MM DEEP</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div> -->
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
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->


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
    
        <?php if($this->session->flashdata('project_insert')): ?>
            <script>
                swal("Good job!", "Project inserted successfully!", "success");
            </script>
        <?php endif; ?>
        
</body>

</html>