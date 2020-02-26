<?php 

class SalesDescriptionModel extends CI_Model {

	public function fetch_all($sales_id) {

		return $this->db->where('sales_id', $sales_id)
								->get('sales_description')
								->result();
	}
}