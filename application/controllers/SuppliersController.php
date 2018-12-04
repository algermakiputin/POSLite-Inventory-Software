<?php

class SuppliersController Extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
	}

	public function mail() {
		 
		$this->load->library('email');
		$this->email->from('algerzxc@gmail.com', 'Your Name');
		$this->email->to('algerapudmakiputin@gmail.com'); 
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');
		if ($this->email->send()) {
			echo "test";
		}else {
			echo $this->email->print_debugger();
		}
		// $suppliers = $this->db->order_by('id','DESC')->get('supplier')->result();
		// $mg = new Mailgun\Mailgun;
		// $mg = $mg::create('key-1a55a06248fee1734ffb5958ffbb3cf9');
		// foreach ($suppliers as $supplier) {
			 

		// 	$outOfStocks = $this->db->select("items.id, items.name, ordering_level.quantity,items.description")
		// 		->from("items")
		// 		->join("ordering_level", "ordering_level.item_id = items.id", "left")
		// 		->where('items.status', 1)
		// 		->where('supplier_id', $supplier->id)
		// 		->where('ordering_level.quantity <=', 0)
		// 		->get();
		 	 
		// 	if ($outOfStocks) {
				
		// 		$data['items'] = $outOfStocks->result();
		// 		$data['name'] = $supplier->name;
		// 		$html = $this->load->view('email/order', $data, true);
		// 		$data = [
		// 			'from' => 'algerzxc@gmail.com.com',
		// 			'to' => 'algerapudmakiputin@gmail.com',
		// 			'subject' => 'Delivery Order',
		// 			'html' => $html,
		// 			'text' => 'Hello we run out of stock, please delivery now'
		// 		];
		// 		if ($mg->messages()->send('sandbox8dbb9e90cfd640b78778d23fa420ca5d.mailgun.org', $data)) {
		// 			echo "sent";
		// 		}

		// 		die();	
				 
		// 	}


		// }


	  
		
	}
	public function index() {
		$this->load->database();
		$data['page'] = "Suppliers";
		$data['suppliers'] = $this->db->order_by('id','DESC')->get('supplier')->result();
		$data['content'] = "suppliers/index";
		$this->load->view('master',$data);
		 
	}

	public function find() {
		$this->load->database();
		$id = $this->input->post('id');
		$supplier = $this->db->where('id', $id)->get('supplier')->row();
		echo json_encode($supplier);

	}

	public function insert() {
		$this->load->database();

		$data = array(
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'contact' => $this->input->post('contact'),
				'email' =>  $this->input->post('email')
			);

		$this->db->insert('supplier',$data);
		$this->session->set_flashdata('success','Supplier added successfully');
		return redirect($_SERVER['HTTP_REFERER']);
	}

	public function update() {
		$this->load->database();

		$data = array(
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'contact' => $this->input->post('contact'),
				'email' => $this->input->post('email'),
			);

		$this->db->where('id',$this->input->post('id'))->update('supplier', $data);

		return redirect('suppliers');
	}

	public function destroy($id) {
		$this->load->database();

		$this->db->delete('supplier', array('id' => $id));

		return redirect($_SERVER['HTTP_REFERER']);
	}
}