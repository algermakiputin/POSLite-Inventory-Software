<?php
class ItemController extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
 
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	
	}

	public function find() {
		$this->load->model('OrderingLevelModel');
		$this->load->model('PriceModel');
		$code = $this->input->post('code');
		$item = $this->db->where('barcode', $code)->get('items')->row();
		
		if ($item) {
			$quantity = (int)$this->OrderingLevelModel->getQuantity($item->id)->quantity;
			$price = $this->db->where('item_id', $item->id)->get('prices')->row()->price;
			echo json_encode([
					'name' => $item->name,
					'price' => '₱' . $price,
					'quantity' => $quantity,
					'id' => $item->id
				]) ;

			return;
		}

		return;
	}

	public function items () {
		$this->load->model('ItemModel');
		$this->load->model('PriceModel');
		$this->load->model('OrderingLevelModel');
		$this->load->model('categories_model');

		$data['items'] = $this->ItemModel->itemList();
		$data['total'] = number_format($this->ItemModel->total()->total,2);

		$data['page'] = 'inventory';
		$data['price'] = $this->PriceModel;
		$data['categoryModel'] = $this->categories_model;
		$data['orderingLevel'] = $this->OrderingLevelModel;
		$data['content'] = "items/index";
		$this->load->view('master', $data);

	}

	public function outOfStocks() {
 	 
 		$data['content'] = "items/stockout";
 		$data['items'] = noStocks()->result();
		$this->load->view('master', $data);
	}

	public function data() {
		$this->load->model('OrderingLevelModel');
		$this->load->model('PriceModel');

		$orderingLevel = $this->OrderingLevelModel;
		$price = $this->PriceModel;
		$start = $this->input->post('start');

		$limit = $this->input->post('length');

		$search = $this->input->post('search[value]'); 
		$items = $this->dataFilter($search, $start, $limit);
		$datasets = [];

		foreach ($items as $item) {
			$quantity = (int)$orderingLevel->getQuantity($item->id)->quantity;
			if (!$quantity)
				continue;

			$price = $this->db->where('item_id', $item->id)->get('prices')->row()->price;
			
			$datasets[] = [
					$item->id,
					ucwords($item->name),
					ucfirst($item->description),
					$quantity,
					'₱'. number_format($price,2)
				];			

		}

		$count = count($datasets);
 
		echo json_encode([
				'draw' => $this->input->post('draw'),
				'recordsTotal' => $count,
				'recordsFiltered' => $count,
				'data' => $datasets
			]);
	}

	public function dataFilter($search, $start, $limit) {

		$this->db->limit($limit, $start);
		if ($search != "") {
			return $this->db->where('status', 1)
						->like('name',$search, 'BOTH')
						->get('items')
		 
						->result();
		} 
		
		return $this->db->where('status', 1)
						->get('items')
						->result();
	}

	public function new() {
		$this->load->database();
		$this->load->model('categories_model'); 

		$data['category'] = $this->db->where('active',1)->get('categories')->result();
		$data['suppliers'] = $this->db->get('supplier')->result();
		$data['page'] = 'new_item';
		$data['content'] = "items/new";  
		$this->load->view('master', $data);
	}

	public function generateBarcode() { 
		
		$code = substr(uniqid(), 0, 7);
		$codeExist = $this->db->where('barcode', $code)->get('items')->row();
		while ($codeExist) {
			$code = substr(uniqid(), 0, 7);
		}
		return $code;
	}

	public function insert() {
		$name = $this->input->post('name');
		$category = $this->input->post('category');
		$description = $this->input->post('description');
		$supplier_id = $this->input->post('supplier');
		$barcode = $this->input->post('barcode');
		$price = $this->input->post('price'); 

		$this->form_validation->set_rules('name', 'Item Name', 'required|max_length[100]');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required|max_length[150]');
		$this->form_validation->set_rules('barcode', 'Barcode', 'required');
		$this->form_validation->set_rules('supplier', 'Supplier', 'required');
		$this->form_validation->set_rules('price', 'Price', 'required|max_length[500000]');  
		$this->form_validation->set_rules('reorder', 'Price', 'required|max_length[500000]');

		if ( $this->form_validation->run() ) {
			$this->load->model('PriceModel');
			$quantity = 0;

			$this->load->model('ItemModel');
			$this->load->model('OrderingLevelModel');
			$this->load->model('HistoryModel');
			$data = array(
				'name' => $name,
				'category_id' => $category,
				'description' => $description, 
				'supplier_id' => $supplier_id,
				'status' => 1,
				'barcode' => $barcode,  
				'reorder_level' => $this->input->post('reorder')
			);

			$this->db->insert('items', $data);
			$item_id = $this->db->insert_id();
			
			$this->HistoryModel->insert('Register new item: ' . $name);
			$this->PriceModel->insert($price, $item_id);
			$this->OrderingLevelModel->insert($item_id);
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">New Item Has Been Added</div>'); 
			return redirect(base_url('items'));
		}

		$this->session->set_flashdata('errorMessage', 
				'<div class="alert alert-success">'.validation_errors().'</div>'); 
		return redirect(base_url('items'));

	}

	public function delete($id){

		$this->load->model('ItemModel');
		$this->load->model('HistoryModel');
		$item = $this->ItemModel->item_info($id);
		
		if ($this->ItemModel->deleteItem($id)) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Item Deleted</div>');
			$this->HistoryModel->insert('Delete Item: ' . $item->name);
			return redirect(base_url('items'));
		}
		
		$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps Something Went Wrong</div>');
		return redirect(base_url('items'));
		
	}

	public function stock_in($id) {
		
		$this->load->model('ItemModel');
		$this->load->model('PriceModel');
		$this->load->model('OrderingLevelModel');
		$this->load->model('categories_model');

		$data['item_info'] = $this->ItemModel->item_info(urldecode($id));
		$data['item_id'] = $id;
		$data['price'] = $this->PriceModel;
		$data['orderingLevel'] = $this->OrderingLevelModel;
		$data['categoryModel'] = $this->categories_model;
		$data['content'] = "items/stockin";
		$this->load->view('master', $data);
	}

	public function add_stocks() {
	
		$itemID = $this->input->post('item_id');
		$itemName = $this->input->post('item_name');
		$stocks = $this->input->post('stocks');

		if (SITE_LIVE) {
			$this->form_validation->set_rules('stocks','Stocks','required|integer|max_length[500]');


			if($this->form_validation->run() === FALSE) {
				$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">' .validation_errors() . '</div>');
				return redirect(base_url("items/stock-in/$itemID"));
			}
		}

		$this->load->model('HistoryModel'); 
		$this->load->model('OrderingLevelModel');

		$update = $this->OrderingLevelModel->addStocks($itemID,$stocks);
		$this->HistoryModel->insert('Stock In: ' . $stocks . ' - ' . $itemName);
		if ($update) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-info">Stocks Added</div> ');
			return redirect(base_url('items'));
			
		}

		$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps Something Went Wrong Please Try Again</div> ');
		return redirect(base_url('items'));
		
		 
	}

	public function edit($id) {

		$this->load->model('PriceModel');
		$this->load->model('ItemModel');
		$data['item'] = $this->db->where('id', $id)->get('items')->row();
		$data['price'] = $this->PriceModel;
		$data['categories'] = $this->db->where('active',1)->get('categories')->result();

		$data['content'] = "items/edit";
		$this->load->view('master', $data);

	}

	public function update() {
		$this->load->model('ItemModel');
		$this->form_validation->set_rules('name', 'Item Name', 'required|max_length[100]');
		$this->form_validation->set_rules('category', 'Category', 'required|max_length[150]');
		$this->form_validation->set_rules('description', 'Description', 'required|max_length[150]');
		$this->form_validation->set_rules('price', 'Price', 'required|max_length[500000]');
		$this->form_validation->set_rules('reorder', 'Re Order Level', 'required|max_length[500000]');
		$this->form_validation->set_rules('id', 'required'); 
 
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opss Something Went Wrong Updating The Item. Please Try Again.</div>');
				return redirect(base_url('items'));
		} 

		$this->load->model('ItemModel');
		$this->load->model('PriceModel');
		$this->load->model('HistoryModel');
		$this->load->model('categories_model');
 		$updated_name = $this->input->post('name');
		$updated_category = $this->input->post('category');
		$updated_desc = strtolower($this->input->post('description'));
		$updated_price = $this->input->post('price'); 
		$id = $this->input->post('id');
		$item = $this->db->where('id', $id)->get('items')->row();
		$currentPrice = $this->PriceModel->getPrice($id);
		$reorder = $this->input->post('reorder');

		$price_id = $this->PriceModel->update($updated_price, $id);
		$update = $this->ItemModel->update_item($id,$updated_name,$updated_category,$updated_desc,$price_id, $reorder);

		if ($update) {
			
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Item Updated</div>');
			
			if ($item->name != $updated_name)
				$this->HistoryModel->insert('Change Item Name: ' . $item->name . ' to ' . $updated_name);
			 
			if ($item->description != $updated_desc)
				$this->HistoryModel->insert('Change '.$item->name.' Description: ' . $item->description . ' to ' . $updated_desc);
			if ($currentPrice != $updated_price) 
					$this->HistoryModel->insert('Change '.$item->name.' Price: ' . $currentPrice . ' to ' . $updated_price);
				if ($item->category_id != $updated_category) 
					$this->HistoryModel->insert('Change '.$item->name.' Category: ' . $this->categories_model->getName($item->category_id) . ' to ' . $this->categories_model->getName($updated_category));

			return redirect(base_url('items'));
		}
	 
		 		
	}

}