<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class ObfuscatorController extends CI_Controller {

	public function test() {
		/*
			1. Require the Obfuscator Class
			2. Scan controller folder and loop through each files.
			3. Obfuscate files except this file.
			4. owerite exisiting file with obfuscated one.
	
		*/
		
		require APPPATH . 'classes/Obfuscator.php';
 		$folder = APPPATH . 'controllers';
		$files = scandir($folder); 
		
		foreach ($files as $file) {

			$split_name = explode('.', $file);
			
			if ( $split_name[0] !== "" && $split_name[1] !== "" && split_name[0] !== "index" && split_name[0] != "ObfuscatorController" ) {

				$filename = $folder . '/' . $split_name[0]. '.php'; // A PHP filename (without .php) that you want to obfuscate

				$sData = file_get_contents($filename);
				$sData = str_replace(array('<?php', '<?', '?>'), '', $sData); // Strip PHP open/close tags
				$sObfusationData = new Obfuscator($sData, 'Class/Code NAME');	
 
				file_put_contents($filename, '<?php ' . "\r\n" . $sObfusationData);

			}

		}
	}
}