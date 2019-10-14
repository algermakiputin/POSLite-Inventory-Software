<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SuppliersController Extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
	}

	public function mail() {

		$suppliers = $this->db->order_by('id','DESC')->get('supplier')->result();
	 	echo $this->sendEmailToSupplier($suppliers);
		
	}

	public function purchase_order() {
		$max_id = $this->db->select("MAX(id) as id")->from("purchase_order")->get()->row()->id || 0;
		$po_number = "BN" . date('Y') . '-' . ($max_id + 1);
		$data['products'] = json_encode($this->db->select('items.id as data, items.name as value, prices.capital')->join('prices', 'prices.item_id = items.id')->get('items')->result());
		$data['content'] = "suppliers/po";
		$data['suppliers'] = $this->db->get('supplier')->result();
		$data['po_number'] = $po_number;
		$this->load->view('master', $data);
	}

	public function sendEmailToSupplier($suppliers) {

		foreach ($suppliers as $supplier) {

			$outOfStocks = $this->db->select("items.id, items.name, ordering_level.quantity,items.description")
				->from("items")
				->join("ordering_level", "ordering_level.item_id = items.id", "left")
				->where('items.status', 1)
				->where('supplier_id', $supplier->id)
				->where('ordering_level.quantity <=', 0)
				->get();
		 	 
			if ($outOfStocks) {
				
				$data['items'] = $outOfStocks->result();
				$data['name'] = $supplier->name;
				$html = $this->load->view('email/order', $data, true);
				$this->load->library('email');
				$this->email->from('algerzxc@gmail.com', 'POS Sales and Inventory System Email');
				$this->email->to($supplier->email); 
				$this->email->subject('Re order stocks');
				$this->email->message($html);
				$this->email->set_mailtype('html');
				if (!$this->email->send()) 
					return 0;	 
			}
		}

		return 1;
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
				'email' =>  $this->input->post('email'),
				'company' =>  $this->input->post('company'),
				'province' =>  $this->input->post('province'),
				'city' =>  $this->input->post('city'),
				'country' =>  $this->input->post('country'),
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
				'company' => $this->input->post('company'),
				'province' => $this->input->post('province'),
				'city' => $this->input->post('city'),
				'country' => $this->input->post('country'),
			);

		$this->db->where('id',$this->input->post('id'))->update('supplier', $data);

		return redirect('suppliers');
	}

	public function destroy($id) {
	 
		$this->db->where('id', $id)->delete('supplier');
		if ($this->db->error()['code'] === 1451) {
			$this->session->set_flashdata('error', 'Cannot delete this supplier. There is an item associated with this supplier.');
		}

		return redirect('suppliers');
	}

	public function save_po() {
		$this->db->db_debug = TRUE;
		$supplier = $this->input->post('supplier');
		$shipto = $this->input->post('shipto');
		$po_number = $this->input->post('po_number');
		$memo = $this->input->post('memo');
		$date = $this->input->post('po_date');
		$products = $this->input->post('product[]');
		$quantity = $this->input->post('quantity[]');
		$price = $this->input->post('price[]');
		$product_id = $this->input->post('product_id[]');
	 
		$this->db->trans_begin();

		$this->db->insert("purchase_order", [
			'supplier_id' => $supplier, 
			'shipto' => $shipto,
			'memo' => $memo,
			'po_date' => date('Y-m-d', strtotime($date)),
			'po_number' => $po_number, 
		]);
		
		$po_id = $this->db->insert_id();

		foreach ($products as $key => $product) {

			if ($product && $quantity[$key] && $price[$key] && $product_id[$key]) {

				$this->db->insert("purchase_order_line", [
					'product_id' => $product_id[$key],
					'product_name' => $products[$key],
					'quantity' => $quantity[$key],
					'price' => $price[$key],
					'purchase_order_id' => $po_id
				]);
			}
		}


		if($this->db->trans_status() === FALSE){

		   $this->db->trans_rollback();
		   die();
		   set_error_message("Opps Something Went Wrong please try again");
		   return redirect('supplier/po');
		} 
		
		success("Purchase order saved successfully");
		$this->db->trans_commit();
		return redirect('supplier/po');
		 
	}
}