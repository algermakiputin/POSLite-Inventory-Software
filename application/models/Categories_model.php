<?php
class Categories_model extends CI_Model {
	
	public function getCategories() {
		return $this->db->get('categories')->result(); 
	}

	public function getName($id) {
		return $this->db->where('id', $id)->get('categories')->row()->name ?? 'uncategorized';
	}

	

}

?>