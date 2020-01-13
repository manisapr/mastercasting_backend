<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>

<div class="panel panel-default" id="message_panel">
    <div class="panel-heading">
        <button id="messaging_id" class="btn" type="button" data-toggle="collapse" data-target="#messaging" aria-expanded="true" aria-controls="create_msg">Messaging</button>
        <button style="float: right;" class="btn" type="button" data-toggle="collapse" data-target="#create_msg" aria-expanded="true" aria-controls="create_msg">Create Message</button>
    </div>
    <div class="collapse multi-collapse multi-collapse" id="create_msg">
        <div class="form msg-frm" style="padding: 20px !important">
            <form class="form-horizontal" id="message_send" action="">
                <div class="form-group">
                    <div class="col-md-8">
                        <textarea style="resize: vertical;" name="msg" id="" cols="30" rows="5" placeholder="Enter message here" class="form-control" required=""></textarea>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="msg_to" id="msg_user" required="">
                            <?php $project_assignee = explode(',', $project_details->assignee); ?>
                            <option value="" selected="" disable>Select User</option>
                            <?php $i = 1; foreach ($msg_user as $key): ?>
                            <?php if(in_array($designation_id,[5,7])): ?>
                                <?php if(in_array($key->id, $project_assignee)): ?>
                                <option value="<?php echo $key->id ?>">
                                    <?php if($key->designation_id == 9): ?>
                                    <?php echo 'Cad Team '.$i; $i++; ?>
                                    <?php else: ?>
                                    <?php echo $key->name.' - '.$key->designation_name ?>
                                    <?php endif ?>
                                </option>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if(in_array($key->id, $project_assignee)): ?>
                                <option value="<?php echo $key->id ?>"><?php echo $key->name.' - '.$key->designation_name ?></option>
                                <?php endif; ?>
                                <?php if($key->id == $project->asign_user): ?>
                                <option value="<?php echo $key->id ?>"><?php echo $key->name.' - '.$key->designation_name ?></option>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if(in_array($designation_id,[1,6,8,9,10,7])): ?>
                            <?php $associated_member = $this->projectmodel->get_associated_member($project->asign_user); ?>
                            <?php foreach ($associated_member as $key): ?>
                            <option value="<?php echo $key->id ?>"><?php echo $key->name.' - '.$key->designation_name ?> (Assoc)</option>
                            <?php endforeach; ?>

                            <?php if(!in_array($designation_id,[5, 7])): ?>
                            <option value="all_assoc">All Associates</option>
                            <?php endif; ?>

                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="project_id" value="<?= $project->project_id ?>">
                <div class="form-actions right todo-form-actions">
                    <button type="submit" class="btn btn-circle btn-sm green">
                    Send
                    </button>
                </div>
            </form>
            <form class="form-horizontal" id="reply_send" action="">
                <div class="form-group">
                    <div class="col-md-12">
                        <textarea style="resize: vertical;" name="msg" id="" cols="30" rows="5" placeholder="Enter reply here" class="form-control" required=""></textarea>
                        <!-- <input name="msg" type="text" placeholder="Message" class="form-control"> -->
                    </div>
                </div>
                <input type="hidden" name="project_id" value="<?= $project->project_id ?>">
                <input type="hidden" id="project_msg_id" name="project_msg_id">
                <div class="form-actions right todo-form-actions">
                    <button type="button" class="btn btn-circle btn-sm green" id="reply_btn">Create Message</button>
                    <button type="submit" class="btn btn-circle btn-sm green">Send</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="table-responsive collapse multi-collapse in show" id="messaging">
        <table class="table table-condensed table-sm" style="margin: 20px">
            <thead>
                <tr>
                    <td>Msg By</td>
                    <td>Msg To</td>
                    <td>Msg</td>
                    <td>Reply</td>
                    <td>Messaged At</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="msg_tbody">
                <?php foreach ($project_msg as $key) : ?>
                <tr>
                    <td><?php
                     if($key->msg_by == ''){
                        echo "";
                     } else{
                        $msg_by_des = $this->db->get_where('user', ['id' => $key->msg_by])->row()->designation_id;
                        if(in_array($designation_id, [5,7])){
                            if($msg_by_des == 9)
                                echo $this->db->get_where('designation', ['designation_id' => $msg_by_des])->row()->designation_name;
                            else
                                echo $this->db->get_where('user', ['id' => $key->msg_by])->row()->name.' - '. $this->db->get_where('designation', ['designation_id' => $msg_by_des])->row()->designation_name;
                                // echo $this->db->get_where('designation', ['designation_id' => $msg_by_des])->row()->designation_name;

                        } else{
                            echo $this->db->get_where('user', ['id' => $key->msg_by])->row()->name.' - '. $this->db->get_where('designation', ['designation_id' => $msg_by_des])->row()->designation_name;
                        }
                     } ?></td>
                    <td>
                        <?php 
                        if($key->msg_to == ''){
                            echo "";
                        } else{
                            $msg_to_des = $this->db->get_where('user', ['id' => $key->msg_to])->row()->designation_id;
                            if(in_array($designation_id, [5,7])){
                                if($msg_to_des == 9)
                                    echo $this->db->get_where('designation', ['designation_id' => $msg_to_des])->row()->designation_name;
                                else
                                    echo $this->db->get_where('user', ['id' => $key->msg_to])->row()->name.' - '. $this->db->get_where('designation', ['designation_id' => $msg_to_des])->row()->designation_name;
                                    // echo $this->db->get_where('designation', ['designation_id' => $msg_to_des])->row()->designation_name;

                            } else{
                                echo $this->db->get_where('user', ['id' => $key->msg_to])->row()->name.' - '. $this->db->get_where('designation', ['designation_id' => $msg_to_des])->row()->designation_name;
                            }
                        } 

                         ?>
                    </td>
                    <td><?= wordwrap($key->msg,30,"<br>\n"); ?></td>
                    <td><?= wordwrap($key->reply,30,"<br>\n"); ?></td>
                    <td><?= date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd/m/y h:i A'); ?></td>
                    <td>
                        <?php if($key->msg_to != 0): ?>
                            <?php if($key->msg_to == $this->session->userdata('user_id') || $this->session->userdata('user_id') == 1): ?>
                            <?php if($key->reply == ''): ?>
                            <button class="btn reply btn-xs" value="<?php echo $key->project_msg_id ?>" href="<?php echo base_url('Project_controller/msg_history/'.$key->project_id.'/'.$key->msg_to)?>"><i class="fa fa-reply" aria-hidden="true"></i>Reply</button>
                            <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- message form submit -->
