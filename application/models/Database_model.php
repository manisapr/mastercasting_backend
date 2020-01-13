<?php  
class Database_model extends CI_Model {
	 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
    }

function can_login($username,$password)
{
//	$this->load->database(); 
	$this->db->where('password',$password);
	$this->db->where('is_deleted',0);
	$this->db->group_start();
	$this->db->where('email',$username);
	$this->db->or_where('username',$username);
	$this->db->group_end();
	
	$query= $this->db->get('user');
//	echo $this->db->last_query();die;
	//print_r($query);
	if($query->num_rows()> 0)
	{
		//print_r($query->result_array());die;
		
		$result = $query->result_array();
		$designation_id = $result[0]['designation_id'];
		$id = $result[0]['id'];
		$name =$result[0]['name'];
			$session_data = array(
				'username'  => $username,
				'user_id'   => $id,
				'name'      => $name,
				'type'  => $designation_id,
				
				);
				
				$this->session->set_userdata($session_data);
		
		//last login update
		$this->db->query("UPDATE `user` SET `last_login` = NOW() WHERE `id` = $id");
	
		return true;
	}
	else
	{
		return false;
	}
}
function insert_user($data)
{
//	$this->load->database();
	$this->db->insert('user',$data);
}
function get_data()
{
	//$this->load->database();

	$query = $this->db->select("user.id,user.name,user.email,designation.designation_name,user.permission");
	$this->db->from('user');
	$this->db->join('designation', 'designation.designation_id = user.designation_id');
	$this->db->where_not_in('user.designation_id', [5,7]);
	$this->db->where('user.is_deleted', 0);
	$query = $this->db->get();
	//select * from user
	return $query->result();

}
// get all data for designer-------------------------------------------------------------------------------------
function get_designer_data ()
{
	//$this->load->database();

	$query = $this->db->select("user.id,user.name,user.email,designation.designation_name");
	$this->db->from('user');
	$this->db->join('designation', 'designation.designation_id = user.designation_id and user.designation_id =2');
	$query = $this->db->get();
	//select * from user
	return $query->result();

}
// get all data for designer----------------------------------------------------------------------------

// get all data for casting-------------------------------------------------------------------------------
function get_casting_data ()
{
	//$this->load->database();

	$query = $this->db->select("user.id,user.name,user.email,designation.designation_name");
	$this->db->from('user');
	$this->db->join('designation', 'designation.designation_id = user.designation_id and user.designation_id =3');
	$query = $this->db->get();
	//select * from user
	return $query->result();

}
// get all data for casting------------------------------------------------------------------------------------------------

// get all data for packing-------------------------------------------------------------------------------
function get_packing_data ()
{
	//$this->load->database();

	$query = $this->db->select("user.id,user.name,user.email,designation.designation_name");
	$this->db->from('user');
	$this->db->join('designation', 'designation.designation_id = user.designation_id and user.designation_id =4');
	$query = $this->db->get();
	//select * from user
	return $query->result();

}
// get all data for packing------------------------------------------------------------------------------------------------

// get all data for manager-------------------------------------------------------------------------------
function get_manager_data ()
{
	//$this->load->database();

	$query = $this->db->select("user.id,user.name,user.email,designation.designation_name");
	$this->db->from('user');
	$this->db->join('designation', 'designation.designation_id = user.designation_id and user.designation_id =6');
	$query = $this->db->get();
	//select * from user
	return $query->result();

}
// get all data for manager------------------------------------------------------------------------------------------------

