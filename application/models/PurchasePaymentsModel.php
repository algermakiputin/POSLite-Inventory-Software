<?php

class PurchasePaymentsModel extends CI_Model {


	/*
	Table Columns
	1. id
	2. purchase_number
	3. total
	4. staff
	5. date
	6. created_at
	*/

	public function store($data) {

		return $this->db->insert('purchase_payments', $data);
	}

	public function fetch_row($purchase_number) {

		return $this->db->where('purchase_number', $purchase_number)
								->get('purchase_payments')
								->row();
	}
}