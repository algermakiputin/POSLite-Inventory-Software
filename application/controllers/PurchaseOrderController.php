<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class PurchaseOrderController extends CI_Controller {

	public function index() {
        $data['page'] = "Purchase Order"; 
		$data['content'] = "purchase/index";
		$this->load->view('master',$data);
    }

    public function new() {
        $supplier_id = $this->input->get('supplier_id');
        
        $itemsToReOrder = $this->db->select('items.*, ordering_level.quantity')
                                    ->from('items')
                                    ->join('ordering_level', 'ordering_level.item_id = items.id')
                                    ->where('items.supplier_id', $supplier_id)
                                    ->where('items.reorderingLevel > ordering_level.quantity')
                                    ->get()
                                    ->result();

        $data['page'] = "Purchase Order"; 
		$data['content'] = "purchase/new";
        $data['itemsToReOrder'] = $itemsToReOrder;
        $data['suppliers'] = $this->db->get('supplier')->result();
        $data['supplier_id'] = $supplier_id;
		$this->load->view('master',$data);
    }

}