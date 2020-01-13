<!-- BEGIN HEADER -->
<?php include 'inc/header.php'; ?>
<?php 
$designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
$user_id = $this->session->userdata('user_id');
 ?>
<style>
    .list-group-item{
        border-bottom: 3px solid transparent;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .list-group-item:last-child{
        border-bottom: 1px solid #ddd;
    }
    .list-group-item:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        border-color: #ddd;
    }
    .list-action{
        display: none;
    }
    .list-action .fa-envelope-open{
        margin-right: 5px;
    }
    .list-action .btn{
        padding: 0;
        margin: 0;
        line-height: 1;
    }
    .list-info{
        flex: 50px 0 0;
        height: 23px!important;
        display: flex;
        align-items: center;
    }
    .tooltip-inner {
        max-width: 100% !important;
    }
    .message-actions{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .message-actions .btn{
        border: 0!important;
        border-radius: 10px !important;
        font-size: 18px!important;
        color: #6c757d!important;
    }
    .list-info .btn{
        border: 0!important;
        border-radius: 10px !important;
        font-size: 16px!important;
        color: #6c757d!important;
    }
    .btn-group .btn+.btn, .btn-group .btn+.btn-group, .btn-group .btn-group+.btn, .btn-group .btn-group+.btn-group {
        margin-left: 0 !important; 
    }
    .read{
        background: rgba(208, 209, 213, 0.6);
    }
    .reply-box{
        border-radius: 5px !important;
        display: none;
    }
    .reply-box:hover, .reply-box:active, .reply-box:focus{
        box-shadow: 0 1px 1px 0 rgba(60,64,67,.08), 0 1px 3px 1px rgba(60,64,67,.16) !important;
        transition: box-shadow 135ms cubic-bezier(.4,0,.2,1) !important;
    }
    
    .reply-box textarea{
        border: 0;
    }
</style>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- BEGIN SIDEBAR -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <?php include 'inc/sidebar.php'; ?>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
            <div class="theme-panel hidden-xs hidden-sm">
            </div>
            <!-- END THEME PANEL -->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="<?php echo base_url() ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    
                    <li>
                        <a href="#">Single Project Message</a>
                    </li>
                </ul>
                <div class="page-toolbar">
                    
                </div>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <!-- <h1 class="page-title">Trade Clients</h1> -->
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Project Message</span>
                            </div>
                        </div>
                        
                        <div class="portlet-body" id="messages_div_body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="btn-group message-actions">
                                            <a href="<?php echo base_url('Message_controller')?>" class="fas fa-arrow-left btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Back"></a>
                                            <button class="fas fa-envelope btn btn-default mark_as_unread_btn" value="<?php echo $project_msg->project_msg_id ?>" data-toggle="tooltip" data-placement="bottom" title="Mark as unread"></button>
                                            <button class="fas fa-trash btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Delete"></button>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>
                                        <?php if(in_array($designation_id, [5,7])): ?>
                                            <?php $msg_by_des = $this->db->get_where('user', ['id' => $project_msg->msg_by])->row()->designation_id; ?>
                                            <?php if($msg_by_des == 9): ?>
                                            <b>Cad Member</b>
                                            <?php else: ?>
                                            <b><?php echo $this->db->get_where('user', ['id' => $project_msg->msg_by])->row()->name ?></b>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <b>J<?php echo $project_msg->project_id ?> <?php echo $this->db->get_where('user', ['id' => $project_msg->msg_by])->row()->name ?></b>
                                        <?php endif; ?>
                                    </h4>
                                    <br>
                                    <p>
                                        <b>Replied:</b> <span><?php echo $project_msg->msg; ?></span>
                                    </p>
                                    <?php if($project_msg->is_replied == 1): ?>
                                    <p>
                                        <b>Replied:</b> <span><?php echo $project_msg->reply ?></span>
                                    </p>
                                    <?php else: ?>
                                    <p>
                                        No reply yet
                                    </p>
                                    <?php endif; ?>
                                    <div class="msg-reply-frwrd">
                                        <?php if($project_msg->is_replied == 0): ?>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-circle btn-secondary grey-salsa btn-sm reply-btn"><i class="fas fa-reply"></i> Reply</button>
                                        </div>
                                        <?php endif; ?>
                                      <!--   <div class="btn-group">
                                            <button type="button" class="btn btn-circle btn-secondary grey-salsa btn-sm">Forward <i class="fas fa-arrow-alt-from-left"></i></button>
                                        </div>   -->  
                                        <div class="btn-group">
                                            <a target="_blank" href="<?php echo base_url('projects/project_details/'.$project_msg->project_id) ?>" class="btn btn-circle btn-secondary grey-salsa btn-sm">Go to project <i class="fas fa-external-link-alt"></i></a>
                                        </div>    
                                    </div>
                                    <div class="panel panel-default reply-box">
                                        <div class="panel-body">
                                            <form action="" id="reply_send">
                                                <input type="hidden" name="project_id" value="<?php echo $project_msg->project_id ?>">
                                                <input type="hidden" name="project_msg_id" value="<?php echo $project_msg->project_msg_id ?>">
                                                <div class="form-group">
                                                    <textarea name="msg" id="" style="padding: 0" cols="30" rows="10" class="form-control" placeholder="Enter reply"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <div class="btn-group">
                                                        <button class="btn btn-circle btn-primary">Send</button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-circle btn-default reply-cancel">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <!-- empty -->
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
    <!-- BEGIN CORE PLUGINS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url();?>assets/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="<?php echo base_url();?>assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?php echo base_url();?>assets/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        $(document).ready(function() {
            $('.group-checkable').change(function() {
                var is_group_checked = $(this).is(':checked');
                if(is_group_checked)
                    $('.checkboxes').prop('checked', true);
                else
                    $('.checkboxes').prop('checked', false);

            });
        })
    </script>

    <script>
        $(".list-group-item").hover(function(){
          $(this).find('.list-date').hide();
          $(this).find('.list-action').show();
          }, function(){
          $(this).find('.list-date').show();
          $(this).find('.list-action').hide();
        });
    </script>

    <script>
         $(document).ready(function() {
         $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>


    <script>
        $(document).on('click', '.mark_as_unread_btn', function(){
            var project_msg_id = $(this).val();
            $.ajax({
                url: "<?php echo base_url('Message_controller/mark_as_unread/') ?>"+"/"+project_msg_id,
                success:function(data){
                    window.history.back();
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.reply-btn', function(){
            $('.reply-box').slideDown('fast');
            $('.msg-reply-frwrd').hide();
        });
        $(document).on('click', '.reply-cancel', function(){
            $('.reply-box').hide();
            $('.msg-reply-frwrd').show();
        });
    </script>
    

    <script>
        $(function(){
            $(document).on('submit','#reply_send',function(e){
                e.preventDefault();
                var form = $(this).serialize();
                $.ajax({
                    url: "<?php echo base_url('Project_controller/insert_reply') ?>",
                    data: form,
                    type: 'post',
                    success:function(data){
                        swal("Message added");
                        location.reload();
                    }
                });
            });
        });
    </script>

    
</body>
</html>