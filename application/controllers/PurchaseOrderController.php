<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PurchaseOrderController Extends CI_Controller {

	public function dataTable() {
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
		$dataset = [];
		$type = "internal";

		$purchase_orders = $this->db->select("purchase_order.*") 
											->where('purchase_order.type', 'internal')
											->like('purchase_order.po_number', $search, 'BOTH')
											->order_by("purchase_order.id", 'DESC')
											->get('purchase_order', $limit, $start) 
											->result();

		foreach ($purchase_orders as $po) {

			$mark = "";

			if ($po->status == "Pending") {

				$mark = '<li>
                         <a href="' . base_url("PurchaseOrderController/mark_delivered/$po->po_number") .'">
                             <i class="fa fa-truck"></i> Mark as delivered</a>
                     </li>
                     <li>
                         <a href="' . base_url("PurchaseOrderController/edit/$po->po_number") .'">
                             <i class="fa fa-edit"></i> Edit</a>
                     </li>';
			}

			$dataset[] = [$po->po_date, $po->po_number, $po->store_name, $po->requested_store_name, $po->memo, $po->status,
				'<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    '.$mark.'
                    
                    	<li>
                         <a href="' . base_url("po/view/$po->po_number") .'">
                             <i class="fa fa-plus"></i> View</a>
                     </li>
                     <li>
                         <a href="' . base_url("PurchaseOrderController/destroy/$po->id") .'" class="delete-data">
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

	public function external_dataTable() {
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
		$dataset = [];
		$type = "external";

		$purchase_orders = $this->db->select("purchase_order.*") 
											->where('purchase_order.type', 'external')
											->like('purchase_order.po_number', $search, 'BOTH')
											->order_by("purchase_order.id", 'DESC')
											->get('purchase_order', $limit, $start) 
											->result();

		foreach ($purchase_orders as $po) {

			$mark = "";
			$class = "text-warning";

			if ($po->status == "Open PO") {

				$mark = '<li>
                         <a href="' . base_url("PurchaseOrderController/mark_delivered/$po->po_number") .'">
                             <i class="fa fa-truck"></i> Mark as delivered</a>
                     </li>
                     <li>
                         <a href="' . base_url("PurchaseOrderController/close_external_po/$po->po_number") .'">
                             <i class="fa fa-times"></i> Close PO</a>
                     </li>
                     <li>
                         <a href="' . base_url("PurchaseOrderController/edit/$po->po_number") .'">
                             <i class="fa fa-edit"></i> Edit</a>
                     </li>';
			}else if ($po->status == "Closed") {
				$class = "text-danger";
			}else {
				$class = "text-success";
			}

			$dataset[] = [$po->po_date, $po->po_number, $po->store_name, $po->requested_store_name, $po->memo, "<span class='$class'>$po->status</span>",
				'<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    '.$mark.'
                    
                    	<li>
                         <a href="' . base_url("po/view/$po->po_number") .'">
                             <i class="fa fa-plus"></i> View</a>
                     </li>
                     <li>
                         <a href="' . base_url("PurchaseOrderController/destroy_external_po/$po->id") .'" class="delete-data">
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

	public function mark_delivered($po_number) {

		$this->db->where('po_number', $po_number)->update('purchase_order', ['status' => 'Delivered']);
		success("PO Marked as delivered successfully");

		return redirect('purchase-orders');

	}

	public function external_po_mark_delivered($po_number) {

		$this->db->where('po_number', $po_number)->update('purchase_order', ['status' => 'Delivered']);
		success("PO Marked as delivered successfully");

		return redirect('external-po');

	}

	public function close_external_po($po_number) {

		$this->db->where('po_number', $po_number)->update('purchase_order', ['status' => 'Closed']);
		success("PO Closed Successfully");

		return redirect('purchase-orders');

	}

	public function external_po() {
		
	}

	public function edit($id) {

		$po = $this->db->where('po_number', $id)->get("purchase_order")->row();
	  
		if (!$po) return redirect('/');

		$orderline = $this->db->where('purchase_order_id', $po->id)->get('purchase_order_line')->result();

		$data['content'] = "po/edit";
		$data['po'] = $po;
		$data['orderline'] = $orderline;
		$data['suppliers'] = $this->db->get('supplier')->result();
		$data['products'] = json_encode($this->get_products());
		$data['image_base64'] = $this->get_logo_base64();
		$data['total'] = 0;

		$this->load->view('master', $data);

	}

	public function destroy($id) {

		$this->db->trans_begin();

		$this->db->where('id', $id)->delete("purchase_order");
		$this->db->where('purchase_order_id', $id)->delete('purchase_order_line');
		
		if($this->db->trans_status() === FALSE){

		   $this->db->trans_rollback(); 
		   set_error_message("Opps Something Went Wrong please try.");
		   return redirect('purchase-orders');
		}  
		
		success("Purchase Order has been deleted successfully.");
		$this->db->trans_commit();
		return redirect('purchase-orders');
	}

	public function destroy_external_po($id) {

		$this->db->trans_begin();

		$this->db->where('id', $id)->delete("purchase_order");
		$this->db->where('purchase_order_id', $id)->delete('purchase_order_line');
		
		if($this->db->trans_status() === FALSE){

		   $this->db->trans_rollback(); 
		   set_error_message("Opps Something Went Wrong please try.");
		   return redirect('external_po');
		}  
		
		success("Purchase Order has been deleted successfully.");
		$this->db->trans_commit();
		return redirect('purchase-orders');
	}

	public function purchase_order_list() {

		$data['content'] = "po/po_list";
		$this->load->view('master', $data);
	}

	public function external_po_list() {
		$data['content'] = "po/external_po_list";
		$this->load->view('master', $data);
	}

	public function purchase_order() {
		$max_id = $this->db->select("MAX(id) as id")->from("purchase_order")->get()->row()->id;
		$max_id = $max_id ? $max_id : 0;
		
		$po_number = "BN" . date('Y') . '-' . ($max_id + 1);

		$products = $this->get_products();


		$data['products'] = json_encode($products);
		$data['content'] = "po/po";
		$data['suppliers'] = $this->db->get('supplier')->result();
		$data['po_number'] = $po_number;
		$data['image_base64'] = $this->get_logo_base64();
 
		$this->load->view('master', $data);
	}

	public function newExternalPO() {

		$max_id = $this->db->select("MAX(id) as id")->from("purchase_order")->get()->row()->id;
		$max_id = $max_id ? $max_id : 0;
		
		$po_number = "EXPO" . date('Y') . '-' . ($max_id + 1);

		$products = $this->get_products();


		$data['products'] = json_encode($products);
		$data['content'] = "po/new_external_po";
		$data['suppliers'] = $this->db->get('supplier')->result();
		$data['po_number'] = $po_number;
		$data['image_base64'] = $this->get_logo_base64();
 
		$this->load->view('master', $data);

	}

	private function get_products() {

		$products = $this->db->select('items.id as data, items.name as value, prices.capital')->join('prices', 'prices.item_id = items.id')->get('items')->result();
		foreach ($products as $product) {
			$product->value = str_replace('"', '”', $product->value);
		}
		return $products;
	}



	public function save_po() {
		 
		$supplier = $this->input->post('supplier'); 
		$invoice_number = $this->input->post('invoice_number');
		$memo = $this->input->post('memo');
		$date = $this->input->post('date');
		$products = $this->input->post('product[]');
		$quantity = $this->input->post('quantity[]');
		$price = $this->input->post('price[]');
		$product_id = $this->input->post('product_id[]');
		$note = $this->input->post('note');
		$request = $this->input->post('store-selector');
		$store_number = $this->input->post('store_number');
	 	$type = $this->input->post('type');
	 	$po_number = $this->input->post('po_number');
	 	$status = "Pending";

	 	if ($type == "external") 
	 		$status = "Open PO";

		$this->db->trans_begin();


		$store_name = $this->db->where('number', $store_number)->get('stores')->row()->branch;
		$requested_store_name = $this->db->where('number', $request)->get('stores')->row()->branch;

		$this->db->insert("purchase_order", [
			'supplier_id' => $supplier,  
			'memo' => $memo,
			'po_date' => date('Y-m-d', strtotime($date)),
			'invoice_number' => $invoice_number, 
			'note' => $note,
			'store_number' => $store_number,
			'request' => $request,
			'type' => $type,
			'po_number' => $po_number,
			'store_name' => $store_name,
			'requested_store_name' => $requested_store_name,
			'status' => $status,
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
		   set_error_message("Opps Something Went Wrong please try again");
		   return redirect('supplier/po');
		} 
		
		success("Purchase order saved successfully");
		$this->db->trans_commit();
		return redirect('po/view/' . $po_number );
		 
	}

	public function update() {

		$supplier = $this->input->post('supplier');
		$shipvia = $this->input->post('shipvia');
		$po_number = $this->input->post('po_number');
		$memo = $this->input->post('memo');
		$date = $this->input->post('date');
		$products = $this->input->post('product[]');
		$quantity = $this->input->post('quantity[]');
		$price = $this->input->post('price[]');
		$product_id = $this->input->post('product_id[]');
		$note = $this->input->post('note');
		$id = $this->input->post('id');
	 	 
		$this->db->trans_begin();

		$this->db->where("po_number", $po_number)->update("purchase_order", [
			'supplier_id' => $supplier, 
			'shipvia' => $shipvia,
			'memo' => $memo,
			'po_date' => date('Y-m-d', strtotime($date)),
			'po_number' => $po_number, 
			'note' => $note
		]);
		 

		$this->db->where('purchase_order_id', $id)->delete("purchase_order_line");

		foreach ($products as $key => $product) {

			if ($product && $quantity[$key] && $price[$key] && $product_id[$key]) {

				$this->db->insert("purchase_order_line", [
					'product_id' => $product_id[$key],
					'product_name' => $products[$key],
					'quantity' => $quantity[$key],
					'price' => $price[$key],
					'purchase_order_id' => $id
				]);
			}
		}


		if($this->db->trans_status() === FALSE){

		   $this->db->trans_rollback();
		   set_error_message("Opps Something Went Wrong please try again");
		   return redirect('supplier/po');
		} 
		
		success("Purchase order saved successfully");
		$this->db->trans_commit();
		return redirect('po/view/' . $po_number );
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
		$path = base_url("assets/logo/test.png");

		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);

		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}

}