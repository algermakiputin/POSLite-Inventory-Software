<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CustomersModel extends CI_Model {

	public function find_by_name( $name ) {

		return $this->db->like("name", $name, 'BOTH')
							->get('customers')
							->result();

	}
}