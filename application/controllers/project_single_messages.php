<!-- BEGIN HEADER -->
<?php include 'inc/header.php'; ?>
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
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum porro maxime, doloremque explicabo ipsam sequi odio mollitia officia. Voluptates voluptatibus cumque illum obcaecati tempore laboriosam optio ex ab sapiente, doloribus.
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
    <script>
        var options = {
            valueNames: [ 'msg_project_id' ]
        };

        var message_list = new List('messages_div_body', options);
    </script>


    
</body>
</html>