<?php
$Gid=$_GET['id_jurnal'];



 $del=mysql_query("DELETE FROM datajurnal WHERE id_jurnal='$Gid'");
  
  header("location:../input.php");


?>