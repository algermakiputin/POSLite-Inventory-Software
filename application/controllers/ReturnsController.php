<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReturnsController extends CI_Controller {

	public function __construct() {
 
      parent::__construct();  


    }

    public function insert() {
 
        $this->load->model("ReturnsModel");

    	$data = $this->input->post('data'); 
      
    	$this->db->trans_begin();

        $this->ReturnsModel->insert($data);


    	if ($this->db->trans_status() === FALSE) {
		
	        $this->db->trans_rollback();
	        echo 0;
	        return false;
		}
		 
		$this->db->trans_commit(); 
		echo 1;

    }

    public function view() {

        $data['content'] = "returns/view";
        $this->load->view('master', $data);
    }

    public function datatable() {

        $this->load->model('ReturnsModel');

        $start = $this->input->post('start');
        $limit = $this->input->post('length');
        $search = $this->input->post('search[value]'); 
        $draw = $this->input->post('draw');
        $from = $this->input->post('columns[0][search][value]') == "" ? date("Y-m-d") : $this->input->post('columns[0][search][value]');
        $to = $this->input->post('columns[1][search][value]') == "" ? date("Y-m-d") : $this->input->post('columns[1][search][value]');  
        $datasets = []; 



        $returns = $this->ReturnsModel->get($limit, $start, $from, $to);
        $count = $this->ReturnsModel->count();


        foreach ($returns as $return) {

            $datasets[] = [
                $return->date,
                $return->transaction_number,
                $return->name,
                $return->item_condition,
                $return->quantity,
                $return->reason
            ];
        }


        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => count($datasets),
            'recordsFiltered' => $count,
            'data' => $datasets
        ]);
    }

}
 