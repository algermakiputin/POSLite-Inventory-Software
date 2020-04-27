<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReturnsController extends CI_Controller {

	public function __construct() {
 
      parent::__construct();  


    }

    public function insert() {

    	$this->load->model("OrderingLevelModel");

    	$data = $this->input->post('data'); 

    	$this->db->trans_begin();

    	foreach ($data as $row) {


    		if ($row['condition'] == "good") {

    			$this->OrderingLevelModel->addStocks( $row['item_id'], $row['return_qty'] );
    		}

    		$this->db->set('quantity', 'quantity-' . $row['return_qty'], false)
    					->where('id', $row['orderline_id'])
    					->update('sales_description');

    		$this->db->insert('returns', [
    					'item_id' => $row['item_id'],
    					'name'	=> $row['name'],
    					'condition'	=> $row['condition'],
    					'quantity'	=> $row['return_qty'],
    					'sales_description_id'	=> $row['orderline_id']
    			]);
    	}


    	if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        echo 0;
	        return false;
		}
		 
		$this->db->trans_commit(); 
		echo 1;

    }

}
 