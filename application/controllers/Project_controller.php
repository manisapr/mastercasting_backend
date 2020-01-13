<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

// date_default_timezone_set('America/Chicago');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);


class Project_controller extends CI_Controller
{

    /**
     * @param $type_of_change
     *
     */

    public $type_of_change = ['project_type' => 1];
    // private $email_form = 'apache@mastercastingandcad.com';
    private $email_form = 'oscar@www.mastercastingandcad.com';

    private $token = 'ZOHvhZew9RsAAAAAAAMe4e9fGDhEztrHRC6jx3CBtCLUqMvIn_4viH9dh8i50YwD';
    // private $token = '7MWwEpOYc2AAAAAAAAAAN-s7OA77K9tz_hab5KjXAZdJAd_vj5UNHbJ0gNK-FRL-';


    public function __construct()
    {
        parent::__construct();
        $this->load->model('projectmodel');
        $this->load->model("member_model");
        $this->load->model("message_model");
        $this->load->library('email');

        $this->session->keep_flashdata('cad_progress');

        date_default_timezone_set('Asia/Calcutta');
    }

    private function email_config()
    {
        // return $config = array(
        //     'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
        //     'smtp_host' => 'email-smtp.us-west-2a.amazonaws.com',
        //     'smtp_port' => 465,
        //     'smtp_user' => 'AKIA5VUTQDVIZN35QZH2',
        //     'smtp_pass' => 'BMTvxHTmGWk1PI2DVs1Flqu4Q76fCwbhcrUl/k+b35tL',
        //     // 'smtp_crypto' => 'tsl', //can be 'ssl' or 'tls' for example
        //     'mailtype' => 'html', //plaintext 'text' mails or 'html'
        //     'smtp_timeout' => '4', //in seconds
        //     'charset' => 'iso-8859-1',
        //     'wordwrap' => TRUE
        // );
        return $config = array(
            'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
            'smtp_host' => 'smtp.mailgun.org',
            'smtp_port' => 2525,
            'smtp_user' => 'postmaster@www.mastercastingandcad.com',
            'smtp_pass' => '89e954a6422e1797b501ea7f2cbdbee1-87cdd773-1c23fff2',
            // 'smtp_crypto' => 'tsl', //can be 'ssl' or 'tls' for example
            'mailtype' => 'html', //plaintext 'text' mails or 'html'
            'smtp_timeout' => '4', //in seconds
            'charset' => 'iso-8859-1',
            'wordwrap' => true
        );
    }

    public function login_check()
    {
        if (!$this->session->userdata('user_id')) {
            return redirect();
        }
    }

    public function self_project_check($project_id)
    {
        $chk = $this->projectmodel->check_self_project($project_id);
        if (!$chk) {
            return redirect();
        }
    }
    
    public function permission_by_designation($designations = [])
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

