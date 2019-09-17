<?php 

class BackupController extends CI_Controller {

	public function test() {
		echo "test";
	}
	public function dump() {

		$this->db->insert("backup", ['id' => null]);
		$this->backup();
	}

	public function backup($fileName='db_backup.zip'){
	    // Load the DB utility class
	    $this->load->dbutil(); 
	    // Backup your entire database and assign it to a variable
	    $backup =& $this->dbutil->backup(); 
	    // Load the file helper and write the file to your server
	    $this->load->helper('file');

	    write_file(FCPATH.'/downloads/'.$fileName, $backup);

	    // Load the download helper and send the file to your desktop
	    $this->load->helper('download');
	    force_download($fileName, $backup);
	}
}