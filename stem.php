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
  require_once __DIR__ . '/vendor/autoload.php';
  require_once 'doc2txt.class.php';
  include_once 'rk.php';
  include_once 'module/koneksiDB.php'
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
            <!-- <li><a href="#"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li> -->
            <!-- <li><a href="input.php">Data</a></li> -->
            <!-- <li><a href="analisisview.php"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Analisis Text</a></li> -->
            <!-- <li><a href="input.php"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Analisis Dokumen</a></li> -->
            <!-- <li><a href="./">Log Out <span class="sr-only">(current)</span></a></li> -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
    
      <div class="row">
        <div class="col-xs-12">
        <h3>Parsing</h3>
        <form method="post">
	        <div class="panel panel-default">
    			  <div class="panel-heading">Parsing Dokumen</div>
    			  <div class="panel-body">
    			  	<div class="auto1">
              <?php
                $id=$_GET['id_jurnal'];
                 
                // Fetech user data based on id
                $result = mysql_query("SELECT * FROM datajurnal WHERE id_jurnal=$id");
                 
                while($r = mysql_fetch_array($result))
                {
                  $id_jurnal = $r['id_jurnal'];
                  $judul = $r['judul'];
                  $dokumen = $r['nm_file'];
                  $stopword = $r['stopword'];
                  // echo $dokumen;
                }
                // coba
                $info = pathinfo($dokumen);
                // $info['extension'];
                $parser = new \Smalot\PdfParser\Parser();
                              $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
                              $rabinkarp = new Rabinkarp_model();
                              $stemmer  = $stemmerFactory->createStemmer();

              if ($info['extension'] == 'pdf') {
                              $pdf    = $parser->parseFile('file/'.$dokumen);
                              // $pdf2    = $parser->parseFile('file/document2.pdf');
                               
                              $text = $pdf->getText();
                              // echo $text;
                              
              ?>
    			  	<textarea name="parsing" style="resize:none; width:100%; height:205px; border:none; margin:none;">
    			    	<?php
    			    	echo $text;
    			    	?>
    			    </textarea>
              <p><?php echo str_word_count($text);?></p>
              <?php
              }else{

                $docObj = new Doc2Txt('file/'.$dokumen);
                //$docObj = new Doc2Txt("test.doc");

                $txt = $docObj->convertToText();
                
                ?>
              <textarea name="parsing" style="resize:none; width:100%; height:100%; border:none; margin:none;">
                <?php
                echo $txt;
                ?>
              </textarea>
              <p><?php echo str_word_count($txt);?></p>
              <?php
              }
              ?>
    			  	</div>

    			  </div>
    			</div>
  			<input type="submit" name="submit" value="PROSES" class="btn btn-primary btn-lg">
			</form>
      <?php
        if (isset($_POST['submit'])) {
      ?>
        <h3>Hasil Tokenizing, filtering, Stemming</h3>
	        <div class="panel panel-default">
    			  <div class="panel-heading">Hasil Tokenizing, filtering, Stemming</div>
    			  <div class="panel-body">
    			  	<div class="auto">
      			    <p>
      			    	<?php

      			    		$ba=$_POST['parsing'];
      			    	  $token=preg_replace("/[^A-Za-z0-9]/", " ", $ba);
                        
                    $str=strtolower($token);
                    $awalnya = array(" di ", " ke ", " dari ", " dengan ", " dan ", " pada ", " itu ", " untuk ", " guna ", " yaitu ", " yakni ");
                    // $gantinya =   array("loe","kapan");
                    $sentence = str_replace($awalnya, " ", $str);
   					        $output   = $stemmer->stem($sentence);
    		    				echo $output;
      				    ?>
      			    </p>
    			  	</div>
    			  </div>
    			</div>
      <?php
        }
      ?>
      <div class="panel panel-default">
        <p><?php 
        $lengword=str_word_count($output);
        echo $lengword;?></p>
      </div>
    			<form action="module/update_data.php" method="POST">
    				<input type="hidden" name="id" value="<?= $id_jurnal;?>" />
            <input type="hidden" value="<?= $output; ?>" name="isi" />
    				<input type="hidden" value="<?= $lengword; ?>" name="lengw" />
    				<input type="hidden" value="stem" name="stem" />

    				<input type="submit" value="Simpan" name="simpan" class="btn btn-success btn-lg" />
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
