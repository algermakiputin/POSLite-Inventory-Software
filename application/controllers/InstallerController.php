<?php 

class InstallerController extends CI_Controller {

	public $mysql;
	public $dbExist;
	public $force = 0;

	public function install() {
	 	$this->load->view('template/header');
	 	$this->load->view('installer/index');
	 	$this->load->view('template/footer');

		// die();
	 // 	$this->import();

		 
	}

	public function import() {

		$this->mysql = new mysqli('localhost', 'root', '');
		$this->dbExist = "SHOW DATABASES LIKE 'test1'";
		if ($this->mysql->query($this->dbExist)->num_rows === 0) {
			$sqlFile = file_get_contents(base_url("assets/sais.sql"));
			return $this->mysql->multi_query($sqlFile);
		}
		
	}

	 
} 