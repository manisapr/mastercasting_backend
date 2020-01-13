<!-- BEGIN HEADER -->
<?php include 'inc/header.php'; ?>
<style>
.list-group-item{
border: 1px solid rgba(0,0,0,.125) !important;
}
</style>
<link rel="stylesheet" type="text/css" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css">

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
                    <li> <a href="#">Retailer Clients</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Retailer Client Details</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title">Retailer Client
            </h1>
            <!-- END PAGE TITLE -->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-briefcase font-dark"></i>
                                <span class="caption-subject bold uppercase">Client C<?php echo $user->dynamic_id  ?> Profile Details</span>
                            </div>
                             <?php if(in_array($designation_id, [1,6,8])): ?>
                            <div class="actions">
                                <div class="btn-group btn-group-devided">
                                    <a href="<?php echo base_url('projects/add_project/'.$user->id) ?>" class="btn btn-circle green">Add Job <i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="portlet-body">
                            <form id="" action="<?= site_url('User_controller/edit_retailer_client_action/'.$user->id)?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form msg-frm">
                                    <!-- END TASK HEAD -->
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="representative">Representative *</label>
                                            <select name="user[representative]" class="form-control">
                                                <option value="" selected disabled="">Select Representative</option>
                                                <?php foreach ($representative as $key): ?>
                                                <option value="<?php echo $key->id ?>" <?php echo $key->id == $user->representative ? 'selected' : '' ?>><?php echo $key->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="first_name">First Name *</label>
                                            <input id="first_name" type="text" class="form-control" placeholder="" name="user[first_name]" value="<?php echo $user->first_name ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last_name">Last Name *</label>
                                            <input type="text" id="last_name" class="form-control" placeholder=""  name="user[last_name]" value="<?php echo $user->last_name ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="email">Email *</label>
                                            <input type="text" id="email" class="form-control" placeholder="" name="user[email]" required="" value="<?php echo $user->email ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="exampleFormControlInput1">Mobile Number *</label>
                                            <input type="text"  maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control" placeholder="" name="user[phone]" required="" value="<?php echo $user->phone ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="office_contact">Office Number</label>
                                            <input type="text"  maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="office_contact" class="form-control" placeholder="" name="user[office_contact]" value="<?php echo $user->office_contact ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="home_contact">Home Number</label>
                                            <input type="text"  maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="home_contact" class="form-control" placeholder="" name="user[home_contact]" value="<?php echo $user->home_contact ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="fax">Fax</label>
                                            <input type="text" id="fax" class="form-control" placeholder="" name="user[fax]" value="<?php echo $user->fax ?>">
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="address1">Address</label>
                                            <textarea class="form-control" id="address1"  rows="3" name="user[address1]"><?php echo $user->address1 ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="inputCity">City</label>
                                            <input type="text" class="form-control" id="inputCity" name="user[city]" value="<?php echo $user->city ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="state">State</label>
                                            <input type="text" id="state" class="form-control" id="inputCity" name="user[state]" value="<?php echo $user->state ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="zip">Zip</label>
                                            <input type="text" id="zip" class="form-control" id="inputCity" name="user[zip]" value="<?php echo $user->zip ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="country">country</label>
                                            <select class="form-control" id="exampleFormControlSelect1" name="user[country]">
                                                <input type="text" id="country" class="form-control" id="inputCity" name="user[country]" value="<?php echo $user->country ?>">
                                            </select>
                                        </div>
                                    </div> -->
                                   <!--  <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Client Reffered By</label>
                                            <input class="form-control" rows="3" name="user[client_reffered_by]" value="">
                                        </div>
                                    </div>
 -->
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

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Client Created At</label>
                                            <input class="form-control" value="<?php echo date('D M d, Y h:i:s a', strtotime($user->created_at)) ?>" disabled="">
                                        </div>
                                    </div>
                                    
                                    <!-- end message -->
                                    <div class="form msg-frm" style="padding: 20px !important">
                                        <div class="form-actions right todo-form-actions">
                                            <button type="submit" class="btn btn-circle btn-sm green">Submit</button>
                                        </div>
                                    </div>
                                    <!-- end project gem spec -->
                                </div>
                            </form>
                             <!-- job -->
                            <div class="panel panel-default" id="message_panel">
                                <div class="panel-heading">
                                    <button id="messaging_id" class="btn" type="button" data-toggle="collapse" data-target="#messaging" aria-expanded="false" aria-controls="multiCollapseExample2">Jobs</button>
                                </div>
                                <div class="collapse multi-collapse" id="create_msg">
                                    
                                </div>
                                
                                <div class="collapse multi-collapse" id="messaging">
                                    <div style="padding: 20px">
                                       <!--  <a class="btn btn-sm">Show live & proposal</a>
                                        <a class="btn btn-sm">Complete</a>
                                        <a class="btn btn-sm">Cancelled</a> -->

                                        <hr style="border-top: 1px solid #bdbdbd;">

                                        <table class="table table-condensed" style="margin-top: 20px">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Jobs Name</th>
                                                    <th>Po</th>
                                                    <th>Deadline</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jobs as $key): ?>
                                                <tr>
                                                    <!-- <td>
                                                        <a class="label label-sm label-success" href="<?php //echo base_url('projects/project_details/'.$key->project_id);?>">J<?php echo $key->project_id ?></a>
                                                    </td>
                                                    <td><?php //echo $key->project_name ?></td>
                                                    <td><?php //echo $key->po ?></td>
                                                    <td><?php //echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'm/d/Y H:i:s'); ?></td> -->
                                                    <td>
                                                        <a class="badge badge-success" href="">J<?php echo $key->project_id ?></a>
                                                    </td>
                                                    <td><?php echo $key->project_name ?></td>
                                                    <td><?php echo $key->po ?></td>
                                                    <td><?= $key->deadline == '0000-00-00' ? 'No deadline' : $key->deadline  ?></td>
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
                                                    <td><span class="badge badge-<?php echo $state ?>"><?php echo ucwords($key->type) ?></span></td>
                                                    <td><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'm/d/Y H:i:s');  ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end job -->
                            
                            <!-- email section -->
                            <div class="panel panel-default" id="message_panel">
                                <div class="panel-heading">
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#client_comm" aria-expanded="false" aria-controls="multiCollapseExample2">Client Communication</button>
                                </div>
                                <div class="collapse multi-collapse" id="create_msg">
                                    
                                </div>
                                <div class="collapse multi-collapse" id="client_comm">
                                    <form id="send_user_email" action="<?php echo base_url('User_controller/send_email_to_user/'.$user->id)?>" class="form-horizontal" method="POST">
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
                                        <?php foreach ($user_proof as $key): ?>
                                        <a href="<?php echo base_url('uploads/user_proof/'.$key->file_name ) ?>" download>Download</a><br>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<script>
    $(document).on('submit', '#send_user_email', function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            url: "<?php echo base_url('User_controller/send_email_to_user/'.$user->id) ?>",
            data: form,
            type: "post",
            success:function(data){
                swal("Mail sent.")
                .then((value) => {
                  location.reload();
                });
            }
        });
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('#company_name').hide();
        $('#company_name_div').hide();
    });

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