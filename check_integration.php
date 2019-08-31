<?php
function check_integration(){
  $str_1 = file_get_contents('index.php');
  $str_2 = file_get_contents('test.php');
  $rar_arch = rar_open('a.rar');
  $entries = $rar_arch->getEntries();
  assert(count($entries) == 2);
  assert($entries[0]->getName() == 'index.php');  
  assert($entries[1]->getName() == 'test.php');
  $str_1_1 = fread($entries[0]->getStream(), 8192);
  $str_2_2 = fread($entries[1]->getStream(), 8192);
  assert($str_1 == $str_1_1);
  assert($str_2 == $str_2);  
}
?>
