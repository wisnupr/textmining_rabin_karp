<!-- <form action="upload_proses.php" enctype="multipart/form-data" method="post">
Last name:<br /> <input type="text" name="type" value="" /><br />
class notes:<br /> <input type="file" name="file" value="" /><br />
  <input type="submit" name="submit" value="Submit Notes" />
</form> -->

<?php
require 'koneksiDB.php';

// 
if(isset($_POST['submit']))
{    
     
 $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
 // $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="../file/";
 
 // new file size in KB
 // $new_size = $file_size/1024;  
 // new file size in KB
 
 // make file name in lower case
 $new_file_name = strtolower($file);
 // make file name in lower case
 $jenis = $_POST['jenis'];
 $penulis = $_POST['penulis'];
 
 $final_file=str_replace(' ','-',$new_file_name);
 
 if(move_uploaded_file($file_loc,$folder.$final_file))
 {
  $query = mysql_query("INSERT INTO datajurnal (penulis, nm_file, type, status) VALUES ('$penulis', '$final_file', '$jenis', 'new')")or die(mysql_error());
 
  ?>
  <script>
  alert('successfully uploaded');
        window.location.href='../input.php?success';
        </script>
  <?php
 }
 else
 {
  ?>
  <script>
  alert('error while uploading file');
        window.location.href='../input.php?fail';
        </script>
  <?php
 }
}


?>

