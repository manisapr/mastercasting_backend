<!-- BEGIN HEADER -->
<?php include 'inc/header.php'; ?>
<style>
.list-group-item{
border: 1px solid rgba(0,0,0,.125) !important;
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
                    <li> <a href="index.html">Home</a> <i class="fa fa-circle"></i> </li>
                    <li> <a href="#">Trade Clients</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Add Trade Client</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title">Add Associate
            </h1>
            <!-- END PAGE TITLE -->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-briefcase font-dark"></i>
                                <span class="caption-subject bold uppercase">New Trade Client Form</span>
                            </div>
                            
                            
                        </div>
                        <div class="portlet-body">
                            <form id="" action="<?= site_url('User_controller/create_trade_action')?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                <!-- == -->
                                <div class="form msg-frm">
                                    <!-- END TASK HEAD -->
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label>Company List *</label>
                                            <select class="form-control" name="user[company_id]" id="company_id" required="">
                                                <option value="<?php echo $company_id ?>" selected><?php echo $company_name ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="exampleFormControlInput1">First Name *</label>
                                            <input type="text" class="form-control" placeholder="" name="user[first_name]" required="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="exampleFormControlInput1">Last Name *</label>
                                            <input type="text" class="form-control" placeholder=""  name="user[last_name]" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="exampleFormControlInput1">Username *</label>
                                            <input type="text" class="form-control" placeholder="" name="user[username]" required="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="exampleFormControlInput1">Email *</label>
                                            <input type="text" class="form-control" placeholder="" name="user[email]" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="exampleFormControlInput1">Mobile Number *</label>
                                            <input type="text"  maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control" placeholder="" name="user[phone]" required="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="exampleFormControlInput1">Office Number</label>
                                            <input type="text" class="form-control" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="" name="user[office_contact]">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="exampleFormControlInput1">Fax Number</label>
                                            <input type="text" class="form-control" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="" name="user[fax]">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="exampleFormControlTextarea1">Address</label>
                                            <textarea class="form-control"  rows="3" name="user[address1]"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="inputCity">City</label>
                                            <input type="text" class="form-control" id="inputCity" name="user[city]">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputCity">State</label>
                                            <input type="text" class="form-control" id="inputCity" name="user[state]">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputCity">Zip</label>
                                            <input type="text" class="form-control" id="inputCity" name="user[zip]">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="inputCity">country</label>
                                            <!-- <select class="form-control" id="exampleFormControlSelect1" name="user[country]" required=""> -->
                                                <input type="text" class="form-control" id="inputCity" name="user[country]">
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- end message -->
                                    <div class="form msg-frm" style="padding: 20px !important">
                                        <div class="form-actions right todo-form-actions">
                                            <button type="submit" class="btn btn-circle btn-sm green">Create trade client</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script>
    $('#company_id').select2();
</script>

</body>
</html>