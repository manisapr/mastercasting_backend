<?php date_default_timezone_set('America/Chicago'); ?>
 <div class="panel panel-default">
    <div class="panel-heading">
        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#activity_log" aria-expanded="false">Activity Log</button> 
        <span class="badge badge-primary pull-right" style="background-color: #337ab7;">Last seen by client <?php echo time_elapsed_string(date_convert(date('d-m-Y H:i:s', strtotime($project_details->last_seen_by_client)), 'Y-M-d H:i:s')); ?></span>
    </div>
    
    <div class="multi-collapse collapse" id="activity_log" aria-expanded="false" style="height: 0px;">
        <div class="row" style="margin: 20px">
            <div class="col" style="height: 300px; overflow-y: scroll;">
                <table class="table table-borderless">
                    <thead>
                        <th class="text-center">Last Updated</th>
                        <th class="text-center">Updated At</th>
                        <th>Updated By</th>
                        <th>Update Type</th>
                        <th>Details</th>
                    </thead>
                    <tbody>
                        <?php foreach ($project_activity_log as $key) : ?>
                        <tr>
                            <td class="text-center"><?php echo time_elapsed_string(date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'Y-M-d H:i:s')) ?></td>
                            <td class="text-center"><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M H:i'); ?></td>
                            <td>
                                <?php $activity_user = $this->db->get_where('user', ['id' => $key->user_id])->row(); ?>
                                <?php echo $activity_user->name  ?> - 
                                <span class="badge badge-primary"></span><?php echo $this->db->get_where('designation', ['designation_id' => $activity_user->designation_id])->row()->designation_name  ?>
                            </td>
                            <td><?php
                                // echo $key->activity_type ;
                                if(in_array($key->activity_type, [12,13,14,15,16,31,32,33,44,45, 51])):{
                                    echo "Project ".strtolower(str_replace('_', ' ', ($this->db->get_where('activity_type', ['activity_type_id' => $key->activity_type])->row()->activity_name)));
                                }
                                elseif(in_array($key->activity_type, [17,18,19,20,21])): {
                                    echo "Project ".strtolower(str_replace('_', ' ', ($this->db->get_where('activity_type', ['activity_type_id' => $key->activity_type])->row()->activity_name)))." specification updated";

                                }
                                elseif(in_array($key->activity_type, [30,46])): {
                                    echo "Project ".strtolower(str_replace('_', ' ', ($this->db->get_where('activity_type', ['activity_type_id' => $key->activity_type])->row()->activity_name)))." added";

                                }
                                else: {
                                    echo "Project ".strtolower(str_replace('_', ' ', ($this->db->get_where('activity_type', ['activity_type_id' => $key->activity_type])->row()->activity_name)))." updated";
                                }

                                endif;
                            ?></td>
                            <td>
                                <?php echo $key->details; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (count($project_activity_log) == 0) : ?>
                        <tr><td class="text-center">No activity yet</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>