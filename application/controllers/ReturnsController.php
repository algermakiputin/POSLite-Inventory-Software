<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReturnsController extends CI_Controller {

	public function __construct() {
 
      parent::__construct();  


    }

    public function insert() {

    	$this->load->model("OrderingLevelModel");
        $this->load->model("ReturnsModel");

    	$data = $this->input->post('data'); 

      
    	$this->db->trans_begin();

    	
        $this->ReturnsModel->insert($data, $this->OrderingLevelModel);


    	if ($this->db->trans_status() === FALSE) {
		
	        $this->db->trans_rollback();
	        echo 0;
	        return false;
		}
		 
		$this->db->trans_commit(); 
		echo 1;

    }

    public function view() {


    }

}
 