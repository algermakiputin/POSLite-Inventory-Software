<?php
class Categories_model extends CI_Model {
	
	public function getCategories() {
		$sql = $this->db->order_by('id','DESC')->get('category'); 
		return $sql->result();
	}

	public function getName($id) {
		return $this->db->where('id', $id)->get('categories')->row()->name;
	}

}

?>