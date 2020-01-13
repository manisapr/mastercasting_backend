<!-- BEGIN HEADER -->
<?php include 'inc/header.php'; ?>
<link rel="stylesheet" type="text/css" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css">

<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>
<style>
    .list-group-item {
        border: 1px solid rgba(0, 0, 0, .125) !important;
    }
</style>
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
                    <li> <a href="<?php echo base_url() ?>">Home</a> <i class="fa fa-circle"></i> </li>
                    <li> <a href="<?php echo base_url('trade_clients') ?>">Trade Clients</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Trade Client Details</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title">Trade Client Details
            </h1>
            <!-- END PAGE TITLE -->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-briefcase font-dark"></i>
                                <span class="caption-subject bold uppercase">Trade Client Details Form</span>
                            </div>
                            <?php if (in_array($designation_id, [1, 6, 8])) : ?>
                                <div class="actions">
                                    <div class="btn-group btn-group-devided">
                                        <a href="<?php echo base_url('projects/add_project/' . $user->id) ?>" class="btn btn-circle green">Add Job <i class="fa fa-plus"></i></a>
                                        <a href="<?php echo base_url('resend_cred/' . $user->id . '/0') ?>" class="btn btn-circle green">Resend Credential</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="portlet-body">
                            <form id="" action="<?= site_url('User_controller/edit_trade_client_action/' . $user->id) ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                <!-- == -->
                                <div class="form msg-frm">
                                    <!-- END TASK HEAD -->
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="representative">Representative *</label>
                                            <select name="user[representative]" class="form-control">
                                                <option value="" selected disabled="">Select Representative</option>
                                                <?php foreach ($representative as $key) : ?>
                                                    <option value="<?php echo $key->id ?>" <?php echo $key->id == $user->representative ? 'selected' : '' ?>><?php echo $key->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="company_name">Company *</label>
                                            <input type="text" class="form-control" id="company_name" placeholder="" name="user[company_name]" value="<?php echo $user->company_name ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="first_name">First Name *</label>
                                            <input id="first_name" type="text" class="form-control" placeholder="" name="user[first_name]" value="<?php echo $user->first_name ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last_name">last Name *</label>
                                            <input type="text" id="last_name" class="form-control" placeholder="" name="user[last_name]" value="<?php echo $user->last_name ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="email">Email *</label>
                                            <input type="text" id="email" class="form-control" placeholder="" name="user[email]" value="<?php echo $user->email ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mobile">Mobile Number *</label>
                                            <input type="text" id="mobile" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control" placeholder="" name="user[phone]" value="<?php echo $user->phone ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="office_contact">Office Number</label>
                                            <input type="text" id="office_contact" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control" placeholder="" name="user[office_contact]" value="<?php echo $user->office_contact ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="fax">Fax</label>
                                            <input type="text" id="fax" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control" placeholder="" name="user[fax]" value="<?php echo $user->fax ?>">
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="address1">Address</label>
                                            <textarea class="form-control" id="address1" rows="3" name="user[address1]"><?php echo $user->address1 ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="inputCity">City</label>
                                            <input type="text" class="form-control" id="inputCity" name="user[city]" value="<?php echo $user->city ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" id="state" name="user[state]" value="<?php echo $user->state ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="zip">Zip</label>
                                            <input type="text" class="form-control" id="zip" name="user[zip]" value="<?php echo $user->zip ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="country">country</label>
                                            <input type="text" class="form-control" id="country" name="user[country]" value="<?php echo $user->country ?>">
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="inputCountry">Country *</label>
                                            <!-- <select class="form-control" id="exampleFormControlSelect1" name="user[country]" required=""> -->
                                                <!-- <input type="text" class="form-control" id="inputCountry" name="user[country]"> -->
                                                <select  class="form-control country_select" id="inputCountry"  name="user[country]" required="">
                                                    <option></option>
                                                    <?php foreach($countries as $key): ?>
                                                    <option value="<?php echo $key->iso2 ?>" data-id="<?php echo $key->id ?>" <?php echo $user->country == $key->iso2 ? 'selected' : '' ?>><?php echo $key->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputState">State *</label>
                                            <!-- <input type="text" class="form-control" id="inputState" name="user[state]" required=""> -->
                                            <select  class="form-control state_select" id="inputState" name="user[state]" required="">
                                                <option></option>
                                                <option value="<?php echo $user->state ?>" selected>
                                                    <?php 
                                                    $state = $this->db->get_where('states', ['iso2' => $user->state, 'country_code' => $user->country])->row();
                                                    echo !empty($state) ? $state->name : $user->state ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="inputCity">City *</label>
                                            <!-- <input type="text" class="form-control" id="inputCity" name="user[city]" required=""> -->
                                            <select  class="form-control city_select" id="inputCity" name="user[city]" required="">
                                                <option></option>
                                                <option value="<?php echo $user->city ?>" selected><?php echo $user->city ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputZip">Zip *</label>
                                            <input type="text" value="<?php echo $user->zip ?>" class="form-control" id="inputZip" name="user[zip]" required="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="inputAdd">Address *</label>
                                            <textarea class="form-control" id="inputAdd" rows="3" name="user[address1]" required=""><?php echo $user->address1 ?></textarea>
                                        </div>
                                    </div>
                                    <!--     <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="exampleFormControlTextarea1">Client Reffered By</label>
                                            <input class="form-control" id="exampleFormControlTextarea1" rows="3" name="user[client_reffered_by]" value="<?php echo $user->client_reffered_by ?>">
                                        </div>
                                    </div> -->

                                    <!--  <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="exampleFormControlTextarea1">Client Created At</label>
                                            <input class="form-control" id="exampleFormControlTextarea1" value="<?php echo date('D M d, Y h:i:s a', strtotime($user->created_at)) ?>" disabled="">
                                        </div>
                                    </div> -->

                                    <!-- end message -->
                                    <div class="form msg-frm" style="padding: 20px !important">
                                        <div class="form-actions right todo-form-actions">
                                            <button type="submit" class="btn btn-circle btn-sm green">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- end project gem spec -->
                            </form>

                            <!-- job -->
                            <div class="panel panel-default" id="message_panel">
                                <div class="panel-heading">
                                    <button id="messaging_id" class="btn" type="button" data-toggle="collapse" data-target="#messaging" aria-expanded="false" aria-controls="multiCollapseExample2">Jobs</button>
                                </div>
                                <div class="collapse multi-collapse" id="messaging">
                                    <div style="padding: 20px" id="client_jobs_div">
                                        <!--  <a class="btn btn-sm">Show live & proposal</a>
                                        <a class="btn btn-sm">Complete</a>
                                        <a class="btn btn-sm">Cancelled</a> -->

                                        <form action="<?php echo base_url('Project_controller/project_shiping/' . $this->uri->segment(3)) ?>" id="project_action_form" method="POST">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <select class="form-control select_job_action" name="job_action">
                                                        <option>Select option</option>
                                                        <option value="ship">Ship</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control select_job_type" name="ship_type" style="display: none">
                                                        <option selected="" disabled="">Select option</option>
                                                        <option value="manually">Manually</option>
                                                        <option value="fedex">Fedex</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" placeholder="Enter Tracking" name="tracking" class="form-control" style="display: none">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" placeholder="Enter rate" name="rate" class="form-control" style="display: none">
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-circle ship_save_btn green" type="button">Save</button>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="" id="sort-jobs" class="form-control">
                                                        <option value="all">Sort by type</option>
                                                        <option value="Completed">Completed</option>
                                                        <option value="Cancelled">Cancelled</option>
                                                        <option value="Live">Live</option>
                                                        <option value="Proposal">Proposal</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 20px">
                                                <div class="col-md-12">
                                                    <table class="table table-condensed" style="margin-top: 20px" id="example_trade">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Id</th>
                                                                <th>Jobs Name</th>
                                                                <th>Po</th>
                                                                <th style="text-align: center">Cad Status</th>
                                                                <th>Deadline</th>
                                                                <th>Status</th>
                                                                <!-- <th>Created At</th> -->
                                                                <th>Address</th>
                                                                <th>Type</th>
                                                                <th>Method</th>
                                                                <th>Tracking Id</th>
                                                                <th style="text-align: center;">IS Shipped</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                            <?php foreach ($jobs as $key) : ?>
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
                                                                    <tr style="cursor: pointer;">
                                                                        <td>
                                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                                <input type="checkbox" class="checkboxes project_id_checkboxes" name="project_id[]" value="<?php echo $key->project_id ?>" <?php echo $key->is_shipped == 1 ? 'disabled' : '' ?> require />
                                                                                <span></span>
                                                                            </label>
                                                                        </td>
                                                                        <td onclick="window.location='<?php echo base_url('projects/project_details/' . $key->project_id); ?>'">
                                                                            <a class="badge badge-success" href="<?php echo base_url('projects/project_details/' . $key->project_id); ?>">J<?php echo $key->project_id ?></a>
                                                                        </td>
                                                                        <td onclick="window.location='<?php echo base_url('projects/project_details/' . $key->project_id); ?>'"><?php echo $key->project_name ?></td>
                                                                        <td onclick="window.location='<?php echo base_url('projects/project_details/' . $key->project_id); ?>'"><?php echo $key->po ?></td>
                                                                        <td onclick="window.location='<?php echo base_url('projects/project_details/' . $key->project_id); ?>'" style="text-align: center"><span class="badge <?php echo $cad_progress_color ?>"><?php echo $key->cad_progress ?></span></td>
                                                                        <td onclick="window.location='<?php echo base_url('projects/project_details/' . $key->project_id); ?>'"><?= $key->deadline == '0000-00-00' ? 'No deadline' : $key->deadline  ?></td>
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
                                                                            <td onclick="window.location='<?php echo base_url('projects/project_details/' . $key->project_id); ?>'"><span class="badge badge-<?php echo $state ?> type"><?php echo ucwords($key->type) ?></span></td>
                                                                            <!-- <td onclick="window.location='<?php echo base_url('projects/project_details/' . $key->project_id); ?>'"><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'm/d/Y H:i:s');  ?></td> -->
                                                                            <td><?php echo $this->projectmodel->get_full_shipping_address($key->project_id, $key->shipping_type) ?></td>
                                                                            <td><?php echo $key->shipping_type ?></td>
                                                                            <td><?php echo $key->shipping_method ?></td>
                                                                            <td><?php echo $key->tracking ?></td>


                                                                            <td style="text-align: center;">
                                                                                <?php if ($key->is_shipped == 0) : ?>
                                                                                    <span class="badge badge-danger">No</span>
                                                                                <?php else : ?>
                                                                                    <span class="badge badge-success">Yes</span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end job -->

                            <!-- shipping history -->
                            <div class="panel panel-default" id="message_panel">
                                <div class="panel-heading">
                                    <button id="ship_history_btn" class="btn" type="button" data-toggle="collapse" data-target="#ship_history" aria-expanded="false" aria-controls="multiCollapseExample2">Shipping history</button>
                                </div>
                                <div class="collapse multi-collapse" id="ship_history">
                                    <div style="padding: 20px" id="client_jobs_div">
                                        <div class="row" style="margin-top: 20px">
                                            <div class="col-md-12">
                                                <table class="table table-condensed" style="margin-top: 20px" id="example_trade">
                                                    <thead>
                                                        <tr>
                                                            <th>Tracking Id</th>
                                                            <th>Jobs</th>
                                                            <th>Service</th>
                                                            <th>Shipping Address</th>
                                                            <th>Shipping Type</th>
                                                            <th style="text-align: center;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($ship_history as $key) : ?>
                                                            <tr>
                                                                <td>
                                                                    <span class="badge badge-primary"><?php echo $key['tracking'] ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php if (is_array($key['project_id'])) : ?>
                                                                        <?php foreach ($key['project_id'] as $key2) : ?>
                                                                            <span style="cursor: pointer;" onclick="window.location='<?php echo base_url('projects/project_details/' . $key2); ?>'" class="badge badge-success"><?php echo $key2 ?></span> <br>
                                                                        <?php endforeach; ?>
                                                                    <?php else : ?>
                                                                        <span style="cursor: pointer;" onclick="window.location='<?php echo base_url('projects/project_details/' . $key['project_id']); ?>'" class="badge badge-success"><?php echo $key['project_id']; ?></span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td><?php echo $key['shipping_method'] ?></td>
                                                                <td><?php echo $key['address'] ?></td>
                                                                <td><?php echo $key['shipping_type'] ?></td>
                                                                <td style="text-align: center;">
                                                                    <a class="far fa-window-close font-red-sunglo" data-fancybox-type="iframe" data-toggle="tooltip" data-placement="bottom" title="Cancel Shipment"></a>
                                                                    <a class="fas fa-print font-blue-hoki" data-fancybox-type="iframe" href="<?php echo base_url('uploads/fedex/shipping_label/' . $key['file']) ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Reprint"></a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end job -->

                            <!-- email section -->
                            <div class="panel panel-default" id="message_panel">
                                <div class="panel-heading">
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#client_comm" aria-expanded="false" aria-controls="multiCollapseExample2">Client Communication</button>
                                </div>

                                <div class="collapse multi-collapse" id="client_comm">
                                    <form id="send_user_email" class="form-horizontal" method="POST">
                                        <div class="form msg-frm" style="padding: 30px !important">
                                            <div class="form-group">
                                                <input type="text" name="mail[subject]" placeholder="Subject" class="form-control" required="">
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" name="mail[body]" placeholder="Message" id="" cols="30" rows="10" required=""></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-circle btn-sm green">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- email section -->
                            <div class="panel panel-default" id="message_panel">
                                <div class="panel-heading">
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#user_proof" aria-expanded="false" aria-controls="multiCollapseExample2">User Proof</button>
                                </div>

                                <div class="collapse multi-collapse" id="user_proof">
                                    <div style="padding: 20px">
                                        <?php if (isset($company_proof)) : ?>
                                            <h4>Jbt Member - <?php echo $company_proof->jbt_member == 1 ? 'Yes' : 'No' ?></h4>
                                            <?php if ($company_proof->jbt_member == 1) : ?>
                                                <p>Jbt: <?php echo $company_proof->jbt ?></p>
                                            <?php else : ?>
                                                <p>Fed tax: <?php echo $company_proof->fed_tax ?></p>
                                                <p>Resale tax <?php echo $company_proof->resale_tax ?></p>
                                                <p>Resale cert: <a href="<?php echo base_url('uploads/resale_certificate/' . $company_proof->resale_cert) ?>" download>Download</a></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
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

