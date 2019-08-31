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
    // read input files from http form post 
    // and write the necessary header and data
    function http_handle(){
      $file_list = array();
      foreach($_FILES as $file){
          $file_list.push($file['tmp_name']);
      }
    }
?>
