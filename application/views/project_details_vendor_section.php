<div class="panel panel-default"  id="project_vendor_envelope">
    <div class="panel-heading">
        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#vendor_envelope_div" aria-expanded="false" aria-controls="multiCollapseExample2">Vendor Envelope</button>
    </div>
    <div class="collapse multi-collapse" id="vendor_envelope_div" aria-expanded="false">
        <div class="row" style="margin: 20px">
            <div class="col-md-6">
                <form method="POST" id="update_vendor_envelope_form" action="<?php echo base_url('Project_controller/print_project_details/vendor')?>" target="_blank">
                    <table class="print_table">
                        <tbody>
                            <tr>
                                <td>Created</td>
                                <td>
                                    <!-- Monday, August 27, 2018 -->
                                    <?php echo date('l, F d, Y', strtotime($project_details->created_at)) ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Disposition</td>
                                <td>
                                    <?php $disposition_internal = $this->db->query("SELECT * FROM `project_disposition_internal` WHERE project_id = $project->project_id AND flag = 0 ORDER by project_disposition_id DESC")->row();  ?>
                                    <?php 
                                    if(count($disposition_internal) == 0){
                                        $disposition_internal = $this->db->query("SELECT * FROM `project_disposition_internal` WHERE project_id = $project->project_id ORDER by project_disposition_id ASC")->row();
                                        if(count($disposition_internal) != 0)
                                            echo $this->db->get_where('disposition',['disposition_id' => $disposition_internal->disposition_id])->row()->name;
                                    } else{
                                        echo $this->db->get_where('disposition',['disposition_id' => $disposition_internal->disposition_id])->row()->name;
                                    }

                                     ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Priority</td>
                                <td>
                                    <select name="project[priority]" class="form-control" <?= $completed ? 'disabled' : '' ?>>
                                        <option value="standard" 
                                        <?php if(isset($project_details->priority)){
                                            echo $project_details->priority == 'standard' ? 'selected' : '';
                                            }
                                         ?>>Standard Priority</option>
                                        <option value="high" 
                                        <?php if(isset($project_details->priority)){
                                            echo $project_details->priority == 'high' ? 'selected' : '';
                                            }
                                         ?>>High Priority</option>
                                        <option value="critical" 
                                        <?php if(isset($project_details->priority)){
                                            echo $project_details->priority == 'critical' ? 'selected' : '';
                                            }
                                         ?>
                                        >Critical</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Deadline</td>
                                <td>
                                    <input name="project[deadline]" class="form-control" type="text"  value="<?php echo date('m/d/Y', strtotime($project_details->deadline)) ?>" id="vendor_calendar" <?php echo !$client_approval ? 'disabled' : '' ?> <?= $completed ? 'disabled' : '' ?>>
                                </td>
                            </tr>
                            <tr>
                                <td>PO #</td>
                                <td>
                                    <input type="text" class="form-control" name="project[po]" value="<?php echo isset($project_details->po) ? $project_details->po : ''?>" <?= $completed ? 'disabled' : '' ?>>
                                </td>
                            </tr>
                            <tr>
                                <td>Tracking #</td>
                                <td>
                                    <input type="text" class="form-control" name="project[tracking]"  value="<?php echo isset($project_details->tracking) ? $project_details->tracking : ''?>" <?= $completed ? 'disabled' : '' ?>>
                                </td>
                            </tr>
                            <tr>
                                <td><button class="btn btn-circle btn-md green">Print</button>
                                    <button type="button" value="<?php echo $project->project_id?>" id="update_vendor_envelope_btn" class="btn btn-circle btn-md green" style="margin-left: 10px" <?= $completed ? 'disabled' : '' ?>>Save</button>
                                </td>
                            </tr>
                            <input type="hidden" name="project[project_id]" value="<?= $this->uri->segment(3); ?>">
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        
    </div>
</div>

  <script>
           
    $(document).on('click', '#update_vendor_envelope_btn', function(){
        var form = $('#update_vendor_envelope_form').serialize();
        var project_id = $(this).val();
        $.ajax({
            url: '<?php echo base_url('Project_controller/update_print_project_details')?>',
            data: form,
            type: 'post',
            success:function(data) {
                // alert(data);
                swal('Updated');
                setTimeout(function(){
                    location.reload();
                }, 2000);
            }

        });
    });
</script>