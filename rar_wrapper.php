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
    // wrapper to call external unrar library
    // we assume rar is on the system path
    // @params $file_list: Array
    // @returns String if return_file_path=true; byte archive object otherwise
    function rar($file_list, $return_file_path=true){
      $file_name = '/tmp/' . random_string() . '.rar';
      $cmd_string = 'rar a ' . $file_name;
      for($i = 0; $i < count($file_list); $i++){
        $cmd_string .= ' ' . $file_list[$i];
      }
      $output = array();
      $return_val;
      exec($cmd_string, $output, $return_val); 
      if($return_val != 0){
        $err_msg = join("\n", $output);
        throw new Exception($cmd_string . "\n" . $err_msg);
      }
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
?>
