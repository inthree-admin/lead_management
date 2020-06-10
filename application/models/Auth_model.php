<?php
class Auth_model extends CI_Model
{

	public function login($data)
	{
		$this->db->select('*');
		$this->db->from('tbl_lead_users'); 
		$this->db->where('lmu_status', 1); 
		$this->db->where('lmu_username', $data['username']);
		$this->db->where('lmu_password', $data['password']);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			$result = $query->row_array(); 
			if ($data['password'] == $result['lmu_password']) {
				return $result = $query->row_array();
			}
		}
	}

	public function login_old($data)
	{
		$this->db->select('u.id,u.username,u.role,u.password,lp.service,u.profile_pic,u.firstname as owner_name');
		$this->db->from('users u');
		$this->db->join('lp_details lp', 'lp.ci_id = u.id', 'left');
		$this->db->where('u.role !=', '3');
		$this->db->where('u.username', $data['username']);
		$this->db->or_where('u.mobile_no', $data['username']);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			$result = $query->row_array();
			$validPassword = password_verify($data['password'], $result['password']);
			if ($validPassword) {
				return $result = $query->row_array();
			}
		}
	}

	public function insert_new_user($ins_arr){
		$this->db->insert('tbl_lead_users', $ins_arr);
        return $this->db->insert_id();	 
	}

	public function update_user($up_arr, $id)
    {
        $this->db->where('lm_id', $id);
        return $this->db->update('tbl_lead_users', $up_arr);
    }


	public function check_already_exist($condition=array()){
		$this->db->select('lmu_email');
		$this->db->from('tbl_lead_users'); 
		$this->db->where('lmu_status',1);
		if(isset($condition['lmu_email']) and !empty($condition['lmu_email']))
			$this->db->where('lmu_email',$condition['lmu_email']);
		if(isset($condition['lmu_username']) and !empty($condition['lmu_username']))
			$this->db->where('lmu_username',$condition['lmu_username']);
		$query = $this->db->get();
		if($query->num_rows() == 0) return true;  
		else return false; 	 
	}

	public function get_user_details($data)
	{
		$this->db->select('*');
		$this->db->from('tbl_lead_users'); 
		$this->db->where('lmu_username', $data['username']);
		$query = $this->db->get();
		return  $query->row_array(); 
	}

}
