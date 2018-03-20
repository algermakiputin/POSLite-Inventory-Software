<?php 
class Login_con extends CI_Controller {

	public function login() {
		$data['page_name'] = "Login";
		$this->load->view('header',$data);
		$this->load->view('login');
		$this->load->view('footer');
	}

	public function login_validation() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$this->form_validation->set_rules('username','Username', 'required');
		$this->form_validation->set_rules('password','Password', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">' . validation_errors() . '</div>');
			redirect(base_url('login'));
		}else {
			$this->load->model('accounts_model');
			$verify_login = $this->accounts_model->login($username);
			if ($verify_login) {
				$hash_password = $verify_login->password;
				$hash = password_verify($password,$hash_password);
				if ($hash) {
					$userdata = array( 
						'id' => "$verify_login->id",
						'username' => "$verify_login->username",
						'log_in' => true,
						'account_type' => "$verify_login->account_type"
						);
					$this->session->set_userdata($userdata);
					$this->session->set_flashdata('successMessage','<div class="alert alert-success">Login Successfully, Welcome '.$this->session->userdata['username'].'</div>');
					if ($this->session->userdata('account_type') == "Cashier") {
						redirect(base_url('pos'));
					}else if ($this->session->userdata('account_type') == "Admin") {
						redirect(base_url('inventory'));
					}else if ($this->session->userdata('account_type') == "Clerk") {
						redirect(base_url('inventory'));
					}
				}else {
					$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Incorrect Login Name Or Password</div>');
				redirect(base_url('login'));
				}
			}else {
				$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Incorrect Login Name Or Password</div>');
				redirect(base_url('login'));
			}
		}
	}
}

?>