<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");
class UsersController extends AppController {

	public $name, $username, $account_type, $user_id;
 
	public function __construct() {
		parent::__construct();
		$this->checkLogin();
		$this->load->config('license');

		if ($this->session->userdata('account_type') != "Admin") {
			return redirect('/');
		}
		
	}
	public function register_account( ) {
		license('users');
	
		if (SITE_LIVE) 
			return redirect('users');

		$this->form_validation->set_rules('Username', 'Username', 'required|min_length[5]');
		$this->form_validation->set_rules('Password', 'Password', 'required|min_length[8]');
		$this->form_validation->set_rules('Full Name', 'full_name', 'required');
		$this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|matches[Password]');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger"> '.validation_errors() . '</div>');
			return redirect(base_url('users'));
		} 
		 
		$this->load->model('UsersModel');
		$date_created = date('Y-m-d h:i:s a');
		$username = $this->input->post('Username');
		$password = $this->input->post('Password');
		$account_type = $this->input->post('account_type');
		$full_name = $this->input->post('full_name');
		$created_by = 'admin';

		$exec = $this->UsersModel->insert_account($username,$password,$account_type,$date_created,$created_by, $full_name);
		if ($exec) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Account Created Successfully</div>');
			return redirect(base_url('users'));
		}
		
		$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps... Something Went Wrong Please Try Again.</div>' );
		return redirect(base_url('users'));
		

		 
	}

	public function delete($id){
 		if (SITE_LIVE) 
			return redirect('users');
		
		$this->load->model('UsersModel');
		$exec = $this->UsersModel->delete_account($id);
		if ($exec) {
			$this->session->set_flashdata('successMessage', '<div class="alert alert-success">Account Deleted Successsfully</div>');
			return redirect(base_url('users'));
		}
		$this->session->set_flashdata('errorMessage', '<div class="alert alert-danger">Opps... Something Went Wrong Please Try Again.</div>' );
		return redirect(base_url('users'));
	}


	public function users () {
		$this->checkLogin();
		$data['page'] = 'accounts';
		$this->load->model('UsersModel');
		$data['accountsList'] = $this->UsersModel->display_accounts();
		$data['content'] = "users/index";
		$this->load->view('master',$data);
		 
	}

	public function history() {
		$this->checkLogin();
		$data['history'] = $this->db->order_by('id','DESC')
						->select('users.account_type, users.username, history.*')
						->from('history')
						->join('users', 'users.id = history.user_id')
						->get()->result();
	 
		$data['content'] = "users/history";
		$this->load->view('master',$data);
	}

	public function edit($id) {

		$user = $this->db->where('id', $id)->get('users')->row();

		if ($user) {

			$data['user'] = $user;
			$data['content'] = "users/edit";
			return $this->load->view('master', $data);
		}

		return redirect('/');
	}

	public function checkLogin() {
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}

	public function update() {

		$this->set_data(); 
		$data = ['username' => $this->username, 'account_type' => $this->account_type, 'name' => $this->name];

		if ($this->input->post("change_password") == "on") {
			$password = $this->input->post("new_password");
			$confirm_password = $this->input->post('confirm_new_password');

			if ($password == $confirm_password) { 
				$encrypt_password = password_hash($password,PASSWORD_DEFAULT); 
				$data['password'] = $encrypt_password;
			} 
		}
 
		$this->db->where('id', $this->user_id)
				->update("users", $data);
		return redirect('users');
	}

	public function set_data() { 
		
		$this->username = $this->input->post("username");
		$this->name = $this->input->post("fullname");
		$this->account_type = $this->input->post("account_type");
		$this->user_id = $this->input->post('id');
	}

	
}