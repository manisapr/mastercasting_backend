            <!-- BEGIN HEADER -->
            <?php include 'inc/header.php'; ?>
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
                       
                        
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN VALIDATION STATES-->
                                <div class="portlet light portlet-fit portlet-form bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-red sbold uppercase">Personal Info</span>
                                        </div>
                                        
                                    </div>
                                    <div class="portlet-body">
                                        <!-- BEGIN FORM-->

											<?php //print_r($data);?>
                                        <form action="<?php echo site_url('Master_controllers/update_profile');?>" id="form_sample_1" class="form-horizontal" method="post">
                                            <div class="form-body">
                                                

												<?php foreach($data as $row)
													{

														?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Designation</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control"  value="<?php echo $this->db->get_where('designation', ['designation_id' =>  $row->designation_id])->row()->designation_name; ?>" disabled/>
                                                    </div>
                                                </div>

												<div class="form-group">
                                                    <label class="control-label col-md-3">Name
                                                        <span class="required"> * </span>
                                                    </label>
														<input type="hidden" name="id" data-required="1" class="form-control"  value="<?php echo $user_id = $row->id;?>"/>
                                                    <div class="col-md-4">
                                                        <input type="text" name="user[name]" data-required="1" class="form-control"  value="<?php echo $row->name;?>" required/> </div>
                                                </div>
												
												<div class="form-group">
                                                    <label class="control-label col-md-3">Email
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="user[email]" data-required="1" class="form-control" value="<?php echo $row->email;?>" required/> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Contact No
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="user[phone]" data-required="1" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control" value="<?php echo $row->phone;?>" required/> 
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Country
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <select  class="form-control country_select" id="inputCountry"  name="user[country]" required="">
                                                            <option></option>
                                                            <?php foreach($countries as $key): ?>
                                                            <option value="<?php echo $key->iso2 ?>" data-id="<?php echo $key->id ?>" <?php echo $row->country == $key->iso2 ? 'selected' : '' ?>><?php echo $key->name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <!-- <input name="user[state]" type="text" class="form-control" value="<?php //echo $row->state;?>" /> -->
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">State</label>
                                                    <div class="col-md-4">
                                                    <select  class="form-control state_select" id="inputState" name="user[state]" required="">
                                                        <option></option>
                                                        <option value="<?php echo $row->state ?>" selected>
                                                            <?php 
                                                            $state = $this->db->get_where('states', ['iso2' => $row->state, 'country_code' => $row->country])->row();
                                                            echo !empty($state) ? $state->name : $row->state ?>
                                                        </option>
                                                    </select>
                                                        <!-- <input name="user[state]" type="text" class="form-control" value="<?php //echo $row->state;?>" /> -->
                                                    </div>
                                                </div>
												
												<div class="form-group">
                                                    <label class="control-label col-md-3">City</label>
                                                    <div class="col-md-4">
                                                    <select  class="form-control city_select" id="inputCity" name="user[city]" required="">
                                                        <option></option>
                                                        <option value="<?php echo $row->city ?>" selected><?php echo $row->city ?></option>
                                                    </select>
                                                        <!-- <input name="user[city]" type="text" class="form-control" value="<?php //echo $row->city;?>" /> -->
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Zip Code</label>
                                                    <div class="col-md-4">
                                                        <input name="user[zip]" type="text" class="form-control" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $row->zip;?>" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Address
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="user[address1]" data-required="1" class="form-control" value="<?php echo $row->address1;?>"/> </div>
                                                </div>

                                                <?php if(in_array($row->designation_id, [5, 7])): ?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Token</label>
                                                    <div class="col-md-4">
                                                        <input class="form-control api_token" type="text" value="<?php echo $row->api_token; ?>" readonly="readonly" style="display: none" tabindex="0" data-toggle="tooltip" title="Copied">
                                                        <button class="btn btn-default generate_token" type="button">Generate</button>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn green">Save</button>
                                                        <!-- <button type="reset" class="btn grey-salsa btn-outline">Cancel</button> -->

													<?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END FORM-->
                                    </div>
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN VALIDATION STATES-->
                                <div class="portlet light portlet-fit portlet-form bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-red sbold uppercase">Change Password</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <!-- BEGIN FORM-->
                                        <form action="<?php echo site_url('User_controller/change_password/'.$user_id);?>" id="form_sample_2" class="form-horizontal" method="post">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Password</label>
                                                    <div class="col-md-4">
                                                        <input id="password" name="user[password]" type="password" class="form-control" value="" required="" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Confirm Password</label>
                                                    <div class="col-md-4">
                                                        <input id="cnfrm_ps" name="cnfrm_ps" type="password" class="form-control" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn green">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END FORM-->
                                    </div>
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>
                        </div>
                     </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <?php include 'inc/footer.php'; ?>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
        <div class="quick-nav-overlay"></div>
        <!-- END QUICK NAV -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
         <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>assets/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
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
		<script  src="js/upload-file.js"></script>
		<script type="text/javascript">
			function readURL(input) {
			
			 if (input.files && input.files[0]) {
			   var reader = new FileReader();
			
			   reader.onload = function(e) {
			     $('#image_change').attr('src', e.target.result);
			   }
			
			   reader.readAsDataURL(input.files[0]);
			 }
			}
			
			$("#file").change(function() {
			 readURL(this);
			});


            $(document).on('submit', '#form_sample_2', function(){
                var ps = $("#password").val();
                var con_ps = $("#cnfrm_ps").val();
                if(ps != con_ps){
                    swal("Confirm Password not Matched");
                    return false;
                }
            });
			
		</script>

        <?php if($this->session->flashdata('password')): ?>
        <script>
            swal("Password changed");
        </script>
        <?php endif; ?>
        <?php if($this->session->flashdata('profile_update') == 'success'): ?>
        <script>
            swal("Profile updated");
        </script>
        <?php endif; ?> 
        <?php if($this->session->flashdata('profile_update') == 'error'): ?>
        <script>
            swal("Email already exist. Please use another email id");
        </script>
        <?php endif; ?>

        <script>
            $(document).on('click', '.generate_token', function(){
                $(this).hide();
                $('input.api_token').show();
            });

            $(document).on('click', '.api_token', function(){
                // alert('dsasd');
                var copyText = $(this);
                copyText[0].select();
                copyText[0].setSelectionRange(0, 99999)
                document.execCommand("copy");
                $(this).tooltip('show');
                // alert("Copied the text: " + copyText.val());
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