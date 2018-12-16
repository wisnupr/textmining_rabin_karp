<?php 
include 'koneksiDB.php';
$id = $_POST['id_jurnal'];
$count=count($id);
if($_POST['submit']){
for($i=0;$i<$count;$i++){
mysql_query("UPDATE datajurnal SET status = 'stem' WHERE id_jurnal = '$id[$i]'");
}
?>
  <script>
  alert('Terima kasih telah melakukan analisis');
        window.location.href='../input.php?success';
        </script>
  <?php
}
?>
	
