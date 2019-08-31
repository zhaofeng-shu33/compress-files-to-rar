<?php
include_once 'rar_wrapper.php';
$file_key = "userfile";
if(isset($_POST["filename"])){
   http_handle($file_key, $_POST["filename"]);
   die();
}
?>
<form action="index.php" method="post" enctype="multipart/form-data">
  rar file name:<br/>
  <input name="filename" type="text"/><br/>
  <input name="<?php echo $file_key;?>[]" type="file" /><br/>
  <input name="<?php echo $file_key;?>[]" type="file" /><br/>
  <input type="submit" value="compress files" />
</form>
