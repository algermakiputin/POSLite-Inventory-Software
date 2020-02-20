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
}