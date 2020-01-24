<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class StocksTransferController Extends CI_Controller {


	public function find_po() {

		$number = $this->input->post('invoice');
		$invoice = $this->db->where('transaction_number', $number)->get('sales')->row();

		if ($invoice) {

			$orderline = $this->db->where('sales_id', $invoice->id)->get('sales_description')->result();
			echo json_encode([
				'details' => $invoice,
				'orderline' => $orderline
			]);

			
		}else {
			echo "0";
		}
 

	}

	public function internal_po() {

		$data['content'] = "transfer/internal_po";
		$this->load->view('master', $data);
	}

	public function external_po() {

		$data['content'] = "transfer/external_po";
		$this->load->view('master', $data);

	}

	public function internal_po_dataTable() {
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
		$dataset = []; 
		$store_number = $this->session->userdata('store_number'); 
		$store_number = $this->session->userdata('store_number');

		$purchase_orders = $this->db->select("purchase_order.*") 
											->where('purchase_order.type', 'internal')
											->where('request', $store_number)
											->like('purchase_order.po_number', $search, 'BOTH')
											->order_by("purchase_order.id", 'DESC')
											->get('purchase_order', $limit, $start) 
											->result();

		foreach ($purchase_orders as $po) {

			$mark = "";
			$status = $po->status; 

			if ($status == "Request Item") {

				$mark = ' 
							<ul class="dropdown-menu">
                     <li>
                         <a href="' . base_url("StocksTransferController/process/$po->po_number") .'">
                             <i class="fa fa-refresh"></i> Create Delivery Note</a>
                     </li>
                     </ul>
                     '; 
            $class = "badge-warning";
			}else if ($status == "Ongoing Transfer") {

				$class = "badge-info";
			}else {

				$class = "badge-success";
			}

			$dataset[] = [$po->po_date, $po->po_number, $po->store_name, $po->requested_store_name, $po->memo, 
				"<span class='badge $class'>$status</span>"
				,
				'<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    
                    '.$mark.'
                     
                    
            </div>'];
		}

		$count = $this->db->get("purchase_order")->num_rows();
		
		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => count($purchase_orders),
			'recordsFiltered'	=> $count,
			'data' => $dataset,
			
		]);
	}

	public function external_po_dataTable() {
		$start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
		$dataset = []; 
		$store_number = $this->session->userdata('store_number'); 
		$store_number = $this->session->userdata('store_number');

		$purchase_orders = $this->db->select("purchase_order.*") 
											->where('purchase_order.type', 'external')
											->where('request', $store_number)
											->like('purchase_order.po_number', $search, 'BOTH')
											->order_by("purchase_order.id", 'DESC')
											->get('purchase_order', $limit, $start) 
											->result();

		foreach ($purchase_orders as $po) {

			$mark = "";
			$status = $po->status; 

			if ($status == "Open PO") {

				$mark = ' 
							<ul class="dropdown-menu">
                     <li>
                         <a href="' . base_url("StocksTransferController/process/$po->po_number") .'">
                             <i class="fa fa-refresh"></i> Process PO</a>
                     </li>
                     <li>
                         <a href="' . base_url("StocksTransferController/close_external_po/$po->po_number") .'">
                             <i class="fa fa-times	"></i> Close PO</a>
                     </li>
                     </ul>
                     '; 
            $class = "badge-warning";
			}else if ($status == "Closed PO") {

				$class = "badge-default";
			}else {

				$class = "badge-success";
			}

			$dataset[] = [$po->po_date, $po->po_number, $po->store_name, $po->requested_store_name, $po->memo, 
				"<span class='badge $class'>$status</span>"
				,
				'<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    
                    '.$mark.'
                     
                    
            </div>'];
		}

		$count = $this->db->get("purchase_order")->num_rows();
		
		echo json_encode([
			'draw' => $this->input->post('draw'),
			'recordsTotal' => count($purchase_orders),
			'recordsFiltered'	=> $count,
			'data' => $dataset,
			
		]);
	}

	public function process($po_number) {

		$po = $this->db->where('po_number', $po_number)->get('purchase_order')->row();
		$orderline = $this->db->where('purchase_order_id', $po->id)->get('purchase_order_line')->result();
 
		$data['po'] = $po;
		$data['orderline'] = $orderline;
		$data['content'] = "transfer/process";
		$this->load->view('master', $data);
	}

	public function process_internal_po() {

		$this->load->model("OrderingLevelModel");

		$po_number = $this->input->post('po_number'); 
		$product_id = $this->input->post('product_id[]');
		$products = $this->input->post('product[]');
		$quantity = $this->input->post('quantity[]');
		$price = $this->input->post('price[]'); 
		$note = $this->input->post('note');
		$invoice_number = $this->input->post('invoice_number');
		$data = [];
		$store_number = $this->session->userdata('store_number');
		$po_id = $this->input->post('po_id');

		$this->db->trans_begin(); 

		$this->db->insert('stocks_transfer', [
					'po_number' => $po_number,
					'note'	=> $note,
					'date'	=> get_date_time(),
					'status'	=> "For Delivery",
					'po_id' => $po_id
			]);

		$stocks_transfer_id = $this->db->insert_id();

		foreach ($product_id as $key => $id) {

			$data[] = [
				'stocks_transfer_id' => $stocks_transfer_id,
				'name'	=> $products[$key],
				'quantity' 	=> $quantity[$key],
				'price'	=> $price[$key],
				'item_id'	=> $id 

			];

		}

		$this->db->where('po_number', $po_number)->update('purchase_order', ['status' => 'Ongoing Transfer']);
		$this->OrderingLevelModel->update_stocks($data, $store_number);
		$this->db->insert_batch('stocks_transfer_line',$data);


		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		        errorMessage("Something went wrong please try agian later");
		        return redirect('transfer/internal-po');
		}
		 

		$this->db->trans_commit(); 
		success("Stock transfer is now being process successfully");
		return redirect('transfer/internal-po');
	}

	public function close_external_po($po_number) {

		$this->db->where('po_number', $po_number)->update('purchase_order', ['status' => "Closed PO"]);
		success("Internal PO has been closed successfully");

		return redirect('transfer/external-po');
	}
 

}