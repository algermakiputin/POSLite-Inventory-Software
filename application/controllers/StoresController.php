<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class StoresController extends CI_Controller {


	public function index() {

		$data['stores'] = $this->db->get('stores')->result();
		$data['content'] = "stores/index";
		$this->load->view('master', $data);

	}

	public function edit($id) {

		$store = $this->db->where('id', $id)->get('stores')->row();

		if (!$store)
			return redirect('stores');

		$data['store'] = $store;
		$data['content'] = 'stores/edit';
		$this->load->view('master', $data);

	}

	public function update() {

		$id = $this->input->post('id');
		$branch = $this->input->post('name');
		$location = $this->input->post('location');

		$this->db->where('id', $id)
					->update('stores', [
							'branch'	=> $branch,
							'location'	=> $location
						]); 

		success('Store updated successfully');

		return redirect('stores');
	}
}