        if (!in_array($designation_id, $designations)) {
            return redirect('dashboard');
        }
    }

    public function index()
    {
        if (!$this->session->userdata('user_id')) {
            return redirect();
        }
        $this->load->view('all_jobs');
    }

    public function upload($filename, $tmp_name)
    {
        $this->load->library('aws3');
        $image_data['file_name'] = $this->aws3->sendFile('castingandcad', $filename, $tmp_name);
        if ($image_data['file_name'] == '') {
            return false;
        } else {
            return $image_data['file_name'];
        }
    }

    public function all_projects()
    {

        $this->login_check();

        $keyword = $this->input->get('query');
        
        if ($keyword == '') {
            if ($this->client_approval()) {
                $data['projects'] = $this->projectmodel->get_all_projects();
            } else {
                $data['projects'] = $this->projectmodel->get_all_projects(true);
            }
        } else {
            $user_id = $this->session->userdata('user_id');
            $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;
            if (in_array($designation_id, [1,6,8])) {
                $data['projects'] = $this->db->query("SELECT DISTINCT `project`.`project_id`, `project`.`project_name` FROM `project` JOIN `user` WHERE `project`.`project_name` LIKE '%$keyword%' OR `project`.`project_id` LIKE '%$keyword%' OR `user`.`name` LIKE '%$keyword%' OR `project`.`dynamic_id` LIKE '%$keyword%'")->result();
            } else {
                // $data['projects'] = $this->db->query("SELECT DISTINCT `project`.`project_id`, `project`.`project_name` FROM `project` JOIN `user` JOIN `project_details` WHERE (`project`.`assign_by` = $user_id OR `project`.`asign_user` = $user_id OR FIND_IN_SET('$user_id', `assignee`)) AND (`project`.`project_name` LIKE '%$keyword%' OR `project`.`project_id` LIKE '%$keyword%' OR `user`.`name` LIKE '%$keyword%')")->result();
                $data['projects'] = $this->db->query("SELECT * FROM `project` JOIN `project_details` ON `project`.`project_id` = `project_details`.`project_id` WHERE ( `assign_by` = '$user_id' OR `asign_user` = '$user_id' OR FIND_IN_SET('$user_id', `assignee`) ) AND (`project`.`project_name` LIKE '$keyword%' OR `project`.`project_id` LIKE '%$keyword%') ORDER BY `created_at` DESC")->result();
            }
            // echo "<pre>";
            $id = array_column($data['projects'], 'project_id');

            if (!empty($id)) {
                $data['projects'] = $this->db->order_by('created_at', 'desc')
                                    ->join('project_details', 'project.project_id = project_details.project_id')
                                    ->where_in('project.project_id', $id)
                                    ->get('project')
                                    ->result();
            } else {
                    $data['projects'] = $this->projectmodel->get_all_projects();
                // if ($this->client_approval()) {
                // } else {
                //     $data['projects'] = $this->projectmodel->get_all_projects(true);
                // }
            }
            // print_r($id);die;
        }
        // print_r($data['projects']);die;
        $this->load->view('all_projects', $data);
    }

    public function complete_projects()
    {
        $this->login_check();
        if ($this->client_approval()) {
            $data['projects'] = $this->projectmodel->get_complete_projects();
        } else {
            $data['projects'] = $this->projectmodel->get_complete_projects(true);
        }

       
        $this->load->view('all_projects', $data);
    }

    public function proposal_projects()
    {
        $this->login_check();
        if ($this->client_approval()) {
            $data['projects'] = $this->projectmodel->get_all_proposal_projects();
        } else {
            $data['projects'] = $this->projectmodel->get_all_proposal_projects(true);
        }

       
        $this->load->view('all_projects', $data);
    }

    public function live_projects()
    {
        $this->login_check();
        if ($this->client_approval()) {
            $data['projects'] = $this->projectmodel->get_live_projects();
        } else {
            $data['projects'] = $this->projectmodel->get_live_projects(true);
        }

       
        $this->load->view('all_projects', $data);
    }

    public function cancel_projects()
    {
        $this->login_check();
        if ($this->client_approval()) {
            $data['projects'] = $this->projectmodel->get_cancelled_projects();
        } else {
            $data['projects'] = $this->projectmodel->get_cancelled_projects(true);
        }

       
        $this->load->view('all_projects', $data);
    }

    public function due_projects(){

        $this->login_check();
        
        $this->permission_by_designation([1,6,8,10]);
        
        if($this->input->post('dates')){
            $date = $this->input->post('dates');
            $date = explode('-', $date);
            $start_date = date('Y-m-d', strtotime($date[0]));
            $end_date = date('Y-m-d', strtotime($date[1]));

            $data['projects'] = $this->db->query("SELECT * from project JOIN project_details on `project`.project_id = `project_details`.project_id where (`deadline` between '$start_date' and '$end_date') and `type` not in ('completed', 'cancelled')")->result();
            // echo $this->db->last_query();
            // die;
        } else {
            $date = date('Y-m-d');
            $data['projects'] = $this->db->query("SELECT * from project JOIN project_details on `project`.project_id = `project_details`.project_id where `deadline` = '$date' and `type` not in ('completed', 'cancelled')")->result();
        }
        

        // $data['query'] = $this->db->last_query();

        $this->load->view('due_projects', $data);
    }
    
    public function add_project($is_user_id_set = false)
    {
        $this->login_check();

        $data = $this->project_meta_fileds();

        if ($is_user_id_set) {
            $data['is_user_id_set'] = $is_user_id_set;
        } else {
            $data['is_user_id_set'] = false;
        }

        // echo $data['is_user_id_set'];die;

        $project_files_temp = $this->db->get('project_files_temp')->result();
        foreach ($project_files_temp as $key) {
            // $cnt = $this->db->get_where('project_files', ['file_name' => $key->file_name])->num_rows();
            // if($cnt < 1)
                // echo $key->project_files_temp_id;
            $this->delete_krajee_cad_img($key->project_files_temp_id);
        }

        $data['client_approval'] = $this->client_approval('designation_id');
        $data['dynamic_id'] = $this->dynamic_id();
        $this->load->view('add_projects', $data);
    }

    public function add_project_action()
    {
        $this->login_check();
        // die;

        $project_specification = $this->input->post('project_specification');
        // print_r($project_specification);die;

        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        $project_details = $this->input->post('project_details');

        $project_details['deadline'] = date('Y-m-d', strtotime($project_details['deadline']));
        $today = date('Y-m-d');

        $critical_begin = date('Y-m-d', strtotime($today));
        $critical_end   = date('Y-m-d', strtotime($today. ' +3 day'));

        $rush_begin = date('Y-m-d', strtotime($today. ' +4 day'));
        $rush_end   = date('Y-m-d', strtotime($today. ' +7 day'));

        $standard_begin = date('Y-m-d', strtotime($today. ' +8 day'));
        $standard_end   = date('Y-m-d', strtotime($today. ' +12 day'));

        if (($project_details['deadline'] >= $critical_begin) && ($project_details['deadline'] <= $critical_end)) {
            $project_details['priority'] = 'critical';
        } elseif (($project_details['deadline'] >= $rush_begin) && ($project_details['deadline'] <= $rush_end)) {
            $project_details['priority'] = 'high';
        } elseif (($project_details['deadline'] >= $standard_begin)) {
            $project_details['priority'] = 'standard';
        }

        // print_r($project_details);die;



        $permissions = $this->input->post('permissions');
        // print_r($project_details['assignee']);
        // if(isset($project_details['assignee'])){
        //  foreach ($project_details['assignee'] as $key => $value) {
        //      $permission_data['user_id'] = $value;
        //      $permission_data['permission_id'] = $permissions['permission_id'][$key];
        //      $permission_data['level'] = $permissions['level'][$key];
        //      $this->member_model->insert_permission($permission_data);
        //  }
        // }

        $project_details['assignee'] = isset($project_details['assignee']) ? implode(',', $project_details['assignee']) : '';
        
        //insert project
        $project = $this->input->post('project');
        $project['project_name'] = $project_details['title'];
        $project['price'] = $project_details['price'];
        $project['assign_by'] = $user_id;
        // // $project['dynamic_id'] = $this->dynamic_id();
        // print_r($project);die;


        //if designation id in client trade or retail then asign user
        if (in_array($designation_id, [5,7])) {
            $project['asign_user'] = $user_id;
        }

        $project_details['internal_deadline'] = date("Y-m-d H:i:s", strtotime("+1 week"));
        // print_r($project_details);die;

        $last_insert_id = $this->projectmodel->insert_project($project);
        if ($last_insert_id === false) {
            return "error";
        }
        
        // new project details
        $project_details['project_id'] = $last_insert_id;
        $project_details['updated_at'] = date('Y-m-d H:i:s');
        $project_details['type'] = 'proposal';

        // print_r($project_details);die;
        $result = $this->projectmodel->insert_project_details($project_details);
        if ($result === false) {
            return "error";
        }

        if (isset($project_details['request_estimate'])) {
            if ($project_details['request_estimate'] == 1) {
                $this->projectmodel->insert_new_estimated_project_tracking($last_insert_id);
            }
        }

        // $project_specification
        $project_specification = $this->input->post('project_specification');

        if ($project_specification) {
            $project_specification['project_id'] = $last_insert_id;
            $result = $this->projectmodel->insert_project_specification($project_specification);
            if ($result === false) {
                return "error";
            }
        }


        $cadFilesData = $this->db->get_where('project_files_temp', ['dynamic_id' => $project['dynamic_id'], 'type' => 'cad'])->result();

        foreach ($cadFilesData as $key) {
            $this->db->insert('project_files', ['project_id' => $last_insert_id, 'type' => 'cad', 'file_name' => $key->file_name, 'user_id' => $project['assign_by']]);
        }

        $picFilesData = $this->db->get_where('project_files_temp', ['dynamic_id' => $project['dynamic_id'], 'type' => 'pic'])->result();
        foreach ($picFilesData as $key) {
            $this->db->insert('project_files', ['project_id' => $last_insert_id, 'type' => 'pic', 'file_name' => $key->file_name, 'user_id' => $project['assign_by']]);
        }

       
        // i don't remember what i did here

        // $project_msg = $this->input->post('project_msg');
        // $project_msg['project_id'] = $last_insert_id;
        // $project_msg['msg_by'] = $user_id;
        // if ($project_msg['msg'] != '') {
        //     $this->projectmodel->insert_project_msg($project_msg);
        // }

        //insert disposition
        $disp = [44, 45, 46, 3, 47, 48, 49, 50];
        foreach ($disp as $key) {
            $this->db->insert('project_disposition', ['project_id' => $last_insert_id, 'disposition_id' => $key]);
        }

        //insert disposition
        $intrnl_disp = [63, 9, 85, 78, 10, 70];
        foreach ($intrnl_disp as $key) {
            $this->db->insert('project_disposition_internal', ['project_id' => $last_insert_id, 'disposition_id' => $key]);
        }


        $project = $this->projectmodel->get_project($last_insert_id);
        $project_details = $this->projectmodel->get_project_details($last_insert_id);
        $project_specification = $this->projectmodel->get_project_specification($last_insert_id);
        $project_files = $this->projectmodel->get_project_files($last_insert_id);

        $this->db->insert('project_description_history', ['project_id' => $last_insert_id, 'description' => $project_details->description]);

        ob_start(); ?>
        
        <h3>Project added by <?php echo $this->db->get_where('user', ['id' => $project->assign_by])->row()->name ?></h3>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Document</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <style>
                .alert{
                    padding: 1px 8px;
                    margin: 0px;
                    font-weight: bold;
                    position: relative;
                    border: 1px solid transparent;
                    border-radius: .25rem;
                    color: #004085;
                    background-color: #cce5ff;
                    border-color: #b8daff;
                }
                p{
                    margin: 0px 25px;
                    padding: 2px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Project Details</h2>

                        <div class="alert alert-primary">Title</div>
                        <p><?php echo $project_details->title ?></p>
                        
                        <div class="alert alert-primary">Po</div>
                        <p><?php echo $project_details->po ?></p>

                        <div class="alert alert-primary">Price</div>
                        <p><?php echo $project_details->price ?></p>

                        <div class="alert alert-primary">Deadline</div>
                        <p><?php echo $project_details->deadline ?></p>

                        <div class="alert alert-primary">Priority</div>
                        <p><?php echo $project_details->priority ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <h2>Project Specification</h2>
                        
                        <div class="alert alert-primary">Purity</div>
                        <p><?php echo $project_specification->purity ?></p>

                        <div class="alert alert-primary">Finish</div>
                        <p><?php echo $project_specification->finish ?></p>

                        <div class="alert alert-primary">Ring size</div>
                        <p><?php echo $project_specification->ring_size ?></p>

                        <div class="alert alert-primary">Plating</div>
                        <p><?php echo $project_specification->plating ?></p>
            
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php

        $html = ob_get_clean();

        $this->send_add_project_email($html, $project_files);


        $this->session->set_flashdata(['project_insert' => 'success']);
        redirect('projects/project_details/'.$last_insert_id);
    }

    public function project_details($id)
    {
        $this->login_check();
        $this->self_project_check($id);

        $this->ship_generate($id);

        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;
        

        $data = $this->project_meta_fileds();
        $data['project'] = $this->projectmodel->get_project($id);
        $data['project_details'] = $this->projectmodel->get_project_details($id);
        $data['project_ship'] = $this->projectmodel->get_project_ship($id);
        // print_r($data['project_ship']);die;
        $data['project_specification'] = $this->projectmodel->get_project_specification($id);
        $data['project_msg'] = $this->projectmodel->get_project_msg($id);
        $data['completed'] = $data['project_details']->type == 'completed' ? true : false;
        
        if (in_array($designation_id, [1, 6, 8])) {
            $data['project_notes'] = $this->projectmodel->get_project_notes($id);
        }

        $data['project_disposition'] = $this->projectmodel->disposition_details($id);
        $data['project_disposition_internal'] = $this->projectmodel->disposition_details_internal($id);
        $data['project_pdf_disposition_internal'] = $this->projectmodel->disposition_details_internal($id);
        $data['project_files'] = $this->projectmodel->get_project_files($id);
        $data['project_archive_files'] = $this->projectmodel->get_project_archive_files($id);
        $data['project_activity_log'] = $this->projectmodel->get_project_activity_log($id);
        $data['print_project_details'] = $this->projectmodel->get_print_project_details($id);
        $data['project_archive_group'] = $this->projectmodel->get_project_archive_group($id);

       
        //ship oct 03
        $data['is_all_ship_form_filed_up'] = $this->projectmodel->is_all_ship_form_filed_up($id);
        $data['client_address'] = $this->projectmodel->get_client_address($id);
        $data['mcc_address'] = $this->projectmodel->get_mcc_address();
        $data['ship_services'] = $this->get_ship_services($id, $data['project_ship']->shipping_type);
        //ship end
        //ship nov 18
        $data['countries'] = $this->projectmodel->get_all_countries();
        // print_r($data['countries']);die;
        //ship end





        $data['project_description_history'] = $this->db->order_by('created_at', 'DESC')->get_where('project_description_history', ['project_id' => $id])->result();

        $data['project_specification_history'] = $this->db->order_by('created_at', 'DESC')->get_where('project_specification_history', ['project_id' => $id])->result();

        $data['cad_slots'] = $this->projectmodel->get_cad_slots_by_project_id($id);
        // $data['cad_3d_print_date'] = $this->projectmodel->get_cad_3d_print_date_by_project_id($id);

        // getting cad for project
        $data['project_cad_member'] = [];
        $assignee = $this->db->get_where('project_details', ['project_id' => $id])->row()->assignee;
        if ($assignee != '') {
            $assignee = explode(',', $assignee);
            foreach ($assignee as $key) {
                $assignee_des = $this->db->get_where('user', ['id' => $key])->row()->designation_id;
                if ($assignee_des == 9) {
                    array_push($data['project_cad_member'], $key);
                }
            }
        }

        // print_r($data['project_cad_member']);die;


        if ($designation_id == 1) {
            $this->db->update('project_details', ['seen' => 1], ['project_id' => $id]);
        }


        $data['member_permission'] = true;

        //for salse rep
        if ($designation_id == 8) {
            $project_assinee = explode(',', $data['project_details']->assignee);

            if (!in_array($user_id, $project_assinee)) {
                $data['member_permission'] = false;
            }
        }

         //for cad team
        if ($designation_id == 9) {
            $data['member_permission'] = false;
        }


        //last seen by client update
        if (in_array($designation_id, [5,7]) && $user_id == $data['project']->asign_user) {
            $last_seen_by_client = date('Y-m-d H:i:s');
            $this->db->query("UPDATE `project_details` SET `last_seen_by_client` = NOW() WHERE `project_id` = '$id'");
        }


        //cad check
        if (in_array($designation_id, [1,6,9])) {
            $data['cad_check'] = $this->projectmodel->cad_priority_check($id);
        }

        $data['project_dispositions'] = $this->load->view('project_dispositions', $data, true);
        $data['project_dispositions_internal'] = $this->load->view('project_dispositions_internal', $data, true);
        $data['project_details_upload_image_section'] = $this->load->view('project_details_upload_image_section', $data, true);
        $data['project_details_archive_section'] = $this->load->view('project_details_archive_section', $data, true);
        $data['project_details_message_section'] = $this->load->view('project_details_message_section', $data, true);
        $data['project_details_note_section'] = $this->load->view('project_details_note_section', $data, true);
        $data['project_details_print_section'] = $this->load->view('project_details_print_section', $data, true);
        $data['project_details_vendor_section'] = $this->load->view('project_details_vendor_section', $data, true);
        $data['project_details_activity_section'] = $this->load->view('project_details_activity_section', $data, true);
        $data['project_details_ship'] = $this->load->view('project_details_ship', $data, TRUE);


        return $this->load->view('project_details', $data);
    }


    private function ship_generate($project_id){
        $ship_cnt = $this->db->get_where('ship', ['project_id'  => $project_id])->row();

        if(!empty($ship_cnt))
            return;

        $this->db->insert('ship', ['project_id' => $project_id]);
    }

    public function update_project($id)
    {
        $this->login_check();

        $data = $this->project_meta_fileds();
        $data['project'] = $this->projectmodel->get_project($id);
        $data['project_details'] = $this->projectmodel->get_project_details($id);
        $data['project_specification'] = $this->projectmodel->get_project_specification($id);
        $data['project_msg'] = $this->projectmodel->get_project_msg($id);
        return $this->load->view('update_project', $data);
    }


    public function update_project_action($project_id)
    {
        $this->login_check();

        $user_id = $this->session->userdata('user_id');

        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;


        // print_r($cad_slot_date);die;
        $project_details = $this->input->post('project');

        $project_created_at = $this->db->get_where('project_details', ['project_id' => $project_id])->row()->created_at;


        // 26 oct 2019
        $project_type = $this->db->get_where('project_details', ['project_id' => $project_id])->row()->type;

        if($project_type == 'completed'){
            $this->db->update('project_details', ['type' => $project_details['type']], ['project_id' => $project_id]);
            return redirect('projects/project_details/'.$project_id);
        }


        // deadline assignne update
        if (!in_array($designation_id, [5,7])) {
            $project_details['deadline'] = date('Y-m-d', strtotime($project_details['deadline']));
            $project_details['internal_deadline'] = date('Y-m-d', strtotime($project_details['internal_deadline']));

            $critical_begin = date('Y-m-d', strtotime($project_created_at));
            $critical_end   = date('Y-m-d', strtotime($project_created_at. ' +3 day'));

            $rush_begin = date('Y-m-d', strtotime($project_created_at. ' +4 day'));
            $rush_end   = date('Y-m-d', strtotime($project_created_at. ' +7 day'));

            $standard_begin = date('Y-m-d', strtotime($project_created_at. ' +8 day'));
            $standard_end   = date('Y-m-d', strtotime($project_created_at. ' +12 day'));

            if (($project_details['deadline'] >= $critical_begin) && ($project_details['deadline'] <= $critical_end)) {
                $project_details['priority'] = 'critical';
            } elseif (($project_details['deadline'] >= $rush_begin) && ($project_details['deadline'] <= $rush_end)) {
                $project_details['priority'] = 'high';
            } elseif (($project_details['deadline'] >= $standard_begin)) {
                $project_details['priority'] = 'standard';
            }

            // echo $project_details['priority'];die;
        }
        // deadline assignne update

        if (isset($project_details['assignee'])) {
            $assignee = $project_details['assignee'];

            $project_details['assignee'] = implode(',', $project_details['assignee']);
        } else {
            $project_details['assignee'] = null;
        }

        // cad and 3d print logic
        if (!in_array($designation_id, [5,7])) {
            // cad slot logic
            $cad_slot_date = $this->input->post('cad_slot_date');
            if (!empty($cad_slot_date)) {
                foreach ($cad_slot_date as $key => $value) {
                    if ($value != '' && $value != null) {
                        $is_cad_slot_exist = $this->db->get_where('cad_slots', ['project_id' => $project_id, 'user_id' => $key])->row();

                        if (empty($is_cad_slot_exist)) {
                            $this->db->insert('cad_slots', ['user_id' => $key, 'project_id' => $project_id, 'date' => date('Y-m-d', strtotime($value))]);
                        } else {
                            $this->db->update('cad_slots', ['date' => date('Y-m-d', strtotime($value))], ['user_id' => $key, 'project_id' => $project_id]);
                        }
                    }
                }
            }
            // end cad slot logic


            // 3d print date logic
            $cad_3d_print_date = $this->input->post('cad_3d_print_date');
            if (!empty($cad_3d_print_date)) {
                foreach ($cad_3d_print_date as $key => $value) {
                    if ($value != '' && $value != null) {
                        $is_cad_3d_print_date_exist = $this->db->get_where('cad_3d_print_date', ['project_id' => $project_id, 'user_id' => $key])->row();

                        if (empty($is_cad_3d_print_date_exist)) {
                            $this->db->insert('cad_3d_print_date', ['user_id' => $key, 'project_id' => $project_id, 'date' => date('Y-m-d', strtotime($value))]);
                        } else {
                            $this->db->update('cad_3d_print_date', ['date' => date('Y-m-d', strtotime($value))], ['user_id' => $key, 'project_id' => $project_id]);
                        }
                    }
                }
            }
            // end 3d print date logic
            if (empty($assignee)) {
                $this->db->where('project_id', $project_id)->delete('cad_slots');
            } else {
                $this->db->where('project_id', $project_id)->where_not_in('user_id', $assignee)->delete('cad_3d_print_date');
                $this->db->where('project_id', $project_id)->where_not_in('user_id', $assignee)->delete('cad_slots');
            }
        }



        $this->insert_activity_log($project_id, $project_details);


        // description history logic
        $description = $this->db->get_where('project_details', ['project_id' => $project_id])->row()->description;

        if ($description != $project_details['description']) {
            $this->db->insert('project_description_history', ['project_id' => $project_id, 'description' => $project_details['description']]);
        }

        // end description history logic

        // estimated priceupdate action
        if (isset($project_details['estimated_price'])) {
            $estimated_price = $this->db->get_where('project_details', ['project_id' => $project_id])->row()->estimated_price;

            if ($estimated_price != $project_details['estimated_price'] && $project_details['estimated_price'] != 0) {
                $this->projectmodel->insert_estimate_tracking($project_id);
                $this->send_estimate_email($project_id);
            }
        }

        if (isset($project_details['estimated_approve'])) {
            $this->projectmodel->insert_estimate_status($project_id, $project_details['estimated_approve']);
        }

        $this->db->update('project_details', $project_details, ['project_id' => $project_id]);



        $project['project_name'] = $project_details['title'];
        $project['price'] = $project_details['price'];

        $this->db->update('project', $project, ['project_id' => $project_id]);

        // if project change to live it will send mail
        if ($project_details['type'] == 'live') {
            $this->send_email_user_project_confirmation($project_id);
        }
        //end  if project change to live it will send mail


        redirect('projects/project_details/'.$project_id);
    }

    public function send_estimate_email($project_id)
    {
        $asign_user = $this->db->get_where('project', ['project_id' => $project_id])->row()->asign_user;
        $email = $this->db->get_where('user', ['id' => $asign_user])->row()->email;

        ob_start(); ?>
        A quote has been created for this project J<?php echo $project_id ?>. Please review and approve to continue. <br>
        Project Link: <a href="<?php echo base_url('projects/project_details/'.$project_id) ?>">Link</a>
        <?php

        $data['html'] = ob_get_clean();

        $html = $this->load->view('default_email_template', $data, true);

        $config = $this->email_config();
        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject('Master Casting');
        $this->email->message($html);
        $this->email->send();
    }

    public function update_project_specification_action($project_id)
    {
        $this->login_check();

        $project_specification = $this->input->post('project_specification');

        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

        // if(in_array($designation_id, [5,7]))
        //     $project_specification['desc_approval'] = 0;
        // else
        //     $project_specification['desc_approval'] = 1;


        $prev_project_specification = $this->db->get_where('project_specification', ['project_id' => $project_id])->row_array();

        // if()

        foreach ($project_specification as $key => $value) {
            if ($value != $prev_project_specification[$key]) {
                $this->db->insert('project_specification_history', ['type' => $key,'project_id' => $project_id, 'value' => $value]);
            }
        }

        // print_r($prev_project_specification);die;

        // die;

        $this->insert_specification_activity_log($project_id, $project_specification);

        $this->db->update('project_specification', $project_specification, ['project_id' => $project_id]);
        redirect('projects/project_details/'.$project_id);
    }

    public function send_email_user_project_confirmation($project_id)
    {
        $assign_by = $this->db->get_where('project', ['project_id' => $project_id])->row()->assign_by;
        $email = $this->db->get_where('user', ['id' => $assign_by])->row()->email;

        ob_start(); ?>
        <b>Project J<?php echo $project_id ?></b> is now live. To check the status of your order please click <a href="<?php echo base_url('projects/project_details/'.$project_id)?>">here</a> to see details.
        <?php

        $data['html'] = ob_get_clean();

        $html = $this->load->view('default_email_template', $data, true);

        $config = $this->email_config();
        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject('Master Casting');
        $this->email->message($html);
        $this->email->send();
    }

    public function insert_activity_log($project_id, $project_details)
    {
        $this->login_check();

        $activity_type = array_keys($project_details);
        $project = $this->db->get_where('project_details', ['project_id' => $project_id])->row_array();
        $user_id = $this->session->userdata('user_id');


        foreach ($activity_type as $key) {
            $activity_type_id = $this->db->get_where('activity_type', ['activity_name' => $key])->row()->activity_type_id;
            if ($project_details[$key] != $project[$key]) {
                if ($key != 'deadline' && $key != 'internal_deadline' && $key != 'estimated_price') {
                    $this->db->insert('project_activity_log', ['activity_type' => $activity_type_id, 'project_id' => $project_id, 'user_id' => $user_id]);
                } elseif ($key == 'deadline' && $project['deadline'] > date('Y-m-d')) {
                    if ($project_details[$key] != $project[$key]) {
                        $this->db->insert('project_activity_log', ['activity_type' => $activity_type_id, 'project_id' => $project_id, 'user_id' => $user_id]);
                    }
                }
            }
        }
    }

    public function insert_specification_activity_log($project_id, $project_specification)
    {
        $this->login_check();

        $activity_type = array_keys($project_specification);
        $user_id = $this->session->userdata('user_id');
        $project = $this->db->get_where('project_specification', ['project_id' => $project_id])->row_array();


        foreach ($activity_type as $key) {
            $activity_type_id = $this->db->get_where('activity_type', ['activity_name' => $key])->row()->activity_type_id;
            if ($project_specification[$key] != $project[$key]) {
                // echo $activity_type_id;
                $this->db->insert('project_activity_log', ['activity_type' => $activity_type_id, 'project_id' => $project_id, 'user_id' => $user_id]);
            }
        }
    }

    public function project_meta_fileds()
    {
        $data['client_approval'] = $this->client_approval('designation_id');
        $data['msg_user'] = $this->projectmodel->get_msg_user();
        $data['employee'] = $this->projectmodel->get_employee();
        $data['assignee'] = $this->projectmodel->get_assignee();
        $data['manager'] = $this->projectmodel->get_manager();
        $data['client'] = $this->projectmodel->get_client();
        $data['disposition'] = $this->projectmodel->get_disposition();
        $data['project_title'] = $this->projectmodel->get_meta_fileds('project', 1);
        $data['specification_finish'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 2)->value);
        $data['specification_purity'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 3)->value);
        $data['specification_ring_size']=explode(',', $this->projectmodel->get_meta_fileds('specification', 4)->value);
        $data['specification_plating'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 5)->value);
        $data['specification_wax_only'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 6)->value);
        $data['specification_wax_only_resin'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 7)->value);
        $data['specification_casting_only'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 8)->value);
        $data['specification_mold'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 9)->value);
        $data['specification_supply_diamonds'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 10)->value);
        $data['specification_supply_center'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 11)->value);
        $data['specification_supply_all_gems'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 12)->value);
        $data['specification_supply_all_gems_yes'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 13)->value);
        $data['specification_sending_my_own'] = explode(',', $this->projectmodel->get_meta_fileds('specification', 14)->value);
        $data['permissions'] = $this->member_model->get_all_permissions();
        
        return $data;
    }

    public function client_approval()
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        if (in_array($designation_id, [1,6,8,9])) {
            return true;
        } elseif (in_array($designation_id, [5,7])) {
            return false;
        }
        return false;
    }

    public function update_project_type($type, $id)
    {
        switch ($type) {
            case 'approve':
                $this->projectmodel->update_project_type('live', $id);
                $this->projectmodel->insert_project_tracking_history($this->type_of_change['project_type'], $id, ['project_type' => 'live']);
                break;
            case 'reject':
                $this->projectmodel->update_project_type('cancelled', $id);
                $this->projectmodel->insert_project_tracking_history($this->type_of_change['project_type'], $id, ['project_type' => 'cancelled']);
                break;
            case 'redo':
                // todo later
                echo "todo";
                break;
        }
        redirect('Master_controllers');
    }

    public function insert_msg()
    {
        $this->login_check();

        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

        $user_id = $this->session->userdata('user_id');
        $project_msg['msg'] = $this->input->post('msg');
        $project_msg['msg_to'] = $this->input->post('msg_to');
        $project_msg['project_id'] = $this->input->post('project_id');
        $project_msg['msg_by'] = $this->session->userdata('user_id');

        // print_r($project_msg);die;

        if ($project_msg['msg'] != '') {
            $this->db->insert('project_activity_log', ['project_id' => $project_msg['project_id'], 'activity_type' => 30, 'user_id' => $user_id]);
            $this->projectmodel->insert_project_msg($project_msg);
        }

        $data = $this->projectmodel->get_project_msg($project_msg['project_id']);

        ?>
        <?php foreach ($data as $key) : ?>
            <tr>
                <td>
                    <?php
                    if ($key->msg_by == '') {
                        echo "";
                    } else {
                        $msg_by_des = $this->db->get_where('user', ['id' => $key->msg_by])->row()->designation_id;
                        if (in_array($designation_id, [5,7])) {
                            if ($msg_by_des == 9) {
                                echo $this->db->get_where('designation', ['designation_id' => $msg_by_des])->row()->designation_name;
                            } else {
                                echo $this->db->get_where('user', ['id' => $key->msg_by])->row()->name.' - '. $this->db->get_where('designation', ['designation_id' => $msg_by_des])->row()->designation_name;
                            }
                                // echo $this->db->get_where('designation', ['designation_id' => $msg_by_des])->row()->designation_name;
                        } else {
                            echo $this->db->get_where('user', ['id' => $key->msg_by])->row()->name.' - '. $this->db->get_where('designation', ['designation_id' => $msg_by_des])->row()->designation_name;
                        }
                    }

                    ?>
                </td>
                <td>
                    <?php
                    if ($key->msg_to == '') {
                        echo "";
                    } else {
                        $msg_to_des = $this->db->get_where('user', ['id' => $key->msg_to])->row()->designation_id;
                        if (in_array($designation_id, [5,7])) {
                            if ($msg_to_des == 9) {
                                echo $this->db->get_where('designation', ['designation_id' => $msg_to_des])->row()->designation_name;
                            } else {
                                echo $this->db->get_where('user', ['id' => $key->msg_to])->row()->name.' - '. $this->db->get_where('designation', ['designation_id' => $msg_to_des])->row()->designation_name;
                            }
                                // echo $this->db->get_where('designation', ['designation_id' => $msg_to_des])->row()->designation_name;
                        } else {
                            echo $this->db->get_where('user', ['id' => $key->msg_to])->row()->name.' - '. $this->db->get_where('designation', ['designation_id' => $msg_to_des])->row()->designation_name;
                        }
                    }

                    ?>
                </td>
                <td><?= $key->msg ?></td>
                <td><?= $key->reply ?></td>
                <td><?= date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd/m/y h:i A'); ?></td>
                <td>
                    <?php if ($key->msg_to != 0) : ?>
                        <?php if ($key->msg_to == $this->session->userdata('user_id')) : ?>
                            <?php if ($key->reply == '') : ?>
                        <button class="btn reply" value="<?php echo $key->project_msg_id ?>" href="<?php echo base_url('Project_controller/msg_history/'.$key->project_id.'/'.$key->msg_to)?>">Reply</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php

        if($project_msg['msg_to'] == 'all_assoc'){
            $asign_user = $this->db->get_where('project', ['project_id' => $project_msg['project_id']])->row()->asign_user;
            $associated_member = $this->projectmodel->get_associated_member($asign_user);
            $email = array_column($associated_member, 'email');
            array_push($email, $this->db->get_where('user', ['id' => $asign_user])->row()->email);
        } else {
            $email = $this->db->get_where('user', ['id' => $project_msg['msg_to']])->row()->email;
        }

        $html = $this->load->view('proj_msg_template', $project_msg, true);
       
        // $reciepient = ['oscar@valenciadiamonds.com', 'Lily@valenciadiamonds.com', 'jasmine@valenciadiamonds.com', 'jacky@diamonds717.com'];
        $reciepient = 'oscar@valenciadiamonds.com';
        $bcc = ['Lily@valenciadiamonds.com', 'jasmine@valenciadiamonds.com', 'jacky@diamonds717.com'];

        array_push($email, $reciepient);

        // print_r();die;

        $config = $this->email_config();

        $this->load->library('email', $config);
        // echo $from = $this->config->item('smtp_user');
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->bcc($bcc);
        $this->email->subject('Master Casting Message');
        $this->email->message($html);
        $this->email->send();
        // try {
        //     echo 'Message has been sent.';
        // } catch(Exception $e) {
        //     echo $e->getMessage();
        // }
    }
    // feb 11 2019
    public function insert_disposition()
    {
        $this->login_check();

        $user_id = $this->session->userdata('user_id');
        $data['disposition_id']=$this->input->post('disposition');
        $data['project_id']=$this->input->post('project_id');
        $data['flag']=0;
        $project_id=$this->input->post('project_id');

        $disposition_count = $this->db->get_where('project_disposition', ['disposition_id' => $data['disposition_id'], 'project_id' => $data['project_id']])->num_rows();

        if ($disposition_count == 1) {
            return print_r('false');
        }
        
        $this->projectmodel->insert_disposition($data, $project_id);
        
        $data['project_disposition'] = $this->projectmodel->disposition_details($project_id);
        $data['client_approval'] = $this->client_approval();
        $this->load->view('project_dispositions', $data);
    }
    public function update_disposition($project_disposition_id)
    {
        $this->login_check();

        $result = $this->projectmodel->update_disposition($project_disposition_id);

        $disposition = $this->db->get_where('project_disposition', ['project_disposition_id' => $project_disposition_id])->row();

        if ($disposition->disposition_id == 50) {
            ob_start(); ?>
            Project J<?php echo $disposition->project_id ?> disposition now updated to Shipped stage.
            Review it <a href="<?php echo base_url('projects/project_details/'.$disposition->project_id) ?>">here</a>
            <?php
            $data['html'] = ob_get_clean();

            $html = $this->load->view('default_email_template', $data, true);

            $reciepient = ['oscar@valenciadiamonds.com'];
            $bcc = ['Lily@valenciadiamonds.com', 'jasmine@valenciadiamonds.com', 'jacky@diamonds717.com'];

            $config = $this->email_config();

            $this->load->library('email', $config);
            // echo $from = $this->config->item('smtp_user');
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype("html");
            $this->email->from($this->email_form, 'Master Casting'); // change it to yours
            $this->email->to($reciepient); // change it to yours
            $this->email->bcc($bcc);
            $this->email->subject('Master Casting Message');
            $this->email->message($html);
            $this->email->send();
        }


        if ($result) :
            $data['project_disposition'] = $this->projectmodel->disposition_details($result);
            $data['client_approval'] = $this->client_approval();
            $this->load->view('project_dispositions', $data);
        endif;
    }

    public function revert_disposition($project_disposition_id)
    {
        $this->login_check();

        $result = $this->projectmodel->revert_disposition($project_disposition_id);

        if ($result) :
            $data['project_disposition'] = $this->projectmodel->disposition_details($result);
            $data['client_approval'] = $this->client_approval();
            $this->load->view('project_dispositions', $data);
        endif;
    }

    public function change_disposition()
    {
        $this->login_check();

        $user_id = $this->session->userdata('user_id');
        $project = $this->input->post('project');
        // echo $project['disposition'];die;


        $project_id = $this->db->get_where('project_disposition', ['project_disposition_id' => $project['project_disposition_id']])->row()->project_id;

        $this->db->update('project_disposition', ['disposition_id' => $project['disposition_id']], ['project_disposition_id' => $project['project_disposition_id']]);
        $this->db->insert('project_activity_log', ['project_id' => $project_id, 'activity_type' => 16, 'user_id' => $user_id]);


        $this->db->query("UPDATE `project_disposition` SET `flag`=0 WHERE project_id= $project_id AND project_disposition_id>= $project[project_disposition_id]");

        $data['project_disposition'] = $this->projectmodel->disposition_details($project_id);
        $data['client_approval'] = $this->client_approval();
        $this->load->view('project_dispositions', $data);
    }

    public function delete_disposition($project_disposition_id)
    {
        $this->login_check();

        $result = $this->projectmodel->delete_disposition($project_disposition_id);
        $data['project_disposition'] = $this->projectmodel->disposition_details($result);
        $data['client_approval'] = $this->client_approval();
        $this->load->view('project_dispositions', $data);
    }


    public function front_add_project_action()
    {
        $project = $this->input->post('project');
        $dynamic_id = $this->input->post('dynamic_id');
        $project_details = $this->input->post('project_details');
        $project_details['type'] = 'proposal';
        $project_details['deadline'] = date('Y-m-d', strtotime($project_details['deadline']));

        // deadline wise pririty
        $project_details['deadline'] = date('Y-m-d', strtotime($project_details['deadline']));
        $today = date('Y-m-d');

        $critical_begin = date('Y-m-d', strtotime($today));
        $critical_end   = date('Y-m-d', strtotime($today. ' +3 day'));

        $rush_begin = date('Y-m-d', strtotime($today. ' +4 day'));
        $rush_end   = date('Y-m-d', strtotime($today. ' +7 day'));

        $standard_begin = date('Y-m-d', strtotime($today. ' +8 day'));
        $standard_end   = date('Y-m-d', strtotime($today. ' +12 day'));

        if (($project_details['deadline'] >= $critical_begin) && ($project_details['deadline'] <= $critical_end)) {
            $project_details['priority'] = 'critical';
        } elseif (($project_details['deadline'] >= $rush_begin) && ($project_details['deadline'] <= $rush_end)) {
            $project_details['priority'] = 'high';
        } elseif (($project_details['deadline'] >= $standard_begin)) {
            $project_details['priority'] = 'standard';
        }


        $project_specification = $this->input->post('project_specification');
        $user_email = $this->input->post('user_email');

        $project_details['internal_deadline'] = date("Y-m-d H:i:s", strtotime("+1 week"));

        if (!$this->input->post('email')) {
            $project['assign_by'] = $this->db->get_where('user', ['email' => $user_email])->row()->id;
        }

        $project['price'] = $project_details['price'];
        $project['project_name'] = $project_details['title'];
        $project['dynamic_id'] = $this->dynamic_id();


        //if designation id in client trade or retail then asign user
        $designation_id = $this->db->get_where('user', ['email' => $user_email])->row()->designation_id;

        if (in_array($designation_id, [5,7])) {
            $project['asign_user'] = $this->db->get_where('user', ['email' => $user_email])->row()->id;
        }

        
        if ($this->input->post('email')) {
            //file upload
            if (count($_FILES['cad']['name']) > 0) {
                for ($i=0; $i<count($_FILES['cad']['name']); $i++) {
                    $_FILES['file']['name']     = time().rand(10, 100).'-'.preg_replace('/[^A-Za-z0-9 _ .-]/', '', $_FILES['cad']['name'][$i]);
                    $_FILES['file']['type']     = $_FILES['cad']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['cad']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['cad']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['cad']['size'][$i];
                    
                    // File upload configuration
                    $uploadPath = 'uploads/temp_proj_files/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xlxs|xlx|csv|txt|doc|docx|xlxs|xlx|csv|txt';
                    
                    // Load and initialize upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    
                    // Upload file to server
                    if ($this->upload->do_upload('file')) {
                        // Uploaded file data
                        $fileData = $this->upload->data();
                        $cadFilesData[$i]['file_name'] = $fileData['file_name'];
                    } else {
                        echo $this->upload->display_errors();
                        return;
                    }
                }
            }


            if (count($_FILES['pic']['name']) > 0) {
                for ($i=0; $i<count($_FILES['pic']['name']); $i++) {
                    $_FILES['file']['name']     = time().rand(10, 100).'-'.preg_replace('/[^A-Za-z0-9 _ .-]/', '', $_FILES['pic']['name'][$i]);
                    $_FILES['file']['type']     = $_FILES['pic']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['pic']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['pic']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['pic']['size'][$i];
                    
                    // File upload configuration
                    $uploadPath = 'uploads/temp_proj_files/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xlxs|xlx|csv|txt';
                    
                    // Load and initialize upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    
                    // Upload file to server
                    if ($this->upload->do_upload('file')) {
                        // Uploaded file data
                        $fileData = $this->upload->data();
                        $picFilesData[$i]['file_name'] = $fileData['file_name'];
                    } else {
                        echo $this->upload->display_errors();
                        return;
                    }
                }
            }

            ob_start(); ?>
            
            <h4>Project added by this email address <?php echo $this->input->post('email') ?></h4>

            <h3>Project details</h3>
            <table>
                <thead>
                    <tr>
                        <td>Title</td>
                        <td>Po#</td>
                        <td>Budget</td>
                        <td>Due Date</td>
                        <td>Priority</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $project_details['title'] ?></td>
                        <td><?php echo $project_details['po'] ?></td>
                        <td><?php echo $project_details['price'] ?></td>
                        <td><?php echo $project_details['deadline'] ?></td>
                        <td><?php echo $project_details['priority'] ?></td>
                    </tr>
                </tbody>
            </table>

            <h3>Project Specification details</h3>
            <table>
                <thead>
                    <tr>
                        <td>Metal</td>
                        <td>Finish</td>
                        <td>Ring Size</td>
                        <td>Plating</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $project_specification['purity'] ?></td>
                        <td><?php echo $project_specification['finish'] ?></td>
                        <td><?php echo $project_specification['ring_size'] ?></td>
                        <td><?php echo $project_specification['plating'] ?></td>
                    </tr>
                </tbody>
            </table>
            <?php

            $html = ob_get_clean();

            $file = array_merge($picFilesData, $cadFilesData);

            $this->send_add_project_email($html, $file, true);

            echo '
                    <script>
                        alert("One job added");
                        window.location.replace("'.DOMAIN.'/add-project/");
                    </script>
                    ';
            return;
        } else {
            $this->db->insert('project', $project);
            $project_details['project_id'] = $this->db->insert_id();
            $project_specification['project_id'] = $this->db->insert_id();
            $last_insert_id = $this->db->insert_id();

            $cadFilesData = $this->db->get_where('project_files_temp', ['dynamic_id' => $dynamic_id, 'type' => 'cad'])->result();

            if (count($cadFilesData) > 0) {
                foreach ($cadFilesData as $key) {
                    $this->db->insert('project_files', ['project_id' => $last_insert_id, 'type' => 'cad', 'file_name' => $key->file_name, 'user_id' => $project['assign_by']]);
                }
            }


            $picFilesData = $this->db->get_where('project_files_temp', ['dynamic_id' => $dynamic_id, 'type' => 'pic'])->result();
            if (count($picFilesData) > 0) {
                foreach ($picFilesData as $key) {
                    $this->db->insert('project_files', ['project_id' => $last_insert_id, 'type' => 'pic', 'file_name' => $key->file_name, 'user_id' => $project['assign_by']]);
                }
            }

            $this->db->insert('project_details', $project_details);
            $this->db->insert('project_specification', $project_specification);
            $this->db->insert('project_description_history', ['project_id' => $last_insert_id, 'description' => $project_details['description']]);


            //insert disposition
            $disp = [44, 45, 46, 3, 47, 48, 49, 50];
            foreach ($disp as $key) {
                $this->db->insert('project_disposition', ['project_id' => $last_insert_id, 'disposition_id' => $key]);
            }

            //insert disposition
            $intrnl_disp = [63, 9, 85, 78, 10, 70];
            foreach ($intrnl_disp as $key) {
                $this->db->insert('project_disposition_internal', ['project_id' => $last_insert_id, 'disposition_id' => $key]);
            }


            $project = $this->projectmodel->get_project($last_insert_id);
            $project_details = $this->projectmodel->get_project_details($last_insert_id);
            $project_specification = $this->projectmodel->get_project_specification($last_insert_id);
            $project_files = $this->projectmodel->get_project_files($last_insert_id);


            ob_start(); ?>
            
            <h3>Project added by <?php echo $this->db->get_where('user', ['id' => $project->assign_by])->row()->name ?></h3>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Document</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
                <style>
                    .alert{
                        padding: 1px 8px;
                        margin: 0px;
                        font-weight: bold;
                        position: relative;
                        border: 1px solid transparent;
                        border-radius: .25rem;
                        color: #004085;
                        background-color: #cce5ff;
                        border-color: #b8daff;
                    }
                    p{
                        margin: 0px 25px;
                        padding: 2px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Project Details</h2>

                            <div class="alert alert-primary">Title</div>
                            <p><?php echo $project_details->title ?></p>
                            
                            <div class="alert alert-primary">Po</div>
                            <p><?php echo $project_details->po ?></p>

                            <div class="alert alert-primary">Price</div>
                            <p><?php echo $project_details->price ?></p>

                            <div class="alert alert-primary">Deadline</div>
                            <p><?php echo $project_details->deadline ?></p>

                            <div class="alert alert-primary">Priority</div>
                            <p><?php echo $project_details->priority ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <h2>Project Specification</h2>
                            
                            <div class="alert alert-primary">Purity</div>
                            <p><?php echo $project_specification->purity ?></p>

                            <div class="alert alert-primary">Finish</div>
                            <p><?php echo $project_specification->finish ?></p>

                            <div class="alert alert-primary">Ring size</div>
                            <p><?php echo $project_specification->ring_size ?></p>

                            <div class="alert alert-primary">Plating</div>
                            <p><?php echo $project_specification->plating ?></p>
                
                        </div>
                    </div>
                </div>
            </body>
            </html>
            <?php

            $html = ob_get_clean();

            $this->send_add_project_email($html, $project_files);

            echo '
    				<script>
    					alert("One job added");
    					window.location.replace("'.DOMAIN.'/add-project/");
    				</script>
    				';
            return;
        }
    }

    public function send_add_project_email($message, $project_files, $new_proj = false)
    {
        
        // $email = 'sjgalaxy98@gmail.com';
        // $email = 'maulik@hih7.com';
        // $email = ['oscar@valenciadiamonds.com', 'Lily@valenciadiamonds.com', 'jasmine@valenciadiamonds.com', 'jacky@diamonds717.com'];
        $email = ['oscar@valenciadiamonds.com'];
        $bcc = ['Lily@valenciadiamonds.com', 'jasmine@valenciadiamonds.com', 'jacky@diamonds717.com'];
     
        $config = $this->email_config();
        $this->load->library('email', $config);

        // $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->bcc($bcc);
        $this->email->subject("New Project Added");
        $this->email->message($message);

        // if(!$new_proj){
        //     foreach ($project_files as $key) {
        //         $this->email->attach(''.DOMAIN.'/mastercasting_backend/uploads/proj_files/'. $key->file_name);
        //     }
        // } else{
        //     foreach ($project_files as $key) {
        //         $this->email->attach(''.DOMAIN.'/mastercasting_backend/uploads/temp_proj_files/'. $key['file_name']);
        //     }
        // }
        $this->email->send();
    }


    public function upload_proj_files($userfile)
    {
        $config['upload_path']          = './uploads/proj_files';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $new_name = time().'-'.preg_replace('/[^A-Za-z0-9 _ .-]/', '', $_FILES[$userfile]['name']);
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);

        if (! $this->upload->do_upload($userfile)) {
            return $error = array('error' => $this->upload->display_errors());
        } else {
            return $this->upload->data();
        }
    }


      // internal disposition
    public function insert_disposition_internal()
    {
        $this->login_check();

        $data['disposition_id']=$this->input->post('disposition');
        $data['project_id']=$this->input->post('project_id');
        $data['flag']=0;
        $project_id=$this->input->post('project_id');

        $disposition_count = $this->db->get_where('project_disposition_internal', ['disposition_id' => $data['disposition_id'], 'project_id' => $data['project_id']])->num_rows();

        if ($disposition_count == 1) {
            return print_r('false');
        }

        $this->projectmodel->insert_disposition_internal($data, $project_id);
        
        $data['project_disposition_internal'] = $this->projectmodel->disposition_details_internal($project_id);
        $data['client_approval'] = $this->client_approval();
        $this->load->view('project_dispositions_internal', $data);
    }

    public function delete_disposition_internal($project_disposition_id)
    {
        $this->login_check();

        $project_id = $this->db->get_where('project_disposition_internal', ['project_disposition_id' => $project_disposition_id])->row()->project_id;
        $this->db->delete('project_disposition_internal', ['project_disposition_id' => $project_disposition_id]);
        $data['project_disposition_internal'] = $this->projectmodel->disposition_details_internal($project_id);
        $data['client_approval'] = $this->client_approval();
        $this->load->view('project_dispositions_internal', $data);
    }

    public function update_disposition_internal($project_disposition_id)
    {
        $this->login_check();

        $result = $this->projectmodel->update_disposition_internal($project_disposition_id);

        $disposition_internal = $this->db->get_where('project_disposition_internal', ['project_disposition_id' => $project_disposition_id])->row();

        if ($disposition_internal->disposition_id == 70) {
            ob_start(); ?>
            Project J<?php echo $disposition_internal->project_id ?> disposition now updated to Ready stage.
            Review it <a href="<?php echo base_url('projects/project_details/'.$disposition_internal->project_id) ?>">here</a>
            <?php
            $data['html'] = ob_get_clean();

            $html = $this->load->view('default_email_template', $data, true);

            $reciepient = ['oscar@valenciadiamonds.com'];
            $bcc = ['Lily@valenciadiamonds.com', 'jasmine@valenciadiamonds.com', 'jacky@diamonds717.com'];

            $config = $this->email_config();

            $this->load->library('email', $config);
            // echo $from = $this->config->item('smtp_user');
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype("html");
            $this->email->from($this->email_form, 'Master Casting'); // change it to yours
            $this->email->to($reciepient); // change it to yours
            $this->email->bcc($bcc);
            $this->email->subject('Master Casting Message');
            $this->email->message($html);
            $this->email->send();
        }

        if ($result) :
            $data['project_disposition_internal'] = $this->projectmodel->disposition_details_internal($result);
            $data['client_approval'] = $this->client_approval();
            $this->load->view('project_dispositions_internal', $data);
        endif;
    }

    public function change_disposition_internal()
    {
        $this->login_check();

        $project = $this->input->post('project');
        // print_r($project);die;
        // echo $project['disposition'];die;


        $project_id = $this->db->get_where('project_disposition_internal', ['project_disposition_id' => $project['project_disposition_id']])->row()->project_id;

        $this->db->update('project_disposition_internal', ['disposition_id' => $project['disposition_id']], ['project_disposition_id' => $project['project_disposition_id']]);

        $this->db->query("UPDATE `project_disposition_internal` SET `flag`=0 WHERE project_id= $project_id AND project_disposition_id>= $project[project_disposition_id]");

        $data['project_disposition_internal'] = $this->projectmodel->disposition_details_internal($project_id);
        $data['client_approval'] = $this->client_approval();
        $this->load->view('project_dispositions_internal', $data);
    }

    public function revert_disposition_internal($project_disposition_id)
    {
        $this->login_check();

        $project_id = $this->db->get_where('project_disposition_internal', ['project_disposition_id' => $project_disposition_id])->row()->project_id;
        // $disposition = $this->projectmodel->disposition_details($project_id);

        $this->db->query("UPDATE `project_disposition_internal` SET `flag`=0 WHERE project_id= $project_id AND project_disposition_id>= $project_disposition_id");

        $data['project_disposition_internal'] = $this->projectmodel->disposition_details_internal($project_id);
        $data['client_approval'] = $this->client_approval();
        $this->load->view('project_dispositions_internal', $data);
    }

    public function add_project_files()
    {
        $project_id = $this->input->post('project_id');
        $user_id = $this->session->userdata('user_id');

        $data = $this->do_upload('file');

        if (isset($data['error'])) {
            return print_r(strip_tags($data['error']));
        }

        $this->db->insert('project_files', ['file_name' => $data['file_name'], 'project_id' => $project_id, 'user_id' => $user_id, 'type' => 'pic']);
        return print(6);
    }

    public function edit_project_files()
    {
        $Imageid = $this->input->post('project_files_id');
        $file_name = $this->db->get_where('project_files', ['project_files_id' => $Imageid])->row()->file_name;

        $data = $this->do_upload('file');

        if (isset($data['error'])) {
            return print_r(strip_tags($data['error']));
        }

        $this->db->update('project_files', ['file_name' => $data['file_name']], ['project_files_id' => $Imageid]);
        unlink("uploads/proj_files/".$file_name);
        return print(1);
    }

    public function delete_project_files($Imageid)
    {
        $file_name = $this->db->get_where('project_files', ['project_files_id' => $Imageid])->row()->file_name;
        unlink("uploads/proj_files/".$file_name);
        $this->db->delete('project_files', ['project_files_id' => $Imageid]);
    }

    public function do_upload($userfile)
    {
        $config['upload_path']          = './uploads/proj_files/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = time().'_'.preg_replace('/\s+/', '', $_FILES[$userfile]['name']);

        $this->load->library('upload', $config);

        if (! $this->upload->do_upload($userfile)) {
            return array('error' => $this->upload->display_errors());
        } else {
            return $this->upload->data();
        }
    }

    public function print_project_details($vendor = false)
    {
        $this->login_check();



        $project = $this->input->post('project');

        $project_created_at = $this->db->get_where('project_details', ['project_id' => $project['project_id']])->row()->created_at;

        $project['deadline'] = isset($project['deadline']) ? date('Y-m-d', strtotime($project['deadline'])) : '0000-00-00';

        $critical_begin = date('Y-m-d', strtotime($project_created_at));
        $critical_end   = date('Y-m-d', strtotime($project_created_at. ' +3 day'));

        $rush_begin = date('Y-m-d', strtotime($project_created_at. ' +4 day'));
        $rush_end   = date('Y-m-d', strtotime($project_created_at. ' +7 day'));

        $standard_begin = date('Y-m-d', strtotime($project_created_at. ' +8 day'));
        $standard_end   = date('Y-m-d', strtotime($project_created_at. ' +12 day'));

        if (($project['deadline'] >= $critical_begin) && ($project['deadline'] <= $critical_end)) {
            $project['priority'] = 'critical';
        } elseif (($project['deadline'] >= $rush_begin) && ($project['deadline'] <= $rush_end)) {
            $project['priority'] = 'high';
        } elseif (($project['deadline'] >= $standard_begin)) {
            $project['priority'] = 'standard';
        }

        $count = $this->db->get_where('print_project_details', ['project_id' => $project['project_id']])->num_rows();

        if ($count == 0) {
            $this->db->insert('print_project_details', $project);
        } else {
            $this->db->update('print_project_details', $project, ['project_id' => $project['project_id']]);
        }
        
        $this->db->update('project_details', $project, ['project_id' => $project['project_id']]);
        // print_r($project);die;

        $data['vendor'] = false;
        if ($vendor == 'vendor') {
            $data['vendor'] = true;
        }


        $data['print_project_details'] = $this->db->get_where('print_project_details', ['project_id' => $project['project_id']])->row();
        $data['project'] = $this->db->get_where('project', ['project_id' => $project['project_id']])->row();
        $data['project_details'] = $this->db->get_where('project_details', ['project_id' => $project['project_id']])->row();
        $data['project_ship'] = $this->db->get_where('ship', ['project_id' => $project['project_id']])->row();
        $data['project_specification'] = $this->db->get_where('project_specification', ['project_id' => $project['project_id']])->row();
        $data['project_files'] = $this->db->get_where('project_files', ['project_id' => $project['project_id'], 'thumbnail' => 1])->result();

        if (count($data['project_files']) == 0) {
            $data['project_files'] = $this->db->get_where('project_files', ['project_id' => $project['project_id']])->result();
        }

        // print_r($data['project_details']);die;
        // echo  $_SERVER["DOCUMENT_ROOT"];die;
        $dl = false;
        if (get_browser_name() == 'ie') {
            $dl = true;
        }
        $this->load->view('print_project', $data);
        $html = $this->output->get_output();
        $this->pdf->loadHtml(html_entity_decode($html));
        $this->pdf->setPaper('B4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream("Job Sheet", array("Attachment" => $dl));
    }


    public function update_print_project_details()
    {
        $this->login_check();

        $project = $this->input->post('project');

        $project_created_at = $this->db->get_where('project_details', ['project_id' => $project['project_id']])->row()->created_at;

        $project['deadline'] = date('Y-m-d', strtotime($project['deadline']));

        $critical_begin = date('Y-m-d', strtotime($project_created_at));
        $critical_end   = date('Y-m-d', strtotime($project_created_at. ' +3 day'));

        $rush_begin = date('Y-m-d', strtotime($project_created_at. ' +4 day'));
        $rush_end   = date('Y-m-d', strtotime($project_created_at. ' +7 day'));

        $standard_begin = date('Y-m-d', strtotime($project_created_at. ' +8 day'));
        $standard_end   = date('Y-m-d', strtotime($project_created_at. ' +12 day'));

        if (($project['deadline'] >= $critical_begin) && ($project['deadline'] <= $critical_end)) {
            $project['priority'] = 'critical';
        } elseif (($project['deadline'] >= $rush_begin) && ($project['deadline'] <= $rush_end)) {
            $project['priority'] = 'high';
        } elseif (($project['deadline'] >= $standard_begin)) {
            $project['priority'] = 'standard';
        }


        $count = $this->db->get_where('print_project_details', ['project_id' => $project['project_id']])->num_rows();

        if ($count == 0) {
            $this->db->insert('print_project_details', $project);
        } else {
            // $this->insert_print_deatils_activity_log($project);
            $this->db->update('print_project_details', $project, ['project_id' => $project['project_id']]);
        }
        $this->db->update('project_details', $project, ['project_id' => $project['project_id']]);
    }

    public function insert_print_deatils_activity_log($project)
    {

        $print_project_details = $this->db->get_where('print_project_details', ['project_id' => $project['project_id']])->row_array();
        $user_id = $this->session->userdata('user_id');

        $activity_type = array_keys($project);

        foreach ($activity_type as $key) {
            if ($key != 'project_id') {
                $activity_type_id = $this->db->get_where('activity_type', ['activity_name' => 'print_details_'.$key])->row()->activity_name;
                if ($print_project_details[$key] != $project[$key]) {
                    if ($key == 'deadline' && $project[$key] != '') {
                        $this->db->insert('project_activity_log', ['activity_type' => $activity_type_id, 'user_id' => $user_id, 'project_id' => $project['project_id']]);
                    }
                    if ($key != 'deadline') {
                        $this->db->insert('project_activity_log', ['activity_type' => $activity_type_id, 'user_id' => $user_id, 'project_id' => $project['project_id']]);
                    }
                }
            }
        }
    }

    public function jump_to_project($key = null)
    {
        // $project = $this->db->or_like(array('project_name' => $key, 'project_id' => $key))->get('project')->result();
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;
        if (in_array($designation_id, [1,6,8])) {
            $project = $this->db->query("SELECT DISTINCT `project`.`project_id`, `project`.`project_name` FROM `project` JOIN `user` WHERE `project`.`project_name` LIKE '$key%' OR `project`.`project_id` LIKE '%$key%' OR `user`.`name` LIKE '%$key%' OR `project`.`dynamic_id` LIKE '%$key%'")->result();
        } else {
            // $project = $this->db->query("SELECT DISTINCT `project`.`project_id`, `project`.`project_name` FROM `project` JOIN `user` JOIN `project_details` WHERE (`project`.`assign_by` = $user_id OR `project`.`asign_user` = $user_id OR FIND_IN_SET('$user_id', `assignee`)) AND (`project`.`project_name` LIKE '$key%' OR `project`.`project_id` LIKE '%$key%' OR `user`.`name` LIKE '%$key%')")->result();
            $project = $this->db->query("SELECT * FROM `project` JOIN `project_details` ON `project`.`project_id` = `project_details`.`project_id` WHERE ( `assign_by` = '$user_id' OR `asign_user` = '$user_id' OR FIND_IN_SET('$user_id', `assignee`) ) AND (`project`.`project_name` LIKE '$key%' OR `project`.`project_id` LIKE '%$key%') ORDER BY `created_at` DESC")->result();
        }


        // echo $this->db->last_query();
        // echo "SELECT * FROM `project` JOIN `user` ON `project`.`asign_user` = `user`.`id` WHERE `project`.`project_name` LIKE '%$key%' OR `project`.`project_id` LIKE '%$key%' OR `user`.`name` LIKE '%$key%'";

        echo json_encode($project);
    }


    public function print_job_label($project_id)
    {
        $this->login_check();

        $project = $this->db->get_where('project', ['project_id' => $project_id])->row();
        $project_details = $this->db->get_where('project_details', ['project_id' => $project_id])->row();
        ob_start(); ?>
        <style type="text/css">
              @page {
                margin: 0cm 0cm;
            }
            div{
                margin-left: 50px;
            }
            p{
                letter-spacing: 1px;
                font-size: 24px;
                font-weight: 500;
            }

        </style>
        <div>
            <p>
                <b>Client:</b> 
                <?php
                if ($project->asign_user != 0) {
                    $user = $this->db->get_where('user', ['id' => $project->asign_user])->row();
                    if ($user->designation_id != 7) {
                        echo $user->name;
                    } else {
                        echo $user->company_name.' ('.$user->name.')';
                    }
                }
                ?>
            </p>
            <p><b>Job:</b> <?php echo $project->project_id ?></p>
            <p><b>Created At:</b> <?php echo $project_details->created_at ?></p>
            <p><b>Deadline:</b> <?php echo $project_details->deadline ?></p>
        </div>
        
        <?php
        $html = ob_get_clean();
        // $customPaper = array(0,0,360,150);
        $customPaper = array(0,0,500,200);
        $this->pdf->loadHtml(html_entity_decode($html));
        $this->pdf->set_paper($customPaper);
        $this->pdf->render();
        $this->pdf->stream("Print Job Label", array("Attachment" => false));
    }


    public function dynamic_id()
    {
        $digits = 8;
        $project = $this->db->get('project')->result();

        if (count($project) == 0) {
            return rand(1000, 10000);
        }

        $check = false;

        while (!$check) {
            $dynamic_id = rand(pow(10, $digits-1), pow(10, $digits)-1);
            foreach ($project as $key) {
                if ($dynamic_id != $key->dynamic_id) {
                    $check = true;
                }
            }
        }

        return $dynamic_id;
    }


    public function all()
    {
        if ($this->client_approval()) {
            echo $data['projects'] = $this->projectmodel->get_all_projects(true);
        } else {
            echo $data['projects'] = $this->projectmodel->get_all_projects();
        }

        print_r($data['projects']);
        die;
        // $this->load->view('all_projects', $data);
    }


    public function file_action($project_id)
    {
        $project_files_id = $this->input->post('project_files_id');
        $action = $this->input->post('action');
        $project_files = $this->db->get_where('project_files', ['project_id' => $project_id])->result();

        if (count($project_files_id) == 0) {
            return redirect('projects/project_details/'.$project_id);
        }

        if ($action == 'thumbnail') {
            $thumbnail_files = $this->db->get_where('project_files', ['project_id' => $project_id, 'thumbnail' => 1])->result();
            // print_r($thumbnail_files);die;

            // foreach ($project_files as $key) {
            //     $this->db->update('project_files', ['thumbnail' => 0], ['project_files_id' => $key->project_files_id]);
            // }

            //for more than one thumbanail
            if (count($thumbnail_files) >= 2) {
                $this->db->update('project_files', ['thumbnail' => 0], ['project_files_id' => $thumbnail_files[0]->project_files_id]);
                if (count($project_files_id) > 1) {
                    $this->db->update('project_files', ['thumbnail' => 0], ['project_files_id' => $thumbnail_files[1]->project_files_id]);
                }
            } elseif (count($thumbnail_files) == 1) {
                $this->db->update('project_files', ['thumbnail' => 0], ['project_files_id' => $thumbnail_files[0]->project_files_id]);
            }

            $this->db->update('project_files', ['thumbnail' => 1], ['project_files_id' => $project_files_id[0]]);
            $file_name = $this->db->get_where('project_files', ['project_files_id' => $project_files_id[0]])->row()->file_name;
            if (!file_exists("./uploads/thumbnail/".$file_name)) {
                // echo file_exists("./uploads/thumbnail/".$file_name);
                // die;
                file_put_contents("./uploads/thumbnail/".$file_name, file_get_contents('https://dn95g1jn6e80y.cloudfront.net/'.$file_name));
            }

            if (count($project_files_id) > 1) {
                $this->db->update('project_files', ['thumbnail' => 1], ['project_files_id' => $project_files_id[1]]);
                $file_name = $this->db->get_where('project_files', ['project_files_id' => $project_files_id[1]])->row()->file_name;
                if (!file_exists("./uploads/thumbnail/".$file_name)) {
                    // echo file_exists("./uploads/thumbnail/".$file_name);
                    // die;
                    file_put_contents("./uploads/thumbnail/".$file_name, file_get_contents('https://dn95g1jn6e80y.cloudfront.net/'.$file_name));
                }
            }
        } elseif ($action == 'client_visible') {
            foreach ($project_files_id as $key) {
                $this->db->update('project_files', ['client_approval' => 1], ['project_files_id' => $key]);
            }
        } elseif ($action == 'client_invisible') {
            foreach ($project_files_id as $key) {
                $this->db->update('project_files', ['client_approval' => 0], ['project_files_id' => $key]);
            }
        } elseif ($action == 'delete') {
            foreach ($project_files_id as $key) {
                $file_name = $this->db->get_where('project_files', ['project_files_id' => $key])->row()->file_name;
                unlink('uploads/proj_files/'.$file_name);
                $this->db->delete('project_files', ['project_files_id' => $key]);
            }
        } elseif ($action == 'invisible_cad') {
            // echo "string";die;
            foreach ($project_files_id as $key) {
                $this->db->update('project_files', ['visible_cad' => 0], ['project_files_id' => $key]);
            }
        } elseif ($action == 'visible_cad') {
            // echo "string";die;
            foreach ($project_files_id as $key) {
                $this->db->update('project_files', ['visible_cad' => 1], ['project_files_id' => $key]);
            }
        } elseif ($action == 'archive') {
            // echo "string";die;
            $group = $this->input->post('group');
            // print_r($group);
            if (!empty($group)) {
                $group = implode(',', $group);
            } else {
                $group = '';
            }
            foreach ($project_files_id as $key) {
                $this->db->update('project_files', ['is_archive' => 1, 'group_id' => $group], ['project_files_id' => $key]);
            }
        } elseif ($action == 'dropbox') {
            // echo "string";die;
            foreach ($project_files_id as $key) {
                $this->db->update('project_files', ['is_dropbox_backed_up' => 1], ['project_files_id' => $key]);

                $finename = $this->db->get_where('project_files', ['project_files_id' => $key])->row()->file_name;

                $dropbox = new Dropbox\Dropbox($this->token);

                // // Upload a file, overwriting if the file already exists in Dropbox
                file_put_contents("./uploads/dropbox/".$finename, file_get_contents('https://dn95g1jn6e80y.cloudfront.net/'.$finename));
                $data = $dropbox->files->upload('/Backup/Files/J'.$project_id.'/'.$finename, './uploads/dropbox/'.$finename, "add");
                unlink('./uploads/dropbox/'.$finename);
            }
        }
        // die;
        return redirect('projects/project_details/'.$project_id);
    }

    public function krajee()
    {
        $this->load->view('krajee');
    }

    public function krajee_upload($project_id, $type = 'pic')
    {
        // print_r($_FILES['file']);die;

        // if($type == 'undefined')
        //     $type = 'pic';

        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;


        if (isset($data['error'])) {
            return print_r(strip_tags($data['error']));
        }


        $preview = [];
        $config = [];
        $errors = [];
        $input = 'file'; // the input name for the fileinput plugin
        if (empty($_FILES[$input])) {
            return [];
        }
        
        $total = count($_FILES[$input]['name']); // multiple files
        // $path = 'uploads/proj_files/'; // your upload path
        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $fileName = time().'_'.preg_replace('/\s+/', '', $_FILES[$input]['name'][$i]); // the file name
            $fileSize = $_FILES[$input]['size'][$i]; // the file size
            
            //Make sure we have a file path
            if ($tmpFilePath != "") {
                //Setup our new file path
                // $newFilePath = $path . $fileName;
                // $newFileUrl = base_url('uploads/proj_files/') . $fileName;
                
                //Upload the file into the new path
                if ($newFileUrl = $this->upload($fileName, $tmpFilePath)) {
                    if (in_array($designation_id, [5,7])) {
                        $client_approval = 1;
                    } else {
                        $client_approval = 0;
                    }

                    if (in_array($designation_id, [9])) {
                        $visible_cad = 1;
                    } else {
                        $visible_cad = 0;
                    }

                    $this->db->insert('project_files', ['file_name' => $fileName, 'project_id' => $project_id, 'user_id' => $user_id, 'type' => $type, 'client_approval' => $client_approval, 'visible_cad' => $visible_cad]);

                    $project_files_id = $this->db->insert_id();
                    $fileId = $fileName . $i; // some unique key to identify the file
                    $preview[] = $newFileUrl;
                    $config[] = [
                        'key' => $fileId,
                        'caption' => $fileName,
                        'size' => $fileSize,
                        'downloadUrl' => $newFileUrl, // the url to download the file
                        'url' => base_url('Project_controller/delete_krajee_img/'.$project_files_id), // server api to delete the file based on key
                    ];
                } else {
                    $errors[] = $fileName;
                }
            } else {
                $errors[] = $fileName;
            }
        }
        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
        if (!empty($errors)) {
            $img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }

        $this->db->insert('project_activity_log', ['activity_type' => 31, 'project_id' => $project_id, 'user_id' => $user_id]);

        echo json_encode($out);
    }

    public function delete_krajee_img($project_files_id = '')
    {
        $user_id = $this->session->userdata('user_id');
        // $file_name = $this->db->get_where('project_files', ['project_files_id' => $project_files_id])->row()->file_name;
        $project_id = $this->db->get_where('project_files', ['project_files_id' => $project_files_id])->row()->project_id;
        $this->db->delete('project_files', ['project_files_id' => $project_files_id]);
        // unlink('uploads/proj_files/'.$file_name);
        $this->db->insert('project_activity_log', ['activity_type' => 33, 'project_id' => $project_id,  'user_id' => $user_id]);
        echo json_encode("Done");
    }


    public function project_description($id)
    {
        $data['project_description'] = $this->db->get_where('project_description_history', ['project_description_history_id' => $id])->row();
        $this->load->view('project_description', $data);
    }


    public function krajee_cad_upload($dynamic_id)
    {

        $user_id = $this->session->userdata('user_id');


        if (isset($data['error'])) {
            return print_r(strip_tags($data['error']));
        }


        $preview = [];
        $config = [];
        $errors = [];
        $input = 'file'; // the input name for the fileinput plugin
        if (empty($_FILES[$input])) {
            return [];
        }
        
        $total = count($_FILES[$input]['name']); // multiple files
        // $path = 'uploads/proj_files/'; // your upload path
        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $fileName = time().'_'.preg_replace('/\s+/', '', $_FILES[$input]['name'][$i]); // the file name
            $fileSize = $_FILES[$input]['size'][$i]; // the file size
            
            //Make sure we have a file path
            if ($tmpFilePath != "") {
                //Setup our new file path
                // $newFilePath = $path . $fileName;
                // $newFileUrl = base_url('uploads/proj_files/') . $fileName;
                
                //Upload the file into the new path
                if ($newFileUrl = $this->upload($fileName, $tmpFilePath)) {
                    $this->db->insert('project_files_temp', ['file_name' => $fileName, 'dynamic_id' => $dynamic_id, 'user_id' => $user_id, 'type' => 'cad']);

                    $project_files_id = $this->db->insert_id();
                    $fileId = $fileName . $i; // some unique key to identify the file
                    $preview[] = $newFileUrl;
                    $config[] = [
                        'key' => $fileId,
                        'caption' => $fileName,
                        'size' => $fileSize,
                        'downloadUrl' => $newFileUrl, // the url to download the file
                        'url' => base_url('Project_controller/delete_krajee_cad_img/'.$project_files_id), // server api to delete the file based on key
                    ];
                } else {
                    $errors[] = $fileName;
                }
            } else {
                $errors[] = $fileName;
            }
        }
        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
        if (!empty($errors)) {
            $img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }


        echo json_encode($out);
    }

    public function krajee_pic_upload($dynamic_id)
    {
        // echo $dynamic_i;die;
        // print_r($_FILES['file']);die;

        $user_id = $this->session->userdata('user_id');

        if (isset($data['error'])) {
            return print_r(strip_tags($data['error']));
        }


        $preview = [];
        $config = [];
        $errors = [];
        $input = 'file'; // the input name for the fileinput plugin
        if (empty($_FILES[$input])) {
            return [];
        }
        
        $total = count($_FILES[$input]['name']); // multiple files
        // $path = 'uploads/proj_files/'; // your upload path
        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $fileName = time().'_'.preg_replace('/\s+/', '', $_FILES[$input]['name'][$i]); // the file name
            $fileSize = $_FILES[$input]['size'][$i]; // the file size
            
            //Make sure we have a file path
            if ($tmpFilePath != "") {
                //Setup our new file path
                // $newFilePath = $path . $fileName;
                // $newFileUrl = base_url('uploads/proj_files/') . $fileName;
                
                //Upload the file into the new path
                if ($newFileUrl = $this->upload($fileName, $tmpFilePath)) {
                    $this->db->insert('project_files_temp', ['file_name' => $fileName, 'dynamic_id' => $dynamic_id, 'user_id' => $user_id, 'type' => 'pic']);

                    $project_files_id = $this->db->insert_id();
                    $fileId = $fileName . $i; // some unique key to identify the file
                    $preview[] = $newFileUrl;
                    $config[] = [
                        'key' => $fileId,
                        'caption' => $fileName,
                        'size' => $fileSize,
                        'downloadUrl' => $newFileUrl, // the url to download the file
                        'url' => base_url('Project_controller/delete_krajee_pic_img/'.$project_files_id), // server api to delete the file based on key
                    ];
                } else {
                    $errors[] = $fileName;
                }
            } else {
                $errors[] = $fileName;
            }
        }
        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
        if (!empty($errors)) {
            $img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }


        echo json_encode($out);
    }

    public function delete_krajee_cad_img($project_files_temp_id = '')
    {
        $file_name = $this->db->get_where('project_files_temp', ['project_files_temp_id' => $project_files_temp_id])->row()->file_name;
        $this->db->delete('project_files_temp', ['project_files_temp_id' => $project_files_temp_id]);
        // unlink('uploads/proj_files/'.$file_name);
        echo json_encode('');
    }

    public function delete_krajee_pic_img($project_files_temp_id = '')
    {
        $file_name = $this->db->get_where('project_files_temp', ['project_files_temp_id' => $project_files_temp_id])->row()->file_name;
        $this->db->delete('project_files_temp', ['project_files_temp_id' => $project_files_temp_id]);
        // unlink('uploads/proj_files/'.$file_name);
        echo json_encode('');
    }


    public function approve_desc($project_description_history_id)
    {
        $project_description_history = $this->db->get_where('project_description_history', ['project_description_history_id' => $project_description_history_id])->row();
        $this->db->update('project_details', ['desc_approval' => 1], ['project_id' => $project_description_history->project_id]);
        $this->db->update('project_description_history', ['seen' => 1, 'approve' => 1], ['project_description_history_id' => $project_description_history_id]);
        redirect('dashboard');
    }

    public function insert_reply()
    {
        $reply = $this->input->post('msg');
        $project_msg_id = $this->input->post('project_msg_id');
        $project_id = $this->input->post('project_id');
        

        // $this->db->update('project_msg', ['reply' => $reply, 'is_eplied' => 1], ['project_msg_id' => $project_msg_id]);
        $this->message_model->insert_reply($project_msg_id, $reply);

        $msg = $this->db->get_where('project_msg', ['project_msg_id' => $project_msg_id])->row();
        $msg_to = $this->db->get_where('user', ['id' => $msg->msg_to])->row()->name;
        $msg_by = $this->db->get_where('user', ['id' => $msg->msg_by])->row()->name;
        $details_string = $msg_to.' > '.$msg_by;
        $user_id = $this->session->userdata('user_id');
        $this->db->insert('project_activity_log', ['project_id' => $project_id, 'activity_type' => 46, 'user_id' => $user_id, 'details' => $details_string]);


        $this->send_email_project_reply($project_id, $reply, $project_msg_id);

        $data = $this->projectmodel->get_project_msg($project_id);

        ?>
        <?php foreach ($data as $key) : ?>
            <tr>
                <td><?= $key->msg_by == '' ? '' : $this->db->get_where('user', ['id' => $key->msg_by])->row()->name  ?></td>
                <td><?= $key->msg_to == 0 || $key->msg_to == null ? '' : $this->db->get_where('user', ['id' => $key->msg_to])->row()->name  ?></td>
                <td><?= $key->msg ?></td>
                <td><?= $key->reply ?></td>
                <td><?= date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd/m/y h:i A'); ?></td>
                <td>
                    <?php if ($key->msg_to != 0) : ?>
                        <?php if ($key->msg_to == $this->session->userdata('user_id')) : ?>
                            <?php if ($key->reply == '') : ?>
                        <button class="btn reply" value="<?php echo $key->project_msg_id ?>" href="<?php echo base_url('Project_controller/msg_history/'.$key->project_id.'/'.$key->msg_to)?>">Reply</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php
    }

    public function send_email_project_reply($project_id = null, $msg = null, $project_msg_id = null)
    {
        $project_details = $this->db->get_where('project_details', ['project_id' => $project_id])->row();
        // $assign_by = $this->db->get_where('project', ['project_id' => $project_id])->row()->assign_by;
        // $assign_by_email = $this->db->get_where('user', ['id' => $assign_by])->row()->email;

        $msg_by = $this->db->get_where('project_msg', ['project_msg_id' => $project_msg_id])->row()->msg_by;
        $msg_by_email = $this->db->get_where('user', ['id' => $msg_by])->row()->email;

        $reciepient = ['oscar@valenciadiamonds.com'];
        $bcc = ['Lily@valenciadiamonds.com', 'jasmine@valenciadiamonds.com', 'jacky@diamonds717.com'];

        array_push($reciepient, $msg_by_email);

        ob_start(); ?>
        A reply added on Project: <a href="<?php base_url('projects/project_details/'.$project_id)?>"></a><?php echo 'J'.$project_id ?> <?php echo $project_details->title ?>
        <br>
        <b>Massage:</b> <?php echo $msg ?>
        <?php
        $data['html'] = ob_get_clean();

        $html = $this->load->view('default_email_template', $data, true);

        $config = $this->email_config();
        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
         $this->email->to($reciepient); // change it to yours
        $this->email->bcc($bcc);
        $this->email->subject("Message added");
        $this->email->message($html);
        $this->email->send();
    }

    public function front_krajee_cad_upload($dynamic_id, $user_email = null)
    {
        // echo $dynamic_i;die;
        // print_r($_FILES['file']);die;

        $user_id = $this->db->get_where('user', ['email' => $user_email])->row()->id;

        if (isset($data['error'])) {
            return print_r(strip_tags($data['error']));
        }


        $preview = [];
        $config = [];
        $errors = [];
        $input = 'file'; // the input name for the fileinput plugin
        if (empty($_FILES[$input])) {
            return [];
        }
        
        $total = count($_FILES[$input]['name']); // multiple files
        // $path = 'uploads/proj_files/'; // your upload path
        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $fileName = time().'_'.preg_replace('/\s+/', '', $_FILES[$input]['name'][$i]); // the file name
            $fileSize = $_FILES[$input]['size'][$i]; // the file size
            
            //Make sure we have a file path
            if ($tmpFilePath != "") {
                //Setup our new file path
                // $newFilePath = $path . $fileName;
                // $newFileUrl = base_url('uploads/proj_files/') . $fileName;
                
                //Upload the file into the new path
                if ($newFileUrl = $this->upload($fileName, $tmpFilePath)) {
                    $this->db->insert('project_files_temp', ['file_name' => $fileName, 'dynamic_id' => $dynamic_id, 'user_id' => $user_id, 'type' => 'cad']);

                    $project_files_id = $this->db->insert_id();
                    $fileId = $fileName . $i; // some unique key to identify the file
                    $preview[] = $newFileUrl;
                    $config[] = [
                        'key' => $fileId,
                        'caption' => $fileName,
                        'size' => $fileSize,
                        'downloadUrl' => $newFileUrl, // the url to download the file
                        'url' => base_url('Project_controller/delete_krajee_cad_img/'.$project_files_id), // server api to delete the file based on key
                    ];
                } else {
                    $errors[] = $fileName;
                }
            } else {
                $errors[] = $fileName;
            }
        }
        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
        if (!empty($errors)) {
            $img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }


        echo json_encode($out);
    }


    public function front_krajee_pic_upload($dynamic_id, $user_email = null)
    {
        // echo $dynamic_i;die;
        // print_r($_FILES['file']);die;

        $user_id = $this->db->get_where('user', ['email' => $user_email])->row()->id;

        if (isset($data['error'])) {
            return print_r(strip_tags($data['error']));
        }


        $preview = [];
        $config = [];
        $errors = [];
        $input = 'file'; // the input name for the fileinput plugin
        if (empty($_FILES[$input])) {
            return [];
        }
        
        $total = count($_FILES[$input]['name']); // multiple files
        // $path = 'uploads/proj_files/'; // your upload path
        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
            $fileName = time().'_'.preg_replace('/\s+/', '', $_FILES[$input]['name'][$i]); // the file name
            $fileSize = $_FILES[$input]['size'][$i]; // the file size
            
            //Make sure we have a file path
            if ($tmpFilePath != "") {
                //Setup our new file path
                // $newFilePath = $path . $fileName;
                // $newFileUrl = base_url('uploads/proj_files/') . $fileName;
                
                //Upload the file into the new path
                if ($newFileUrl = $this->upload($fileName, $tmpFilePath)) {
                    $this->db->insert('project_files_temp', ['file_name' => $fileName, 'dynamic_id' => $dynamic_id, 'user_id' => $user_id, 'type' => 'pic']);

                    $project_files_id = $this->db->insert_id();
                    $fileId = $fileName . $i; // some unique key to identify the file
                    $preview[] = $newFileUrl;
                    $config[] = [
                        'key' => $fileId,
                        'caption' => $fileName,
                        'size' => $fileSize,
                        'downloadUrl' => $newFileUrl, // the url to download the file
                        'url' => base_url('Project_controller/delete_krajee_pic_img/'.$project_files_id), // server api to delete the file based on key
                    ];
                } else {
                    $errors[] = $fileName;
                }
            } else {
                $errors[] = $fileName;
            }
        }
        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
        if (!empty($errors)) {
            $img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }


        echo json_encode($out);
    }

    public function desc_permission($project_description_history_id)
    {
        $project_id = $this->db->get_where('project_description_history', ['project_description_history_id' => $project_description_history_id])->row()->project_id;
        $this->db->update('project_description_history', ['approve' => 1], ['project_description_history_id' => $project_description_history_id]);
        $this->db->update('project_details', ['desc_approval' => 1], ['project_id' => $project_id]);
    }

    public function spec_permission($project_specification_history_id)
    {
        $project_id = $this->db->get_where('project_specification_history', ['project_specification_history_id' => $project_specification_history_id])->row()->project_id;
        $this->db->update('project_specification_history', ['approve' => 1], ['project_specification_history_id' => $project_specification_history_id]);
        // $this->db->update('project_details', ['desc_approval' => 1], ['project_id' => $project_id]);
    }

    public function reset_all_disposition($project_id = '')
    {
        
        $this->projectmodel->reset_all_disposition($project_id);

        $data['project_disposition'] = $this->projectmodel->disposition_details($project_id);
        $data['client_approval'] = $this->client_approval();
        $this->load->view('project_dispositions', $data);
    }

    public function view_dispositions()
    {
        $this->login_check();
        $this->permission_by_designation([1,6,8]);

        $data['disposition'] = $this->db->get('disposition')->result();

        $this->load->view('view_dispositions', $data);
    }

    public function add_disposition_indi()
    {
        $disposition = $this->input->post('disposition');
        $this->db->insert('disposition', $disposition);
        $this->session->set_flashdata('disposition', 'success');
        redirect('view_dispositions');
    }

    public function delete_disposition_indi($disposition_id)
    {
        $id = [44, 45, 46, 3, 47, 48, 49, 50];
        // $disabled = false;
        if (!in_array($key->disposition_id, $id)) {
            $this->db->delete('disposition', ['disposition_id' => $disposition_id]);
        }
    }

    public function FunctionName($value = '')
    {
        echo $this->date_convert('2019-06-07 11:55:32', 'UTC', 'America/Chicago', 'Y-m-d H:i:s');
    }

    function date_convert($time, $oldTZ, $newTZ, $format)
    {
        // create old time
        $d = new \DateTime($time, new \DateTimeZone($oldTZ));
        // convert to new tz
        $d->setTimezone(new \DateTimeZone($newTZ));

        // output with new format
        return $d->format($format);
    }

    public function disposition_change_option($project_id, $val)
    {
        
        $this->projectmodel->disposition_change_option($project_id, $val);

        $data['project_disposition'] = $this->projectmodel->disposition_details($project_id);
        $data['client_approval'] = $this->client_approval();
        $this->load->view('project_dispositions', $data);

        // print_r($disposition_ids);die;
    }

    public function approve_estimate($project_id)
    {
        $this->db->update('project_details', ['estimated_approve' => 1], ['project_id' => $project_id]);
        // $this->session->set_flashdata('approve_estimate', 'success');
        redirect('projects/project_details/'.$project_id);
    }

    public function change_cad_progress($project_id = '', $value = '')
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        if (!in_array($designation_id, [1, 6, 9])) {
            return redirect('/projects/project_details/'.$project_id);
        }

        switch ($value) {
            case 'hold':
                $cad_progress = 'On Hold';
                break;
            case 'in_progress':
                $cad_progress = 'In Progress';
                break;
            case '3d_printing':
                $cad_progress = '3D Printing Only';
                break;
            case 'ready':
                $cad_progress = 'Ready';
                break;
            case 'waiting_for_approval':
                $cad_progress = 'Waiting For Approval';
                break;
        }

        $this->db->update('project_details', ['cad_progress' => $cad_progress], ['project_id' => $project_id]);

        $this->db->insert('project_tracking_history', ['project_id' => $project_id, 'type_of_change' => 2, 'cad_progress' => $cad_progress]);

        $this->session->set_flashdata('cad_progress', $cad_progress);
        redirect('/projects/project_details/'.$project_id);
        // $this->project_details($project_id);
    }

    public function seen_cad_progession($project_tracking_history_id)
    {
        $this->db->update('project_tracking_history', ['seen' => 1], ['project_tracking_history_id' => $project_tracking_history_id]);
    }

    public function recover_archive($project_files_id)
    {
        $this->db->update('project_files', ['is_archive' => 0], ['project_files_id' => $project_files_id]);
    }

    public function add_archive_group($project_id, $value)
    {
        $this->db->insert('project_archive_group', ['project_id' => $project_id, 'group_name' => rawurldecode($value)]);
    }

    public function seen_project_msg($project_msg_id)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        if (in_array($designation_id, [1,6])) {
            $this->db->update('project_msg', ['admin_seen' => 1], ['project_msg_id' => $project_msg_id]);
        } else {
            $this->db->update('project_msg', ['seen' => 1], ['project_msg_id' => $project_msg_id]);
        }
    }

    public function seen_project_reply($project_msg_id)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        if (in_array($designation_id, [1,6])) {
            $this->db->update('project_msg', ['admin_reply_seen' => 1], ['project_msg_id' => $project_msg_id]);
        } else {
            $this->db->update('project_msg', ['reply_seen' => 1], ['project_msg_id' => $project_msg_id]);
        }
    }

    public function seen_all_project_msg($project_msg_id)
    {
        $this->db->update('project_msg', ['seen' => 1]);
    }

    public function create_note()
    {
        $note = $this->input->post('note');
        $note['user_id'] = $this->session->userdata('user_id');
        
        $this->db->insert('project_notes', $note);
    }

    public function delete_note($project_note_id = null)
    {
        $this->db->delete('project_notes', ['project_note_id' => $project_note_id]);
    }

    public function project_shiping($client_id)
    {
        $job_action = $this->input->post('job_action');

        if ($job_action == 'ship') {
            $tracking = $this->input->post('tracking');
            if ($tracking == '') {
                ob_start(); ?>
                <script>
                    alert('Please dont leave tracking field blank')
                    window.history.go(-1);
                </script>
                <?php echo ob_get_clean();
                return;
            }
            $project_id = $this->input->post('project_id');
          
            foreach ($project_id as $key) {
                $this->db->update('project_details', ['tracking' => $tracking, 'type' => 'completed'], ['project_id' => $key]);
                $this->db->update('project_disposition', ['flag' => 1], ['project_id' => $key]);
                $this->db->update('project_disposition_internal', ['flag' => 1], ['project_id' => $key]);
            }

            redirect('details/trade/'.$client_id);
        }
    }


    public function all_estimated_projects()
    {
        $this->login_check();

        $this->permission_by_designation([1,6]);

        $data['estimated_projects'] = $this->projectmodel->get_all_estimated_projects();

        $this->load->view('all_estimated_projects', $data);
    }

    public function get_all_estimated_projects()
    {
        echo 'dasd';
    }

    public function estimate_status_seen($project_tracking_history_id)
    {
        $this->projectmodel->estimate_status_seen($project_tracking_history_id);
    }

    public function estimate_requests_seen($project_tracking_history_id)
    {
        $this->projectmodel->estimate_requests_seen($project_tracking_history_id);
    }

    public function seen_estimate_price_track($project_tracking_history_id)
    {
        $this->projectmodel->seen_estimate_price_track($project_tracking_history_id);
    }

    public function download_activity_log()
    {
        $project_id = $this->input->post('project_id');
        $filename = $this->input->post('filename');
        $user_id = $this->session->userdata('user_id');

        $this->db->insert('project_activity_log', ['project_id' => $project_id, 'user_id' => $user_id, 'activity_type' => 51, 'details' => $filename]);
    }

    public function remind_me_later()
    {
        $this->load->helper('cookie');
        $this->input->set_cookie('remind_me_later', 'success', 60*60*24);
        // echo "dasd";
    }

    public function change_estimate_approve($project_id)
    {
        $project_id;
        $type = $this->input->post('type');
        if ($type == '4') {
            $this->load->helper('cookie');
            $this->input->set_cookie('ignore', 'success', 60*60*24);
            // echo "dasd";
            return;
        }
        // die;
        $this->db->update('project_details', ['estimated_approve' => $type], ['project_id' => $project_id]);
        $this->projectmodel->insert_estimate_status($project_id, $type);
    }


    public function set_alert($project_id, $type)
    {
        $this->db->update('project_details', ['alert' => $type], ['project_id' => $project_id]);
        redirect('projects/project_details/'.$project_id);
    }

    public function sent_alert()
    {
        $projects = $this->db->select('project_id')->where(['alert' => 1])->get('project_details')->result();

        $project_ids = array_column($projects, 'project_id');

        if (empty($project_ids)) {
            return;
        }

        $users = $this->db->select('asign_user')->where_in('project_id', $project_ids)->get('project')->result();

        $users = array_unique(array_column($users, 'asign_user'));

        foreach ($users as $key) {
            $ids = $this->db->select('project.project_id')->join('project_details', 'project.project_id = project_details.project_id')->where(['asign_user' => $key, 'alert' => 1])->get('project')->result();
            $ids = array_column($ids, 'project_id');

            $user = $this->db->get_where('user', ['id' => $key])->row();

            ob_start() ?>
            <p class="msg">Job <?php foreach ($ids as $key) : ?> 
            <a href="<?php echo base_url('projects/project_details/'.$key) ?>" class="job_link">J-<?php echo $key ?></a>,
                               <?php endforeach; ?> <?php echo count($ids) > 1 ? 'are' : 'is' ?> on hold and need your attention.</p>
            <?php
            $data['name'] = $user->name;
            $data['html'] = ob_get_clean();

            echo $html = $this->load->view('default_email_template', $data, true);

            $config = $this->email_config();
            $this->load->library('email', $config);

            $this->email->set_newline("\r\n");
            $this->email->set_mailtype("html");
            $this->email->from($this->email_form, 'Master Casting'); // change it to yours
            $this->email->to($user->email); // change it to yours
            $this->email->subject("Mastercasting job alert");
            $this->email->message($html);
            $this->email->send();
        }
    }

    
    public function get_alerted_projects()
    {
        $user_id = $this->session->userdata('user_id');

        $ids = $this->db->select('project.project_id')->join('project_details', 'project.project_id = project_details.project_id')->where(['asign_user' => $user_id, 'alert' => 1])->get('project')->result();

        $ids = array_column($ids, 'project_id');

        echo json_encode($ids);
    }



    // oct 03
    public function get_ship_services($project_id = 1001){
        return $services = $this->projectmodel->get_ship_services($project_id);
    }


    public function get_ship_services_options(){
        $project_id = $this->input->post('project_id');
        $type = $this->input->post('type');
        $ship_service = $this->projectmodel->get_ship_services($project_id, $type);

        ob_start(); ?>
        <option value="" selected="" disabled="">Select ship method</option>
        <?php 
        foreach ($ship_service as $key => $value): ?>
        <option value="<?php echo $key ?>"><?php echo $value ?></option>
        <?php endforeach;
        echo ob_get_clean();
    }


    public function project_action(){
        $action = $this->input->post('action');

        $data['project_ids'] = $this->input->post('project_id');
        $data['range_date'] = $this->input->post('range_date');
        

        switch ($action) {
            case 'report':
                $this->get_report_jobs($data);
                break;
            
            default:
                die('wrong action');
                break;
        }
    }

    public function get_report_jobs($data){

        if(isset($data['range_date'])){
            $data['range_date'] = explode('-', $data['range_date']);
            $start_date = date('Y-m-d', strtotime($data['range_date'][0]));
            $end_date = date('Y-m-d', strtotime($data['range_date'][1]));
        }
        

        if(empty($data['project_ids'])){
            $data['projects'] = $this->db->select('project_id, price, priority, po, title, DATE(created_at)')->where("DATE(created_at) BETWEEN DATE('$start_date') AND DATE('$end_date')")->get('project_details')->result();
        } else{
            $project_ids = $data['project_ids'];
            $data['projects'] = $this->db->select('project_id, price, priority, po, title, DATE(created_at)')->where_in('project_id', $project_ids)->get('project_details')->result();
        }

        $price = array_column($data['projects'], 'price');

        $data['price'] = array_sum($price);

        return $this->load->view('report_of_jobs', $data);
    }

    public function save_ship_action($project_id){
        $ship = $this->input->post('ship');
        $client_address = $this->input->post('client_address');

        $ship['project_id'] = $project_id;

        $is_ship_exist = $this->db->get_where('ship', ['project_id' => $project_id])->row();
        

        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        // $this->form_validation->set_rules('ship[customer_email]', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('ship[shipping_type]', 'Shipping Type', 'required');
        // $this->form_validation->set_rules('ship[custom_value]', 'Shipping Custom Value', 'required');

        if($this->form_validation->run() === false){
            echo validation_errors();
            return;
        }

        if($ship['shipping_type'] == 'ship_to_client'){
            $this->form_validation->set_rules('client_address[address1]', 'Shipping address', 'required');
            $this->form_validation->set_rules('client_address[city]', 'Shipping city', 'required');
            $this->form_validation->set_rules('client_address[state]', 'Shipping region', 'required');
            $this->form_validation->set_rules('client_address[zip]', 'Shipping postal code', 'required');
            $this->form_validation->set_rules('client_address[country]', 'Shipping country', 'required');

            if($this->form_validation->run() === false){
                echo validation_errors();
                return;
            }
        }


        if($ship['shipping_type'] == 'drop_ship'){
            $this->form_validation->set_rules('ship[country]', 'Shipping country', 'required');
            $this->form_validation->set_rules('ship[address]', 'Shipping address', 'required');
            $this->form_validation->set_rules('ship[city]', 'Shipping city', 'required');
            if($ship['country'] != 'GB')
                $this->form_validation->set_rules('ship[region]', 'Shipping region', 'required');

            $this->form_validation->set_rules('ship[postal_code]', 'Shipping postal code', 'required');

            if($this->form_validation->run() === false){
                echo validation_errors();
                return;
            }
        }

        $user_id = $this->projectmodel->get_client_id($project_id);
        $ship['city'] = ucwords(strtolower($ship['city']));
        $client_address['city'] = ucwords(strtolower($client_address['city']));

        if($ship['shipping_type'] == 'ship_to_client'){
            $this->db->update('user', $client_address, ['id' => $user_id]);
        }



        if(empty($is_ship_exist)){
            $this->db->insert('ship', $ship);
        } else {
            $this->db->update('ship', $ship, ['project_id' => $project_id]);
        }

        redirect('projects/project_details/'.$project_id.'/#project_printing_ship_label');
    }

    public function api_injected_projects()
    {
        $this->login_check();

        $data['projects'] = $this->projectmodel->get_injected_projects();
       
        $this->load->view('all_projects', $data);
    }

    public function get_all_shipping_list(){
        $this->login_check();

        if($this->shipping_lists_sort_by()){
            return true;
        }
        // die();
        
        $data['projects'] = $this->projectmodel->get_all_shipping_lists();

        $this->load->view('shipping_lists', $data);
    }
    public function shipping_lists_sort_by(){
        $sort_by = $this->input->get('sort_by');

        if(!$this->input->get('sort_by'))
            return false;
        else{
            $data['projects'] =  $this->projectmodel->get_all_shipping_lists();

            if($this->input->get('sort_by') ==  'indi'){
                $indi = $this->input->get('indi');
                $data['indi_list'] = $this->member_model->get_all_retail_clients();
                if($indi){
                    $data['projects'] =  $this->projectmodel->get_all_shipping_lists('indi', $indi);
                }
            }
            elseif($this->input->get('sort_by') == 'comp'){
                $data['comp_list'] = $this->member_model->get_all_companies();
                $comp = $this->input->get('comp');
                if($comp){
                    $data['projects'] =  $this->projectmodel->get_all_shipping_lists('comp', $comp);
                }
            }

            $this->load->view('shipping_lists', $data);
            return true;       
        }
    }

    
    public function get_total_rate(){
        $project_id = $this->input->post('project_id');

        if(empty($project_id)){
            echo 'empty';
            return;
        }
        echo $this->projectmodel->get_total_rate($project_id);
    }
    //end oct 03
    
    

    //dashboard notification load oct 22

    public function get_all_proposal_projects(){

        $proposal_projects = $this->projectmodel->get_proposal_projects();


        ob_start(); ?>

        <!-- BEGIN: Comments -->
        <?php foreach ($proposal_projects as $key) : ?>
        <?php
        $asign_user = $this->db->get_where('project', ['project_id' => $key->project_id])->row()->asign_user; 
        $company_name = '';

        if($asign_user != 0){
            $asign_user = $this->db->get_where('user', ['id' => $asign_user])->row();
            if($asign_user->designation_id == 7)
                $company_name = $asign_user->company_name;
        }
        ?>
        <div class="mt-comments">
            <div class="mt-comment">
                <!-- <div class="mt-comment-img">
                <img src="../assets/pages/media/users/avatar1.jpg"> </div> -->
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <a href="<?= site_url('projects/project_details/'.$key->project_id) ?>">
                            <span class="mt-comment-author"><?= 'J'.$key->project_id.' '. $key->title.'- ('.$company_name.')' ?></span>
                        </a>
                        <span class="mt-comment-date"> <?= date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M H:i');  ?></span>
                    </div>
                    <div class="mt-comment-text"><?=  strlen($key->description) > 50 ? substr($key->description,0,50)."..." : $key->description; ?></div>
                    <div class="mt-comment-details">
                        <span class="mt-comment-status mt-comment-status-pending">
                            Proposal 
                            <?php 
                            switch ($key->priority) {
                                case 'critical':
                                    $priority = $key->priority;
                                    $priority_class = 'text-danger';
                                    break;
                                case 'high':
                                    $priority = 'rush';
                                    $priority_class = 'text-warning';
                                    break;
                                case 'standard':
                                    $priority = $key->priority;
                                    $priority_class = 'text-success';
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                             ?>
                            <b><span class="<?php echo $priority_class ?>"><?php echo $priority ?></span></b>
                        </span>
                        <ul class="mt-comment-actions">
                            <li>
                                <a href="<?= site_url('projects/update_project_type/approve/'.$key->project_id)?>">Approve</a>
                            </li>
                            <!-- <li>
                                <a href="<?php //site_url('projects/update_project_type/reject/'.$key->project_id)?>">Reject</a>
                            </li> -->
                            <!-- <li>
                                <a href="">Redo</a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- END: Comments -->
        <?php
        echo ob_get_clean();
    }

    public function get_all_inactiveprojects(){

        $inactive_projects = $this->projectmodel->get_inactive_projects();

        ob_start();
        ?>
        <!-- BEGIN: Comments -->
        <?php foreach ($inactive_projects as $key) : ?>
        <?php
        $asign_user = $this->db->get_where('project', ['project_id' => $key->project_id])->row()->asign_user; 
        $company_name = '';

        if($asign_user != 0){
            $asign_user = $this->db->get_where('user', ['id' => $asign_user])->row();
            if($asign_user->designation_id == 7)
                $company_name = $asign_user->company_name;
        }
        ?>
        <div class="mt-comments">
            <div class="mt-comment">
                <!-- <div class="mt-comment-img">
                <img src="../assets/pages/media/users/avatar1.jpg"> </div> -->
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <a href="<?= site_url('projects/project_details/'.$key->project_id) ?>">
                            <span class="mt-comment-author"><?= 'J'.$key->project_id.' '. $key->title.'- ('.$company_name.')' ?></span>
                        </a>
                        <span class="mt-comment-date"> <?= date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M H:i');  ?></span>
                    </div>
                    <div class="mt-comment-text"><?=  strlen($key->description) > 50 ? substr($key->description,0,50)."..." : $key->description; ?></div>
                    <div class="mt-comment-details">
                        <span class="mt-comment-status mt-comment-status-pending">Proposal</span>
                        <ul class="mt-comment-actions">
                            <li>
                                <a href="<?= site_url('projects/update_project_type/approve/'.$key->project_id)?>">Approve</a>
                            </li>
                            <li>
                                <a href="<?= site_url('projects/update_project_type/reject/'.$key->project_id)?>">Reject</a>
                            </li>
                            <!-- <li>
                                <a href="">Redo</a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- END: Comments -->

        <?php
        echo ob_get_clean();
    }

    public function get_all_message(){

        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

        $project_msg = $this->projectmodel->get_dashboard_project_msgs($this->client_approval());

        ob_start(); ?>

        <!-- BEGIN: Comments -->
        <div class="mt-comments">

            <?php foreach ($project_msg as $key) : ?>
            <div class="mt-comment">
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <a href="<?= site_url('projects/project_details/'.$key->project_id.'#message_panel') ?>">
                            <span class="mt-comment-author">
                                <?= 'J'.$key->project_id.' '.$this->db->get_where('project_details', ['project_id' => $key->project_id])->row()->title  ?>
                                (<?php 
                                    if(in_array($designation_id, [5,7])){
                                    $msg_by_des = $this->db->get_where('user', ['id' => $key->msg_by])->row()->designation_id;
                                    if($msg_by_des == 9){
                                        echo 'Cad Team'  ?> - <?php echo $key->msg_to != '' ? $this->db->get_where('user', ['id' => $key->msg_to])->row()->name : '';
                                    } else{
                                        echo $key->msg_by != '' ? $this->db->get_where('user', ['id' => $key->msg_by])->row()->name : ''  ?> - <?php echo $key->msg_to != '' ? $this->db->get_where('user', ['id' => $key->msg_to])->row()->name : '';
                                    }

                                    }else{

                                        echo $key->msg_by != '' ? $this->db->get_where('user', ['id' => $key->msg_by])->row()->name : ''  ?> - <?php echo $key->msg_to != '' ? $this->db->get_where('user', ['id' => $key->msg_to])->row()->name : '';   
                                    }
                                ?>) 

                            </span>
                        </a>
                        <span class="mt-comment-date"><?= date_convert(date('d-m-Y h:i A', strtotime($key->created_at)), 'd M, Y h:i A');  ?></span>
                    </div>
                    <div class="mt-comment-text"> <?= $key->msg ?> </div>
                    <div class="mt-comment-details">
                        <ul class="mt-comment-actions">
                            <li>
                                <a class="seen_msg" data-id="<?= $key->project_msg_id ?>">Seen</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (count($project_msg) == 0) : ?>
            <div class="mt-comment text-center">Empty</div>
            <?php endif ?>
        </div>
        <!-- END: Comments -->
        <?php 
        echo ob_get_clean();
    }


    public function get_all_replies(){

        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

        $project_replies = $this->projectmodel->get_dashboard_project_repllies($this->client_approval());

        ob_start();
        ?>
        <!-- BEGIN: Comments -->
        <div class="mt-comments">
            <?php foreach ($project_replies as $key) : ?>
            <div class="mt-comment">
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <a href="<?= site_url('projects/project_details/'.$key->project_id.'#message_panel') ?>">
                            <span class="mt-comment-author">
                                <?= 'J'.$key->project_id.' '.$this->db->get_where('project_details', ['project_id' => $key->project_id])->row()->title  ?>
                                (<?php 
                                    if(in_array($designation_id, [5,7])){
                                    $msg_by_des = $this->db->get_where('user', ['id' => $key->msg_to])->row()->designation_id;
                                        if($msg_by_des == 9){
                                            echo 'Cad Team' ?> - <?php echo $key->msg_by != '' ? $this->db->get_where('user', ['id' => $key->msg_by])->row()->name : '' ;
                                        } else{
                                            echo $key->msg_to != '' ? $this->db->get_where('user', ['id' => $key->msg_to])->row()->name : '' ?> - <?php echo $key->msg_by != '' ? $this->db->get_where('user', ['id' => $key->msg_by])->row()->name : '';
                                        }

                                    }else{

                                        echo  $key->msg_to != '' ? $this->db->get_where('user', ['id' => $key->msg_to])->row()->name : '' ?> - <?php echo $key->msg_by != '' ? $this->db->get_where('user', ['id' => $key->msg_by])->row()->name : '';   
                                    }
                                ?>) 

                            </span>
                        </a>
                        <span class="mt-comment-date"><?= date_convert(date('d-m-Y h:i A', strtotime($key->created_at)), 'd M, Y h:i A');  ?></span>
                    </div>
                    <div class="mt-comment-text"> <?= $key->reply ?> </div>
                    <div class="mt-comment-details">
                        <ul class="mt-comment-actions">
                            <li>
                                <a class="seen_reply" data-id="<?= $key->project_msg_id ?>">Seen</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (count($project_replies) == 0) : ?>
            <div class="mt-comment text-center">Empty</div>
            <?php endif ?>
        </div>
        <!-- END: Comments -->
        <?php
        echo ob_get_clean();
    }


    public function get_all_description_history(){
        $project_description_history = $this->db->select("*")->join('project', 'project.project_id = project_description_history.project_id')->where(['seen' => 0,'approve' => 0])->order_by('created_at', 'DESC')->limit(10, 0)->get('project_description_history')->result();

        ob_start(); ?>
        <!-- BEGIN: Comments -->
        <?php foreach ($project_description_history as $key) : ?>
            <?php $project_desc = $this->db->get_where('project_details', ['project_id' => $key->project_id])->row() ?>
        <div class="mt-comments">
            <div class="mt-comment">
                <!-- <div class="mt-comment-img">
                <img src="../assets/pages/media/users/avatar1.jpg"> </div> -->
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <a href="<?= site_url('projects/project_details/'.$key->project_id) ?>">
                            <span class="mt-comment-author"><?= 'J'.$key->project_id.' '.$project_desc->title ?></span>
                        </a>
                        <span class="mt-comment-date">Updated at <?= date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M, Y h:i A'); ?></span>
                    </div>
                    <!-- <div class="mt-comment-text"><?=  strlen($key->description) > 50 ? substr($key->description,0,50)."..." : $key->description; ?></div> -->
                    <div class="mt-comment-text">Description changed</div>
                    <div class="mt-comment-details">
                        <!-- <span class="mt-comment-status mt-comment-status-pending">Proposal</span> -->
                        <ul class="mt-comment-actions">
                            <li>
                                <a href="<?= site_url('Project_controller/approve_desc/'.$key->project_description_history_id)?>">Approve</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- END: Comments -->
        <?php
        echo ob_get_clean();
    }

    public function get_estimate_requests(){

        $estimated_projects = $this->projectmodel->get_all_estimated_projects_notification();

        ob_start(); ?>
        <!-- BEGIN: Comments -->
        <?php foreach ($estimated_projects as $key) : ?>
        <div class="mt-comments">
            <div class="mt-comment">
                <!-- <div class="mt-comment-img">
                <img src="../assets/pages/media/users/avatar1.jpg"> </div> -->
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <a href="<?= site_url('projects/project_details/'.$key->project_id) ?>">
                            <span class="mt-comment-author"><?= 'J'.$key->project_id.' '.$key->title ?></span>
                        </a>
                        <span class="mt-comment-date">Added at <?= date_convert(date('d-m-Y H:i:s', strtotime($key->track_added)), 'd M, Y h:i A');  ?></span>
                    </div>

                    <div class="mt-comment-details">
                        <!-- <span class="mt-comment-status mt-comment-status-pending">
                            <span class="text-<?php //echo $estimated_status_class ?>"><?php //echo $estimated_status ?></span>
                        </span> -->
                        <ul class="mt-comment-actions">
                            <li>
                                <a class="estimate_requests_seen_btn" data-id='<?php echo $key->project_tracking_history_id ?>'>Seen</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- END: Comments -->
        <?php 
        echo ob_get_clean();
    }

    public function get_estimate_status(){

        $estimate_status = $this->projectmodel->get_all_estimate_status_notification();

        ob_start(); ?>
        <!-- BEGIN: Comments -->
        <?php foreach ($estimate_status as $key) : ?>
        <div class="mt-comments">
            <div class="mt-comment">
                <!-- <div class="mt-comment-img">
                <img src="../assets/pages/media/users/avatar1.jpg"> </div> -->
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <a href="<?= site_url('projects/project_details/'.$key->project_id) ?>">
                            <span class="mt-comment-author"><?= 'J'.$key->project_id.' '.$key->title ?></span>
                        </a>
                        <span class="mt-comment-date">Updated at <?= date_convert(date('d-m-Y H:i:s', strtotime($key->track_added)), 'd M, Y h:i A');  ?></span>
                    </div>
                    <?php 
                    switch ($key->estimate_status) {
                        case 1:
                            $estimated_status_class = 'success';
                            $estimated_status = 'Approve';
                            break;
                        case 0:
                            $estimated_status_class = 'danger';
                            $estimated_status = 'Decline';
                            break;
                        case 2:
                            $estimated_status_class = 'warning';
                            $estimated_status = 'Revise';
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                     ?>
                    <div class="mt-comment-details">
                        <span class="mt-comment-status mt-comment-status-pending">
                            <span class="text-<?php echo $estimated_status_class ?>"><?php echo $estimated_status ?></span>
                        </span>
                        <ul class="mt-comment-actions">
                            <li>
                                <a class="estimate_status_seen_btn" data-id='<?php echo $key->project_tracking_history_id ?>'>Seen</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- END: Comments -->

        <?php 
        echo ob_get_clean();
    }

    public function get_cad_status(){
        $all_cad_progress_notification = $this->db->where_in('cad_progress', ['Ready', 'On Hold'])->where('type_of_change', 2)->where('seen', 0)->get('project_tracking_history')->result();


        ob_start(); ?>
        <!-- BEGIN: Comments -->
        <?php foreach ($all_cad_progress_notification as $key) : ?>
        <?php $project_desc = $this->db->get_where('project_details', ['project_id' => $key->project_id])->row() ?>
        <?php $asign_user = $this->db->get_where('project', ['project_id' => $key->project_id])->row(); ?>
        <?php $client = $this->db->get_where('user', ['id' => $asign_user->asign_user])->row(); ?>
        <?php 
        // echo '<pre>';
        // print_r($client); die; ?>
        <div class="mt-comments">
            <div class="mt-comment">
                <!-- <div class="mt-comment-img">
                <img src="../assets/pages/media/users/avatar1.jpg"> </div> -->
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <a href="<?= site_url('projects/project_details/'.$key->project_id) ?>">
                            <span class="mt-comment-author"><?= 'J'.$key->project_id.' '.$project_desc->title ?></span>
                        </a>
                        <span class="mt-comment-date">Updated at <?= date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M, Y h:i A'); ?></span>
                        
                    </div>
                    <div class="mt-comment-text">
                      Client: <?php echo $client->name; ?>
                    </div>
                    <div class="mt-comment-text">Cad Status changed to <?php echo $key->cad_progress ?></div>
                    
                    <div class="mt-comment-details">
                        <!-- <span class="mt-comment-status mt-comment-status-pending">Proposal</span> -->
                        <ul class="mt-comment-actions">
                            <li>
                                <a class="seen_cad_progession" data-id="<?php echo $key->project_tracking_history_id ?>">Seen</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- END: Comments -->
        <?php
        echo ob_get_clean();
    }

    public function get_all_dealine_projects(){

        $deadline_projects = $this->projectmodel->get_deadline_projects($this->client_approval());

        ob_start();
        ?>
        <!-- BEGIN: Comments -->
        <div class="mt-comments" id="deadline_projects_comments">                              
        <?php foreach ($deadline_projects as $key) : ?>
        <div class="mt-comment">
            <!-- <div class="mt-comment-img">
            <img src="../assets/pages/media/users/avatar1.jpg"> </div> -->
            <div class="mt-comment-body">
                <div class="mt-comment-info">
                    <a href="<?= site_url('projects/project_details/'.$key->project_id)?>">
                        <span class="mt-comment-author"><?= 'J'.$key->project_id.' '.$key->title?></span>
                    </a>
                    <span class="mt-comment-date">Created at <?= date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M, Y h:i A');  ?></span>
                </div>
                <div class="<?= date('Y-m-d') > $key->deadline ? 'text-danger' : 
                'text-warning'?>">Deadline date - <?= date('d M, Y', strtotime($key->deadline))  ?></div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (count($deadline_projects) == 0) : ?>
        <div class="mt-comment text-center">Empty</div>
        <?php endif ?>
        </div>
        <!-- END: Comments -->
        <?php

        echo ob_get_clean();
    }

    public function get_all_projects_by_ajax(){

        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

        $projects = $this->projectmodel->get_all_projects(10);

        ?>
        <?php 
        $odd = 'odd';
        $cnt = 1;
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
            <tr class="<?= $odd ?> gradeX" ondblclick="window.location='<?= site_url('projects/project_details/'.$key->project_id)?>';" style='cursor:pointer'>
                <td>
                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" name="project_id[]" class="checkboxes" value="<?php echo $key->project_id ?>" />
                        <span></span>
                    </label>
                </td>
                <td style="text-align: center;"><?php echo $cnt ?></td>
                <td>
                    <?= $key->title ?> 
                    <?php if($key->is_api_injected == 1): ?>
                    <i style="color: #1BBC9B;font-weight: bold; margin-left: 5px;" class="fas fa-cogs"></i>
                    <?php endif; ?>
                </td>
                <td><?= $key->po ?></td>
                <?php if(!in_array($designation_id, [9])): ?>
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
                         // if($client->designation_id == 7)
                         //    echo ' - '.$client->company_name;
                    }
                    ?>
                </td>
                <td>
                    <?= $key->assign_by == 0 ? '' : $this->db->get_where('user',['id' => $key->assign_by])->row()->name  ?>
                </td>
                <?php endif; ?>

                <?php if($key->assignee == ''): ?>
                <td></td>
                <?php else: ?>
                <td><?php 
                $assignees = explode(',', $key->assignee);
                $i = 1;
                foreach ($assignees as $key_one => $value) {
                    // echo $value;
                    $assignees[$key_one] = $this->db->get_where('user',['id' => $value])->row()->name;
                    if(in_array($designation_id, [5,7])){
                        $assignee_des = $this->db->get_where('user',['id' => $value])->row()->designation_id;
                        if($assignee_des == 9){
                            $assignees[$key_one] = 'Cad Team '.$i;
                            $i++;
                        }
                    }
                }
                // print_r($assignees);
                echo implode(', ', $assignees);
                 ?></td>
                <?php endif; ?>

                <?php if(in_array($designation_id, [1,6,8,9])): ?>
                <td style="text-align: center"><span class="badge <?php echo $cad_progress_color ?>"><?php echo $key->cad_progress ?></span></td>
                <?php endif; ?>


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

                <!-- <td><?= ($key->deadline == '0000-00-00' || $key->deadline > date('Y-m-d')) ? 'NA' : time_elapsed_string($key->deadline) ?></td> -->
                <td><?php
                 if($key->deadline != '0000-00-00'){
                    if($key->deadline > date('Y-m-d'))
                        echo '+ '.timespan(time(),strtotime($key->deadline), 1);
                    else
                        echo '- '.timespan(strtotime($key->deadline), time(), 1);
                 }
                 ?></td>

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

                <td class="text-center"><a class="badge badge-success" href="<?= site_url('projects/project_details/'.$key->project_id)?>">J<?= $key->project_id?></a> </td>
            </tr>
        <?php $cnt++; endforeach; ?>
        <?php
    }

    //end dashboard notification load oct 22

    public function get_alerted_projects_by_ajax(){
        $res = $this->db->select('*')->join('project_details', 'project_details.project_id = project.project_id')->where(['project_details.alert' => 1])->where_in('project_details.type', ['completed', 'cancelled'])->get('project')->result();

        // echo '<pre>';
        // print_r($res);

        ob_start(); ?>
        <!-- BEGIN: Comments -->
        <?php foreach ($res as $key) : ?>
        <?php 
        // echo '<pre>';
        // print_r($client); die; ?>
        <div class="mt-comments">
            <div class="mt-comment">
                <!-- <div class="mt-comment-img">
                <img src="../assets/pages/media/users/avatar1.jpg"> </div> -->
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <a href="<?= site_url('projects/project_details/'.$key->project_id) ?>">
                            <span class="mt-comment-author"><?= 'J'.$key->project_id.' '.$key->title ?></span>
                        </a>
                        <span class="mt-comment-date">Updated at <?= date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M, Y h:i A'); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- END: Comments -->
        <?php
        echo ob_get_clean();
    }

    public function get_state_by_country(){

        $id = $this->input->post('id');
        $state_value = $this->input->post('state_value');

        $states = $this->projectmodel->get_states_by_country($id);

        ob_start(); ?>

        <option></option>
        <?php foreach($states as $key): ?>
        <option value="<?php echo $key->iso2 ?>" <?php echo $key->iso2 == $state_value ? 'selected' : '' ?>><?php echo $key->name ?></option>
        <?php endforeach; ?>

        <?php
        echo ob_get_clean();
    }

    public function get_cities_by_search_term(){
        $term = $this->input->get('search');
        $state = $this->input->get('state');
        $country = $this->input->get('country');
        $data = array();

        if($state == ''){
            echo json_encode($data);
            return;
        }

        $state_id = $this->db->get_where('states', ['iso2' => $state, 'country_code' => $country])->row()->id;

        $cities = $this->db->select('id, name')->like('name', $term, 'after')->where(['state_id' => $state_id])->get('cities')->result();


        foreach ($cities as $key) {
            $data[] = array('id' => $key->name, 'text' => $key->name);
        }

        echo json_encode($data);
    }

    public function cad_priority_check($project_id = 9469){
        $user_id = $this->session->userdata('user_id');

        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

        if($designation_id == 1)
            return true;

        $cad_dates = $this->db->select('*')->join('project_details', 'project_details.project_id = cad_slots.project_id')->where(['cad_slots.user_id' => $user_id, 'date' => date('Y-m-d')])->order_by('slot_order', 'ASC')->order_by( 'cad_slots.created_at', 'ASC')->get('cad_slots')->result();
        echo $this->db->last_query();
        $project_details = $this->db->get_where('project_details', ['project_id' => $project_id])->row();

        $cad_date = $this->db->get_where('cad_slots', ['project_id' => $project_id])->row();

        if(empty($cad_date))
            return true;

        if($cad_date->date < date('Y-m-d')){
            return true;
        }
        else if($cad_date->date > date('Y-m-d')){
            return false;
        }

        if($cad_dates[0]->project_id == $project_id && $cad_dates[0]->cad_progress == 'In Progress'){
            return true;
        }
        
        if(in_array($project_details->cad_progress, ['Ready', 'On Hold', 'Waiting For Approval'])){
            return true;
        }

        if(count($cad_dates) <= 2){
            if(in_array($cad_dates[0]->cad_progress, ['Ready', 'On Hold', 'Waiting For Approval'])){
                return true;
            } else {
                return false;
            }
        } elseif(count($cad_dates) > 2){
            foreach ($cad_dates as $key => $value) {
                if($value->project_id == $project_id && $key != 0){
                    $project_key = $key;
                } else if($value->project_id == $project_id && $key == 0) {
                    $project_key = 1;
                }
            }

            if(in_array($cad_dates[$project_key - 1]->cad_progress, ['Ready', 'On Hold', 'Waiting For Approval'])){
                return true;
            } else {
                return false;
            }
        }
    }
    

    public function dropb(){
        return $this->load->view('dropb');
    }

  

}