<?php
class Ajax_model extends CI_Model {
	public function item_info($itemName) {
		$this->load->database();
		$sql = $this->db->where('name', $itemName)->get('items');
		return $sql->row();
	}
}

?>


