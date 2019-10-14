<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PurchaseOrderController Extends CI_Controller {

	public function dataTable() {
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
		$dataset = [];

		$purchase_orders = $this->db->like('po_number', $search, 'BOTH')
											->order_by("id", 'DESC')
											->get('purchase_order', $limit, $start) 
											->result();
		foreach ($purchase_orders as $po) {
			$dataset[] = [$po->po_date, $po->po_number, $po->memo, 
				'<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    	<li>
                         <a href="' . base_url("po/view/$po->po_number") .'">
                             <i class="fa fa-plus"></i> View</a>
                     </li>
                     <li>
                         <a href="' . base_url("po/delete/$po->po_number") .'">
                             <i class="fa fa-trash"></i> Delete</a>
                     </li>
                    </ul>
            </div>'];
		}

		$count = $this->db->get("purchase_order")->num_rows();
		
		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => count($purchase_orders),
			'recordsFiltered'	=> $count,
			'data' => $dataset
		]);
	}

	public function purchase_order_list() {

		$data['content'] = "suppliers/po_list";
		$this->load->view('master', $data);
	}

	public function purchase_order() {
		$max_id = $this->db->select("MAX(id) as id")->from("purchase_order")->get()->row()->id;
		$max_id = $max_id ? $max_id : 0;
		
		$po_number = "BN" . date('Y') . '-' . ($max_id + 1);
		$data['products'] = json_encode($this->db->select('items.id as data, items.name as value, prices.capital')->join('prices', 'prices.item_id = items.id')->get('items')->result());
		$data['content'] = "po/po";
		$data['suppliers'] = $this->db->get('supplier')->result();
		$data['po_number'] = $po_number;
		$data['image_base64'] = $this->get_logo_base64();

		$this->load->view('master', $data);
	}

	public function save_po() {
		$this->db->db_debug = TRUE;
		$supplier = $this->input->post('supplier');
		$shipto = $this->input->post('shipto');
		$po_number = $this->input->post('po_number');
		$memo = $this->input->post('memo');
		$date = $this->input->post('date');
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

	public function view($id) {
		$po = $this->db->where('po_number', $id)->get('purchase_order')->row();

		// Redirect back if we cannot find data with PO Number passed
		if (!$po) return redirect("purchase-orders");
	 	
	 	$data['supplier'] = $this->db->where('id', $po->supplier_id)->get('supplier')->row();
	 	$data['orderline'] = $this->db->where('purchase_order_id', $po->id)->get("purchase_order_line")->result();
		$data['po'] = $po;
		$data['content'] = 'po/view';
		$data['total'] = 0;
		$data['image_base64'] = $this->get_logo_base64();
 
		$this->load->view('master', $data);
	}

	function get_logo_base64() {
		$path = base_url("assets/logo/bitstop.jpg");

		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);

		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}

}