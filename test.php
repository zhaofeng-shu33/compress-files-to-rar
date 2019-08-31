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
  // assert
  // install and enable rar archiving for your php
  // see https://www.php.net/manual/en/book.rar.php
  $rar_arch = rar_open($file_name);
  $entries = $rar_arch->getEntries();
  assert(count($entries) == 2);
  assert($entries[0]->getName() == trim($file_list[0], '/'));  
  assert($entries[1]->getName() == trim($file_list[1],'/'));
  $str_1_1 = fread($entries[0]->getStream(), 8192);
  $str_2_2 = fread($entries[1]->getStream(), 8192);
  assert($str_1 == $str_1_1);
  assert($str_2 == $str_2);
}
test_rar();
?>
