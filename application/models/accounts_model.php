<?php

class Accounts_model extends CI_Model {
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
		return $this->db->insert('accounts', $data);
	}

	public function display_accounts() {
		$this->load->database();
		$this->db->order_by('id','DESC');
		$sql = $this->db->get('accounts');
		return $sql->result();
	}

	public function delete_account($id) {
		$this->load->database();
		$this->db->where('id',$id);
		$del = $this->db->delete('accounts');
		return $del;
	}

	public function login($username) {
		$this->load->database();
		$sql = $this->db->where('username',$username)
						->get('accounts');
	 	return $row = $sql->row();
	}
}