<?php

class HistoryModel extends CI_Model {
	public function insert($action) {
		$data = array(
				'user_id' => $this->session->userdata('id'),
				'action' => $action
			);
		$this->db->insert('history', $data);
	}
}