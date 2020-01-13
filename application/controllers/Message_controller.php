<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_controller extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model("message_model");
    }

    public function login_check()
    {
        if (!$this->session->userdata('user_id')) {
            return redirect();
        }
    }

    public function index()
    {
        $this->login_check();


        $limit = 10;
        $start = 0;

        $user_id = $this->session->userdata('user_id');
        // $data['project_msg'] = $this->message_model->get_message($limit, $start);
        // $data['project_replies'] = $this->message_model->get_replies();


        $this->load->view('project_messages');
    }

    public function get_message_pagination()
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;
        $last_login = $this->db->get_where('user', ['id' => $user_id])->row()->last_login;

        $keyword = $this->uri->segment(4);
        $sort_by_me = $this->input->get('sort_by_me');
        $is_archive = $this->input->get('is_archive');
        // // $output['html'] = 'didjaoisjd';
        // $output['html'] =  $key;
        // // $output['html'] =  $this->message_model->get_message_count($keyword, $sort_by_me);
        // $output['pagination_link'] = $this->db->last_query();
        // echo json_encode($output);die;


        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->message_model->get_message_count($keyword, $sort_by_me, $is_archive);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = true;
        $config["full_tag_open"] = '<ul class="pagination pagination-msg">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];

        $output = array(
            'pagination_link'  => $this->pagination->create_links(),
        );

        // if($keyword != ''){
        //  echo json_encode(['html' => $keyword, 'pagination_link' => 'good']);
        //  $messages = $this->message_model->get_message($config["per_page"], $start);
        // }else{
        // }
        $messages = $this->message_model->get_message($config["per_page"], $start, $keyword, $sort_by_me, $is_archive);

        ob_start(); ?>
        <?php if (!empty($messages)) : ?>
            <?php foreach ($messages as $key) : ?>
                <?php
                if (in_array($designation_id, [1,6])) {
                    if ($key->admin_seen == 0) {
                        $seen = 0;
                    } else {
                        $seen = 1;
                    }
                } else {
                    if ($key->seen == 0) {
                        $seen = 0;
                    } else {
                        $seen = 1;
                    }
                }

                ?>
        <li class="list-group-item list-group-item-action shadow-sm <?php echo $seen == 1 ? 'read' : '' ?>" style="cursor: pointer;">
            <div style="display: inline;flex: 0 0 350px;cursor: pointer;">
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="msg-checkboxes" name="project_msg_id[]" value="<?php echo $key->project_msg_id ?>" require/>
                    <span></span>
                </label>
                <span class="msg_project_id" style="width: 90%;display: inline-block;" onclick="window.location='<?php echo base_url('Message_controller/single_message/'.$key->project_msg_id) ?>'">
                    <b>J<?php echo $key->project_id ?></b>
                    <small>
                        <?php if (in_array($designation_id, [1,6])) : ?>
                        <b>(<?php echo $this->db->get_where('user', ['id' => $key->msg_by])->row()->name.' - '.$this->db->get_where('user', ['id' => $key->msg_to])->row()->name ?>)</b>
                        <?php elseif (in_array($designation_id, [5,7])) : ?>
                            <?php $msg_by_des = $this->db->get_where('user', ['id' => $key->msg_by])->row()->designation_id; ?>
                            <?php if ($msg_by_des == 9) : ?>
                            <b>(Cad Member)</b>
                            <?php else : ?>
                            <b>(<?php echo $this->db->get_where('user', ['id' => $key->msg_by])->row()->name ?>)</b>
                            <?php endif; ?>
                        <?php else : ?>
                        <b>(<?php echo $this->db->get_where('user', ['id' => $key->msg_by])->row()->name ?>)</b>
                        <?php endif; ?>
                    </small>
                    <?php if ($last_login < $key->created_at && $seen == 0) : ?>
                      <span class="badge badge-pill badge-primary">New</span>
                    <?php endif; ?>
                </span> 
            </div>
            <div onclick="window.location='<?php echo base_url('Message_controller/single_message/'.$key->project_msg_id) ?>'" style="display: inline;flex: 1 1 auto;">
                <?php echo mb_strimwidth($key->msg, 0, 75, "..."); ?>
            </div>
            <div class="list-info">
                <span class="list-date" style="height: 100%; text-align: center; width: 100%"><small><b><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->created_at)), 'd M h:i A'); ?></b></small></span>
                <span class="btn-group list-action">
                    <?php if ($seen == 0) : ?>
                    <button type="button" value="<?php echo $key->project_msg_id ?>" class="fas fa-envelope-open btn btn-default mark_as_read_btn" data-toggle="tooltip" data-placement="bottom" title="Mark as read"></button>
                    <?php else : ?>
                    <button type="button" value="<?php echo $key->project_msg_id ?>" class="fas fa-envelope btn btn-default mark_as_unread_btn" data-toggle="tooltip" data-placement="bottom" title="Mark as unread"></button>
                    <?php endif; ?>
                    <!-- <button style="margin-left: 10px!important" class="fas fa-trash btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Delete"></button> -->
                </span>
            </div>
        </li>
            <?php endforeach;
        else : ?>
        <a class="list-group-item list-group-item-action shadow-sm">No result</a>
        <?php endif; ?>
        <?php
        $output['html'] = ob_get_clean();
        echo json_encode($output);
    }

    public function get_reply_pagination()
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;
        $last_login = $this->db->get_where('user', ['id' => $user_id])->row()->last_login;

        $keyword = $this->uri->segment(4);
        $sort_by_me = $this->input->get('sort_by_me');


        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->message_model->get_reply_count($keyword, $sort_by_me);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = true;
        $config["full_tag_open"] = '<ul class="pagination pagination-reply">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];

        $output = array(
            'pagination_reply_link'  => $this->pagination->create_links(),
        );

        // if($keyword != ''){
        //  echo json_encode(['html' => $keyword, 'pagination_link' => 'good']);
        //  $messages = $this->message_model->get_message($config["per_page"], $start);
        // }else{
        // }
        $messages = $this->message_model->get_replies($config["per_page"], $start, $keyword, $sort_by_me);

        ob_start(); ?>
        <?php if (!empty($messages)) : ?>
            <?php foreach ($messages as $key) : ?>
                <?php
                if (in_array($designation_id, [1,6])) {
                    if ($key->admin_reply_seen == 0) {
                        $seen = 0;
                    } else {
                        $seen = 1;
                    }
                } else {
                    if ($key->reply_seen == 0) {
                        $seen = 0;
                    } else {
                        $seen = 1;
                    }
                }

                ?>
        <li class="list-group-item list-group-item-action shadow-sm <?php echo $seen == 1 ? 'read' : '' ?>" style="cursor: pointer;">
            <div style="display: inline;flex: 0 0 350px;cursor: pointer;">
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="checkboxes" name="project_msg_id[]" value="<?php echo $key->project_msg_id ?>" require/>
                    <span></span>
                </label>
                <span class="msg_project_id" style="width: 90%;display: inline-block;" onclick="window.location='<?php echo base_url('Message_controller/single_reply/'.$key->project_msg_id) ?>'">
                    <b>J<?php echo $key->project_id ?></b>
                    <small>
                        <?php if (in_array($designation_id, [1,6])) : ?>
                        <b>(<?php echo $this->db->get_where('user', ['id' => $key->msg_to])->row()->name.' - '.$this->db->get_where('user', ['id' => $key->msg_by])->row()->name ?>)</b>
                        <?php elseif (in_array($designation_id, [5,7])) : ?>
                            <?php $msg_to_des = $this->db->get_where('user', ['id' => $key->msg_to])->row()->designation_id; ?>
                            <?php if ($msg_to_des == 9) : ?>
                            <b>(Cad Member)</b>
                            <?php else : ?>
                            <b>(<?php echo $this->db->get_where('user', ['id' => $key->msg_to])->row()->name ?>)</b>
                            <?php endif; ?>
                        <?php else : ?>
                        <b>(<?php echo $this->db->get_where('user', ['id' => $key->msg_to])->row()->name ?>)</b>
                        <?php endif; ?>
                    </small>
                    <?php if ($last_login < $key->replied_at && $seen == 0) : ?>
                      <span class="badge badge-pill badge-primary new-msg">New</span>
                    <?php endif; ?>
                </span> 
            </div>
            <div onclick="window.location='<?php echo base_url('Message_controller/single_reply/'.$key->project_msg_id) ?>'" style="display: inline;flex: 1 1 auto;">
                <?php echo mb_strimwidth($key->reply, 0, 75, "..."); ?>
            </div>
            <div class="list-info">
                <span class="list-date" style="height: 100%; text-align: center; width: 100%"><small><b><?php echo date_convert(date('d-m-Y H:i:s', strtotime($key->replied_at)), 'd M h:i A'); ?></b></small></span>
                <span class="btn-group list-action">
                    <?php if ($seen == 0) : ?>
                    <button type="button" value="<?php echo $key->project_msg_id ?>" class="fas fa-envelope-open btn btn-default mark_as_read_reply_btn" data-toggle="tooltip" data-placement="bottom" title="Mark as read"></button>
                    <?php else : ?>
                    <button type="button" value="<?php echo $key->project_msg_id ?>" class="fas fa-envelope btn btn-default mark_as_read_unread_btn" data-toggle="tooltip" data-placement="bottom" title="Mark as unread"></button>
                    <?php endif; ?>
                    <!-- <button style="margin-left: 10px!important" class="fas fa-trash btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Delete"></button> -->
                </span>
            </div>
        </li>
            <?php endforeach;
        else : ?>
        <a class="list-group-item list-group-item-action shadow-sm">No result</a>
        <?php endif; ?>
        <?php
        $output['reply_html'] = ob_get_clean();
        echo json_encode($output);
    }


    public function single_message($project_msg_id = null)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        if (in_array($designation_id, [1,6])) {
            $this->db->update('project_msg', ['admin_seen' => 1], ['project_msg_id' => $project_msg_id]);
        } else {
            $this->db->update('project_msg', ['seen' => 1], ['project_msg_id' => $project_msg_id]);
        }

        $data['project_msg'] = $this->db->get_where('project_msg', ['project_msg_id' => $project_msg_id])->row();
        $this->load->view('project_single_messages', $data);
    }

    public function single_reply($project_msg_id = null)
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;

        if (in_array($designation_id, [1,6])) {
            $this->db->update('project_msg', ['admin_reply_seen' => 1], ['project_msg_id' => $project_msg_id]);
        } else {
            $this->db->update('project_msg', ['reply_seen' => 1], ['project_msg_id' => $project_msg_id]);
        }

        $data['project_msg'] = $this->db->get_where('project_msg', ['project_msg_id' => $project_msg_id])->row();
        $this->load->view('project_single_reply', $data);
    }

    public function mark_as_read($project_msg_id = null)
    {
        if ($project_msg_id != null) {
            $this->message_model->mark_as_read([$project_msg_id]);
            return;
        }
        $project_msg_id = $this->input->post('project_msg_id');
        $msgtype = $this->input->post('msgtype');
        // print_r($project_msg_id);die;
        $this->message_model->mark_as_read($project_msg_id);
        return;
    }

    public function mark_as_read_reply_btn($project_msg_id = null)
    {
        if ($project_msg_id != null) {
            $this->message_model->mark_as_read_reply_btn([$project_msg_id]);
            return;
        }
        $project_msg_id = $this->input->post('project_msg_id');
        $msgtype = $this->input->post('msgtype');
        // print_r($project_msg_id);die;
        // echo $project_msg_id;
        $this->message_model->mark_as_read_reply_btn($project_msg_id);
        return;
    }

    public function set_as_archive($project_msg_id = null)
    {
        if ($project_msg_id != null) {
            $this->message_model->set_as_archive([$project_msg_id]);
            return;
        }
        $project_msg_id = $this->input->post('project_msg_id');
        $msgtype = $this->input->post('msgtype');
        // print_r($project_msg_id);die;
        $this->message_model->set_as_archive($project_msg_id);
        return;
    }

    public function mark_as_unread($project_msg_id = null)
    {
        if ($project_msg_id != null) {
            $this->message_model->mark_as_unread([$project_msg_id]);
            return;
        }
        $project_msg_id = $this->input->post('project_msg_id');

        $this->message_model->mark_as_unread($project_msg_id);
        return;
    }


    public function mark_as_reply_unread($project_msg_id = null)
    {
        if ($project_msg_id != null) {
            $this->message_model->mark_as_reply_unread([$project_msg_id]);
            return;
        }
        $project_msg_id = $this->input->post('project_msg_id');

        $this->message_model->mark_as_reply_unread($project_msg_id);
        return;
    }
}
