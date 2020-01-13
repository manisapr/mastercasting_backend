<?php $segment1 = $this->uri->segment(1); ?>
<?php $segment = $this->uri->segment(2); ?>
<?php $segment2 = $this->uri->segment(3); ?>
<?php $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id; ?>
<?php $comp_des = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->comp_des; ?>
<?php //$designing = $this->db->get_where('user', ['id' => ])->row(); ?>
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            
            <li class="nav-item start <?= $segment1 == 'dashboard' ? 'active' : ''  ?>">
                <a href="<?php echo site_url('dashboard');?>" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                    <!-- <span class="arrow"></span> -->
                </a>
            </li>
            <!-- <li class="heading">
                <h3 class="uppercase">Projects</h3>
            </li> -->
            <li class="nav-item <?= in_array($segment, ['project','project_edit','project_details','add_project','all_projects','complete_projects','cancel_projects','live_projects','proposal_projects', 'estimated_projects', 'api_projects', 'shipping_list', 'due_projects']) ? 'active' : ''  ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-wallet"></i>
                    <span class="title ">Project</span>
                    <span class="arrow"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <?php if(!in_array($designation_id, [9])): ?>
                    <li class="nav-item <?= in_array($segment, ['add_project']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/add_project');?>" class="nav-link ">
                            <span class="title">Add Projects</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item <?= in_array($segment, ['project','all_projects']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/all_projects');?>" class="nav-link ">
                            <span class="title">All Projects</span>

                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment, ['project','proposal_projects']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/proposal_projects');?>" class="nav-link ">
                            <span class="title">Proposal Projects</span>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment, ['project','complete_projects']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/complete_projects');?>" class="nav-link ">
                            <span class="title">Complete Projects</span>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment, ['project','live_projects']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/live_projects');?>" class="nav-link ">
                            <span class="title">Live Projects</span>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment, ['project','cancel_projects']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/cancel_projects');?>" class="nav-link ">
                            <span class="title">Cancel Projects</span>
                        </a>
                    </li>

                    <?php if(in_array($designation_id, [1,6])): ?>
                    <li class="nav-item <?= in_array($segment, ['project','estimated_projects']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/estimated_projects');?>" class="nav-link ">
                            <span class="title">Estimate Projects</span>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment, ['project','api_projects']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/api_projects');?>" class="nav-link ">
                            <span class="title">Api Projects</span>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment, ['project','shipping_list']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/shipping_list');?>" class="nav-link ">
                            <span class="title">Ship Lists</span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if(in_array($designation_id, [1,6,8,10])): ?>
                    <li class="nav-item <?= in_array($segment, ['project','due_projects']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('projects/due_projects');?>" class="nav-link ">
                            <span class="title">Due Projects</span>
                        </a>
                    </li>
                    <?php endif; ?>

                </ul>
            </li>
            <?php if(in_array($designation_id, [1,6,8])): ?>
            <li class="nav-item <?= in_array($segment, ['all_team_members','client','trade','edit_trade','creare_trade','trade','retailer']) ? 'active' : ''  ?> <?= in_array($segment1,['retail_clients','trade_clients','all_team_members','all_cad','all_sales_rep','all_manager','company_list','get_user_by_company']) ? 'active' : ''  ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-user"></i>
                    <span class="title">Members</span>
                    <span class="arrow"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?= in_array($segment1, ['all_team_members','all_cad','all_sales_rep','all_manager']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('all_team_members');?>" class="nav-link ">
                            <span class="title">Team Members</span>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment1,['retail_clients']) ? 'open' : ''  ?> <?= in_array($segment,['retailer']) ? 'open' : ''  ?>" >
                        <a href="<?php echo site_url('retail_clients');?>" class="nav-link ">
                            <span class="title">Retailer Clients</span>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment1,['trade_clients']) ? 'open' : ''  ?>  <?= in_array($segment,['trade']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('trade_clients');?>" class="nav-link ">
                            <span class="title">Trade Clients</span>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment1,['company_list','get_user_by_company']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('company_list');?>" class="nav-link ">
                            <span class="title">Company List</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <?php if(in_array($designation_id, [1,6,8])): ?>
            <li class="nav-item <?= in_array($segment1,['view_dispositions']) ? 'active' : ''  ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-wrench"></i>
                    <span class="title">Settings</span>
                    <span class="arrow"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?= in_array($segment1, ['view_dispositions']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('view_dispositions');?>" class="nav-link ">
                            <span class="title">View Disposition</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <?php if($comp_des == 1): ?>
            <li class="nav-item <?= in_array($segment1,['view_associates', 'associate']) ? 'active' : ''  ?> <?= in_array($segment,['associate']) ? 'active' : ''  ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-wrench"></i>
                    <span class="title">Member</span>
                    <span class="arrow"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?= in_array($segment1, ['view_associates']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('view_associates');?>" class="nav-link ">
                            <span class="title">View Associates</span>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($segment, ['associate']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('create/associate');?>" class="nav-link ">
                            <span class="title">Add Associates</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <li class="nav-item <?= in_array($segment1,['Message_controller']) ? 'active' : ''  ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-envelope"></i>
                    <span class="title">Message</span>
                    <span class="arrow"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?= in_array($segment1, ['Message_controller']) ? 'open' : ''  ?>">
                        <a href="<?php echo site_url('Message_controller');?>" class="nav-link ">
                            <span class="title">View Message</span>
                        </a>
                    </li>
                </ul>
            </li>
          
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>