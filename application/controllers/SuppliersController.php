<?php

class SuppliersController Extends CI_Controller {


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
				'contact' => $this->input->post('contact')
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
				'contact' => $this->input->post('contact')
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