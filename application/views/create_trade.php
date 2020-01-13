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
                    <li> <a href="#">Trade Clients</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Add Trade Client</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title">Add Trade Client
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
                            <form id="create_user_form" action="<?= site_url('User_controller/create_trade_action')?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                <!-- == -->
                                <div class="form msg-frm">
                                    <!-- END TASK HEAD -->
                                    <div class="form-group">
                                        <div class="col-md-6">
                                           <!--  <style>
                                                .page-header.navbar .search-form.search-form-expanded ul {
                                                    width: auto!important;
                                                }
                                                .easy-autocomplete-container ul {
                                                    top: 0;
                                                }
                                            </style> -->
                                            <label>Company List *</label>
                                            <select class="form-control" name="user[company_id]" id="company_id" required="">
                                                <option value="">Select Company</option>
                                                <?php foreach ($companies as $key): ?>
                                                <option value="<?php echo $key->company_id ?>"><?php echo $key->company_name ?></option>
                                                <?php endforeach; ?>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6" id="company_name_div">
                                            <label>Company Name</label>
                                            <input type="text" class="form-control" id="company_name" placeholder="" name="user[company_name]">
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
                                        <div class="col-md-6">
                                            <label for="inputCountry">Country *</label>
                                            <!-- <select class="form-control" id="exampleFormControlSelect1" name="user[country]" required=""> -->
                                                <!-- <input type="text" class="form-control" id="inputCountry" name="user[country]"> -->
                                                <select  class="form-control country_select" id="inputCountry"  name="user[country]" required="">
                                                    <option></option>
                                                    <?php foreach($countries as $key): ?>
                                                    <option value="<?php echo $key->iso2 ?>" data-id="<?php echo $key->id ?>" ><?php echo $key->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputState">State *</label>
                                            <!-- <input type="text" class="form-control" id="inputState" name="user[state]" required=""> -->
                                            <select  class="form-control state_select" id="inputState" name="user[state]" required="">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="inputCity">City *</label>
                                            <!-- <input type="text" class="form-control" id="inputCity" name="user[city]" required=""> -->
                                            <select  class="form-control city_select" id="inputCity" name="user[city]" required="">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputZip">Zip *</label>
                                            <input type="text" class="form-control" id="inputZip" name="user[zip]" required="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="inputAdd">Address *</label>
                                            <textarea class="form-control" id="inputAdd" rows="3" name="user[address1]" required=""></textarea>
                                        </div>
                                    </div>
                                    
                                   <!--  <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="exampleFormControlTextarea1">Client Reffered By</label>
                                            <input class="form-control" id="exampleFormControlTextarea1" rows="3" name="user[client_reffered_by]">
                                        </div>
                                    </div> -->
                                    
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

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js"></script>
<script>
    (function( $ ) {
        var options = {

            url: function(phrase) {
                return "<?php echo base_url('/User_controller/get_company/') ?>"+phrase;
            },

            getValue: function(element) {
                return element.company_name;
            },

            ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                  dataType: "json"
                }
            },

            list: {
                 onChooseEvent: function() {
                    // var project_id = $("#jump_to_project").getSelectedItemData().project_id;
                },
                // match: {
                //     enabled: true
                // },
            },
        };

        $("#company_name").easyAutocomplete(options);
    })( jQuery );
</script> -->

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

    $(document).on('change', '#company_id', function(){
        var company_id = $(this).val();
        if(company_id == 'other'){
            $('#company_name').show();
            $('#company_name_div').show();
            $("#company_name").attr("required","required");
        }else{
            $("#company_name").removeAttr("required");
            $('#company_name').hide();
            $('#company_name_div').hide();
        }
    });

    // $(document).on('submit','#create_user_form', function(){
    //     var city = $('#inputCity').val();
    //     var country = $('#inputCountry').val();
    //     var address = $('#inputAdd').val();

    //     if(city == '' | country == '' | address == ''){
    //         alert('Please fill all the required field');
    //         return false;
    //     }
    //     return;
    // });
</script>


</body>
</html>