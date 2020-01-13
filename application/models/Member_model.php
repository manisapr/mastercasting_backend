<?php  
class Member_model extends CI_Model {


	function __construct(){
        parent::__construct();
		$this->load->database();
    }

    public function get_user_deatils($user_id){
    	return $this->db->get_where('user', ['id' => $user_id])->row();
    }

    public function get_all_permissions(){
    	return $this->db->get('permissions')->result();
    }

    public function get_user_permissions($user_id){
    	return $this->db->select('*')->from('user_permission')->join('permissions', 'user_permission.permission_id = permissions.permission_id')->where(['user_permission.user_id' => $user_id])->get()->result();
    }

    public function insert_permission($data){
    	$permission_count = $this->db->get_where('user_permission', ['user_id' => $data['user_id'], 'permission_id' => $data['permission_id']])->num_rows();
		if($permission_count == 0)
			$this->db->insert('user_permission', $data);
		else
			$this->db->update('user_permission', ['level' => $data['level'], 'updated_at' => $data['updated_at']], ['user_id' => $data['user_id'], 'permission_id' => $data['permission_id']]);
    }

    public function get_all_members(){
        return $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where('is_deleted', 0)->where_not_in('user.designation_id', [5,7])->get('user')->result();
    } 

    public function get_all_manager(){
        return $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where('is_deleted', 0)->where(['user.designation_id' => 6])->get('user')->result();
    } 

    public function get_all_cad(){
        return $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where('is_deleted', 0)->where(['user.designation_id' => 9])->get('user')->result();
    }

    public function get_all_sales_rep(){
        return $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where('is_deleted', 0)->where(['user.designation_id' => 8])->get('user')->result();
    }

    public function get_representative($value='')
    {
        return $this->db->select('*')->join('designation', 'user.designation_id = designation.designation_id')->where_in('user.designation_id' , [1, 6, 8])->get('user')->result();
    }


}
