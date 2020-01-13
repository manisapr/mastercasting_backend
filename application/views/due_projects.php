<?php //print_r($projects);die; ?>
            <!-- BEGIN HEADER -->
            <?php include 'inc/header.php'; ?>
<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .dt-button{
        display: inline-block;
        margin-bottom: 0;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        touch-action: manipulation;
        cursor: pointer;
        border: 1px solid transparent;
        white-space: nowrap;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857;
        border-radius: 4px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 3px;
        outline: 0!important;
        border-radius: 25px!important;
        overflow: hidden;
        background-color: #bb1d50 !important;
        border-color: #701130 !important;
        color: #FFF;
        margin-right: 10px;
    }
    .dt-button:hover{
        text-decoration: none;
        color: white;
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
                        <!-- BEGIN THEME PANEL -->
                        <div class="theme-panel hidden-xs hidden-sm">
                        </div>
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo base_url()?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <a href="#">Projects</a>
                                </li>
                               
                            </ul>
                            <div class="page-toolbar">
                               
                            </div>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2))); ?>
                            <small>managed datatable samples</small>
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase"> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2))); ?> Table</span>
                                        </div>
                                       <!--  <div class="actions">
                                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                    <input type="radio" name="options" class="toggle" id="option1">My Clients</label>
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm  active">
                                                    <input type="radio" name="options" class="toggle" id="option2">All</label>
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                    <input type="radio" name="options" class="toggle" id="option2">My Jobs</label>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-toolbar">
                                            <div class="row">
                                                <form action="<?php echo base_url('projects/due_projects') ?>" method="POST">
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="dates">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button class="btn btn-circle btn-sm green">save</button>
                                                    </div>
                                                    <!-- <div class="col-md-1">
                                                        <button class="btn btn-circle btn-sm green print">Print Report</button>
                                                    </div> -->
                                                </form>
                                            </div>
                                        </div>
                                        <table class="table table-condensed table-bordered table-hover table-checkable order-column" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th> # </th>
                                                    <th style="text-align: center;"> Job Id </th>
                                                    <th> Job </th>
                                                    <th> Client </th>
                                                    <th> Dis </th>
                                                    <th> In Dis </th>
                                                    <th> Cad Status </th>
                                                    <th> ETA </th>
                                                    <th> Deadline </th>
                                                    <th style="text-align: center;"> Status </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $odd = 'odd';
                                                $cnt = 1;
                                                $total_rows = count($projects);
                                                $num_of_digit = (int) strlen((string)$total_rows);
                                                foreach ($projects as $key) :
                                                    $odd = $odd == 'odd' ? 'even' : 'odd';
                                                 ?>
                                                 <?php 
                                                switch ($key->cad_progress) {
                                                    case 'On Hold':
                                                        $cad_progress_color = '';
                                                        # code...
                                                        break;
                                                    case 'Ready':
                                                        $cad_progress_color = 'badge-success';
                                                        break;
                                                    case 'In Progress':
                                                        $cad_progress_color = 'badge-primary';
                                                        break;
                                                    case '3D Printing Only':
                                                        $cad_progress_color = 'badge-primary';
                                                        break;
                                                    
                                                }
                                                ?>
                                                <tr class="<?= $odd ?> gradeX" onclick="window.location='<?= site_url('projects/project_details/'.$key->project_id)?>';" style='cursor:pointer'>
                                                    <td>
                                                        <?php 
                                                        // $num_of_digit_cnt = (int) strlen((string)$cnt);
                                                        if($num_of_digit > (int) strlen((string)$cnt))
                                                            echo str_repeat("0", $num_of_digit - (int) strlen((string)$cnt)).$cnt;
                                                        else
                                                            echo $cnt
                                                         ?>
                                                    </td>

                                                    <td>
                                                        <span class="badge badge-success"><?php echo $key->project_id ?></span>
                                                    </td>

                                                    <td>
                                                        <?= $key->title ?>
                                                        <?php if($key->is_api_injected == 1): ?>
                                                        <i style="color: #1BBC9B;font-weight: bold; margin-left: 5px;" class="fas fa-cogs"></i>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if($key->asign_user == 0) 
                                                            echo '';
                                                        else{
                                                            $client = $this->db->get_where('user',['id' => $key->asign_user])->row();  
                                                            if($client->designation_id == 7)
                                                                echo $client->company_name.' ('.$client->name.')';
                                                            else
                                                                echo $client->name;
                                                        }
                                                        ?>
                                                    </td>
                                                


                                                    <td>
                                                        <?php $disposition = $this->db->query("SELECT * FROM `project_disposition` WHERE project_id = $key->project_id AND flag = 1 ORDER by project_disposition_id DESC")->row();  ?>
                                                        <?php 
                                                        if(count($disposition) == 0){
                                                            $disposition = $this->db->query("SELECT * FROM `project_disposition` WHERE project_id = $key->project_id ORDER by project_disposition_id ASC")->row();
                                                        }

                                                         ?>
                                                        <?php $disposition_id = count($disposition) == 0 ? '' : $disposition->disposition_id ?>
                                                        <?php echo $disposition_id == '' ? '' : $this->db->get_where('disposition',['disposition_id' => $disposition_id])->row()->name ?>
                                                    </td>


                                                    <td>
                                                        <?php $project_disposition_internal = $this->db->query("SELECT * FROM `project_disposition_internal` WHERE project_id = $key->project_id AND flag = 1 ORDER by project_disposition_id DESC")->row();  ?>
                                                        <?php 
                                                        // if(count($project_disposition_internal) == 0){
                                                        //     // $project_disposition_internal = $this->db->query("SELECT * FROM `project_disposition_internal` WHERE project_id = $key->project_id ORDER by project_disposition_id ASC")->row();
                                                        //     // $project_disposition_internal = '';

                                                        // }

                                                         ?>
                                                        <?php $project_disposition_id = count($project_disposition_internal) == 0 ? '' : $project_disposition_internal->disposition_id ?>
                                                        <?php echo $project_disposition_id == '' ? 'NA' : $this->db->get_where('disposition',['disposition_id' => $project_disposition_id])->row()->name ?>
                                                    </td>


                                                    <td style="text-align: center"><span class="badge <?php echo $cad_progress_color ?>"><?php echo $key->cad_progress ?></span></td>


                                                    
                                                    <td>
                                                        <?php
                                                        if($key->deadline != '0000-00-00'){
                                                            if($key->deadline > date('Y-m-d'))
                                                                echo '+ '.timespan(time(),strtotime($key->deadline), 1);
                                                            else
                                                                echo '- '.timespan(strtotime($key->deadline), time(), 1);
                                                        }
                                                        ?>
                                                    </td>


                                                    <td><?= $key->deadline == '0000-00-00' ? 'No deadline' : $key->deadline  ?></td>
                                                    

                                                    <!-- <td><?php echo date('m-d-Y H:i:s',strtotime($key->created_at)) ?></td> -->
                                                    <?php 
                                                    switch ($key->type) {
                                                        case 'live':
                                                            $state = 'info';
                                                            break;
                                                        case 'cancelled':
                                                            $state = 'danger';
                                                            break;
                                                        case 'proposal':
                                                            $state = 'secondary';
                                                            break;
                                                        case 'completed':
                                                            $state = 'success';
                                                            break;
                                                    }
                                                     ?>
                                                    <td style="text-align: center;"><span class="badge badge-<?php echo $state ?>"><?= ucwords($key->type) ?></span></td>

                                                </tr>
                                                <?php $cnt++; endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                       

                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
          
            <!-- END FOOTER -->
        </div>
            </div>
        </div>
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>/assets/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>/assets/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url();?>/assets/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>/assets/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>/assets/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });

                $(document).ready(function() {
                    $('#example').DataTable();
                } );
            })
        </script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            jQuery.noConflict();
            (function($){
                $('input[name="dates"]').daterangepicker();
            })(jQuery);
        </script>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" integrity="sha256-gJWdmuCRBovJMD9D/TVdo4TIK8u5Sti11764sZT1DhI=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha256-DupmmuWppxPjtcG83ndhh/32A9xDMRFYkGOVzvpfSIk=" crossorigin="anonymous"></script>
        <script>
            function demoFromHTML() {
                var pdf = new jsPDF('p', 'pt', 'letter');
                // source can be HTML-formatted string, or a reference
                // to an actual DOM element from which the text will be scraped.
                source = $('#example')[0];

                // we support special element handlers. Register them with jQuery-style 
                // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
                // There is no support for any other type of selectors 
                // (class, of compound) at this time.
                specialElementHandlers = {
                    // element with id of "bypass" - jQuery style selector
                    '#bypassme': function (element, renderer) {
                        // true = "handled elsewhere, bypass text extraction"
                        return true
                    }
                };
                margins = {
                    top: 80,
                    bottom: 60,
                    left: 10,
                    width: 700
                };
                // all coords and widths are in jsPDF instance's declared units
                // 'inches' in this case
                pdf.fromHTML(
                source, // HTML string or DOM elem ref.
                margins.left, // x coord
                margins.top, { // y coord
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': specialElementHandlers
                },

                function (dispose) {
                    // dispose: object with X, Y of the last line add to the PDF 
                    //          this allow the insertion of new lines after html
                    pdf.save('Test.pdf');
                }, margins);
            }

            $(document).on('click', '.print', function(){
                demoFromHTML();
            });
        </script> -->
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
        <script>
          
            $('#myTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'pdf', 'print'
                ]
            });
        </script>
    </body>

</html>