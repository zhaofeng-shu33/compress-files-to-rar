<?php
	function random_string($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
		  $randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
    function execute_external_program($cmd_string){
      $output = array();
      $return_val;
      exec($cmd_string, $output, $return_val); 
      if($return_val != 0){
        $err_msg = join("\n", $output);
        throw new Exception($cmd_string . "\n" . $err_msg);
      }
    }

    // wrapper to call external unrar library
    // we assume rar is on the system path
    // @params $file_list: Array (name => tmp_name)
    // @returns String if return_file_path=true; byte archive object otherwise
    function rar($file_list, $return_file_path=true){
      $file_name = '/tmp/' . random_string() . '.rar';
      $cmd_string = 'rar a ' . $file_name;
      foreach($file_list as $i){
        $cmd_string .= ' ' . $i;
      }
      execute_external_program($cmd_string);
      $cmd_string = 'rar rn ' . $file_name;
      foreach($file_list as $k => $v){
        $cmd_string .= ' ' . trim($v, "/") . ' ' . $k;
      }
	  execute_external_program($cmd_string);
      if($return_file_path){
        return $file_name;
      }
      else{
        // read the file
        $handle = fopen($file_name, 'r');
        $contents = fread($handle, filesize($file_name));
        fclose($handle);
        return $contents;
      }
    }
    // read input files from http form post, get the filename from POST['filename'] 
    /*
	When uploading multiple files, the $_FILES[key] variable is created in the form:

	Array
	(
		[name] => Array
		    (
		        [0] => foo.txt
		        [1] => bar.txt
		    )
		[tmp_name] => Array
		    (
		        [0] => /tmp/phpYzdqkD
		        [1] => /tmp/phpeEwEWG
		    )
	)
    */ 
    // and write the necessary header and data
    // this function should not fail, err code is 1
    function http_handle($file_key, $output_name){
      $file_list = array();   
      $php_file_list = $_FILES[$file_key];  
	  $file_count = count($php_file_list['name']);

	  if($file_count == 0){
		error_handling("no file is uploaded");
      }
      for($i = 0; $i < $file_count; $i++){
        $file_list[$php_file_list['name'][$i]] = $php_file_list['tmp_name'][$i];
      }
      try{
	    $raw_contents = rar($file_list, false);
      }
	  catch(Exception $e){
		error_handling("compress files fails"); 
	  }
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="' . $output_name . '"');
      echo $raw_contents;
    }

    function error_handling($err_message){
      header('Content-Type: text/html');
      echo $err_message;
      die();
    }
 
    function debug_helper($var_to_dump){
	  $debug_info = var_export($var_to_dump, true);
      file_put_contents('debug.txt', $debug_info);
    }
?>
