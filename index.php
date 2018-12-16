<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/lg.png">

    <title>Rabin Karp</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug 
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">-->

    <!-- Custom styles for this template -->
    <link href="assets/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--<script src="assets/js/ie-emulation-modes-warning.js"></script>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>

  <body>
  <?php 
  require_once __DIR__ . '/vendor/autoload.php';
  include_once 'rk.php';
  include_once 'module/koneksiDB.php';
  ?>

     <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
        <a class="navbar-brand" style="margin-top:0; " href="#">
          <img alt="Brand" src="img/logo.png" height="30">
        </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">App Pendeteksi Kesamaan Dokumen</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
            <!-- <li><a href="input.php">Data</a></li> -->
            <li><a href="analisisview.php"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Analisis Text</a></li>
            <li><a href="input.php"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Analisis Dokumen</a></li>
            <!-- <li><a href="./">Log Out <span class="sr-only">(current)</span></a></li> -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="row">
      <div class="col-xs-12">
      	<div class="panel panel-default">
		  <div class="panel-body">
		    <h3>Selamat datang di Aplikasi Pendeteksi Plagiarisme Dokumen Karya Ilmiah</h3> 
		    <hr>
		    <h4>User Guide</h4>
		    A. Analisis Plagiat text
		    <ul>
		    	<li>Pilih menu analisis text</li>
		    	<li>Input K Gram *panjang pola</li>
		    	<li>Input data teks kedalam form input uji dan form input pembanding</li>
		    	<li>Klik button "ANALISIS"</li>
		    	<li>Akan muncul hasil analisis plagiat dan nilai similaritynya</li>
		  	</ul>
		  	B. Analisis Plagiat Dokumen
		  	<ul>
			  	<li>Pilih menu analisis dokumen</li>
		  		<li>Upload dokumen yang akan di uji dan di bandingkan</li>
		  		<li>Setelah di upload klik tombol "stemming" pada file yang akan di bandingkan</li>
		  		<li>Periksa dokumen yang telah di ekstrak kemudian hapus yang tidak perlu</li>
		  		<li>Klik tombol "PROSES" jika behasil akan keluar hasil tokenizing, filtering, dan stemming</li>
		  		<li>Klik tombol "SIMPAN" untuk menyimpan data yang sudah di bersihkan</li>
		  		<li>Kemudian pilih tombol "PICK" untuk memilih yang akan di analisis</li>
		  		<li>Setelah terpilih dua dokumen kemudian input K Gram</li>
		  		<li>Klik tombol "ANALISIS"</li>
		  		<li>Akan muncul hasil analisis plagiat dan nilai similaritynya</li>
		  	</ul>
		  </div>
		</div>
      </div>
      </div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
  

    <script type="text/javascript">
    $(document).ready(function() {

     $('#example').DataTable(
      {
        "pageLength": 5,
        "info": false,
        "ordering": false,
        "lengthChange" : false
      });
     $('#analisisu').DataTable(
      {
        "paging": false,
        "searching": false,
        "info": false,
        "ordering": false,
        "lengthChange" : false
      });
     $('#analisisp').DataTable(
      {
        "paging": false,
        "searching": false,
        "info": false,
        "ordering": false,
        "lengthChange" : false
      });
    });
  
    $(document).ready(function(){
      $(".klik").click(function(){
        var data = $('.form').serialize();
        $.ajax({
          type: 'POST',
          url: "module/addanalisis.php",
          data: data,
          success: function(data) {
            successmessage = 'Data sudah di pilih';
            $("#successmessage").text(successmessage).show().fadeOut(1000);
            setTimeout(function(){  location.reload(); }, 800);
          }
        });
      });
      $(".btnanalisis").click(function(){
        var data = $('.fanalisis').serialize();
        $.ajax({
          type: 'POST',
          url: "module/analisis.php",
          data: data,
          success : function(hasil) {
            // alert(hasil);
            // console.log();
            $("#views").html(hasil);
          }
        });
      });
    });

    
      
    




    </script>
    <!--<script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script>-->
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<script src="assets/js/ie10-viewport-bug-workaround.js"></script>-->
    
  </body>
</html>
