<!-- BEGIN HEADER -->
<?php include 'inc/header.php'; ?>
<?php 
$user_id = $this->session->userdata('user_id');
$designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;
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
        background: transparent;
    }
    .list-info{
        flex: 100px 0 0;
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
    .new-msg{
        margin-left: 10px;
    }
/*    .list-group-item{
        padding: 0 !important;
    }
    .list-group-item div:first-child{
        padding: 10px 15px !important;
    }*/
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
                        <a href="#">Project Messages</a>
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
                                <span class="caption-subject bold uppercase">Project Messages</span>
                            </div>
                        </div>
                        
                        <div class="portlet-body" id="messages_div_body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="btn-group message-actions">
                                            <label style="margin-bottom: 22px;" class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                <span></span>
                                            </label>
                                            <button class="fas fa-envelope btn btn-default mark_as_unread_selected_btn" data-toggle="tooltip" data-placement="bottom" title="Mark as unread"></button>
                                            <button class="fas fa-envelope-open btn btn-default mark_as_read_selected_btn" data-toggle="tooltip" data-placement="bottom" title="Mark as read"></button>

                                            <?php if(in_array($designation_id, [1,6])): ?>
                                            <button class="fas fa-archive btn btn-default archive_selected_btn" data-toggle="tooltip" data-placement="bottom" title="Set as archive"></button>
                                            <?php endif; ?>
                                            <!-- <button class="fas fa-trash btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Delete"></button> -->
                                            <?php if(in_array($designation_id, [1,6])): ?>
                                            <button class="btn btn-default btn-sm sort_by_me" value="0">Sort by me</button>
                                            <?php endif; ?>
                                           <!--  <?php if(in_array($designation_id, [1,6])): ?>
                                            <button class="btn btn-default btn-sm archive_msgs" value="0">Archives</button>
                                            <?php endif; ?> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control search" placeholder="Serach here">
                                    </div>
                                </div>
                            </div>
                            <div class="tabbable-line">
                                <ul class="nav nav-tabs ">
                                    <li class="msg_tab active" data-type="msg">
                                        <a href="#messages_div" data-toggle="tab" aria-expanded="false"> Messages </a>
                                    </li>
                                    <li class="msg_tab" data-type="reply">
                                        <a href="#replies" data-toggle="tab" aria-expanded="false"> Replies </a>
                                    </li>
                                    <?php if(in_array($designation_id, [1,6])): ?>
                                    <li class="msg_tab" data-type="archive">
                                        <a href="#archives" data-toggle="tab" aria-expanded="false"> Archives </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="messages_div">
                                        <form action="" method="POST" id="msg_action_form">
                                            <ul class="list-group list message_list"></ul>
                                        </form>
                                        <div id="pagination_link"></div>

                                    </div>
                                    <div class="tab-pane" id="replies">
                                        <form action="" method="POST" id="reply_action_form">
                                            <ul class="list-group list message_reply_list"></ul>
                                        </form>
                                        <div id="pagination_reply_link"></div>
                                    </div>

                                    <?php if(in_array($designation_id, [1,6])): ?>
                                    <div class="tab-pane" id="archives">
                                        <form action="" method="POST" id="archive_action_form">
                                            <ul class="list-group list message_archive_list"></ul>
                                        </form>
                                        <div id="pagination_archive_link"></div>
                                    </div>
                                    <?php endif; ?>
                                    
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
                    $('.msg-checkboxes').prop('checked', true);
                else
                    $('.msg-checkboxes').prop('checked', false);

            });
        })
    </script>

    <script>
        $(document).on('mouseenter', '.list-group-item', function( event ) {
            $(this).find('.list-date').hide();
            $(this).find('.list-action').show();
        }).on('mouseleave', '.list-group-item', function( event ) {
            $(this).find('.list-date').show();
            $(this).find('.list-action').hide();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>

<!--     <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
    <script>
        var options = {
            valueNames: [ 'msg_project_id' ]
        };

        var message_list = new List('messages_div_body', options);
    </script> -->

    <script>
        $(document).ready(function(){

            // project message
            function load_message_data(page, search = '', sort_by_me = '', is_archive = '')
            {
              $.ajax({
               url:"<?php echo base_url(); ?>Message_controller/get_message_pagination/"+page+'/'+search,
               data: {'sort_by_me': sort_by_me, 'is_archive': is_archive},
               method:"GET",
               dataType:"json",
               success:function(data)
               {
                $('#messages_div ul').html(data.html);
                $('#pagination_link').html(data.pagination_link);
               }
              });
            }

            function load_archives_data(page, search = '', sort_by_me = '', is_archive = 'true')
            {
              $.ajax({
               url:"<?php echo base_url(); ?>Message_controller/get_message_pagination/"+page+'/'+search,
               data: {'sort_by_me': sort_by_me, 'is_archive': is_archive},
               method:"GET",
               dataType:"json",
               success:function(data)
               {
                $('#archives ul').html(data.html);
                $('#pagination_archive_link').html(data.pagination_link);
               }
              });
            }

            var key = $('.search').val();
             
            load_message_data(1, key);
            load_archives_data(1, key);

           

            $(document).on("click", ".pagination-msg li a", function(event){
                event.preventDefault();
                var page = $(this).data("ci-pagination-page");
                load_message_data(page);
            });
            // project message





            function load_reply_data(page, search = '', sort_by_me = '')
            {
              $.ajax({
               url:"<?php echo base_url(); ?>Message_controller/get_reply_pagination/"+page+'/'+search,
               method:"GET",
               data: {'sort_by_me': sort_by_me},
               dataType:"json",
               success:function(data)
               {
                $('#replies ul').html(data.reply_html);
                $('#pagination_reply_link').html(data.pagination_reply_link);
               }
              });
            }

            var key = $('.search').val();

            load_reply_data(1, key);

            // sort by me
            $(document).on('click', '.sort_by_me', function(){
                var key = $('.search').val();
                var sort_by_me = $(this).val();


                if(sort_by_me == 0){
                    $(this).val(1);
                    $(this).html('Sort by all');
                    load_message_data(1, key, 'true');                
                    load_reply_data(1, key, 'true');  
                    load_archives_data(1, key, 'true');
                } else {
                    $(this).val(0);
                    $(this).html('Sort by me');
                    load_message_data(1, key, '');                
                    load_reply_data(1, key, '');                
                    load_archives_data(1, key, '');
                }
            });
            // end sort by me
            // 
            // 
            // sort by me
            $(document).on('click', '.archive_msgs', function(){
                var key = $('.search').val();
                var archive_msgs = $(this).val();
                var sort_by_me = $('.sort_by_me').val();
                sort_by_me = sort_by_me == 0 ? '' : 'true';
                if(archive_msgs == 0){
                    $(this).val(1);
                    $(this).html('All messages');
                    load_message_data(1, key, sort_by_me, 'true');                
                    load_reply_data(1, key, sort_by_me, 'true');                
                } else {
                    $(this).val(0);
                    $(this).html('Archives');
                    load_message_data(1, key, sort_by_me, '');                
                    load_reply_data(1, key, sort_by_me, '');                
                }
            });
            // end sort by me

            $(document).on("click", ".pagination-reply li a", function(event){
                event.preventDefault();
                var page = $(this).data("ci-pagination-page");
                load_reply_data(page);
            });


            $(document).on('keyup', '.search', function(){
                var keyword = $(this).val();
                load_message_data(1, keyword);
                load_reply_data(1, keyword);
            });

            $(document).on('click', '.mark_as_read_selected_btn', function(){
                var msgtype = $('.msg_tab.active').data('type');
                var form = $('#msg_action_form').serialize();


                if(form == ''){
                    swal('Please select a message');
                    return;
                }


                $.ajax({
                    url: "<?php echo base_url('Message_controller/mark_as_read/') ?>",
                    data: form  + "&msgtype="+msgtype,
                    type: 'POST',
                    success:function(data){
                        // alert(data);
                        var keyword = $('.search').val();
                        load_message_data(1, keyword);
                        load_reply_data(1, keyword);
                    }
                });
            });

            $(document).on('click', '.archive_selected_btn', function(){
                var msgtype = $('.msg_tab.active').data('type');
                var form = $('#msg_action_form').serialize();


                if(form == ''){
                    swal('Please select a message');
                    return;
                }


                $.ajax({
                    url: "<?php echo base_url('Message_controller/set_as_archive/') ?>",
                    data: form  + "&msgtype="+msgtype,
                    type: 'POST',
                    success:function(data){
                        // alert(data);
                        var keyword = $('.search').val();
                        load_message_data(1, keyword);
                        load_reply_data(1, keyword);
                        load_archives_data(1, keyword);

                    }
                });
            });

            $(document).on('click', '.mark_as_read_btn', function(){
                var project_msg_id = $(this).val();
                $.ajax({
                    url: "<?php echo base_url('Message_controller/mark_as_read/') ?>"+"/"+project_msg_id,
                    success:function(data){
                        var keyword = $('.search').val();
                        load_message_data(1, keyword);
                        load_archives_data(1, keyword);
                    }
                });
            });

            $(document).on('click', '.mark_as_read_reply_btn', function(){
                var project_msg_id = $(this).val();
                $.ajax({
                    url: "<?php echo base_url('Message_controller/mark_as_read_reply_btn/') ?>"+"/"+project_msg_id,
                    success:function(data){
                        var keyword = $('.search').val();
                        load_reply_data(1, keyword);
                    }
                });
            });

            $(document).on('click', '.mark_as_unread_selected_btn', function(){
                var form = $('#msg_action_form').serializeArray();
                if(form == ''){
                    swal('Please select a message');
                    return;
                }
                $.ajax({
                    url: "<?php echo base_url('Message_controller/mark_as_unread/') ?>",
                    data: form,
                    type: 'POST',
                    success:function(data){
                        var keyword = $('.search').val();
                        load_message_data(1, keyword);
                    }
                });
            });

            $(document).on('click', '.mark_as_unread_btn', function(){
                var project_msg_id = $(this).val();
                $.ajax({
                    url: "<?php echo base_url('Message_controller/mark_as_unread/') ?>"+"/"+project_msg_id,
                    success:function(data){
                        var keyword = $('.search').val();
                        load_message_data(1, keyword);
                        load_archives_data(1, keyword);

                    }
                });
            });

            $(document).on('click', '.mark_as_read_unread_btn', function(){
                var project_msg_id = $(this).val();
                $.ajax({
                    url: "<?php echo base_url('Message_controller/mark_as_reply_unread/') ?>"+"/"+project_msg_id,
                    success:function(data){
                        var keyword = $('.search').val();
                        load_reply_data(1, keyword);
                    }
                });
            });
        });
    </script>

    <script>
       
    </script>



    
</body>
</html>