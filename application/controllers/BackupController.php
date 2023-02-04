<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."controllers/AppController.php");
class BackupController extends AppController {

	public function index() {
		
		$data['content'] = "backup/index";
		$data['backups'] = $this->db->get('backup')->result();
		$this->load->view('master', $data);
	}
	public function dump() { 
	 	$filename = './backup/backup'.date('Y-m-d-h-i-s').'.txt';
	 	
		$this->db->insert("backup", ['id' => null, 'filename' => $filename, 'date_time' => get_date_time()]);
		$this->backup($filename);
		$this->session->set_flashdata('success', "Backup successfully");
		return redirect('backups');
	}

	public function delete($id) {
		$this->db->where('id', $id)->delete('backup');
		return redirect('backups');
	}

	public function backup($filename){
	    // Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$prefs = array(    // Array of tables to backup.
		        'ignore'        => array(),                     // List of tables to omit from the backup
		        'format'        => 'txt',                       // gzip, zip, txt
		        'filename'      => 'mybackup.sql',              // File name - NEEDED ONLY WITH ZIP FILES
		        'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
		        'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
		        'newline'       => "\n"                         // Newline character used in backup file
		);

		$backup = $this->dbutil->backup($prefs);
 
		$encrypted_backup = $this->encryption->encrypt($backup); 
		
		$handle = fopen($filename, 'w') or die('Cannot open file:  '.$my_file);
		fwrite($handle, $encrypted_backup);
		fclose($handle);  

	}

	public function import() {

		$file = $_FILES['file'];
		$sql = file_get_contents($file['tmp_name']);
 
		if (!$sql) return redirect('/');

		$sql = $this->encryption->decrypt($sql);  
		$rows = explode(");", $sql); 
		$queries = array_filter($rows, function ($row) {
			return strpos($row, "# ") ? false : true;
		}); 
		 
		$this->db->trans_start();
 		$this->empty_all(); 
		
		foreach ($queries as $key => $query) { 
			if ( strpos($query, "INSERT INTO") ) { 
				$this->db->query(trim($query) . ")");
			}
		}  
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', "Error restoring backup");
			return redirect('backups');
		}

		$this->session->set_flashdata('success', "Backup restored successfully");
		return redirect('backups');
	}

	function empty_all()
	{
	  $query = $this->db->query("SHOW TABLES");
	  $name = $this->db->database; 

	  foreach ($query->result_array() as $row)
	  {
	    $table = $row['Tables_in_' . $name];
	    $this->db->query("TRUNCATE " . $table);
	    $this->db->query("ALTER TABLE ".$table." AUTO_INCREMENT = 1");
	  }

	  $this->output->set_output("Database emptyed");
	}
}