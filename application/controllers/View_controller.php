<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_controller extends CI_Controller {

	function __construct() {
		parent::__construct();
		//$this->load->helper(form);
		$this->load->model("database_model");
		$this->load->library('email');
		$this->load->library('pagination');
		$this->load->helper("url");
		// $this->load->controller("Master_controllers");
	}
	
	// public function index()
	// {
	// 	$this->load->view('login');
	// }


	public function get(){
		$this->load->model('projectmodel');
		$a = $this->projectmodel->get_client_address(9135);


		echo "<pre>"; //print new object
		print_r($a->address1);
	}
	
	

	


}