<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script> -->
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>/assets/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/assets/pages/scripts/form-fileupload.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $('#clickmewow').click(function() {
            $('#radio1003').attr('checked', 'checked');
        });

    })
    // $(document).ready(function() {
    //     $('#example_trade').DataTable( {
    //         "scrollX": true
    //     });
    // });
</script>

<script>
    $(document).on('submit', '#send_user_email', function(e) {
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            url: "<?php echo base_url('User_controller/send_email_to_user/' . $user->id) ?>",
            data: form,
            type: "post",
            success: function(data) {
                swal("Mail sent.")
                    .then((value) => {
                        location.reload();
                    });
            }
        });
    });
</script>

<?php if ($this->session->flashdata('create_trade')) : ?>
    <script>
        swal("One trade client added");
    </script>
<?php $this->session->unset_userdata('create_trade');
endif; ?>

<?php if ($this->session->flashdata('resend_cred')) : ?>
    <script>
        swal("Credentails sent");
    </script>
<?php $this->session->unset_userdata('resend_cred');
endif; ?>

<?php if ($this->session->flashdata('edit_trade')) : ?>
    <script>
        swal("Updated successfully");
    </script>
<?php $this->session->unset_userdata('edit_trade');
endif; ?>

<script>
    // $('input[name=tracking]').hide();
    $('.ship_save_btn').hide();
    $(document).on('change', '.select_job_action', function() {
        var option = $(this).val();
        if (option == 'ship') {
            // $('input[name=tracking]').attr('required', 'required');
            // $('input[name=ship_type]').show();
            // $('input[name=rate]').show();
            $('.select_job_type').show();
            $('.ship_save_btn').show();
        } else {
            $('input[name=ship_type]').hide();
            // $('input[name=tracking]').removeAttr('required');
        }
    });

    $(document).on('change', '.select_job_type', function() {
        var option = $(this).val();
        if (option == 'fedex') {
            // $('input[name=tracking]').attr('required', 'required');
            // $('.ship_save_btn').show();
            $('input[name=tracking]').hide();
            $('input[name=rate]').hide();
        } else {
            $('input[name=rate]').show();
            $('input[name=tracking]').show();
            // $('input[name=tracking]').removeAttr('required');
        }
    });

    $(document).on('click', '.ship_save_btn', function() {
        var num_of_checks = $('input.project_id_checkboxes:checked').length;
        if (num_of_checks > 0) {
            $('#project_action_form').submit()
        }
    });
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script>
    var options = {
        valueNames: ['type']
    };

    var featureList = new List('client_jobs_div', options);

    $('#sort-jobs').change(function() {
        var types = $(this).val();
        if (types == 'all') {
            location.reload();
        }

        featureList.filter(function(item) {
            if (item.values().type == types) {
                return true;
            } else {
                return false;
            }
        });
        return false;
    });
