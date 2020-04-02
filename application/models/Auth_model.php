<?php
class Auth_model extends CI_Model
{

	public function login($data)
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
}
