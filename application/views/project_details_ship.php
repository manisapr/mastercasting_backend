<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>
<div class="panel panel-default" id="project_printing_ship_label">
    <div class="panel-heading">
        <button class="btn collapsed print_ship_label_panel_btn" type="button" data-toggle="collapse" data-target="#printing_ship_label_div" aria-expanded="false" aria-controls="multiCollapseExample2">Printing ship label</button>
    </div>
    <div class="multi-collapse collapse" id="printing_ship_label_div" aria-expanded="false">
        <div class="row" style="margin: 20px">
            <div class="col-md-12">
                <form role="form" method="POST" action="<?php echo base_url('Project_controller/save_ship_action/'.$project->project_id) ?>">
                    <div class="form-body">
                        <div class="form-group">
                            <label>Shipping Type</label> <span class="font-red-sunglo ship_frm_err"><small></small></span>
                            <div class="mt-radio-inline">
                                <label class="mt-radio">
                                    <input type="radio" class="shipping_type_input ship_field" name="ship[shipping_type]" value="ship_to_client" <?php echo $project_ship->shipping_type == 'ship_to_client' ? 'checked' : '' ?> <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> Ship To Client
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio" class="shipping_type_input ship_field" name="ship[shipping_type]" value="drop_ship" <?php echo $project_ship->shipping_type == 'drop_ship' ? 'checked' : '' ?> <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> Drop Ship
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio" class="shipping_type_input ship_field" name="ship[shipping_type]" value="ship_to_mcc" <?php echo $project_ship->shipping_type == 'ship_to_mcc' ? 'checked' : '' ?> <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> Ship To MCC
                                    <span></span>
                                </label>
                            </div>
                        </div>

                       

                        <div id="ship_to_client_div" class="ship_div" style="<?php echo $project_ship->shipping_type != 'ship_to_client' ? 'display: none' : ''?>">
                            <div class="form-group">
                                <label>Shipping Address Details</label>
                            </div>

                            <div class="form-group col-md-12">
                                <textarea style="resize: vertical;" class="form-control ship_field form-field" name="client_address[address1]" id="" cols="30" rows="2" placeholder="Address" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>><?php echo $client_address->address ?></textarea>
                            </div>

                            <div class="form-group col-md-3">
                                <select  class="form-control ship_field country_select" id="country_select_one" name="client_address[country]" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                    <option></option>
                                    <?php foreach($countries as $key): ?>
                                    <option value="<?php echo $key->iso2 ?>" data-id="<?php echo $key->id ?>" <?php echo $key->iso2 == $client_address->country ? 'selected' : '' ?>><?php echo $key->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- <input type="text"  value="<?php echo $project_ship->country ?>" class="form-control ship_field" name="ship[country]" placeholder="Country Code" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> -->
                            </div>
                            
                            <div class="form-group col-md-3">
                                <select  class="form-control ship_field state_select"  name="client_address[state]" data-state="<?php echo $client_address->state ?>" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                    <option></option>
                                </select>
                                <!-- <input type="text" class="form-control ship_field" value="<?php echo $client_address->state ?>"  name="client_address[state]" placeholder="State Code" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> -->
                            </div>
                            <div class="form-group col-md-3">
                                <select  class="form-control ship_field city_select" id="city_select_one"  name="client_address[city]" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                    <option></option>
                                    <option value="<?php echo $client_address->city ?>" selected><?php echo $client_address->city ?></option>
                                </select>
                                <!-- <input type="text" class="form-control ship_field form-field" value="<?php echo $client_address->city ?>" name="client_address[city]" placeholder="City" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> -->
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control ship_field form-field"  value="<?php echo $client_address->zip ?>" name="client_address[zip]" placeholder="Postal Code" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                            </div>
                            <!-- <div class="form-group col-md-3">
                                <input type="text"  value="<?php //echo $client_address->country ?>" class="form-control ship_field" name="client_address[country]" placeholder="Country Code" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                            </div> -->


                        </div>




                        <div id="drop_ship_div" class="ship_div" style="<?php echo $project_ship->shipping_type != 'drop_ship' ? 'display: none' : ''?>">
                            <div class="form-group">
                                <label>Customer Details</label>
                            </div>

                            <div class="form-group col-md-4">
                                <input type="text" class="form-control ship_field" name="ship[customer_name]" value="<?php echo $project_ship->customer_name ?>" placeholder="Customer Name" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control ship_field" value="<?php echo $project_ship->customer_email ?>" name="ship[customer_email]" placeholder="Customer Email" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control ship_field" value="<?php echo $project_ship->customer_phone ?>" name="ship[customer_phone]" placeholder="Customer Phone" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                            </div>

                            
                            <div class="form-group">
                                <label>Shipping Address Details</label>
                            </div>

                            <div class="form-group col-md-12">
                                <textarea style="resize: vertical;" class="form-control ship_field form-field" name="ship[address]" id="" cols="30" rows="2" placeholder="Address" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>><?php echo $project_ship->address ?></textarea>
                            </div>

                            <div class="form-group col-md-3">
                                <select  class="form-control ship_field country_select" id="country_select_two"  name="ship[country]" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                    <option></option>
                                    <?php foreach($countries as $key): ?>
                                    <option value="<?php echo $key->iso2 ?>"  data-id="<?php echo $key->id ?>"  <?php echo $key->iso2 == $project_ship->country ? 'selected' : '' ?>><?php echo $key->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- <input type="text"  value="<?php echo $project_ship->country ?>" class="form-control ship_field" name="ship[country]" placeholder="Country Code" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> -->
                            </div>
                            <div class="form-group col-md-3">
                                <select  class="form-control state_select" id="state_select_one" name="ship[region]" data-state="<?php echo $project_ship->region ?>" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                    <option></option>
                                </select>
                                <!-- <input type="text" class="form-control ship_field" value="<?php //echo $project_ship->region ?>"  name="ship[region]" placeholder="State Code" <?php //echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> -->
                            </div>
                            <div class="form-group col-md-3">
                                <select  class="form-control ship_field city_select" id="city_select_two"  name="ship[city]" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                    <option></option>
                                    <option value="<?php echo $project_ship->city ?>" selected><?php echo $project_ship->city ?></option>
                                </select>
                                <!-- <input type="text" class="form-control ship_field form-field" value="<?php //echo $project_ship->city ?>" name="ship[city]" placeholder="City" <?php //echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> -->
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control ship_field form-field"  value="<?php echo $project_ship->postal_code ?>" name="ship[postal_code]" placeholder="Postal Code" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                            </div>

                            <div class="form-group col-md-12">
                                <input type="hidden" name="ship[residential_address]" value="0"/>
                                <input class="residential_address ship_field" name="ship[residential_address]" value="1" type="checkbox" <?php echo $project_ship->residential_address == 1 ? 'checked' : ''?>> This is a residential address?
                        </div>
                        </div>


                        <div id="ship_to_mcc_div" class="ship_div" style="<?php echo $project_ship->shipping_type != 'ship_to_mcc' ? 'display: none' : ''?>">
                            <div class="form-group">
                                <label>Shipping Address Details</label>
                            </div>

                            <div class="form-group col-md-12">
                                <textarea style="resize: vertical;" class="form-control ship_field form-field" id="" cols="30" rows="2" placeholder="Address" disabled><?php echo $mcc_address->address ?></textarea>
                            </div>

                            <div class="form-group col-md-3">
                                <select  class="form-control ship_field country_select" disabled>
                                    <option></option>
                                    <?php foreach($countries as $key): ?>
                                    <option value="<?php echo $key->iso2 ?>"  data-id="<?php echo $key->id ?>"  <?php echo $key->iso2 == $mcc_address->country ? 'selected' : '' ?>><?php echo $key->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- <input type="text"  value="<?php echo $project_ship->country ?>" class="form-control ship_field" name="ship[country]" placeholder="Country Code" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>> -->
                            </div>
                           
                            <div class="form-group col-md-3">
                                <select  class="form-control ship_field state_select" data-state="<?php echo $mcc_address->region ?>" disabled>
                                    <option></option>
                                </select>
                                <!-- <input type="text" class="form-control ship_field" placeholder="State Code" value="<?php echo $mcc_address->region ?>" disabled> -->
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control ship_field form-field" placeholder="City" value="<?php echo $mcc_address->city ?>" disabled>
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control ship_field form-field" placeholder="Postal Code" value="<?php echo $mcc_address->postal_code ?>" disabled>
                            </div>
                            <!-- <div class="form-group col-md-3">
                                <input type="text" class="form-control ship_field form-field" placeholder="Country Code" value="<?php //echo $mcc_address->country ?>" disabled>
                            </div> -->
                            </div>

                        <div class="form-group">
                            <label>Package & Shipment Details</label>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control ship_field" placeholder="Custom Value" name="ship[custom_value]" value="<?php echo $project_ship->custom_value ?>" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                        </div>
                        <div class="form-group col-md-3">
                            <select name="ship[shipping_method]" id="shp_mthd_slct" class="form-control ship_field" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                <option value="" selected="" disabled="">Select ship method</option>
                                <?php foreach ($ship_services as $key => $value) : ?>
                                <option value="<?php echo $key ?>" <?php echo $project_ship->shipping_method == $key ? 'selected' : '' ?>><?php echo $value ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select name="ship[lable_stock_type]" class="form-control ship_field" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                <option value="" disabled="">Select Label Stock Type</option>
                                <option value="STOCK_4X6" <?php echo $project_ship->lable_stock_type == 'STOCK_4X6' ? 'selected' : ''?>>Stock 4x6</option>
                                <option value="PAPER_4X6" <?php echo $project_ship->lable_stock_type == 'PAPER_4X6' ? 'selected' : ''?>>Paper 4x6</option>
                                <option value="PAPER_8.5X11_TOP_HALF_LABEL" <?php echo $project_ship->lable_stock_type == 'PAPER_8.5X11_TOP_HALF_LABEL' ? 'selected' : ''?>>Paper 8.5x11 top half label</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select name="ship[signature_type]" class="form-control ship_field" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                <option value="SERVICE_DEFAULT" selected="">Default Signature</option>
                                <option value="NO_SIGNATURE_REQUIRED" <?php echo $project_ship->signature_type == 'NO_SIGNATURE_REQUIRED' ? 'selected' : ''?>>No Signature Required</option>
                                <option value="DIRECT" <?php echo $project_ship->signature_type == 'DIRECT' ? 'selected' : ''?>>Direct Signature Required</option>
                                <option value="INDIRECT" <?php echo $project_ship->signature_type == 'INDIRECT' ? 'selected' : ''?>>Indirect Signature Required</option>
                                <option value="ADULT" <?php echo $project_ship->signature_type == 'ADULT' ? 'selected' : ''?>>Adult Signature Required</option>
                            </select>
                        </div>

                        <div class="form-group clearfix">
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control ship_field" placeholder="Weight" name="ship[weight]" value="<?php echo $project_ship->weight ?>" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                            </div>
                            <div class="form-group col-md-2">
                                <select name="ship[weight_unit]" class="form-control ship_field" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : ''?>>
                                    <option value="" disabled="">Select Weight Units</option>
                                    <option value="KG" <?php echo $project_ship->weight_unit == 'KG' ? 'selected' : ''?>>KG</option>
                                    <option value="LB" <?php echo $project_ship->weight_unit == 'LB' ? 'selected' : ''?>>LB</option>
                                </select>
                            </div>
                        </div>

                        <?php if($project_ship->is_shipped == 1): ?>
                        <div class="form-group col-md-12">
                            <?php if(!in_array($designation_id,[5, 7])): ?>
                            <button type="button" class="btn btn-circle btn-sm green send_label_btn">Send Label</button>
                            <?php endif; ?>
                            <a target="_blank" class="btn btn-circle btn-sm green" href="<?php echo base_url('uploads/fedex/shipping_label/'.$project_ship->file) ?>"><i class="fas fa-print"></i> Print Label</a>
                        </div>
                        <?php endif; ?>


                        <?php if($project_ship->is_shipped == 0): ?>
                        <div class="form-group col-md-12">

                            <button style="display: none; float: right" type="submit" class="btn btn-circle btn-sm save_ship_btn green">Save Changes</button>

                            <?php if(!in_array($designation_id, [5, 7])): ?>
                            <button type="button"  class="btn btn-circle btn-sm green ready_to_ship_btn" <?php echo $project_ship->is_shipped == 1 ? 'disabled' : '' ?>><?php echo $project_ship->is_shipped == 1 ? 'Shipped' : 'Ship and print label' ?></button>
                            <?php endif; ?>

                            <?php if(!in_array($designation_id, [5, 7])): ?>
                            <button type="button" class="btn btn-circle btn-sm green" id="get_rate_btn" value="<?php echo $project->project_id ?>">Get Rates</button>
                            <?php endif; ?>
                        </div>
                    

                        <?php endif; ?>
                        <!--  <div id="ship_to_mcc_div" style="display: none;">
                            <div class="col-md-3 text-center">
                                Ship to mcc
                            </div>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="rate_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Shipping Rates</h4>
      </div>
      <div class="modal-body" style="text-align: center;" id="rate_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
    $('input.shipping_type_input').change(function() {
        var ship_div = $('.ship_div');
        if(this.value == 'ship_to_client'){
            // $('#ship_to_mcc_div').show();
            ship_div.hide();
            ship_div.eq(0).show();
        }
        else if(this.value == 'drop_ship'){
            ship_div.hide();
            ship_div.eq(1).show();
        }
        else{
            ship_div.hide();
            ship_div.eq(2).show();
        }
        change_ship_service(this.value);
    });

    function change_ship_service(type){

        $.ajax({
            beforeSend:function(){
                $("#printing_ship_label_div").
                append('<div class="loader_container"><div class="loader"></div></div>');
            },
            url: '<?php echo base_url('Project_controller/get_ship_services_options') ?>',
            data: {'project_id': <?php echo $project_details->project_id ?>, 'type': type},
            type: 'POST',
            success:function(data){
                $('#shp_mthd_slct').html(data);
                $("#printing_ship_label_div .loader_container").remove();
            }
        });
    }
