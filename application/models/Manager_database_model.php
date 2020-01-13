<?php  
class Manager_database_model extends CI_Model {
	 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
    }

function can_login($username,$password)
{
//	$this->load->database(); 
	$this->db->where('email',$username);
	$this->db->where('password',$password);
	$query= $this->db->get('user');
//	echo $this->db->last_query();die;
	//print_r($query);
	if($query->num_rows()> 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
}