<script>
    $(function(){
        $(document).on('submit','#message_send',function(e){
            e.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url: "<?= site_url('Project_controller/insert_msg') ?>",
                data: form,
                type: 'post',
                beforeSend: function() {
                    swal({
                        title: 'Message Sending',
                        text: 'Please wait....',
                        buttons: false
                    });
                },
                success:function(data){
                    if(!$('#messaging').hasClass("show"))
                        $('#messaging_id').trigger('click');
                    // $("#msg_tbody").html(data);
                    $("input[name='msg']").val('');
                    $("[name='msg_to']").val('');
                    swal("Thank you for you message. Someone will get back to you within 24 hours. If urgent please call us.");
                     $("#messaging").load(location.href + ' #messaging');
                },
                fail: function(){
                    swal('Message not send please try again');
                }
            });
        });
    });
</script>

<!-- reply scripts -->
<script>
    $('#reply_send').hide();

    $(document).on('click', '.reply', function(){

        var project_msg_id = $(this).val();
        $('#message_send').hide();
        $('#reply_send').show();
        $("#project_msg_id").val(project_msg_id);

        $('#create_msg').collapse('show');

        $('html,body').animate({
            scrollTop: $("#reply_send").offset().top - 100},
        'slow');
    });
    $(document).on('click', '#reply_btn', function(){
        $('#message_send').show();
        $('#reply_send').hide();
    });
</script>

<script>
    $(function(){
        $(document).on('submit','#reply_send',function(e){
            e.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url: "<?= site_url('Project_controller/insert_reply') ?>",
                data: form,
                type: 'post',
                success:function(data){
                    // alert(data);
                    // if(!$('#messaging').hasClass("show"))
                    //     $('#messaging_id').trigger('click');
                    // $("#msg_tbody").html(data);
                    // $("input[name='msg']").val('');
                    // $("[name='msg_to']").val('');
                    swal("Message added");
                    location.reload();
                }
            });
        });
    });
</script>