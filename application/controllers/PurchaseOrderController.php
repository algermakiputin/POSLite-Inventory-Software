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

    public function store() {  
        $purchase = array(
            'supplier_id' => $this->input->post('supplier_id'),
            'status' => $this->input->post('status'),
            'eta' => $this->input->post('eta'),
        );

        $this->db->insert('purchase', $purchase);
        $purchase_id = $this->db->insert_id();
        $product_id = $this->input->post('product_id');
        $price = $this->input->post('price');
        $quantity = $this->input->post('quantity');
        $remarks = $this->input->post('remarks'); 
        $purchaseLineItems = [];
        foreach( $product_id as $key => $id ) {
            $purchaseLineItems[] = array(
                'item_id' => $id,
                'price' => $price[$key],
                'quantity' => $quantity[$key],
                'remarks' => $remarks[$key],
                'purchase_id' => $purchase_id,
                'received' => 0
            );
        } 
        $this->db->insert_batch('purchase_order_line_item', $purchaseLineItems);
    }

    public function datatable() {
        $start = $this->input->post('start');
		$limit = $this->input->post('length');
		$search = $this->input->post('search[value]'); 
        $draw = $this->input->post('draw');
        $count = $this->datatableQuery()->num_rows();
        $result = $this->datatableQuery()->result();
        $dataset = [];
        $badges = [
            'Pending' => 'warning',
            'Open Order' => 'primary',
            'Received' => 'info',
            'Complete' => 'success'
        ];

        foreach ($result as $row) { 
            $badgeClass = $badges[$row->status];
            $dataset[] = [
                substr($row->created_date, 0, 10),
                $row->supplier_name,
                $row->eta,
                $row->total,
                "<span class='badge badge-$badgeClass'>$row->status</span>",
                '
				<div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                    <ul class="dropdown-menu"> 
                        <li>
                            <a href="'. base_url("PurchaseOrderController/view/" . $row->id) .'"><i class="fa fa-eye"></i> View</a> 
                        </li> 
                        <li>
                            <a href="'. base_url("PurchaseOrderController/edit/" . $row->id) .'"><i class="fa fa-edit"></i> Edit</a> 
                        </li> 
                    '. $admin .'
                    </ul>
                </div> 
				'
            ];
        }

        echo json_encode([
			'draw' => $draw,
			'recordsTotal' => $count,
			'recordsFiltered' => $count,
			'data' => $dataset
		]);
    }


    public function datatableQuery() {
        return $this->db->select('purchase.*, SUM(purchase_order_line_item.quantity * purchase_order_line_item.price) as total, supplier.name as supplier_name')
                    ->from('purchase')
                    ->join('purchase_order_line_item', 'purchase_order_line_item.purchase_id = purchase.id', 'BOTH')
                    ->join('supplier', 'supplier.id = purchase.supplier_id')
                    ->group_by('purchase.id')
                    ->get();
     
    }

    public function edit($id) {
        return '';
    }
}