</script>

<script>
    $(document).on('click', '#get_rate_btn', function(){
        var type = $('input.shipping_type_input:checked').val();
        $.ajax({
            url: "<?php echo base_url('Fedex/rate/'.$project->project_id) ?>",
            data: {'type': type},
            type: 'POST',
            success:function(data){
                $('#rate_body').html(data);
                $('#rate_modal').modal('show');
            }
        });
    });
</script>

 <script>
    $(document).on('click', '.ready_to_ship_btn', function(){
        debugger;
        var is_selected = $('#shp_mthd_slct').val();

        // if(is_selected)
        var is_shipped = '<?php echo $is_all_ship_form_filed_up ?>';

        // alert(is_shipped);
        if(is_shipped == '0' && is_selected != null)
            window.location.href = '<?php echo base_url('Fedex/ship/'.$project->project_id) ?>';
        else {

            $('html, body').animate({
                scrollTop: $("#project_printing_ship_label").offset().top
            }, 2000);

            if(is_shipped == '1')
                $('.ship_frm_err').html('***Please fill this up first');
            else if(is_selected == null)
                $('.ship_frm_err').html('Select a ship method');
            else
                $('.ship_frm_err').html(is_shipped);

            if($('.print_ship_label_panel_btn').hasClass('collapsed'))
                $('.print_ship_label_panel_btn').trigger('click');
        }

    });