</script>


<script>
    $(document).on('submit', '#project_action_form', function(e) {
        debugger;
        e.preventDefault();

        var form = $(this).serialize();
        var action = $('.select_job_action').val();

        if (action == 'ship') {
            $.ajax({
                url: "<?php echo base_url('Fedex/multiple_ship') ?>",
                data: form,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'error') {
                        swal({
                            icon: "error",
                            dangerMode: true,
                            title: 'Warning',
                            text: data.msg
                        });
                    } else {
                        swal({
                            icon: "success",
                            title: 'Successfull',
                            text: data.msg
                        });
                        setTimeout(function() {
                            location.reload()
                        }, 3000);
                    }
                }
            });
        }


    });
</script>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script>

    $.fn.select2.defaults.set("theme", "bootstrap");

    $('#company_id').select2();


    $("#inputState").select2({
        placeholder: "Select a state",
        allowClear: true
    });

    $("#inputCountry").select2({
        placeholder: "Select a country",
        allowClear: true
    });


    $(document).on('change', '#inputCountry', function(){
        var country = $(this).find(':selected').data('id');

        // $('.form-field').val('');

        $.ajax({
            url: '<?php echo base_url('Project_controller/get_state_by_country') ?>',
            data: {'id' : country},
            type: 'post',
            success:function(data){
                var state = $('#inputState').html(data);
            }
        });
    });

    $("#inputCity").select2({
        placeholder: "Enter city",
        allowClear: true,
        minimumInputLength: 3,
        tags: [],
        ajax: {
            url: "<?php echo base_url('Project_controller/get_cities_by_search_term') ?>",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            data: function (params) {
                var query = {
                    search: params.term,
                    state: $('#inputState').find(':selected').val(),
                    country: $('#inputCountry').eq(0).find(':selected').val()
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
            },
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data
                };
            }
        }
    });
</script>

</body>

</html>