<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DatabaseController extends CI_Controller {

	public function sync() {

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: POST");
		$queries = $this->input->post('queries');

		$this->db->trans_begin();
		
		foreach ($queries as $query) {

			$this->db->query($query['query']);
		}

		if ($this->db->trans_status() === FALSE)	{
		   
		   $this->db->trans_rollback();
		   echo 0;
		   return;
		}
		 
		$this->db->trans_commit();
		echo 1;
		return;
	}

	public function test_connection() {

   	return true;
   
   }
}