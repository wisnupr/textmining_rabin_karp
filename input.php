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
        <!-- Form -->
        <div class="col-xs-6">
        <h3>Dokumen Uji dan Pembanding</h3>
          <form action="module/upload_proses.php" enctype="multipart/form-data" method="post">
            <div class="form-group">
              <label for="file">Penulis</label>
              <input name="penulis" type="text" id="teks" class="form-control" placeholder="input Penulis" required>
            </div>
            <div class="form-group">
              <label for="jenis">Jenis Dokumen</label>
              <select class="form-control" name="jenis" id="jenis" requare>
                <option>Pilih Jenis Dokumen</option>
                <option value="uji">Uji</option>
                <option value="pembanding">Pembanding</option>
              </select>
            </div>
            <div class="form-group">
              <label for="file">Input Dokumen pdf atau doc</label>
              <input name="file" type="file" id="file" class="form-control" placeholder="input" required>
            </div>
            
            <div class="form-group">
              <input type="submit" name="submit" value="UPLOAD" class="btn btn-primary btn-form-action btn-submit btn-lg">
            </div>
          </form>
        </div>
        <!-- end Form -->
      </div>
      <div class="row">
      <div class="col-xs-12">
        <div class="panel panel-default" style="padding:10px;">
          <!-- Default panel contents -->
          <div class="panel-heading" style="margin-bottom:5px;">Data Dokumen</div>
          <table id="example" class="table table-condensed">
            <thead>
            <tr>
              <th>#</th>
              <th>Penulis</th>
              <th>Nama Dokumen</th>
              <th>Jumlah Kata</th>
              <th>Jenis Dokumen</th>
              <th>Status</th>
              <th align="center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
              // $i=1;
              $query=mysql_query("SELECT * FROM datajurnal");
              while ($r = mysql_fetch_array($query)) {
                $idj=$r['id_jurnal'];
              ?>
              
              <tr>
                <td>
                <?php if ($r['status'] == 'new'){
                ?>  
                <a href="#" class="btn btn-info btn-sm disabled">Pick</a> 
                <?php
                }elseif($r['status'] == 'analisis'){
                  ?>
                  <a href="#" class="btn btn-info btn-sm disabled">Pick</a> 
                <?php
                }else{
                  ?>
                  <form class="form" >
                  <!-- <input type="hidden" name="init" id="" value="analisis"> -->
                  <a class="btn btn-info btn-sm klik" data-id="<?php echo $idj; ?>">Pick</a> 
                  </form>
                <?php
                }
                ?>
                </td>
                <td><?= $r['penulis'];?></td>
                <td><?= $r['nm_file'];?></td>
                <td><?= $r['lengword'];?></td>
                <td><?= $r['type'];?></td>
                <td><span class="label label-default"><?= $r['status'];?></span></td>
                <td align="right">
                 <?php if ($r['status'] == 'stem' || $r['status'] == 'analisis'){
                ?>  
                <a href="#" class="btn btn btn-primary btn-sm disabled">Stemming</a> 
                <?php
                }else{
                  ?>
                  <a href="stem.php?id_jurnal=<?php echo $r['id_jurnal'];?>" class="btn btn-primary  btn-sm">Stemming</a>
                <?php
                }
                ?>
                </td>  
              </tr>
              <?php
              // $i++;
            }
            ?>
            </tbody>
          </table>
          
        </div> 
        </div>       
      </div><!--/row-->
      <div id="successmessage"></div>
      <div class="row">
      <div class="col-xs-6">
        
        <!-- <form class="fanalisis"> -->
        <div class="panel panel-default" style="padding:10px;">
        <!-- Default panel contents -->
        <div class="panel-heading" style="margin-bottom:5px;">Data Dokumen Uji</div>
        <table id="analisisu">
          <thead>

            <tr>
              <th>Nama file</th>
              <th>Jenis Dokumen</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $que=mysql_query("SELECT * FROM datajurnal WHERE status = 'analisis' and type = 'uji'");
              while ($rw = mysql_fetch_array($que)) {
          ?>
            <tr>
              <td><?php echo $rw['nm_file'];?></td>
              <td><?php echo $rw['type'];?></td>
              
            </tr>
          <?php
          $isi1=$rw['isi'];
          }
          ?>
          </tbody>
        </table>
        
        </div>
      </div>
      <div class="col-xs-6">
        <div class="panel panel-default" style="padding:10px;">
        <!-- Default panel contents -->
        <div class="panel-heading" style="margin-bottom:5px;">Data Dokumen Pembanding</div>
        <table id="analisisp">
          <thead>
              <tr>
                <th>Nama file</th>
                <th>Jenis Dokumen</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $que=mysql_query("SELECT * FROM datajurnal WHERE status = 'analisis' and type = 'pembanding'");
                while ($rwp = mysql_fetch_array($que)) {
            ?>
              <tr>
                <td><?php echo $rwp['nm_file'];?></td>
                <td><?php echo $rwp['type'];?></td>
                
              </tr>
            <?php
            $isi2=$rwp['isi'];
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-xs-12" style="margin-bottom:10px;">
      <form action="analisis.php" method="post">
        <div class="form-group">
          <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
          <div class="input-group col-xs-3">
            <div class="input-group-addon "><b>Kgram</b></div>
              <input type="text" name="kgram" class="form-control">
          </div>
        </div>
      <!-- </div> -->
          <!-- <a class="btn btn-success btn-lg btnanalisis">ANALISIS</a> -->
          
          <input type="hidden" name="duji" value="<?php echo $isi1; ?>">
          <input type="hidden" name="dpem" value="<?php echo $isi2; ?>">
          <input type="submit" name="submit" value="ANALISIS" class="btn btn-success btn-lg btnanalisis"/>
        
        </form>
        
      </div>
      <div id="views"></div>
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
        "pageLength": 100,
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
      $(".btnanalisis").click(function(str){
        var id = str;
        var data = $('.fanalisis').serialize();
        $.ajax({
          type: 'POST',
          url: "module/analisis.php?id_jurnal"+id,
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
