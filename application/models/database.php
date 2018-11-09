<?php

class Database extends CI_Model {

	public function getDateTime() {
		date_default_timezone_set('Asia/Manila');
		$datestring = '%Y-%m-%d %h:%i:%s %a';
		$time = time();
		return mdate($datestring, $time);
	}

	public function insertCategory ($categoryName) {
		$this->load->database();
		$this->load->model('database'); 
		$date_time = $this->getDateTime();

		$data = array( 
			'name' => "$categoryName"
			);
		$sql = $this->db->insert('categories', $data);
		if ($sql) {
			$this->session->set_flashdata('successMessage',  '<br><div class="alert alert-success">New Category Has Been Added</div>');
			$this->db->close();
			redirect(base_url('categories'));
		}
	}
}