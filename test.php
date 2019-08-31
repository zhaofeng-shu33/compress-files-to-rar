<?php
include_once 'rar_wrapper.php';
function test_rar(){
  // prepare the data
  $str_1 = "compress files\nto rar";
  $str_2 = 'files compress';
  $file_list = array('/tmp/test_compress_files_1.txt', '/tmp/test_compress_files_2.txt');
  file_put_contents($file_list[0], $str_1);
  file_put_contents($file_list[1], $str_2);
  // invoke the wrapper
  try{
    $file_name = rar($file_list);
  }
  catch(Exception $e){
    echo $e->getMessage() . "\n";
    die();
  }
  echo $file_name;
  // assert
  
}
test_rar();
?>
