<?php 

$file =  sys_get_temp_dir() .  "/ci_session" . $_COOKIE['ci_session'];

$content = file_get_contents($file);

if ( $content ) {
	$explode = explode(';', $content);

	if ( count($explode) > 2) {
		
		if (strpos($explode[3], "1")) { 

			$id = str_replace('"', "", trim(substr($explode[1], 7)));
			$username = str_replace('"', "", trim(substr($explode[2], 13)));
	 		
	 		echo $username;
		}
 
	}else {

		echo "Not login";
	}

}