function insert_project($project_data)
{
	
//	$this->load->database();
		
	$this->db->insert('project',$project_data);
	
}
  
  function select_all_user_data()
		{
	    	$query = $this->db->get('user');
			return $query->result();	
		}
		
		 function select_all_designation_data()
		{
	    	$query = $this->db->get('designation');
			return $query->result();	
		}			
    function view_all_projects()		
		{ 
		 $query = $this->db->query("SELECT project.project_id, project.project_name, project.assign_designer, project.assign_packing, user.id, user.name, user.email,user.designation_id
FROM  `user` 
JOIN project ON user.id = project.assign_casting
OR user.id = project.assign_designer
OR user.id = project.assign_packing
OR user.id = project.asign_user");
		return $query->result();	 
		
		/* $query = $this->db->get('project');			
		return $query->result(); */
		
		}
		
		function all_project_assign_manager()
		{
			$query = $this->db->query("SELECT user.id, user.name, project.project_id, project.project_name
										FROM user
										JOIN project ON user.id = project.manager_category
										AND user.designation_id =  '6'");
			return $query->result();
		}
		
		 function select_all_projectr_data()
		{
			$this->db->where('manager_category',$this->session->userdata('user_id'));
	    	$query = $this->db->get('project');
			return $query->result();	
		}
		
		///--------------user--------------------------------------
		
		  function select_user_projectr_data()
		{
			$id=$this->session->userdata('user_id');
			$query=$this->db->query("SELECT * FROM  project WHERE  assign_casting ='" .$id. "' OR  assign_designer ='" .$id. "' OR  assign_packing = '".$id."'");
			return $query->result();	
		}  
		
	///--------------user--------------------------------------	
		
		
		/* return $this->db
     ->where('LastName', 'Svendson');
     ->where('Age', 12);
     ->group_start()
         ->where('FirstName','Tove')
         ->or_where('FirstName','Ola')
         ->or_where('Gender','M')
         ->or_where('Country','India')
     ->group_end()
     ->get('Persons')
     ->result();
		 */
		/* SELECT  `project_name` 
FROM  `project` 
WHERE  `assign_casting` =6
OR  `assign_designer` =6
OR  `assign_packing` =6
		 */
		
		
		
		
		
		
		//view all projects for admin only--------------------------------
		
		
		function select_all_projectr_data_admin()
		{
			
	    	$query = $this->db->get('project');
			return $query->result();	
			
		}
		
		
		//view all projects for admin only----------------------------------
		
		
		
		
		function projectdelete($project_id)
		{       
		       // echo $project_id;
				
				
				$this->db->query("delete from project where project_id='".$project_id."'");
		}
		
		public function edit_project_by_id($project_id)
		{
			$this->db->where('project_id', $project_id);
			$query= $this->db->get('project');
			return $query->result();
		}
		
		
		public function update_project($project_id,$project_update)
		{
					$this->db->where('project_id', $project_id);
					$this->db->update('project',$project_update);	
		}
		
		
		
		public function project_member_update($project_id,$project_member_update)
		{
			$this->db->where('project_id', $project_id);
			$this->db->update('project',$project_member_update);
		}
		
		public function select_all_manager()
		{
			
				$this->db->select('name');	
				$this->db->select('id');	
				$this->db->where('designation_id' ,'6');
				$query =  $this->db->get('user');
				/* print("<pre>");
					print_r($query);die; */
					return $query->result(); 
		}


		public function user_edit($id)
		{
			
				$this->db->select('*');	
				$this->db->where('id' ,$id);
		
				$this->db->from('user');
				$query =  $this->db->get();
				/* print("<pre>");
					print_r($query);die; */
					return $query->result_array(); 
		}
		

		public function select_by_username($user_id)
	{
		$this->db->where('id',$user_id);
		$query= $this->db->get('user');
		return $query->result();
	}
	
	public function profile_update($user_id, $data)
	{
		$email_check = $this->db->get_where('user', ['email' => $data['email'], 'id !=' => $user_id])->num_rows();

		if(!empty($email_check))
			return false;

		$user_details = $this->db->get_where('user', ['id' => $user_id])->row();

		$this->db->update('user', $data, ['id' => $user_id]);

		$otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		$query = $otherdb->get_where('wp_users', ['user_email' => $user_details->email])->row();
		$query = $otherdb->update('wp_users',['user_email' => $data['email']], ['user_email' => $user_details->email]);
		
		return true;
	}
	
	public function delete_user($user_id)
	{
		/* echo $user_id;
		die; */
		$this->db->query("delete from user where id ='".$user_id."'");
		
	}

	public function project_manager_update($project_id,$project_manager_update)
		{
			$this->db->where('project_id', $project_id);
			$this->db->update('project',$project_manager_update);
		}
	
	
	
	
	public function select_project_details($project_id)
	{
	$this->db->select('*');
	$this->db->from('project');
    $this->db->where('project_id', $project_id);
	$query =  $this->db->get();
	return $query->result();
	}
	
	
	public function insert_message($data)
	{
		$this->db->insert('communication',$data);
	}
	
	public function select_message_details($project_id)
	{
		
		
		$query = $this->db->query("select communication.com_id,communication.message ,communication.project_status,communication.uploaded_file,communication.date,user.name,user.email from 
									communication join user on communication.assign_user=user.id 
									and communication.project_id ='".$project_id."' order by communication.date desc " );
			return $query->result();
	}
	
	public function select_message_details_pag($project_id,$limit, $start)
	{
		$sql= "select communication.com_id,communication.message ,communication.project_status,communication.uploaded_file,communication.date,user.name,user.email from 
									communication join user on communication.assign_user=user.id 
									and communication.project_id ='".$project_id."' order by communication.date desc"; 
									
									$sql.=" limit ".$limit;
									if($start>0){
									$sql.=" ,".$start;
									}
									
		$query = $this->db->query($sql);
									
								return $query->result();	
							
									
									
	}
	
	
	
	public function admin_project_count()
	{
		$data = $this->db->query("SELECT `project_name` FROM project");
		 
		 
        return $data->result();

	}
	
	public function manager_project_count()
	{
		$data = $this->db->query("SELECT `project_name` FROM project where manager_category ='".$this->session->userdata('user_id')."'" );
		 
	
        return $data->result();

	}
	
	public function user_project_count()
	{
		$data = $this->db->query("SELECT `project_name` FROM project where assign_designer ='".$this->session->userdata('user_id')."' OR assign_casting='".$this->session->userdata('user_id')."' OR assign_packing = '".$this->session->userdata('user_id')."' OR asign_user = '".$this->session->userdata('user_id')."'" );
		 
		
        return $data->result();

	}
	
	public function admin_attach_count()
	{
		$data = $this->db->query("Select `uploaded_file` from communication");
		 
		
        return $data->result();

	}
	
		public function manager_attach_count()
	{
		$data = $this->db->query("Select `uploaded_file` from communication where manager_id='".$this->session->userdata('user_id')."'");
		 
		
        return $data->result();

	}
	
		public function user_attach_count()
	{
		$data = $this->db->query("Select `uploaded_file` from communication where assign_user='".$this->session->userdata('user_id')."'");
		 
		
        return $data->result();

	}
	
	public function pending_projects()
	{
		$data = $this->db->query("select communication.project_id, 
								  communication.message, communication.project_status, 
								  communication.date,project.project_name,user.name 
								  from communication join project on communication.project_id=project.project_id 
								  join user on communication.assign_user=user.id and project_status='Pending'");
		return $data->result();
	}
	
	public function pending_projects_manager()
	{
		$data = $this->db->query("select communication.project_id, 
								  communication.message, communication.project_status, 
								  communication.date,project.project_name,user.name 
								  from communication join project on communication.project_id=project.project_id 
								  join user on communication.assign_user=user.id and communication.manager_id='".$this->session->userdata('user_id')."' and project_status='Pending'");
		return $data->result();
	}
	
	
	public function pending_projects_user()
	{
		$data = $this->db->query("select communication.project_id, 
								  communication.message, communication.project_status, 
								  communication.date,project.project_name,user.name 
								  from communication join project on communication.project_id=project.project_id 
								  join user on communication.assign_user=user.id and communication.assign_user='".$this->session->userdata('user_id')."' and project_status='Pending'");
		return $data->result();
	}
	
	
	public function view_all_message()
	{
		$data = $this->db->query("select communication.com_id,communication.message ,communication.project_status,communication.date,user.name,user.email from 
								  communication join user on communication.assign_user=user.id 
								  order by communication.date desc  limit 0,10");
		 
		
        return $data->result();

	}
	
	
	public function view_manager_message()
	{
		$data = $this->db->query("select communication.com_id,communication.message ,communication.project_status,
								  communication.date,user.name,user.email from communication join user on communication.assign_user=user.id 
								  and communication.manager_id='".$this->session->userdata('user_id')."' order by communication.date desc  limit 0,10");
		 
		
        return $data->result();

	}
	
	public function view_user_message()
	{
		$data = $this->db->query("select communication.com_id,communication.message ,communication.project_status,
								  communication.date,user.name,user.email from communication join user on communication.assign_user=user.id 
								  and communication.assign_user='".$this->session->userdata('user_id')."' order by communication.date desc  limit 0,10");
		 
		
        return $data->result();

	}

	public function addshowcase($data)
	{
		$this->db->insert('resource',$data);

	}

	public function showcase_details()
	{
		return $this->db->get('resource')->result();
       

	}

	public function clent_showcase_details($id)
	{
		return $this->db->where('user_id',$id)->get('resource')->result();
       

	}

	public function per_showcase_details($id)
	{
		return $this->db->where('id',$id)->get('resource')->result();
       

	}
	public function edit_done_showcase($id,$data)
	{
		 $this->db->where('id', $id)->update('resource',$data);
          return true;

	}
	public function delete_showcase($id)
	{
		$this->db->where('id', $id);
        $this->db->delete('resource');
	}

	public function client_project_details($id,$limit,$offset)
	{
		$query=$this->db->select('t1.project_id, t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t1.asign_user', $id)
     ->limit($limit,$offset)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_all_project_details($id)
	{
		$query=$this->db->select('t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t1.asign_user', $id)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}



	public function client_pending_project_details($id,$limit,$offset)
	{
		$query=$this->db->select('t1.project_id,t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t1.asign_user', $id)
     ->where('t2.project_status','Pending')
     ->limit($limit,$offset)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_all_pending_project_details($id)
	{
		$query=$this->db->select('t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t2.project_status','Pending')
     ->where('t1.asign_user', $id)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_complete_project_details($id,$limit,$offset)
	{
		$query=$this->db->select('t1.project_id,t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t1.asign_user', $id)
     ->where('t2.project_status','Completed')
     ->limit($limit,$offset)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_all_complete_project_details($id)
	{
		$query=$this->db->select('t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t2.project_status','Completed')
     ->where('t1.asign_user', $id)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_testing_project_details($id,$limit,$offset)
	{
		$query=$this->db->select('t1.project_id,t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t1.asign_user', $id)
     ->where('t2.project_status','Testing')
     ->limit($limit,$offset)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_all_testing_project_details($id)
	{
		$query=$this->db->select('t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t2.project_status','Testing')
     ->where('t1.asign_user', $id)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_approved_project_details($id,$limit,$offset)
	{
		$query=$this->db->select('t1.project_id,t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t1.asign_user', $id)
     ->where('t2.project_status','Approved')
     ->limit($limit,$offset)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_all_approved_project_details($id)
	{
		$query=$this->db->select('t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t2.project_status','Approved')
     ->where('t1.asign_user', $id)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_rejected_project_details($id,$limit,$offset)
	{
		$query=$this->db->select('t1.project_id,t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t1.asign_user', $id)
     ->where('t2.project_status','Rejected')
     ->limit($limit,$offset)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function client_all_rejected_project_details($id)
	{
		$query=$this->db->select('t1.project_name, t2.project_status')
     ->from('project as t1')
     ->where('t2.project_status','Rejected')
     ->where('t1.asign_user', $id)
     ->join('communication as t2', 't1.project_id = t2.project_id', 'LEFT')
     ->get();
     return $query->result();
	}

	public function addsub($data)
	{
		$this->db->insert('sub_resource',$data);
		$insert_id = $this->db->insert_id();
        return $insert_id;

	}

	public function addsubpic($data1)
	{
		$this->db->insert('sub_resource_multiple',$data1);
		       

	}

	public function view_sub($id)
	{
		$query=$this->db->where('resource_id',$id)->get('sub_resource')->result();
		return $query;       

	}

	public function view_sub_details($id)
	{
		$query=$this->db->where('sub_resource_id',$id)->get('sub_resource_multiple')->result();
		return $query;       

	}

	public function trade()
	{
		$query=$this->db->get('trade')->result();
		return $query;
	}

	 public function creare_trade_done($data){
        
        $this->db->insert('trade',$data);
	 }

	 public function trade_details($id){
        
        $query=$this->db->where('id',$id)->get('trade');
        return $query->result();
	 }

	 public function trade_edit($id,$data){
        $this->db->where('id',$id)->update('trade',$data);
      
	 }

	 public function delete_trade($id){
        $this->db->where('id',$id)->delete('trade');
      
	 }

	 public function all_orders_details(){
         return $this->db->select('a.*,b.name')->from('orders as a')->join('trade as b','b.id=a.client_id')->get()->result();
      
	 }

	 public function perticular_project_details($id){
         return $this->db->where('project_id',$id)->get('project')->result();
      
	 }
	 public function worker_name($id){
         
       return $this->db->select('a.name,b.designation_name')->from('user as a')->join('designation as b','b.designation_id=a.designation_id')->where('a.id',$id)->get()->result();
	 }

	 public function project_details_by_id($id){   
       return $this->db->select('*')->where('project_id',$id)->get('project_details')->result();
	 }

	  public function project_specification($id){   
       return $this->db->select('*')->where('project_id',$id)->get('project_specification')->result();
	 }


	
}	