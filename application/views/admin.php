
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>SIMLPPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
	<style type="text/css">
	@font-face {
	  font-family: 'Cabin';
	  font-style: normal;
	  font-weight: 400;
	  src: local('Cabin Regular'), local('Cabin-Regular'), url(<?php echo base_url(); ?>aset/font/satu.woff) format('woff');
	}
	@font-face {
	  font-family: 'Cabin';
	  font-style: normal;
	  font-weight: 700;
	  src: local('Cabin Bold'), local('Cabin-Bold'), url(<?php echo base_url(); ?>aset/font/dua.woff) format('woff');
	}
	@font-face {
	  font-family: 'Lobster';
	  font-style: normal;
	  font-weight: 400;
	  src: local('Lobster'), url(<?php echo base_url(); ?>aset/font/tiga.woff) format('woff');
	}	
	
	</style>
    <link rel="stylesheet" href="<?php echo base_url(); ?>aset/css/bootstrap.css" media="screen">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../bower_components/bootstrap/assets/js/html5shiv.js"></script>
      <script src="../bower_components/bootstrap/assets/js/respond.min.js"></script>
    <![endif]-->
  

    <script src="<?php echo base_url(); ?>aset/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootswatch.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/jquery.chained.js"></script>
  <body style="">
    <div class="navbar navbar-inverse navbar-fixed-top" style="background-color: #c80505">
      <div class="container">
        <div class="navbar-header"  >
          <span class="navbar-brand"><strong style="font-family: 'Futura XBlk BT'; margin-left: 200px; ">Sistem Informasi Manajemen Penelitian dan Pengabdian Kepada Masyarakat</strong></span>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main" >
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        
      </div>
    </div>

	<?php 
	$q_instansi	= $this->db->query("SELECT * FROM tr_instansi LIMIT 1")->row();
	?>
    <div class="container">
	
	<br><br><br><br><br>

	<div class="container-fluid" style="margin-top: 30px">
	

      <div class="row-fluid">
		<div style="width: 400px; margin: 0 auto">
			<div class="well well-sm">
				<img src="..\aset\img\UNIVERSITASTEKNOKRAT.png"  style="display: inline; float: left; margin-right: 20px; width: 80px; height: 80px">
				<h3 style="margin: 20px 0 0.4em 0; font-size: 16px; color: #FF0000; font-weight: bold; font-family: 'Futura XBlk BT' ;	">Universitas Teknokrat Indonesia</h3>
				<div style="color: #000; font-size: 13px" class="clearfix"><?php echo $q_instansi->alamat; ?></div>
			 </div>
		</div>


		

		<div class="navbar-header"  >
			



		</div>

		
		<div class="well" style="width: 40%; margin: 0 auto">

			<div class="row">
				<div class="col-md-6" style="text-align: center;">
					<a href="<?= base_url('index.php/penelitian')?>">
						Peneltian
					</a>
				</div>
				<div class="col-md-6" style="text-align: center;">
					<a href="<?= base_url('index.php/pkm')?>">
						PKM
					</a>
				</div>
			</div>


		</div><!--/span-->
      </div><!--/row-->

    </div><!--/.fluid-container-->
    <br />
	<center style="margin-top: -15px;">&copy; Raushan Fikri<br>
	</center>
	
	<script type="text/javascript">
	$(document).ready(function(){
		$(" #alert" ).fadeOut(6000);
	});
	</script>
	  
    </div>
  
</body></html>

