<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_controller extends CI_Controller {

	/**
	 * @param $type_of_change
	 *
	 */
	private $email_form = 'apache@mastercastingandcad.com';

	public function __construct(){
		parent::__construct();
        $this->load->model('projectmodel');
        $this->load->model('member_model');
        $this->load->library('email');
		// date_default_timezone_set('Asia/Calcutta');

        $this->session->keep_flashdata('create_trade');
        $this->session->keep_flashdata('resend_cred');
        $this->session->keep_flashdata('edit_trade');
        $this->session->keep_flashdata('vacation_add');
        // $this->session->keep_flashdata('update_des');

	}

	private function email_config(){
		return $config = array(
		    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
		    'smtp_host' => 'email-smtp.us-west-2a.amazonaws.com', 
		    'smtp_port' => 465,
		    'smtp_user' => 'AKIA5VUTQDVIZN35QZH2',
		    'smtp_pass' => 'BMTvxHTmGWk1PI2DVs1Flqu4Q76fCwbhcrUl/k+b35tL',
		    // 'smtp_crypto' => 'tsl', //can be 'ssl' or 'tls' for example
		    'mailtype' => 'html', //plaintext 'text' mails or 'html'
		    'smtp_timeout' => '4', //in seconds
		    'charset' => 'iso-8859-1',
		    'wordwrap' => TRUE
		);
	}

	public function login_check(){
        if (!$this->session->userdata('user_id')) {
            return redirect('dashboard');
        }
    }

    public function permission_by_designation($designations = []){
    	$designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;

    	if(!in_array($designation_id, $designations))
            return redirect('dashboard');

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


    // Trades

	public function create_trade(){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);
		$data['companies'] = $this->db->get('companies')->result();
        $data['countries'] = $this->projectmodel->get_all_countries();
		
		$this->load->view('create_trade', $data);
	}

	public function create_trade_action(){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8,7]);


		$user = $this->input->post('user');
		$user['username'] = preg_replace('/\s+/', '', $user['username']);
		$user['dynamic_id'] = $this->dynamic_id();
		$user['designation_id'] = 7; // trade client designation
		$user['name'] = ucwords(strtolower($user['first_name']. ' ' . $user['last_name']));

		$digits = 4;
		$ps = rand(pow(10, $digits-1), pow(10, $digits)-1);

		$user['password'] = md5($ps);
		$user['ps'] = $ps;
		// $user['permission'] = 1;

		if($user['company_id'] == 'other'){
			$this->db->insert('companies', ['company_name' => $user['company_name']]);
            $user['company_id'] = $this->db->insert_id();
            $user['comp_des'] = 1;
		}else{
			$user['company_name'] = $this->db->get_where('companies', ['company_id' => $user['company_id']])->row()->company_name;
            $user['comp_des'] = 2;
		}

		// print_r($user);die;

		$email_check = $this->db->get_where('user', ['email' => $user['email']])->num_rows();

		if($email_check > 0){
			echo "
				<script>
					alert('Email already exist');
					window.location.replace('".base_url('create/trade/')."');
				</script>
				";
				return;
		}

		$username_check = $this->db->get_where('user', ['username' => $user['username']])->num_rows();

		if($username_check > 0){
			echo "
				<script>
					alert('Username already exist');
					window.location.replace('".base_url('create/trade/')."');
				</script>
				";
				return;
		}

		// print_r($user);die;

		$this->db->insert('user', $user);
		$this->send_email_new_user($user['email'], $ps);
		$user = $this->db->insert_id();
		$token = md5(uniqid($user, true));
		$this->db->update('user', ['api_token' => $token], ['id' => $user]);
		
		$this->session->set_flashdata('create_trade', 'success');
		return redirect(DOMAIN.'/add-user/?user='.$user);
		// return redirect('details/trade/'.$user);
	}

	public function trade_client_details($user_id){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);

		$data['user'] = $this->db->get_where('user', ['id' => $user_id])->row();
		// $data['representative'] = $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where_in('user.designation_id' , [6, 8])->get('user')->result();
		$data['representative'] = $this->member_model->get_representative();
		$data['jobs'] = $this->projectmodel->get_all_projects_by_id($user_id);
		$data['company_proof'] = $this->db->get_where('company', ['user_id' => $user_id])->row();
        $data['countries'] = $this->projectmodel->get_all_countries();
		$data['ship_history'] = $this->projectmodel->get_all_shipping_history_by_client($user_id);
		
		// print_r($data['user']);die;
		$this->load->view('trade_client_details', $data);
	}

	public function trade_clients(){
		// echo "string";die;
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);

		$data['user'] = $this->db->order_by('created_at', 'DESC')->get_where('user', ['designation_id' => 7, 'is_deleted' => 0])->result();
		return $this->load->view('trade_clients', $data);
	}

	public function edit_trade_client_action($user_id){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);

		$user = $this->input->post('user');
		$user['name'] = $user['first_name'].' '.$user['last_name'];

		$email_check = $this->db->get_where('user', ['email' => $user['email'], 'id !=' => $user_id])->num_rows();

		if($email_check > 0){
			echo "
				<script>
					alert('Email already exist');
					window.location.replace('".base_url('details/trade/'.$user_id)."');
				</script>
				";
				return;
		}

		$user_details = $this->db->get_where('user', ['id' => $user_id])->row();

		$user['city'] = ucwords(strtolower($user['city']));

		$this->db->update('user', $user, ['id' => $user_id]);

		//updating company name
		$this->db->update('companies', ['company_name' => $user['company_name']], ['company_id' => $user_details->company_id]);


		$otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		$query = $otherdb->get_where('wp_users', ['user_email' => $user_details->email])->row();
		$query = $otherdb->update('wp_users',['user_email' => $user['email']], ['user_email' => $user_details->email]);

		$this->session->set_flashdata('edit_trade', 'success');
		return redirect('details/trade/'.$user_id);
	}

	public function delete_trade_client($id){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);

		$this->db->delete('user', ['id' => $id]);
		return redirect('trade_clients');
	}

	// end trade


	//retailer
	public function create_retailer(){
	    $this->login_check();
		$this->permission_by_designation([1,6,8]);

        $data['countries'] = $this->projectmodel->get_all_countries();

		$this->load->view('create_retailer', $data);
	}

	public function create_retail_action(){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);

		$user = $this->input->post('user');
		$user['dynamic_id'] = $this->dynamic_id();
		$user['designation_id'] = 5; // retail client designation
		$user['name'] = ucwords(strtolower($user['first_name']. ' ' . $user['last_name']));
		$user['username'] = preg_replace('/\s+/', '', $user['username']);


		$digits = 4;
		$ps = rand(pow(10, $digits-1), pow(10, $digits)-1);

		$user['password'] = md5($ps);
		$user['ps'] = $ps;
		
		// $user['permission'] = 1;


		$email_check = $this->db->get_where('user', ['email' => $user['email']])->num_rows();

		if($email_check > 0){
			echo "
				<script>
					alert('Email already exist');
					window.location.replace('".base_url('create/retailer/')."');
				</script>
				";
				return;
		}

		$username_check = $this->db->get_where('user', ['username' => $user['username']])->num_rows();

		if($username_check > 0){
			echo "
				<script>
					alert('Username already exist');
					window.location.replace('".base_url('create/retailer/')."');
				</script>
				";
				return;
		}

		// print_r($user);die;

		$this->db->insert('user', $user);
		$this->send_email_new_user($user['email'], $ps);
		$user = $this->db->insert_id();
		$token = md5(uniqid($user, true));
		$this->db->update('user', ['api_token' => $token], ['id' => $user]);

		return redirect(DOMAIN.'/add-user/?user='.$user);
		// return redirect('details/retailer/'.$user);
	}

	public function retailer_client_details($user_id){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);

		$data['user'] = $this->db->get_where('user', ['id' => $user_id])->row();
		$data['representative'] = $this->member_model->get_representative();
		$data['jobs'] = $this->projectmodel->get_all_projects_by_id($user_id);
		// print_r($data['jobs']);die;
        $data['countries'] = $this->projectmodel->get_all_countries();
		$data['user_proof'] = $this->db->get_where('user_proof', ['user_id' => $user_id])->result();

		$this->load->view('retailer_client_details', $data);
	}

	public function edit_retailer_client_action($user_id){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);


		$user = $this->input->post('user');

		$email_check = $this->db->get_where('user', ['email' => $user['email'], 'id !=' => $user_id])->num_rows();

		if($email_check > 0){
			echo "
				<script>
					alert('Email already exist');
					window.location.replace('".base_url('details/retailer/'.$user_id)."');
				</script>
				";
				return;
		}
		$user['city'] = ucwords(strtolower($user['city']));

		$this->db->update('user', $user, ['id' => $user_id]);
		return redirect('details/retailer/'.$user_id);
	}

	public function retail_clients(){
		// echo "string";die;
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);


		$data['user'] = $this->db->order_by('created_at', 'DESC')->get_where('user', ['designation_id' => 5, 'is_deleted' => 0])->result();
		return $this->load->view('retail_clients', $data);
	}


    public function delete_retail_client($user_id){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);

    	$this->db->delete('user', ['id' => $user_id]);
    	redirect('retail_clients');
    }

	//end retailer


    // user actions

	public function delete_member(){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8]);

		$user_id = $this->input->post('user_id');
		foreach ($user_id as $key) {
			$this->db->update('user', ['is_deleted' => 1],['id' => $key]);
		}
		echo count($user_id);die;
	}

    public function user_hold_action(){
    	$user_id = $this->input->post('user_id');
    	foreach ($user_id as $key) {
    		// echo $key;
    		$this->db->update('user', ['permission' => 0], ['id' => $key]);
    	}
    }

    public function user_delete_action(){
    	$user_id = $this->input->post('user_id');
    	foreach ($user_id as $key) {
    		$this->db->update('user', ['is_deleted' => 1], ['id' => $key]);
    	}
    }

    public function user_approve_action(){
    	$user_id = $this->input->post('user_id');
    	foreach ($user_id as $key) {
    		$this->db->update('user', ['permission' => 1], ['id' => $key]);
    		ob_start(); ?>
    		<!-- <p>Tim, </p>
				<p>Your account is now active, it may take a day or two to see all of your jobs from before but anything new will be available right away. If you don't have a password yet, go back to the website and click log in and forgot password to re set.
				You are now able to upload jobs here and you will have all of your jobs and files availible always including history of previous jobs.
				Let me know if you have any questions.
				Regards,</p> -->
			Your account has been approved and its ready for use.<br>
			Please follow this <a href="<?php echo base_url() ?>">link</a> to log in
    		<?php
    		$html = ob_get_clean();
    		$email = $this->db->get_where('user', ['id' => $key])->row()->email;
    		$this->send_email_user_action($email, $html);
    	}
    }

    public function user_deny_not_enough_info_action(){
    	$user_id = $this->input->post('user_id');
    	foreach ($user_id as $key) {
    		ob_start(); ?>
			Your account has been denied.<br>
			Reason You did not provide enough information please try again
    		<?php
    		$html = ob_get_clean();
    		$email = $this->db->get_where('user', ['id' => $key])->row()->email;
    		$this->db->delete('user', ['id' => $key]);

    		$otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

		    $otherdb->delete('wp_users', ['user_email' => $email]);

    		$this->send_email_user_action($email, $html);
    	}
    }

    public function user_deny_try_again_action(){
    	$user_id = $this->input->post('user_id');
    	foreach ($user_id as $key) {
    		ob_start(); ?>
			Your account has been denied.<br>
			You did not provide enough proof of relation to the industry, please click this link to contact our retail department <a href="www.diamonds717.com">www.diamonds717.com</a> give us your idea.
    		<?php
    		$html = ob_get_clean();
    		$email = $this->db->get_where('user', ['id' => $key])->row()->email;
    		$this->db->delete('user', ['id' => $key]);

    		$otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

		    $otherdb->delete('wp_users', ['user_email' => $email]);

    		$this->send_email_user_action($email, $html);
    	}
    }

    public function send_email_user_action($email, $html){
     	$data['html'] = $html;
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

    public function send_email_new_user($email, $ps){
    	// $mail = $this->input->post('mail');
    	// // print_r($mail);die;
    	// $email = $this->db->get_where('user', ['id' => $user_id])->row()->email;
    	ob_start(); ?>
		You are added by admin as a client in mastercasting. You can login using your email and this password (<?php echo $ps ?>). You can also change password later. You can login  <a href="<?php echo base_url() ?>">here</a>.
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

    public function send_email_to_user($user_id){
    	$mail = $this->input->post('mail');
    	// print_r($mail);die;
    	$email = $this->db->get_where('user', ['id' => $user_id])->row()->email;

    	$data['html'] = $mail['body'];

    	$html = $this->load->view('default_email_template', $data, true);

    	$config = $this->email_config();

        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject($mail['subject']);
        $this->email->message($html);
        $this->email->send();
    }

    public function change_password($user_id){
    	$user = $this->input->post('user');
    	$user['ps'] = $user['password'];
    	$user['password'] = md5($user['password']);
    	$this->db->update('user', ['password' => $user['password'], 'ps' => $user['ps']], ['id' => $user_id]);
    	$this->session->set_flashdata('password', 'success');
    	redirect(DOMAIN.'/reset-password?user='.$user_id);
    }

    public function member_permission_invoke($user_id){
    	$permission = $this->db->get_where('user', ['id' => $user_id])->row()->permission;
    	if($permission == 0)
    		$permission = 1;
    	else
    		$permission = 0;

		$this->db->update('user', ['permission' => $permission], ['id' => $user_id]);
		ob_start(); ?>
		Your account has been approved and its ready for use.<br>
		Please follow this <a href="<?php echo base_url() ?>">link</a> to log in
		<?php
		$html = ob_get_clean();
		echo $permission;
		$this->send_email_user_action($user_id, $html);
    }

    // user actions
	public function company_list($key='')
    {
    	if (!$this->session->userdata('user_id')) {
            return redirect();
        }
        $this->permission_by_designation([1,6,8]);

    	// $key = $this->input->get('key');
    	// $data['company_name'] = $this->db->query("SELECT DISTINCT company_name FROM `user` WHERE `designation_id` = 7 AND `is_deleted` = 0")->result();
    	$data['companies'] = $this->db->get('companies')->result();
    	$this->load->view('company_list', $data);
    }

   	public function get_user_by_company($company_id) {
		if (!$this->session->userdata('user_id')) {
            return redirect();
        }

        $this->permission_by_designation([1,6,8]);

        // echo rawurldecode($company_name);die;
		 
		$data["members"] = $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where('company_id', $company_id)->where('is_deleted', 0)->where(['user.designation_id' => 7])->get('user')->result();

		$user_ids = array_column($data['members'], 'id');
		$data['jobs'] = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->group_start()
                                    ->where_in('assign_by', $user_ids)
                                    ->or_where_in('asign_user', $user_ids)
                                ->group_end()
                                ->get('project')
                                ->result();

		// $project_ids = [];

		// foreach ($project as $key) {
		// 	echo $key->project_id.'-'.$key->assignee;
		// 	$assignee = explode(',', $key->assignee);
		// 	foreach ($user_ids as $key1) {
		// 		if(in_array($key1, [$assignee]))
		// 			array_push($project_ids, $key1);

		// 	}
		// 	echo "<br>";
		// }
		// echo "<hr>";
		// print_r($project_ids);
		// die;
		$this->load->view('user_by_company', $data);
	}

    //get company
    public function get_company($key='')
    {
    	// $key = $this->input->get('key');
    	$company_name = $this->db->query("SELECT DISTINCT company_name FROM `user` WHERE `company_name` LIKE '$key%'")->result();
    	echo json_encode($company_name);
    }

    public function email(){

		// $config = array(
  //           'protocol' => 'smtp',
  //           'smtp_host' => 'email-smtp.us-west-2a.amazonaws.com',
  //           'smtp_port' => 465,
  //           'smtp_user' => 'AKIA5VUTQDVI4ZD3Z4VC',
  //           'smtp_pass' => 'BI6wKETcip4mq0It8Z0KP8I5jQeXDZexGSJyJOys0QUj',
  //           'mailtype' => 'html',
  //           'charset' => 'iso-8859-1',
  //       );
  //       $this->load->library('email', $config);

  //       $this->email->set_newline("\r\n");
  //       $this->email->set_mailtype("html");
  //       $this->email->from($this->email_form, 'Mastercasting'); // change it to yours
  //       $this->email->to('webdeveloper@hih7.com'); // change it to yours
  //       $this->email->subject('subject');
  //       $this->email->message('meytwo');
  //       $this->email->send();

    	// $this->load->config('email');
  //   	$config = array(
		//     'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
		//     'smtp_host' => 'smtp.mailgun.org', 
		//     'smtp_port' => 587,
		//     'smtp_user' => 'postmaster@www.mastercastingandcad.com',
		//     'smtp_pass' => '89e954a6422e1797b501ea7f2cbdbee1-87cdd773-1c23fff2',
		//     // 'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
		//     'mailtype' => 'html', //plaintext 'text' mails or 'html'
		//     'smtp_timeout' => '4', //in seconds
		//     'charset' => 'iso-8859-1',
		//     'wordwrap' => TRUE
		// );
		$config['protocol']         = 'smtp';
		$config['smtp_host']        = 'smtp.mailgun.org';
		$config['smtp_port']        = 2525;
		$config['smtp_user']        = 'postmaster@www.mastercastingandcad.com';
		$config['smtp_pass']        = '89e954a6422e1797b501ea7f2cbdbee1-87cdd773-1c23fff2';
		// $config['smtp_crypto']      = 'ssl';
		$config['charset']          = 'utf-8';
		$config['mailtype']         = 'html';
		$config['email']['newline'] = "rn";

        $this->load->library('email', $config);
        // echo $from = $this->config->item('smtp_user');
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from('postmaster@www.mastercastingandcad.com', 'Mastercastingandcad'); // change it to yours
        $this->email->to('sjgalaxy98@gmail.com'); // change it to yours
        $this->email->subject('Subject Please');
        $this->email->message('hello mastercasting');
        try {
		    $this->email->send();
		    echo 'Message has been sent.';
		} catch(Exception $e) {
		    echo $e->getMessage();
		}
        echo $this->email->print_debugger();

    	phpinfo();
    }

    public function otherdb(){
	  $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

	  $query = $otherdb->get_where('wp_users', ['ID' => 1])->result();
	  print_r($query);
	}

    public function resend_cred($user_id, $member = NULL){
		// echo $member;die;
    	// $user = $this->input->post('user');
    	// if (!$this->session->userdata('user_id')) {
        //     return redirect();
        // }

        $designation_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->designation_id;
        if(!in_array($designation_id, [1,6,8]))
        	return redirect();

    	// echo $user_id;die;
    	$user = $this->db->get_where('user', ['id' => $user_id])->row();
    	$digits = 4;
		$ps = rand(pow(10, $digits-1), pow(10, $digits)-1);
    	// echo $user['ps'] = $ps;die;
    	$password = md5($ps);
    	$this->db->update('user', ['password' => $password, 'ps' => $ps], ['id' => $user_id]);
    	$this->session->set_flashdata('resend_cred', 'success');
    	ob_start(); ?>
		<p>Your Credentails For mastercasting login</p>
		<p>Email: <?php echo $user->email ?></p>
		<p>Username: <?php echo $user->username ?></p>
		<p>Password: <?php echo $ps ?></p>
    	<?php
    	$html = ob_get_clean();
		$this->send_email_user_action($user->email, $html);
		if($member == 0)
			redirect(DOMAIN.'/reset-password?user='.$user_id.'&resend_cred=1');
		else
			redirect(DOMAIN.'/reset-password?user='.$user_id.'&resend_cred=1&member=1');

    }

    public function cad_slots($user_id = NULL)
    {
    	$this->login_check();

    	$data['cad_slots_date'] = $this->db->select('*')->join('project_details', 'project_details.project_id = cad_slots.project_id')->where(['cad_slots.user_id' => $user_id, 'date' => date('Y-m-d')])->order_by('slot_order', 'ASC')->order_by( 'cad_slots.created_at', 'ASC')->get('cad_slots')->result();
    	// echo $this->db->last_query();
    	// echo "<pre>";
    	// print_r($data);die;

    	$data['cad_slots'] = $this->projectmodel->get_all_cad_dates($user_id);
    	// $data['cad_slots'] = $this->db->get_where('cad_slots', ['user_id' => $user_id])->result();
    	$data['slots'] = $this->db->select('slots, id')->where(['id' => $user_id])->get('user')->row();
    	$data['vacations'] = $this->db->get_where('vacations', ['user_id' => $user_id])->result();
    	$data['slot_section'] = $this->load->view('slot_section', $data, true);
    	$this->load->view('cad_slots', $data);
    }

 
    public function slot_check($user_id = '', $slot = '')
    {
    	$total_slot = $this->db->get_where('user', ['id' => $user_id])->row()->slots;

    	$total_slot = (int)$total_slot;

		if($slot == 0 && $total_slot > 0)
			$total_slot -= 1;
		elseif($slot == 1 && $total_slot < 6)
			$total_slot += 1;

    	$this->db->update('user', ['slots' => $total_slot], ['id' => $user_id]);
    }

    public function get_cad_slot_by_id($user_id){
    	$data['cad_slots'] = $this->db->get_where('cad_slots', ['user_id' => 1067])->result();
    	echo $view = $this->load->view('slot_section', $data, true);
    }

    public function check_des($user_id){
    	$designation_id = $this->db->get_where('user', ['id' => $user_id])->row()->designation_id;
    	if($designation_id == 9)
    		echo "1";
    }

    public function check_slot_availability($user_id = NULL)
    {
    	
    	$date = date('Y-m-d', strtotime($this->input->post('date')));

    	$vacation = $this->db->query("SELECT * FROM vacations WHERE user_id = $user_id and '$date' between start_date and end_date")->num_rows();

    	if($vacation > 0){
    		echo "vacation";
    		return;
    	}

    	$cad_slots_num = $this->db->get_where('cad_slots', ['user_id' =>$user_id, 'date' => $date])->num_rows();
    	$slots = $this->db->select('slots')->where(['id' => $user_id])->get('user')->row()->slots;

    	echo ((int)$slots - (int)$cad_slots_num);

    }

    public function update_cad_slot_date($cad_slot_id = NULL){
    	$cad = $this->db->get_where('cad_slots', ['cad_slot_id' => $cad_slot_id])->row();
    	$date = date('Y-m-d', strtotime($this->input->post('date')));
    	$vacation_nums = $this->db->query("SELECT * FROM vacations WHERE user_id = $cad->user_id and '$date' between start_date and end_date")->num_rows();
    	if($vacation_nums > 0)
    		echo 'no';
    	else{
	    	$this->db->update('cad_slots', ['date' => $date], ['cad_slot_id' => $cad_slot_id]);
	    	$prev_cad_date = $this->db->query("SELECT * FROM cad_slots where `cad_slot_id` != $cad_slot_id AND `date` = '$date' ORDER BY slot_order DESC, created_at DESC LIMIT 1")->row();
	    	// echo $this->db->last_query();
	    	if(empty($prev_cad_date)){
		    	$this->db->update('cad_slots', ['slot_order' => 0], ['cad_slot_id' => $cad_slot_id]);
	    	} else{
		    	if($prev_cad_date->slot_order == NULL){
			    	$this->db->update('cad_slots', ['slot_order' => NULL], ['cad_slot_id' => $cad_slot_id]);
		    	} else {
			    	$this->db->update('cad_slots', ['slot_order' => ($prev_cad_date->slot_order + 1)], ['cad_slot_id' => $cad_slot_id]);
		    	}
	    	}
    	}
    }

	public function view_associates() {
		if (!$this->session->userdata('user_id')) {
            return redirect();
        }

        $this->permission_by_designation([1,6,8,7]);

        $company_id = $this->db->get_where('user', ['id' => $this->session->userdata('user_id')])->row()->company_id;
        // echo rawurldecode($company_name);die;
		 
		$data["members"] = $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where('company_id', $company_id)->where('is_deleted', 0)->where(['user.designation_id' => 7])->get('user')->result();

		$user_ids = array_column($data['members'], 'id');
		$data['jobs'] = $this->db->order_by('created_at', 'desc')
                                ->join('project_details', 'project.project_id = project_details.project_id')
                                ->group_start()
                                    ->where_in('assign_by', $user_ids)
                                    ->or_where_in('asign_user', $user_ids)
                                ->group_end()
                                ->get('project')
                                ->result();

		$this->load->view('user_by_company', $data);
	}

	public function create_associate(){
	    $this->login_check();
	    $this->permission_by_designation([1,6,8,7]);
	    $user_id = $this->session->userdata('user_id');
	    $user = $this->db->get_where('user', ['id' => $user_id])->row();
	    $data['company_id'] = $user->company_id;
	    $data['company_name'] = $user->company_name;
		$this->load->view('add_associate', $data);
	}


	public function insert_vacation()
	{
		$date = $this->input->post('date');
		$vacation = $this->input->post('vacation');
		$date = explode('-', $date);
		$vacation['start_date'] = date('Y-m-d', strtotime($date[0]));
		$vacation['end_date'] = date('Y-m-d', strtotime($date[1]));

		$this->db->insert('vacations', $vacation);

		$this->session->set_flashdata('vacation_add', 'success');
		redirect('cad_slots/'.$vacation['user_id']);
	}

	public function vacation_details($vacation_id = NULL){
		$vacation = $this->db->get_where('vacations', ['vacation_id' => $vacation_id])->row();
		echo 'Reason: '.$vacation->reason;
	}

	public function update_designation($user_id)
	{
	    $this->permission_by_designation([1]);

		$designation_id = $this->input->post('designation_id');
		$this->db->update('user', ['designation_id' => $designation_id], ['id' => $user_id]);

		// $this->session->set_flashdata('update_des', 'success');

		redirect('member_details/'.$user_id);
	}



    public function get_cad_slot_dates_by_status($user_id='')
    {
        $slot_cnt = $this->db->get_where('user', ['id' => $user_id])->row()->slots;
        $cad_warning_dates = $this->db->query("SELECT COUNT(cad_slot_id) as cnt, date  FROM `cad_slots` WHERE user_id = $user_id GROUP BY `date` HAVING (cnt =  ($slot_cnt - 1))")->result();
        $cad_full_dates = $this->db->query("SELECT COUNT(cad_slot_id) as cnt, date  FROM `cad_slots` WHERE user_id = $user_id GROUP BY `date` HAVING (cnt = $slot_cnt)")->result();
        $cad_available_dates = $this->db->query("SELECT COUNT(cad_slot_id) as cnt, date  FROM `cad_slots` WHERE user_id = $user_id GROUP BY `date` HAVING (cnt < $slot_cnt - 1)")->result();

        $dates['warning_dates'] = array_map(array($this, "date_format_array_map_fn"), array_column($cad_warning_dates, 'date'));
        $dates['full_dates'] = array_map(array($this, "date_format_array_map_fn"), array_column($cad_full_dates, 'date'));
        $dates['available_dates'] = array_map(array($this, "date_format_array_map_fn"), array_column($cad_available_dates, 'date'));
        echo json_encode($dates);
    }

    public function date_format_array_map_fn($date){
    	return date('m/d/Y', strtotime($date));
    }


    //new july 12
    public function sort_cad_slot(){
    	$listIdsJson = $this->input->post('listIds');

    	$listIds = json_decode($listIdsJson);

    	foreach ($listIds as $key => $value) {
    		$this->db->update('cad_slots', ['slot_order' => $key], ['cad_slot_id' => $value]);
    	}
    	return;
    }

    public function project_details_modal_cad_slot($project_id){
    	$project_details = $this->db->get_where('project_details', ['project_id' => $project_id])->row();
    	$project_specification = $this->db->get_where('project_specification', ['project_id' => $project_id])->row();

    	ob_start(); ?>
    	<tr style="cursor: pointer;" onclick="window.location='<?php echo base_url('project/project_details/'.$project_id) ?>';">
    		 <?php 
	            switch ($project_details->cad_progress) {
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
			<td><a class="badge badge-success" href="">J<?php echo $project_id ?></a></td>
	        <td><a class="badge badge-<?php echo $cad_progress_color ?>" href=""><?php echo $project_details->cad_progress ?></a></td>
    	</tr>
    	<?php 
    	$data['tbody_data'] = ob_get_clean();

    	ob_start(); ?>
		<div class="col-md-6">
           <ul>
                <li>Ring Size : <span class="text-info"><?php echo $project_specification->ring_size ?></span></li>
                <li>Purity / Color / Metal:  <span class="text-info"><?php echo $project_specification->purity ?></span></li>
                <li>Plating:  <span class="text-info"><?php echo $project_specification->plating ?></span></li>
                <li>Finish:  <span class="text-info"><?php echo $project_specification->finish ?></span></li>
                <li>Custom:  <span class="text-info"><?php echo $project_specification->custom ?></span></li>
            </ul>
        </div>
        <div class="col-md-6">
            <ul>
                <li>
                    Wax Only : <span class="text-info"><?php echo $project_specification->wax_only ?></span> / 
                    Casting Only:  <span class="text-info"><?php echo $project_specification->casting_only ?></span>
                </li>
                <li>Mold:  <span class="text-info"><?php echo $project_specification->mold ?></span></li>
                <li>Supply Diamonds:  <span class="text-info"><?php echo $project_specification->supply_diamonds ?></span></li>
                <li>Supply Center:  <span class="text-info"><?php echo $project_specification->supply_center ?></span></li>
                <li>
                    Supply All Gems:  <span class="text-info"><?php echo $project_specification->supply_all_gems ?> <?php echo $project_specification->supply_all_gems == 'Yes' ? 
                    '/' : '' ?> <?php echo $project_specification->supply_all_gems_yes ?></span>
                </li>
                <li>Sending my own: <span class="text-info"> <?php echo $project_specification->sending_my_own ?></span></li>
            </ul>
            </ul>
        </div>
    	<?php 
    	$data['spec_data'] = ob_get_clean();


    	echo json_encode($data);
    }


    public function cad_priority_check($project_id)
    {
    	$cad_date = $this->db->select('*')->join('project_details', 'project_details.project_id = cad_slots.project_id')->where(['cad_slots.project_id' => $project_id])->get('cad_slots')->row();

    	// echo $cad_date->date;die;

    	if($cad_date->date < date('Y-m-d')){
    		echo "zero";
	    	return;
    	}

    	if($cad_date->cad_progress == 'Ready'){
    		echo 'You completed this job.';
	    	return;
    	}

    	$result = $this->projectmodel->cad_priority_check($project_id);

    	if($result){
    		echo 'You can start working this job.';
	    	return;
    	} else{
    		echo 'Please finish the previous job first.';
	    	return;
    	}
    	return;
    }

    public function get_cad_dates_by_date($date, $user_id){
    	// echo $date;die;
    	$cad_slots_date = $this->projectmodel->get_cad_dates_by_date($date, $user_id);
    	ob_start(); ?>
		<?php for ($i=0 ; $i < 6; $i++): ?>
        <?php if(isset($cad_slots_date[$i]->project_id)){
          switch ($cad_slots_date[$i]->cad_progress) {
            case 'In Progress':
              $cad_progress_class = 'list-group-item-info';
              break;
            case 'On Hold':
              $cad_progress_class = 'list-group-item-danger';
              break;
            case '3D Printing Only':
              $cad_progress_class = 'list-group-item-info';
              break;
            case 'Ready':
              $cad_progress_class = 'list-group-item-success';
              break;
          }
        } ?>
        <li class="list-group-item <?php echo isset($cad_slots_date[$i]->project_id) ? $cad_progress_class.' filled' : 'empty' ?>" data-id="<?php echo isset($cad_slots_date[$i]->project_id) ? $cad_slots_date[$i]->cad_slot_id : '' ?>"><?php echo isset($cad_slots_date[$i]->project_id) ? 'J'.$cad_slots_date[$i]->project_id.' ('.$cad_slots_date[$i]->cad_progress.') ' : 'Empty' ?></li>
        <?php endfor; ?>
    	<?php 
    	$data['html'] = ob_get_clean();

    	$data['date'] = date('d M', strtotime($date));

    	echo json_encode($data);
    }

    public function automated_sort_cad_dates(){
    	$user_ids = $this->db->get_where('user', ['designation_id' => 9])->result();

    	$user_ids = array_column($user_ids, 'id');

    	// $this->db->update('user', ['name' => 'Oscar Valencia', 'city' => 'Chicago'], ['id' => 1]);

    	foreach ($user_ids as $user_id) {
    		$prev_projects = $this->db->select('cad_slots.project_id, cad_slots.cad_slot_id, cad_slots.date, cad_slots.user_id, cad_slots.slot_order, project_details.cad_progress')
	    					->join('project_details', 'project_details.project_id = cad_slots.project_id')
	    					->where(['user_id' => $user_id, 'date <' => date('Y-m-d')])
	    					->where_in('project_details.cad_progress', ['In Progress', 'On Hold'])
	    					->get('cad_slots')
	    					->result();

	    	// print_r($prev_projects);
	    	// echo "<hr>";


	    	$pending_projects = $this->db->select('cad_slots.project_id, cad_slots.cad_slot_id, cad_slots.date, cad_slots.user_id, cad_slots.slot_order, project_details.cad_progress')
	    					->join('project_details', 'project_details.project_id = cad_slots.project_id')
	    					->where(['user_id' => $user_id, 'date' => date('Y-m-d')])
	    					->where_in('project_details.cad_progress', ['In Progress', 'On Hold'])
	    					->get('cad_slots')
	    					->result();

	    	$pending_projects = array_merge($prev_projects, $pending_projects);

	    	// print_r($pending_projects);
	    	// echo "string";
	    	

    		$today = date('Y-m-d');
    		$counter = 0;
			$update_date = date('Y-m-d', strtotime($today . ' +1 day'));

			$loop_break = 0;

			while ($loop_break < 1) {

				$vacation_count = $this->db->query("SELECT vacation_id FROM `vacations` WHERE user_id= '$user_id' AND '$update_date' between start_date	and end_date")->num_rows();

				// if(date('N', strtotime($update_date)) < 6 && $vacation_count == 0){
				if($vacation_count == 0){
		    		$next_day_cad_dates = $this->db->select('cad_slots.project_id, cad_slots.cad_slot_id, cad_slots.date, cad_slots.user_id, cad_slots.slot_order, project_details.cad_progress')
		    					->join('project_details', 'project_details.project_id = cad_slots.project_id')
		    					->where(['user_id' => $user_id, 'date' => $update_date])
		    					->order_by('slot_order', 'ASC')
		    					->order_by( 'cad_slots.created_at', 'ASC')
		    					->get('cad_slots')
		    					->result();

		    		if(!empty($next_day_cad_dates)){
		    			foreach ($next_day_cad_dates as $key => $value) {
		    				$this->db->update('cad_slots', ['slot_order' => $key], ['cad_slot_id' => $value->cad_slot_id]);
		    			}
		    		}

		    		if(empty($pending_projects)){
		    			$loop_break = 1;
		    		} else {
		    			$next_day_cad_dates = $this->db->select('cad_slots.project_id, cad_slots.cad_slot_id, cad_slots.date, cad_slots.user_id, cad_slots.slot_order, project_details.cad_progress')
		    					->join('project_details', 'project_details.project_id = cad_slots.project_id')
		    					->where(['user_id' => $user_id, 'date' => $update_date])
		    					->order_by('slot_order', 'ASC')
		    					->order_by( 'cad_slots.created_at', 'ASC')
		    					->get('cad_slots')
		    					->result();

		    			$reverse_pending_projects = array_reverse($pending_projects);
		    			
		    			foreach ($reverse_pending_projects as $key => $value) {
		    				array_unshift($next_day_cad_dates, $pending_projects[$key]);
		    			}
			    		$total_assigned_slot = $this->db->get_where('user', ['id' => $user_id])->row()->slots;
	    				$pending_projects = array_reverse(array_slice($next_day_cad_dates, $total_assigned_slot));

	    				$final_result = array_slice($next_day_cad_dates, 0,$total_assigned_slot, false);

	    				foreach ($final_result as $key => $value) {
	    					$this->db->update('cad_slots', ['date' => $update_date, 'slot_order' => $key], ['cad_slot_id' => $value->cad_slot_id]);
	    				}

		    		}
				}


    			$update_date = date('Y-m-d', strtotime($update_date . ' +1 day'));


			}
    	}


    	$config = $this->email_config();

        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to('sjgalaxy98@gmail.com'); // change it to yours
        $this->email->subject('master');
        $this->email->message('Time - '.date('d-M H:i:s'));
        $this->email->send();
    }

    public function getdate(){
    	echo date('Y-m-d H:i:s');
    }

}