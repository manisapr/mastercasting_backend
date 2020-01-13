<?php

class Message_model extends CI_Model
{

    public function get_message($limit, $start, $keyword, $sort_by_me = '', $is_archive = '')
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        // $limit = 10;
        // $start = 0;

        if (in_array($designation_id, [1,6])) {
            $this->db->order_by('created_at', 'desc');
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            $this->db->limit($limit, $start);
            if ($sort_by_me != '') {
                $this->db->where('msg_to', $user_id);
            }
            if ($is_archive != '') {
                $this->db->where('is_archive', 1);
            } else {
                $this->db->where('is_archive', 0);
            }
            return $this->db->get('project_msg')->result();
        } elseif (in_array($designation_id, [5,7])) {
            $company_id = $this->db->get_where('user', ['id' => $user_id])->row()->company_id;
            $associated_member = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $associated_member = array_column($associated_member, 'id');

            $this->db->order_by('project_msg.created_at', 'desc');
            $this->db->where(['msg_to' => $user_id]);
            $this->db->or_where_in('msg_to', $associated_member);
            $this->db->group_start();
                    $this->db->where(['assign_by' => $user_id]);
                    $this->db->or_where(['asign_user' => $user_id]);
            $this->db->group_end();
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            if ($is_archive != '') {
                $this->db->where('is_archive', 1);
            } else {
                $this->db->where('is_archive', 0);
            }
            $this->db->join('project', 'project.project_id = project_msg.project_id');
            $this->db->limit($limit, $start);
            return $this->db->get('project_msg')->result();
        } else {
            $this->db->order_by('project_msg.created_at', 'desc');
            $this->db->where(['msg_to' => $user_id]);
            $this->db->group_start();
                    $this->db->where(['assign_by' => $user_id]);
                    $this->db->or_where(['asign_user' => $user_id]);
                    $this->db->or_where("FIND_IN_SET('$user_id', `assignee`)");
            $this->db->group_end();
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            if ($is_archive != '') {
                $this->db->where('is_archive', 1);
            } else {
                $this->db->where('is_archive', 0);
            }
            $this->db->join('project', 'project.project_id = project_msg.project_id');
            $this->db->join('project_details', 'project_details.project_id = project_msg.project_id');
            $this->db->limit($limit, $start);
            return $this->db->get('project_msg')->result();
        }
    }

    public function insert_reply($project_msg_id, $reply)
    {
        $this->db->query("UPDATE `project_msg` SET `reply` = '$reply', `is_replied` = 1, `replied_at` = NOW() WHERE `project_msg_id` = '$project_msg_id'");
    }

    public function get_message_count($keyword, $sort_by_me = '', $is_archive = '')
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [1,6])) {
            $this->db->order_by('created_at', 'desc');
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            if ($sort_by_me != '') {
                $this->db->where('msg_to', $user_id);
            }
            if ($is_archive != '') {
                $this->db->where('is_archive', 1);
            } else {
                $this->db->where('is_archive', 0);
            }
            $result = $this->db->get('project_msg')->result();
            return count($result);
        } elseif (in_array($designation_id, [5,7])) {
            $company_id = $this->db->get_where('user', ['id' => $user_id])->row()->company_id;
            $associated_member = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $associated_member = array_column($associated_member, 'id');

            $this->db->order_by('project_msg.created_at', 'desc');
            $this->db->where(['msg_to' => $user_id]);
            $this->db->or_where_in('msg_to', $associated_member);
            $this->db->group_start();
                    $this->db->where(['assign_by' => $user_id]);
                    $this->db->or_where(['asign_user' => $user_id]);
            $this->db->group_end();
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            if ($is_archive != '') {
                $this->db->where('is_archive', 1);
            } else {
                $this->db->where('is_archive', 0);
            }
            $this->db->join('project', 'project.project_id = project_msg.project_id');
            $result = $this->db->get('project_msg')->result();
            return count($result);
        } else {
            $this->db->order_by('project_msg.created_at', 'desc');
            $this->db->where(['msg_to' => $user_id]);
            $this->db->group_start();
                    $this->db->where(['assign_by' => $user_id]);
                    $this->db->or_where(['asign_user' => $user_id]);
                    $this->db->or_where("FIND_IN_SET('$user_id', `assignee`)");
            $this->db->group_end();
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            if ($is_archive != '') {
                $this->db->where('is_archive', 1);
            } else {
                $this->db->where('is_archive', 0);
            }
            $this->db->join('project', 'project.project_id = project_msg.project_id');
            $this->db->join('project_details', 'project_details.project_id = project_msg.project_id');
            $this->db->limit($limit, $start);
            $result = $this->db->get('project_msg')->result();
            return count($result);
        }
    }

    public function mark_as_read($project_msg_id)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        $this->db->where_in('project_msg_id', $project_msg_id);
        if (in_array($designation_id, [1,6])) {
            $this->db->update('project_msg', ['admin_seen' => 1]);
        } else {
            $this->db->update('project_msg', ['seen' => 1]);
        }
    }

    public function mark_as_read_reply_btn($project_msg_id)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        $this->db->where_in('project_msg_id', $project_msg_id);
        if (in_array($designation_id, [1,6])) {
            $this->db->update('project_msg', ['admin_reply_seen' => 1]);
        } else {
            $this->db->update('project_msg', ['seen' => 1]);
        }
    }

    public function set_as_archive($project_msg_id)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        $this->db->where_in('project_msg_id', $project_msg_id);
        $this->db->update('project_msg', ['is_archive' => 1]);
        // if (in_array($designation_id, [1,6])) {
        // } else {
        //     $this->db->update('project_msg', ['seen' => 1]);
        // }
    }

    public function mark_as_unread($project_msg_id)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        $this->db->where_in('project_msg_id', $project_msg_id);
        if (in_array($designation_id, [1,6])) {
            $this->db->update('project_msg', ['admin_seen' => 0]);
        } else {
            $this->db->update('project_msg', ['seen' => 0]);
        }
    }

    public function mark_as_reply_unread($project_msg_id)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        $this->db->where_in('project_msg_id', $project_msg_id);
        if (in_array($designation_id, [1,6])) {
            $this->db->update('project_msg', ['admin_reply_seen' => 0]);
        } else {
            $this->db->update('project_msg', ['reply_seen' => 0]);
        }
    }


    public function get_replies($limit, $start, $keyword, $sort_by_me = '')
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [1,6])) {
            $this->db->order_by('replied_at', 'desc');
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            $this->db->limit($limit, $start);
            $this->db->where(['is_replied' => 1]);
            if ($sort_by_me != '') {
                $this->db->where('msg_by', $user_id);
            }
            return $this->db->get('project_msg')->result();

            // return $this->db->order_by('replied_at', 'desc')->get_where('project_msg', ['is_replied' => 1, 'admin_reply_seen' => 0])->result();
        } elseif (in_array($designation_id, [5,7])) {
            $company_id = $this->db->get_where('user', ['id' => $user_id])->row()->company_id;
            $associated_member = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $associated_member = array_column($associated_member, 'id');

            $this->db->order_by('project_msg.replied_at', 'desc');
            $this->db->where(['msg_by' => $user_id]);
            $this->db->or_where_in('msg_by', $associated_member);
            $this->db->where(['is_replied' => 1]);
            $this->db->group_start();
                    $this->db->where(['assign_by' => $user_id]);
                    $this->db->or_where(['asign_user' => $user_id]);
            $this->db->group_end();
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            $this->db->join('project', 'project.project_id = project_msg.project_id');
            $this->db->limit($limit, $start);
            return $this->db->get('project_msg')->result();
        } else {
            $this->db->order_by('project_msg.replied_at', 'desc');
            $this->db->where(['msg_by' => $user_id]);
            $this->db->where(['is_replied' => 1]);
            $this->db->group_start();
                    $this->db->where(['assign_by' => $user_id]);
                    $this->db->or_where(['asign_user' => $user_id]);
                    $this->db->or_where("FIND_IN_SET('$user_id', `assignee`)");
            $this->db->group_end();
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            $this->db->join('project', 'project.project_id = project_msg.project_id');
            $this->db->join('project_details', 'project_details.project_id = project_msg.project_id');
            $this->db->limit($limit, $start);
            return $this->db->get('project_msg')->result();
        }
    }

    public function get_reply_count($keyword, $sort_by_me)
    {
        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        $user_id = $this->session->userdata('user_id');

        if (in_array($designation_id, [1,6])) {
            $this->db->order_by('created_at', 'desc');
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            $this->db->where(['is_replied' => 1]);
            if ($sort_by_me != '') {
                $this->db->where('msg_by', $user_id);
            }
            $result = $this->db->get('project_msg')->result();
            return count($result);
        } elseif (in_array($designation_id, [5,7])) {
            $company_id = $this->db->get_where('user', ['id' => $user_id])->row()->company_id;
            $associated_member = $this->db->get_where('user', ['company_id' => $company_id])->result();

            $associated_member = array_column($associated_member, 'id');

            $this->db->order_by('project_msg.created_at', 'desc');
            $this->db->where(['msg_by' => $user_id]);
            $this->db->or_where_in('msg_by', $associated_member);

            $this->db->where(['is_replied' => 1]);
            $this->db->group_start();
                    $this->db->where(['assign_by' => $user_id]);
                    $this->db->or_where(['asign_user' => $user_id]);
            $this->db->group_end();
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            $this->db->join('project', 'project.project_id = project_msg.project_id');
            $result = $this->db->get('project_msg')->result();
            return count($result);
        } else {
            $this->db->order_by('project_msg.created_at', 'desc');
            $this->db->where(['msg_to' => $user_id]);
            $this->db->where(['is_replied' => 1]);
            $this->db->group_start();
                    $this->db->where(['assign_by' => $user_id]);
                    $this->db->or_where(['asign_user' => $user_id]);
                    $this->db->or_where("FIND_IN_SET('$user_id', `assignee`)");
            $this->db->group_end();
            if ($keyword != '') {
                $this->db->like('project_id', $keyword, 'right');
            }
            $this->db->join('project', 'project.project_id = project_msg.project_id');
            $this->db->join('project_details', 'project_details.project_id = project_msg.project_id');
            $result = $this->db->get('project_msg')->result();
            return count($result);
        }
    }
}