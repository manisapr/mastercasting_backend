<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('temp');
	}


	public function upload($filename, $tmp_name){
		$this->load->library('aws3');	
		$image_data['file_name'] = $this->aws3->sendFile('castingandcad', $filename, $tmp_name);	
        if($image_data['file_name'] == '')
        	return false;
        else
        	return $image_data['file_name'];
	}


	public function krajee_cad_upload() {

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
            if ($tmpFilePath != ""){
                //Setup our new file path
                
                //Upload the file into the new path
                if($newFileUrl = $this->upload($fileName, $tmpFilePath)) {
                    // $this->db->insert('project_files_temp', ['file_name' => $fileName, 'dynamic_id' => $dynamic_id, 'user_id' => $user_id, 'type' => 'cad']);

                    $project_files_id = 1;
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
}
