<?php
class Categories_model extends CI_Model {
	public function getCategories() {
		$this->load->database();
		$sql = $this->db->order_by('id','DESC')->get('category');
		$this->db->close();
		return $sql->result();
	}

	public function getCategoriesName(){
		$this->load->database();
		$sql = $this->db->select('category')
						->get('category');
		return $sql->result();
	}

	public function deleteCategory($id) {
		$this->load->database();
		$sql = $this->db->where('id',$id)
					->delete('category');
		return $sql;
	}
}

?>