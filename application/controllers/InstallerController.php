<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class InstallerController extends CI_Controller {

	public $mysql;
	public $dbExist;
	public $force = 0;

	public function install() {
	 	$this->load->view('template/header');
	 	$this->load->view('installer/index');
	 	$this->load->view('template/footer'); 
	 	$this->import();
	 	return redirect('login');
		 
	}

	public function import() {

		$this->mysql = new mysqli('localhost', 'root', '');
		$this->dbExist = "SHOW DATABASES LIKE 'poslite'";
		if ($this->mysql->query($this->dbExist)->num_rows === 0) {
			$sqlFile = file_get_contents(base_url("assets/poslite.sql"));
			return $this->mysql->multi_query($sqlFile);
		}

		return;
		
	}

	 
} 