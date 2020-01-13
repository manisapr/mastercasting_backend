<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_controllers extends CI_Controller {

    // private $email_form = 'apache@mastercastingandcad.com';
    private $email_form = 'oscar@www.mastercastingandcad.com';

	function __construct() {
		parent::__construct();
		//$this->load->helper(form);
		$this->load->model("database_model");
		$this->load->model("projectmodel");
		$this->load->model("member_model");
		$this->load->library('email');
		$this->load->library('pagination');
		$this->load->helper("url");
	}

	  private function email_config(){
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
            'wordwrap' => TRUE
        );
    }


	public function index() {
		if(!$this->session->userdata('username'))
			return $this->load->view('login');
		return redirect('dashboard'); 
	}

	public function login() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run()) {

			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			$this->load->model('database_model');
			if($this->db->get_where('user', ['email' => $username])->num_rows() > 0){
				$permission = $this->db->get_where('user', ['email' => $username])->row()->permission;
				if($permission == 0){
					$this->session->set_flashdata('error', 'You are on hold.');
					return redirect();
				}
			}

			if ($this->database_model->can_login($username, $password)) {
				redirect('dashboard');
			} else {
				$this->session->set_flashdata('error', 'Invalid username and password');
				redirect();
			}
		} else {
			$this->login();
		}
	}

	public function login_check(){
        if (!$this->session->userdata('user_id')) {
            return redirect();
        }
    }
	
	public function enter() {
		if ($this->session->userdata('username') != '') {
			echo '<h2>Welcome -' . $this->session->userdata('username') . '</h2>';
			echo '<label><a href="' . base_url('Master_controllers/logout') . '">Logout</a></label>';
		} else {
			redirect();
		}

	}
	
	public function logout() {
		$this->session->unset_userdata(['username','user_id','designation_id']);
		redirect();
	}
	
	public function dashboard() {

		if (isset($this->session->userdata['username']) == FALSE) {

			redirect();
		} else {

			$user_id = $this->session->userdata('user_id');
			$designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

			// $data['pending_projects'] = $this->database_model->pending_projects();
			// $data['pending_projects_manager'] = $this->database_model->pending_projects_manager();
			// $data['pending_projects_user'] = $this->database_model->pending_projects_user();

			// $data['view_all_message'] = $this->database_model->view_all_message();

			// $data['view_manager_message'] = $this->database_model->view_manager_message();
			// $data['view_user_message'] = $this->database_model->view_user_message();

			//new 
			$data['client_approval'] = $this->client_approval();
			// $data['proposal_projects'] = $this->projectmodel->get_proposal_projects();
			// $data['deadline_projects'] = $this->projectmodel->get_deadline_projects($this->client_approval());

			// if(in_array($designation_id, [1,6,8])){
			// 	$data['inactive_projects'] = $this->projectmodel->get_inactive_projects();
			// }

			// print_r($data['deadline_projects']);die;
			// $data['project_msg'] = $this->projectmodel->get_dashboard_project_msgs($this->client_approval());
			// $data['project_replies'] = $this->projectmodel->get_dashboard_project_repllies($this->client_approval());

			

			if(in_array($designation_id, [1,6,8,9])){
				$data['all_project_cnt'] = count($this->projectmodel->get_all_projects());
				$data['cancelled_project_cnt'] = count($this->projectmodel->get_cancelled_projects());
				$data['live_project_cnt'] = count($this->projectmodel->get_live_projects());
				$data['completed_project_cnt'] = count($this->projectmodel->get_complete_projects());
			} else {
				$data['all_project_cnt'] = count($this->projectmodel->get_all_projects(true));
				$data['cancelled_project_cnt'] = count($this->projectmodel->get_cancelled_projects(true));
				$data['live_project_cnt'] = count($this->projectmodel->get_live_projects(true));
				$data['completed_project_cnt'] = count($this->projectmodel->get_complete_projects(true));
			}

			if(in_array($designation_id,[1,6,8])){
				// $data['all_cad_progress_notification'] = $this->db->get_where('project_tracking_history', ['type_of_change' => 2, 'seen' => 0])->result();
		        $data['all_cad_progress_notification'] = $this->db->where_in('cad_progress', ['Ready', 'On Hold'])->where('type_of_change', 2)->where('seen', 0)->limit(15)->get('project_tracking_history')->result();
			}

			
			//description history 
			// $data['project_description_history'] = $this->db->select("*")->join('project', 'project.project_id = project_description_history.project_id')->where(['seen' => 0,'approve' => 0])->order_by('created_at', 'DESC')->limit(15)->get('project_description_history')->result();
			//end description history 


			//cads calenders data
			if(in_array($designation_id, [9])){
		    	$data['cad_slots'] = $this->projectmodel->get_all_cad_dates($user_id);
		    	$data['vacations'] = $this->db->get_where('vacations', ['user_id' => $user_id])->result();

		    	$data['cad_3d_print_date'] = $this->db->get_where('cad_3d_print_date', ['user_id' => $user_id])->result();

			}
			//end cads calenders data

			//estimated projects
			// if(in_array($designation_id, [1,6])){
			// 	$data['estimated_projects'] = $this->projectmodel->get_all_estimated_projects_notification();
			// 	$data['estimate_status'] = $this->projectmodel->get_all_estimate_status_notification();
			// }

			if(in_array($designation_id, [5,7])){
				$data['estimate_price_notification'] = $this->projectmodel->get_all_estimate_price_notification();
			}
			//end estimated projects

			$this->load->view('index', $data);
		}
	}

	public function dynamic_id(){
        $digits = 8;
        $user = $this->db->get('user')->result();
        $check = false;

        while (!$check) {
            $dynamic_id = rand(pow(10, $digits-1), pow(10, $digits)-1);
            foreach ($user as $key) {
                if ($dynamic_id != $key->dynamic_id) {
                    $check = true;
                }
            }
        }

        return $dynamic_id;
    }

	public function client() {

		{
			if (isset($this->session->userdata['username']) == FALSE) {

				redirect();
			} else {
				$this->load->model("database_model");
				$result["get_data"] = $this->database_model->get_data();
				$this->load->view("client", $result);
				//print_r($result);
			}

		}
	}

	public function insert_user() {
        $this->login_check();

		$this->load->model("database_model");
		$data = array(
			'name' => ucwords(strtolower($this->input->post('user_name'))),
			'username' => preg_replace('/\s+/', '', $this->input->post('user_username')),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'designation_id' => $this->input->post('sample_1_length'),
			// 'password' => MD5($this->input->post('password')),
			'dynamic_id' => $this->dynamic_id()
		);
		// print_r($data);die;
		$cnt = $this->db->get_where('user', ['email' => $this->input->post('email')])->num_rows();

		if($cnt > 0){
		 echo '
    				<script>
    					alert("User already exist with this email id: '.$this->input->post('email').'");
    					window.location.replace("'.base_url('Master_controllers/all_team_members').'");
    				</script>
    				';
            return;
		}

		$username_cnt = $this->db->get_where('user', ['username' => $data['username']])->num_rows();

		if($username_cnt > 0){
		 echo '
    				<script>
    					alert("User already exist with this Username: '.$data['username'].'");
    					window.location.replace("'.base_url('Master_controllers/all_team_members').'");
    				</script>
    				';
            return;
		}

		//print_r($data);
		//die;
		if($this->input->post('sample_1_length') == 1)
			$data['permission'] = 1;

		$digits = 4;
		$ps = rand(pow(10, $digits-1), pow(10, $digits)-1);

		$data['password'] = md5($ps);
		$data['ps'] = $ps;


		$this->database_model->insert_user($data);
		$user =  $this->db->insert_id();

		$this->send_email_new_user($this->input->post('email'), $ps);
		return redirect(DOMAIN.'/add-user/?user='.$user);
		// redirect("Master_controllers/all_team_members");

	}

    public function send_email_new_user($email, $ps){
    	// $mail = $this->input->post('mail');
    	// // print_r($mail);die;
    	// $email = $this->db->get_where('user', ['id' => $user_id])->row()->email;
    	ob_start(); ?>
		<p>You are added by admin as a member in mastercasting. You can login using your email and this password (<?php echo $ps ?>). You can also change password later. You can login  <a href="<?php echo base_url() ?>">here</a>.</p>
    	<?php
    	$html = ob_get_clean();

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


    // members
	public function all_team_members() {
		if (!$this->session->userdata('user_id')) {
            return redirect();
        }
		 
		$data["members"] = $this->member_model->get_all_members();
		$this->load->view('team_members', $data);
	}

	public function all_designer() {
		if (isset($this->session->userdata['username']) == FALSE) {

			redirect();
		} else {
			$this->load->model("database_model");
			$result["get_designer"] = $this->database_model->get_designer_data();
			$this->load->view('team_designer', $result);
		}
	}

	public function all_casting() {
		if (isset($this->session->userdata['username']) == FALSE) {

			redirect();
		} else {
			$this->load->model("database_model");
			$result["get_casting"] = $this->database_model->get_casting_data();
			$this->load->view('team_casting', $result);
		}
	}

	public function all_packing() {
		if (isset($this->session->userdata['username']) == FALSE) {

			redirect();
		} else {
			$this->load->model("database_model");
			$result["get_packing"] = $this->database_model->get_packing_data();
			$this->load->view('team_packing', $result);
		}
	}

	public function all_manager() {
		if (!$this->session->userdata('user_id')) {
            return redirect();
        }
		 
		$data["members"] = $this->member_model->get_all_manager();
		$this->load->view('team_manager', $data);
	}

	public function all_sales_rep() {
		if (!$this->session->userdata('user_id')) {
            return redirect();
        }
		 
		$data["members"] = $this->member_model->get_all_sales_rep();
		$this->load->view('team_sales_rep', $data);
	}

	public function all_cad() {
		if (!$this->session->userdata('user_id')) {
            return redirect();
        }

		$data["members"] = $this->member_model->get_all_cad();
		$this->load->view('team_cad', $data);
		
	}

	public function edit_profile() {
	    $this->login_check();

		if (isset($this->session->userdata['username']) == FALSE) {
			redirect('Master_conteollers/index');
		} else {
			$user_id = $this->session->userdata('user_id');
			$query['data'] = $this->database_model->select_by_username($user_id);
			$query['countries'] = $this->projectmodel->get_all_countries();
			$this->load->view('edit_profile', $query);
		}
	}

	public function update_profile() {
        $this->login_check();

		$id = $this->input->post('id');
		$user = $this->input->post('user');
		$result = $this->database_model->profile_update($id, $user);
		if(!$result)
			$this->session->set_flashdata('profile_update', 'error');
		else
			$this->session->set_flashdata('profile_update', 'success');

		redirect('edit_profile');
	}

	public function user_delete($user_id) {
		if (isset($this->session->userdata['username']) == FALSE) {

			redirect();
		} else {
			$this->database_model->delete_user($user_id);
			redirect("Master_controllers/all_team_members");
		}
	}

	// end team member

	public function client_approval(){
		$designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
		if(in_array($designation_id, [1,6,8]))
			return true;
		elseif(in_array($designation_id, [5,7]))
			return false;
		return false;
	}

	public function dashborad_details(){
		$data['client_approval'] = $this->client_approval();
		$data['proposal_projects'] = $this->projectmodel->get_proposal_projects();
		if($this->client_approval())
			$data['deadline_projects'] = $this->projectmodel->get_deadline_projects(true);
		else
			$data['deadline_projects'] = $this->projectmodel->get_deadline_projects();
		return $data;
	}


	//new sj 09_01_2018
	public function insert_user_modal() {
		$this->load->model("database_model");
		$data = array(
			'name' => $this->input->post('user_name'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'designation_id' => $this->input->post('sample_1_length'),
			'password' => MD5($this->input->post('password')),
			'dynamic_id' => $this->dynamic_id()
		);

		$this->database_model->insert_user($data);
		$this->email->from('mastercasting@kushalsethia.com', 'Master Casting');
		//$this->email->from('lifecoach@kushalsethia.com', 'mastercasting');
		$this->email->to($this->input->post('email'));
		//$this->email->cc($alternate_admin_email);
		$this->email->subject('Master Casting');
		$this->email->message($this->input->post('password'));
		$this->email->send();
		
		$clients = $this->projectmodel->get_client();
		?>
		<option value="">Set Client</option>
        <?php foreach ($clients as $key): ?>
        <option value="<?= $key->id ?>"><?= $key->name ?></option>
        <?php endforeach; ?>
        <?php
	}

	public function insert_member_user_modal() {
		$this->load->model("database_model");
		$data = array(
			'name' => $this->input->post('user_name'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'designation_id' => $this->input->post('sample_1_length'),
			'password' => MD5($this->input->post('password')),
			'dynamic_id' => $this->dynamic_id()
		);

		$this->database_model->insert_user($data);
		$this->email->from('mastercasting@kushalsethia.com', 'mastercasting');
		//$this->email->from('lifecoach@kushalsethia.com', 'mastercasting');
		$this->email->to($this->input->post('email'));
		//$this->email->cc($alternate_admin_email);
		$this->email->subject('Mastercasting:User Password');
		$this->email->message($this->input->post('password'));
		$this->email->send();

		$assignee = $this->projectmodel->get_assignee();
		?>
		<option value="">Set Assignee</option>
        <?php foreach ($assignee as $key): ?>
        <option value="<?= $key->id ?>"><?= $key->name ?></option>
        <?php endforeach; ?>
        <?php
	}

	public function add_set_assignee_field(){
		$client_approval = $this->client_approval();
		$assignee = $this->projectmodel->get_assignee();
		$permissions = $this->member_model->get_all_permissions();

		if ($client_approval) : ?>
		<div class="form-group">
		    <div class="col-md-4">
		        <select id="all_assignee" name="project_details[assignee][]" class="form-control all_assignee">
		            <option selected="" disabled="">Set Assignee</option>
		            <?php foreach ($assignee as $key): ?>
		            <option value="<?= $key->id ?>"><?= $key->name ?></option>
		            <?php endforeach; ?>
		        </select>
		    </div>
		    <div  class="col-md-2">
                <button class="btn btn-default set_permission_btn" type="button" value="" data-toggle="modal" data-target="#set_permission_modal">Set Permission</button>
            </div>
		    <!-- <div class="col-md-4">
                <select class="form-control permissions_id" name="permissions[permission_id][]" id="">
                    <option value="">Choose Permission Key</option>
                    <?php foreach ($permissions as $key) : ?>
                    <option value="<?= $key->permission_id?>"><?= $key->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control permissions_level" name="permissions[level][]" id="">
                    <option value="">Set Permission</option>
                    <option value="1">Allow</option>
                    <option value="0">Disallow</option>
                </select>
            </div> -->
		</div>
		<?php endif; 
	}
	//new sj 09_01_2018 end

	public function member_details($user_id){
		
		$this->login_check();

		$data['member_details'] = $this->member_model->get_user_deatils($user_id);
		$data['permissions'] = $this->member_model->get_all_permissions();
		$data['user_permissions'] = $this->member_model->get_user_permissions($user_id);
		$data['jobs'] = $this->projectmodel->get_all_projects_by_id($user_id);
		$data['designations'] = $this->db->where_not_in('designation_id', [7, 5])->get('designation')->result();
		// echo $this->db->last_query();die;
		// print_r($data['member_details']);
		$this->load->view('member_details', $data);
	}

	public function add_permission(){
		$data = $this->input->post('permission');
		$data['updated_at'] = date('Y-m-d H:i:s');
		$this->member_model->insert_permission($data);

		$user_permissions = $this->member_model->get_user_permissions($data['user_id']);
		?>
		<?php foreach ($user_permissions as $key) : ?>
        <li class="list-group-item <?= $key->level == '1' ? 'list-group-item-success' : 'list-group-item-danger' ?>"><?= $key->name ?><a href="<?= base_url('Master_controllers/delete_permission/'. $key->user_permission_id) ?>" class="badge badge-pill delete_permission">&times;</a> <span class="badge <?= $key->level == '1' ? 'badge-success' : 'badge-danger' ?> badge-pill"><?= $key->level == '1' ? 'Allowed' : 'Disallowed' ?></span></li>
        <?php endforeach; ?>
		<?php
	}

	public function add_multiple_permission(){
		$permission = $this->input->post('permission');

		if(!isset($permission['permission_id']) || count($permission['permission_id']) == 0 || $permission['user_id'] == 0){
			if($permission['user_id'] == 0)
				return;
			else
				return $this->member_permissions($permission['user_id']);
		}

		foreach ($permission['permission_id'] as $key => $value) {
			// if( $permission['level'][$key] != 'null'){
				$data['user_id'] = $permission['user_id'];
				$data['permission_id'] = $value;
				$data['level'] = $permission['level'][$value];
				$data['updated_at'] = date('Y-m-d H:i:s');
				// print_r($data);
				$this->member_model->insert_permission($data);
			// }
		}
		$this->member_permissions($permission['user_id']);
	}

	public function member_permissions($user_id){
		$user_permissions = $this->member_model->get_user_permissions($user_id);
		?>
		<?php foreach ($user_permissions as $key) : ?>
        <li class="list-group-item <?= $key->level == '1' ? 'list-group-item-success' : 'list-group-item-danger' ?>"><?= $key->name ?><a href="<?= base_url('Master_controllers/delete_permission/'. $key->user_permission_id) ?>" class="badge badge-pill delete_permission">&times;</a> <span class="badge <?= $key->level == '1' ? 'badge-success' : 'badge-danger' ?> badge-pill"><?= $key->level == '1' ? 'Allowed' : 'Disallowed' ?></span></li>
        <?php endforeach; ?>
		<?php
	}

	public function delete_permission($user_permission_id){
		$user_id = $this->db->get_where('user_permission', ['user_permission_id' => $user_permission_id])->row()->user_id;
		$this->db->delete('user_permission', ['user_permission_id' => $user_permission_id]);
		$this->member_permissions($user_id);
	}


	public function FunctionName($value='')
	{
		$timestamp = 1140153693;
		$timezone  = 'UM8';
		$daylight_saving = TRUE;
		echo date('d-m-y H:i:s');
		echo gmt_to_local($timestamp, $timezone, $daylight_saving);
	}

	public function get_json_data()
	{
		$string = file_get_contents("./uploads/json_data/order.json");
		$json_a = json_decode($string);

		echo "<pre>";
		print_r($json_a);die;

		// foreach ($json_a as $key => $value){
		//   echo  $key . ':' . $value;
		//   echo "<br>";
		// }

	}

	public function inactive_projects(){
		$projects = $this->db->get('project')->result();
		$project_ids = array_column($projects, 'project_id');

		$in_active_project_ids = [];

		foreach ($project_ids as $key) {
			$project = $this->db->get_where('project_details', ['project_id' => $key])->row();
			$activity = $this->db->order_by('created_at', 'DESC')->get_where('project_activity_log', ['project_id' => $key])->row();
			if(empty($activity)){
				$diff = strtotime($project->created_at) - time();
				$days_diff = abs(round($diff / 86400));
				if($days_diff >= 7)
					array_push($in_active_project_ids, $key);
			}
			else{
				$diff = strtotime($activity->created_at) - time();
				$days_diff = abs(round($diff / 86400));
				if($days_diff >= 7)
					array_push($in_active_project_ids, $key);
			}
		}

		$in_active_project = $this->db->where_in('project_id', $in_active_project_ids)->get('project_details')->result();

		print_r($in_active_project);die;

	}


	public function mismatch(){
		$project_details = $this->db->select('project_id')->get('project_details')->result();
		$project_details_ids = array_column($project_details, 'project_id');

		$project = $this->db->select('project_id')->get('project')->result();
		$project_ids = array_column($project, 'project_id');

		echo "<pre>";
		print_r($project_details_ids);

		echo "<hr>";
		print_r($project_ids);


		$ar = array_merge(array_diff($project_ids, $project_details_ids), array_diff($project_details_ids, $project_ids));;
		print_r($ar);

	}


}