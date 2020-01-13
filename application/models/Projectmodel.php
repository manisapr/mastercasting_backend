<?php

require_once APPPATH.'config/credentials.php';
require_once APPPATH.'config/bootstrap.php';

date_default_timezone_set('America/Chicago');


ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);


use FedEx\RateService\Request as RateRequest;
use FedEx\RateService\ComplexType as RateComplexType;
use FedEx\RateService\SimpleType as RateSimpleType;

class ProjectModel extends CI_Model
{

    public function get_all_projects($is_client = false)
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [5])) {
            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        }else if (in_array($designation_id, [7])) {
            $company_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->company_id;

            $users = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $user_ids = array_column($users, 'id');

            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->group_start()
                                    ->where_in('assign_by', $user_ids)
                                    ->or_where_in('asign_user', $user_ids)
                                    // ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        } else {
            if(in_array($designation_id, [9])){
                $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
            } else{
                $result = $this->db->order_by('created_at', 'desc')->join('project_details', 'project.project_id = project_details.project_id')->get('project')->result();
            }
        }
        // return $this->db->last_query();

        if (!isset($result)) {
            return false;
        }
        return $result;
        // echo $this->db->last_query();
    }


    public function get_complete_projects($is_client = false)
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [5])) {
            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'completed')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        }else if (in_array($designation_id, [7])) {
            $company_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->company_id;

            $users = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $user_ids = array_column($users, 'id');

            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'completed')
                                ->group_start()
                                    ->where_in('assign_by', $user_ids)
                                    ->or_where_in('asign_user', $user_ids)
                                    // ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        } else {
            if(in_array($designation_id, [9])){
                $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'completed')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
            } else{
                $result = $this->db->order_by('created_at', 'desc')->where('type', 'completed')->join('project_details', 'project.project_id = project_details.project_id')->get('project')->result();
            }
        }

        if (!isset($result)) {
            return false;
        }
        return $result;
        // echo $this->db->last_query();
    }

    public function get_live_projects($is_client = false)
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [5])) {
            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'live')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        }else if (in_array($designation_id, [7])) {
            $company_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->company_id;

            $users = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $user_ids = array_column($users, 'id');

            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'live')
                                ->group_start()
                                    ->where_in('assign_by', $user_ids)
                                    ->or_where_in('asign_user', $user_ids)
                                    // ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        } else {
            if(in_array($designation_id, [9])){
                $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'live')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
            } else{
                $result = $this->db->order_by('created_at', 'desc')->where('type', 'live')->join('project_details', 'project.project_id = project_details.project_id')->get('project')->result();
            }
        }

        if (!isset($result)) {
            return false;
        }
        return $result;
        // echo $this->db->last_query();
    }

    public function get_cancelled_projects($is_client = false)
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [5])) {
            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'cancelled')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        }else if (in_array($designation_id, [7])) {
            $company_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->company_id;

            $users = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $user_ids = array_column($users, 'id');

            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'cancelled')
                                ->group_start()
                                    ->where_in('assign_by', $user_ids)
                                    ->or_where_in('asign_user', $user_ids)
                                    // ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        } else {
            if(in_array($designation_id, [9])){
                $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'cancelled')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
            } else{
                $result = $this->db->order_by('created_at', 'desc')->where('type', 'cancelled')->join('project_details', 'project.project_id = project_details.project_id')->get('project')->result();
            }
        }

        if (!isset($result)) {
            return false;
        }
        return $result;
        // echo $this->db->last_query();
    }


    public function get_injected_projects()
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [5])) {
            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('is_api_injected', 1)
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        } if (in_array($designation_id, [7])) {
            $company_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->company_id;

            $users = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $user_ids = array_column($users, 'id');

            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('is_api_injected', 1)
                                ->group_start()
                                    ->where_in('assign_by', $user_ids)
                                    ->or_where_in('asign_user', $user_ids)
                                    // ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        } else {
            if(in_array($designation_id, [9])){
                $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('is_api_injected', 1)
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
            } else{
                $result = $this->db->order_by('created_at', 'desc')->where('is_api_injected', 1)->join('project_details', 'project.project_id = project_details.project_id')->get('project')->result();
            }
        }

        if (!isset($result)) {
            return false;
        }
        return $result;
        // echo $this->db->last_query();
    }

    public function get_all_proposal_projects($is_client = false)
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [5])) {
            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'proposal')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        }else if (in_array($designation_id, [7])) {
            $company_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->company_id;

            $users = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $user_ids = array_column($users, 'id');

            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'proposal')
                                ->group_start()
                                    ->where_in('assign_by', $user_ids)
                                    ->or_where_in('asign_user', $user_ids)
                                    // ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        } else {
            if(in_array($designation_id, [9])){
                $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->where('type', 'proposal')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
            } else{
                $result = $this->db->order_by('created_at', 'desc')->where('type', 'proposal')->join('project_details', 'project.project_id = project_details.project_id')->get('project')->result();
            }
        }

        if (!isset($result)) {
            return false;
        }
        return $result;
        // echo $this->db->last_query();
    }

    public function check_self_project($check_id)
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [5])) {
            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        }else if (in_array($designation_id, [7])) {
            $company_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->company_id;

            $users = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $user_ids = array_column($users, 'id');

            $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->group_start()
                                    ->where_in('assign_by', $user_ids)
                                    ->or_where_in('asign_user', $user_ids)
                                    // ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
        } else {
            if(in_array($designation_id, [9])){
                $result = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->group_start()
                                    ->where(['assign_by' => $this->session->userdata('user_id')])
                                    ->or_where(['asign_user' => $this->session->userdata('user_id')])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
            } else{
                $result = $this->db->order_by('created_at', 'desc')->join('project_details', 'project.project_id = project_details.project_id')->get('project')->result();
            }
        }
        // return $this->db->last_query();
        
        $project_ids = array_column($result, 'project_id');
        // print_r($project_ids);

        if (in_array($check_id, $project_ids)) {
            return true;
        } else{
            return false;
        }
    }

    public function get_assignee()
    {
        $result = $this->db->join('designation', 'designation.designation_id = user.designation_id')->where_not_in('user.designation_id',[7, 5])->where(['is_deleted' => 0, 'permission' => 1])->order_by('name', 'ASC')->get('user')->result();
        if (!isset($result)) {
            return false;
        }
        return $result;
    }

    public function get_employee()
    {
        $result = $this->db->join('designation', 'designation.designation_id = user.designation_id')->where_in('user.designation_id',[1,6,8,9,10])->get('user')->result();
        if (!isset($result)) {
            return false;
        }
        return $result;
    }

    public function get_manager()
    {
        $result = $this->db->join('designation', 'designation.designation_id = user.designation_id')->where(['user.designation_id' => 6])->get('user')->result();
        if (!isset($result)) {
            return false;
        }
        return $result;
    }

    public function get_client()
    {
        $result = $this->db->join('designation', 'designation.designation_id = user.designation_id')->where_in('user.designation_id', [7, 5])->where(['is_deleted' => 0, 'permission' => 1])->get('user')->result();
        if (!isset($result)) {
            return false;
        }
        return $result;
    }

    public function get_meta_fileds($section, $id)
    {
        $result = $this->db->get_where('meta_fields', ['section' => $section, 'meta_fields_id' => $id])->row();
        if (!isset($result)) {
            return false;
        }
        return $result;
    }

    public function insert_project($data)
    {
        $result = $this->db->insert('project', $data);
        if (!isset($result)) {
            return false;
        }
        return $this->db->insert_id();
    }

    public function insert_project_details($data)
    {
        $result = $this->db->insert('project_details', $data);
        if (!isset($result)) {
            return false;
        }
        return true;
    }

    public function insert_project_specification($data)
    {
        $result = $this->db->insert('project_specification', $data);
        if (!isset($result)) {
            return false;
        }
        return true;
    }
    
    public function insert_project_gem_spec($data)
    {
        $result = $this->db->insert('project_gem_spec', $data);
        if (!isset($result)) {
            return false;
        }
        return true;
    }

    public function get_project($id)
    {
        return $this->db->get_where('project', ['project_id' => $id])->row();
    }

    public function get_project_details($id)
    {
        return $this->db->get_where('project_details', ['project_id' => $id])->row();
    }

    public function get_project_specification($id)
    {
        return $this->db->get_where('project_specification', ['project_id' => $id])->row();
    }

    public function get_project_files($id)
    {
        return $this->db->order_by('created_at', 'desc')->get_where('project_files', ['project_id' => $id, 'is_archive' => 0])->result();
    }

    public function get_project_archive_files($id)
    {
        return $this->db->order_by('created_at', 'desc')
                        ->where(['project_id' => $id, 'is_archive' => 1])
                        ->group_start()
                            ->where(['group_id' => NULL])
                            ->or_where(['group_id' => ''])
                        ->group_end()
                        ->get('project_files')->result();
    }

    public function get_project_archive_files_by_group($id, $group)
    {
        return $this->db->order_by('created_at', 'desc')
                        ->where(['project_id' => $id, 'is_archive' => 1])
                        ->group_start()
                            ->where("FIND_IN_SET('$group', `group_id`)")
                        ->group_end()
                        ->get('project_files')->result();
    }

    public function get_disposition()
    {
        $result = $this->db->order_by('name', 'ASC')->get('disposition')->result();
        if (!isset($result)) {
            return false;
        }
        return $result;
    }

    public function get_proposal_projects()
    {
        $result = $this->db->order_by('created_at', 'desc')->get_where('project_details', ['type' => 'proposal'])->result();
        if (!isset($result)) {
            return false;
        }
        return $result;
    }

    public function get_deadline_projects($client_approval = false)
    {
        if (!$client_approval) {
            return $this->db
                    ->select('project_details.title, project.project_id, project_details.created_at, project_details.deadline')
                    ->order_by('deadline', 'desc')
                    ->where(['type' => 'live', 'deadline <' => date('Y-m-d', strtotime("+3 days"))])
                    ->group_start()
                            ->where(['assign_by' => $this->session->userdata('user_id')])
                            ->or_where(['asign_user' => $this->session->userdata('user_id')])
                    ->group_end()
                    ->join('project', 'project.project_id = project_details.project_id')
                    ->limit(10, 0)
                    ->get('project_details')
                    ->result();
        }
        return $this->db->select('project_details.title, project_details.project_id, project_details.created_at, project_details.deadline')->order_by('deadline', 'desc')->where(['type' => 'live', 'deadline <' => date('Y-m-d', strtotime("+3 days"))])->limit(10, 0)->get('project_details')->result();
    }

    public function update_project_type($type, $id)
    {

        $this->db->update('project_details', ['type' => $type], ['project_id' => $id]);
    }

    public function insert_project_tracking_history($type_of_change, $id, $changes)
    {
        $changes['project_id'] = $id;
        $changes['type_of_change'] = $type_of_change;
        $this->db->insert('project_tracking_history', $changes);
    }

    public function insert_project_msg($data)
    {
        if($data['msg_to'] == 'all_assoc'){
            $asign_user = $this->db->get_where('project', ['project_id' => $data['project_id']])->row()->asign_user;
            $associated_member = $this->get_associated_member($asign_user);
            foreach ($associated_member as $key) {
                $data['msg_to'] = $key->id;
                $this->db->insert('project_msg', $data);
            }
            $data['msg_to'] = $asign_user;
            $this->db->insert('project_msg', $data);
        } else {
            $this->db->insert('project_msg', $data);
        }
    }

    public function get_project_msg($id)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        $company_id = $this->db->get_where('user', ['id' => $user_id])->row()->company_id;
        $associated_member = $this->db->get_where('user', ['company_id' => $company_id])->result();

        $associated_member = array_column($associated_member, 'id');

        if(in_array($designation_id, [5,7]))
            return $result = $this->db->order_by('created_at', 'desc')
                                    ->where('project_id', $id)
                                    ->group_start()
                                        ->where('msg_by', $user_id)
                                        ->or_where('msg_to', $user_id)
                                        ->or_where_in('msg_to', $associated_member)
                                    ->group_end()
                                    ->get('project_msg')
                                    ->result();
        return $result = $this->db->order_by('created_at', 'desc')->get_where('project_msg', ['project_id' => $id])->result();
    }

    public function get_project_notes($project_id){
        return $this->db->order_by('created_at', 'DESC')->get_where('project_notes', ['project_id' => $project_id])->result();
    }

    public function get_dashboard_project_msgs($client_approval = false)
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if(in_array($designation_id, [1,6])){
            return $this->db->order_by('created_at', 'desc')->limit(15)->get_where('project_msg', ['admin_seen' => 0])->result();
        }
        elseif(in_array($designation_id, [5,7])){
            $company_id = $this->db->get_where('user', ['id' => $user_id])->row()->company_id;
            $associated_member = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $associated_member = array_column($associated_member, 'id');

            return $this->db->order_by('project_msg.created_at', 'desc')
                            ->where(['msg_to' => $user_id])
                            // ->where(['msg_by !=' => $user_id])
                            ->or_where_in('msg_to', $associated_member)
                            ->where(['seen' => 0])
                            ->group_start()
                                    ->where(['assign_by' => $user_id])
                                    ->or_where(['asign_user' => $user_id])
                            ->group_end()
                            ->join('project', 'project.project_id = project_msg.project_id')
                            ->get('project_msg')
                            ->result();
        }
        else{
            return $this->db->order_by('project_msg.created_at', 'desc')
                            ->where(['msg_to' => $user_id])
                            ->where(['project_msg.seen' => 0])
                            ->group_start()
                                    ->where(['assign_by' => $user_id])
                                    ->or_where(['asign_user' => $user_id])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                            ->group_end()
                            ->join('project', 'project.project_id = project_msg.project_id')
                            ->join('project_details', 'project_details.project_id = project_msg.project_id')
                            ->get('project_msg')
                            ->result();
        }
    }

    public function get_dashboard_project_repllies($client_approval = false){
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if(in_array($designation_id, [1,6])){
            return $this->db->order_by('created_at', 'desc')->limit(15)->get_where('project_msg', ['is_replied' => 1, 'admin_reply_seen' => 0])->result();
        }
        elseif(in_array($designation_id, [5,7])){
            $company_id = $this->db->get_where('user', ['id' => $user_id])->row()->company_id;
            $associated_member = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $associated_member = array_column($associated_member, 'id');

            return $this->db->order_by('project_msg.created_at', 'desc')
                            ->where(['msg_by' => $user_id])
                            ->or_where_in('msg_by', $associated_member)
                            // ->where(['msg_by !=' => $user_id])
                            ->where(['is_replied' => 1])
                            ->where(['reply_seen' => 0])
                            ->group_start()
                                    ->where(['assign_by' => $user_id])
                                    ->or_where(['asign_user' => $user_id])
                            ->group_end()
                            ->join('project', 'project.project_id = project_msg.project_id')
                            ->get('project_msg')
                            ->result();
        }
        else{
            return $this->db->order_by('project_msg.created_at', 'desc')
                            ->where(['msg_by' => $user_id])
                            ->where(['is_replied' => 1])
                            ->where(['reply_seen' => 0])
                            ->group_start()
                                    ->where(['assign_by' => $user_id])
                                    ->or_where(['asign_user' => $user_id])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                            ->group_end()
                            ->join('project', 'project.project_id = project_msg.project_id')
                            ->join('project_details', 'project_details.project_id = project_msg.project_id')
                            ->get('project_msg')
                            ->result();
        }
    }

    // feb 11 2019
    public function insert_disposition($data, $project_id)
    {
        $query=$this->db->where('project_id', $project_id)->get('project_disposition')->result_array();
        
        if (sizeof($query)<8) {
            $result = $this->db->insert('project_disposition', $data);


            // disposition add activity log
            $user_id = $this->session->userdata('user_id');
            $details_string = $this->db->get_where('disposition', ['disposition_id' => $data['disposition_id']])->row()->name;
            $this->db->insert('project_activity_log',['project_id' => $project_id, 'activity_type' => 12, 'user_id' => $user_id, 'details' =>$details_string]);

            if (!isset($result)) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
    public function disposition_details($project_id)
    {
        $this->db->select('project_disposition.*,disposition.name');
        $this->db->join('disposition', 'project_disposition.disposition_id=disposition.disposition_id');
        $this->db->where('project_disposition.project_id', $project_id);
        $query=$this->db->get('project_disposition')->result_array();
        return $query;
    }
    public function update_disposition($project_disposition_id)
    {
        $result = $this->db->where('project_disposition_id', $project_disposition_id)->update('project_disposition', ['flag'=>1]);
        if (isset($result)) {
            $result = $this->db->get_where('project_disposition', ['project_disposition_id' => $project_disposition_id])->row()->project_id;
            

            //details string      
            $user_id = $this->session->userdata('user_id');
            $project_id = $result;
            $project_disposition = $this->db->get_where('project_disposition',['project_id' => $project_id])->result();
            $updated_project_disposition_id = $project_disposition_id;
            foreach ($project_disposition as $key => $value) {
                if($value->project_disposition_id == $updated_project_disposition_id){
                    if($key == 0) //if first project disposition is updated 
                        $details_string = $this->db->get_where('disposition', ['disposition_id' => $project_disposition[$key]->disposition_id])->row()->name;
                    else //if not then generated string with prev dis
                        $details_string = $this->db->get_where('disposition', ['disposition_id' => $project_disposition[$key-1]->disposition_id])->row()->name.' to '.$this->db->get_where('disposition', ['disposition_id' => $project_disposition[$key]->disposition_id])->row()->name;
                }
            }

            // activity log for disposition update
            $this->db->insert('project_activity_log',['project_id' => $project_id, 'activity_type' => 13, 'user_id' => $user_id, 'details' => $details_string]);
            return $result;
        }
        return false;
    }

    public function revert_disposition($project_disposition_id)
    {
        $user_id = $this->session->userdata('user_id');
        $project_id = $this->db->get_where('project_disposition', ['project_disposition_id' => $project_disposition_id])->row()->project_id;

        $project_reverted_disposition_id = $this->db->get_where('project_disposition', ['project_disposition_id' => $project_disposition_id])->row()->disposition_id;
        
        // details string what disposition reverted
        $details_string = $this->db->get_where('disposition', ['disposition_id' => $project_reverted_disposition_id])->row()->name;

        $this->db->insert('project_activity_log',['project_id' => $project_id, 'activity_type' => 14, 'user_id' => $user_id, 'details' => $details_string]);


        $result = $this->db->query("UPDATE `project_disposition` SET `flag`=0 WHERE project_id= $project_id AND project_disposition_id>= $project_disposition_id");

        if($result)
            return $project_id;
        return false;
    }

    public function delete_disposition($project_disposition_id)
    {
        $user_id = $this->session->userdata('user_id');
        $project_id = $this->db->get_where('project_disposition', ['project_disposition_id' => $project_disposition_id])->row()->project_id;

        $project_deleted_disposition_id = $this->db->get_where('project_disposition', ['project_disposition_id' => $project_disposition_id])->row()->disposition_id;
        $details_string = $this->db->get_where('disposition', ['disposition_id' => $project_deleted_disposition_id])->row()->name;


        $this->db->delete('project_disposition', ['project_disposition_id' => $project_disposition_id]);
        $this->db->insert('project_activity_log',['project_id' => $project_id, 'activity_type' => 15, 'user_id' => $user_id, 'details' => $details_string]);

        return $project_id;
    }

    public function reset_all_disposition($project_id){
        $this->db->delete('project_disposition', ['project_id' => $project_id]);

        //insert disposition
        $disp = [44, 45, 46, 3, 47, 48, 49, 50];
        foreach ($disp as $key) { 
            $this->db->insert('project_disposition', ['project_id' => $project_id, 'disposition_id' => $key]);
        }

        // activity log
        $user_id = $this->session->userdata('user_id');
        $this->db->insert('project_activity_log',['project_id' => $project_id, 'activity_type' => 44, 'user_id' => $user_id]);
    }

    public function disposition_change_option($project_id, $val)
    {
        $user_id = $this->session->userdata('user_id');

        switch ($val) {
            case 'wax':
                $details_string = 'Wax Only';
                $disposition_ids = [44, 56, 46, 49, 50];
                break;
            case 'casting':
                $details_string = 'Casting Only';
                $disposition_ids = [44, 56, 46, 3, 49, 50];
                break;
            case 'repairs':
                $details_string = 'Repairs';
                $disposition_ids = [44, 56, 45, 48, 49, 50];
                break;
        }

        $this->db->delete('project_disposition', ['project_id' => $project_id]);

        foreach ($disposition_ids as $key) {
            $this->db->insert('project_disposition', ['project_id' => $project_id, 'disposition_id' => $key]);
        }



        $this->db->insert('project_activity_log',['project_id' => $project_id, 'activity_type' => 45, 'user_id' => $user_id, 'details' => $details_string]);

    }


    //internal disposition
    public function insert_disposition_internal($data, $project_id)
    {
        $query=$this->db->where('project_id', $project_id)->get('project_disposition_internal')->result_array();
        
        if (sizeof($query)<8) {
            $result = $this->db->insert('project_disposition_internal', $data);
            if (!isset($result)) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function update_disposition_internal($project_disposition_id)
    {
        $result = $this->db->where('project_disposition_id', $project_disposition_id)->update('project_disposition_internal', ['flag'=>1]);
        if (isset($result)) {
            return $this->db->get_where('project_disposition_internal', ['project_disposition_id' => $project_disposition_id])->row()->project_id;
        }
        return false;
    }

    public function disposition_details_internal($project_id)
    {
        $this->db->select('project_disposition_internal.*,disposition.name');
        $this->db->join('disposition', 'project_disposition_internal.disposition_id=disposition.disposition_id');
        $this->db->where('project_disposition_internal.project_id', $project_id);
        $query=$this->db->get('project_disposition_internal')->result_array();
        return $query;
    }

    public function get_project_activity_log($project_id)
    {
        return $this->db->order_by('created_at', 'DESC')->get_where('project_activity_log', ['project_id' => $project_id])->result();
    }

    public function get_print_project_details($project_id)
    {
        return $this->db->get_where('print_project_details', ['project_id' => $project_id])->row();
    }

    public function activity_msg($activity_type_id)
    {
        # code...
    }

    public function get_all_projects_by_id($user_id){
        // return  $this->db->order_by('created_at', 'desc')
        //                         ->join('project_details', 'project.project_id = project_details.project_id')
        //                         ->group_start()
        //                             ->where(['assign_by' => $user_id])
        //                             ->or_where(['asign_user' => $user_id])
        //                         ->group_end()
        //                         ->get('project')
        //                         ->result();
        return $this->db->select("project.*, project_details.*, ship.shipping_type, ship.ship_id, ship.is_shipped, ship.shipping_method")
                                ->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->join('ship', 'project.project_id = ship.project_id')
                                ->group_start()
                                    ->where(['assign_by' => $user_id])
                                    ->or_where(['asign_user' => $user_id])
                                    ->or_where("FIND_IN_SET('$user_id', `assignee`)")
                                ->group_end()
                                ->get('project')
                                ->result();
    }

    public function get_msg_user()    {
        return $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where(['is_deleted' => '0', 'permission' => 1])->get('user')->result();
    }

    public function get_associated_member($user_id){
        $company_id = $this->db->get_where('user', ['id' => $user_id])->row()->company_id;
        return $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where(['is_deleted' => '0', 'permission' => 1, 'user.company_id' => $company_id, 'user.id !=' => $user_id])->get('user')->result();
    }

    public function get_project_archive_group($project_id='')
    {
        return $this->db->get_where('project_archive_group', ['project_id' => $project_id])->result();
    }


    public function get_inactive_projects(){
        // $projects = $this->db->get('project')->result();
		$projects = $this->db->select('project.project_id, project_details.created_at')->join('project_details', 'project.project_id = project_details.project_id')->where(['type' => 'live', 'project_details.created_at <=' => date('Y-m-d', strtotime("+2 days"))])->get('project')->result();
		$project_ids = array_column($projects, 'project_id');

//        $in_active_project_ids = [];

		/*foreach ($projects as $key => $value) {
			$activity = $this->db->select('project_activity_log_id, project_id, created_at')->order_by('created_at', 'DESC')->get_where('project_activity_log', ['project_id' => $value->project_id])->row();
            if(empty($activity)){
				$diff = strtotime($value->created_at) - time();
                $days_diff = abs(round($diff / 86400));
                if($days_diff >= 2)
					array_push($in_active_project_ids, $value->project_id);
            }
            else{
                $diff = strtotime($activity->created_at) - time();
                $days_diff = abs(round($diff / 86400));
                if($days_diff >= 2)
					array_push($in_active_project_ids, $value->project_id);
			}
		}*/
//		$in_active_project = $this->db->order_by('created_at', 'DESC')->where_in('project_id', $in_active_project_ids)->limit(15)->get('project_details')->result();

		$in_active_project = $this->db->order_by('created_at', 'DESC')->where_in('project_id', $project_ids)->limit(15)->get('project_details')->result();
        return $in_active_project;

    }


    public function get_cad_slots_by_project_id($project_id){

        return $this->db->select('*')->join('user', 'user.id = cad_slots.user_id')->join('designation', 'user.designation_id = designation.designation_id')->where(['project_id' => $project_id])->get('cad_slots')->result();
    }

    // new demo
    public function get_all_estimated_projects(){
        return $this->db->select('*')
                ->join('project', 'project.project_id = project_details.project_id')
                ->where('project_details.request_estimate', 1)
                ->order_by('project_details.created_at', 'DESC')
                ->get('project_details')
                ->result();
    }

    public function insert_new_estimated_project_tracking($project_id){
        $this->db->insert('project_tracking_history', ['type_of_change' => 3, 'project_id' => $project_id]);
        $this->db->update('project_details', ['estimated_approve' => 0], ['project_id' => $project_id]);
        return;
    }

    public function insert_estimate_tracking($project_id){
        $this->db->insert('project_tracking_history', ['type_of_change' => 4, 'project_id' => $project_id]);
        $this->db->update('project_details', ['estimated_approve' => 0], ['project_id' => $project_id]);
        return;
    }

    public function insert_estimate_status($project_id, $estimate_status){
        $this->db->insert('project_tracking_history', ['type_of_change' => 5, 'project_id' => $project_id, 'estimate_status' => $estimate_status]);
        if($estimate_status == 1){
            $project_details = $this->db->get_where('project_details', ['project_id' => $project_id])->row();
            $this->db->update('project_details', ['price' => $project_details->estimated_price], ['project_id' => $project_id]);
            $this->db->update('project', ['price' => $project_details->estimated_price], ['project_id' => $project_id]);
        }
        return;
    }

    public function get_all_estimated_projects_notification(){
        return $this->db->select('*, project_tracking_history.created_at as track_added')
                ->join('project_details', 'project_details.project_id = project_tracking_history.project_id')
                ->where('project_tracking_history.type_of_change', 3)
                ->where('project_tracking_history.seen', 0)
                ->order_by('project_tracking_history.created_at', 'DESC')
                ->limit(10)
                ->get('project_tracking_history')
                ->result();
    }

    public function get_all_estimate_price_notification(){
        return $this->db->select('*, project_tracking_history.created_at as track_added')
                ->join('project_details', 'project_details.project_id = project_tracking_history.project_id')
                ->join('project', 'project.project_id = project_tracking_history.project_id')
                ->where('project_tracking_history.type_of_change', 4)
                ->where('project_tracking_history.seen', 0)
                ->group_start()
                    ->where(['project.assign_by' => $this->session->userdata('user_id')])
                    ->or_where(['project.asign_user' => $this->session->userdata('user_id')])
                ->group_end()
                ->order_by('project_tracking_history.created_at', 'DESC')
                ->limit(10)
                ->get('project_tracking_history')
                ->result();
    }

    public function get_all_estimate_status_notification(){
        return $this->db->select('*, project_tracking_history.created_at as track_added')
                ->join('project_details', 'project_details.project_id = project_tracking_history.project_id')
                ->where('project_tracking_history.type_of_change', 5)
                ->where('project_tracking_history.seen', 0)
                ->order_by('project_tracking_history.created_at', 'DESC')
                ->limit(10)
                ->get('project_tracking_history')
                ->result();
    }


    public function estimate_status_seen($project_tracking_history_id){
        $this->db->update('project_tracking_history', ['seen' => 1], ['project_tracking_history_id' => $project_tracking_history_id]);
    } 

    public function estimate_requests_seen($project_tracking_history_id){
        $this->db->update('project_tracking_history', ['seen' => 1], ['project_tracking_history_id' => $project_tracking_history_id]);
    }

    public function seen_estimate_price_track($project_tracking_history_id){
        $this->db->update('project_tracking_history', ['seen' => 1], ['project_tracking_history_id' => $project_tracking_history_id]);
    }


    public function cad_priority_check($project_id = 9469){
        $user_id = $this->session->userdata('user_id');


        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

        if($designation_id == 1)
            return true;


        $cad_dates = $this->db->select('*')->join('project_details', 'project_details.project_id = cad_slots.project_id')->where(['cad_slots.user_id' => $user_id, 'date' => date('Y-m-d')])->order_by('slot_order', 'ASC')->order_by( 'cad_slots.created_at', 'ASC')->get('cad_slots')->result();
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

    public function get_all_cad_dates($user_id){
        return $this->db->select('*')->join('project_details', 'project_details.project_id = cad_slots.project_id')->where(['cad_slots.user_id' => $user_id])->order_by('slot_order', 'ASC')->get('cad_slots')->result();
    }

    public function get_cad_dates_by_date($date, $user_id){
        $date = date('Y-m-d', strtotime($date));
        return $this->db->select('*')->join('project_details', 'project_details.project_id = cad_slots.project_id')->where(['cad_slots.user_id' => $user_id, 'date' => $date])->order_by('slot_order', 'ASC')->order_by( 'cad_slots.created_at', 'ASC')->get('cad_slots')->result();
    }









    public function get_project_ship($project_id){
        return $this->db->get_where('ship', ['project_id' => $project_id])->row();
    }

    public function is_all_ship_form_filed_up($project_id){
        $ship_details = $this->db->get_where('ship', ['project_id' => $project_id])->row();

        if(count($ship_details) == 0)
            return 1;

        if($ship_details->shipping_type == NULL)
            return '***Select a shipping type';

        if($ship_details->shipping_type == 'drop_ship'){

            if(in_array(NULL , [$ship_details->address, $ship_details->city, $ship_details->postal_code, $ship_details->country, $ship_details->shipping_type, $ship_details->shipping_method]))
                return 1;

            if($ship_details->country != 'GB' && $ship_details->region == NULL)
                return 1;
            else if($ship_details->country == 'GB')
                return 0;

        }


        return 0;
    }

    public function get_all_shipping_lists($sort = NULL, $id = NULL){
        $this->db->select('
            user.id,
            user.name,
            companies.company_id,
            companies.company_name,
            project_details.project_id, 
            project_details.title,
            project_details.po,
            project_details.tracking,
            project_details.is_api_injected,
            ship.address,
            ship.city,
            ship.region,
            ship.postal_code,
            ship.country,
            ship.shipping_type,
            ship.shipping_method,
            ship.rate,
            ship.is_shipped,
            ship.manual,
            ship.file');
        $this->db->join('ship', 'ship.project_id = project_details.project_id');
        $this->db->join('project', 'project.project_id = project_details.project_id');
        $this->db->join('user', 'project.asign_user = user.id');
        $this->db->join('companies', 'companies.company_id = user.company_id');
        if($sort !== NULL){
            if($sort == 'comp')
                $this->db->where('user.company_id', $id);
            elseif($sort == 'indi')
                $this->db->where('user.id', $id);
        }
        $result = $this->db->get('project_details')->result();

        foreach($result as $key => $value){
            $ship_address = $this->ship_address($value->project_id, $value->shipping_type);
            $result[$key]->address = $ship_address->address;
            $result[$key]->city = $ship_address->city;
            $result[$key]->region = $ship_address->region;
            $result[$key]->postal_code = $ship_address->postal_code;
            $result[$key]->country = $ship_address->country;
        }
        
        // print_r($result[0]);
        return $result;
    }


    public function get_total_rate($project_id){
        return $this->db->select("SUM(rate) as total_rate")
                    ->where_in('project_id', $project_id)
                    ->get('ship')
                    ->row()->total_rate;
    }


    public function get_client_address($project_id){
        $client_id = $this->db->select('asign_user')->where(['project_id' => $project_id])->get('project')->row()->asign_user;

        // return $this->db->select('asign_user')->where(['project_id' => $project_id])->get('project')->row();

        if($client_id == 0){
            $client_address = new stdClass();//create a new
            $client_address->address = "";
            $client_address->city = "";
            $client_address->state ="";
            $client_address->country ="";
            $client_address->zip ="";
            $client_address->customer_name ="";
            $client_address->customer_phone ="";
            return $client_address;
        }

        return $client_address = $this->db->select('address1 as address, city, state, country, zip, name as customer_name, phone as customer_phone')->where(['id' => $client_id])->get('user')->row();
    }

    public function get_client_id($project_id){
        return $this->db->select('asign_user')->where(['project_id' => $project_id])->get('project')->row()->asign_user;
    }

    public function get_ship_suctomer_email($project_id){
        $client_id = $this->db->select('asign_user')->where(['project_id' => $project_id])->get('project')->row()->asign_user;
        if($client_id == 0){
            $client_mail = new stdClass();//create a new
            $client_mail->email = "";
            return $client_mail;
        }
        return $this->db->select('email')->where(['id' => $client_id])->get('user')->row()->email;
    }

    public function get_mcc_address(){
        return $arrayName['mcc_address'] = (object) array(
            'address' => '68 East Madison Street',
            'city' => 'Chicago',
            'region' => 'IL',
            'postal_code' => 60602,
            'country' => 'US',
            'customer_name' => '',
            'customer_phone' => '312-332-4434',
        );
    }


    public function get_ship_services($project_id = NULL, $type = NULL){

        // echo "<pre>";
        $ship_details = $this->ship_address($project_id, $type);
        $rateRequest = new RateComplexType\RateRequest();

        //authentication & client details
        $rateRequest->WebAuthenticationDetail->UserCredential->Key = FEDEX_KEY;
        $rateRequest->WebAuthenticationDetail->UserCredential->Password = FEDEX_PASSWORD;
        $rateRequest->ClientDetail->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $rateRequest->ClientDetail->MeterNumber = FEDEX_METER_NUMBER;

        $rateRequest->TransactionDetail->CustomerTransactionId = 'testing rate service request';

        //version
        $rateRequest->Version->ServiceId = 'crs';
        $rateRequest->Version->Major = 24;
        $rateRequest->Version->Minor = 0;
        $rateRequest->Version->Intermediate = 0;

        $rateRequest->ReturnTransitAndCommit = true;

        //shipper
        $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
        $rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['68 E Madison Street'];
        $rateRequest->RequestedShipment->Shipper->Address->City = 'Chicago';
        $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'IL';
        $rateRequest->RequestedShipment->Shipper->Address->PostalCode = 60602;
        $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'US';

        //recipient
        $rateRequest->RequestedShipment->Recipient->Address->StreetLines = [$ship_details->address];
        $rateRequest->RequestedShipment->Recipient->Address->City = $ship_details->city;
        $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = $ship_details->country == "GB" ? "" : $ship_details->region;
        $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $ship_details->postal_code;
        $rateRequest->RequestedShipment->Recipient->Address->CountryCode = $ship_details->country;
        $rateRequest->RequestedShipment->Recipient->Address->Residential = $ship_details->residential_address;

        //shipping charges payment
        $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = RateSimpleType\PaymentType::_SENDER;

        //rate request types
        $rateRequest->RequestedShipment->RateRequestTypes = [RateSimpleType\RateRequestType::_PREFERRED, RateSimpleType\RateRequestType::_LIST];

        $rateRequest->RequestedShipment->PackageCount = 1;

        //create package line items
//        $rateRequest->RequestedShipment->RequestedPackageLineItems = [new RateComplexType\RequestedPackageLineItem(), new RateComplexType\RequestedPackageLineItem()];
        $specialServiceRequest = new RateComplexType\PackageSpecialServicesRequested();
        // RateSimpleType\SignatureOptionType::_DIRECT
        $specialServiceRequest
            ->setSpecialServiceTypes( array(RateSimpleType\PackageSpecialServiceType::_SIGNATURE_OPTION))
            ->setSignatureOptionDetail(
                (new RateComplexType\SignatureOptionDetail())->setOptionType($ship_details->signature_type));
        $requestedPackageLineItem = new RateComplexType\RequestedPackageLineItem();
        $requestedPackageLineItem
            ->setSpecialServicesRequested($specialServiceRequest);
        $rateRequest->RequestedShipment->RequestedPackageLineItems = [$requestedPackageLineItem];

        //package 1
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $ship_details->weight;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = $ship_details->weight_unit;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = 10;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = 10;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = 3;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = RateSimpleType\LinearUnits::_IN;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;

        //package 2
       /* $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = 5;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = RateSimpleType\WeightUnits::_LB;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = 20;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = 20;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = 10;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = RateSimpleType\LinearUnits::_IN;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount = 1;*/

        $rateServiceRequest = new RateRequest();
        $rateServiceRequest->getSoapClient()->__setLocation(RateRequest::PRODUCTION_URL); //use production URL

        $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); // send true as the 2nd argument to return the SoapClient's stdClass response.

        // if($rateReply->HighestSeverity === 'ERROR'){
        //      return die($rateReply->Notifications[0]->Message);
        // }

        $services = [];

        if (!empty($rateReply->RateReplyDetails)) {
            foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
                // array_push($services, $rateReplyDetail->ServiceType);
                $services[$rateReplyDetail->ServiceType] = ucwords(strtolower(str_replace('_', ' ', $rateReplyDetail->ServiceType)));
            }
        }

        return $services;
        // print_r($rateReply);
    }

    public function ship_address($project_id, $type = NULL){
        $ship_details = $this->db->get_where('ship', ['project_id' => $project_id])->row();

        if($type == NULL){
            if($ship_details->shipping_type == 'ship_to_client'){
                $client_address = $this->get_client_address($project_id);

                $ship_details->address = $client_address->address;
                $ship_details->city = $client_address->city;
                $ship_details->region = $client_address->state;
                $ship_details->postal_code = $client_address->zip;
                $ship_details->country = $client_address->country;
                $ship_details->customer_name = $client_address->customer_name;
                $ship_details->customer_phone = $client_address->customer_phone;
            } else if($ship_details->shipping_type == 'ship_to_mcc'){
                $mcc_address = $this->get_mcc_address($project_id);

                $ship_details->address = $mcc_address->address;
                $ship_details->city = $mcc_address->city;
                $ship_details->region = $mcc_address->region;
                $ship_details->postal_code = $mcc_address->postal_code;
                $ship_details->country = $mcc_address->country;
                $ship_details->customer_name = $mcc_address->customer_name;
                $ship_details->customer_phone = $mcc_address->customer_phone;
            }

        } else{
            if($type == 'ship_to_client'){
                $client_address = $this->get_client_address($project_id);

                $ship_details->address = $client_address->address;
                $ship_details->city = $client_address->city;
                $ship_details->region = $client_address->state;
                $ship_details->postal_code = $client_address->zip;
                $ship_details->country = $client_address->country;
                $ship_details->customer_name = $client_address->customer_name;
                $ship_details->customer_phone = $client_address->customer_phone;
            } else if($type == 'ship_to_mcc'){
                $mcc_address = $this->get_mcc_address($project_id);

                $ship_details->address = $mcc_address->address;
                $ship_details->city = $mcc_address->city;
                $ship_details->region = $mcc_address->region;
                $ship_details->postal_code = $mcc_address->postal_code;
                $ship_details->country = $mcc_address->country;
                $ship_details->customer_name = $mcc_address->customer_name;
                $ship_details->customer_phone = $mcc_address->customer_phone;
            }

        }

        $ship_details->customer_email = $this->get_ship_suctomer_email($project_id);

        return $ship_details;
    }


    public function get_full_shipping_address($project_id, $type){
        $ship_address = $this->ship_address($project_id, $type);
        return $ship_address->address.', '.$ship_address->city.', '.$ship_address->region.', '.$ship_address->country.' - '.$ship_address->postal_code;
    }

    public function get_all_shipping_history_by_client($user_id){


        $projects = $this->get_all_projects_by_id($user_id);
        $ship_history = [];

        $project_ids = array_column($projects, 'project_id');

        if(empty($project_ids))
            return $ship_history;

        $ship = $this->db->select('*')
                                ->where_in('project_id', $project_ids)
                                ->where_in('is_shipped', 1)
                                ->order_by('shipped_at', 'group_id')
                                ->get('ship')->result();

        $cnt = 0;
        // $ship_id_tmp = [];
        // $cnt = 0;
        foreach ($ship as $key => $value) {
            // $ship_tmp = [];
            // $tmp = $value->group_id;
            if($value->group_id == 0){
                $ship_tmp['project_id'] = $value->project_id;
                $ship_tmp['group_id'] = $value->group_id;
                $ship_tmp['address'] = $this->get_full_shipping_address($value->project_id, $value->shipping_type);
                $ship_tmp['shipping_type'] = $value->shipping_type;
                $ship_tmp['tracking'] = $this->db->get_where('project_details', ['project_id' => $value->project_id])->row()->tracking;
                $ship_tmp['shipping_method'] = $value->shipping_method;
                $ship_tmp['file'] = $value->file;

                array_push($ship_history, $ship_tmp);
                $cnt = 0;

            }
            else{
                $ship_tmp_grp = $this->db->select('project_id')->where(['group_id' => $value->group_id])->get('ship')->result();

                $ship_tmp['project_id'] = array_column($ship_tmp_grp, 'project_id');
                $ship_tmp['group_id'] = $value->group_id;
                $ship_tmp['address'] = $this->get_full_shipping_address($value->project_id, $value->shipping_type);
                $ship_tmp['shipping_type'] = $value->shipping_type;
                $ship_tmp['tracking'] = $this->db->get_where('project_details', ['project_id' => $value->project_id])->row()->tracking;
                $ship_tmp['shipping_method'] = $value->shipping_method;
                $ship_tmp['file'] = $value->file;

                if($cnt == 0)
                    array_push($ship_history, $ship_tmp);
                $cnt++;
            }
        }

        return $ship_history;
    }

    public function get_percentile_rate($rate){
        $percentage = 10;
        return round($rate + ($rate*$percentage)/100, 2);
    }

    public function get_all_countries(){
        return $this->db->select('iso2')->select('name')->select('id')->from('countries')->get()->result();
    }  
    
    public function get_states_by_country($id){
        return $this->db->select('iso2')->select('name')->from('states')->where(['country_id' => $id])->order_by('name')->get()->result();
    }

}
