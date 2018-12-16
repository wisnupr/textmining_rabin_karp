
<?php
 
// Include Composer autoloader if not already done.
include_once 'rk.php';
include_once 'module/koneksiDB.php';


$rabinkarp = new Rabinkarp_model();


?>
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

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  <?php 
  // require_once __DIR__ . '/vendor/autoload.php';
  // include_once 'rk.php';
  ?>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
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
            <li><a href="index.php">Home</a></li>
            <!-- <li><a href="input.php">Data</a></li> -->
            <li><a href="analisisview.php">Analisis Text</a></li>
            <li><a href="input.php">Analisis Dokumen</a></li>
            <!-- <li><a href="./">Log Out <span class="sr-only">(current)</span></a></li> -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="container">

      <div class="row"><!-- row -->
        <div class="col-xs-12"><!-- header -->
          <h3>Analisis Pendeteksian</h3>
        </div><!-- /header -->
      <div class="row">
      <?php
      if (isset($_POST['submit'])){
            $start = microtime(TRUE);
            // $uji = "aku";
            $uji = $_POST['duji'];
            $banding = $_POST['dpem'];
            $gram= $_POST['kgram'];
         
            // echo $_POST['kgram'];
            $teks1White = $rabinkarp->whiteInsensitive($uji);
            $teks2White = $rabinkarp->whiteInsensitive($banding);
            $teks1Gram = $rabinkarp->kGram($teks1White, $gram);
            $teks2Gram = $rabinkarp->kGram($teks2White, $gram);
            $teks1Hash = $rabinkarp->hash($teks1Gram);
            $teks2Hash = $rabinkarp->hash($teks2Gram);
            $fingerprint = $rabinkarp->fingerprint($teks1Hash, $teks2Hash);
            // $clear_fg = array_unique($fingerprint);
            $unique = $rabinkarp->unique($fingerprint);
            $hasiluniq = $rabinkarp->fingerprint($unique, $teks1Hash);
            // $arraydata = array (0 => 1429, 1 => 1366, 2 => 1287, 3 => 1339, 4 => 1350, 5 => 1320, 6 => 1456, 7 => 1399, 8 => 1463, 9 => 1381, 10 => 1316, 11 => 1318, 12 => 1452, 13 => 1336, 14 => 1497, 15 => 1352, 16 => 1435, 17 => 1270, 18 => 1299, 19 => 1294, 20 => 1367, 21 => 1297, 22 => 1373, 23 => 1421, 24 => 1345, 25 => 1413, 26 => 1389, 27 => 1370, 28 => 1291 );
            // $teks1Hash1 = $rabinkarp->hash($teks1Gram);
            // $new_fg = $rabinkarp->fingerprint($arraydata, $teks1Hash);
            $similiarity = $rabinkarp->SimilarityCoefficient($hasiluniq, $teks1Hash, $teks2Hash);
          ?>
      <div class="col-xs-12" style="margin-bottom:10px;">
      </div>
      <div class="col-xs-6">
          <div class="panel panel-default" style="min-height: 200px;">
            <div class="panel-heading">K-Gram Uji</div>
            <div class="panel-body">
              <div style="display:block; width:100%; height:205px; overflow:auto;">
              <p>
              <?php
               foreach ($teks1Gram as $ke1) {
                 echo "[".$ke1."]";
               }
              ?>
              </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="panel panel-default" style="min-height: 200px;">
        <div class="panel-heading">K-Gram Pembanding</div>
        <div class="panel-body">
          <div style="display:block; width:100%; height:205px; overflow:auto;"><p>
          <?php
           foreach ($teks2Gram as $ke2) {
             echo "[".$ke2."]";
           }
          ?>
          </p>
          </div>
        </div>
      </div>
        </div>
      <!-- hash -->
        <div class="col-xs-6">
          <div class="panel panel-default" style="min-height: 200px;">
            <div class="panel-heading">Nilai Hash Uji</div>
            <div class="panel-body">
              <div style="display:block; width:100%; height:205px; overflow:auto;">
              <p>
              <?php
               foreach ($teks1Hash as $key1) {
                 echo "[".$key1."]";
               }
              ?>
              </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="panel panel-default" style="min-height: 200px;">
        <div class="panel-heading">Nilai Hash Pembanding</div>
        <div class="panel-body">
          <div style="display:block; width:100%; height:205px; overflow:auto;"><p>
          <?php
           foreach ($teks2Hash as $key2) {
             echo "[".$key2."]";
           }
          ?>
          </p>
          </div>
        </div>
      </div>
        </div>
      </div>
      <p>
        <?php 
        // $khas = $rabinkarp->fingerprint($has1, $has2);
        //             $lgha = count($khas);
        //             echo $lgha;
        $finish = microtime(TRUE); 
        $totaltime = $finish - $start;  
                    ?>
      </p>
            
      <div class="row">
      <div class="panel panel-default">

        <div class="panel-heading">Hasil</div>
          
        <table class="table">
          <tr>
            <th align="center">Jumlah Hash Kalimat 1</th>
            <th align="center">Jumlah Hash Kalimat 2</th>
            <th align="center">Jumlah Pola yang sama</th>
            <th align="center">Total Akses (s)</th>
            <th align="center">Similarity</th>
          </tr>
          <tr>
          
            <td align="center">
              <?php 
              echo count($teks1Hash);
              ?>
            </td>
            <td align="center">
              <?php
              echo count($teks2Hash);
              ?>
            </td>
            <td align="center">
              <?php
              echo count($hasiluniq);
              ?>
            </td>
            <td align="center">
              <?php
              echo $totaltime;
              ?>
            </td>
            <td align="center">
            <?php 

            echo $rabinkarp->rabinkarp($uji, $banding, $gram);
            }
            ?>

            </td>
          </tr>
        </table>

          </div>
        </div>
        <div class="row">
        <form method="post" action="module/endanalisis.php">
          <?php 
          // include 'koneksiDB.php';
          // $id = $_POST['init'];

          $sql="SELECT * FROM datajurnal WHERE status = 'analisis'";
          $result=mysql_query($sql);
          // Count table rows
          $count=mysql_num_rows($result);
          while($rows=mysql_fetch_array($result)){
            ?>
          <input name="id_jurnal[]" type="hidden"  value="<?php echo $rows['id_jurnal']; ?>">
          <input name="status[]" type="hidden"  value="stem">
          
          <?php
          }
          ?>
          <input name="submit" type="submit"  value="FINISH" class="btn btn-success btn-lg">
        </form>
        </div>
      </div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

