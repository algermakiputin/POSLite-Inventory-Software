<?php

class UsersModel extends CI_Model {

	public $users;

	public function insert_account ($username,$password,$account_type,$date_created,$created_by, $name, $store) {
		$encrypt_password = password_hash($password,PASSWORD_DEFAULT);
		$data = array(
			'username' => $username,
			'password' => $encrypt_password,
			'account_type' => $account_type,
			'date_created' => get_date_time(),
			'created_by' => $created_by,
			'name' => $name,
			'store_number' => $store
		);

		$data = $this->security->xss_clean($data);
		return $this->db->insert('users', $data);
	}

	public function display_accounts() {
		 
		$this->users = $this->db->select('users.*, stores.branch')
										->order_by('users.id','DESC')
										->join('stores', 'stores.number = users.store_number') 
										->get('users')
										->result();
		
		return $this->users;
	}  

	public function find($id) {

		return $this->db->select('users.*, stores.id as store_id, stores.branch')
							->join('stores', 'stores.id = users.store_id')
							->where('users.id', $id)
							->get('users')
							->row(); 
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