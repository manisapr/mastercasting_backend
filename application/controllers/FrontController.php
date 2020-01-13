<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FrontController extends CI_Controller
{
    // private $email_form = 'apache@mastercastingandcad.com';
    private $email_form = 'oscar@www.mastercastingandcad.com';


    function __construct()
    {
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

    public function register()
    {

        $user_proof = $this->input->post('user_proof');

        // print_r($user_proof);die;

        $client = $this->input->post('client');
        $client['ps'] = $client['password'];
        $client['password'] = md5($client['password']);
        $client['designation_id'] = 5;
        $client['name'] = ucwords($client['first_name']. ' ' .$client['last_name']);
        $client['dynamic_id'] = $this->dynamic_id();

        $username_exist = $this->db->get_where('user', ['username' => $client['username']])->result();
        if (count($username_exist) > 0) {
            echo '
				<script>
					alert("Username already exist");
					window.location.replace("'.DOMAIN.'/register/");
				</script>
				';
                return;
            // redirect('http://54.191.73.95/register/?error=true');
        }

        $email_exist = $this->db->get_where('user', ['email' => $client['email']])->result();
        if (count($email_exist) > 0) {
            echo '
				<script>
					alert("email already exist");
					window.location.replace("'.DOMAIN.'/register/");
				</script>
				';
                return;
            // redirect('http://54.191.73.95/register/?error=true');
        }


        $this->db->insert('user', $client);

        // $this->register_wp(['user_login' => $client['username'], 'user_email' => $client['email'], 'user_pass']);

        $user_id = $this->db->insert_id();

        $token = md5(uniqid($user_id, true));
        $this->db->update('user', ['api_token' => $token], ['id' => $user_id]);

        if (count($_FILES['files']['name']) > 0) {
            for ($i=0; $i<count($_FILES['files']['name']); $i++) {
                $_FILES['file']['name']     = time().'-'.$_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];
                
                // File upload configuration
                $uploadPath = 'uploads/user_proof/';
                $config['upload_path'] = $uploadPath;
                // $config['allowed_types'] = 'jpg|png|pdf|xls|csv';
                // $config['allowed_types'] = '';
                $config['allowed_types'] = '*';
                
                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                // Upload file to server
                if ($this->upload->do_upload('file')) {
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                }
            }

            // print_r($uploadData);

            foreach ($uploadData as $key) {
                $this->db->insert('user_proof', ['user_id' => $user_id, 'file_name' => $key['file_name']]);
            }
        }

        // echo "<pre>";
        // print_r($uploadData);die;

        $this->sendEmail($user_id, $uploadData, false, $user_proof);

        $this->sendNewUserEmail($client['email']);


        redirect(DOMAIN."/thank-you/?user=$user_id");
    }

    public function register_company()
    {
        $comp = $this->input->post('comp');
        $comp['designation_id'] = 7;
        $comp['dynamic_id'] = $this->dynamic_id();
        $img = [];


        $username_exist = $this->db->get_where('user', ['username' => $comp['username']])->result();
        if (count($username_exist) > 0) {
            echo '
				<script>
					alert("Username already exist");
					window.location.replace("'.DOMAIN.'/register/");
				</script>
				';
                return;
            // redirect('http://54.191.73.95/register/?error=true');
        }

        $email_exist = $this->db->get_where('user', ['email' => $comp['email']])->result();

        if (count($email_exist) > 0) {
            echo '
				<script>
					alert("User already exist");
					window.location.replace("'.DOMAIN.'/register/");
				</script>
				';
                return;
            // redirect('http://54.191.73.95/register/?error=true');
        } else {
            if ($this->input->post('optradio') == 'yes') {
                $comp_details['jbt_member'] = 1;
                $comp_details['jbt'] = $this->input->post('jbt');
            } else {
                $comp_details['jbt_member'] = 0;
                $comp_details['fed_tax'] = $this->input->post('fed_tax');
                $comp_details['resale_tax'] = $this->input->post('resale_tax');
                $img = $this->upload_file('file');
                $comp_details['resale_cert'] = $img['file_name'];
            }

            $comp['ps'] = $comp['password'];
            $comp['password'] = md5($comp['password']);
            $comp['name'] = ucwords($comp['first_name']. ' ' .$comp['last_name']);


            if($this->input->post('new_company') == 'no'){
                $comp['company_name'] = $this->db->get_where('companies', ['company_id' => $comp['company_id']])->row()->company_name;
                $comp['comp_des'] = 2;
            } else{
                $this->db->insert('companies', ['company_name' => $comp['company_name']]);
                $comp['company_id'] = $this->db->insert_id();
                $comp['comp_des'] = 1;
            }

            // // if company exist or else
            // $company = $this->db->get_where('companies', ['company_name' => $comp['company_name']])->row();

            // if(count($company) == 1){
            //     $comp['company_id'] = $company->company_id;
            // } elseif(count($company) == 0){
            // }

            // echo "<pre>";
            if($this->input->post('hear_about_us_show') && $comp['hear_about_us'] == 'Shows'){
                $comp['hear_about_us'] = $comp['hear_about_us'] . ' - ' . $this->input->post('hear_about_us_show');
            }
            // print_r($comp);die;
            // print_r($comp_details);
            $this->db->insert('user', $comp);
            $comp_details['user_id'] = $this->db->insert_id();
            $user_id = $this->db->insert_id();

            $token = md5(uniqid($user_id, true));
            $this->db->update('user', ['api_token' => $token], ['id' => $user_id]);

            $this->db->insert('company', $comp_details);
            $this->sendEmail($user_id, $img, true);
        }
        
        $this->sendNewUserEmail($comp['email']);

        redirect(DOMAIN."/thank-you/?user=$user_id");
    }

    public function upload_file($userfile)
    {
        $config['upload_path']          = './uploads/resale_certificate';
        $config['allowed_types']        = 'gif|jpg|png|pdf|xls';
        // $config['allowed_types']        = '*';
        $new_name = time().'-'.$_FILES[$userfile]['name'];
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);

        if (! $this->upload->do_upload($userfile)) {
            return $error = array('error' => $this->upload->display_errors());
        } else {
            return $this->upload->data();
        }
    }

    public function login()
    {
        $user = $this->input->post('user');
        $check = $this->db->get_where('user', ['email' => $user['email'], 'password' => md5($user['password'])])->num_rows();

        if ($check == 1) {
            redirect(DOMAIN.'/login/?logged_in=true');
        } else {
            redirect(DOMAIN.'/login/?logged_in=false');
        }
    }

    public function register_wp()
    {
        $otherdb = $this->load->database('otherdb', true);
        $query = $otherdb->get('wp_users')->result();
        var_dump($query);
    }


    public function sendEmail($user_id, $upload = [], $isComp = false, $user_proof = [])
    {
        // print_r($upload);die;
        
        // $email = 'maulik@hih7.com';
        $email = ['oscar@valenciadiamonds.com', 'Lily@valenciadiamonds.com', 'jasmine@valenciadiamonds.com', 'jacky@diamonds717.com'];
        // $email = 'webdeveloper@hih7.com';
        // $email = 'oscar@valenciadiamonds.com';
        // $email = 'sjgalaxy98@gmail.com';

        $user = $this->db->get_where('user', ['id' => $user_id])->row();

        if($isComp){
            $comp_details = $this->db->get_where('company', ['user_id' => $user_id])->row();

            if($comp_details->jbt_member == 0)
                $is_jbt_member = false;
            else
                $is_jbt_member = true;
        }

        // $message =
        ob_start(); ?>

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
                        <div class="alert alert-primary">User</div>
                        <p><?php echo $isComp ? 'Company' : 'Individual' ?></p>

                        <div class="alert alert-primary">First Name</div>
                        <p><?php echo $user->first_name ?></p>

                        <div class="alert alert-primary">Last Name</div>
                        <p><?php echo $user->last_name ?></p>

                        <div class="alert alert-primary">Email</div>
                        <p><a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a></p>

                        <div class="alert alert-primary">Phone</div>
                        <p><a href="tel:1231231231"><?php echo $user->phone ?></a></p>

                        <?php if($isComp): ?>
                        <div class="alert alert-primary">Company Name</div>
                        <p><?php echo $user->company_name ?></p>

        
                        <div class="alert alert-primary">Jbt Member</div>
                        <p><?php echo $is_jbt_member ? 'Yes' : 'No' ?></p>

                        <?php if($is_jbt_member): ?>
                        <div class="alert alert-primary">Jbt</div>
                        <p><?php echo $comp_details->jbt ?></p>
                        <?php else: ?>
                        <div class="alert alert-primary">Fed Tax</div>
                        <p><?php echo $comp_details->fed_tax ?></p>
                        <div class="alert alert-primary">Resale Tax</div>
                        <p><?php echo $comp_details->resale_tax ?></p>
                        <?php endif; ?>

                        <?php endif; ?>

                        <div class="alert alert-primary">Address</div>
                        <p><?php echo $user->address1 ?></p>

                        <div class="alert alert-primary">City</div>
                        <p><?php echo $user->city ?></p>

                        <div class="alert alert-primary">State</div>
                        <p><?php echo $user->state ?></p>

                        <div class="alert alert-primary">Zip</div>
                        <p><?php echo $user->zip ?></p>

                        <div class="alert alert-primary">Country</div>
                        <p><?php echo $user->country ?></p>
                        
                        <?php if($user->hear_about_us != NULL): ?>
                        <div class="alert alert-primary">How did you hear about us?</div>
                        <p><?php echo $user->hear_about_us ?></p>
                        <?php endif; ?>

                        <?php if(!empty($user_proof)): ?>
                        <div class="alert alert-primary">User Proof</div>
                        <p><?php echo implode(', ', $user_proof); ?></p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </body>
        </html>


        <?php
        $message = ob_get_clean();
        $config = $this->email_config();
        $this->load->library('email', $config);

        // $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject("New User Registerd");
        $this->email->message($message);
        if(!empty($upload) && !$isComp){
            foreach ($upload as $key) {
                $this->email->attach(DOMAIN.'/mastercasting_backend/uploads/user_proof/'. $key['file_name']);
            }
        } elseif(!empty($upload) && $isComp) {
                $this->email->attach(DOMAIN.'/mastercasting_backend/uploads/resale_certificate/'. $upload['file_name']);

        }
        $this->email->send();
    }


    public function permission_check($user_id)
    {
        if (!$this->session->userdata('user_id')) {
            return redirect();
        }

        $this->db->update('user', ['permission' => 1, 'ps' => null], ['id' => $user_id]);

        $email = $this->db->get_where('user', ['id' => $user_id])->row()->email;


        $this->sendUserEmail($email);
        echo '
				<script>
					alert("Permission invoked");
					window.location.replace("'.DOMAIN.'/mastercasting_backend/");
				</script>
				';
                return;
    }

    public function sendNewUserEmail($email = 'sjgalaxy98@gmail.com')
    {
        $config = $this->email_config();
        $this->load->library('email', $config);

        // $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject("Master Casting");
        $this->email->message("Welcome to mastercasting. Thank you for registration. We will get back to you soon after checking your info. Please hold on.");
        $this->email->send();
    }


    public function sendUserEmail($email = 'sjgalaxy98@gmail.com')
    {
        ob_start();
        ?>
        <p>Your account has been approved and its ready for use.</p>
        <p>Please follow this <a href="<?php echo base_url() ?>">link</a> to log in</p>
        <?php
        $html = ob_get_clean();

        $config = $this->email_config();
        $this->load->library('email', $config);

        // $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject("Master Casting");
        $this->email->message($html);
        $this->email->send();
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
}

