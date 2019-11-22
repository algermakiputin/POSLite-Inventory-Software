<?php

class UsersModel extends CI_Model {

	public function insert_account ($username,$password,$account_type,$date_created,$created_by, $name) {
		$encrypt_password = password_hash($password,PASSWORD_DEFAULT);
		$data = array(
			'username' => $username,
			'password' => $encrypt_password,
			'account_type' => $account_type,
			'date_created' => get_date_time(),
			'created_by' => $created_by,
			'name' => $name
		);
		$data = $this->security->xss_clean($data);
		return $this->db->insert('users', $data);
	}

	public function display_accounts() {
		
		$this->db->order_by('id','DESC');
		$sql = $this->db->get('users');
		return $sql->result();
	}

	public function delete_account($id) {
		$id = $this->security->xss_clean($id);
		$this->db->where('id',$id);
		$del = $this->db->delete('users');
		return $del;
	}

	public function login($username) { 
		
		$sql = $this->db->where('username',$username)
						->get('users');

	 	return $row = $sql->row();
	}
}