<?php 

class DeliveriesController extends CI_Controller 

{

	public function __construct() {
		parent::__construct();
	 
	}

	public function new() {
		$this->load->database();
		$this->load->model('PriceModel');
	 
		$data['page'] = "New Delivery";
		$data['suppliers'] = $this->db->get('supplier')->result();
 		$data['content'] = "deliveries/new";
		$this->load->view('master',$data);
		 
	}


	public function insert() {
	 
		$this->load->database();

		$data = array(
			'supplier_id' => $this->input->post('supplier_id'),
			'expiry_date' => date('Y-m-d', strtotime($this->input->post('expiry_date')))
			);

		$this->db->insert('delivery',$data);
		
		$delivery_id = $this->db->insert_id();

		if ($delivery_id) {
			$data = array(
				'item' => $this->input->post('item_name'),
				'price' => $this->input->post('price'),
				'quantity' => $this->input->post('quantity'),
				'delivery_id' => $delivery_id
			);
			$this->db->insert('delivery_details', $data);
			$this->session->set_flashdata('success', 'Delivery submitted successfully');
			
			return redirect('new-delivery');
		}
	}

	public function index() {
		$this->load->database();
		
		$dataSet = [];
		$deliveries = $this->db->get('delivery')->result();

		foreach ($deliveries as $delivery) {

			$delivery_details = $this->db->where('delivery_id', $delivery->id)->get('delivery_details')->row();
			if ($delivery_details) {
				$dataSet[] = [
					'supplier_name' => $this->db->where('id', $delivery->supplier_id)->get('supplier')->row()->name,
					'item' => $delivery_details->item,
					'price' => $delivery_details->price,
					'quantity' => $delivery_details->quantity,
					'expiry_date' => $delivery->expiry_date,
					'id' => $delivery->id
				];
			}
		}

	  

		$data['page'] = "Deliveries"; 
 		$data['dataSet'] = $dataSet;
 		$data['content'] = "deliveries/index";
		$this->load->view('master',$data);
		 
	}

	public function destroy($id) {
		$this->db->where('delivery_id', $id)->delete('delivery_details');
		$this->db->where('id', $id)->delete('delivery');
		$this->session->set_flashdata('success', "Delivery deleted successfully");
		return redirect(deliveries);
	}

}