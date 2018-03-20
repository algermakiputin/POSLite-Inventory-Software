<?php

class Database extends CI_Model {
	public function itemList () {
		$this->load->database();
		$sql = $this->db->order_by('id','DESC')->get('items');
		$result = $sql->result();
		$this->db->close();
		// $tableAttr = array(
		// 	'table_open' => '<table class="table">'
		// 	);
		// $item_table = $this->table->set_heading('id','Name','Category','Description', 'Date/Time Added','Created By', 'Quantity', 'Price');
		// $item_table = $this->table->set_template($tableAttr);
		// $item_table = $this->table->generate($sql);

		return $result;
	}

	public function getDateTime() {
		date_default_timezone_set('Asia/Manila');
		$datestring = '%Y-%m-%d %h:%i:%s %a';
		$time = time();
		return mdate($datestring, $time);
	}

	public function insertCategory ($categoryName, $creator) {
		$this->load->database();
		$this->load->model('database');
		$creator = 'admin';
		$date_time = $this->getDateTime();

		$data = array(
			'date_time' => "$date_time",
			'category' => "$categoryName",
			'creator' => "$creator"
			);
		$sql = $this->db->insert('category', $data);
		if ($sql) {
			$this->session->set_flashdata('successMessage',  '<br><div class="alert alert-success">New Category Has Been Added</div>');
			$this->db->close();
			redirect(base_url('categories'));
		}
	}
}