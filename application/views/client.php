
        <!-- BEGIN HEADER -->
        <?php include 'inc/header.php'; ?>
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
                                <a href="index.html">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                          
                            <li>
                                <a href="#">Clients</a>
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h1 class="page-title">Clients    
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
                                        <span class="caption-subject bold uppercase"> Managed Table</span>
                                    </div>
                                </div>
                                <?php $designation_id=$this->session->userdata('type'); 
                                if($designation_id=='1' || $designation_id=='6')    
                                    {                                                               
                                ?>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <button id="sample_editable_1_new" class="btn sbold green" data-toggle="modal" data-target="#exampleModalLong3"> Add Client <i class="fa fa-plus"></i> </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="btn-group pull-right">
                                                    <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-print"></i> Print </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                                <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th> Name </th>
                                                <th> Role </th>
                                                <th> Mail id </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php  
                                                foreach($get_data as $row)  
                                                {                   
                                                if($row->designation_name == 'Client')
                                                    {                   
                                                ?>
                                                    <tr class="odd gradeX">
                                                        <td>
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input type="checkbox" class="checkboxes" value="1" /> <span></span> </label>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo site_url('/Master_controllers/client_project_details/').$row->id; ?>">
                                                                <!-- <a href="<?php echo site_url(); ?>/Master_controllers/client_project_details?id=<?php echo $row->id; ?>"> -->
                                                                <!-- <a href="<?php echo site_url(); ?>/Master_controllers/client_project_details/<?php echo $row->id; ?>"> -->
                                                                <?php echo $row->name;?>
                                                            </a>
                                                        </td>
                                                        <td> <span class="label label-sm label-info"><?php echo $row->designation_name;?></span> </td>
                                                        <td> <a href="mailto:userwow@gmail.com"><?php echo $row->email;?></a> </td>
                                                        <?php 
                                                        }   
                                                        }   
                                                        ?>
                                                    </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php }                                 
                                    else                                    
                                    {                                       
                                echo "You are not an Authentic viewer to view this page.";          
                                }                                                               
                                ?>
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
    <!--[if lt IE 9]>       <script src="../assets/global/plugins/respond.min.js"></script><script src="../assets/global/plugins/excanvas.min.js"></script> <script src="../assets/global/plugins/ie8.fix.min.js"></script> <![endif]-->
    <div class="modal fade signup_pop" id="exampleModalLong2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <h4>Name of the Project</h4>
                    <form>
                        <div class="pro_url">
                            <input type="text" placeholder="Name"> </div>
                        <div class="tabgroup">
                            <input class="tabgroup__item tabgroup__item--1" type="radio" id="tab1" name="tabgroup_a" checked />
                            <label class="tab tab--1" for="tab1">Our Team</label>
                            <input class="tabgroup__item tabgroup__item--2" type="radio" id="tab2" name="tabgroup_a" />
                            <label class="tab tab--2" for="tab2">The Client</label>
                            <div class="panel panel--1">
                                <h5>Invite People to you team</h5>
                                <div class="inv_ppl">
                                    <input type="text" placeholder=""> </div>
                                <div class="inv_ppl">
                                    <input type="text" placeholder=""> </div>
                                <div class="inv_ppl">
                                    <input type="text" placeholder=""> </div>
                                <div class="price_pro">
                                    <label>Price</label>
                                    <input type="text"> </div>
                                <div class="pop_btn">
                                    <input type="submit" value="Start the project">
                                    <input type="Reset" value="Cancel"> </div>
                            </div>
                            <div class="panel panel--2">
                                <h5>Invite People to you team</h5>
                                <div class="inv_ppl">
                                    <input type="text" placeholder=""> </div>
                                <div class="inv_ppl">
                                    <input type="text" placeholder=""> </div>
                                <div class="inv_ppl">
                                    <input type="text" placeholder=""> </div>
                                <!-- <div class="price_pro"> -->
                                <!-- <label>Price</label> <input type="text"> -->
                                <!-- </div> -->
                                <div class="pop_btn">
                                    <input type="submit" value="Start the project">
                                    <input type="Reset" value="Cancel"> </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade signup_pop" id="exampleModalLong3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <h4>Add Member</h4>
                    <form  method="post" action="<?php echo site_url('Master_controllers/insert_user');?>" >
                    
                        <?php $rand_pass = substr(base64_encode(mt_rand()), 0, 10); //Rand password Code Gen ?>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label>
                            <input class="form-control" type="text" placeholder="Name" id="name" name="user_name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input class="form-control" type="email" placeholder="Email Id" id="email"  name="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Phone</label>
                            <input class="form-control" type="phone" placeholder="Phone No." id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Designation</label>
                            <select class="form-control" name="sample_1_length" aria-controls="sample_1" class="form-control input-sm input-xsmall input-inline">
                                <option>Select Designation</option>
                                <option value="1">Admin</option>
                                <option value="2">Designing</option>
                                <option value="3">Casting</option>
                                <option value="4">Packing</option>
                                <option value="5">Client</option>
                                <option value="6">Manager</option>
                            </select>
                        </div>
                        <div class="inv_ppl">
                            <input type="hidden" placeholder="Password" name="password" value="<?php echo $rand_pass;?>">
                        </div>
                        <div class="tabgroup">
                            <div class="pop_btn">
                                <input type="submit" class="btn blue" value="Submit"  onclick='Javascript:validedData();'>
                                <input class="btn default" type="Reset" value="Cancel">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
            $('#clickmewow').click(function() {
                $('#radio1003').attr('checked', 'checked');
            });
        })
    </script>
    
    
    <script>
    function validedData(){
    var name = document.getElementById('name');
    if(name.value=="")
    {
      alert("Enter Your Name Please");
      return false;
    }
     if(!(isNaN(name.value)))
    {
      alert("Please Enter Only Characters");
      return false;
    }   
    if ((name.value.length < 5) || (name.value.length > 15))
      {
        alert("Your Character must be 5 to 15 Character");
        return false;
      } 
    var email = document.getElementById('email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(email.value=="")
    {
        alert("Enter Email Please");
        return false;
    }

    if (!filter.test(email.value)) {
    alert('Please provide a valid email address');
    email.focus;
    return false;
 }
     var phone1 = document.getElementById('phone');
      if(phone1.value=="")
      {
        alert("Enter Your Phone Number Please");
        return false;
      }
      if(isNaN(phone1.value))
        {
        alert("Enter the valid Mobile Number(Like : 9566137117)");
        return false;
          }
        if(!(phone1.value.length==10))
            {
            alert(" Your Mobile Number must be 1 to 10 Integers");
            return false;
            }   
        
    }
    
    </script>
</body>

</html>