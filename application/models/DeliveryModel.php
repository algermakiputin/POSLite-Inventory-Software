<?php 

class DeliveryModel extends CI_Model { 


	public function get_delivery_join_supplier($id) {

		return $this->db->select('delivery.*, supplier.name')
					->from('delivery')
					->join('supplier', 'supplier.id = delivery.supplier_id')
					->where('delivery.id', $id)
					->get()
					->row();
	}

	public function get_delivery_details($id) {

		return $this->db->select("delivery_details.*, items.name as product_name, SUM(delivery_details.price * delivery_details.quantities) as subTotal")
						->from('delivery_details')
						->join('items', 'items.id = delivery_details.item_id', 'BOTH')
						->where('delivery_details.delivery_id', $id)
						->group_by('delivery_details.id')
						->get()
						->result();
	}
}