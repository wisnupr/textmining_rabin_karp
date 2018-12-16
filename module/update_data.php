<?php
require 'koneksiDB.php';
  
if(isset($_POST['simpan'])){

    // ambil data dari formulir
    $id=$_POST['id'];
  $isi=$_POST['isi'];
  $lengword=$_POST['lengw'];
  $status=$_POST['stem'];

    // buat query update
    $sql = "UPDATE datajurnal SET isi='$isi', lengword='$lengword', status='$status' WHERE id_jurnal=$id";
    $query = mysql_query($sql);

    // apakah query update berhasil?
    if( $query ) {
        // kalau berhasil alihkan ke halaman list-siswa.php
        header('Location: ../input.php');
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }


} else {
    die("Akses dilarang...");
}

?>
?>