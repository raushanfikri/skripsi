<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <head>
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
	<link rel="stylesheet" href="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.css" />
	<link href="<?php echo base_url();?>aset/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" /> 
  	<link href="<?php echo base_url();?>aset/select2/css/select2.min.css" rel="stylesheet" type="text/css" /> 
  	<link href="<?php echo base_url();?>aset/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" /> 
  
	<script src="<?php echo base_url(); ?>aset/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>aset/js/bootswatch.js"></script>
    <script src="<?php echo base_url(); ?>aset/select2/js/select2.full.min.js"></script>
	<script src="<?php echo base_url(); ?>aset/datatables/jquery.dataTables.js"></script>
	<script src="<?php echo base_url(); ?>aset/datatables/dataTables.bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.js"></script>
	<script type="text/javascript">
	// <![CDATA[
	$(document).ready(function () {
		$(function () {
			$( "#kode_surat" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('index.php/pkm/get_klasifikasi'); ?>",
						data: { kode: $("#kode_surat").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		
		$(function () {
			$( "#dari" ).autocomplete({
				source: function(request, response) {
					$.ajax({ 
						url: "<?php echo site_url('index.php/pkm/get_instansi_lain'); ?>",
						data: { kode: $("#dari").val()},
						dataType: "json",
						type: "POST",
						success: function(data){
							response(data);
						}    
					});
				},
			});
		});
		
		
		$(function() {
			$( "#tgl_surat" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy-mm-dd'
			});
		});
	});
	// ]]>
	</script>
	</head>
	
  <body style="">
  	<div class="navbar navbar-inverse navbar-fixed-top" style="background-color: #c80505;z-index: 5">
  		<div class="container">

  			<div class="navbar-collapse collapse" id="navbar-main">
  				<ul class="nav navbar-nav">
  					<li><a href="<?php echo base_url(); ?>index.php/pkm"><i class="icon-home icon-white"> </i>
  							Beranda</a></li>

  					<!-- <?php
			if ($this->session->userdata('admin_level') == "Dosen") {
			?>
			<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-file icon-white"> </i> Penelitian  <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/dosenpublikasi"> Pemakalah Forum Ilmiah</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/dosenhki"> Hak Kekayaan Intelektual (HKI)</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/dosenbuku"> Buku Ajar / Teks</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/dosenjurnal"> Jurnal</a></li>\
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/dosenseminar"> Seminar</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/dosenpenelitian"> Penelitian</a></li>
               
              </ul>
            </li>
			
			<?php 
			}
			?> -->

  					<?php
			$level = strtolower($this->session->userdata('admin_level'));
			if ($level="admin") {
			?>



  					<li class="dropdown">
  						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i
  								class="icon-th-list icon-white"> </i> Data Master <span class="caret"></span></a>
  						<ul class="dropdown-menu" aria-labelledby="themes">
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/dosen">Data Dosen</a>
  							</li>
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/fakultas">Data
  									Fakultas</a></li>
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/jurusan">Data
  									Jurusan</a></li>

  						</ul>

  					<li class="dropdown">
  						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i
  								class="icon-file icon-white"> </i> Admin PKM <span class="caret"></span></a>
  						<ul class="dropdown-menu" aria-labelledby="themes">
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/pengabdian">
  									Pengabdian</a></li>
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/pengabdianpublikasi">
  									PKM - Pemakalah Forum Ilmiah</a></li>
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/pengabdianhki"> PKM - Hak
  									Kekayaan Intelektual (HKI)</a></li>
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/pengabdianbuku"> PKM - Buku
  									Ajar / Teks</a></li>
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/pengabdianjurnal"> PKM -
  									Artikel Jurnal</a></li>
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/pengabdianseminar"> PKM -
  									Artikel Prosiding</a></li>
  							<!-- <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/penelitian_pkm"> PKM - Penelitian</a></li> -->
  						</ul>
  					</li>


  					<li class="dropdown">
  						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-print icon-white">
  							</i> Laporan Pengabdian<span class="caret"></span></a>
  						<ul class="dropdown-menu" aria-labelledby="themes">
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/cetaklaporan"> Cetak Laporan</a></li>
  							<!-- <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/pengguna">Instansi Pengguna</a></li>
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/manage_admin">Manajemen User</a></li> -->
  						</ul>
  					</li>
					  <?php 
			}
			?>
  				</ul>

  				<ul class="nav navbar-nav navbar-right">
  					<li class="dropdown">
  						<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i
  								class="icon-user icon-white"></i> <?= $this->session->userdata('admin_nama') ?> <span
  								class="caret"></span></a>
  						<ul class="dropdown-menu" aria-labelledby="themes">
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/passwod">Ubah
  									Password</a></li>
  							<li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/pkm/logout">Logout</a></li>
  						</ul>
  					</li>
  				</ul>

  			</div>
  		</div>
  	</div>


  	<?php 
	$q_instansi	= $this->db->query("SELECT * FROM tr_instansi LIMIT 1")->row();
	echo $this->session->userdata('admin_level');
	?>
  	<div class="container">

  		<div class="page-header" id="banner">
  			<div class="row">
  				<div class="" style="padding: 15px 15px 0 15px;">
  					<div class="well well-sm">
  						<img src="..\aset\img\UNIVERSITASTEKNOKRAT.png"
  							style="display: inline; float: left; margin-right: 20px; width: 100px; height: 100px">
  						<h2
  							style="margin: 15px 0 10px 0; color: #000; font-family: 'Futura XBlk BT'; color:#FF0000; ">
  							<?php echo $q_instansi->nama; ?></h2>
  						<div style="color: #000; font-size: 16px; font-family: Tahoma" class="clearfix">
  							<b><?php echo $q_instansi->alamat; ?></b></div>
  					</div>
  				</div>
  			</div>
  		</div>


  		<?php $this->load->view('pkm/'.$page); ?>

  		<div class="span12 well well-sm">
  			<h4 style="font-weight: bold">&copy; Copyright By Raushan FIkri</h4>
  			<h6>&copy; 2019. Universitas Teknokrat Indonesia</h6>
  		</div>

  	</div>


  </body>

  </html>
