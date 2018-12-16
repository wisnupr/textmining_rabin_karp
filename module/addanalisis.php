<?php 
include 'koneksiDB.php';
$id = $_POST['init'];


	mysql_query("UPDATE datajurnal SET status = 'analisis' WHERE id_jurnal = '$id'");


 

?>