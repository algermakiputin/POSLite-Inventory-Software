<?php

class UsersModel extends CI_Model {

	public function insert_account ($username,$password,$account_type,$date_created,$created_by) {
		$encrypt_password = password_hash($password,PASSWORD_DEFAULT);
		$data = array(
			'username' => "$username",
			'password' => "$encrypt_password",
			'account_type' => "$account_type",
			'date_created' => "$date_created",
			'created_by' => "$created_by"
			);
		$this->load->database();
		return $this->db->insert('users', $data);
	}

	public function display_accounts() {
		
		$this->db->order_by('id','DESC');
		$sql = $this->db->get('users');
		return $sql->result();
	}

	public function delete_account($id) {
	
		$this->db->where('id',$id);
		$del = $this->db->delete('users');
		return $del;
	}

	public function login($username) {
		$this->load->database();
		$sql = $this->db->where('username',$username)
						->get('users');
	 	return $row = $sql->row();
	}
}