</script>


<script>
    $(document).on('click', '.send_label_btn', function(){
        $.ajax({
            beforeSend:function(){
                swal({
                      text: 'Email is sending',
                      timer: 2000,
                      showCancelButton: false,
                      showConfirmButton: false
                });
            },
            url: "<?php echo base_url('Fedex/send_ship_label/'.$project->project_id) ?>",
            success:function(data){
                swal('Email sent');
            }
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script>
    jQuery.noConflict;

    (function($){
		var hash = window.location.hash;
		if (hash === "#project_printing_ship_label") {
			$('#printing_ship_label_div').addClass('show in');
		}

		$.fn.select2.defaults.set("theme", "bootstrap");

        $(".country_select").select2({
            placeholder: "Select a country",
            allowClear: true
        });

        $(".state_select").select2({
            placeholder: "Select a state",
            allowClear: true
        });

        // debugger;
        var country_select = $('.country_select');
        var length = country_select.length;

        for (let i = 0; i < length; i++) {
            var country = country_select.eq(i).find(':selected').data('id');
            var state = $('.state_select');
            var state_value = state.eq(i).data('state');
            $.ajax({
                url: '<?php echo base_url('Project_controller/get_state_by_country') ?>',
                data: {'id' : country, 'state_value': state_value},
                type: 'post',
                success:function(data){
                    state.eq(i).html(data);
                }
            });
        }
        // $(document).on('load', function(){
            
        // })

        $(document).on('change', '.country_select', function(){
            var index = $('.country_select').index(this);
            var country = $(this).find(':selected').data('id');

            $('.save_ship_btn').show();
            $('.ready_to_ship_btn, #get_rate_btn').hide();
            // $('.form-field').val('');

            $.ajax({
                beforeSend:function(){
                    $("#printing_ship_label_div").
                    append('<div class="loader_container"><div class="loader"></div></div>');
                },
                url: '<?php echo base_url('Project_controller/get_state_by_country') ?>',
                data: {'id' : country},
                type: 'post',
                success:function(data){
                    var state = $('.state_select');
                    state.eq(index).html(data);
                    $("#printing_ship_label_div .loader_container").remove();
                }
            });
        });

        $(document).on('change', '.state_select', function(){
            $('.save_ship_btn').show();
            $('.ready_to_ship_btn, #get_rate_btn').hide();
        });

        $(document).on('change', '.city_select', function(){
            $('.save_ship_btn').show();
            $('.ready_to_ship_btn, #get_rate_btn').hide();
        });


        $("#city_select_one").select2({
            placeholder: "Enter city",
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
                        state: $('.state_select').eq(0).find(':selected').val(),
                        country: $('#country_select_one').eq(0).find(':selected').val()
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

        $("#city_select_two").select2({
            placeholder: "Enter city",
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
                        state: $('.state_select').eq(1).find(':selected').val(),
                        country: $('#country_select_two').eq(0).find(':selected').val()
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
    })(jQuery);
</script>


<script>
    $(document).on('change keyup paste', '.ship_field', function(){
        $('.save_ship_btn').show();
        $('.ready_to_ship_btn, #get_rate_btn').hide();
    });
</script>

<?php if($this->session->flashdata('fedex_ship')): ?>
<script>
    swal('Project shipped');

    setTimeout(function(){
        window.open("<?php echo base_url('uploads/fedex/shipping_label/'.$project_ship->file) ?>",  "_blank");
    }, 2000);
</script>
<?php $this->session->unset_userdata('fedex_ship');  endif; ?>