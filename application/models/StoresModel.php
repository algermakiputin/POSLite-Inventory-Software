<?php
class StoresModel extends CI_Model {
	
	public function get_stores() {

		return $this->db->get('stores')->result();
	}
 
}

?>